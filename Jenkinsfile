pipeline {
    // Agent specified as none @ root of pipeline agent gets specified inside stages
    agent none
    
    // Git Repo Details
    environment {
        REPO = "bamtech-wordpress-child"
        GITORG = "JellyfishGroup/"
        GIT = "https://api.github.com/repos/"
        PULL = "git@github.com"
        GCR = "gcr.io/jellyfish-development-167809/"
        NAME = "bamtech"
        WORDPRESS = "wordpress"
        REGION = "us-east-1"
        UATCLUSTER = "ecsUatCluster"
        PRODCLUSTER = "ecsProdCluster"
        UAT = "uat"
        PROD = "prod"
        TIMEOUT = "1200"
        
        // Images that do not usually get built..
         NGINX = "nginx"
         VARNISH = "varnish"
        
    }

    options {
        skipDefaultCheckout()   
    }

    stages {
        stage('Build') {

            // Build stage agent selector
            agent { 
                node {
                    label 'container_builder'
                    customWorkspace '/var/jenkins_home/shared/docker_ctb'
                }
            }

            // Build step use jenkins master credentials
            steps {

                // Jenkins credentials stored on master 
                // StringBinding used as API token
                // FileBinding used as auth script and service key
                withCredentials([
                                [$class: 'StringBinding', credentialsId: 'TOKEN', variable: 'API_TOKEN'],
                                [$class: 'FileBinding', credentialsId: 'DEPLOY_KEY', variable: 'key'],
                                [$class: 'FileBinding', credentialsId: 'AUTH', variable: 'run'],
                                [$class: 'FileBinding', credentialsId: 'TAGGER', variable: 'tagger']]) {

                    // Build step grab release TAG and build/push images with new tag ID
                    // Then run cleanup on agents
                    // send slack notification that build steps has started:
                    slackSend channel: '#deploy', color: 'good', message: "Project ${NAME} has started building images > (<${env.RUN_DISPLAY_URL}|Open>) for details"
                
                    script {
                        sh "sudo cp ${env.key} jelly.json;sudo cp ${env.run} auth.sh;sudo cp ${env.tagger} tagger.sh"
                        sh "sudo chmod +x auth.sh; sudo chown jenkins: auth.sh; sudo chown jenkins:  jelly.json; ./auth.sh;sudo chmod +x tagger.sh; sudo chown jenkins: tagger.sh"
                        sh "curl -sS -H 'Authorization: token  ${API_TOKEN}' ${GIT}${GITORG}${REPO}/releases | jq  -r '.[].tag_name'| head -1 > tags"
                        def TAG=readFile('tags')
                        sh "git clone ${PULL}:${GITORG}${REPO}.git --depth 1 -b $TAG"
                        
                        // build Wordpress
                        sh "cd ${REPO}; docker build -f DockerfileWP . -t ${GCR}${REPO}-ecs-${WORDPRESS}:$TAG" 
                        sh "gcloud docker -- push ${GCR}${REPO}-ecs-${WORDPRESS}; cd ../"
                        sh "./tagger.sh ${GCR} ${REPO} ${WORDPRESS} $TAG"
                        sh "docker images -q |xargs docker rmi -f"
                        
                        // Images that do not usually get built..
                        //* build Nginx
                        sh "cd ${REPO}; docker build -f DockerfileNGX . -t ${GCR}${REPO}-ecs-${NGINX}:$TAG"
                        sh "gcloud docker -- push ${GCR}${REPO}-ecs-${NGINX}; cd ../"
                        sh "./tagger.sh ${GCR} ${REPO} ${NGINX} $TAG"
                        sh "docker images -q |xargs docker rmi -f"
                        
                        // build Varnish
                        sh "cd ${REPO}; docker build -f DockerfileVSH . -t ${GCR}${REPO}-ecs-${VARNISH}:$TAG"
                        sh "gcloud docker -- push ${GCR}${REPO}-ecs-${VARNISH}; cd ../"
                        sh "./tagger.sh ${GCR} ${REPO} ${VARNISH} $TAG"
                        sh "docker images -q |xargs docker rmi -f"
                        
                        // Tidy up
                        sh "sudo rm -rf ${REPO};"
                    }
                }
            }
        }
 
        stage('DeployUat') {
            // Deploy stage agent selector
            agent {
                node {
                    label 'ecs_deployer'
                    customWorkspace '/var/jenkins_home/shared/ecs_deployer'
                }
            }
             
            //// Deploy step use jenkins master credentials to pull tag
            steps {
                withCredentials([
                                [$class: 'StringBinding', credentialsId: 'TOKEN', variable: 'API_TOKEN'],
                                [$class: 'FileBinding', credentialsId: 'ECS_DEPLOY', variable: 'DEPLOYER'],
                                [$class: 'AmazonWebServicesCredentialsBinding', credentialsId: 'BAM_AWS', accessKeyVariable: 'BAM_ACCESS', secretKeyVariable: 'BAM_SECRET']]) {
                // send slack notification that deploy stage has started
                slackSend channel: '#deploy', color: 'good', message: "All image's have started deployment to UAT > (<${env.RUN_DISPLAY_URL}|Open>) for details"
                // Deploy step grab release TAG set image id and deploy new revisions
                script {
                    sh "curl -sS -H 'Authorization: token  ${API_TOKEN}' ${GIT}${GITORG}${REPO}/releases | jq  -r '.[].tag_name'| head -1 > tags"
                    def TAG=readFile('tags')
                    
                    // Export keys and start deployment
                    sh "sudo cp ${env.DEPLOYER} ecs.sh; sudo chmod +x ecs.sh; sudo chown jenkins: ecs.sh"
                    sh "echo 'export AWS_SECRET_ACCESS_KEY=${env.BAM_SECRET}\nexport AWS_ACCESS_KEY_ID=${env.BAM_ACCESS}\nexport AWS_DEFAULT_REGION=${REGION}\nexport AWS_DEFAULT_OUTPUT=json' >> aws.env"
                    sh ". ./aws.env ; ecs deploy ${UATCLUSTER} ${UAT}-${WORDPRESS} --image ${WORDPRESS} ${GCR}${REPO}-ecs-${WORDPRESS}:latest --timeout ${TIMEOUT}"
                    
                    // Clean up
                    sh "sudo rm -rf *"
                    
                    }
                }            
            }
            post {
                  failure {
                      slackSend channel: '#deploy',
                          color: 'danger',
                          message: "Image ${WORDPRESS} FAILED to deploy, Visit > (<${env.RUN_DISPLAY_URL}|Open>) for details"
                    }
              
                
                  success {
                      slackSend channel: '#deploy',
                          color: 'good',
                          message: "Image's ${WORDPRESS}, ${NGINX} and ${VARNISH} deployed successfully to to stage, Please access > (<${env.RUN_DISPLAY_URL}|Open>) and accept or decline build to continue.."
               
                      input message: "Image's ${WORDPRESS}, ${NGINX} and ${VARNISH} have been released to ${UAT}, please test and confirm..."
                  }
               }
            }
            stage('DeployProd') {
            // Deploy stage agent selector
            agent {
                node {
                    label 'ecs_deployer'
                    customWorkspace '/var/jenkins_home/shared/ecs_deployer'
                }
            }
             
            //// Deploy step use jenkins master credentials to pull tag
            steps {
                withCredentials([
                                [$class: 'StringBinding', credentialsId: 'TOKEN', variable: 'API_TOKEN'],
                                [$class: 'FileBinding', credentialsId: 'ECS_DEPLOY', variable: 'DEPLOYER'],
                                [$class: 'AmazonWebServicesCredentialsBinding', credentialsId: 'BAM_AWS', accessKeyVariable: 'BAM_ACCESS', secretKeyVariable: 'BAM_SECRET']]) {
                // send slack notification that deploy stage has started
                slackSend channel: '#deploy', color: 'good', message: "All image's have started deployment to production > (<${env.RUN_DISPLAY_URL}|Open>) for details"
                // Deploy step grab release TAG set image id and deploy new revisions
                script {
                    sh "curl -sS -H 'Authorization: token  ${API_TOKEN}' ${GIT}${GITORG}${REPO}/releases | jq  -r '.[].tag_name'| head -1 > tags"
                    def TAG=readFile('tags')
                    
                    // Export keys and start deployment
                    sh "sudo cp ${env.DEPLOYER} ecs.sh; sudo chmod +x ecs.sh; sudo chown jenkins: ecs.sh"
                    sh "echo 'export AWS_SECRET_ACCESS_KEY=${env.BAM_SECRET}\nexport AWS_ACCESS_KEY_ID=${env.BAM_ACCESS}\nexport AWS_DEFAULT_REGION=${REGION}\nexport AWS_DEFAULT_OUTPUT=json' >> aws.env"
                    sh ". ./aws.env ; ecs deploy ${PRODCLUSTER} ${UAT}-${WORDPRESS} --image ${WORDPRESS} ${GCR}${REPO}-ecs-${WORDPRESS}:latest --timeout ${TIMEOUT}"
                    
                    // Clean up
                    sh "sudo rm -rf *"
                    
                    }
                }              
            }
            post {
                  failure {
                     slackSend channel: '#deploy',
                         color: 'danger',
                         message: "Image's ${WORDPRESS}, ${NGINX} and ${VARNISH} FAILED to deploy, Visit > (<${env.RUN_DISPLAY_URL}|Open>) for details"
                         }
              
                  success {
                     slackSend channel: '#deploy',
                         color: 'good',
                         message: "All images deployed successfully to to production, Please access > (<${env.RUN_DISPLAY_URL}|Open>) and accept or decline build to continue.."
             
                     input message: "Image's ${WORDPRESS}, ${NGINX} and ${VARNISH} have been released to ${PROD}, please test and confirm..."
                    }
               }
          }
     }     
}

pipeline {
    // Agent specified as none @ root of pipeline agent gets specified inside stages
    agent none
    
    // Git Repo Details
    environment {
        //
        REPO = "bamtech-wordpress-child"
        
        //
        GITORG = "JellyfishGroup/"
        
        //
        GIT = "https://api.github.com/repos/"
        
        //
        PULL = "git@github.com"
        
        //
        GCR = "gcr.io/jellyfish-development-167809/"
        
        //
        NAME = "bamtech"
        
        //
        WORDPRESS = "wordpress"
        
        //
        REGION = "us-east-1"
        
        //
        UATCLUSTER = "ecsUatCluster"
        
        //
        PRODCLUSTER = "ecsProdCluster"
        
        //
        UAT = "uat"
        
        //
        PROD = "prod"
        
        //
        TIMEOUT = "1200"
        
        // Images that do not usually get built..
        NGINX = "nginx"
        VARNISH = "varnish"
    }

    // Job wide options
    options {
        // Prevent "Git Clone" because we want to this manually below in order to fetch a specific tag
        skipDefaultCheckout()   
    }

    // All the stages of the build
    stages {
        // Build Images
        stage('Build') {

            // Build stage agent selector
            agent { 
                node {
                    label 'container_builder'
                    customWorkspace '/var/jenkins_home/shared/docker_ctb/'
                }
            }

            // Build step use jenkins master credentials
            steps {

                // Jenkins credentials stored on master 
                // StringBinding used as API token
                // FileBinding used as auth script and service key
                withCredentials([
                    // Git API Token to pull the tag
                    [$class: 'StringBinding', credentialsId: 'TOKEN', variable: 'API_TOKEN'],
                    // Deploy key for ECS
                    [$class: 'FileBinding', credentialsId: 'DEPLOY_KEY', variable: 'key'],
                    // Authenticate with AWS
                    [$class: 'FileBinding', credentialsId: 'AUTH', variable: 'run'],
                    // Another script that tags the image with "x.x.x.x" and "latest"
                    [$class: 'FileBinding', credentialsId: 'TAGGER', variable: 'tagger']]) {

                    // Build step grab release TAG and build/push images with new tag ID
                    // Then run cleanup on agents
                    // send slack notification that build steps has started:
                    slackSend channel: '#deploy', color: 'good', message: "Project ${NAME} has started building images > (<${env.RUN_DISPLAY_URL}|Open>) for details"
                
                    script {
                        // Copy the environment keys from Jenkins master to 
                        // 1. jelly.json - authenticate with AWS
                        // 2. env.run - renamed to auth.sh - pulls the deploy key
                        // 3. env.tagger - environment script onto the container that does the image tagging
                        echo "[DESC] Copying environment keys"
                        sh "sudo cp ${env.key} jelly.json;sudo cp ${env.run} auth.sh;sudo cp ${env.tagger} tagger.sh"
                        
                        // Setting permissions on the above scripts
                        sh "sudo chmod +x auth.sh; sudo chown jenkins: auth.sh; sudo chown jenkins:  jelly.json; ./auth.sh;sudo chmod +x tagger.sh; sudo chown jenkins: tagger.sh"
                        
                        // Grab the latest tag into a text file
                        sh "curl -sS -H 'Authorization: token  ${API_TOKEN}' ${GIT}${GITORG}${REPO}/releases | jq  -r '.[].tag_name'| head -1 > tags"
                        
                        // assign the tag to a variable
                        def TAG=readFile('tags')
                        
                        /* 
                        // CONSIDER USING MULTIPLE JENKINS NODES HERE TO BUILD WITH 
                        // i.e.
                        // labels for Jenkins node types we will build on
                        def IMAGES = [WORDPRESS, NGINX, VARNISH] 
                        def BUILDERS = [:]
                        for (X in IMAGES) {
                            // Need to bind the label variable before the closure - can't do 'for (image in images)'
                            def IMAGE = X 

                            // Create a map to pass in to the 'parallel' step so we can fire all the builds at once
                            builders[IMAGE] = {
                                node(IMAGE) {
                                    // Clone the tag
                                    sh "git clone ${PULL}:${GITORG}${REPO}.git --depth 1 -b $TAG"
                                    
                                    // Output message to the screen
                                    echo "Building image: "+$IMAGE+":"+${TAG}
                                    
                                    // Build the image
                                    sh "cd ${REPO}; docker build -f DockerfileWP . -t ${GCR}${REPO}-ecs-$IMAGE:$TAG" 
                                    
                                    // Push the image to Google Container Registry
                                    sh "gcloud docker -- push ${GCR}${REPO}-ecs-$IMAGE; cd ../"
                                    
                                    // Tag the pushed images
                                    sh "./tagger.sh ${GCR} ${REPO} $IMAGE $TAG"
                                    
                                    // Clean up images
                                    sh "docker images -q |xargs docker rmi -f"
                                    
                                    // Tidy up files
                                    sh "sudo rm -rf ${REPO};"
                                }
                            }
                        }

                        parallel builders
                        */
                        
                        //
                        sh "git clone ${PULL}:${GITORG}${REPO}.git --depth 1 -b $TAG"
                        
                        // Build Wordpress
                        sh "cd ${REPO}; docker build -f DockerfileWP . -t ${GCR}${REPO}-ecs-${WORDPRESS}:$TAG" 
                        sh "gcloud docker -- push ${GCR}${REPO}-ecs-${WORDPRESS}; cd ../"
                        sh "./tagger.sh ${GCR} ${REPO} ${WORDPRESS} $TAG"
                        sh "docker images -q |xargs docker rmi -f"
                        
                        // Images that do not usually get built..
                        // Build Nginx
                        sh "cd ${REPO}; docker build -f DockerfileNGX . -t ${GCR}${REPO}-ecs-${NGINX}:$TAG"
                        sh "gcloud docker -- push ${GCR}${REPO}-ecs-${NGINX}; cd ../"
                        sh "./tagger.sh ${GCR} ${REPO} ${NGINX} $TAG"
                        sh "docker images -q |xargs docker rmi -f"
                        
                        // Build Varnish
                        sh "cd ${REPO}; docker build -f DockerfileVSH . -t ${GCR}${REPO}-ecs-${VARNISH}:$TAG"
                        sh "gcloud docker -- push ${GCR}${REPO}-ecs-${VARNISH}; cd ../"
                        sh "./tagger.sh ${GCR} ${REPO} ${VARNISH} $TAG"
                        sh "docker images -q |xargs docker rmi -f"
                        
                        // Tidy up
                        sh "sudo rm -rf ${REPO};"
                    }
                }
            }
            post {
                  
                failure {
                    slackSend channel: '#deploy',
                        color: 'danger',
                        message: "Image's ${WORDPRESS}, ${NGINX} and ${VARNISH} FAILED to build, Visit > (<${env.RUN_DISPLAY_URL}|Open>) for details"
                }
                
                success {
                    slackSend channel: '#deploy',
                        color: 'good',
                        message: "Image's ${WORDPRESS}, ${NGINX} and ${VARNISH} SUCCESSFULLY built, Please visit > (<${env.RUN_DISPLAY_URL}|Open>) for details"
                }

                always {
                    sh "echo ${workspace}"
                    sh "rm -rf *"
                }               
            }
        }
        stage('DeployUat') {
            // Deploy stage agent selector
            agent {
                node {
                    label 'ecs_deployer'
                    customWorkspace '/var/jenkins_home/shared/ecs_deployer/'
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

                always {
                    sh "echo ${workspace}"
                    sh "rm -rf *"
                }
            }
        }
        stage('DeployProd') {
            // Deploy stage agent selector
            agent {
                node {
                    label 'ecs_deployer'
                    customWorkspace '/var/jenkins_home/shared/ecs_deployer/'
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
                    sh ". ./aws.env ; ecs deploy ${PRODCLUSTER} ${PROD}-${WORDPRESS} --image ${WORDPRESS} ${GCR}${REPO}-ecs-${WORDPRESS}:latest --timeout ${TIMEOUT}"
                    
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
                }

                always {
                    sh "echo ${workspace}"
                    sh "rm -rf *"
                }          
            }
        }    
    }       
}

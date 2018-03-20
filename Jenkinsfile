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
                                [$class: 'FileBinding', credentialsId: 'AUTH', variable: 'run']]) {

                    // Build step grab release TAG and build/push images with new tag ID
                    // Then run cleanup on agents
                    // send slack notification that build steps has started:
                    slackSend channel: '#deploy', color: 'good', message: "Image ${NAME} build has started > (<${env.RUN_DISPLAY_URL}|Open>) for details"
                
                    script {
                        sh "sudo cp ${env.key} jelly.json;sudo cp ${env.run} auth.sh"
                        sh "sudo chmod +x auth.sh; sudo chown jenkins: auth.sh; sudo chown jenkins:  jelly.json; ./auth.sh "
                        sh "curl -sS -H 'Authorization: token  ${API_TOKEN}' ${GIT}${GITORG}${REPO}/releases | jq  -r '.[].tag_name'| head -1 > tags"
                        def TAG=readFile('tags')
                        sh "git clone ${PULL}:${GITORG}${REPO}.git --depth 1 -b $TAG"
                        
                        // build wordpress
                        sh "cd ${REPO}; docker build -f DockerfileWP . -t ${GCR}${REPO}-ecs-wordpress:$TAG" 
                        sh "gcloud docker -- push ${GCR}${REPO}-ecs-wordpress; cd ../"
                        sh "gcloud container images add-tag ${GCR}${REPO}-ecs-wordpress:$TAG ${GCR}${REPO}-ecs-wordpress:latest"
                    }
                }
            }
        }
    }
    post {
        failure {

/* COMMENTED OUT AS NO DEPLOY IS USED HERE
                slackSend channel: '#deploy', color: 'danger', message: "Image ${NAME}:$TAG FAILED to deploy, Visit > (<${env.RUN_DISPLAY_URL}|Open>) for details"
*/
                
                // clean the bodies
                script {
                    sh "docker images -q |xargs docker rmi -f"
                    sh "sudo rm -rf ${REPO};"
                }
            }
              
                
            success {

/* COMMENTED OUT AS NO DEPLOY IS USED HERE
                slackSend channel: '#deploy', color: 'good', message: "Image ${NAME}:$TAG deployed successfully to to stage, Please access > (<${env.RUN_DISPLAY_URL}|Open>) and accept or decline build to continue.."
*/                                
                // clean the bodies
                script {
                    sh "docker images -q |xargs docker rmi -f"
                    sh "sudo rm -rf ${REPO};"
                }
            }
        }
    }
}
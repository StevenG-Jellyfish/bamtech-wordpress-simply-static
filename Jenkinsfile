pipeline {
    // Trigger from master branch github
    triggers {
        upstream (
            upstreamProjects: 'sos-wordpress-child/master'
         )
    }
    environment {
        // GCloud Details 
        PROJECT_ID = "uk-soss-0004-sos-systems"
        ZONE = "europe-west1-b"
        CLUSTER = "sos-kubernetes"
        DEPLOYMENT_STG = "sos-stage"
        
        // Git Repo Details
        REPO = "sos-wordpress-child"
        GITORG = "JellyfishGroup/"
        GIT = "https://api.github.com/repos/"
        PULL = "git@github.com:"
        GCR = "gcr.io/jellyfish-development-167809/"
        WORDPRESS = "wordpress"
    }
    // Agent specified as none @ root of pipeline 
    // agent gets specified inside stages
    agent none
        
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
                // StringBinding - API token
                // FileBinding - auth script and service key
                withCredentials([
                                [$class: 'StringBinding', credentialsId: 'TOKEN', variable: 'API_TOKEN'],
                                [$class: 'FileBinding', credentialsId: 'DEPLOY_KEY', variable: 'key'],
                                [$class: 'FileBinding', credentialsId: 'AUTH', variable: 'run']]) {
                       // Build step grab release TAG and build/push images with new tag ID
                       // Then run cleanup on agents
                    script {
                         sh "sudo cp ${env.key} jelly.json;sudo cp ${env.run} auth.sh"
                         sh "chmod +x auth.sh; ./auth.sh "
                         sh "curl -sS -H 'Authorization: token  ${API_TOKEN}' ${GIT}${GITORG}${REPO}/releases | jq  -r '.[].tag_name'| head -1 > tags"
                         def TAG=readFile('tags')
                         sh "git clone ${PULL}${GITORG}${REPO}.git --depth 1 -b $TAG"
                         sh "cd ${REPO}; docker build -f DockerfileWP . -t ${GCR}${REPO}-gke-${WORDPRESS}:$TAG" 
                         sh "gcloud docker -- push ${GCR}${REPO}-gke-${WORDPRESS}; cd ../"
                         sh "docker images -q |xargs docker rmi -f"
                         sh "sudo rm -rf ${REPO};"
                         echo "Complete!"
                       }
                  }
             }
        }
        stage('Deploy') {
            // Deploy stage agent selector
            agent {
                node {
                    label 'kube_deployer'
                    customWorkspace '/var/jenkins_home/shared/kube_deployer'
                }
            }
            // Deploy step use jenkins master credentials to pull tag
            steps {
                withCredentials([[
                    $class: 'StringBinding',
                    credentialsId: 'TOKEN',
                    variable: 'API_TOKEN'
                ]]) {
                // Deploy step grab release TAG set image id and deploy new revisions
                script {
                    sh "curl -sS -H 'Authorization: token  ${API_TOKEN}' ${GIT}${GITORG}${REPO}/releases | jq  -r '.[].tag_name'| head -1 > tags"
                    def TAG=readFile('tags')
                    sh "gcloud config set project ${PROJECT_ID}"
                    sh "gcloud config set compute/zone ${ZONE}"
                    sh "gcloud container clusters get-credentials ${CLUSTER}"
                    sh "kubectl set image deployment/${DEPLOYMENT_STG} wordpress=${GCR}${REPO}-gke-${WORDPRESS}:$TAG"
                    sh "kubectl rollout status deployment/${DEPLOYMENT_STG}"
                    // User Input to complete.
                    input message: "Image ${WORDPRESS}:$TAG has been released to stage, please test and confirm..."
                    }
                }  
            }
        }
    }
}

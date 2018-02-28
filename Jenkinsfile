pipeline {
    environment {
        REPO = "wordpress-child"
    }
    agent none

    stages {
        stage('Build') {
            agent {
                node {
                    label 'container_builder'
                    customWorkspace '/var/jenkins_home/shared/docker_ctb'
                }
            } 
            steps {
                sh """/var/jenkins_home/build_container.sh ${REPO}"""
            }    
        }
    }
}

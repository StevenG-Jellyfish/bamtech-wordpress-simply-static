pipeline {
    // Agent specified as none @ root of pipeline 
    // agent gets specified inside stages
    agent none
    
    environment {
        // Git Repo Details
        REPO = "Bamtech-wordpress"
        GITORG = "JellyfishGroup/"
        GIT = "https://api.github.com/repos/"
        PULL = "git@github.com:"
        WD= 'home/sites/Bamtech-wordpress'
    }
    options {
        skipDefaultCheckout()   
    }
    stages {
        stage('pull & deploy') {
            agent none

           
                    script {
                         sh "cd ${WD}"
                         sh "docker-compose down"
                         sh "git fetch"
                         sh "docker compose up -d"                         
                         echo "Complete!"
                       }
                  }
             }
}

pipeline {
    // Agent specified as none @ root of pipeline 
    // agent gets specified inside stages
    agent any
    
    environment {
        WD= "home/sites/Bamtech-wordpress"
    }
    stages {
        stage('rebuild wordpress') {
            steps {              
                    script {
                         sh "cd ${WD}"
                         sh "git pull"
                         sh "docker-compose build wordpress"
                         sh "docker-compose up --no-deps -d wordpress"                         
                         echo "Complete!"
                       }
                  }
             }
    }
}

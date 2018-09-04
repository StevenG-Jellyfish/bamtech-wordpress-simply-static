/*
    This is a CI/CD pipeline. Consisting of:

    github
    slack
    Google Cloud Builder
    Google Cloud Functions
    JFrog
    Jenkins Pipeline
    AWS ECS
    Lighthouse Inspector
    Ghost Inspector

    This pipeline is made up of the following:

        1. On code-release in git, via cloudbuild.yaml file, trigger Google Cloud Docker Build and notify to Slack
        2. Push images to JFrog
        3. Receive webhook from Google and automatically start Jenkins Job based on the Jenkins job token trigger
        4. Notify via Slack the various stages
        5. Deploy to AWS ECS UAT and PROD


 */


/*
    Slack Channel
 */
def slackChannelMessage (color, message) {

  // Update slack channel as required
  def date = new Date()
  slackSend (channel: '#deploy', color: "${color}", message: "${message} - ${date}")
  
}


/*
    Webhook Step - wait for POST curl to URL
 */
def webHookUrl(env_value) {

   script {
     def date = new Date()
     hook = registerWebhook()
     slackChannelMessage ("good", "${env_value} - Click on this link to continue to progress to: ${env_value} for ${env.JOB_NAME} Build (${env.BUILD_NUMBER}) using TAG ${git_tag_id} for Image ${WORDPRESS} : ${hook.getURL()} > (<${env.RUN_DISPLAY_URL}|Open>)")
     data = waitForWebhook hook
    }

}


/*
    Ghost Inspector Test
 */

def GhostInsTest () {

  slackChannelMessage ("good", "Running Gost Inspector test for Image ${WORDPRESS}:${TAG}..., Visit > (<${env.RUN_DISPLAY_URL}|Open>) for details")

  script {

    def result = sh (
       returnStdout: true,
       script: """curl -s "https://api.ghostinspector.com/v1/suites/${SUITE_ID}/execute/?apiKey=${API_KEY}&startUrl=http://${URL_TO_CHECK}" | grep -i SUCCESS | grep -i PASSING"""
    )

     // echo "CURL output = $result"

    if ( result.equals('') ) {
           echo "Ghost Inspector Test Failed"
           sh "exit 1"
        }
        else {
           echo "Ghost Inspector Test Passed"
           sh "exit 0"
    }

  }

}


/*
  AWS deployment
 */

 def AWSDeployment (cluster, cluster_ENV) {

       echo "Running against ${cluster_ENV} -  ${cluster} - AWS ECS.  Using timeout of ${TIMEOUT}"

       withCredentials([
             [$class: 'AmazonWebServicesCredentialsBinding', credentialsId: 'BAM_AWS', accessKeyVariable: 'BAM_ACCESS', secretKeyVariable: 'BAM_SECRET']]) {
             // Export keys and run against AWS ECS access
                sh "echo 'export AWS_SECRET_ACCESS_KEY=${env.BAM_SECRET}\nexport AWS_ACCESS_KEY_ID=${env.BAM_ACCESS}\nexport AWS_DEFAULT_REGION=${REGION}\nexport AWS_DEFAULT_OUTPUT=json' >> aws.env"

      
                // Pull from GCR
                echo "Use image: - ${WORDPRESS} ${GCR}${REPO}-ecs-${WORDPRESS}:${TAG} for ${cluster_ENV} -  ${cluster}"
                sh ". ./aws.env ; ecs deploy ${cluster} ${cluster_ENV}-${WORDPRESS} --timeout ${TIMEOUT} --image ${WORDPRESS} ${GCR}${REPO}-ecs-${WORDPRESS}:${TAG}"
               
               // Pull from JFrog
               // echo "Use image: - ${WORDPRESS} ${jfrog_URL}${REPO}-ecs-${WORDPRESS}:${TAG} for ${cluster_ENV} -  ${cluster}"
               // sh ". ./aws.env ; ecs deploy ${cluster} ${cluster_ENV}-${WORDPRESS} --timeout ${TIMEOUT} --image ${WORDPRESS} ${jfrog_URL}${REPO}-ecs-${WORDPRESS}:${TAG}"
        
       }

 }



/*
    Test with a simple curl and check we get 200 back
 */
 def curlTest (namespace, out, domain) {

     echo "Running tests in ${namespace}"

     script {
        if (out.equals('')) {
            out = 'http_code'
        }

        url = "https://${domain}"  // use https
       //  url = "http://${domain}" // use http
    }
}

/*
    Run a curl against a given url
 */

def curlRun (url, out) {

    echo "Running curl on ${url}"

    script {

        if (out.equals('')) {

            out = 'http_code'

        }

        echo "Getting ${out}"

            def result = sh (

                returnStdout: true,

                script: "curl --output /dev/null --silent --connect-timeout 5 --max-time 5 --retry 5 --retry-delay 5 --retry-max-time 30 --write-out \"%{${out}}\" ${url}"

        )

        echo "Result (${out}): ${result}"
    }
}


/*
    This is the main pipeline section with the stages of the CI/CD
 */

pipeline {

    environment {

        GCR = "gcr.io/jellyfish-development-167809/"
        REPO = "bamtech-wordpress-child"
        NAME = "bamtech"
        WORDPRESS = "wordpress"

        // AWS ECS
        REGION = "us-east-1"
        UATCLUSTER = "ecsUatCluster"
        PRODCLUSTER = "ecsProdCluster"
        UAT = "uat"
        PROD = "prod"
        TIMEOUT = "1200"

        // Images that do not usually get built..
        NGINX = "nginx"
        VARNISH = "varnish"

        // Curl Tests
    	 DOMAIN_STG = ""
    	 DOMAIN_UAT = ""
    	 DOMAIN_PROD = ""

        // lighthouse-inspector json values
        lightHouse_ins_json = "default-lighthouse-ins-json"
        lh_URL = "www.jellyfish.co.uk"  // Omit http://
        pwa = "2"
        best_practices = "2"
        performance = "2"
        accessibility = "2"
        first_meaningful_paint = "2"
        load_fast_enough_for_pwa = false
        // Lighthouse Inspector output file
        LHF = "lhf.out"
        // Chrome node
        cws = "/tmp"

        // Ghost Inspector
        API_KEY= ""
        SUITE_ID = ""
        URL_TO_CHECK = ""

        // JFrog details
        SERVER_ID = "JF.jfrog01"
        jfrog_URL = "jellyfish-docker.jfrog.io/"

        TAG = ""

    }

// Jenkins slave containers
agent {
   kubernetes {
     label 'jenkins-slaves-bamtech'
     defaultContainer 'jnlp'

     yaml """

apiVersion: v1
kind: Pod
metadata:
 name: jenkins-slaves
 label: jenkins-slaves
spec:
 securityContext:
   runAsUser: 0
 containers:
 - name: jnlp
   env:
   - name: CONTAINER_ENV_VAR
     value: jenkins-jnlp
 - name: jenkins-ecs-slave
   image: jellyfish-docker.jfrog.io/jfh-development/docker_jenkins_slave-kube_deploy:latest
   imagePullPolicy: Always
   command:
   - cat
   tty: true
   env:
   - name: CONTAINER_ENV_VAR
     value: jenkins-ecs-slave
 - name: jenkins-chrome-slave
   image: jellyfish-docker.jfrog.io/jfh-development/docker_jenkins_slave-chrome_service:latest
   imagePullPolicy: Always
   command:
   - cat
   tty: true
   env:
   - name: CONTAINER_ENV_VAR
     value: jenkins-chrome-slave
 - name: jenkins-qa-slave
   image: jellyfish-docker.jfrog.io/jfh-development/docker_jenkins_slave-qa_service:latest
   imagePullPolicy: Always
   command:
   - cat
   tty: true
   env:
   - name: CONTAINER_ENV_VAR
     value: jenkins-qa-slave
 imagePullSecrets:
 - name: docker-reg-secret

"""
   }
}

// jenkins job token - Also update in cloudbuild.yaml
triggers {
    GenericTrigger(
     genericVariables: [
      [key: 'git_tag_id', value: '$.git_tag_id']
     ],
     causeString: 'Triggered on GIT Release TAG:- $git_tag_id',
     token: 'start-bamtech-wordpress-child-jenkinsfile',
     regexpFilterExpression: '',
     regexpFilterText: '',
     printContributedVariables: true,
     printPostContent: true
    )
  }

     options {
        skipDefaultCheckout()
    }

    stages {

         ////////// Step 1 //////////
         stage('Trigger received from Google WebHook') {

            steps {

                 slackChannelMessage ("good", " ** Start of Jenkins job ${env.JOB_NAME} Build (${env.BUILD_NUMBER}) using TAG $git_tag_id for Image ${WORDPRESS} > (<${env.RUN_DISPLAY_URL}|Open>) for details")

                 script {

                    TAG = "$git_tag_id"

                    echo "Release TAG: ${TAG}"

                    FEATURE = sh (
                          script: """#!/bin/bash
                                  echo $TAG | grep -i FEATURE
                                  """,
                                  returnStatus: true,
                            )

                    if (FEATURE) {
                         echo "FEATURE release is FALSE - Push image through all stages"
                         FEATURE = false
                         slackChannelMessage ("good", "Will push Image ${WORDPRESS}:${TAG} to all stages, Please visit > (<${env.RUN_DISPLAY_URL}|Open>) for details")
                      }
                      else
                      {
                        echo "FEATURE release is TRUE"
                        FEATURE = true
                        slackChannelMessage ("good", "Found FEATURE release.  Will push to STG only. tag: $TAG for Image ${WORDPRESS}, Please visit > (<${env.RUN_DISPLAY_URL}|Open>) for details")
                    }
                  }
            }
            post {
                 failure {
                   echo "Failed to get release TAG"
                   slackChannelMessage ("danger", "Image ${WORDPRESS} FAILED to get latest release TAG, Visit > (<${env.RUN_DISPLAY_URL}|Open>) for details")
                 }
                 success {
                    echo "Successfully retreived release TAG: ${TAG}"
                    slackChannelMessage ("good", "SUCCESSFULLY retrieved latest release tag: $TAG for Image ${WORDPRESS}, Please visit > (<${env.RUN_DISPLAY_URL}|Open>) for details")
                }
            }

        }

       ////////// Step 2 //////////
        // Wait for user manual approval before deploying to UAT - webhook
       stage('Deploy to UAT?') {

           when {
                    expression { FEATURE == false }
                }

           steps {
                milestone(1)
                // Wait for POST to continue
                // webHookUrl('UAT')
                milestone(2)

                script {
                    DEPLOY_UAT = true
                }
            }
       }


       stage('Update UAT Docker Image in AWS ECS') {

            when {
                    expression { FEATURE == false }
            }

           // Deploy UAT agent selector - ECS

            steps {
             container('jenkins-ecs-slave') {
                 script {
                    cluster = "${UATCLUSTER}"
                    cluster_ENV = "uat"
                    echo "Perform update of ${WORDPRESS}:${TAG} to ${cluster} on ENV: ${cluster_ENV}"
                    slackChannelMessage ("good", "Update in AWS ECS UAT ${cluster} has started for ${WORDPRESS}:${TAG} > (<${env.RUN_DISPLAY_URL}|Open>) for details")
                    AWSDeployment(cluster, cluster_ENV)
                }
              }
            }
            post {
                 failure {
                   echo "Update of image: ${WORDPRESS}:${TAG} in ${cluster} failed"
                   slackChannelMessage ("danger", "Image ${WORDPRESS}:${TAG} FAILED to update on ${cluster_ENV} - ${cluster}, Visit > (<${env.RUN_DISPLAY_URL}|Open>) for details")
                 }
                 success {
                    echo "Successfully updated Image: ${WORDPRESS}:${TAG} in ${cluster}"
                    slackChannelMessage ("good", "Image ${WORDPRESS}:${TAG} updated SUCCESSFULLY to ${cluster_ENV} - ${cluster}, Visit > (<${env.RUN_DISPLAY_URL}|Open>) for details")
                 }
            }

        }

        ////////// Step 3 //////////
        // Wait for user manual approval before deploying to PROD
       stage('Deploy to PROD?') {

            when {
                    expression { FEATURE == false }
            }

           steps {
                milestone(3)
                // Wait for POST to continue
                webHookUrl('PROD')
                milestone(4)

                script {
                    DEPLOY_PROD = true
                }
            }
       }

       stage('Update PROD Docker Image in AWCS ECS') {

        when {
                   expression { FEATURE == false }
             }

           // Deploy PROD agent selector - ECS

           steps {
             container('jenkins-ecs-slave') {
             script {
                cluster = "${PRODCLUSTER}"
                cluster_ENV = "prod"
                echo "Perform update of ${WORDPRESS}:${TAG} to ${cluster} on ENV: ${cluster_ENV}"
                slackChannelMessage ("good", "Update in AWS ECS UAT ${cluster} has started for ${WORDPRESS}:${TAG} > (<${env.RUN_DISPLAY_URL}|Open>) for details")
                AWSDeployment(cluster, cluster_ENV)
            }
          }
        }
        post {
             failure {
                echo "Update of image: ${WORDPRESS}:${TAG} in ${cluster} failed"
                slackChannelMessage ("danger", "Image ${WORDPRESS}:${TAG} FAILED to update on ${cluster_ENV} - ${cluster}, Visit > (<${env.RUN_DISPLAY_URL}|Open>) for details")
                      }
             success {
                echo "Successfully updated Image: ${WORDPRESS}:${TAG} in ${cluster}"
                slackChannelMessage ("good", "Image ${WORDPRESS}:${TAG} updated SUCCESSFULLY to ${cluster_ENV} - ${cluster}, Visit > (<${env.RUN_DISPLAY_URL}|Open>) for details")
             }
        }

    }

    }
    post {
            failure {
              echo "Pipeline currentResult: ${currentBuild.currentResult}"
              slackChannelMessage ("danger", "** Pipeline completed for job ${env.JOB_NAME} Build (${env.BUILD_NUMBER}) - ${currentBuild.currentResult} on Image ${WORDPRESS}:${TAG}, Visit > (<${env.RUN_DISPLAY_URL}|Open>) for details")
            }
            success {
              echo "Pipeline currentResult: ${currentBuild.currentResult}"
              slackChannelMessage ("good", "** Pipeline completed for job ${env.JOB_NAME} Build (${env.BUILD_NUMBER}) - ${currentBuild.currentResult} for Image ${WORDPRESS}:${TAG}, Visit > (<${env.RUN_DISPLAY_URL}|Open>) for details")
           }
   }

}

# APP Dualnets Universiteit Utrecht

### Prerequisites

- In order to run (or build) a Docker container on your local machine you will need to install the 'Docker-for-Desktop'
client for your particular hardware setup. Clients are available for Windows, Mac OS X & Linux. They can be found at
https://www.docker.com/products/docker-desktop. Installation should be straight forward, instructions are provided at
the before mentioned website.

- add

  `127.0.0.1 dualnets.docker.dev`

  `127.0.0.1 saml-idp.docker.dev`

  to your hosts file.

## SAML IdP Container

Most of the projects & systems build by the HTS AppTeam need a (local) SAML IdP server to handle authentication.
To make life easier this container handles all that. You should be able to run this container and be good-to-go.

### Installation

Clone: https://github.com/UtrechtUniversity/HTS-Appteam-Development (develop branch)

When above mentions prerequisites are met, you should be able to build & run the container with the following command,
run in the HTS-Appteam-Development root folder:

`docker network create "hts-appteam-local-dev"`
`docker-compose up --build -d`

You should be able to access this SAML-IdP from your browser with the following URL https://saml-idp.docker.dev/


### Development:
Clone this repo and run `docker-compose up --build -d` in the root folder.

### Testing
Tests can run from the host with `./test.sh` or from within the container with: `php artisan dusk`
You can see all dusk tests on the url: http://localhost:7900/  (password: `secret`)


## Survey Application:

Frontend is build with LiveWire

Run `composer install` or `composer update` to install dependencies

Run `npm install`

To build the css and js run `npm build`

For the database setup run `php artisan migrate`

If you want to use survey demo data run `php artisan migrate --seed`

## Install questionaire

The application has two questionnaires: Default (dutch) and English. You can install the questionnaire via the 
url: {your url}/install-questions. Only one questionnaire can be installed at a time. After installing the 
questionnaire you can switch, but you have to remove all existing surveys, participant and results before you switch.

For the questionnaire to work properly you need to define a setting on the page {your url}/settingtable. Add a new 
setting with key: 'locale' and value: 'nl' or 'en', depending on the questionnaire you chose.


#### Question types (form_type)

- `text` - Open text question
- `select` - Basic multiple choice question
- `select_students` - Questions with students as options to choose from
- `select_for_subject` - Questions with students as options to choose from for each student
- `select_multiple` -  Multiple choice question for multiple students
- `display` - Display question with text, this is not really a question but a text display

#### Mobile Web App

The survey app is build for mobile web app tested on iPhone X and 11 with Safari browser. Should work on other browsers but focus is with Safari and Chrome. 

Code for the survey questions and answers lives in directory `app/Livewire/Forms` and frontend in `resources/views/livewire/forms`

Survey steps are controlled by the StepController

The html intro page can be edited in `form-step-intro.blade`

###
### Survey CSV Export 
Cron will run once per hour to check if students are finished with a particular survey from classId. This will check the latest submission from the student, if this is longer than 1 hour ago than the survey results will be exported to the csv.

The naming of the exported csv file is `YY-mm-dd time classId`. Results are exported hourly per classId when there are new submissions.

There is also an option to run the csv export script simply from the url route. Open the link `{mydomain}/csv-export`. Don't forget to wait 1 hour after the survey submission.

###
### Data Privacy 

All the students names will be deleted after the survey results export in the database. This is running once per hour. 

The complete info for all survey answers and students will be deleted daily at `03:00`. After this there is no survey data in the database. 


###
### Cron Jobs 

The schedules for the cron are in the Kernel.php

There are 2 commands to run on the backend to manually run the cvs export and data delete script. 
Run `php artisan list` to see the commands under app. 

To run the survey csv export script run command: `php artisan app:export-csv-run`

To delete all survey database data run command : `php atrtisan app:delete-all-survey-data`

To start the schedule worker run command: `php arisan schedule:work` has also `-q` to run quite 
###

#### _Enjoy the app!_ :heart:

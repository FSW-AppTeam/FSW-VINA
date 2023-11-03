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

###

## Survey Application:

Frontend is build with LiveWire

Run `composer install` or `composer update` to install dependencies


Run `npm install`

To build the css and js run `npm build`

For the database setup run `php artisan migrate`

If you want to use survey demo data run `php artisan migrate --seed`

###

#### Mobile Web App

The survey app is build for mobile web app tested on iPhone X and 11 with Safari browser. Should work on other browsers but focus is with Safari and Chrome. 

Code for the survey questions and answers lives in directory `app/Livewire/Forms` and frontend in `resources/views/livewire/forms`

The survey questions and answers text can be edited in the .json files from directory `storage/app/surveys`

> [!WARNING]
> Do not edit the json properties for:
>
>```json
>{
>"survey_id": 1,
>"question_id": 3,
>"question_type": "text"
>}
>```
> 
> Unless your really sure what you are doing!



Survey steps are controlled by the StepController

The html intro page can be edited in `form-step-intro.blade`


###
### Survey Insert Students Script

There is an option to use demo data from the seeder with `php artisan migrate --seed` or you can use `prefilled-names.json` file to create your own students for testing. 
Simply edit the `storage/app/surveys/prefilled-names.json` with your preferred names. You can add and remove more students to test the app. 


> **Note:**
> To start from the prefilled names script, the option for `active_list` must be set to `true`. If this is set to `false` the script is inactive!
> 
> The `active_student` property is the avctive student who is answering the survey questions. The other students for that class will be created automatically. 
> 
> You can change the `classcode` to run different tests 
>

###
### Survey CSV Export 
Cron will run once per hour to check if students are finished with a particular survey from classId. This will check the latest submission from the student, if this is longer than 1 hour ago than the survey results will be exported to the csv.

The naming of the exported csv file is `YY-mm-dd time classId`. Results are exported hourly per classId when there are new submissions.

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

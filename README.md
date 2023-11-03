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



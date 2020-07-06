# HumanAid Back Office

## Requirements

Make sure you have :
- The **GIT tool** allowing you to interact locally with the remote repository
- A working **Docker** (How to install docker : https://docs.docker.com/get-docker/)

If you can't get docker running on your machine, you can install a web server depending on your OS.To run this project, we need all the modules present in the "docker-compose.yml" file, namely : PHP^7.1, MYSQL/MariaDB, APACHE/NGINX and Composer. A NGINX configuration file is available at the root of the repository (filename: "humanaid_bo.conf"). The entry point of a symfony 4 project is in "./public/" and is named "index.php".

 

## Installation

To start, fork the project by clicking on the button in the top right corner of the GIT page of the repository and clone the project by clicking on the green "Clone" button. 
Once this is done, on your local repository :

- See this ".env.dist", copy paste this file and rename it by ".env", and change the ".env" file's variable, same thing for "./api/.env.dist"

- If you want to create a new feature, fix a bug etc... position yourself on the "develop" branch and create your development branch, by typing the following command:

```xml
git checkout develop && git checkout -b new/feature/branch
```

- Build your docker containers by typing the following command :

```xml
docker-compose up -d --build
```

- Once your containers are up, install Symfony dependencies and create the database by typing this command in your repository :

```xml
docker-compose exec php sh -c 'make start'
```

In case of a problem : 

- Change by your web server's database information the "DATABASE_URL" (mysql://{username}:{password}@{host}:{port}/{database_name}) in your .env file
- If PHP is well installed type the command bellow to install Symfony dependencies and create the database :

```xml
make start
```
# Install instructions - XML Catalog feed importer #

## Requirements ##
- [Git](https://git-scm.com/) - Distributed version-control system for tracking
  changes in source code during software development.
- [Composer](https://getcomposer.org/) - Dependency manager for the PHP
  programming language.
- [DDEV](https://github.com/drud/ddev) - Open source tool that makes it simple
  to get local PHP development environments up and running in minutes.
- [Docker](https://www.docker.com/products/docker-desktop) - Docker Desktop is a
  tool for MacOS and Windows machines for the building and sharing of
  containerized applications and microservices.

## Clone ##
Clone from remote repository into your local directory:
```
git clone git@bitbucket.org:nborschke/frame-mall-website.git
```

## DDEV start ##
At first you have to start your *DDEV* services (usually *web* and *db*).
Navigate to your project root directory and run the following command:
```
ddev start
```

## Setup ##
After cloning, you will have to install all required dependencies via *Composer*.
Navigate to the root directory of your project and execute the following
command:
```
ddev composer install
```

## Migrations ##
To ensure needed database tables are all setup please execute migrations:
```
ddev exec bin/console doctrine:migrations:migrate
```

## URLs ##
To get a list of all URLs, ports, SQL credentials etc. type:
```
ddev desc
```

## Database ##

### Credentials ###
```
Host: db
Database: db
Username: db
Password: db
```

## Import XML Catalog Data ##
To import the catalog data, place the file to import into the files directory.
Then run the following command:
```
ddev exec bin/console nborschke:import-xml files/{filename}.xml
```

## Tests ##
Run tests:
```
ddev exec php bin/phpunit
```

## Logs ##
Error logs will be written to the following path:

```
/var/log/dev.log
```




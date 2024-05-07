
# Zoo Arcadia - ECF Studi

A website for a fictionnal zoo developped as a final exercise for studi school.




## Authors

- [@julobeau](https://github.com/julobeau)


## Tech Stack

Symfony 7.0 (php 8.2, composer)   
MySQL 8  
MongoDB (local or Atlas, driver php)  
Bootstrap 5.3.3  
SCSS


## Installation

Install locally with:

```bash
  cd my_projects
  git clone https://github.com/julobeau/Zoo-Arcadia -b main
  cd Zoo-Arcadia
  cp .env .env.local
```
  Edit the .env.local file. Remove everything and add:
  ```php
 ###> doctrine/doctrine-bundle ###
DATABASE_URL="mysql://<username>:<password>@<host>:<port>/sf_zoo_arcadia?serverVersion=8.0.32&charset=utf8mb4"
###< doctrine/doctrine-bundle ###
### Configure mailtrap account to catch emails ###
MAILER_DSN=smtp://<username>:<password>@sandbox.smtp.mailtrap.io:2525
### Mailtrap ###
### Configure MongoDb ###
MONGODB_URL=mongodb+srv://<username>:<password>@<host>
MONGODB_DB=arcadia
### MongoDb ###
  ```
  
  Run composer to install dependencies:

```bash
  composer install
```
## Demo

[Demo](https://zoo-arcadia-jb-9f78cb1dd18e.herokuapp.com/)


## Documentation

[Documentation](https://linktodocumentation)


## License

[MIT](https://choosealicense.com/licenses/mit/)


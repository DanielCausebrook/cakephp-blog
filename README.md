# cakephp-blog
Test cakephp project using the 2.x Blog Tutorial.

This repository contains my implementation of the [CakePhp Blog Tutorial](https://book.cakephp.org/2.0/en/getting-started.html#blog-tutorial). It features full bootstrap styling as well as additional features such as an improved permission model and account profiles.

## Configuration

In order to get this project running on your system you'll need to setup the database. Some systems will need extra setup but I will detail the basics that I had to follow here. For any additional information please refer to the aforementioned [tutorial](https://book.cakephp.org/2.0/en/getting-started.html#blog-tutorial).

### Connect to your database

This repostitory does not contain any database conection configuration. You'll need to create the file `app/Config/database.php` with the details and credentials for your database. CakePHP provides an example at `app/Config/database.php.default`.

### Load the schema

This repository contains a schema that can be used to create the required tables in the database. It also creates three default roles, 'author', 'mod' and 'admin' and one default user. The user '`ChiefChef`' is created with password '`password`' for convenience. Please don't forget to change the password if required!

To load the schema you'll need to run:

```
app/Console/cake schema create
```

More information about schema migration can be found in the [CakePHP cookbook](https://book.cakephp.org/2.0/en/console-and-shells/schema-management-and-migrations.html).

### Other configuration notes

- CakePHP must have write access to the `app/tmp` directory.
- You should set your own salt and cipher seed for security.
- You may encounter issues with allowing URL rewriting.

These are all covered in detail in the [tutorial](https://book.cakephp.org/2.0/en/getting-started.html#blog-tutorial).

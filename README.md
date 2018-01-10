# SQL Dumper

A PHP command line application to dump databases into your source code. This can be very useful if you need to version control your database along with the source code.

## Getting Started

This package is available on packagist. You can use following commands to add this package into your composer dev dependancies.

``` composer require srimaln91/sql-dumper --dev```

### Prerequisites

You need to have mysql and mysqldump binaries installed on your system. This package uses native mysql binaries to create and restore dumps.


### Installing

Please follow below steps to configure this application.

``` composer require srimaln91/sql-dumper --dev```

### Configuration

You need to create a config.yml file in your project root. Below is the default config file.

```
---
database:
  hostname: localhost
  database: xxxxx
  username: xxxxx
  password: xxx
  port: 3306
binaries:
  mysql: "/usr/bin/mysql"
  git: "/usr/bin/git"
directory:
  db: "/path/to/your/dump/directory/"
  ```

## How to generate a database dump

You can execute below command to create a new dump or update an existing dump directory

``` vendor/bin/application db:dump ```

### How to restore a database dump

Please use below command

```
vendor/bin/application db:restore
```

## Authors

* **Srimal Nishantha** - 
[GitHub](https://github.com/srimaln91)

See also the list of [contributors](https://github.com/srimaln91/sql-dumper/graphs/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

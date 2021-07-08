# Reports Portal

Reports generation tool for generate reports for custom date range.

# Requirements

This is web application developed with PHP with MySql database and web application runs on Apache web server 

```
web server Apache
php 8.0
mysql 8.0
```

### Configurations
Update all configurations in ``` /src/configs/Config.php ``` file

Reports specific configurations are in ``` src/configs/reportsConfigs.json ```

Output directory for generated files needs to be created and give permission to ```write``` in it.

## Installation

Install composer dependencies.

```bash
$ composer install
```

Generate composer autoload file.

```bash
$ composer dump-autoload
```

Run unit tests.

```bash
$ vendor/bin/phpunit tests
```


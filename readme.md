# Reports Portal

Reports generation tool for generate reports for custom date range

# Requirements
```bash
php 8.0
mysql 8.0
```

### Configurations
Update all configurations in /src/utils/Config file

Reports specific configurations are in src/configs/reportsConfigs.json

## Installation

Install composer dependencies

```bash
$ composer install
```

Generate composer autoload file

```bash
$ composer dump-autolaod
```

Run unit tests

```bash
$ vendor/bin/phpunit tests
```


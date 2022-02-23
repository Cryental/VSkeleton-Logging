# Volistx Skeleton Logging App

This app is an external log service app for Volistx Skeleton.

### Requirements
- PHP 8.1
- PHP Extensions:
  - curl
  - mysqli
  - pdo_mysql
  - openssl

### Usage
1. Please copy `config.php.example` to `config.php` and modify `config.php` for your database and settings.
2. Create a database in MySQL and import `table.sql`.
3. Run following commands:
```
composer install
```

### Commands
- Generate a Product using this command:
```
php ./console/commands --product:generate product_name <product_name>
```
- Wipe all records related to a Product using this command:
```
php ./console/commands --product:wipe product_id <product_id>
```
- Generate an admin access key for specific product using this command:
```
php ./console/commands --key:generate product_id <product_id>
```
- Disable an access key with this command:
```
php ./console/commands --key:disable key <key>
```
- You can wipe the DB wih this command:
```
php ./console/commands --db:wipe
```

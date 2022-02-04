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
1. Please modify `config.php` for your database and settings.
2. Create a database in MySQL and import `table.sql`.
3. Run following commands:
```
composer install
```

Generate an admin access key using this command:
```
php ./console/access-key --generate
```
Also you can delete an access key with this command:
```
php ./console/access-key --delete <key>
```
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
Please modify `config.php` for your database and settings and run following commands:
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
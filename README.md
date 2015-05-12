## Hands on Slim Framework

```bash
# fetch all dependencies
composer install

# install database
vendor/bin/doctrine orm:schema-tool:create

# run development server
php -S 0.0.0.0:8000 -t public server.php
```

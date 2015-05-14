# meta
A PHP 5.4 Page-Meta Container that is easily extensible

Installation & Requirements
---------------------------
This package requires PHP 5.4 or above. To install, simply add this line to
your `composer.json` file under the require key

```json
"require": {
    "coreplex/meta": "0.*"
}
```

Laravel Integration
-------------------
To use this package with Laravel, just take the following steps after
installation:

Add the service provider to the providers array in your `config/app.php` file
```php
'Coreplex\Meta\MetaServiceProvider',
```

You then need to publish the required assets using the command line. Run this
command to provision this action
```shell
php artisan vendor:publish --provider="Coreplex\Meta\MetaServiceProvider"
```

Usage
-----
More documentation to come when the library is working!
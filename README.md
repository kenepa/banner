# Displays a informative banner to users

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kenepa/banner.svg?style=flat-square)](https://packagist.org/packages/kenepa/banner)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/kenepa/banner/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/kenepa/banner/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/kenepa/banner/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/kenepa/banner/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/kenepa/banner.svg?style=flat-square)](https://packagist.org/packages/kenepa/banner)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

TODO:
This package relies on cache storage. if you are developing locally make sure NOT use the array cache driver. because this one is not persistent.
Make sure you have a proper caching solution for your prod environment.

You can install the package via composer:

```bash
composer require kenepa/banner
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="banner-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="banner-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="banner-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$banner = new Kenepa\Banner();
echo $banner->echoPhrase('Hello, Kenepa!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jehizkia](https://github.com/kenepa)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

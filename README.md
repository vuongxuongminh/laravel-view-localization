<p align="center">
    <a href="https://github.com/laravel" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/958072" height="100px">
    </a>
    <h1 align="center">Laravel View Localization</h1>
    <br>
    <p align="center">
    <a href="https://packagist.org/packages/vxm/laravel-view-localization"><img src="https://img.shields.io/packagist/v/vxm/laravel-view-localization.svg?style=flat-square" alt="Latest version"></a>
    <a href="https://travis-ci.org/vuongxuongminh/laravel-view-localization"><img src="https://img.shields.io/travis/vuongxuongminh/laravel-view-localization/master.svg?style=flat-square" alt="Build status"></a>
    <a href="https://scrutinizer-ci.com/g/vuongxuongminh/laravel-view-localization"><img src="https://img.shields.io/scrutinizer/g/vuongxuongminh/laravel-view-localization.svg?style=flat-square" alt="Quantity score"></a>
    <a href="https://styleci.io/repos/193444361"><img src="https://styleci.io/repos/193444361/shield?branch=master" alt="StyleCI"></a>
    <a href="https://packagist.org/packages/vxm/laravel-view-localization"><img src="https://img.shields.io/packagist/dt/vxm/laravel-view-localization.svg?style=flat-square" alt="Total download"></a>
    <a href="https://packagist.org/packages/vxm/laravel-view-localization"><img src="https://img.shields.io/packagist/l/vxm/laravel-view-localization.svg?style=flat-square" alt="License"></a>
    </p>
</p>

## About it

A package support you dynamic render view by user locale for Laravel application.

## Installation

Require Laravel View Localization using [Composer](https://getcomposer.org):

```bash
composer require vxm/laravel-view-localization
```

You need to publish the config-file with:

```php
php artisan vendor:publish --provider="VXM\ViewLocalization\ViewLocalizationServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
    /**
     * Your source language locale.
     */
    'sourceLocale' => 'en',
];
```

## Usage

It is a way to replace a set of views with another by user locale without the need of touching the original view rendering code. 
You can use it to systematically change the look and feel of an application depend on user locale. 
For example, when call `view('about')`, you will be rendering the view file `resources/views/about.blade.php`, if user locale is `vi`, the view file `resources/views/vi/about.blade.php` will be rendered, instead.

>Note: If the application locale is the same as source locale original view will be rendered regardless of presence of translated view.

The package will automatically register itself. Now your application can dynamic render view by user locale.

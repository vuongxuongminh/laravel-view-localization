<?php
/**
 * @link https://github.com/vuongxuongminh/laravel-view-localization
 *
 * @copyright (c) Vuong Xuong Minh
 * @license [MIT](https://opensource.org/licenses/MIT)
 */

namespace VXM\ViewLocalization\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use VXM\ViewLocalization\ViewLocalizationServiceProvider;

/**
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since  1.0.0
 */
class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ViewLocalizationServiceProvider::class,
        ];
    }
}

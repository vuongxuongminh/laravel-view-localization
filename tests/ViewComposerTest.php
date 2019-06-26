<?php
/**
 * @link https://github.com/vuongxuongminh/laravel-view-localization
 *
 * @copyright (c) Vuong Xuong Minh
 * @license [MIT](https://opensource.org/licenses/MIT)
 */

namespace VXM\ViewLocalization\Tests;

/**
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since  1.0.0
 */
class ViewComposerTest extends TestCase
{
    protected function getEnvironmentSetUp($application): void
    {
        $application['view']->getFinder()->addLocation(__DIR__.'/resources/views');
    }

    public function testCanRenderView()
    {
        $result = (string) $this->app['view']->make('test2');
        $this->assertContains('test2 view en', $result);
    }

    public function testCanReplaceView()
    {
        $this->app->setLocale('vi');
        $result = (string) $this->app['view']->make('test');
        $this->assertContains('test view vi', $result);
    }

    public function testCanRenderViewWhenSourceLocaleSameWithAppLocale()
    {
        $this->app->setLocale('en');
        $result = (string) $this->app['view']->make('test');
        $this->assertContains('test view en', $result);
    }

    public function testCanRenderViewFile()
    {
        $result = (string) $this->app['view']->file(__DIR__.'/resources/views/test2.blade.php');
        $this->assertContains('test2 view en', $result);
    }

    public function testCanReplaceViewFile()
    {
        $this->app->setLocale('vi');
        $result = (string) $this->app['view']->file(__DIR__.'/resources/views/test.blade.php');
        $this->assertContains('test view vi', $result);
    }

    public function testCanRenderViewWhenSourceLocaleSameWithAppLocaleFile()
    {
        $this->app->setLocale('en');
        $result = (string) $this->app['view']->file(__DIR__.'/resources/views/test.blade.php');
        $this->assertContains('test view en', $result);
    }
}

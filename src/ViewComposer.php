<?php
/**
 * @link https://github.com/vuongxuongminh/laravel-view-localization
 *
 * @copyright (c) Vuong Xuong Minh
 * @license [MIT](https://opensource.org/licenses/MIT)
 */

namespace VXM\ViewLocalization;

use Illuminate\View\View;
use InvalidArgumentException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Foundation\Application;

/**
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since  1.0.0
 */
class ViewComposer
{
    /**
     * Views compose locale by this app locale.
     *
     * @var Application
     */
    protected $app;

    /**
     * Application source locale.
     *
     * @var string
     */
    protected $sourceLocale;

    /**
     * File system use to searching view path.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * View path locale resolved.
     *
     * @var array|string[]
     */
    protected $resolvedPaths = [];

    /**
     * Create new ViewComposer instance.
     *
     * @param  Application  $app
     * @param  string  $sourceLocale
     * @param  Filesystem  $files
     */
    public function __construct(Application $app, string $sourceLocale, Filesystem $files)
    {
        $this->app = $app;
        $this->sourceLocale = $sourceLocale;
        $this->files = $files;
    }

    /**
     * Compose given View instance.
     *
     * @param  View  $view
     */
    public function compose(View $view): void
    {
        $path = $view->getPath();
        $appLocale = $this->app->getLocale();

        if (isset($this->resolvedPaths[$appLocale][$path])) {
            $resolvedPath = $this->resolvedPaths[$appLocale][$path];
        } else {
            $resolvedPath = $this->resolvePath($view);
        }

        if ($resolvedPath) {
            $view->setPath(
                $this->resolvedPaths[$appLocale][$path] = $resolvedPath
            );
        } else {
            $this->resolvedPaths[$appLocale][$path] = false;
        }
    }

    /**
     * Resolve path by user locale.
     *
     * The searching is based on the specified language code. In particular,
     * a file with the same name will be looked for under the subdirectory
     * whose name is the same as the language code. For example, given the file "path/to/view.php"
     * and language code "zh-CN", the localized file will be looked for as
     * "path/to/zh-CN/view.php". If the file is not found, it will try a fallback with just a language code that is
     * "zh" i.e. "path/to/zh/view.php". If it is not found as well the original file will be returned.
     *
     * The implementation of this method referenced FileHelper in Yii2 Framework.
     *
     * @param  View  $view
     * @return string|null
     */
    protected function resolvePath(View $view): ?string
    {
        $appLocale = $this->app->getLocale();

        if ($appLocale === $this->sourceLocale) {
            return null;
        }

        if ($path = $this->findSubPath($view, $appLocale)) {
            return $path;
        }

        $appLocale = substr($appLocale, 0, 2);

        if ($appLocale === $this->sourceLocale) {
            return null;
        }

        return $this->findSubPath($view, $appLocale);
    }

    /**
     * Find sub path.
     *
     * @param  View  $view
     * @param  string  $subDir
     * @return string|null
     */
    protected function findSubPath(View $view, string $subDir): ?string
    {
        if ($view->getName() !== $view->getPath()) {
            return $this->findSubViewPath($view, $subDir);
        } else {
            return $this->findSubNativePath($view, $subDir);
        }
    }

    /**
     * Find sub view path.
     *
     * @param  View  $view
     * @param  string  $subDir
     * @return string|null
     */
    protected function findSubViewPath(View $view, string $subDir): ?string
    {
        $rawPath = str_replace('.', '/', $view->getName());
        $base = $this->files->dirname($rawPath);
        $name = $this->files->name($rawPath);
        $path = ltrim($base.'.'.$subDir.'.'.$name, '.');
        $factory = $view->getFactory();

        try {
            $path = $factory->getFinder()->find($path);
        } catch (InvalidArgumentException $exception) {
            return null;
        }

        if ($view->getEngine() === $factory->getEngineFromPath($path)) {
            return $path;
        }

        return null;
    }

    /**
     * Find sub native path.
     *
     * @param  View  $view
     * @param  string  $subDir
     * @return string|null
     */
    protected function findSubNativePath(View $view, string $subDir): ?string
    {
        $path = $view->getPath();
        $dirname = $this->files->dirname($path);
        $basename = $this->files->basename($path);

        if ($this->files->exists($path = $dirname.'/'.$subDir.'/'.$basename)) {
            return $path;
        }

        return null;
    }
}

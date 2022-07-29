# Modules-Inertia

[![Latest Version on Packagist](https://img.shields.io/packagist/v/dongrim/modules-inertia.svg?style=flat-square)](https://packagist.org/packages/dongrim/modules-inertia)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)


The package is designed to be used by Vue/InertiaJs in conjunction with [Laravel-Modules](https://github.com/nWidart/laravel-modules)


## Laravel compatibility

 Laravel      | modules-inertia
:-------------|:----------
 6.0-9.x (PHP 7.1 required) | 0.0.x

## Installation

**Install the package via composer.**

```bash
composer require dongrim/modules-inertia
```

## Config Files

**In order to edit the default configuration you may execute:**

```
php artisan vendor:publish --provider="Dongrim\ModulesInertia\ModulesInertiaServiceProvider"
```

## Autoloading
**By default, the module classes are not loaded automatically. You can autoload your modules using psr-4.**
**For example:**
```json
{
  "autoload": {
    "psr-4": {
      "App\\": "app/",
      "Modules\\": "modules/",
      "Database\\Factories\\": "database/factories/",
      "Database\\Seeders\\": "database/seeders/"
  }

}
```
**Tip: don't forget to run `composer dump-autoload` afterwards.**




## Routing

**Module routes must contain middleware in your App\Http\Kernel, as the last item in your web middleware group.**

```php

'web' => [
    // ...
    \App\Http\Middleware\HandleInertiaRequests::class,
],

```
## Usage

**By default, Vue module files are created in the module directory Resources/Pages**

**You can change the default directory in config/modules.php**

```php
 'Pages/Index' => 'Resources/Pages/Index.vue',
 //...
 'source' => 'Resources/Pages',
```

### On Controller

**The default value of Inertia::render() in a module has been changed to Inertia::module().**

**Inertia::render() is still available by default. It can be used outside of modules**

**For example:**

```php
    public function index()
    {
        return Inertia::module('module::file');
        //or
        return Inertia::module('module::file', ['data'=>'some data']);
        //or
        return Inertia::module('module::directory.file', ['data'=>'some data']);
        //...
    }
```
### On Vue

**For example**

```js
import Vue from "vue";
import { createInertiaApp, Link } from "@inertiajs/inertia-vue";

createInertiaApp({
    resolve: (name) => {
        let page = null;

        let isModule = name.split("::");
        if (isModule.length > 1) {
            let moduleName = isModule[0];
            let pathToFile = isModule[1];
            //@modules is alias to module folder or examle ../../modules
            page = require(`@modules/${moduleName}/${pathToFile}.vue`);
        } else {
            page = require(`./Pages/${name}`);
        }

        return page.default;
    },
    setup({ el, App, props, plugin }) {
        Vue.use(plugin);
       
        new Vue({
            render: (h) => h(App, props),
        }).$mount(el);
    },
});
```


## After create module

**To be VueJS able to find the created module, you need to rebuild the script**

```bash
npm run dev
```


## Documentation

You'll find installation instructions and full documentation on [https://docs.laravelmodules.com/](https://docs.laravelmodules.com/).


## Authors
- [Nicolas Widart](https://github.com/nWidart/)
- [Yaroslav Fedan](https://github.com/YaroslavFedan/)
- Add your clickable username here. It should point to your GitHub account. 

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
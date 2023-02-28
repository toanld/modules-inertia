# Modules-Inertia

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

The package is designed to be used by Vue/InertiaJs in conjunction with [Laravel-Modules](https://github.com/nWidart/laravel-modules)


## Laravel compatibility

 Laravel      | modules-inertia
:-------------|:----------
 6.0-10.x     | 0.0.x

## Installation

**Install the package via composer.**

```bash
composer require toanld/modules-inertia
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
      "Modules\\": "Modules/",
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

### For use in Controller

**The default value of Inertia::render() in a module has been changed to Inertia::module().**

**Inertia::render() is still available by default. It can be used outside of modules**

- `module_name` - real name of the current module
- `file_name` - real name of the file (no extension .vue)
- `directory_name` -  if you have nested display folder structure ( you can specify the file path separating by a dot )

**For example:**

```php
    public function some_method()
    {
        return Inertia::module('module_name::file_name');
        //
        return Inertia::module('module_name::file_name', ['data'=>'some data']);
        //
        return Inertia::module('module_name::directory_name.file_name', ['data'=>'some data']);
    }
```

### If you use Vue version 2 


```javascript
import Vue from "vue";
import { createInertiaApp, Link } from "@inertiajs/inertia-vue";

createInertiaApp({
    resolve: (name) => {
        let page = null;

        let isModule = name.split("::");
        if (isModule.length > 1) {
            let moduleName = isModule[0];
            let pathToFile = isModule[1];
            // @modules is an alias of the module folder or just specify the path 
            // from the root directory to the folder modules             
            // for example ../../modules
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


### If you use Vue version 3


```javascript
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";

createInertiaApp({
    resolve: (name) => {
        let page = null;

        let isModule = name.split("::");
        if (isModule.length > 1) {
            let module = isModule[0];
            let pathTo = isModule[1];
            // @modules is an alias of the module folder or just specify the path 
            // from the root directory to the folder modules             
            // for example ../../modules
            page = require(`@modules/${moduleName}/${pathToFile}.vue`);
        } else {
            page = require(`./Pages/${name}`);
        }
        //...
        return page.default;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
});

```

## Aliases

**For the convenience of specifying the path from the root directory to the module directory, you can add alias in webpack.mix.js**

```javascript
const path = require('path')

mix.webpackConfig((webpack) => {
  return {
    resolve: {
       alias: {
         "@modules": path.resolve(__dirname + "/modules"),
       },
    },
  };
});

```

**For the convenience of specifying the path from the root directory to the module directory, you can add alias in vite.config.js**

```javascript
const path = require('path')

export default defineConfig({
  resolve:{
    alias:{
      '@modules' : path.resolve(__dirname + '/modules')
    },
  }
})

```

## Console command

**You can run `php artisan module:publish-stubs` to publish stubs.**

**And override the generation of default files**


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

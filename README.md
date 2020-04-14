# elephantpink-events
 
## Install package

```
 composer require elephantpink/events 
```

## Database: migrations and seeders

```
 php artisan vendor:publish --tag=epink-events-migrations
```

After this, you'll find the migrations under the main database/migrations folder.

In order to create the required tables run:

```
 php artisan migrate
```

If you want sample data on the database run:

```
 php artisan db:seed --class=EventSeeder
```

## Frontend

In order to use these components you'll need to install the following node packages:

To do so execute:

```
 npm install lang.js laravel-mix-svg-vue svg-vue vue vue-template-compiler vue-router vuex
```


You can use directly the components from the vendor folder, or if you need to customize them, simply publish them to the resource folder:

```
 php artisan vendor:publish --tag=epink-events-assets 
```

This will create two separate "events" folders under resources/js and resources/sass.

#### Router import example:

```
import eventsAdminRoutes from './events/router'

let routes = [other routes]

routes = routes.concat(eventsAdminRoutes [, other router files ])

const router = new VueRouter({ 
  routes: routes 
})
```

#### Store import example:

```
import Vue from 'vue'
import Vuex from 'vuex'
import eventsStore from './events/store'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    events: eventsStore,
  },
  ...
})
```

#### Translations import example:

```
import Lang from 'lang.js';
import eventsTranslations from './events/translations'

let lang = new Lang();
let fullTranslations = Object.assign({}, eventsTranslations [, other translation files ])
lang.setMessages(fullTranslations)
```

#### Icons

In order to use the svg-vue icons you should add the `laravel-mix-svg-vue` modify your webpack.mix.js file so it has the following content:

```
const mix = require('laravel-mix');
require('laravel-mix-svg-vue');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .svgVue()
```

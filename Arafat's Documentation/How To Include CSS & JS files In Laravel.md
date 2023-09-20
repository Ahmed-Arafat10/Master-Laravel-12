- we can store `css` & `js` files in `public` folder, and then include them
  in view using `asset('css/file.css)` or `asset('js/file.js)`

- Another and better is to use Laravel Mix, it is used to compile `css` and `js` files to improve performance
- First install Laravel Mix

````
npm install laravel-mix --save-dev
````

- Now all `css` & `js` files will be stored in `resources` file
- You have to include them in `app.css` and `app.js` like this:

````css
@import url('home/style.css');
````

> the folder is stored in `resources/css/home/style.css`, you are just importing it and any other css file in the
> project

- Now to be able to use it first run :

````
npm run dev
````

- Then in any `view` just add `@vite('resources/css/app.css')`, it will now work with you


- The problem here that in production (AWS EC2), `npm run dev` is not recommended as it holds the terminal
- To build the css and js files in production type

````
vite build
````

> this will add `build/assets/` folder into your `public`

- Anyone can use now in any `view` without running `npm run dev`:

````php
<link rel="stylesheet" href="{{asset('build/assets/app-76886d0c.css')}}"
````

Or

````
@vite('resources/css/app.css')
````

- In external css file:
````php
background-image: url("/public/images/doctor.png");
````


### temp

````
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import imagetools from 'vite-imagetools';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        imagetools.imagetools({
            force: true,
            name: '[name].[ext]',
            sizes: { small: 320, medium: 640, large: 1024 },
            quality: { webp: 75, jpg: 80 ,png:80},
            outputDir: 'public/build/assets/images',
        }),
    ],
});

````
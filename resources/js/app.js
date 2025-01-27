import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';


import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    progress: {
      color: '#4B5563',
    },
   // resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    // resolve: name => {
    //   const pages = import.meta.glob('./Pages/**/*.vue')
    //   return pages[`./Pages/${name}.vue`]()
    // },
    setup({ el, App, props, plugin }) {
      return createApp({ render: () => h(App, props) })
        .use(plugin)
        .mixin({ methods: { route } })
        .mount(el)
    },
  });

//InertiaProgress.init({ color: '#4B5563' });

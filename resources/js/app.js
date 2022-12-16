import "./bootstrap"
import "../css/app.css"

import {createInertiaApp, App} from '@inertiajs/inertia-svelte'
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers'
import {InertiaProgress} from '@inertiajs/progress'

createInertiaApp({
  resolve: (name) => resolvePageComponent(`./Pages/${name}.svelte`, import.meta.glob('./Pages/**/*.svelte')),
  setup({el, App, props}) {
    new App({target: el, props})
  },
})

InertiaProgress.init({
  color: '#5046e5',
  showSpinner: true,
})

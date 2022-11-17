import "./bootstrap"
import "../css/app.css"

import { createInertiaApp } from '@inertiajs/inertia-svelte'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import {user} from "./Stores/auth";

createInertiaApp({
    resolve: (name) => resolvePageComponent(`./Pages/${name}.svelte`, import.meta.glob('./Pages/**/*.svelte')),
    setup({ el, App, props }) {
        user.set(props.initialPage.props.auth.user)
        new App({ target: el, props })
    },
})

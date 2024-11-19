import './bootstrap';
import '/@src/styles'
import 'iconify-icon'

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, DefineComponent, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { createHead } from '@unhead/vue'
import { InferSeoMetaPlugin } from '@unhead/addons'
import { createPinia } from 'pinia'
import { createRouter } from '/@src/router'
import Layout from '/@src/layouts/sidebar.vue'
import AuthLayout from '/@src/components/layouts/auth/AuthLayout.vue'
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const plugins = import.meta.glob<{ default?: any }>('./plugins/*.ts', {
    eager: true,
})

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const page = resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./pages/**/*.vue'),
        )

        page
            .then((module) => {
                if (name.startsWith("auth/")) {
                    module.default.layout = AuthLayout;
                } else {
                    module.default.layout = module.default.layout || Layout;
                }
            })
            .catch((error) => {
                console.log(error);
            });

        return page;
    },
    async setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
        const router = createRouter()
        const pinia = createPinia()
        const head = createHead({
            plugins: [InferSeoMetaPlugin()],
        })

        const vuero = {
            app,
            router,
            head,
            pinia
        }

        for (const path in plugins) {
            try {
                const plugin = plugins[path]?.default
                if (!plugin) throw new Error(`Plugin does not have a default export.`)
                await plugin(vuero)
            }
            catch (error) {
                console.log(`Error while loading plugin "${path}"`)
                console.error(error)
            }
        }

        app.config.globalProperties.$route = route

        app.use(head)
        app.use(pinia)
        app.use(plugin)
        app.use(ZiggyVue)
        app.use(vuero.router)
        app.mixin({ methods: { $route: route } })
        app.mount(el)
    },
    progress: {
        color: '#4B5563',
    },
});

import "../css/main.css";
import "aos/dist/aos.css";

import { createPinia } from "pinia";
import { useDarkModeStore } from "@/Stores/darkMode.js";
import { darkModeKey } from "@/config.js";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import BaseDivider from "@/Components/BaseDivider.vue";
import FormDatePicker from "@/Components/FormDatePicker.vue";

import "vue-toastification/dist/index.css";
import "sweetalert2/dist/sweetalert2.min.css";

import Toast, { TYPE } from "vue-toastification";

import { createI18n } from "vue-i18n";
import generalLangBg from "@/Lang/bg/general_lang_bg";
import generalLangDe from "@/Lang/de/general_lang_de";
import generalLangEn from "@/Lang/en/general_lang_en";
import generalLangFr from "@/Lang/fr/general_lang_fr";
import generalLangRu from "@/Lang/ru/general_lang_ru";
import generalLangTr from "@/Lang/tr/general_lang_tr";
import generalLangZh from "@/Lang/zh/general_lang_zh";

const i18n = createI18n({
    legacy: false,
    locale: "en",
    fallbackLocale: "en",
    fallbackRoot: "en",
    messages: {
        bg: generalLangBg,
        de: generalLangDe,
        en: generalLangEn,
        fr: generalLangFr,
        ru: generalLangRu,
        tr: generalLangTr,
        zh: generalLangZh,
    },
});

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

const toastOptions = {
    toastDefaults: {
        // ToastOptions object for each type of toast
        [TYPE.ERROR]: {
            timeout: 10000,
            closeButton: false,
        },
        [TYPE.SUCCESS]: {
            timeout: 3000,
            hideProgressBar: true,
        },
    },
    position: "top-center",
    timeout: 5000,
    closeOnClick: true,
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
    showCloseButtonOnHover: true,
    hideProgressBar: true,
    closeButton: "button",
    icon: true,
    rtl: false,
    transition: "Vue-Toastification__fade",
    maxToasts: 20,
    newestOnTop: true,
    filterBeforeCreate: (toast, toasts) => {
        if (toasts.filter((t) => t.type === toast.type).length !== 0) {
            // Returning false discards the toast
            return false;
        }
        // You can modify the toast if you want
        return toast;
    },
};
const pinia = createPinia();

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(i18n)
            .use(plugin)
            .use(pinia)
            .use(Toast, toastOptions)
            .component("DatePicker", FormDatePicker)
            .component("BaseDivider", BaseDivider)
            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
    progress: {
        // color: "#4B5563",
        // The delay after which the progress bar will appear, in milliseconds...
        delay: 250,
        // The color of the progress bar...
        color: "#29d",
        // Whether to include the default NProgress styles...
        includeCSS: true,
        // Whether the NProgress spinner will be shown...
        showSpinner: true,
    },
});

const darkModeStore = useDarkModeStore(pinia);

/* Dark mode */
if (
    (!localStorage[darkModeKey] &&
        window.matchMedia("(prefers-color-scheme: dark)").matches) ||
    localStorage[darkModeKey] === "1"
) {
    darkModeStore.set(false);
}

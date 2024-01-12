/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require("./bootstrap");

window.Vue = require("vue").default;

// ELMENT IO
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import locale from "element-ui/lib/locale/lang/es";
import { Loading } from "element-ui";
window.Loading = Loading;
window.Vue.use(ElementUI, { locale });

// BOOSTRAP VUE
import { BootstrapVue, IconsPlugin } from "bootstrap-vue";
import "bootstrap-vue/dist/bootstrap-vue.css";
// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);

// SWEETALERT2
// ES6 Modules or TypeScript
import Swal from "sweetalert2";
window.Swal = Swal;

// HIGH CHARTS
var Highcharts = require("highcharts");
require("highcharts/modules/exporting")(Highcharts);
window.Highcharts = Highcharts;
window.Highcharts.setOptions({
    lang: {
        loading: "Cargando...",
        months: [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre",
        ],
        weekdays: [
            "Domingo",
            "Segunda",
            "Terça",
            "Quarta",
            "Quinta",
            "Sexta",
            "Sábado",
        ],
        shortMonths: [
            "Ene",
            "Feb",
            "Mar",
            "Abr",
            "May",
            "Jun",
            "Jul",
            "Ago",
            "Sep",
            "Oct",
            "Nov",
            "Dic",
        ],
        exportButtonTitle: "Exportar",
        printButtonTitle: "Imprimir",
        rangeSelectorFrom: "De",
        rangeSelectorTo: "Al",
        rangeSelectorZoom: "Periodo",
        downloadPNG: "Descargar imagen PNG",
        downloadJPEG: "Descargar imagen JPEG",
        downloadPDF: "Descargar documento PDF",
        downloadSVG: "Descargar imagen SVG",
        viewFullscreen: "Pantalla completa",
        printChart: "Imprimir",
        // resetZoom: "Reset",
        // resetZoomTitle: "Reset,
        // thousandsSep: ".",
        // decimalPoint: ','
    },
});
// MOMENT
import moment from "moment";
moment.locale("es");
Vue.prototype.$moment = moment;

// EVENT BUS
export const EventBus = new Vue();
window.EventBus = EventBus;

// ARCHIVO GLOBAL DE FUNCIONES
import globalMixin from "./globalMixin.js";

Vue.mixin(globalMixin);

// COMPONENTES
Vue.component("App", require("./App.vue").default);
Vue.component("Auth", require("./Auth.vue").default);
import router from "./routes";
const app = new Vue({
    el: "#app",
    router,
});

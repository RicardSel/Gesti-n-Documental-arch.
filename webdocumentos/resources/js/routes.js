import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

export default new Router({
    base: "/" + app_base,
    routes: [
        // INICIO
        {
            path: "/",
            name: "inicio",
            component: require("./components/Inicio.vue").default,
        },

        // LOGIN
        {
            path: "/login",
            name: "login",
            component: require("./Auth.vue").default,
        },

        // Usuarios
        {
            path: "/usuarios/perfil/:id",
            name: "usuarios.perfil",
            component: require("./components/modulos/usuarios/perfil.vue")
                .default,
            props: true,
        },
        {
            path: "/usuarios",
            name: "usuarios.index",
            component: require("./components/modulos/usuarios/index.vue")
                .default,
        },

        // Funcionarios
        {
            path: "/funcionarios",
            name: "funcionarios.index",
            component: require("./components/modulos/funcionarios/index.vue")
                .default,
        },

        // Depdendencias
        {
            path: "/dependencias",
            name: "dependencias.index",
            component: require("./components/modulos/dependencias/index.vue")
                .default,
        },

        // Oficinas
        {
            path: "/oficinas",
            name: "oficinas.index",
            component: require("./components/modulos/oficinas/index.vue")
                .default,
        },

        // Estantes
        {
            path: "/estantes",
            name: "estantes.index",
            component: require("./components/modulos/estantes/index.vue")
                .default,
        },

        // Documentos
        {
            path: "/documentos",
            name: "documentos.index",
            component: require("./components/modulos/documentos/index.vue")
                .default,
        },

        // Reserva de Documentos
        {
            path: "/reserva_documentos",
            name: "reserva_documentos.index",
            component:
                require("./components/modulos/reserva_documentos/index.vue")
                    .default,
        },

        // Prestamo de Documentos
        {
            path: "/prestamo_documentos",
            name: "prestamo_documentos.index",
            component:
                require("./components/modulos/prestamo_documentos/index.vue")
                    .default,
        },

        // Devolucion de Documentos
        {
            path: "/devolucion_documentos",
            name: "devolucion_documentos.index",
            component:
                require("./components/modulos/devolucion_documentos/index.vue")
                    .default,
        },

        // Configuración
        {
            path: "/configuracion",
            name: "configuracion",
            component: require("./components/modulos/configuracion/index.vue")
                .default,
            props: true,
        },

        // Reportes
        {
            path: "/reportes/usuarios",
            name: "reportes.usuarios",
            component: require("./components/modulos/reportes/usuarios.vue")
                .default,
            props: true,
        },
        {
            path: "/reportes/documentos",
            name: "reportes.documentos",
            component: require("./components/modulos/reportes/documentos.vue")
                .default,
            props: true,
        },
        {
            path: "/reportes/documentos_estados",
            name: "reportes.documentos_estados",
            component: require("./components/modulos/reportes/documentos_estados.vue")
                .default,
            props: true,
        },
        {
            path: "/reportes/cantidad_documentos",
            name: "reportes.cantidad_documentos",
            component: require("./components/modulos/reportes/cantidad_documentos.vue")
                .default,
            props: true,
        },

        // PÁGINA NO ENCONTRADA
        {
            path: "*",
            component: require("./components/modulos/errors/404.vue").default,
        },
    ],
    mode: "history",
    linkActiveClass: "active open",
});

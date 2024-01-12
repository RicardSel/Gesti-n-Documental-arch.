<template>
    <div class="wrapper">
        <NavBar :ruta="ruta"></NavBar>
        <SideBar
            :ruta="ruta"
            :configuracion="oConfiguracion"
            :user_sidebar="oUser"
        ></SideBar>
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
        <Footer :configuracion="oConfiguracion"></Footer>
        <!-- <Control></Control> -->
    </div>
</template>

<script>
import NavBar from "./plantilla/NavBar.vue";
import SideBar from "./plantilla/SideBar.vue";
import Content from "./plantilla/Content.vue";
import Footer from "./plantilla/Footer.vue";
import Control from "./plantilla/Control.vue";
export default {
    components: {
        NavBar,
        SideBar,
        Footer,
        Control,
        Content,
    },
    props: ["user", "configuracion", "ruta"],
    data() {
        return {
            oUser: this.user,
            oConfiguracion: this.configuracion,
        };
    },
    mounted() {
        EventBus.$on("usuario_actualizado", (data) => {
            this.oUser = data;
        });
        // ALMACENA CONFIGURACIÓN
        this.convierteProps();
        EventBus.$on("configuracionActualizada", (data) => {
            this.oConfiguracion = JSON.parse(data);
            localStorage.setItem("configuracion", data);
        });
    },
    methods: {
        convierteProps() {
            this.oUser = JSON.parse(this.oUser);
            this.oConfiguracion = JSON.parse(this.oConfiguracion);
        },
    },
};
</script>

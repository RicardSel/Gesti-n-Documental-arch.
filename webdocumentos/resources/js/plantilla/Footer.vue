<template>
    <div>
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Versión</b> 1.0.0
            </div>
            <strong
                >Copyright &copy; {{ fechaActual }}
                <router-link :to="{ name: 'inicio' }" class="text-danger">{{
                    configuracion.alias
                }}</router-link
                >.</strong
            >
            Todos los derechos reservados.
        </footer>
    </div>
</template>

<script>
export default {
    props: ["configuracion"],
    computed: {
        fechaActual() {
            return this.$moment(String(new Date())).format("YYYY");
        },
    },
};
</script>

<style></style>

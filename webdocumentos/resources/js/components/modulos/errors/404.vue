<template>
    <section class="sec-blog bg0 p-t-60 p-b-90 contenedor_actividades">
        <div class="container">
            <div class="p-b-66">
                <h2 class="ltext-105 cl5 txt-center respon1">
                    404 - Página no encontrada
                </h2>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h3>
                        <i class="fas fa-exclamation-triangle text-warning"></i>
                        Oops! Página no encontrada.
                    </h3>
                    <p>
                        No pudimos encontrar la página que estabas buscando.
                        Mientras tanto, puede volver a la página de inicio.
                        <router-link :to="{ name: 'portal.inicio' }"
                            >Volver al inicio</router-link
                        >
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {};
</script>

<style></style>

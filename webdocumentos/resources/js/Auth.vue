<template>
    <div class="login-page">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card border border-success">
                <div class="card-header text-center">
                    <img :src="logo" alt="Logo" />
                    <router-link
                        :to="{ name: 'login' }"
                        class="h1 text-white text-xl"
                        ><b v-text="empresa"></b
                    ></router-link>
                </div>
                <div class="card-body">
                    <p class="login-box-msg text-white font-weight-bold">
                        Ingresa tu usuario y contraseña para inicar sesión
                    </p>

                    <div>
                        <div class="input-group mb-3">
                            <input
                                type="email"
                                class="form-control"
                                placeholder="Usuario"
                                v-model="usuario"
                                @keypress.enter="login()"
                                autofocus
                            />
                            <div class="input-group-append">
                                <div class="input-group-text bg-danger">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input
                                type="password"
                                class="form-control"
                                placeholder="Contraseña"
                                v-model="password"
                                @keypress.enter="login()"
                            />
                            <div class="input-group-append">
                                <div class="input-group-text bg-danger">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-if="error">
                            <div class="col-12">
                                <div class="callout callout-danger">
                                    <h5>¡Error!</h5>
                                    <p>
                                        El usuario o contraseña son incorrectos
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-12">
                                <button
                                    type="button"
                                    class="btn btn-danger btn-block btn-flat font-weight-bold"
                                    @click.prevent="login()"
                                    v-loading.fullscreen.lock="
                                        fullscreenLoading
                                    "
                                >
                                    <i class="fa fa-sign-in-alt"></i> Acceder
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        empresa: { String, default: "Nombre Empresa" },
        logo: {
            String,
            default:
                "https://www.logodesign.net/logo/eye-and-house-5806ld.png?size=2&industry=All",
        },
        configuracion: {
            String,
            default: "",
        },
        url_portal: {
            String,
            default: "/registro",
        },
    },
    data() {
        return {
            usuario: "",
            password: "",
            error: false,
            fullscreenLoading: false,
        };
    },
    methods: {
        login() {
            this.fullscreenLoading = true;
            axios
                .post(main_url + "/login", {
                    usuario: this.usuario,
                    password: this.password,
                })
                .then((res) => {
                    let user = res.data.user;
                    setTimeout(() => {
                        this.obtienePermisos(user);
                    }, 50);
                })
                .catch((error) => {
                    this.error = true;
                    this.password = "";
                    this.fullscreenLoading = false;
                    console.log(error.response);
                    if (error.response.data.message) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            html: error.response.data.message,
                            showConfirmButton: false,
                            timer: 4000,
                        });
                    }
                });
        },
        obtienePermisos(user) {
            axios
                .get(main_url + "/admin/usuarios/getPermisos/" + user.id)
                .then((res) => {
                    this.error = false;
                    this.$router.push({ name: "inicio" });
                    localStorage.setItem("configuracion", this.configuracion);
                    localStorage.setItem("permisos", JSON.stringify(res.data));
                    localStorage.setItem("user", JSON.stringify(user));
                    location.reload();
                });
        },
    },
};
</script>

<style>
.login-page {
    background: var(--principal_transparent);
}

.login-page .card {
    border-radius: 0px;
    box-shadow: 0px 0px 1px 1px var(--red);
    background: var(--principal);
}
.login-page .card-header {
    border-bottom: solid 1px var(--red);
}
</style>

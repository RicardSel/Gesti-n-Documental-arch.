import axios from "axios";

export default {
    methods: {
        getFormatoFecha(date) {
            if (date) {
                return this.$moment(String(date)).format("DD/MM/YYYY");
            }
            return "";
        },
        getAnioActual() {
            return this.$moment().format("YYYY");
        },
        getFechaActual() {
            return this.$moment().format("YYYY-MM-DD");
        },
        getHoraActual() {
            return this.$moment().format("HH:mm");
        },
        getUsuariosTipo(tipo) {
            return new Promise((resolve, reject) => {
                axios
                    .get(main_url + "/admin/usuarios/getUsuarioTipo", {
                        params: {
                            tipo: tipo,
                        },
                    })
                    .then((response) => {
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
        getUsuarioById(id) {
            return new Promise((resolve, reject) => {
                axios
                    .get(main_url + "/admin/usuarios/getUsuario/" + id)
                    .then((response) => {
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
    },
};

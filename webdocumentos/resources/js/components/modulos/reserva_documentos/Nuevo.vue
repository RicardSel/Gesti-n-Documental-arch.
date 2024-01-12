<template>
    <div
        class="modal fade"
        :class="{ show: bModal }"
        id="modal-default"
        aria-modal="true"
        role="dialog"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                        @click="cierraModal"
                    >
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label
                                    :class="{
                                        'text-danger': errors.documento_id,
                                    }"
                                    >Seleccionar Documento*</label
                                >
                                <el-select
                                    placeholder="Seleccionar Documento"
                                    class="d-block"
                                    :class="{
                                        'is-invalid': errors.documento_id,
                                    }"
                                    v-model="reserva_documento.documento_id"
                                    filterable
                                    clearable
                                >
                                    <el-option
                                        v-for="item in listDocumentos"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="
                                            item.codigo +
                                            ' - ' +
                                            item.descripcion
                                        "
                                    ></el-option>
                                </el-select>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.documento_id"
                                    v-text="errors.documento_id[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label
                                    :class="{
                                        'text-danger': errors.funcionario_id,
                                    }"
                                    >Seleccionar Funcionario*</label
                                >
                                <el-select
                                    placeholder="Seleccionar Funcionario"
                                    class="d-block"
                                    :class="{
                                        'is-invalid': errors.funcionario_id,
                                    }"
                                    v-model="reserva_documento.funcionario_id"
                                    filterable
                                    clearable
                                >
                                    <el-option
                                        v-for="item in listFuncionarios"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="
                                            item.codigo + ' - ' + item.full_name
                                        "
                                    ></el-option>
                                </el-select>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.funcionario_id"
                                    v-text="errors.funcionario_id[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label
                                    :class="{
                                        'text-danger': errors.descripcion,
                                    }"
                                    >Descripción*</label
                                >
                                <el-input
                                    type="textarea"
                                    placeholder="Descripción"
                                    :class="{
                                        'is-invalid': errors.descripcion,
                                    }"
                                    v-model="reserva_documento.descripcion"
                                    autosize
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.descripcion"
                                    v-text="errors.descripcion[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label
                                    :class="{
                                        'text-danger': errors.observacion,
                                    }"
                                    >Observación*</label
                                >
                                <el-input
                                    type="textarea"
                                    placeholder="Observación"
                                    :class="{
                                        'is-invalid': errors.observacion,
                                    }"
                                    v-model="reserva_documento.observacion"
                                    autosize
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.observacion"
                                    v-text="errors.observacion[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.fecha,
                                    }"
                                    >Fecha*</label
                                >
                                <input
                                    type="date"
                                    placeholder="Fecha"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': errors.fecha,
                                    }"
                                    v-model="reserva_documento.fecha"
                                    clearable
                                />
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.fecha"
                                    v-text="errors.fecha[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.hora,
                                    }"
                                    >Hora*</label
                                >
                                <input
                                    type="time"
                                    placeholder="Hora"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': errors.hora,
                                    }"
                                    v-model="reserva_documento.hora"
                                    clearable
                                />
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.hora"
                                    v-text="errors.hora[0]"
                                ></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button
                        type="button"
                        class="btn btn-default"
                        data-dismiss="modal"
                        @click="cierraModal"
                    >
                        Cerrar
                    </button>
                    <el-button
                        type="danger"
                        class="bg-danger"
                        :loading="enviando"
                        @click="setRegistroModal()"
                        >{{ textoBoton }}</el-button
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        muestra_modal: {
            type: Boolean,
            default: false,
        },
        accion: {
            type: String,
            default: "nuevo",
        },
        reserva_documento: {
            type: Object,
            default: {
                documento_id: "",
                funcionario_id: "",
                descripcion: "",
                observacion: "",
                fecha: "",
                hora: "",
            },
        },
    },
    watch: {
        muestra_modal: function (newVal, oldVal) {
            this.errors = [];
            if (newVal) {
                this.getDocumentosArchivo();
                if (this.accion != "edit") {
                    this.reserva_documento.fecha = this.getFechaActual();
                    this.reserva_documento.hora = this.getHoraActual();
                }
                this.bModal = true;
            } else {
                this.bModal = false;
            }
        },
    },
    computed: {
        tituloModal() {
            if (this.accion == "nuevo") {
                return "AGREGAR RESERVA DE DOCUMENTO";
            } else {
                return "MODIFICAR REGISTRO";
            }
        },
        textoBoton() {
            if (this.accion == "nuevo") {
                return "Registrar";
            } else {
                return "Actualizar";
            }
        },
    },
    data() {
        return {
            user: JSON.parse(localStorage.getItem("user")),
            bModal: this.muestra_modal,
            enviando: false,
            listDocumentos: [],
            listFuncionarios: [],
            errors: [],
        };
    },
    mounted() {
        this.bModal = this.muestra_modal;
        this.getFuncionarios();
    },
    methods: {
        getDocumentosArchivo() {
            axios
                .get(main_url + "/admin/documentos/archivo")
                .then((response) => {
                    this.listDocumentos = response.data.documentos;
                    if (this.accion == "edit") {
                        setTimeout(() => {
                            this.listDocumentos.push(
                                this.reserva_documento.documento
                            );
                        }, 300);
                    }
                });
        },
        getFuncionarios() {
            axios.get(main_url + "/admin/funcionarios").then((response) => {
                this.listFuncionarios = response.data.funcionarios;
            });
        },
        setRegistroModal() {
            this.enviando = true;
            try {
                this.textoBtn = "Enviando...";
                let url = main_url + "/admin/reserva_documentos";
                let config = {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                };
                let formdata = new FormData();
                formdata.append(
                    "documento_id",
                    this.reserva_documento.documento_id
                        ? this.reserva_documento.documento_id
                        : ""
                );
                formdata.append(
                    "funcionario_id",
                    this.reserva_documento.funcionario_id
                        ? this.reserva_documento.funcionario_id
                        : ""
                );
                formdata.append(
                    "descripcion",
                    this.reserva_documento.descripcion
                        ? this.reserva_documento.descripcion
                        : ""
                );
                formdata.append(
                    "observacion",
                    this.reserva_documento.observacion
                        ? this.reserva_documento.observacion
                        : ""
                );
                formdata.append(
                    "fecha",
                    this.reserva_documento.fecha
                        ? this.reserva_documento.fecha
                        : ""
                );
                formdata.append(
                    "hora",
                    this.reserva_documento.hora
                        ? this.reserva_documento.hora
                        : ""
                );
                if (this.accion == "edit") {
                    url =
                        main_url +
                        "/admin/reserva_documentos/" +
                        this.reserva_documento.id;
                    formdata.append("_method", "PUT");
                }
                axios
                    .post(url, formdata, config)
                    .then((res) => {
                        this.enviando = false;
                        Swal.fire({
                            icon: "success",
                            title: res.data.msj,
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        this.limpiaReservaDocumento();
                        this.$emit("envioModal");
                        this.errors = [];
                        if (this.accion == "edit") {
                            this.textoBtn = "Actualizar";
                        } else {
                            this.textoBtn = "Registrar";
                        }
                    })
                    .catch((error) => {
                        this.enviando = false;
                        if (this.accion == "edit") {
                            this.textoBtn = "Actualizar";
                        } else {
                            this.textoBtn = "Registrar";
                        }
                        if (error.response) {
                            if (error.response.status === 422) {
                                this.errors = error.response.data.errors;
                            }
                            if (
                                error.response.status === 420 ||
                                error.response.status === 419 ||
                                error.response.status === 401
                            ) {
                                window.location = "/";
                            }
                            if (error.response.status === 500) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    html: error.response.data.message,
                                    showConfirmButton: false,
                                    timer: 2000,
                                });
                            }
                        }
                    });
            } catch (e) {
                this.enviando = false;
                console.log(e);
            }
        },
        cargaImagen(e) {
            this.reserva_documento.foto = e.target.files[0];
        },
        // Dialog/modal
        cierraModal() {
            this.bModal = false;
            this.$emit("close");
        },
        limpiaReservaDocumento() {
            this.errors = [];
            this.reserva_documento.documento_id = "";
            this.reserva_documento.funcionario_id = "";
            this.reserva_documento.descripcion = "";
            this.reserva_documento.observacion = "";
            this.reserva_documento.fecha = "";
            this.reserva_documento.hora = "";
        },
    },
};
</script>

<style></style>

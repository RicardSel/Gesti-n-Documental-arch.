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
                        <div class="row" v-show="!ver_prestamo">
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
                                    v-model="devolucion_documento.documento_id"
                                    filterable
                                    clearable
                                    @change="getFuncionarioPrestamo"
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
                            <div
                                class="col-md-12 text-center"
                                v-show="devolucion_documento.documento_id != ''"
                            >
                                <button
                                    type="button"
                                    class="btn"
                                    :class="[
                                        ver_prestamo
                                            ? 'btn-gray'
                                            : 'btn-primary',
                                    ]"
                                    v-html="txtBtnVerPrestamo"
                                    @click="ver_prestamo = !ver_prestamo"
                                ></button>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Funcionario*</label>
                                <el-input
                                    placeholder="Funcionario"
                                    :class="{
                                        'is-invalid': errors.funcionario_id,
                                    }"
                                    :value="nomFuncionario"
                                    readonly
                                >
                                </el-input>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger':
                                            errors.cantidad_documentos,
                                    }"
                                    >Cantidad de Documentos*</label
                                >
                                <input
                                    type="number"
                                    placeholder="Cantidad de Documentos"
                                    class="form-control"
                                    :class="{
                                        'is-invalid':
                                            errors.cantidad_documentos,
                                    }"
                                    v-model="
                                        devolucion_documento.cantidad_documentos
                                    "
                                    autosize
                                />
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.cantidad_documentos"
                                    v-text="errors.cantidad_documentos[0]"
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
                                    v-model="devolucion_documento.fecha"
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
                                    v-model="devolucion_documento.hora"
                                    clearable
                                />
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.hora"
                                    v-text="errors.hora[0]"
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
                                    v-model="devolucion_documento.descripcion"
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
                                    v-model="devolucion_documento.observacion"
                                    autosize
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.observacion"
                                    v-text="errors.observacion[0]"
                                ></span>
                            </div>
                        </div>
                        <div class="row" v-if="ver_prestamo">
                            <div
                                class="col-md-12 text-center"
                                v-show="devolucion_documento.documento_id != ''"
                            >
                                <button
                                    type="button"
                                    class="btn"
                                    :class="[
                                        ver_prestamo
                                            ? 'btn-secondary'
                                            : 'btn-primary',
                                    ]"
                                    v-html="txtBtnVerPrestamo"
                                    @click="ver_prestamo = !ver_prestamo"
                                ></button>
                            </div>
                            <div class="col-md-12">
                                <p>
                                    <strong>Código Documento: </strong>
                                    {{ prestamo_documento.documento.codigo }}
                                </p>
                                <p>
                                    <strong>Funcionario: </strong>
                                    {{
                                        prestamo_documento.funcionario.full_name
                                    }}
                                </p>
                                <p>
                                    <strong>Tipo de Documento: </strong>
                                    {{ prestamo_documento.tipo_documento }}
                                </p>
                                <p>
                                    <strong>Cantidad de Documentos: </strong>
                                    {{ prestamo_documento.cantidad_documentos }}
                                </p>
                                <p>
                                    <strong>Fecha: </strong>
                                    {{ prestamo_documento.fecha }}
                                </p>
                                <p>
                                    <strong>Hora: </strong>
                                    {{ prestamo_documento.hora }}
                                </p>
                                <p>
                                    <strong>Dependencia: </strong>
                                    {{ prestamo_documento.dependencia.nombre }}
                                </p>
                                <p>
                                    <strong>Descripción: </strong>
                                    {{ prestamo_documento.descripcion }}
                                </p>
                                <p>
                                    <strong>Observación: </strong>
                                    {{ prestamo_documento.observacion }}
                                </p>
                            </div>
                            <div
                                class="col-md-12 text-center"
                                v-show="devolucion_documento.documento_id != ''"
                            >
                                <button
                                    type="button"
                                    class="btn"
                                    :class="[
                                        ver_prestamo
                                            ? 'btn-secondary'
                                            : 'btn-primary',
                                    ]"
                                    @click="ver_prestamo = !ver_prestamo"
                                >
                                    <i class="fa fa-arrow-left"></i> Volver al
                                    formulario
                                </button>
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
        devolucion_documento: {
            type: Object,
            default: {
                documento_id: "",
                funcionario_id: "",
                cantidad_documentos: "",
                fecha: "",
                hora: "",
                descripcion: "",
                observacion: "",
                funcionario: null,
            },
        },
    },
    watch: {
        muestra_modal: function (newVal, oldVal) {
            this.errors = [];
            if (newVal) {
                this.funcionario = null;
                this.getDocumentosPrestado();
                if (this.accion != "edit") {
                    this.devolucion_documento.fecha = this.getFechaActual();
                    this.devolucion_documento.hora = this.getHoraActual();
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
                return "AGREGAR DEVOLUCIÓN DE DOCUMENTO";
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
        nomFuncionario() {
            if (this.funcionario) {
                return (
                    this.funcionario.codigo + " - " + this.funcionario.full_name
                );
            }
            return "";
        },
        txtBtnVerPrestamo() {
            if (this.ver_prestamo) {
                return `<i class="fa fa-eye-slash"></i> Ocultar préstamo`;
            }
            return `<i class="fa fa-eye"></i> Ver préstamo`;
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
            funcionario: null,
            prestamo_documento: null,
            ver_prestamo: false,
        };
    },
    mounted() {
        this.bModal = this.muestra_modal;
        this.getFuncionarioPrestamo();
    },
    methods: {
        getDocumentosPrestado() {
            axios
                .get(main_url + "/admin/documentos/prestado")
                .then((response) => {
                    this.listDocumentos = response.data.documentos;
                    if (this.accion == "edit") {
                        setTimeout(() => {
                            this.listDocumentos.push(
                                this.devolucion_documento.documento
                            );
                            this.getFuncionarioPrestamo();
                        }, 300);
                    }
                });
        },
        getFuncionarioPrestamo() {
            if (this.devolucion_documento.documento_id != "") {
                axios
                    .get(
                        main_url +
                            "/admin/prestamo_documentos/funcionario_prestamo",
                        {
                            params: {
                                documento_id:
                                    this.devolucion_documento.documento_id,
                            },
                        }
                    )
                    .then((response) => {
                        this.funcionario = response.data.funcionario;
                        this.prestamo_documento =
                            response.data.prestamo_documento;
                        setTimeout(() => {
                            this.devolucion_documento.funcionario_id =
                                this.funcionario.id;
                        }, 300);
                    });
            } else {
                this.devolucion_documento.funcionario_id = "";
                this.funcionario = null;
                this.prestamo_documento = null;
                this.ver_prestamo = false;
            }
        },
        setRegistroModal() {
            this.enviando = true;
            try {
                this.textoBtn = "Enviando...";
                let url = main_url + "/admin/devolucion_documentos";
                let config = {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                };
                let formdata = new FormData();
                formdata.append(
                    "documento_id",
                    this.devolucion_documento.documento_id
                        ? this.devolucion_documento.documento_id
                        : ""
                );
                formdata.append(
                    "funcionario_id",
                    this.devolucion_documento.funcionario_id
                        ? this.devolucion_documento.funcionario_id
                        : ""
                );
                formdata.append(
                    "cantidad_documentos",
                    this.devolucion_documento.cantidad_documentos
                        ? this.devolucion_documento.cantidad_documentos
                        : ""
                );
                formdata.append(
                    "fecha",
                    this.devolucion_documento.fecha
                        ? this.devolucion_documento.fecha
                        : ""
                );
                formdata.append(
                    "hora",
                    this.devolucion_documento.hora
                        ? this.devolucion_documento.hora
                        : ""
                );
                formdata.append(
                    "descripcion",
                    this.devolucion_documento.descripcion
                        ? this.devolucion_documento.descripcion
                        : ""
                );
                formdata.append(
                    "observacion",
                    this.devolucion_documento.observacion
                        ? this.devolucion_documento.observacion
                        : ""
                );
                if (this.accion == "edit") {
                    url =
                        main_url +
                        "/admin/devolucion_documentos/" +
                        this.devolucion_documento.id;
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
                        this.limpiaDevolucionDocumento();
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
            this.devolucion_documento.foto = e.target.files[0];
        },
        // Dialog/modal
        cierraModal() {
            this.bModal = false;
            this.$emit("close");
        },
        limpiaDevolucionDocumento() {
            this.errors = [];
            this.devolucion_documento.documento_id = "";
            this.devolucion_documento.funcionario_id = "";
            this.devolucion_documento.cantidad_documentos = "";
            this.devolucion_documento.fecha = "";
            this.devolucion_documento.hora = "";
            this.devolucion_documento.descripcion = "";
            this.devolucion_documento.observacion = "";
        },
    },
};
</script>

<style></style>

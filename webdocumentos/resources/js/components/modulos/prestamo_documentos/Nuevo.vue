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
                                    v-model="prestamo_documento.documento_id"
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
                                    v-model="prestamo_documento.funcionario_id"
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
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.tipo_documento,
                                    }"
                                    >Tipo de Documento*</label
                                >
                                <el-input
                                    placeholder="Tipo de Documento"
                                    :class="{
                                        'is-invalid': errors.tipo_documento,
                                    }"
                                    v-model="prestamo_documento.tipo_documento"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.tipo_documento"
                                    v-text="errors.tipo_documento[0]"
                                ></span>
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
                                        prestamo_documento.cantidad_documentos
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
                                    v-model="prestamo_documento.fecha"
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
                                    v-model="prestamo_documento.hora"
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
                                        'text-danger': errors.dependencia_id,
                                    }"
                                    >Seleccionar Dependencia*</label
                                >
                                <el-select
                                    placeholder="Seleccionar Dependencia"
                                    class="d-block"
                                    :class="{
                                        'is-invalid': errors.dependencia_id,
                                    }"
                                    v-model="prestamo_documento.dependencia_id"
                                    filterable
                                    clearable
                                >
                                    <el-option
                                        v-for="item in listDependencias"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="item.nombre"
                                    ></el-option>
                                </el-select>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.dependencia_id"
                                    v-text="errors.dependencia_id[0]"
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
                                    v-model="prestamo_documento.descripcion"
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
                                    v-model="prestamo_documento.observacion"
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
        prestamo_documento: {
            type: Object,
            default: {
                documento_id: "",
                funcionario_id: "",
                tipo_documento: "",
                cantidad_documentos: "",
                fecha: "",
                hora: "",
                dependencia_id: "",
                descripcion: "",
                observacion: "",
            },
        },
    },
    watch: {
        muestra_modal: function (newVal, oldVal) {
            this.errors = [];
            if (newVal) {
                this.getDocumentosArchivoReservado();
                if (this.accion != "edit") {
                    this.prestamo_documento.fecha = this.getFechaActual();
                    this.prestamo_documento.hora = this.getHoraActual();
                    setTimeout(() => {
                        this.getLastDependencia();
                    }, 300);
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
                return "AGREGAR PRESTAMO DE DOCUMENTO";
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
            listDependencias: [],
            errors: [],
        };
    },
    mounted() {
        this.bModal = this.muestra_modal;
        this.getFuncionarios();
        this.getDependencias();
    },
    methods: {
        getDependencias() {
            axios.get(main_url + "/admin/dependencias").then((response) => {
                this.listDependencias = response.data.dependencias;
            });
        },

        getLastDependencia() {
            if (this.accion != "edit") {
                axios
                    .get(main_url + "/admin/dependencias/getLastDependencia")
                    .then((response) => {
                        if (response.data.dependencia) {
                            this.prestamo_documento.dependencia_id =
                                response.data.dependencia.id;
                        }
                    });
            }
        },
        getDocumentosArchivoReservado() {
            axios
                .get(main_url + "/admin/documentos/archivo_reservado")
                .then((response) => {
                    this.listDocumentos = response.data.documentos;
                    if (this.accion == "edit") {
                        setTimeout(() => {
                            this.listDocumentos.push(
                                this.prestamo_documento.documento
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
                let url = main_url + "/admin/prestamo_documentos";
                let config = {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                };
                let formdata = new FormData();
                formdata.append(
                    "documento_id",
                    this.prestamo_documento.documento_id
                        ? this.prestamo_documento.documento_id
                        : ""
                );
                formdata.append(
                    "funcionario_id",
                    this.prestamo_documento.funcionario_id
                        ? this.prestamo_documento.funcionario_id
                        : ""
                );
                formdata.append(
                    "tipo_documento",
                    this.prestamo_documento.tipo_documento
                        ? this.prestamo_documento.tipo_documento
                        : ""
                );
                formdata.append(
                    "cantidad_documentos",
                    this.prestamo_documento.cantidad_documentos
                        ? this.prestamo_documento.cantidad_documentos
                        : ""
                );
                formdata.append(
                    "fecha",
                    this.prestamo_documento.fecha
                        ? this.prestamo_documento.fecha
                        : ""
                );
                formdata.append(
                    "hora",
                    this.prestamo_documento.hora
                        ? this.prestamo_documento.hora
                        : ""
                );
                formdata.append(
                    "dependencia_id",
                    this.prestamo_documento.dependencia_id
                        ? this.prestamo_documento.dependencia_id
                        : ""
                );
                formdata.append(
                    "descripcion",
                    this.prestamo_documento.descripcion
                        ? this.prestamo_documento.descripcion
                        : ""
                );
                formdata.append(
                    "observacion",
                    this.prestamo_documento.observacion
                        ? this.prestamo_documento.observacion
                        : ""
                );
                if (this.accion == "edit") {
                    url =
                        main_url +
                        "/admin/prestamo_documentos/" +
                        this.prestamo_documento.id;
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
                        this.limpiaPrestamoDocumento();
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
            this.prestamo_documento.foto = e.target.files[0];
        },
        // Dialog/modal
        cierraModal() {
            this.bModal = false;
            this.$emit("close");
        },
        limpiaPrestamoDocumento() {
            this.errors = [];
            this.prestamo_documento.documento_id = "";
            this.prestamo_documento.funcionario_id = "";
            this.prestamo_documento.tipo_documento = "";
            this.prestamo_documento.cantidad_documentos = "";
            this.prestamo_documento.fecha = "";
            this.prestamo_documento.hora = "";
            this.prestamo_documento.dependencia_id = "";
            this.prestamo_documento.descripcion = "";
            this.prestamo_documento.observacion = "";
        },
    },
};
</script>

<style></style>

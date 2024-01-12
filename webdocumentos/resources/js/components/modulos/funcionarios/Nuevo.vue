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
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.codigo,
                                    }"
                                    >Código Funcionario*</label
                                >
                                <el-input
                                    placeholder="Código Funcionario"
                                    :class="{ 'is-invalid': errors.codigo }"
                                    v-model="funcionario.codigo"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.codigo"
                                    v-text="errors.codigo[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.nombre,
                                    }"
                                    >Nombre(s)*</label
                                >
                                <el-input
                                    placeholder="Nombre(s)"
                                    :class="{ 'is-invalid': errors.nombre }"
                                    v-model="funcionario.nombre"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.nombre"
                                    v-text="errors.nombre[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.paterno,
                                    }"
                                    >Ap. Paterno*</label
                                >

                                <el-input
                                    placeholder="Ap. Paterno"
                                    :class="{ 'is-invalid': errors.paterno }"
                                    v-model="funcionario.paterno"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.paterno"
                                    v-text="errors.paterno[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.materno,
                                    }"
                                    >Ap. Materno</label
                                >
                                <el-input
                                    placeholder="Ap. Materno"
                                    :class="{ 'is-invalid': errors.materno }"
                                    v-model="funcionario.materno"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.materno"
                                    v-text="errors.materno[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.ci,
                                    }"
                                    >Número de Carnet*</label
                                >
                                <el-input
                                    placeholder="Número de C.I."
                                    :class="{ 'is-invalid': errors.ci }"
                                    v-model="funcionario.ci"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.ci"
                                    v-text="errors.ci[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.ci_exp,
                                    }"
                                    >Extensión*</label
                                >
                                <el-select
                                    class="w-100 d-block"
                                    :class="{
                                        'is-invalid': errors.ci_exp,
                                    }"
                                    v-model="funcionario.ci_exp"
                                    clearable
                                >
                                    <el-option
                                        v-for="(item, index) in listExpedido"
                                        :key="index"
                                        :value="item.value"
                                        :label="item.label"
                                    >
                                    </el-option>
                                </el-select>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.ci_exp"
                                    v-text="errors.ci_exp[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.fono,
                                    }"
                                    >Celular</label
                                >
                                <b-form-tags
                                    input-id="tags-basic"
                                    placeholder="Celular"
                                    :class="{ 'is-invalid': errors.fono }"
                                    v-model="funcionario.fono"
                                    addButtonText="Añadir"
                                    separator=" ,;"
                                    remove-on-delete
                                ></b-form-tags>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.fono"
                                    v-text="errors.fono[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.gestion_ingreso,
                                    }"
                                    >Gestión Ingreso*</label
                                >
                                <el-input
                                    placeholder="Gestión Ingreso"
                                    :class="{
                                        'is-invalid': errors.gestion_ingreso,
                                    }"
                                    v-model="funcionario.gestion_ingreso"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.gestion_ingreso"
                                    v-text="errors.gestion_ingreso[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.tipo_ingreso,
                                    }"
                                    >Tipo de Ingreso*</label
                                >
                                <el-input
                                    placeholder="Tipo de Ingreso"
                                    class="w-100"
                                    :class="{
                                        'is-invalid': errors.tipo_ingreso,
                                    }"
                                    v-model="funcionario.tipo_ingreso"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.tipo_ingreso"
                                    v-text="errors.tipo_ingreso[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.fecha_baja,
                                    }"
                                    >Fecha de Baja*</label
                                >
                                <input
                                    type="date"
                                    placeholder="Fecha de Baja"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': errors.fecha_baja,
                                    }"
                                    v-model="funcionario.fecha_baja"
                                    clearable
                                />
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.fecha_baja"
                                    v-text="errors.fecha_baja[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.fecha_item,
                                    }"
                                    >Fecha de Item*</label
                                >
                                <input
                                    type="date"
                                    placeholder="Fecha de Item"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': errors.fecha_item,
                                    }"
                                    v-model="funcionario.fecha_item"
                                    clearable
                                />
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.fecha_item"
                                    v-text="errors.fecha_item[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.descripcion,
                                    }"
                                    >Descripción</label
                                >
                                <el-input
                                    type="textarea"
                                    placeholder="Descripción"
                                    class="w-100"
                                    :class="{
                                        'is-invalid': errors.descripcion,
                                    }"
                                    v-model="funcionario.descripcion"
                                    autosize
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.descripcion"
                                    v-text="errors.descripcion[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.observaciones,
                                    }"
                                    >Observaciones</label
                                >
                                <el-input
                                    type="textarea"
                                    placeholder="Observaciones"
                                    class="w-100"
                                    :class="{
                                        'is-invalid': errors.observaciones,
                                    }"
                                    v-model="funcionario.observaciones"
                                    autosize
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.observaciones"
                                    v-text="errors.observaciones[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.acceso,
                                    }"
                                    >Acceso al sistema*</label
                                >
                                <el-switch
                                    :class="{
                                        'is-invalid': errors.acceso,
                                    }"
                                    style="display: block"
                                    v-model="funcionario.acceso"
                                    active-color="#13ce66"
                                    inactive-color="#ff4949"
                                    active-text="HABILITADO"
                                    inactive-text="INHABILITADO"
                                    active-value="1"
                                    inactive-value="0"
                                >
                                </el-switch>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.acceso"
                                    v-text="errors.acceso[0]"
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
        funcionario: {
            type: Object,
            default: {
                codigo: "",
                nombre: "",
                paterno: "",
                materno: "",
                ci: "",
                ci_exp: "",
                gestion_ingreso: "",
                tipo_ingreso: "",
                fono: [],
                tipo_ingreso: "",
                fecha_baja: "",
                fecha_item: "",
                descripcion: "",
                observaciones: "",
                acceso: "0",
            },
        },
    },
    watch: {
        muestra_modal: function (newVal, oldVal) {
            this.errors = [];
            if (newVal) {
                this.bModal = true;
            } else {
                this.bModal = false;
            }
        },
    },
    computed: {
        tituloModal() {
            if (this.accion == "nuevo") {
                return "AGREGAR FUNCIONARIO";
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
            listExpedido: [
                { value: "LP", label: "La Paz" },
                { value: "CB", label: "Cochabamba" },
                { value: "SC", label: "Santa Cruz" },
                { value: "CH", label: "Chuquisaca" },
                { value: "OR", label: "Oruro" },
                { value: "PT", label: "Potosi" },
                { value: "TJ", label: "Tarija" },
                { value: "PD", label: "Pando" },
                { value: "BN", label: "Beni" },
            ],
            listTipos: ["ADMINISTRADOR", "OPERADOR"],
            errors: [],
        };
    },
    mounted() {
        this.bModal = this.muestra_modal;
    },
    methods: {
        setRegistroModal() {
            this.enviando = true;
            try {
                this.textoBtn = "Enviando...";
                let url = main_url + "/admin/funcionarios";
                let config = {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                };
                let formdata = new FormData();
                formdata.append(
                    "codigo",
                    this.funcionario.codigo ? this.funcionario.codigo : ""
                );
                formdata.append(
                    "nombre",
                    this.funcionario.nombre ? this.funcionario.nombre : ""
                );
                formdata.append(
                    "paterno",
                    this.funcionario.paterno ? this.funcionario.paterno : ""
                );
                formdata.append(
                    "materno",
                    this.funcionario.materno ? this.funcionario.materno : ""
                );
                formdata.append(
                    "ci",
                    this.funcionario.ci ? this.funcionario.ci : ""
                );
                formdata.append(
                    "ci_exp",
                    this.funcionario.ci_exp ? this.funcionario.ci_exp : ""
                );
                formdata.append(
                    "gestion_ingreso",
                    this.funcionario.gestion_ingreso
                        ? this.funcionario.gestion_ingreso
                        : ""
                );
                formdata.append(
                    "tipo_ingreso",
                    this.funcionario.tipo_ingreso
                        ? this.funcionario.tipo_ingreso
                        : ""
                );
                formdata.append(
                    "fono",
                    this.funcionario.fono
                        ? this.funcionario.fono.join("; ")
                        : ""
                );
                formdata.append(
                    "tipo_ingreso",
                    this.funcionario.tipo_ingreso
                        ? this.funcionario.tipo_ingreso
                        : ""
                );
                formdata.append(
                    "fecha_baja",
                    this.funcionario.fecha_baja
                        ? this.funcionario.fecha_baja
                        : ""
                );
                formdata.append(
                    "fecha_item",
                    this.funcionario.fecha_item
                        ? this.funcionario.fecha_item
                        : ""
                );
                formdata.append(
                    "descripcion",
                    this.funcionario.descripcion
                        ? this.funcionario.descripcion
                        : ""
                );
                formdata.append(
                    "observaciones",
                    this.funcionario.observaciones
                        ? this.funcionario.observaciones
                        : ""
                );
                formdata.append(
                    "acceso",
                    this.funcionario.acceso ? this.funcionario.acceso : "0"
                );

                if (this.accion == "edit") {
                    url =
                        main_url + "/admin/funcionarios/" + this.funcionario.id;
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
                        this.limpiaFuncionario();
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
            this.funcionario.foto = e.target.files[0];
        },
        // Dialog/modal
        cierraModal() {
            this.bModal = false;
            this.$emit("close");
        },
        limpiaFuncionario() {
            this.errors = [];
            this.funcionario.codigo = "";
            this.funcionario.nombre = "";
            this.funcionario.paterno = "";
            this.funcionario.materno = "";
            this.funcionario.ci = "";
            this.funcionario.ci_exp = "";
            this.funcionario.gestion_ingreso = "";
            this.funcionario.tipo_ingreso = "";
            this.funcionario.fecha_baja = "";
            this.funcionario.fecha_item = "";
            this.funcionario.fono = [];
            this.funcionario.descripcion = "";
            this.funcionario.observaciones = "";
            this.funcionario.acceso = "0";
        },
    },
};
</script>

<style></style>

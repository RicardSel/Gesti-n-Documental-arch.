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
                                    v-model="documento.descripcion"
                                    clearable
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
                                        'text-danger': errors.dependencia_id,
                                    }"
                                    >Último Movimiento Dependencia*</label
                                >
                                <el-select
                                    placeholder="Último Movimiento Dependencia"
                                    class="d-block"
                                    :class="{
                                        'is-invalid': errors.dependencia_id,
                                    }"
                                    v-model="documento.dependencia_id"
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
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.funcionario_id,
                                    }"
                                    >Último Movimiento Funcionario*</label
                                >
                                <el-select
                                    placeholder="Último Movimiento Funcionario"
                                    class="d-block"
                                    :class="{
                                        'is-invalid': errors.funcionario_id,
                                    }"
                                    v-model="documento.funcionario_id"
                                    filterable
                                    clearable
                                >
                                    <el-option
                                        v-for="item in listFuncionarios"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="item.full_name"
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
                                        'text-danger': errors.oficina_id,
                                    }"
                                    >Nombre de Oficina Archivo*</label
                                >
                                <el-select
                                    placeholder="Nombre de Oficina Archivo"
                                    class="d-block"
                                    :class="{
                                        'is-invalid': errors.oficina_id,
                                    }"
                                    v-model="documento.oficina_id"
                                    filterable
                                    clearable
                                >
                                    <el-option
                                        v-for="item in listOficinas"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="item.nombre"
                                    ></el-option>
                                </el-select>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.oficina_id"
                                    v-text="errors.oficina_id[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.estante_id,
                                    }"
                                    >Seleccionar Estante*</label
                                >
                                <el-select
                                    placeholder="Seleccionar Estante"
                                    class="d-block"
                                    :class="{
                                        'is-invalid': errors.estante_id,
                                    }"
                                    v-model="documento.estante_id"
                                    filterable
                                    clearable
                                    @change="getNivelDivisionEstante"
                                >
                                    <el-option
                                        v-for="item in listEstantes"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="item.nombre"
                                    ></el-option>
                                </el-select>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.estante_id"
                                    v-text="errors.estante_id[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.nivel,
                                    }"
                                    >Seleccionar Nivel*</label
                                >
                                <el-select
                                    placeholder="Seleccionar Nivel"
                                    class="d-block"
                                    :class="{
                                        'is-invalid': errors.nivel,
                                    }"
                                    v-model="documento.nivel"
                                    filterable
                                    clearable
                                >
                                    <el-option
                                        v-for="item in listNivels"
                                        :key="item"
                                        :value="item"
                                        :label="item"
                                    ></el-option>
                                </el-select>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.nivel"
                                    v-text="errors.nivel[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.division,
                                    }"
                                    >Seleccionar División*</label
                                >
                                <el-select
                                    placeholder="Seleccionar División"
                                    class="d-block"
                                    :class="{
                                        'is-invalid': errors.division,
                                    }"
                                    v-model="documento.division"
                                    filterable
                                    clearable
                                >
                                    <el-option
                                        v-for="item in listDivisions"
                                        :key="item"
                                        :value="item"
                                        :label="item"
                                    ></el-option>
                                </el-select>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.division"
                                    v-text="errors.division[0]"
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
                                    v-model="documento.fecha"
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
                                    v-model="documento.hora"
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
        documento: {
            type: Object,
            default: {
                codigo: "",
                descripcion: "",
                dependencia_id: "",
                funcionario_id: "",
                oficina_id: "",
                nombre: "",
                estante_id: "",
                nivel: "",
                division: "",
                estado: "",
                fecha: "",
                hora: "",
            },
        },
    },
    watch: {
        muestra_modal: function (newVal, oldVal) {
            this.errors = [];
            if (newVal) {
                if (this.accion != "edit") {
                    this.documento.fecha = this.getFechaActual();
                    this.documento.hora = this.getHoraActual();
                    setTimeout(() => {
                        this.getLastDependencia();
                        this.getLastFuncionario();
                    }, 300);
                }
                setTimeout(() => {
                    this.getNivelDivisionEstante();
                }, 300);
                this.bModal = true;
            } else {
                this.bModal = false;
            }
        },
    },
    computed: {
        tituloModal() {
            if (this.accion == "nuevo") {
                return "AGREGAR DOCUMENTO";
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
            listDependencias: [],
            listFuncionarios: [],
            listOficinas: [],
            listEstantes: [],
            listNivels: [],
            listDivisions: [],
            errors: [],
        };
    },
    mounted() {
        this.bModal = this.muestra_modal;
        this.getDependencias();
        this.getFuncionarios();
        this.getOficinas();
        this.getEstantes();
    },
    methods: {
        getDependencias() {
            axios.get(main_url + "/admin/dependencias").then((response) => {
                this.listDependencias = response.data.dependencias;
            });
        },
        getFuncionarios() {
            axios.get(main_url + "/admin/funcionarios").then((response) => {
                this.listFuncionarios = response.data.funcionarios;
            });
        },
        getOficinas() {
            axios.get(main_url + "/admin/oficinas").then((response) => {
                this.listOficinas = response.data.oficinas;
            });
        },
        getEstantes() {
            axios.get(main_url + "/admin/estantes").then((response) => {
                this.listEstantes = response.data.estantes;
            });
        },
        getNivelDivisionEstante() {
            if (this.documento.estante_id != "") {
                axios
                    .get(
                        main_url +
                            "/admin/estantes/nivel_division/" +
                            this.documento.estante_id
                    )
                    .then((response) => {
                        if (this.accion != "edit") {
                            this.documento.nivel = "";
                            this.documento.division = "";
                        }
                        this.listNivels = response.data.niveles;
                        this.listDivisions = response.data.divisiones;
                    });
            } else {
                this.documento.nivel = "";
                this.documento.division = "";
                this.listNivels = [];
                this.listDivisions = [];
            }
        },
        getLastDependencia() {
            if (this.accion != "edit") {
                axios
                    .get(main_url + "/admin/dependencias/getLastDependencia")
                    .then((response) => {
                        if (response.data.dependencia) {
                            this.documento.dependencia_id =
                                response.data.dependencia.id;
                        }
                    });
            }
        },
        getLastFuncionario() {
            if (this.accion != "edit") {
                axios
                    .get(main_url + "/admin/dependencias/getLastFuncionario")
                    .then((response) => {
                        if (response.data.funcionario) {
                            this.documento.funcionario_id =
                                response.data.funcionario.id;
                        }
                    });
            }
        },
        setRegistroModal() {
            this.enviando = true;
            try {
                this.textoBtn = "Enviando...";
                let url = main_url + "/admin/documentos";
                let config = {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                };
                let formdata = new FormData();
                formdata.append(
                    "descripcion",
                    this.documento.descripcion ? this.documento.descripcion : ""
                );
                formdata.append(
                    "dependencia_id",
                    this.documento.dependencia_id
                        ? this.documento.dependencia_id
                        : ""
                );
                formdata.append(
                    "funcionario_id",
                    this.documento.funcionario_id
                        ? this.documento.funcionario_id
                        : ""
                );
                formdata.append(
                    "oficina_id",
                    this.documento.oficina_id ? this.documento.oficina_id : ""
                );
                formdata.append(
                    "nombre",
                    this.documento.nombre ? this.documento.nombre : ""
                );
                formdata.append(
                    "estante_id",
                    this.documento.estante_id ? this.documento.estante_id : ""
                );
                formdata.append(
                    "nivel",
                    this.documento.nivel ? this.documento.nivel : ""
                );
                formdata.append(
                    "division",
                    this.documento.division ? this.documento.division : ""
                );
                formdata.append(
                    "estado",
                    this.documento.estado ? this.documento.estado : ""
                );
                formdata.append(
                    "fecha",
                    this.documento.fecha ? this.documento.fecha : ""
                );
                formdata.append(
                    "hora",
                    this.documento.hora ? this.documento.hora : ""
                );

                if (this.accion == "edit") {
                    url = main_url + "/admin/documentos/" + this.documento.id;
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
                        this.limpiaDocumento();
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
            this.documento.foto = e.target.files[0];
        },
        // Dialog/modal
        cierraModal() {
            this.bModal = false;
            this.$emit("close");
        },
        limpiaDocumento() {
            this.errors = [];
            this.documento.descripcion = "";
            this.documento.dependencia_id = "";
            this.documento.funcionario_id = "";
            this.documento.oficina_id = "";
            this.documento.nombre = "";
            this.documento.estante_id = "";
            this.documento.nivel = "";
            this.documento.division = "";
            this.documento.estado = "";
            this.documento.fecha = "";
            this.documento.hora = "";
        },
    },
};
</script>

<style></style>

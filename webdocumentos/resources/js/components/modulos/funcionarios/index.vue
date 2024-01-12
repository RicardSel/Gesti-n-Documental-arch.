<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Gestión de Funcionarios</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-success">
                                <div class="row">
                                    <div class="col-md-3">
                                        <button
                                            v-if="
                                                permisos.includes(
                                                    'funcionarios.create'
                                                )
                                            "
                                            class="btn btn-danger btn-flat btn-block"
                                            @click="
                                                abreModal('nuevo');
                                                limpiaFuncionario();
                                            "
                                        >
                                            <i class="fa fa-plus"></i>
                                            Nuevo
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <b-col lg="10" class="my-1">
                                        <b-form-group
                                            label="Buscar"
                                            label-for="filter-input"
                                            label-cols-sm="3"
                                            label-align-sm="right"
                                            label-size="sm"
                                            class="mb-0"
                                        >
                                            <b-input-group size="sm">
                                                <b-form-input
                                                    id="filter-input"
                                                    v-model="filter"
                                                    type="search"
                                                    placeholder="Buscar"
                                                ></b-form-input>

                                                <b-input-group-append>
                                                    <b-button
                                                        variant="success"
                                                        :disabled="!filter"
                                                        @click="filter = ''"
                                                        >Borrar</b-button
                                                    >
                                                </b-input-group-append>
                                            </b-input-group>
                                        </b-form-group>
                                    </b-col>
                                    <div class="col-md-12">
                                        <b-overlay
                                            :show="showOverlay"
                                            rounded="sm"
                                        >
                                            <b-table
                                                :fields="fields"
                                                :items="listRegistros"
                                                show-empty
                                                stacked="md"
                                                :head-variant="'dark'"
                                                no-border-collapse
                                                bordered
                                                hover
                                                responsive
                                                :current-page="currentPage"
                                                :per-page="perPage"
                                                @filtered="onFiltered"
                                                empty-text="Sin resultados"
                                                empty-filtered-text="Sin resultados"
                                                :filter="filter"
                                            >
                                                <template #cell(foto)="row">
                                                    <b-avatar
                                                        :src="
                                                            row.item.path_image
                                                        "
                                                        size="3rem"
                                                    ></b-avatar>
                                                </template>
                                                <template #cell(acceso)="row">
                                                    <span
                                                        class="badge badge-success"
                                                        v-if="
                                                            row.item.user
                                                                .acceso == 1
                                                        "
                                                    >
                                                        HABILITADO
                                                    </span>
                                                    <span
                                                        v-else
                                                        class="badge badge-danger"
                                                    >
                                                        INHABILITADO
                                                    </span>
                                                </template>
                                                <template #cell(mas)="row">
                                                    <b-button
                                                        variant="success"
                                                        size="sm"
                                                        @click="
                                                            row.toggleDetails
                                                        "
                                                    >
                                                        {{
                                                            row.detailsShowing
                                                                ? "Ocultar"
                                                                : "Mostrar"
                                                        }}
                                                        Detalles
                                                    </b-button>
                                                </template>

                                                <template #row-details="row">
                                                    <b-card>
                                                        <b-row class="mb-2">
                                                            <b-col
                                                                sm="3"
                                                                class="text-sm-right"
                                                                ><b
                                                                    >Gestión
                                                                    Ingreso:</b
                                                                ></b-col
                                                            >
                                                            <b-col>{{
                                                                row.item
                                                                    .gestion_ingreso
                                                            }}</b-col>
                                                        </b-row>
                                                        <b-row class="mb-2">
                                                            <b-col
                                                                sm="3"
                                                                class="text-sm-right"
                                                                ><b
                                                                    >Tipo de
                                                                    Ingreso:</b
                                                                ></b-col
                                                            >
                                                            <b-col>{{
                                                                row.item
                                                                    .tipo_ingreso
                                                            }}</b-col>
                                                        </b-row>
                                                        <b-row class="mb-2">
                                                            <b-col
                                                                sm="3"
                                                                class="text-sm-right"
                                                                ><b
                                                                    >Fecha de
                                                                    Baja:</b
                                                                ></b-col
                                                            >
                                                            <b-col>{{
                                                                row.item
                                                                    .fecha_baja
                                                            }}</b-col>
                                                        </b-row>
                                                        <b-row class="mb-2">
                                                            <b-col
                                                                sm="3"
                                                                class="text-sm-right"
                                                                ><b
                                                                    >Fecha de
                                                                    Item:</b
                                                                ></b-col
                                                            >
                                                            <b-col>{{
                                                                row.item
                                                                    .fecha_item
                                                            }}</b-col>
                                                        </b-row>
                                                        <b-row class="mb-2">
                                                            <b-col
                                                                sm="3"
                                                                class="text-sm-right"
                                                                ><b
                                                                    >Descripción:</b
                                                                ></b-col
                                                            >
                                                            <b-col>{{
                                                                row.item
                                                                    .descripcion
                                                            }}</b-col>
                                                        </b-row>
                                                        <b-row class="mb-2">
                                                            <b-col
                                                                sm="3"
                                                                class="text-sm-right"
                                                                ><b
                                                                    >Observaciones:</b
                                                                ></b-col
                                                            >
                                                            <b-col>{{
                                                                row.item
                                                                    .observaciones
                                                            }}</b-col>
                                                        </b-row>
                                                        <b-button
                                                            size="sm"
                                                            variant="success"
                                                            @click="
                                                                row.toggleDetails
                                                            "
                                                            >Ocultar</b-button
                                                        >
                                                    </b-card>
                                                </template>

                                                <template #cell(accion)="row">
                                                    <div
                                                        class="row justify-content-between"
                                                    >
                                                        <b-button
                                                            v-if="
                                                                permisos.includes(
                                                                    'funcionarios.edit'
                                                                )
                                                            "
                                                            size="sm"
                                                            pill
                                                            variant="outline-warning"
                                                            class="btn-flat btn-block"
                                                            title="Editar registro"
                                                            @click="
                                                                editarRegistro(
                                                                    row.item
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-edit"
                                                            ></i>
                                                        </b-button>
                                                        <b-button
                                                            size="sm"
                                                            pill
                                                            variant="outline-info"
                                                            class="btn-flat btn-block"
                                                            title="Cambiar contraseña"
                                                            @click="
                                                                cambiarContraseña(
                                                                    row.item
                                                                        .user
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-key"
                                                            ></i>
                                                        </b-button>
                                                        <b-button
                                                            v-if="
                                                                permisos.includes(
                                                                    'funcionarios.destroy'
                                                                )
                                                            "
                                                            size="sm"
                                                            pill
                                                            variant="outline-danger"
                                                            class="btn-flat btn-block"
                                                            title="Eliminar registro"
                                                            @click="
                                                                eliminaFuncionario(
                                                                    row.item.id,
                                                                    row.item
                                                                        .full_name +
                                                                        '<br/><h4>¿Está seguro(a) de eliminar este registro?</h4>'
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-trash"
                                                            ></i>
                                                        </b-button>
                                                    </div>
                                                </template>
                                            </b-table>
                                        </b-overlay>
                                        <div class="row">
                                            <b-col
                                                sm="6"
                                                md="2"
                                                class="ml-auto my-1"
                                            >
                                                <b-form-select
                                                    align="right"
                                                    id="per-page-select"
                                                    v-model="perPage"
                                                    :options="pageOptions"
                                                    size="sm"
                                                ></b-form-select>
                                            </b-col>
                                            <b-col
                                                sm="6"
                                                md="2"
                                                class="my-1 mr-auto"
                                                v-if="perPage"
                                            >
                                                <b-pagination
                                                    v-model="currentPage"
                                                    :total-rows="totalRows"
                                                    :per-page="perPage"
                                                    align="left"
                                                ></b-pagination>
                                            </b-col>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <Nuevo
            :muestra_modal="muestra_modal"
            :accion="modal_accion"
            :funcionario="oFuncionario"
            @close="muestra_modal = false"
            @envioModal="getFuncionarios"
        ></Nuevo>
    </div>
</template>

<script>
import Nuevo from "./Nuevo.vue";
export default {
    components: {
        Nuevo,
    },
    data() {
        return {
            user: JSON.parse(localStorage.getItem("user")),
            permisos: localStorage.getItem("permisos"),
            search: "",
            listRegistros: [],
            showOverlay: false,
            fields: [
                {
                    key: "codigo",
                    label: "Código",
                    sortable: true,
                },
                {
                    key: "user.usuario",
                    label: "Usuario",
                    sortable: true,
                },
                { key: "full_name", label: "Nombre", sortable: true },
                { key: "full_ci", label: "C.I.", sortable: true },
                {
                    key: "fecha_registro_t",
                    label: "Fecha de registro",
                    sortable: true,
                },
                { key: "acceso", label: "Acceso al sistema" },
                { key: "mas", label: "Ver mas" },
                { key: "accion", label: "Acción" },
            ],
            loading: true,
            fullscreenLoading: true,
            loadingWindow: Loading.service({
                fullscreen: this.fullscreenLoading,
            }),
            muestra_modal: false,
            modal_accion: "nuevo",
            oFuncionario: {
                id: 0,
                codigo: "",
                nombre: "",
                paterno: "",
                materno: "",
                ci: "",
                ci_exp: "",
                gestion_ingreso: "",
                tipo_ingreso: "",
                fecha_baja: "",
                fecha_item: "",
                fono: [],
                tipo: "",
                descripcion: "",
                observaciones: "",
                acceso: "0",
            },
            currentPage: 1,
            perPage: 5,
            pageOptions: [
                { value: 5, text: "Mostrar 5 Registros" },
                { value: 10, text: "Mostrar 10 Registros" },
                { value: 25, text: "Mostrar 25 Registros" },
                { value: 50, text: "Mostrar 50 Registros" },
                { value: 100, text: "Mostrar 100 Registros" },
                { value: this.totalRows, text: "Mostrar Todo" },
            ],
            totalRows: 10,
            filter: null,
        };
    },
    mounted() {
        this.loadingWindow.close();
        this.getFuncionarios();
    },
    methods: {
        // Seleccionar Opciones de Tabla
        editarRegistro(item) {
            this.oFuncionario.id = item.id;
            this.oFuncionario.codigo = item.codigo ? item.codigo : "";
            this.oFuncionario.nombre = item.user.nombre ? item.user.nombre : "";
            this.oFuncionario.paterno = item.user.paterno
                ? item.user.paterno
                : "";
            this.oFuncionario.materno = item.user.materno
                ? item.user.materno
                : "";
            this.oFuncionario.ci = item.user.ci ? item.user.ci : "";
            this.oFuncionario.ci_exp = item.user.ci_exp ? item.user.ci_exp : "";
            this.oFuncionario.gestion_ingreso = item.gestion_ingreso
                ? item.gestion_ingreso
                : "";
            this.oFuncionario.tipo_ingreso = item.tipo_ingreso
                ? item.tipo_ingreso
                : "";
            this.oFuncionario.fecha_baja = item.fecha_baja
                ? item.fecha_baja
                : "";
            this.oFuncionario.fecha_item = item.fecha_item
                ? item.fecha_item
                : "";
            this.oFuncionario.fono = item.user.fono
                ? item.user.fono.split("; ")
                : "";
            this.oFuncionario.descripcion = item.descripcion
                ? item.descripcion
                : "";
            this.oFuncionario.observaciones = item.observaciones
                ? item.observaciones
                : "";
            this.oFuncionario.acceso = item.user.acceso
                ? "" + item.user.acceso
                : "0";
            this.modal_accion = "edit";
            this.muestra_modal = true;
        },
        cambiarContraseña(item) {
            Swal.fire({
                title: "Modificar contraseña",
                html: "Usuario: " + item.full_name,
                input: "text",
                inputAttributes: {
                    minlength: 4,
                },
                showCancelButton: true,
                confirmButtonColor: "#17a2b8",
                confirmButtonText: "Actualizar",
                cancelButtonText: "Cancelar",
                preConfirm: (texto) => {
                    if (texto.length >= 4) {
                        return axios
                            .post("/admin/usuarios/updatePassword/" + item.id, {
                                password: texto,
                            })
                            .then((response) => {
                                Swal.fire({
                                    icon: "success",
                                    title: response.data.message,
                                    showConfirmButton: false,
                                    timer: 1500,
                                });
                            })
                            .catch((error) => {
                                Swal.fire({
                                    icon: "error",
                                    title: "Ocurrío un error al enviar la contraseña",
                                    confirmButtonColor: "#e0a800",
                                    confirmButtonText: `<span class="text-black">Aceptar</span>`,
                                });
                            });
                    } else {
                        Swal.showValidationMessage(
                            "El texto debe contener al menos 6 caracteres"
                        );
                    }
                },
            });
        },

        // Listar Funcionarios
        getFuncionarios() {
            this.showOverlay = true;
            this.muestra_modal = false;
            let url = main_url + "/admin/funcionarios";
            if (this.pagina != 0) {
                url += "?page=" + this.pagina;
            }
            axios
                .get(url, {
                    params: { per_page: this.per_page },
                })
                .then((res) => {
                    this.showOverlay = false;
                    this.listRegistros = res.data.funcionarios;
                    this.totalRows = res.data.total;
                });
        },
        eliminaFuncionario(id, descripcion) {
            Swal.fire({
                title: "¿Quierés eliminar este registro?",
                html: `<strong>${descripcion}</strong>`,
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                confirmButtonText: "Si, eliminar",
                cancelButtonText: "No, cancelar",
                denyButtonText: `No, cancelar`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    axios
                        .post(main_url + "/admin/funcionarios/" + id, {
                            _method: "DELETE",
                        })
                        .then((res) => {
                            this.getFuncionarios();
                            this.filter = "";
                            Swal.fire({
                                icon: "success",
                                title: res.data.msj,
                                showConfirmButton: false,
                                timer: 1500,
                            });
                        })
                        .catch((error) => {
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
                }
            });
        },
        abreModal(tipo_accion = "nuevo", funcionario = null) {
            this.muestra_modal = true;
            this.modal_accion = tipo_accion;
            if (funcionario) {
                this.oFuncionario = funcionario;
            }
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },
        limpiaFuncionario() {
            this.oFuncionario.codigo = "";
            this.oFuncionario.nombre = "";
            this.oFuncionario.paterno = "";
            this.oFuncionario.materno = "";
            this.oFuncionario.ci = "";
            this.oFuncionario.ci_exp = "";
            this.oFuncionario.gestion_ingreso = "";
            this.oFuncionario.tipo_ingreso = "";
            this.oFuncionario.fecha_baja = "";
            this.oFuncionario.fecha_item = "";
            this.oFuncionario.fono = [];
            this.oFuncionario.tipo = "";
            this.oFuncionario.descripcion = "";
            this.oFuncionario.observaciones = "";
            this.oFuncionario.acceso = "0";
        },
        formatoFecha(date) {
            return this.$moment(String(date)).format("DD/MM/YYYY");
        },
    },
};
</script>

<style></style>

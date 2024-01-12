<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Documentos</h1>
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
                                                    'documentos.create'
                                                )
                                            "
                                            class="btn btn-danger btn-flat btn-block"
                                            @click="
                                                abreModal('nuevo');
                                                limpiaDocumento();
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
                                                <template #cell(estado)="row">
                                                    <span
                                                        class="font-weight-bold"
                                                        >{{
                                                            row.item.estado
                                                        }}</span
                                                    >
                                                </template>
                                                <template
                                                    #cell(documentos)="row"
                                                >
                                                    <div
                                                        class="w-100 text-center contenedor_celda_documentos"
                                                    >
                                                        <span
                                                            class="badge badge-success text-md span_total_documentos"
                                                            >{{
                                                                row.item
                                                                    .adjuntar_documentos
                                                                    .length
                                                            }}</span
                                                        >
                                                        <button
                                                            type="button"
                                                            class="btn-flat btn-block rounded bg-transparent border-0"
                                                            @click="
                                                                documentosRegistro(
                                                                    row.item
                                                                )
                                                            "
                                                        >
                                                            <img
                                                                :src="
                                                                    url_principal +
                                                                    '/imgs/documentos.png'
                                                                "
                                                                width="30px"
                                                            />
                                                        </button>
                                                    </div>
                                                </template>

                                                <template #cell(accion)="row">
                                                    <div
                                                        class="row justify-content-between"
                                                    >
                                                        <b-button
                                                            v-if="
                                                                permisos.includes(
                                                                    'documentos.edit'
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
                                                            v-if="
                                                                permisos.includes(
                                                                    'documentos.destroy'
                                                                )
                                                            "
                                                            size="sm"
                                                            pill
                                                            variant="outline-danger"
                                                            class="btn-flat btn-block"
                                                            title="Eliminar registro"
                                                            @click="
                                                                eliminaDocumento(
                                                                    row.item.id,
                                                                    `<h4>¿Está seguro(a) de eliminar el registro con código ${row.item.codigo}?</h4>`
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
            :documento="oDocumento"
            @close="muestra_modal = false"
            @envioModal="getDocumentos"
        ></Nuevo>
        <Documentos
            :muestra_modal="muestra_modal_documentos"
            :documento="oDocumento"
            @close="muestra_modal_documentos = false"
            @actualizacion="getDocumentos"
        ></Documentos>
    </div>
</template>

<script>
import Nuevo from "./Nuevo.vue";
import Documentos from "./Documentos.vue";
export default {
    components: {
        Nuevo,
        Documentos,
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
                    key: "descripcion",
                    label: "Nombre Documento",
                    sortable: true,
                },
                {
                    key: "dependencia.nombre",
                    label: "Dependencia",
                    sortable: true,
                },
                {
                    key: "funcionario.full_name",
                    label: "Funcionario",
                    sortable: true,
                },
                {
                    key: "oficina.nombre",
                    label: "Oficina",
                    sortable: true,
                },
                { key: "oficina.nombre", label: "Oficina", sortable: true },
                { key: "estante.nombre", label: "Estante", sortable: true },
                { key: "nivel", label: "Nivel", sortable: true },
                { key: "division", label: "División", sortable: true },
                { key: "estado", label: "Estado", sortable: true },
                { key: "fecha_hora_t", label: "Fecha y Hora", sortable: true },
                {
                    key: "documentos",
                    label: "Documentos Adjuntados",
                    sortable: true,
                },
                {
                    key: "fecha_registro_t",
                    label: "Fecha de registro",
                    sortable: true,
                },
                { key: "accion", label: "Acción" },
            ],
            loading: true,
            fullscreenLoading: true,
            loadingWindow: Loading.service({
                fullscreen: this.fullscreenLoading,
            }),
            muestra_modal: false,
            muestra_modal_documentos: false,
            modal_accion: "nuevo",
            oDocumento: {
                id: 0,
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
            url_principal: main_url,
        };
    },
    mounted() {
        this.loadingWindow.close();
        this.getDocumentos();
    },
    methods: {
        // Seleccionar Opciones de Tabla
        editarRegistro(item) {
            this.oDocumento.id = item.id;
            this.oDocumento.codigo = item.codigo ? item.codigo : "";
            this.oDocumento.descripcion = item.descripcion
                ? item.descripcion
                : "";
            this.oDocumento.dependencia_id = item.dependencia_id
                ? item.dependencia_id
                : "";
            this.oDocumento.funcionario_id = item.funcionario_id
                ? item.funcionario_id
                : "";
            this.oDocumento.oficina_id = item.oficina_id ? item.oficina_id : "";
            this.oDocumento.nombre = item.nombre ? item.nombre : "";
            this.oDocumento.estante_id = item.estante_id ? item.estante_id : "";
            this.oDocumento.nivel = item.nivel ? item.nivel : "";
            this.oDocumento.division = item.division ? item.division : "";
            this.oDocumento.estado = item.estado ? item.estado : "";
            this.oDocumento.fecha = item.fecha ? item.fecha : "";
            this.oDocumento.hora = item.hora ? item.hora : "";
            this.modal_accion = "edit";
            this.muestra_modal = true;
        },
        documentosRegistro(item) {
            this.oDocumento.id = item.id;
            this.oDocumento.codigo = item.codigo ? item.codigo : "";
            this.oDocumento.descripcion = item.descripcion
                ? item.descripcion
                : "";
            this.oDocumento.dependencia_id = item.dependencia_id
                ? item.dependencia_id
                : "";
            this.oDocumento.funcionario_id = item.funcionario_id
                ? item.funcionario_id
                : "";
            this.oDocumento.oficina_id = item.oficina_id ? item.oficina_id : "";
            this.oDocumento.nombre = item.nombre ? item.nombre : "";
            this.oDocumento.estante_id = item.estante_id ? item.estante_id : "";
            this.oDocumento.nivel = item.nivel ? item.nivel : "";
            this.oDocumento.division = item.division ? item.division : "";
            this.oDocumento.estado = item.estado ? item.estado : "";
            this.oDocumento.fecha = item.fecha ? item.fecha : "";
            this.oDocumento.hora = item.hora ? item.hora : "";
            this.oDocumento.adjuntar_documentos = item.adjuntar_documentos
                ? item.adjuntar_documentos
                : "";
            this.modal_accion = "edit";
            this.muestra_modal_documentos = true;
        },

        // Listar Documentos
        getDocumentos() {
            this.showOverlay = true;
            this.muestra_modal = false;
            let url = main_url + "/admin/documentos";
            if (this.pagina != 0) {
                url += "?page=" + this.pagina;
            }
            axios
                .get(url, {
                    params: { per_page: this.per_page },
                })
                .then((res) => {
                    this.showOverlay = false;
                    this.listRegistros = res.data.documentos;
                    this.totalRows = res.data.total;
                });
        },
        eliminaDocumento(id, descripcion) {
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
                        .post(main_url + "/admin/documentos/" + id, {
                            _method: "DELETE",
                        })
                        .then((res) => {
                            this.getDocumentos();
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
        abreModal(tipo_accion = "nuevo", documento = null) {
            this.muestra_modal = true;
            this.modal_accion = tipo_accion;
            if (documento) {
                this.oDocumento = documento;
            }
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },
        limpiaDocumento() {
            this.oDocumento.descripcion = "";
            this.oDocumento.dependencia_id = "";
            this.oDocumento.funcionario_id = "";
            this.oDocumento.oficina_id = "";
            this.oDocumento.nombre = "";
            this.oDocumento.estante_id = "";
            this.oDocumento.nivel = "";
            this.oDocumento.division = "";
            this.oDocumento.estado = "";
            this.oDocumento.fecha = "";
            this.oDocumento.hora = "";
        },
        formatoFecha(date) {
            return this.$moment(String(date)).format("DD/MM/YYYY");
        },
    },
};
</script>

<style>
.contenedor_celda_documentos {
    position: relative;
}
.span_total_documentos {
    top: -10px;
    position: absolute;
}
</style>

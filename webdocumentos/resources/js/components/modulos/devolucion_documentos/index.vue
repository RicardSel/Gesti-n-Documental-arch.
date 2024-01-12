<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Devolución de Documentos</h1>
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
                                                    'devolucion_documentos.create'
                                                )
                                            "
                                            class="btn btn-danger btn-flat btn-block"
                                            @click="
                                                abreModal('nuevo');
                                                limpiaDevolucionDocumento();
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
                                                    #cell(devolucion_documentos)="row"
                                                >
                                                    <div
                                                        class="w-100 text-center contenedor_celda_devolucion_documentos"
                                                    >
                                                        <span
                                                            class="badge badge-success text-md span_total_devolucion_documentos"
                                                            >{{
                                                                row.item
                                                                    .adjuntar_devolucion_documentos
                                                                    .length
                                                            }}</span
                                                        >
                                                        <button
                                                            type="button"
                                                            class="btn-flat btn-block rounded bg-transparent border-0"
                                                            @click="
                                                                devolucion_documentosRegistro(
                                                                    row.item
                                                                )
                                                            "
                                                        >
                                                            <img
                                                                :src="
                                                                    url_principal +
                                                                    '/imgs/devolucion_documentos.png'
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
                                                                    'devolucion_documentos.edit'
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
                                                                    'devolucion_documentos.destroy'
                                                                )
                                                            "
                                                            size="sm"
                                                            pill
                                                            variant="outline-danger"
                                                            class="btn-flat btn-block"
                                                            title="Eliminar registro"
                                                            @click="
                                                                eliminaDevolucionDocumento(
                                                                    row.item.id,
                                                                    `<h4>¿Está seguro(a) de eliminar el registro del documento con código ${row.item.documento.codigo}?</h4>`
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
            :devolucion_documento="oDevolucionDocumento"
            @close="muestra_modal = false"
            @envioModal="getDevolucionDocumentos"
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
                    key: "documento.codigo",
                    label: "Código Documento",
                    sortable: true,
                },
                {
                    key: "funcionario.full_name",
                    label: "Funcionario",
                    sortable: true,
                },
                {
                    key: "cantidad_documentos",
                    label: "Cantidad de Documentos",
                    sortable: true,
                },
                { key: "fecha_hora_t", label: "Fecha y Hora", sortable: true },
                {
                    key: "descripcion",
                    label: "Descripción",
                    sortable: true,
                },
                {
                    key: "observacion",
                    label: "Observación",
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
            modal_accion: "nuevo",
            oDevolucionDocumento: {
                id: 0,
                documento_id: "",
                funcionario_id: "",
                cantidad_documentos: "",
                fecha: "",
                hora: "",
                descripcion: "",
                observacion: "",
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
        this.getDevolucionDocumentos();
    },
    methods: {
        // Seleccionar Opciones de Tabla
        editarRegistro(item) {
            this.oDevolucionDocumento.id = item.id;
            this.oDevolucionDocumento.documento_id = item.documento_id
                ? item.documento_id
                : "";
            this.oDevolucionDocumento.funcionario_id = item.funcionario_id
                ? item.funcionario_id
                : "";
            this.oDevolucionDocumento.cantidad_documentos =
                item.cantidad_documentos ? item.cantidad_documentos : "";
            this.oDevolucionDocumento.fecha = item.fecha ? item.fecha : "";
            this.oDevolucionDocumento.hora = item.hora ? item.hora : "";
            this.oDevolucionDocumento.descripcion = item.descripcion
                ? item.descripcion
                : "";
            this.oDevolucionDocumento.observacion = item.observacion
                ? item.observacion
                : "";
            this.oDevolucionDocumento.documento = item.documento
                ? item.documento
                : "";
            this.modal_accion = "edit";
            this.muestra_modal = true;
        },
        // Listar DevolucionDocumentos
        getDevolucionDocumentos() {
            this.showOverlay = true;
            this.muestra_modal = false;
            let url = main_url + "/admin/devolucion_documentos";
            if (this.pagina != 0) {
                url += "?page=" + this.pagina;
            }
            axios
                .get(url, {
                    params: { per_page: this.per_page },
                })
                .then((res) => {
                    this.showOverlay = false;
                    this.listRegistros = res.data.devolucion_documentos;
                    this.totalRows = res.data.total;
                });
        },
        eliminaDevolucionDocumento(id, descripcion) {
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
                        .post(main_url + "/admin/devolucion_documentos/" + id, {
                            _method: "DELETE",
                        })
                        .then((res) => {
                            this.getDevolucionDocumentos();
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
        abreModal(tipo_accion = "nuevo", devolucion_documento = null) {
            this.muestra_modal = true;
            this.modal_accion = tipo_accion;
            if (devolucion_documento) {
                this.oDevolucionDocumento = devolucion_documento;
            }
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },
        limpiaDevolucionDocumento() {
            this.oDevolucionDocumento.documento_id = "";
            this.oDevolucionDocumento.funcionario_id = "";
            this.oDevolucionDocumento.cantidad_documentos = "";
            this.oDevolucionDocumento.fecha = "";
            this.oDevolucionDocumento.hora = "";
            this.oDevolucionDocumento.descripcion = "";
            this.oDevolucionDocumento.observacion = "";
        },
        formatoFecha(date) {
            return this.$moment(String(date)).format("DD/MM/YYYY");
        },
    },
};
</script>

<style>
.contenedor_celda_devolucion_documentos {
    position: relative;
}
.span_total_devolucion_documentos {
    top: -10px;
    position: absolute;
}
</style>

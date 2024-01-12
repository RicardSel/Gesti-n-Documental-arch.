<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Reserva de Documentos</h1>
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
                                                    'reserva_documentos.create'
                                                )
                                            "
                                            class="btn btn-danger btn-flat btn-block"
                                            @click="
                                                abreModal('nuevo');
                                                limpiaReservaDocumento();
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
                                                    #cell(reserva_documentos)="row"
                                                >
                                                    <div
                                                        class="w-100 text-center contenedor_celda_reserva_documentos"
                                                    >
                                                        <span
                                                            class="badge badge-success text-md span_total_reserva_documentos"
                                                            >{{
                                                                row.item
                                                                    .adjuntar_reserva_documentos
                                                                    .length
                                                            }}</span
                                                        >
                                                        <button
                                                            type="button"
                                                            class="btn-flat btn-block rounded bg-transparent border-0"
                                                            @click="
                                                                reserva_documentosRegistro(
                                                                    row.item
                                                                )
                                                            "
                                                        >
                                                            <img
                                                                :src="
                                                                    url_principal +
                                                                    '/imgs/reserva_documentos.png'
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
                                                                    'reserva_documentos.edit'
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
                                                                    'reserva_documentos.destroy'
                                                                )
                                                            "
                                                            size="sm"
                                                            pill
                                                            variant="outline-danger"
                                                            class="btn-flat btn-block"
                                                            title="Eliminar registro"
                                                            @click="
                                                                eliminaReservaDocumento(
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
            :reserva_documento="oReservaDocumento"
            @close="muestra_modal = false"
            @envioModal="getReservaDocumentos"
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
                    key: "descripcion",
                    label: "Descripción",
                    sortable: true,
                },
                {
                    key: "observacion",
                    label: "Observación",
                    sortable: true,
                },
                { key: "fecha_hora_t", label: "Fecha y Hora", sortable: true },
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
            oReservaDocumento: {
                id: 0,
                documento_id: "",
                funcionario_id: "",
                descripcion: "",
                observacion: "",
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
        this.getReservaDocumentos();
    },
    methods: {
        // Seleccionar Opciones de Tabla
        editarRegistro(item) {
            this.oReservaDocumento.id = item.id;
            this.oReservaDocumento.documento_id = item.documento_id
                ? item.documento_id
                : "";
            this.oReservaDocumento.funcionario_id = item.funcionario_id
                ? item.funcionario_id
                : "";
            this.oReservaDocumento.descripcion = item.descripcion
                ? item.descripcion
                : "";
            this.oReservaDocumento.observacion = item.observacion
                ? item.observacion
                : "";
            this.oReservaDocumento.fecha = item.fecha ? item.fecha : "";
            this.oReservaDocumento.hora = item.hora ? item.hora : "";
            this.oReservaDocumento.documento = item.documento
                ? item.documento
                : "";
            this.modal_accion = "edit";
            this.muestra_modal = true;
        },
        // Listar ReservaDocumentos
        getReservaDocumentos() {
            this.showOverlay = true;
            this.muestra_modal = false;
            let url = main_url + "/admin/reserva_documentos";
            if (this.pagina != 0) {
                url += "?page=" + this.pagina;
            }
            axios
                .get(url, {
                    params: { per_page: this.per_page },
                })
                .then((res) => {
                    this.showOverlay = false;
                    this.listRegistros = res.data.reserva_documentos;
                    this.totalRows = res.data.total;
                });
        },
        eliminaReservaDocumento(id, descripcion) {
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
                        .post(main_url + "/admin/reserva_documentos/" + id, {
                            _method: "DELETE",
                        })
                        .then((res) => {
                            this.getReservaDocumentos();
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
        abreModal(tipo_accion = "nuevo", reserva_documento = null) {
            this.muestra_modal = true;
            this.modal_accion = tipo_accion;
            if (reserva_documento) {
                this.oReservaDocumento = reserva_documento;
            }
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },
        limpiaReservaDocumento() {
            this.oReservaDocumento.documento_id = "";
            this.oReservaDocumento.funcionario_id = "";
            this.oReservaDocumento.descripcion = "";
            this.oReservaDocumento.observacion = "";
            this.oReservaDocumento.fecha = "";
            this.oReservaDocumento.hora = "";
        },
        formatoFecha(date) {
            return this.$moment(String(date)).format("DD/MM/YYYY");
        },
    },
};
</script>

<style>
.contenedor_celda_reserva_documentos {
    position: relative;
}
.span_total_reserva_documentos {
    top: -10px;
    position: absolute;
}
</style>

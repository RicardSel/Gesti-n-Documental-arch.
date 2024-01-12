<template>
    <div
        class="modal fade contenedor_adjuntar_documentos"
        :class="{ show: bModal }"
        id="modal-default"
        aria-modal="true"
        role="dialog"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h4 class="modal-title" v-html="tituloModal"></h4>
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
                            <div class="col-md-12">
                                <p>
                                    <strong>Código documento: </strong>
                                    {{ documento.codigo }}
                                </p>
                            </div>
                            <div class="col-md-12">
                                <el-upload
                                    class="upload-demo"
                                    drag
                                    :action="''"
                                    :before-upload="beforeUpload"
                                    :file-list="fileList"
                                    list-type="picture"
                                    multiple
                                >
                                    <i class="el-icon-upload"></i>
                                    <div class="el-upload__text">
                                        Suelta tu archivo aquí o
                                        <em>haz clic para cargar</em>
                                    </div>
                                    <div slot="tip" class="el-upload__tip">
                                        Los archivos no deben pesar mas de 4096
                                        KB
                                    </div>
                                    <template v-slot:file="item">
                                        <div class="custom-file-item">
                                            <img
                                                v-if="
                                                    item.file.tipo == 'imagen'
                                                "
                                                :src="item.file.url"
                                                alt=""
                                                class="el-upload-list__item-thumbnail"
                                            />
                                            <img
                                                v-if="item.file.tipo == 'video'"
                                                :src="url_icono_videos"
                                                alt=""
                                                class="el-upload-list__item-thumbnail"
                                            />
                                            <img
                                                v-if="item.file.tipo == 'audio'"
                                                :src="url_icono_audios"
                                                alt=""
                                                class="el-upload-list__item-thumbnail"
                                            />
                                            <img
                                                v-if="
                                                    item.file.tipo == 'archivo'
                                                "
                                                :src="url_icono_archivos"
                                                alt=""
                                                class="el-upload-list__item-thumbnail"
                                            />
                                            <a
                                                :href="item.file.url"
                                                target="_blank"
                                                class="el-upload-list__item-name"
                                                ><i class="el-icon-document"></i
                                                >{{ item.file.archivo }} </a
                                            ><label
                                                class="el-upload-list__item-status-label"
                                                ><i
                                                    class="el-icon-upload-success el-icon-check"
                                                ></i></label
                                            ><i
                                                class="el-icon-close"
                                                @click="handleRemove(item.file)"
                                            ></i
                                            ><i class="el-icon-close-tip"
                                                >Pulse Eliminar para retirar</i
                                            >
                                        </div>
                                    </template>
                                </el-upload>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-end">
                    <button
                        type="button"
                        class="btn btn-default"
                        data-dismiss="modal"
                        @click="cierraModal"
                    >
                        Cerrar
                    </button>
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
        documento: {
            type: Object,
            default: {
                id: 0,
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
                adjuntar_documentos: [],
            },
        },
    },
    watch: {
        muestra_modal: function (newVal, oldVal) {
            this.errors = [];
            if (newVal) {
                this.url_subir_archivo =
                    main_url +
                    "/admin/adjuntar_documentos/store/" +
                    this.documento.id;
                this.bModal = true;
                this.getAdjuntarDocumentos();
            } else {
                this.bModal = false;
            }
        },
    },
    computed: {
        tituloModal() {
            return `DOCUMENTOS ADJUNTADOS`;
        },
    },
    data() {
        return {
            user: JSON.parse(localStorage.getItem("user")),
            bModal: this.muestra_modal,
            errors: [],

            url_subir_archivo:
                main_url +
                "/admin/adjuntar_documentos/store/" +
                this.documento.id,
            fileList: [],
            url_icono_videos: main_url + "/imgs/video-player.png",
            url_icono_audios: main_url + "/imgs/volume.png",
            url_icono_archivos: main_url + "/imgs/documents.png",
        };
    },
    mounted() {
        this.bModal = this.muestra_modal;
        this.fileList = this.documento.adjuntar_documentos;
    },
    methods: {
        getAdjuntarDocumentos() {
            axios
                .get(
                    main_url +
                        "/admin/documentos/adjuntar_documentos/" +
                        this.documento.id
                )
                .then((response) => {
                    this.documento.adjuntar_documentos =
                        response.data.adjuntar_documentos;
                    this.fileList = this.documento.adjuntar_documentos;
                });
        },
        handleRemove(file) {
            const index = this.fileList.indexOf(file); // Encuentra el índice del archivo en la lista
            Swal.fire({
                title: "¿Quierés eliminar este archivo?",
                html: `<strong>${file.archivo}</strong>`,
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                confirmButtonText: "Si, eliminar",
                cancelButtonText: "No, cancelar",
                denyButtonText: `No, cancelar`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    axios
                        .post(
                            main_url + "/admin/adjuntar_documentos/" + file.id,
                            {
                                _method: "DELETE",
                            }
                        )
                        .then((res) => {
                            this.getAdjuntarDocumentos();
                            setTimeout(() => {
                                this.$emit("actualizacion");
                            }, 300);
                            if (index !== -1) {
                                this.fileList.splice(index, 1); // Elimina el archivo de la lista
                                this.fileList = fileList; // Actualiza la lista de archivos
                            }
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
        handlePreview(file) {
            console.log(file);
        },
        beforeUpload(file) {
            const maxSizeInKB = 4096; // Peso máximo permitido en kilobytes (4096 KB)
            // if (file.size / 1024 <= maxSizeInKB) {
            const formData = new FormData();
            formData.append("file", file);
            let config = {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            };
            axios
                .post(this.url_subir_archivo, formData, config)
                .then((response) => {
                    setTimeout(() => {
                        this.$emit("actualizacion");
                    }, 300);
                    this.getAdjuntarDocumentos();
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

            return false;
            // } else {
            //     // El archivo supera el peso máximo permitido, muestra un mensaje de error
            //     this.$message.error(
            //         "El archivo supera el tamaño máximo permitido de 4096 KB"
            //     );
            //     return false;
            // }
        },

        // Dialog/modal
        cierraModal() {
            this.bModal = false;
            this.$emit("close");
        },
    },
};
</script>

<style>
.contenedor_adjuntar_documentos .el-upload,
.contenedor_adjuntar_documentos .el-upload-dragger {
    width: 100%;
}
</style>

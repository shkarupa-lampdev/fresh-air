<template>
    <div class="content-body">
        <div class="container">
            <div class="row page-titles">
                <div class="col p-0">
                    <h4>Hello, <span>Welcome here</span></h4>
                </div>
                <div class="col p-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">From</a>
                        </li>
                        <li class="breadcrumb-item active">Dropzone</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-success" v-if="sandFile">Ви відправили файл, очікуйте результат
                            </div>
                            <h4 class="card-title">Завантажте файл</h4>
                            <h6 class="card-subtitle">Переконайтесь, що Ви завантажуєте файл <code>.csv</code>, а також,
                                що цей файл містить лише показники за актуальні дати
                            </h6>
                            <form @submit.prevent="dropZoneHandle()" class="dropzone m-t-15" id="dropzone-form">
                                <div class="fallback">
                                    <input
                                        @change="onFileChange"
                                        ref="fileInput"
                                        name="file"
                                        type="file"
                                        multiple="multiple"
                                    >
                                </div>
                            </form>
                            <button
                                id="submit-dropzone"
                                type="submit"
                                class="btn btn-dark mb-2"
                                form="dropzone-form"
                            >Завантажити
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-content" v-if="showSuccess">
                <div class="alert alert-success">
                    <h4 class="alert-heading">Чудово!</h4>
                    <p>Ви успішно завантажили файл.</p>
                </div>
            </div>
            <div class="alert alert-danger" v-if="showFail">Не вдалось завантажити файл</div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "FormDropzone",
    data() {
        return {
            file: '',
            showSuccess: false,
            showFail: false,
            sandFile: false,
        }
    },
    methods: {
        async dropZoneHandle() {
            try {
                const formData = new FormData();
                formData.append('file', this.file);
                this.sandFile = true;

                await axios.post("/api/upload-csv", formData);
                this.showSuccess = true;
                this.showFail = false;
            } catch (e) {
                console.log(e);
                this.showSuccess = false;
                this.showFail = true;
            }

        },
        onFileChange(event) {
            this.file = event.target.files[0];

        }
    }
}
</script>

<style scoped>
#submit-dropzone {
    margin-top: 15px;
}
</style>

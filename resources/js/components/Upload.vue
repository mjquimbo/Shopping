<template>
    <div>
        <div class="image-upload-icon-container" @click="clear">
            <i>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-file-plus-fill" viewBox="0 0 16 16">
                    <path
                        d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM8.5 6v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 1 0z" />
                </svg>
            </i>
        </div>

        <div v-if="showModal" class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload File</h5>
                        <button type="button" class="close" @click="showModal = false">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img :src="imageHolder" alt="product-image" />
                        <input class="text-dark" type="file" @change="onFileChange">
                        <p v-if="hasError" class="text-danger">
                            The selected file is either invalid or exceeds the
                            allowed size limit
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="showModal = false">Close</button>
                        <button type="button" class="btn btn-secondary" @click="save">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "upload",
    props: {
        product: Object,
    },
    data() {
        return {
            showModal: false,
            selectedImage: null,
            hasError: false,
            imageHolder: this.product.image
        }
    },
    methods: {
        onFileChange(event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            if (file === undefined) {
                return;
            }

            if (file.size > 200000) {
                this.hasError = true;
                return;
            }

            reader.onload = (e) => {
                const contents = e.target.result;
                const mimeType = contents.split(",")[0].split(":")[1].split(";")[0];

                if (mimeType === "image/jpeg" || mimeType === "image/png") {
                    this.selectedImage = event.target.files[0];
                    this.hasError = false;
                    this.imageHolder = contents;
                } else {
                    this.hasError = true
                }
            };
            reader.readAsDataURL(file);
        },
        async save() {
            if (this.selectedImage !== null) {
                const formData = new FormData();
                formData.append('image', this.selectedImage);
                formData.append('product', JSON.stringify(this.product));
                const { data: { product, success } } = await axios.post("/admin/upload-image", formData);

                if (success) {
                    this.product.image = product.image
                    this.reset();
                } else {
                    this.hasError = true;
                }
            }
        },
        clear() {
            this.showModal = true;
            this.imageHolder = this.product.image;
            this.selectedImage = null;
            this.hasError = false;
        },
        reset() {
            this.showModal = false;
            this.imageHolder = this.product.image;
            this.selectedImage = null;
            this.hasError = false;
        }
    },
}
</script>

<style scoped>
.image-upload-icon-container {
    margin: auto;
    text-align: center;
    cursor: pointer;
}

.modal {
    display: block;
    position: fixed;
    z-index: 999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-dialog {
    position: relative;
    margin: 10% auto;
    padding: 0;
    width: 80%;
    max-width: 500px;
}

.modal-content {
    position: relative;
    background-color: #fefefe;
    border-radius: 0.3rem;
    box-shadow: 0 0.3rem 0.9rem rgba(0, 0, 0, 0.5);
}

.modal-header {
    padding: 1rem;
    border-bottom: 1px solid #ddd;
}

.modal-title {
    margin: 0;
}

.modal-body {
    padding: 1rem;
}

.modal-body>img {
    object-fit: contain;
    width: 200px;
    height: 100px;
}

.modal-footer {
    padding: 1rem;
    border-top: 1px solid #ddd;
    text-align: right;
}
</style>

<template>
    <div>
        <div class="image-upload-icon-container" @click="showHistoryOrder">
            <i>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-eye" viewBox="0 0 16 16">
                    <path
                        d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                    <path
                        d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
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
                        <div> {{user.username}}</div>
                        <hr/>
                        <div v-if="data.length > 0">
                            <div v-for="(item, index) in data" :key="index">
                                <div>QUANTITY: {{ item.total_quantity}}</div>
                                <div>PRICE: ${{ item.total_price}}</div>
                                <div>ORDER DATE: {{ item.created_at}}</div>
                                <hr/>
                            </div>
                        </div>
                        <div v-else>
                            NO ORDERS
                        </div>
                        <p v-if="hasError" class="text-danger">
                            The selected file is either invalid or exceeds the
                            allowed size limit
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="showModal = false">Close</button>
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
        user: Object,
    },
    data() {
        return {
            showModal: false,

            hasError: false,
            data: []

        }
    },
    methods: {
        async showHistoryOrder() {
            this.showModal = true;

              const {data} =  await axios.post(`/admin/orders`, {
                    userId: this.user.id
                });
              this.data = data;
        },
        onFileChange(event) {
            // const file = event.target.files[0];
            // const reader = new FileReader();
            //
            // if (file === undefined) {
            //     return;
            // }
            //
            // if (file.size > 200000) {
            //     this.hasError = true;
            //     return;
            // }
            //
            // reader.onload = (e) => {
            //     const contents = e.target.result;
            //     const mimeType = contents.split(",")[0].split(":")[1].split(";")[0];
            //
            //     if (mimeType === "image/jpeg" || mimeType === "image/png") {
            //         this.selectedImage = event.target.files[0];
            //         this.hasError = false;
            //         this.imageHolder = contents;
            //     } else {
            //         this.hasError = true
            //     }
            // };
            // reader.readAsDataURL(file);
        },
        async save() {
            // if (this.selectedImage !== null) {
            //     const formData = new FormData();
            //     formData.append('image', this.selectedImage);
            //     formData.append('product', JSON.stringify(this.product));
            //     const { data: { product, success } } = await axios.post("/admin/upload-image", formData);
            //
            //     if (success) {
            //         this.product.image = product.image
            //         this.reset();
            //     } else {
            //         this.hasError = true;
            //     }
            // }
        },
        clear() {
            this.showModal = true;

            this.selectedImage = null;
            this.hasError = false;
        },
        reset() {
            this.showModal = false;

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

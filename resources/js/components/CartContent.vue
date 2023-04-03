<template>
  <div>
    <div class="ps-2">Total Quantity: {{ cart.totalQuantity }}</div>
    <div class="ps-2">Total Price: ₱{{ cart.totalPrice }}</div>

    <div class="cart-container" v-if="isCartEmpty(cart.products)">
      <div class="col m-2 text-center" v-for="product in cart.products" :key="product.id">
        <div class="card">
          <img class="image-container p-3" :src="product.image" alt="product-image" />
          <div class="product-detail-container">
            <div>Brand: {{ product.brand }}</div>
            <div>Model: {{ product.model }}</div>
            <div>Original Price: ₱{{ product.price }}</div>

            <div>
              Quantity:
              <span class="decrement" @click="deleteProductToCart(product)">
                <i class="fa-solid fa-square-minus"></i>
              </span>
              <span class="m-1"> {{ product.pivot.quantity }} </span>
              <span class="increment" @click="addProductToCart(product)">
                <i class="fa-solid fa-square-plus"></i>
              </span>
              <div>Total Price: ₱{{ product.pivot.price }}</div>
              <button class="btn btn-danger m-2" @click="deleteProduct(product)">
                Delete
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-else>
      <div class="ps-2">Cart is Empty</div>
    </div>
  </div>
</template>

<script>
export default {
  name: "cart-content",
  computed: {
    cart() {
      return this.$store.getters.cart;
    },

  },
  methods: {
    async addProductToCart(product) {
      await axios.post(`/products/add-product/${product.id}`, {
        product: product,
      });
      const { data } = await axios.get("/cart/fetch-cart");
      this.$store.dispatch("setCart", data);
    },
    async deleteProductToCart(product) {
      await axios.post(`/products/delete-product/${product.id}`, {
        product: product,
      });
      const { data } = await axios.get("/cart/fetch-cart");
      this.$store.dispatch("setCart", data);
    },
    async deleteProduct(product) {
      await axios.post(`/products/delete-all-product/${product.id}`, {
        product: product,
      });
      const { data } = await axios.get("/cart/fetch-cart");
      this.$store.dispatch("setCart", data);
    },
    isCartEmpty(products) {
      return products && products.length > 0 ? true : false
    }
  },
  async mounted() { },
};
</script>

<style scoped>
.cart-container {
  display: grid;
  grid-template-columns: 1fr;
  width: 80%;
  margin: auto;
  row-gap: 1em;
  text-align: center;
}

.increment,
.decrement {
  cursor: pointer;
  font-weight: 500;
  font-size: 1em;
}

.image-container {
  width: 90%;
  height: 90%;
  object-fit: contain;
  margin: auto;
}

@media only screen and (min-width: 480px) {
  .cart-container {
    grid-template-columns: 1fr 1fr;
  }
}
</style>
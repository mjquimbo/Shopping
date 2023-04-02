<template>
  <div>
    <button class="btn btn-secondary m-2" @click="addProductToCart" >Add to Cart</button>
  </div>
</template>

<script>
export default {
  name: "add-product",
  props: {
    product: Object,
  },
  methods: {
    async addProductToCart() {
      await axios.post(`/products/add-product/${this.product.id}`, {
        product: this.product,
      });
      const { data } = await axios.get("/cart/fetch-cart");
      this.$store.dispatch("setCart", data);
      alert("item added");
    },
  },
};
</script>

<style scoped>
</style>
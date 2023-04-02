<template>
  <div style="padding-bottom:15px; font-weight:bold">
    Shopping Cart:
    <i class="fa-solid fa-cart-shopping"></i>
    <span>{{ cart.totalQuantity }}</span>
  </div>
</template>

<script>
export default {
  name: "shopping-cart",
  computed: {
    cart() {
      return this.$store.getters.cart;
    },
  },
  async mounted() {
    const { data } = await axios.get("/cart/fetch-cart");
    this.$store.dispatch("setCart", data);
  },
};
</script>

<style scoped>
div > span {
  margin-left: 5px;
}
</style>
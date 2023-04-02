<template>
  <span @click="signOut">Sign Out</span>
</template>

<script>
export default {
  name: "sign-out",
  methods: {
    signOut() {
      this.$store.dispatch("setCart", {
        products: null,
        total_quantity: 0,
        total_price: 0,
      });
    },
  },
};
</script>

<style scoped>
</style>

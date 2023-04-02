import { createStore } from "vuex";

const store = createStore({
    state: {
        cart: {
            products: null,
            totalQuantity: null,
            totalPrice: null,
        },
    },
    mutations: {
        setCart(state, payload) {
            state.cart.products = payload.products;
            state.cart.totalPrice = payload.total_price;
            state.cart.totalQuantity = payload.total_quantity;
        },
    },
    actions: {
        setCart(state, payload) {
            state.commit("setCart", payload);
        },
    },
    getters: {
        cart: (state) => state.cart,
    },
});
export default store;

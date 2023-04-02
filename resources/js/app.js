/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import { createApp } from "vue";
import "./bootstrap";
import AddProduct from "./components/AddProduct.vue";
import CartContent from "./components/CartContent.vue";
import ShoppingCart from "./components/ShoppingCart.vue";
import SignOut from "./components/SignOut.vue";
import OrderHistory from "./components/OrderHistoryt.vue";
import Upload from "./components/Upload.vue";
import store from "./store/store";
/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});
app.use(store);
app.component("add-product", AddProduct);
app.component("cart-content", CartContent);
app.component("shopping-cart", ShoppingCart);
app.component("upload-image", Upload);
app.component("order-history", OrderHistory);
app.component("sign-out", SignOut);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount("#app");

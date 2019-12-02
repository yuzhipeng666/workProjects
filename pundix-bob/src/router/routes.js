import Home from "@/views/Home.vue";
const Order = () => import("@/views/Order.vue");
const OrderConfirm = () => import("@/views/OrderConfirm.vue");

export const routes = [
  { path: "/", component: Home },
  { path: "/order", component: Order },
  { path: "/order-confirm", component: OrderConfirm }
];

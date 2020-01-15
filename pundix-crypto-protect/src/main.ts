import Vue from "vue";
import "./plugins/axios";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import i18n from "./i18n";
import "./plugins/px";
import { Time } from "./plugins/time";
import { Format } from "./plugins/format";

import "./assets/css/icon.css";

// import MiniRefreshTools from "minirefresh/dist/minirefresh.min";
// import "minirefresh/dist/minirefresh.min.css";

Vue.config.productionTip = false;

// Vue.use(MiniRefreshTools);

Vue.use(require("vue-moment"));

// 全局引入Slot文件夹
const requireSlot = require.context("./slots", false, /(.*).vue$/);

requireSlot.keys().forEach(fileName => {
  const slotConfig = requireSlot(fileName);

  const slotName = (fileName.split("/").pop() as string).replace(
    /\.\w+$/,
    "Slot"
  );

  Vue.component(slotName, slotConfig.default || slotConfig);
});

// 过滤倒计时天数
Vue.filter("countdownDay", function(val: number) {
  const data = Time.countdown(val);

  const dayWrite = window.vm.$tc("home.planList.day", data.day);
  const hourWirte = window.vm.$tc("home.planList.hours", data.hours);
  const minuWrite = window.vm.$tc("home.planList.minus", data.minus);
  const secondWrite = window.vm.$tc("home.planList.seconds", data.seconds);

  if (data.day > 0) {
    return `${dayWrite} ${data.hours > 0 ? hourWirte : ""}`;
  } else if (data.hours > 0) {
    return `${hourWirte} ${data.minus > 0 ? minuWrite : ""}`;
  } else if (data.minus > 0) {
    return `${minuWrite} ${data.seconds > 0 ? secondWrite : ""}`;
  } else if (data.seconds > 0) {
    return secondWrite;
  }
});

// 过滤倒计时天数/时分秒
Vue.filter("countdown", function(val: number) {
  return Time.countdown(val).result;
});

// 过滤数值
Vue.filter("amount", function(val?: number, len: number = 10) {
  if (!val) return val;

  return Format.amount(val, len);
});

Vue.filter("doubleNumber", Format.doubleNumber);

window.onload = () =>
  window.Pundix.init((token: string) => {
    window.vm = new Vue({
      router,
      store,
      i18n,
      render: (h: any) => h(App)
    }).$mount("#app");

    window.vm.$store.commit("SAVE_TOKEN", token);
  });

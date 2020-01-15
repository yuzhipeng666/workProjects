import Vue from "vue";
import Vuex from "vuex";

import common from "./common";

Vue.use(Vuex);

const localIsLite = localStorage.getItem("isLite");

export default new Vuex.Store({
  state: {
    // 用户token
    token: "",

    // 当前显示是否为精简版
    isLite: localIsLite === null ? true : JSON.parse(localIsLite)
  },
  getters: {
    isLite: ({ isLite }) => isLite
  },
  mutations: {
    // 保存用户token
    SAVE_TOKEN(state, token) {
      state.token = token;
    },

    CHANGE_IS_LITE(state) {
      state.isLite = !state.isLite;

      localStorage.setItem("isLite", state.isLite);
    }
  },
  actions: {},
  modules: {
    // 公共组件
    common
  }
});

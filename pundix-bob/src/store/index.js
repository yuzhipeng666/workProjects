import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    userNum: "",

    // 订单数据(需要提交的)
    orderForm: {
      num: 1,
      email: "",
      confirmEmail: "",
      fullName: "",
      phoneNumber: ""
    },
    // 订单数据(不需提交)
    orderInfo: {},

    // 错误通知
    notice: {
      isShow: false,
      msg: "",
      type: "error"
    },

    // 支付成功
    payConfirm: {
      isShow: false
    },

    // Loading
    loading: false
  },
  getters: {
    orderForm: ({ orderForm }) => orderForm,
    orderInfo: ({ orderInfo }) => orderInfo,
    notice: ({ notice }) => notice,
    payConfirm: ({ payConfirm }) => payConfirm,
    loading: ({ loading }) => loading
  },
  mutations: {
    SAVE_USER_NUM(state, userNum) {
      state.userNum = userNum;
    },

    SAVE_MODEL(state, { key, value }) {
      state.orderForm[key] = value;
    },

    SAVE_ALL(state, { form, info }) {
      form && (state.orderForm = form);
      info && (state.orderInfo = info);
    },

    SET_NOTICE(state, { msg, isShow = true, type }) {
      if (!isShow) return (state.notice.isShow = false);

      state.notice.isShow = isShow;
      state.notice.msg = msg;
      state.notice.type = type || "";
    },

    SET_PAY_CONFIRM(state, bool) {
      state.payConfirm.isShow = bool;

      if (bool) {
        state.orderForm.num = 1;
        state.orderForm.email = "";
        state.orderForm.confirmEmail = "";
        state.orderForm.fullName = "";
        state.orderForm.phoneNumber = "";
      }
    },

    SET_LOADING(state, bool) {
      state.loading = bool;
    }
  },
  actions: {},
  modules: {}
});

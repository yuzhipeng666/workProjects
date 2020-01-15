import { Module } from "vuex";

export default {
  namespaced: true,
  state: {
    // 弹窗
    confirm: {
      isShow: false,
      type: undefined,
      title: "",
      data: null,
      showCancel: true,
      confirmBtn: "",
      confirmHandler: undefined
    },

    // 加载
    loading: false,

    // 提示框
    toast: {
      msg: "",
      isShow: false,
      timer: null
    }
  },
  getters: {
    confirm: ({ confirm }) => confirm,
    loading: ({ loading }) => loading,
    toast: ({ toast }) => toast
  },
  mutations: {
    /** 改变弹窗内容的方法 */
    CHANGE_CONFIRM(
      state,
      {
        isShow = true,
        type = undefined,
        title = "",
        data = null,
        showCancel = false,
        confirmBtn = "",
        confirmHandler = undefined
      }: CommonConfirm
    ) {
      state.confirm.isShow = isShow;
      state.confirm.type = type;
      state.confirm.title = title;
      state.confirm.data = data;
      state.confirm.showCancel = showCancel;
      state.confirm.confirmBtn = confirmBtn;
      state.confirm.confirmHandler = async (data?: any) => {
        confirmHandler && (await confirmHandler(data));

        state.confirm.isShow = false;
      };
    },

    /** 改变loading状态 */
    CHANGE_LOADING(state, bool) {
      state.loading = bool;
    },

    /** toast状态 */
    CHANGE_TOAST(state, { isShow = true, msg }: CommonToast) {
      state.toast.isShow = isShow;
      state.toast.msg = msg;

      // 显示状态为true时，设置定时器关闭toast
      if (isShow) {
        // 清除上一次的定时器
        clearTimeout(state.toast.timer);

        state.toast.timer = setTimeout(() => {
          state.toast.isShow = false;
        }, 2500);
      }
    }
  }
} as Module<
  {
    confirm: CommonConfirm;
    loading: boolean;
    toast: CommonToast;
  },
  any
>;

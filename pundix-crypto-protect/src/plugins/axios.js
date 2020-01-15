"use strict";

import Vue from "vue";
import axios from "axios";

// Full config:  https://github.com/axios/axios#request-config
// axios.defaults.baseURL = process.env.baseURL || process.env.apiUrl || '';
// axios.defaults.headers.common['Authorization'] = AUTH_TOKEN;
// axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

let config = {
  baseURL: window.location.origin + "/cryptoBoom"
  // timeout: 60 * 1000, // Timeout
  // withCredentials: true, // Check cross-site Access-Control
};

const _axios = axios.create(config);

_axios.interceptors.request.use(
  function(config) {
    if (window.vm) {
      config.headers.Authorization = window.vm.$store.state.token;
      // config.headers.Authorization = "8c77781f-5aa4-4324-a3e6-606d4bb32f7a";

      // 访问接口时打开loading
      window.vm.$store.commit("common/CHANGE_LOADING", true);
    }

    // Do something before request is sent
    return config;
  },
  function(error) {
    // Do something with request error
    return Promise.reject(error);
  }
);

// Add a response interceptor
_axios.interceptors.response.use(
  function(response) {
    if (response.status === 200) {
      switch (response.data.code) {
        case 200:
          return Promise.resolve(response.data.data);
        default:
          window.vm.$store.commit("common/CHANGE_TOAST", {
            msg: response.data.msg
          });
          return Promise.reject(response.data);
      }
    } else {
      window.vm.$store.commit("common/CHANGE_TOAST", { msg: "Server error" });
      return Promise.reject("Server error");
    }
  },
  function(error) {
    // Do something with response error
    window.vm.$store.commit("common/CHANGE_TOAST", { msg: error });
    return Promise.reject(error);
  }
);

Plugin.install = function(Vue, options) {
  Vue.axios = _axios;
  window.axios = _axios;
  Object.defineProperties(Vue.prototype, {
    axios: {
      get() {
        return _axios;
      }
    },
    $axios: {
      get() {
        return _axios;
      }
    }
  });
};

Vue.use(Plugin);

export default Plugin;

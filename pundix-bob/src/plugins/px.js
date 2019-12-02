const http = {
  // 获取pundix初始数据
  getSetup() {
    return window.axios.get("/api/v1/xwallet/setup");
  },

  // 保存授权xwallet信息
  saveAuthInfo(data) {
    return window.axios.post("/api/v1/xwallet/authinfo", data);
  }
};

export const pundix = {
  authToken: "",

  // 初始化Pundix jssdk
  async init(callback) {
    const data = await http.getSetup();

    const debug = process.env.NODE_ENV === "development";

    window.PX.init({
      ...data.initParams,
      debug,
      jsApiList: ["auth", "pay"], //  必填，
      // 初始化成功
      success: () => {
        this.authToken = data.authParams.authToken;

        callback();
      },
      // 初始化失败
      fail(err) {
        // console.log("init: ", err);
        alert("Initialization unsuccessful, please restart the DApp");
        return err;
      }
    });
  },

  // 授权
  auth() {
    return new Promise((resolve, reject) => {
      window.PX.auth({
        authToken: this.authToken,
        async success(res) {
          try {
            // 保存授权信息
            const data = await http.saveAuthInfo(res);

            resolve(data.userNum);
          } catch (error) {
            reject(error);
          }
        },
        fail(err) {
          switch (err.code) {
            case 40001:
              return reject(window.vm.$t("error.10005"));
            default:
              return reject(err.msg);
          }
        }
      });
    });
  },

  pay(data) {
    return new Promise((resolve, reject) => {
      window.PX.pay({
        ...data,
        success(res) {
          resolve(res);
        },
        fail(err) {
          switch (err.code) {
            case 40001:
              return reject(window.vm.$t("error.10004"));
            case 40002:
              return reject(window.vm.$t("error.10006"));
            default:
              return reject(err.msg);
          }
        }
      });
    });
  },

  newPage(link) {
    window.PX.newPage({ link });
  }
};

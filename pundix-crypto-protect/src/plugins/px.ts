import { PxInitParams, PxAuthParams, PxConvertParams } from "@/px";
import { logs } from "./logs";

class httpRequest {
  /**
   * 获取Xwallet初始化数据
   */
  getXwalletInit() {
    return window.axios.post<PxInitParams>("/auth/xwallet/init");
  }

  /**
   * 获取授权数据
   */
  getXwalletAuth() {
    return window.axios.post<PxAuthParams>("/auth/xwallet/authToken");
  }

  saveAccessToken(accessToken: string) {
    return window.axios.post<{ id: number; name: string; token: string }>(
      "/auth/xwallet/login",
      { accessToken }
    );
  }
}

export class Pundix extends httpRequest {
  async init(callback?: Function) {
    // 获取初始化数据
    const data = await this.getXwalletInit();

    window.PX.init({
      ...data,
      debug: process.env.NODE_ENV !== "development",
      success: opt => {
        logs("Init success: ", opt);

        this.auth(callback);
      },
      fail(err) {
        logs("Init fail: ", err);
      }
    });
  }

  async auth(callback?: Function) {
    const data = await this.getXwalletAuth();

    window.PX.auth({
      ...data,
      success: async opt => {
        logs("Auth success: ", opt);

        const data = await this.saveAccessToken(opt.accessToken);

        callback && callback(data.token);
      },
      fail(err) {
        logs("Auth fail: ", err);
      }
    });
  }

  pay(data: PayParamsResponse, callback?: Function, fail?: Function) {
    window.PX.pay({
      ...data,
      type: 0,
      success(data) {
        logs("Pay success: ", data);

        callback && callback();
      },
      fail(err) {
        logs("Pay fail: ", err);

        // 提示Toast
        window.vm.$store.commit("common/CHANGE_TOAST", {
          msg: window.vm.$t(`errMsg.${err.code}`)
        });

        fail && fail(err.code);
      }
    });
  }

  convert(data: PxConvertParams, callback?: Function) {
    window.PX.convert({
      ...data,
      type: 0,
      success(data) {
        logs("Convert success: ", data);

        callback && callback();
      },
      fail(err) {
        logs("Convert fail: ", err);
      }
    });
  }
}

window.Pundix = new Pundix();

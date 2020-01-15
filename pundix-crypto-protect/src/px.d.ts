type jsApiList = "auth" | "pay" | "withdraw";

interface PxCommonFunc<S, F = { msg: string; code: number }> {
  success(opt: S): void;
  fail(err: F): void;
}

// 授权 参数
interface PxInitParams
  extends PxCommonFunc<{ auth: boolean; convert: boolean; pay: boolean }> {
  appId: string;
  timestamp: number;
  nonceStr: string;
  sign: string;
  jsApiList?: jsApiList[];
  debug?: boolean;
}

// 授权 参数
interface PxAuthParams
  extends PxCommonFunc<{
    accessToken: string;
    openId: string;
    refreshToken: string;
  }> {
  authToken: string;
}

// 支付 参数
interface PxPayParams extends PxCommonFunc<{ result: string }> {
  timestamp: number;
  nonceStr: string;
  data: string;
  sign: string;
  type?: 0 | 1;
}

// 兑换 参数
interface PxConvertParams extends PxCommonFunc<{ result: string }> {
  timestamp: number;
  nonceStr: string;
  data: string;
  sign: string;
  type?: 0 | 1;
}

// 自定义分享 参数
interface PxSharedDataParams {
  title: string;
  imgUrl: string;
  description: string;
  link: string;
}

// 打开新窗口 参数
interface PxNewPageParams {
  link: string;
}

export interface PxMain {
  init: (params: PxInitParams) => void;
  auth: (params: PxAuthParams) => void;
  pay: (params: PxPayParams) => void;
  convert: (params: PxConvertParams) => void;
  sharedData: (params: PxSharedDataParams) => void;
  newPage: (params: PxNewPageParams) => void;
}

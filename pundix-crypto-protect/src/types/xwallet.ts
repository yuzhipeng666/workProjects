/**
 * 支付面板前调用接口的所需参数
 */
interface PayParamsRequest {
  amount: number;
  rechargeUnit: string;
}

/**
 * 支付面板前准备的数据
 */
interface PayParamsResponse {
  /** appId */
  appId?: string;
  /** data */
  data: string;
  /** nonce */
  nonceStr: string;
  /** 签名 */
  sign: string;
  /** 时间戳 */
  timestamp: number;
}

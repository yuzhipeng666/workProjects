interface CommonConfirm {
  /** 显示状态 */
  isShow?: boolean;
  /** 弹窗类型 */
  type?:
    | "issue"
    | "notice"
    | "deposit"
    | "withdraw"
    | "confirmation"
    | "lastTime"
    | "currentPrice";
  /** 标题 */
  title?: string;
  /** 数据 */
  data?: any;
  /** 是否显示取消按钮 */
  showCancel?: boolean;
  /** 确定按钮文案 */
  confirmBtn?: string;
  /** Confirm处理程序 */
  confirmHandler?: Function;
}

interface CommonConfirmDepositFillList {
  fillValue?: number;
}

interface CommonConfigDepositResponse {
  /** 填充列表 */
  coinFillConfigList: CommonConfirmDepositFillList[];
  /** 汇率 */
  exchangeRate: number;
  /** 参考币种(目前是usd) */
  referenceUnit: string;
}

/**
 * Notice 弹窗的data数据
 */
interface CommonConfirmNoticeData {
  /** 行权剩余时间倒计时 */
  dt: number;
  /** 行权类型 */
  type: "protected" | "profit";
  /** 浮盈 */
  profit: number;
  /** 收益币种 */
  unit: string;
}

/**
 * 提示框
 */
interface CommonToast {
  msg: string;
  isShow?: boolean;
  timer?: any;
}

/**
 * 页码请求
 */
interface CommonPageRequest {
  pageSize: number;
  prevId: number;
}

// ---------------- 确认支付弹窗 --------------
interface IConfirmationDataInfo {
  /** 总支付金额 */
  total: number;
  /** 支付币种 */
  totalUnit: string;
  /** 收益币金额 */
  earn: number;
  /** 收益币种 */
  earnUnit: string;
  /** 钱包余额 */
  balance: number;
  /** 余额单位 */
  balanceUnit: string;
}

interface IConfirmationDataForm {
  investPart: number;
}

interface IConfirmationData {
  info: IConfirmationDataInfo;
  form: IConfirmationDataForm;
  other: BuyLitePlanDetail | BuyProPlanDetail;
  payFail: Function;
}

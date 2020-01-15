interface BuyPlanDetailCommon {
  /** 购买币种(投资币种)可用余额 */
  availableBalance: number;
  /** 某天的第几条计划 */
  dayNumber: number;
  /**  每份多少收益 */
  earnAmountOfPerPart: number;
  /** 收益币种图标 */
  earnIcon: string;
  /** 收益币种对应投资币种汇率 */
  earnToInvestExchangeRate: number;
  /** 收益币种 */
  earnUnit: string;
  /** 购买手续费比例% */
  feeRate: number;
  /** 购买币种 */
  investUnit: string;
  /** 最大可购买份数 */
  maxInvestPart: number;
  /** 行权日期(例如:1201)  */
  monthDay: string;
  /** 名称 */
  planName: string;
  /** 结束行权时间(完成时间) */
  exerciseEndDt: number;
  /** 结束冻结时间(行权开始时间) */
  freezeEndDt: number;
}

// ------------------- 完整版 -------------------
/**
 * 当前购买计划的详情
 */
interface BuyProPlanDetail extends BuyPlanDetailCommon {
  /** 结束购买时间(冻结开始时间) */
  investEndDt: number;
  /** 服务器当前时间 */
  systemDt: number;
}

// --------------------- 精简版 -----------------------
/**
 * 当前查看的计划详情
 */
interface BuyLitePlanDetail extends BuyPlanDetailCommon {
  // annualizedRate: PlanAnnualizedRate;
}

/**
 * 购买当前计划接口接收的参数
 */
interface BuyPlanRequest {
  /**   投资份数 */
  investPart: number;
  /**  计划id */
  planId: number;
}

/**
 * 购买当前计划接口返回的内容
 */
interface BuyPlanResponse {
  /** appId */
  appId: string;
  /** 充值订单号 */
  data: string;
  /** 投资收益币种的总数量=购买份数*每份数量 */
  earnAmount: number;
  /** nonce */
  nonceStr: string;
  /** 支付状态 */
  pay: boolean;
  /** 签名 */
  sign: string;
  /** 时间戳 */
  timestamp: number;
  /** 用户支付订单id */
  userOrderPayPlanId: number;
  /** 收益币种 */
  earnUnit: string;
  /** 结束行权时间(完成时间) */
  exerciseEndDt: number;
  /** 结束冻结时间(行权开始时间) */
  freezeEndDt: number;
  /** 购买币种 */
  investUnit: string;
  /** 服务器当前时间 */
  systemDt: number;
}

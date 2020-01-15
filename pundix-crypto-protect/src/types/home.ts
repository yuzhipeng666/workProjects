/**
 * 精简版/完整版共同存在的字段
 */
// interface PlanListCommon {
//   /** 某天的第几条计划 */
//   dayNumber: number;
//   /** 收益币种图标 */
//   earnIcon: string;
//   /** 收益币种对应投资币种汇率 */
//   earnToInvestExchangeRate: number;
//   /** 收益币种 */
//   earnUnit: string;
//   /** 购买币种 */
//   investUnit: string;
//   /** 行权日期(例如:1201) */
//   monthDay: string;
//   /** id */
//   planId: string;
//   /** 名称 */
//   planName: string;
// }

// -------------------- 完整版 -------------------
/**
 * 计划列表信息
 */
// interface PlanList extends PlanListCommon {
//   /** 每份多少收益 */
//   earnAmountOfPerPart: number;
//   /** 一份多少价格 */
//   exchangeRatePart: number;
//   /** 结束行权时间(完成时间) */
//   exerciseEndDt: number;
//   /** 结束冻结时间(行权开始时间) */
//   freezeEndDt: number;
//   /** 结束购买时间(冻结开始时间); */
//   investEndDt: number;
//   /** 开始购买时间(预售结束时间) */
//   investStartDt: number;
//   /** 已售出百分比 */
//   percentSold: number;
//   /** 状态(0:预热中; 1:销售中) */
//   status: 0 | 1;
//   /** 服务器当前时间 */
//   systemDt: number;
// }

/**
 * 计划列表
 */
interface PlanResponse<T> {
  /** 可否翻页 */
  hasNext: boolean;
  list: T[];
}

// ---------------- 精简版 -------------------
/**
 * 年化率信息
 */
// interface PlanAnnualizedRate {
//   /** 比价基数时间 */
//   baseDt: number;
//   /** 比价基础汇率 */
//   baseExchangeRate: number;
//   /** 涨幅 */
//   riseRate: number;
//   /** 类型(0:浮盈; 1:保护;) */
//   riseRateType: number;
//   /** 目标时间 */
//   targetDt: number;
//   /** 目标汇率 */
//   targetExchangeRate: number;
// }

// /**
//  * 计划列表数据
//  */
// interface PlanLiteList extends PlanListCommon {
//   /** 年化率信息 */
//   annualizedRate: PlanAnnualizedRate;
// }

/**
 * 计划列表
 */
interface PlanLiteResponse {
  /** 可否翻页 */
  // hasNext: boolean;
  // list: PlanLiteList[];
}

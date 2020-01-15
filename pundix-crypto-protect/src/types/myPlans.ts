// interface IMyPlansListCommon {
//   /** 某天的第几条计划 */
//   dayNumber: number;
//   /** 收益币种的总数量 */
//   earnAmount: number;
//   /** 收益币种图标 */
//   earnIcon: string;
//   /** 收益币种 */
//   earnUnit: string;
//   /** 购买币种 */
//   investUnit: string;
//   /** 行权日期(例如:1201) */
//   monthDay: string;
//   /** 订单应付金额 */
//   orderInvestAmount: number;
//   /** 名称 */
//   planName: string;
//   /** 状态(0:冻结中; 1:行权中; 2:已行权; 3:结算中; 4:完成) */
//   status: number;
// }

// --------------------- Lite ---------------------
// interface IMyPlansLiteList extends IMyPlansListCommon {
//   /** 收益币涨幅 */
//   earnRiseRate: number;
//   /** 购买币涨幅 */
//   investRiseRate: number;
// }

// -------------------- Pro ---------------------
/**
 * 计划列表
 */
// interface IMyPlansProList extends IMyPlansListCommon {
//   /** 购买时间 */
//   buyDt: number;
//   /** 结束行权时间(完成时间) */
//   exerciseEndDt: number;
//   /** 结束冻结时间(行权开始时间) */
//   freezeEndDt: number;
//   /** 涨幅 */
//   annualizedRate: number;
//   /** 涨幅类型(0:浮盈(Floating); 1:保护(Protected); 2:利润(Profit)) */
//   riseRateType: number;
//   /** 服务器当前时间 */
//   systemDt: number;
//   /** 用户操作时间(行权时间) */
//   userOpDt: number;
//   /** id */
//   userPlanId: number;
// }

/**
 * 用户投资计划列表(response)
 */
interface SearchUserPlanResponse<T> {
  /** 可否翻页 */
  hasNext: boolean;
  /** 列表 */
  list: T[];
}

/**
 * 用户投资计划列表(request)
 */
interface SearchUserPlanRequest {
  pageSize: number;
  prevId: string;
  /** 状态(0:进行中, 1:完成) */
  status: "0" | "1";
}

/**
 * 用户投资计划详情(response)
 */
// interface SearchUserPlanDetail extends IMyPlansProList {
//   /** 收益币涨幅 */
//   earnRiseRate: number;
//   /** 收益币种对应投资币种汇率(您购买的价格) */
//   earnToInvestExchangeRateBuy: number;
//   /** 收益币种对应投资币种汇率(当前价格或结束价格) */
//   earnToInvestExchangeRateNew: number;
//   /** 结束购买时间(冻结开始时间) */
//   investEndDt: number;
//   /** 购买币涨幅 */
//   investRiseRate: number;
// }

/**
 * 行权结束
 */
interface ExerciseFinish {
  /** 订单应付金额(回款金额) */
  orderInvestAmount: number;
}

/**
 * 行权取消
 */
interface ExerciseCancel {
  /** 投资收益币种的总数量 */
  earnAmount: number;
}

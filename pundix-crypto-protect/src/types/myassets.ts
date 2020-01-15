/**
 * 当前持仓金额
 */
// interface GamingPlanAmount {
//   /** 币种余额 */
//   amount: number;
//   /** 币种 */
//   unit: string;
// }

/**
 * 币种余额列表
 */
// interface CoinDetailList {
//   /** 币种余额 */
//   amount: number;
//   /** 币种icon */
//   icon: string;
//   /** 币种 */
//   unit: string;
// }

/**
 * 查询用户资产
 */
// interface SearchMyAssetResponse {
//   /** 币种余额列表 */
//   coinDetailList: CoinDetailList[];
//   /** 当前持仓金额 */
//   gamingPlanAmount: GamingPlanAmount;
//   /** 总资产(余额+当前持仓金额) */
//   totalAsset: number;
//   /** 总余额(可用余额) */
//   totalBalance: number;
//   /** 币种 */
//   unit: string;
// }

// ----------------------------------------------------------
// type historyBillType = 0 | 1;

/**
 * 历史记录列表
 */
// interface HistoryList {
//   /** 动作类型(7:用户提现; 9:用户充值; 10:加密游戏投资付款(应付); 11:加密游戏投资付款(手续费); 12:加密游戏投资收益; 13:加密游戏投资行权赎回)) , */
//   actionType: number;
//   /** 币种额度 , */
//   amount: number;
//   /** 账单类型(0:入账; 1:出账) , */
//   billType: historyBillType;
//   /** 某天的第几条计划 */
//   dayNumber: number;
//   /** 创建时间 , */
//   dt: number;
//   /** 结束行权时间(完成时间) , */
//   exerciseEndDt: number;
//   /** 行权日期 */
//   monthDay: string;
//   /** 产品类型, 0:Protect , */
//   productType: number;
//   /** 标题 , */
//   title: string;
//   /** 币种单位 */
//   unit: string;
// }

// /**
//  * 查询用户资产历史记录
//  */
// interface SearchAssetHistoryPageResponse {
//   /** 可否翻页 */
//   hasNext: boolean;
//   /** 列表 */
//   list: HistoryList[];
// }

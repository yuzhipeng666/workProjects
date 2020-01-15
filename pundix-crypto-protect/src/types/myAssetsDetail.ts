/**
 * 查询某个币的资产
 */
interface SearchAssetCoin {
  /** 可用余额(转换币余额目前暂时是usd) */
  availableAmountConversionUnit: number;
  /** 可用余额 */
  availableAmount: number;
  /** 转换单位(目前暂时是usd) */
  conversionUnit: string;
  /** 冻结余额 */
  lockAmount: number;
  /** 冻结余额(转换币余额目前暂时是usd) */
  lockAmountConversionUnit: number;
  /** 总余额 */
  totalAmount: number;
  /** 总余额(转换币余额目前暂时是usd) */
  totalAmountConversionUnit: number;
}

/**
 * 查询提现信息
 */
interface SearchWithdrawal {
  /** 可提现余额 */
  amount: number;
  /** 币种兑换参考币种汇率 */
  exchangeRate: number;
  /** 参考币种(目前是usd) */
  referenceUnit: string;
}

/**
 * 发起提现接口(request)
 */
interface withdrawalRequest {
  amount: number;
  unit: string;
}

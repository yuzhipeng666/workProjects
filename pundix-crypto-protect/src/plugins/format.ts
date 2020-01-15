export class Format {
  /**
   * 格式化金额
   * @param val 需要格式化的金额
   * @param len 输出格式的长度
   */
  static amount(val: number, len = 10) {
    const float = val
      .toFixed(len)
      .replace(/(?:\.0*|(\.\d+?)0+)$/, "$1")
      .split(".");

    float[0] = float[0].replace(/(\d)(?=(?:\d{3})+$)/g, "$1,");

    return float.join(".");
  }

  /**
   * 小于10的数字，在前面补0
   * @param val 数字类型
   */
  static doubleNumber(val: number) {
    return val < 10 ? `0${val}` : val;
  }
}

/** 转换为Date格式 */
function getDate(dt: Date) {
  return new Date(dt);
}

/** 小于10前面补全一个0 */
function completion(num: number) {
  return num < 10 ? `0${num}` : num;
}

export class Time {
  // 生成时间戳
  static timestamp(dt: any) {
    return getDate(dt).valueOf();
  }

  // 格式化
  static format(dt: any, format = "YYYY/MM/DD HH:II:SS") {
    if (!dt) return dt;

    const time = getDate(dt);

    const conversion = {
      year: time.getFullYear(),
      month: completion(time.getMonth() + 1),
      date: completion(time.getDate()),
      hour: completion(time.getHours()),
      minute: completion(time.getMinutes()),
      second: completion(time.getSeconds())
    };

    return format
      .replace("YYYY", conversion.year.toString())
      .replace("MM", conversion.month.toString())
      .replace("DD", conversion.date.toString())
      .replace("HH", conversion.hour.toString())
      .replace("II", conversion.minute.toString())
      .replace("SS", conversion.second.toString());
  }

  // 倒计时
  static countdown(dt: number) {
    const day = Math.floor(dt / 1000 / 60 / 60 / 24);

    // ------- 自动补全0 ---------
    const hours = Math.floor((dt / 1000 / 60 / 60) % 24); // 小时
    const minus = Math.floor((dt / 1000 / 60) % 60); // 分
    const seconds = Math.floor((dt / 1000) % 60); // 秒

    const timeResult = `${completion(hours)}:${completion(minus)}:${completion(
      seconds
    )}`;
    const dayResult = `${day} days, `;

    return {
      day,
      hours,
      minus,
      seconds,
      result: (day ? dayResult : "") + timeResult
    };
  }
}

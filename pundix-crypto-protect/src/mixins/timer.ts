import { Vue, Component } from "vue-property-decorator";

type dtKey = "exerciseEndDt" | "freezeEndDt" | "investEndDt" | "investStartDt";

@Component
export default class Timer extends Vue {
  /** 服务器时间 */
  systemDt = 0;
  /** 定时器 */
  timeFunc = null as any;

  /**
   * 计时器
   * @param dt 需要对比的时间
   * @param param1 回调事件
   */
  timerHandler(
    dt: number,
    callback?: { timeFunc?: Function; endFunc?: Function }
  ) {
    clearTimeout(this.timeFunc);

    if (this.systemDt > dt)
      return callback && callback.endFunc && callback.endFunc();

    this.timeFunc = setTimeout(() => {
      this.systemDt += 1000;

      callback && callback.timeFunc && callback.timeFunc();
    }, 1000);
  }
}

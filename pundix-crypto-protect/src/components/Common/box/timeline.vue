<template>
  <div class="timeline">
    <div class="timelint-main">
      <strong class="title">{{ $t("common.timeline.title.frozen") }}</strong>
      <ul class="timeline-box">
        <!-- 虚线 -->
        <div class="dotted-line" :class="{ active: checkActive(finishDt) }">
          <div
            class="active"
            :style="{
              transform: `translateY(${dottedLineActiveHeight}%)`
            }"
          ></div>
        </div>
        <li
          v-if="type === 1"
          class="frozen"
          :class="{ active: checkActive(boughtDt) }"
        >
          <p class="status">{{ $t("common.timeline.list.status.bought") }}</p>
          <p class="time">{{ boughtDt | moment("MMM DD, HH:mm:ss") }}</p>
        </li>
        <li v-else class="frozen" :class="{ active: checkActive(newSystemDt) }">
          <p class="status">{{ $t("common.timeline.list.status.buyItNow") }}</p>
          <p class="time">{{ newSystemDt | moment("MMM DD, HH:mm:ss") }}</p>
        </li>
        <li class="frozen" :class="{ active: checkActive(frozenDt) }">
          <p class="status">{{ $t("common.timeline.list.status.frozen") }}</p>
          <p class="time">{{ frozenDt | moment("MMM DD, HH:mm:ss") }}</p>
        </li>
        <strong class="title">{{
          $t("common.timeline.title.exercise")
        }}</strong>
        <li class="exercise" :class="{ active: checkActive(exerciseDt) }">
          <p class="status">{{ $t("common.timeline.list.status.exercise") }}</p>
          <p class="time">{{ exerciseDt | moment("MMM DD, HH:mm:ss") }}</p>
        </li>
        <li class="exercise" :class="{ active: checkActive(finishDt) }">
          <p class="status">{{ $t("common.timeline.list.status.finish") }}</p>
          <p class="time">{{ finishDt | moment("MMM DD, HH:mm:ss") }}</p>
        </li>
      </ul>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";

@Component
export default class Timeline extends Vue {
  /** buy的类型, 0: 未购买 1: 已购买 */
  @Prop(Number) type!: 0 | 1;
  /** 购买时间 */
  @Prop(Number) boughtDt!: number;
  /** 冻结时间 */
  @Prop(Number) frozenDt!: number;
  /** 行权时间 */
  @Prop(Number) exerciseDt!: number;
  /** 结束时间 */
  @Prop(Number) finishDt!: number;
  /** 当前系统时间 */
  @Prop(Number) systemDt!: number;

  /** 当前时间 */
  get newSystemDt() {
    return this.systemDt;
  }

  // 激活的线条长度
  get dottedLineActiveHeight() {
    if (this.checkActive(this.finishDt)) {
      return 0;
    } else if (this.checkActive(this.exerciseDt)) {
      return -32;
    } else if (this.checkActive(this.frozenDt)) {
      return -68;
    } else {
      return -90;
    }
  }

  checkActive(dt: number) {
    return dt <= this.systemDt;
  }
}
</script>

<style scoped>
.timeline {
  padding: 0 0.18rem;
}

.timeline .title {
  display: block;
  font-size: 0.14rem;
  color: #333333;
  margin: 0.14rem 0;
}

.timeline .timelint-main {
  width: 2.5rem;
  margin-left: auto;
}

.timeline .timeline-box {
  position: relative;
}

.timeline .timeline-box li {
  border-radius: 0.04rem;
  padding: 0.08rem 0.18rem;
  box-sizing: border-box;
  position: relative;
}

.timeline .timeline-box li + li {
  margin-top: 0.1rem;
}

.timeline .timeline-box li.frozen {
  background-color: #4a56b9;
}

.timeline .timeline-box li.exercise {
  background-color: #ff8717;
}

.timeline .timeline-box li.exercise .time {
  color: #fecfa3;
}

.timeline .timeline-box li::after {
  content: "";
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.4);
  z-index: 10;
}

.timeline .timeline-box li.active::after {
  background-color: transparent;
}

.timeline .timeline-box li::before {
  content: "";
  display: inline-block;
  width: 0.08rem;
  height: 0.08rem;
  background: url(../../../assets/ic_gou_3_nor.svg) no-repeat center / cover;
  position: absolute;
  left: -0.18rem;
  top: 50%;
  transform: translate(-100%, -50%);
}

.timeline .timeline-box li.active::before {
  width: 0.12rem;
  height: 0.12rem;
  background: url(../../../assets/ic_gou_2.svg) no-repeat center / cover;
  left: -0.16rem;
}

.timeline .timeline-box li .status {
  font-size: 0.14rem;
  color: #ffffff;
}

.timeline .timeline-box li .time {
  font-size: 0.12rem;
  color: #a3aae4;
  margin-top: 0.02rem;
}

.timeline .timeline-box .dotted-line {
  width: 0.08rem;
  height: 100%;
  position: absolute;
  top: 0;
  left: -0.22rem;
  transform: translateX(-50%);
  overflow: hidden;
}

.timeline .timeline-box .dotted-line::before {
  content: "";
  position: absolute;
  width: 0.01rem;
  height: calc(100% - 0.08rem);
  left: 50%;
  top: 0;
  background: linear-gradient(
    to bottom,
    rgba(74, 86, 185, 0.26),
    rgba(74, 86, 185, 0.26) 0.02rem,
    transparent 0.02rem,
    transparent 0.02rem
  );
  background-size: 100% 0.06rem;
  transform: translateX(-50%);
}

.timeline .timeline-box .dotted-line::after {
  content: "";
  position: absolute;
  width: 0;
  height: 0;
  border-color: rgba(74, 86, 185, 0.26) transparent transparent transparent;
  border-style: solid;
  border-width: 0.08rem 0.04rem 0;
  left: 50%;
  bottom: 0;
  transform: translateX(-50%);
  z-index: 10;
}

.timeline .timeline-box .dotted-line.active::after {
  border-color: #4a56b9 transparent transparent transparent;
}

.timeline .timeline-box .dotted-line .active {
  background-color: #4a56b9;
  width: 0.01rem;
  height: calc(100% - 0.08rem);
  margin: 0 auto;
}

/* .timeline .timeline-box .dotted-line .active {
  width: 0.01rem;
  height: 100%;
  background-color: red;
  position: absolute;
  left: 0;
  transform: translateX(-50%);
} */
</style>

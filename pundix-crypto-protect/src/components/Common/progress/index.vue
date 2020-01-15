<template>
  <div class="common-progress">
    <div class="progress">
      <!-- 第一截 -->
      <div
        class="before"
        :style="{ flexBasis: progressFlexBasis(beforeDay) + '%' }"
      >
        <div class="title">
          <p>{{ beforeContent || $t("common.progress.frozen") }}</p>
        </div>

        <div class="bar flex-align-center">
          <span>{{ beforeDay | countdownDay }}</span>
        </div>
      </div>
      <!-- 第二截 -->
      <div
        class="after"
        :style="{ flexBasis: progressFlexBasis(afterDay) + '%' }"
      >
        <div class="content">
          <div class="title start">
            <p>{{ afterContent || $t("common.progress.option") }}</p>
          </div>
        </div>
        <div class="bar flex-align-center">
          <span>{{ afterDay | countdownDay }}</span>
        </div>
      </div>
    </div>

    <!-- 当前进度 -->
    <div class="current-box flex-align-center">
      <div
        class="before current flex-align-center"
        :style="{ flexBasis: progressFlexBasis(beforeDay) + '%' }"
      >
        <div
          v-if="currentType === 0"
          :style="{
            transform: `translateX(-${getCurrentPercent(
              currentType === 0 ? 'beforeDay' : 'current'
            )}%)`
          }"
        >
          <span>{{ $t("common.progress.now") }}</span>
        </div>
      </div>
      <div
        class="after current flex-align-center"
        :style="{ flexBasis: progressFlexBasis(afterDay) + '%' }"
      >
        <div
          v-show="currentType === 1"
          :style="{
            transform: `translateX(-${getCurrentPercent(
              currentType === 1 ? 'afterDay' : 'current'
            )}%)`
          }"
        >
          <span>{{ $t("common.progress.now") }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";

export interface objContent {
  title: string;
  time: number;
}

@Component
export default class CommonProgress extends Vue {
  @Prop(Number) beforeDay!: number;
  @Prop(Number) afterDay!: number;
  @Prop(String) beforeContent!: string;
  @Prop(String) afterContent!: string;
  /** 当前进度 */
  @Prop(Number) current!: number;
  /** 当前进度类型 0: before; 1: after */
  @Prop(Number) currentType!: 0 | 1;

  get totalDay() {
    return this.beforeDay + this.afterDay;
  }

  /**
   * 进度条长度
   * 1 / (冻结时长 + 行权时长) * day
   */
  progressFlexBasis(day: number) {
    return (1 / this.totalDay) * day * 100;
  }

  /**
   * 判断内容类型: stirng / object
   */
  contentType(opt: string | objContent) {
    return typeof opt;
  }

  /**
   * 当前进度百分比
   */
  getCurrentPercent(key: "beforeDay" | "afterDay") {
    return (this.current / this[key]) * 100;
  }
}
</script>

<style scoped>
.common-progress {
  position: relative;
}

.common-progress .progress {
  display: flex;
  align-items: flex-end;
}

.common-progress .progress > div,
.common-progress .current-box > div {
  min-width: 30%;
}

.common-progress .progress > div + div,
.common-progress .current-box > div + div {
  margin-left: 0.02rem;
}

.common-progress .progress .bar {
  height: 0.16rem;
}

.common-progress .progress .bar span {
  font-size: 0.1rem;
  color: #ffffff;
  margin-left: 0.04rem;
  opacity: 0.9;
}

.common-progress .progress .title {
  margin-bottom: 0.08rem;
  display: block;
  margin-top: 0.16rem;
  font-size: 0.1rem;
  color: #b3b3b3;
  line-height: 0.1rem;
  position: relative;
  padding-bottom: 0.03rem;
  max-width: 0.8rem;
}

.common-progress .progress .title::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 0;
  width: calc(0.26rem * 2);
  height: calc(0.16rem * 2);
  border-width: 0;
  border-top-width: 0.01rem;
  border-left-width: 0.01rem;
  border-style: solid;
  transform: scale(0.5);
  transform-origin: 0 0;
}

.common-progress .progress .before .bar {
  background-color: #4a56b9;
}

.common-progress .progress .after .bar {
  background-color: #ff8717;
}

.common-progress .progress .before .title::after {
  border-color: #4a56b9;
}

.common-progress .progress .after .title::after {
  border-color: #ff8717;
}

.common-progress .progress .content {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
}

.common-progress .progress .title.end::after {
  border-left-width: 0;
  border-right-width: 0.01rem;
  right: 0;
  left: initial;
  transform-origin: 100% 0;
}

/* 当前进度 */
.common-progress .current-box {
  position: absolute;
  background-color: rgba(0, 0, 0, 0.5);
  left: 0;
  top: calc(100% + 0.08rem);
  width: 100%;
  justify-content: flex-end;
}

.common-progress .current-box .current > div {
  position: relative;
  width: 100%;
  height: 100%;
  margin: 0 0.005rem;
  transition: transform 1s linear;
}

.common-progress .current-box .current span {
  font-size: 0.12rem;
  position: absolute;
  left: 100%;
  top: 0;
  transform: translateX(-50%);
}

.common-progress .current-box .current span::before {
  content: "";
  display: inline-block;
  width: 1px;
  height: 0.22rem;
  position: absolute;
  left: 50%;
  bottom: 100%;
  transform: translateX(-50%) scale(0.5);
  transform-origin: 0 100%;
}

.common-progress .current-box .before span {
  color: #4a56b9;
}
.common-progress .current-box .before span::before {
  background-color: #4a56b9;
}

.common-progress .current-box .after span {
  color: #ff8717;
}

.common-progress .current-box .after span::before {
  background-color: #ff8717;
}
</style>

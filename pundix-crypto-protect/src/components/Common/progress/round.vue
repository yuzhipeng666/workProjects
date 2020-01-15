<template>
  <div
    class="common-round-progress flex-center"
    :style="{
      width: radius,
      height: radius
    }"
  >
    <svg
      width="100%"
      height="100%"
      viewBox="0 0 100 100"
      version="1.1"
      xmlns="http://www.w3.org/2000/svg"
    >
      <circle
        class="progress-background"
        :r="round.r"
        :cx="round.cx"
        :cy="round.cy"
        fill="transparent"
        :stroke="progressBg"
        :stroke-width="round.strokeWidth"
      />
      <circle
        class="progress-bar"
        :r="round.r"
        :cx="round.cx"
        :cy="round.cy"
        fill="transparent"
        :stroke="progressBar"
        :stroke-width="round.strokeWidth"
        :stroke-dasharray="dashArray"
        :stroke-dashoffset="dashOffset"
      />
    </svg>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";

@Component
export default class CommonRoundProgress extends Vue {
  /** 图片宽高 */
  @Prop({ default: ".12rem" }) radius!: string;
  /** 百分比 */
  @Prop(Number) percent!: number;
  /** 百分比背景颜色 */
  @Prop({ default: "#f08d3a" }) progressBg!: string;
  /** 百分比背景覆盖颜色 */
  @Prop({ default: "#dfdfdf" }) progressBar!: string;

  /** 圆形信息 */
  round = {
    r: 35,
    cx: 50,
    cy: 50,
    strokeWidth: 30
  };

  /** 圆形弧度 */
  get dashArray() {
    return Math.PI * 2 * this.round.r;
  }

  /** 范围 */
  get dashOffset() {
    return this.dashArray * ((100 - this.percent) / 100);
  }
}
</script>

<style scoped>
.common-round-progress circle {
  transform-origin: center;
}

.common-round-progress .progress-bar {
  transform: rotate(-90deg);
}
</style>

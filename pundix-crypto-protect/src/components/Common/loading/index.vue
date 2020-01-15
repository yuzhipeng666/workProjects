<template>
  <div class="loading">
    <div class="load-box">
      <div
        class="load-line"
        v-for="(line, index) in lineTotal"
        :key="line"
        :style="{
          transform: `translateY(-50%) rotate(${(360 / lineTotal) * line}deg)`
        }"
      >
        <div
          class="load-color"
          :style="{
            animation: `opacityAnimate ${duration}s ease ${(duration /
              lineTotal) *
              index}s infinite`
          }"
        ></div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component } from "vue-property-decorator";

@Component
export default class Loading extends Vue {
  // 线总数
  lineTotal = 12;

  /** animation动画完成时间 */
  duration = 0.6;
}
</script>

<style scoped>
.loading {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 10000;
  background-color: rgba(0, 0, 0, 0.1);
}

.load-box {
  position: absolute;
  top: 50%;
  left: 50%;
}

.loading .load-line {
  width: 0.15rem;
  height: 0.018rem;
  position: absolute;
  left: 50%;
  top: 50%;
  transform-origin: left center;
  padding: 0 0.05rem;
  box-sizing: border-box;
}

.loading .load-color {
  width: 100%;
  height: 100%;
  background-color: #a5a5a5;
  border-radius: 0.02rem;
}
</style>

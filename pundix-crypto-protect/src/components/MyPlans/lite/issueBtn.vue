<template>
  <div
    class="issue-btn flex-align-center"
    :style="{
      transform: `translateX(${translateX}%)`
    }"
    @click="clickHandler"
  >
    <i class="icon icon-question"></i>
    <p>{{ $t("issueBtnText") }}</p>
  </div>
</template>

<script lang="ts">
import { Vue, Component } from "vue-property-decorator";
import { config } from "@/config";

@Component
export default class IssueBtn extends Vue {
  /** 触发处理程序开关，默认为打开 */
  private switch = true;

  /** 收起定时器时间 */
  private time = 2000;

  get translateX() {
    return this.switch ? 0 : 72;
  }

  /**
   * 定时器收起
   */
  setTime() {
    setTimeout(() => (this.switch = false), this.time);
  }

  /**
   * 点击组件判断当前状态是否为收起
   * 是: 展开组件
   * 否: 做处理
   */
  clickHandler() {
    if (this.switch) {
      window.PX.newPage({ link: config.issueLink as string });
    } else {
      this.switch = true;
    }

    this.setTime();
  }

  created() {
    this.setTime();
  }
}
</script>

<style scoped>
.issue-btn {
  position: fixed;
  bottom: 1.86rem;
  right: 0;
  background-color: #ffffff;
  height: 0.38rem;
  box-shadow: 0.1rem 0.06rem 0.15rem 0 rgba(0, 0, 0, 0.07);
  padding: 0 0.04rem;
  border: 1px solid #efefef;
  border-radius: 100px 0 0 100px;
  box-sizing: border-box;
  transition: transform 0.3s ease;
}

.issue-btn p {
  font-size: 0.13rem;
  color: #333333;
  letter-spacing: 0.002rem;
  margin-left: 0.04rem;
}
</style>

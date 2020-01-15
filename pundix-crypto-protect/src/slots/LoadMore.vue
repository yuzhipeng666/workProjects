<template>
  <div
    class="load-more"
    :class="{
      'main-padding': padding
    }"
    :style="{
      transform: `translateY(${animate.refresh}px)`
    }"
    @touchstart="touchStart"
    @touchmove="touchMove"
    @touchend="touchEnd"
  >
    <!-- 下拉刷新 -->
    <div class="refresh" v-if="refresh" ref="refresh">
      {{ refreshText }}
    </div>

    <!-- Main -->
    <main>
      <slot />
    </main>

    <!-- 上拉加载 -->
    <!-- <div class="more" v-if="more"></div> -->
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop, Ref } from "vue-property-decorator";
import { config } from "@/config";

@Component
export default class LoadMoreSlot extends Vue {
  // 下拉刷新(default: 开启)
  @Prop({ default: true }) refresh!: boolean;
  // 上拉加载(default: 开启)
  @Prop({ default: true }) more!: boolean;
  // Padding
  @Prop({ default: true }) padding!: boolean;

  // 下拉刷新dom元素
  @Ref("refresh") refreshElement!: HTMLDivElement;

  // 下拉刷新的样式
  refreshStyle = {
    height: 0
  };

  // 手指坐标信息
  touch = {
    startY: 0
  };

  /** 是否开始处理程序 */
  isHandler = {
    refresh: false,
    more: true
  };

  // 动画
  animate = {
    refresh: 0,
    more: 0
  };

  /** 下拉刷新文案 */
  get refreshText() {
    if (this.refreshEmit) {
      return "加载中...";
    } else if (this.animate.refresh >= this.refreshStyle.height) {
      return "松开立即刷新";
    } else {
      return "下拉可以刷新";
    }
  }

  get refreshEmit() {
    // 通知组件执行下拉刷新程序，并传入重置下拉刷新的回调函数
    this.isHandler.refresh && this.$emit("refresh", this.resetRefresh);

    return this.isHandler.refresh;
  }

  /**
   * 重置下拉刷新
   */
  resetRefresh() {
    this.isHandler.refresh = false;
    this.animate.refresh = 0;
  }

  /**
   * 手指点击事件
   */
  touchStart(evt: TouchEvent) {
    // 记录点击的Y轴坐标
    this.touch.startY = evt.touches[0].pageY;
  }

  /**
   * 手指移动事件
   * 1. 判断页面滚动距离是否在顶部(scrollTop: 0) / 底部(scrollTop: heigth)
   * 2. 判断手指滑动方向，给出页面动画
   */
  touchMove(evt: TouchEvent) {
    // 页面滚动距离
    const scrollTop =
      document.documentElement.scrollTop || document.body.scrollTop;

    // 手指移动的Y方向坐标
    const pageY = evt.touches[0].pageY;

    // 下拉刷新
    if (scrollTop === 0 && this.refresh) {
      // 计算显示下拉组件的长度(px)
      this.animate.refresh = Math.pow(pageY - this.touch.startY, 0.8);

      // 已出现下拉组件时，禁止页面滚动
      if (this.animate.refresh > 0 && evt.cancelable) {
        evt.preventDefault();
        evt.stopPropagation();
      }
    }

    // 上拉加载/翻页
    if (this.more) {
      const scrollHeight = Math.round(scrollTop + window.innerHeight);

      if (scrollHeight >= document.body.clientHeight && this.isHandler.more) {
        // 关闭加载更多的开关
        this.isHandler.more = false;

        // 通知父组件more事件，并传入打开加载更多开关的回调函数
        this.$emit("more", () => (this.isHandler.more = true));
      }
    }
  }

  /**
   * 手指离开屏幕事件
   */
  touchEnd(evt: TouchEvent) {
    // 判断是否触发了下拉刷新
    if (
      this.animate.refresh < this.refreshStyle.height ||
      isNaN(this.animate.refresh)
    ) {
      // false
      this.animate.refresh = 0;
    } else {
      // true
      this.animate.refresh = this.refreshStyle.height;

      this.isHandler.refresh = true;
    }
  }

  mounted() {
    this.refreshStyle.height = this.refreshElement.clientHeight;
  }
}
</script>

<style scoped>
.load-more {
  position: relative;
  transition: transform 0.05s ease;
}

.load-more .refresh {
  /* background-color: pink; */
  width: 100%;
  height: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
  position: absolute;
  top: 0;
  left: 0;
  transform: translateY(-100%);
}

.load-more main {
  min-height: 90vh;
}
</style>

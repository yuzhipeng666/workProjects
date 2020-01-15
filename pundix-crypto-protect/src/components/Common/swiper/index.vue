<template>
  <div class="common-swiper">
    <div
      class="common-swiper-block"
      @touchstart="touchStart"
      @touchmove.stop.prevent="touchMove"
      @touchend="touchEnd"
    >
      <div
        class="common-swiper-width"
        :style="{
          width: swiperBlockWidth + '%',
          height
        }"
      >
        <div
          class="img"
          v-for="(list, index) in copyLists"
          :key="index"
          :style="{
            transform: `translateX(-${translateX}%)`,
            transitionDuration
          }"
        >
          <img :src="list.url" />
        </div>
      </div>
    </div>

    <div class="common-swiper-point flex-center">
      <span
        v-for="(list, index) in lists"
        :key="index"
        class="point"
        :class="{ active: index === pointIndex }"
      ></span>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";

export interface ISwiperList {
  link: string;
  url: string;
  index?: number;
}

@Component
export default class CommonSwiper extends Vue {
  @Prop(Array) lists!: ISwiperList[];
  /** 间距(ms) */
  @Prop({ default: 2000 }) space!: number;
  /** 动画时长(ms) */
  @Prop({ default: 400 }) duration!: number;
  /** banner图高度 */
  @Prop(String) height!: string;

  // private translateX = 0;
  /** 长度的下标 */
  private lenIndex = 2;
  /** 是否改变下标到第一张图/最后一张图 */
  private changeIndex = false;
  /** 定时器 */
  private timer = null as any;

  /** 手指定位 */
  private touch = {
    start: 0,
    lenIndex: 0,
    switch: false, // 手动移动的开关，同时用于计算平移距离
    isMove: true, // 是否可用手指拖动
    isMoveTimer: null
  } as {
    start: number;
    lenIndex: number;
    switch: boolean;
    isMove: boolean;
    isMoveTimer: any;
  };

  /** 点的选中下标 */
  get pointIndex() {
    return this.copyLists[this.lenIndex].index;
  }

  /** 平移距离(%) */
  get translateX() {
    return 100 * (this.touch.switch ? this.touch.lenIndex : this.lenIndex);
  }

  /** 初始化列表数据，新增index字段 */
  get initLists() {
    return this.lists.map((list, index) => ({
      index,
      ...list
    }));
  }

  /** 补全头尾各两条数据 */
  get copyLists() {
    let lists = [] as ISwiperList[];

    this.initLists
      .slice(this.lists.length - 2, this.lists.length)
      .forEach(list => lists.push(list));
    this.initLists.forEach(list => lists.push(list));
    this.initLists.slice(0, 2).forEach(list => lists.push(list));

    return lists;
  }

  /** 获取主要块的宽度(%) */
  get swiperBlockWidth() {
    return this.copyLists.length * 100;
  }

  get transitionDuration() {
    return this.changeIndex ? "" : `${this.duration}ms`;
  }

  /**
   * 计时器重置index到最开始/最尾部
   */
  setTimeInitStartOrEnd(lenIndex: number) {
    setTimeout(() => {
      this.changeIndex = true;

      this.lenIndex = lenIndex;
    }, this.duration);
  }

  /**
   * 动画主要逻辑
   */
  swiperAnimate() {
    this.changeIndex = false;

    if (this.lenIndex === this.lists.length + 2) {
      this.setTimeInitStartOrEnd(2);
    }

    if (this.lenIndex === 1) {
      this.setTimeInitStartOrEnd(this.copyLists.length - 3);
    }
  }

  /**
   * 定时器轮播
   */
  setTime() {
    this.timer = setTimeout(() => {
      this.lenIndex += 1;

      this.swiperAnimate();

      this.setTime();
    }, this.space);
  }

  touchStart(evt: TouchEvent) {
    /** 清除定时器 */
    clearTimeout(this.timer);

    this.touch.start = evt.touches[0].pageX;

    this.touch.lenIndex = this.lenIndex;

    this.touch.switch = true;

    // 关闭动画延迟
    this.changeIndex = true;
  }

  touchMove(evt: TouchEvent) {
    if (!this.touch.isMove) return;

    const pageX = evt.touches[0].pageX;

    const spacing = (this.touch.start - pageX) / 260;

    this.touch.lenIndex = this.lenIndex + spacing;
  }

  touchEnd(evt: TouchEvent) {
    if (!this.touch.isMove) return;

    // 关闭手指拖动
    this.touch.isMove = false;

    this.lenIndex = Math.round(this.touch.lenIndex);

    this.touch.switch = false;

    this.swiperAnimate();

    // 判断手指拖动状态
    // 如果为false，使用定时器等到动画完成后再开启拖动
    if (!this.touch.isMove) {
      setTimeout(() => (this.touch.isMove = true), this.duration);
    }

    this.setTime();
  }

  created() {
    this.setTime();
  }
}
</script>

<style scoped>
.common-swiper {
  width: 100%;
  height: 100%;
  overflow: hidden;
}

.common-swiper .common-swiper-block {
  width: 92%;
  margin: 0 auto;
}

.common-swiper .common-swiper-width {
  height: 100%;
  display: flex;
}

.common-swiper .img {
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex: 1;
  transition-property: transform;
  transition-timing-function: ease;
  padding: 0 0.03rem;
  box-sizing: content-box;
}

.common-swiper .img img {
  width: 100%;
  height: 100%;
}

.common-swiper .common-swiper-point {
  margin-top: 0.05rem;
}

.common-swiper .point {
  display: inline-block;
  width: 0.05rem;
  height: 0.05rem;
  border-radius: 50%;
  background-color: #ccd4ef;
}

.common-swiper .point + .point {
  margin-left: 0.06rem;
}

.common-swiper .point.active {
  background-color: #4a56b9;
}
</style>

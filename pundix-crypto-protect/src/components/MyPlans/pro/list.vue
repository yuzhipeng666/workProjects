<template>
  <router-link
    :to="{
      name: 'plans-detail',
      params: {
        userPlanId: info.userPlanId
      }
    }"
    tag="div"
  >
    <box-slot class="plan-list">
      <template #header>
        <div class="header flex-align-center">
          <coin-info
            :icon="info.earnIcon"
            :unit="info.earnUnit"
            :name="info.planName"
            :monthDay="info.monthDay"
            :dayNumber="info.dayNumber"
          />

          <span class="status" :class="`status-${info.status}`">
            {{ $t("myPlans.planLists.status")[info.status] }}
          </span>
        </div>
      </template>

      <div class="main line">
        <label-list
          class="float"
          :success="true"
          :label="$t(`myPlans.planLists.title.floating[${info.riseRateType}]`)"
        >
          <template #label>
            <i class="icon icon-issue" @click.stop.prevent="clickIssue"></i>
          </template>
          +{{ info.riseRate | amount(2) }}%
        </label-list>
        <label-list
          :label="$t('myPlans.planLists.title.have', { unit: info.earnUnit })"
        >
          {{ info.earnAmount | amount }}
        </label-list>
        <label-list
          :label="$t('myPlans.planLists.title.paid', { unit: info.investUnit })"
        >
          {{ info.orderInvestAmount | amount }}
        </label-list>
      </div>

      <common-progress
        :beforeDay="frozenDay"
        :afterDay="optionDay"
        :beforeContent="$t('myPlans.planLists.progress.before')"
        :afterContent="$t('myPlans.planLists.progress.after')"
        :current="progressCurrent"
        :currentType="info.status"
      />

      <div class="line"></div>

      <div class="bottom">
        <div class="time-exercise flex-align-center">
          <i18n
            v-if="info.status === 0"
            path="myPlans.planLists.timeExercise.can"
            tag="p"
          >
            <span slot="time" class="time">
              {{ frozenEndCountDown | countdown }}
            </span>
          </i18n>

          <i18n
            v-else-if="info.status === 1"
            path="myPlans.planLists.timeExercise.have"
            tag="p"
          >
            <span slot="time" class="time">
              {{ openEndCountDown | countdown }}
            </span>
          </i18n>
          <i18n
            v-else-if="info.status === 2"
            path="myPlans.planLists.timeExercise.chosen"
            tag="p"
            class="chosen"
          >
            <span slot="other" class="amount">
              {{ info.orderInvestAmount | amount }}
              {{ info.investUnit }}
            </span>
          </i18n>
          <i18n
            v-else
            path="myPlans.planLists.timeExercise.chosen"
            tag="p"
            class="chosen"
          >
            <span slot="other" class="amount">
              {{ info.earnAmount | amount }}
              {{ info.earnUnit }}
            </span>
          </i18n>

          <i class="icon icon-detail"></i>
        </div>
      </div>
    </box-slot>
  </router-link>
</template>

<script lang="ts">
import { Vue, Component, Prop, Mixins, Watch } from "vue-property-decorator";

import CommonProgress from "@/components/Common/progress/index.vue";
import CoinInfo from "@/components/Common/box/coinInfo.vue";
import LabelList from "@/components/Common/labelList/index.vue";
import Timer from "@/mixins/timer";

export interface IMyPlanProList {
  /** 购买时间 */
  buyDt: number;
  /** 结束行权时间(完成时间) */
  exerciseEndDt: number;
  /** 结束冻结时间(行权开始时间) */
  freezeEndDt: number;
  /** 涨幅 */
  annualizedRate: number;
  /** 涨幅类型(0:浮盈(Floating); 1:保护(Protected); 2:利润(Profit)) */
  riseRateType: number;
  /** 服务器当前时间 */
  systemDt: number;
  /** 用户操作时间(行权时间) */
  userOpDt: number;
  /** id */
  userPlanId: number;
  /** 某天的第几条计划 */
  dayNumber: number;
  /** 收益币种的总数量 */
  earnAmount: number;
  /** 收益币种图标 */
  earnIcon: string;
  /** 收益币种 */
  earnUnit: string;
  /** 购买币种 */
  investUnit: string;
  /** 行权日期(例如:1201) */
  monthDay: string;
  /** 订单应付金额 */
  orderInvestAmount: number;
  /** 名称 */
  planName: string;
  /** 状态(0:冻结中; 1:行权中; 2:已行权; 3:结算中; 4:完成) */
  status: number;
}

@Component({
  components: {
    CommonProgress,
    CoinInfo,
    LabelList
  }
})
export default class HomePlanList extends Mixins(Timer) {
  @Prop({ type: Object }) info!: IMyPlanProList;
  @Prop(Number) index!: number;

  private dateNow = Date.now(); // 当前时间戳
  private isShare = true;

  // 冻结时长
  get frozenDay() {
    return this.info.freezeEndDt - this.info.buyDt;
  }

  // 行权时长
  get optionDay() {
    return this.info.exerciseEndDt - this.info.freezeEndDt;
  }

  // 结束冻结倒计时
  get frozenEndCountDown() {
    this.timerHandler(this.info.freezeEndDt, {
      // 改变状态
      endFunc: () => (this.info.status = 1)
    });

    return this.info.freezeEndDt - this.systemDt;
  }

  // 结束行权倒计时
  get openEndCountDown() {
    this.timerHandler(this.info.exerciseEndDt, {
      // 删除
      endFunc: () => this.$emit("delete", this.index)
    });

    return this.info.exerciseEndDt - this.systemDt;
  }

  /**
   * 根据状态判断进度条当前进度
   */
  get progressCurrent() {
    switch (this.info.status) {
      case 0:
        return this.frozenEndCountDown;
      case 1:
        return this.openEndCountDown;
      default:
        return this.info.exerciseEndDt - this.info.userOpDt;
    }
  }

  clickIssue() {
    console.log("123");
  }

  created() {
    this.systemDt = this.info.systemDt;
  }
}
</script>

<style scoped>
.plan-list {
  margin-bottom: 0.24rem;
}

/* Header */
.plan-list .header .status {
  font-size: 0.1rem;
  display: inline-block;
  padding: 0.01rem 0.03rem;
  margin-left: 0.08rem;
  transform: skewX(-5deg);
  color: #ffffff;
  border-radius: 0.02rem;
}

.plan-list .header .status.status-0 {
  background-color: #8594a7;
}

.plan-list .header .status.status-1 {
  background-color: #ff8717;
}

.plan-list .header .status.status-2,
.plan-list .header .status.status-3,
.plan-list .header .status.status-4 {
  background-color: #63acda;
}

/* Main */
.plan-list .main {
  padding: 0.14rem 0 0.1rem;
}

.plan-list .main .list {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.plan-list .main .list + .list {
  margin-top: 0.12rem;
}

.plan-list .main .list .title {
  color: #7e7e7e;
  font-size: 0.12rem;
  line-height: 0.14rem;
}

.plan-list .main .list .value {
  font-size: 0.14rem;
  color: #333333;
  line-height: 0.17rem;
  font-weight: 700;
}

.plan-list .main .list.price .title {
  margin-right: 0.05rem;
}

.plan-list .main .list.price .value {
  color: #41bd77;
}

/* Progress */
.plan-list .common-progress {
  margin-bottom: 0.28rem;
}

/* Bottom */
.plan-list .bottom {
  padding-top: 0.2rem;
}

.plan-list .bottom .time-exercise {
  justify-content: space-between;
}

.plan-list .bottom .time-exercise p {
  font-size: 0.12rem;
}
.plan-list .bottom .time-exercise .time {
  color: #ff8717;
}

.plan-list .chosen {
  color: #7e7e7e;
}

.plan-list .chosen .amount {
  color: #151515;
}

.plan-list .float .icon-issue {
  margin-left: 0.04rem;
}
</style>

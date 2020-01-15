<template>
  <box-slot
    class="lite-list"
    :class="{ disabled }"
    :line="false"
    :title="title"
  >
    <div class="header flex-align-center" slot="header">
      <div class="logo flex-center">
        <img :src="list.earnIcon" :alt="list.earnUnit" />
      </div>
      <div class="info">
        <title>{{ list.planName }}</title>
        <strong class="time"
          >#{{ list.monthDay }} -{{ list.dayNumber | doubleNumber }}</strong
        >
      </div>
    </div>

    <strong class="amount">
      {{ list.earnToInvestExchangeRate | amount }} {{ list.investUnit }}/{{
        list.earnUnit
      }}
    </strong>

    <p class="ps flex-align-center" v-if="list.annualizedRate">
      <i18n :path="`home.lite.lastTime[${list.annualizedRate.riseRateType}]`">
        <span slot="rate" class="success-color">
          + {{ list.annualizedRate.annualizedRate | amount(2) }} %
        </span>
      </i18n>
      <!-- <i class="icon icon-issue" @click="issueConfirm"></i> -->
    </p>

    <slot />
  </box-slot>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";

import CoinInfo from "@/components/Common/box/coinInfo.vue";
import { Format } from "@/plugins/format";
import { namespace } from "vuex-class";

const commonModule = namespace("common");

/**
 * 年化率信息
 */
interface PlanAnnualizedRate {
  /** 比价基数时间 */
  baseDt: number;
  /** 比价基础汇率 */
  baseExchangeRate: number;
  /** 涨幅 */
  annualizedRate: number;
  /** 类型(0:浮盈; 1:保护;) */
  riseRateType: number;
  /** 目标时间 */
  targetDt: number;
  /** 目标汇率 */
  targetExchangeRate: number;
}

export interface IPlanList {
  /** 某天的第几条计划 */
  dayNumber: number;
  /** 收益币种图标 */
  earnIcon: string;
  /** 收益币种对应投资币种汇率 */
  earnToInvestExchangeRate: number;
  /** 收益币种 */
  earnUnit: string;
  /** 购买币种 */
  investUnit: string;
  /** 行权日期(例如:1201) */
  monthDay: string;
  /** id */
  planId: string;
  /** 名称 */
  planName: string;
  /** 年化率信息 */
  annualizedRate: PlanAnnualizedRate;
}

@Component({
  components: {
    CoinInfo
  },
  filters: {
    doubleNumber: Format.doubleNumber
  }
})
export default class LiteList extends Vue {
  @Prop({ type: String, required: false }) title!: string;

  @Prop(Object) list!: IPlanList;

  @Prop({ default: false }) disabled!: boolean;

  /** Confirm func */
  @commonModule.Mutation CHANGE_CONFIRM!: (confirm: CommonConfirm) => void;

  /**
   * Issue弹窗
   */
  issueConfirm() {
    this.CHANGE_CONFIRM({
      title: this.$t(
        `common.confirm.title.lastTime[${this.list.annualizedRate.riseRateType}]`
      ) as string,
      type: "lastTime",
      data: this.list,
      confirmBtn: this.$t("common.confirm.btn.gotIt") as string
    });
  }
}
</script>

<style scoped>
.lite-list {
  margin-bottom: 0.12rem;
}

.lite-list.disabled {
  position: relative;
}

.lite-list.disabled::after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.3);
}

.lite-list .header .logo {
  width: 0.24rem;
  height: 0.24rem;
}

.lite-list .header .info {
  display: flex;
  align-items: flex-end;
}

.lite-list .header .info title {
  display: inline-block;
  font-size: 0.14rem;
  color: #333333;
  margin: 0 0.06rem 0 0.1rem;
}

.lite-list .header .info .time {
  font-size: 0.12rem;
  color: #999999;
}

.lite-list .amount {
  display: block;
  font-size: 0.16rem;
  color: #333333;
  line-height: 0.2rem;
  margin-top: 0.1rem;
}

.lite-list .ps {
  font-size: 0.12rem;
  color: #999999;
  margin-top: 0.1rem;
}

.lite-list .ps .icon-issue {
  width: 0.1rem;
  height: 0.1rem;
  margin-left: 0.02rem;
}
</style>

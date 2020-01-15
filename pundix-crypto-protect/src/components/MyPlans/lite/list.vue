<template>
  <box-slot class="my-plans-lite-list" :line="false">
    <div slot="header" class="header">
      <strong class="title">{{ list.planName }}</strong>
      <span class="time">
        #{{ list.monthDay }} -{{ list.dayNumber | doubleNumber }}
      </span>
    </div>

    <div class="main">
      <div class="unit-type-list flex-align-center">
        <unit-type
          v-for="(list, index) in unitTypeList"
          :key="index"
          :list="list"
        />
      </div>

      <i18n :path="`myPlans.lite.tips[${tips}]`" tag="p" class="tips">
        <template #unit>
          <span v-if="tips === 0 || tips === 2">{{ list.investUnit }}</span>
          <span v-else>{{ list.earnUnit }}</span>
        </template>
      </i18n>
    </div>
  </box-slot>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";

import UnitType, { IUnitTypeList } from "./unitType.vue";

export interface IList {
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
  /** 收益币涨幅 */
  earnRiseRate: number;
  /** 购买币涨幅 */
  investRiseRate: number;
  /** ID */
  userPlanId: number;
}

@Component({
  components: { UnitType }
})
export default class MyPlansLiteList extends Vue {
  @Prop(Object) list!: IList;

  // get

  get unitTypeList(): IUnitTypeList[] {
    return [
      // 购买币
      {
        unit: this.list.investUnit,
        amount: this.list.orderInvestAmount,
        type: 2,
        active: this.tips === 0 || this.tips === 2,
        rate: this.list.investRiseRate
      },
      // 收益币
      {
        unit: this.list.earnUnit,
        amount: this.list.earnAmount,
        type: 4,
        active: this.tips === 1 || this.tips === 3,
        rate: this.list.earnRiseRate
      }
    ];
  }

  get tips() {
    // 状态为 0: 冻结中 / 1: 行权中 时
    if (this.list.status === 0 || this.list.status === 1) {
      // 购买币涨幅大于0，显示购买币文本，否则显示收益币文本
      return this.list.investRiseRate ? 0 : 1;
    } else if (this.list.status === 2) {
      return 2;
    } else {
      return 3;
    }
  }
}
</script>

<style scoped>
.my-plans-lite-list {
  margin-bottom: 0.15rem;
}

.my-plans-lite-list .header .title {
  font-size: 0.16rem;
  color: #333333;
}

.my-plans-lite-list .header .time {
  font-size: 0.12rem;
  color: #999999;
}

.my-plans-lite-list .unit-type-list {
  justify-content: space-between;
  margin: 0.1rem 0 0.18rem;
}

.my-plans-lite-list .tips {
  font-size: 0.13rem;
  color: #7e7e7e;
}

.my-plans-lite-list .tips span {
  color: #333333;
}
</style>

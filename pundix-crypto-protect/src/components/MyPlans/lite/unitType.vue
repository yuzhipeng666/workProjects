<template>
  <div
    class="unit-type border"
    :class="{ active: list.active }"
    :data-active="$t('myPlans.lite.activeText')"
    :data-type="list.type"
  >
    <p class="unit">{{ list.unit }}</p>
    <p class="amount">{{ list.amount | amount }}</p>
    <p class="type">{{ typeText }}</p>
    <strong v-if="list.active" class="rate success-color">
      + {{ list.rate | amount(2) }} %
    </strong>
    <strong v-else>- -</strong>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";

export interface IUnitTypeList {
  /** 币种 */
  unit: string;
  /** 金额 */
  amount: number;
  /** 类型(2: Protected, 4: Profit) */
  type: 2 | 4;
  /** 激活状态 */
  active: boolean;
  /** 收益率 */
  rate: number;
}

@Component
export default class MyPlansLiteUnitType extends Vue {
  @Prop(Object) list!: IUnitTypeList;

  get typeText() {
    switch (this.list.type) {
      case 2:
        return this.$t("myPlans.lite.type[0]");
      case 4:
        return this.$t("myPlans.lite.type[1]");
      default:
        return "";
    }
  }
}
</script>

<style scoped>
.unit-type {
  width: 48%;
  color: #333333;
  box-shadow: 0 0.06rem 0.06rem -0.06rem rgba(26, 64, 129, 0.05);
  padding: 0.12rem;
  box-sizing: border-box;
  position: relative;
}

.unit-type.active::before {
  content: attr(data-active);
  position: absolute;
  top: 0;
  right: 0;
  font-size: 0.1rem;
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 0.3rem;
  height: 0.14rem;
  border-radius: 0 0.04rem 0 0.06rem;
}

.unit-type.active[data-type="2"]::before {
  background-color: #ff8717;
}
.unit-type.active[data-type="4"]::before {
  background-color: #4a56b9;
}

.unit-type::after {
  border-radius: 0.08rem;
  border-color: #d3d3d3;
}

.unit-type .unit {
  font-size: 0.13rem;
}

.unit-type .amount {
  font-size: 0.18rem;
  line-height: 0.22rem;
}

.unit-type .type {
  font-size: 0.12rem;
  color: #666666;
  opacity: 0.7;
  margin: 0.1rem 0 0.04rem;
}

.unit-type .rate {
  font-size: 0.12rem;
}
</style>

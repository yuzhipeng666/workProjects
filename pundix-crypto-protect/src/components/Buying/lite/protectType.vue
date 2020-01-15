<template>
  <li class="protect-type border">
    <div class="logo">
      <img v-if="list.type === 0" src="@/assets/icon/ic_down@svg.svg" />
      <img v-else src="@/assets/icon/ic_up@svg.svg" />
    </div>

    <i18n
      :path="`buy.lite.preview.typePs[${list.type}]`"
      tag="p"
      class="type-ps"
    >
      <template #amount>{{ list.limitAmount | amount }}</template>
      <template #buyUnit>{{ list.buyUnit }}</template>
      <template #getUnit>{{ list.getUnit }}</template>
    </i18n>

    <h5 class="result">
      {{ $t(`buy.lite.preview.type[${list.type}]`, { unit }) }}
    </h5>
    <strong class="success-color">
      {{ list.amount | amount }} {{ unit }}
    </strong>
  </li>
</template>

<script lang="ts">
import { Vue, Prop, Component } from "vue-property-decorator";

export interface IProtectTypeList {
  /** 类型(0: return, 1: get) */
  type: 0 | 1;
  /** 购买币种 */
  buyUnit: string;
  /** 收益币种 */
  getUnit: string;
  /** 金额 */
  amount: number;
  /** 限制金额 */
  limitAmount: number;
}

@Component
export default class ProtectType extends Vue {
  @Prop(Object) list!: IProtectTypeList;

  get unit() {
    return this.list.type === 0 ? this.list.buyUnit : this.list.getUnit;
  }
}
</script>

<style scoped>
.protect-type {
  padding: 0.14rem 0.12rem;
  box-sizing: border-box;
  width: 48%;
}

.protect-type::after {
  border-color: #d3d3d3;
  border-radius: 0.08rem;
}

.protect-type .logo {
  width: 0.4rem;
  height: 0.4rem;
  margin: 0.04rem 0 0.15rem;
}

.protect-type .type-ps {
  font-size: 0.12rem;
  color: #666666;
  line-height: 0.16rem;
}

.protect-type .result {
  font-size: 0.18rem;
  color: #000000;
  line-height: 0.24rem;
  margin: 0.12rem 0 0.05rem;
}

.protect-type strong {
  font-size: 0.12rem;
}
</style>

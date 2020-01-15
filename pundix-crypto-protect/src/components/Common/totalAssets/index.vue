<template>
  <div class="total-assets">
    <div class="total-amount">
      <p class="title">{{ $t("home.totalAssets.title.total") }}</p>
      <strong class="amount">{{ asset | amount(2) }} {{ unit }}</strong>
    </div>

    <div class="available-amount flex-align-center">
      <p class="title">{{ $t("home.totalAssets.title.available") }}</p>
      <p class="amount">{{ balance | amount(2) }} {{ unit }}</p>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";

@Component
export default class HomeTotalAssets extends Vue {
  @Prop(Number) asset!: number;
  @Prop(Number) balance!: number;
  @Prop(String) unit!: string;
}
</script>

<style scoped>
.total-assets {
  background-color: #293170;
  background: url(../../../assets/bg_banner.png) repeat-x center / cover;
  padding: 0.2rem 0.3rem;
  box-sizing: border-box;
}

.total-assets .title {
  font-size: 0.12rem;
  color: #8c94bc;
  line-height: 0.14rem;
}

.total-assets .amount {
  font-size: 0.28rem;
  color: #ffffff;
}

.total-assets .total-amount .amount {
  margin-top: 0.08rem;
}

.total-assets .total-amount strong.amount {
  display: block;
  margin-top: 0.05rem;
}

.total-assets .available-amount {
  margin-top: 0.2rem;
}

.total-assets .available-amount .amount {
  font-size: 0.14rem;
  margin-left: 0.02rem;
}
</style>

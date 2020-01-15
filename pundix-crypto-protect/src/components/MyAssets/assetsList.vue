<template>
  <router-link
    :to="routeDetail"
    tag="div"
    class="assets-list flex-align-center"
  >
    <div class="coin flex-align-center">
      <div class="logo flex-center">
        <img v-if="type === 1" :src="info.icon" :alt="info.unit" />
        <img v-else src="@/assets/logo_my.svg" :alt="info.unit" />
      </div>
      <div v-if="type === 1" class="name">{{ info.unit }}</div>
      <div v-else class="name">{{ $t("myAssets.assetsDetail.myPlan") }}</div>
    </div>

    <div v-if="type === 1" class="amount flex-align-center">
      {{ info.amount | amount }}
    </div>
    <div v-else class="amount flex-align-center">
      &#8776;{{ info.amount | amount }} {{ info.unit }}
    </div>
  </router-link>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";

export interface IAssetCoinList {
  /** 币种余额 */
  amount: number;
  /** 币种icon */
  icon?: string;
  /** 币种 */
  unit: string;
}

@Component
export default class AssetsList extends Vue {
  @Prop(Object) info!: IAssetCoinList;
  @Prop({ default: 1 }) type!: 0 | 1;

  get routeDetail() {
    return this.type === 1
      ? { name: "myAssetsDetail", params: { unit: this.info.unit } }
      : { name: "plans" };
  }
}
</script>

<style scoped>
.assets-list {
  justify-content: space-between;
  background-color: #ffffff;
  box-shadow: 0 0.14rem 0.14rem -0.1rem rgba(26, 64, 129, 0.1);
  border-radius: 0.04rem;
  padding: 0.18rem;
  box-sizing: border-box;
}

.assets-list + .assets-list {
  margin-top: 0.06rem;
}

.assets-list .coin .logo {
  width: 0.24rem;
  height: 0.24rem;
}

.assets-list .coin .name {
  margin-left: 0.12rem;
  font-size: 0.14rem;
  color: #333333;
  line-height: 0.16rem;
  font-weight: 700;
}

.assets-list .amount {
  font-size: 0.14rem;
  color: #333333;
}

.assets-list .amount::after {
  content: "";
  display: inline-block;
  width: 0.1rem;
  height: 0.1rem;
  margin-left: 0.01rem;
  background: url(../../assets/ic_more.svg) no-repeat center right / contain;
}
</style>

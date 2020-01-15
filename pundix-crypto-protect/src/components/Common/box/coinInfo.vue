<template>
  <div class="coin-info flex-align-center">
    <div v-if="icon" class="logo flex-center">
      <img :src="icon" :alt="unit" />
    </div>
    <div class="info">
      <div class="name flex-align-center">
        <h6>{{ name }}</h6>
        <strong v-show="monthDay" class="time"
          >#{{ monthDay }} -{{ dayNumber | doubleNumber }}</strong
        >
      </div>
      <div class="other">
        <slot />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";
import { Format } from "@/plugins/format";

@Component({
  filters: {
    doubleNumber: Format.doubleNumber
  }
})
export default class CoinInfo extends Vue {
  /** 币种图标 */
  @Prop(String) icon!: string;
  /** 币种 */
  @Prop(String) unit!: string;
  /** 标题 */
  @Prop(String) name!: string;
  /** 标注月份 */
  @Prop(String) monthDay!: string;
  /** 标注序号 */
  @Prop(Number) dayNumber!: number;
}
</script>

<style scoped>
.coin-info .logo {
  width: 0.32rem;
  height: 0.32rem;
}

.coin-info .info {
  margin-left: 0.12rem;
}

.coin-info .info .name h6 {
  font-size: 0.16rem;
  color: #333333;
}

.coin-info .info .name .time {
  color: #4a56b9;
  margin-left: 0.06rem;
  font-size: 0.13rem;
}
</style>

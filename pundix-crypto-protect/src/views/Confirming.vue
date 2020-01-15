<template>
  <success-slot class="success-buy" type="warning">
    <template #title>
      {{ $t("success.confirming") }}
    </template>

    <div class="option-amount" slot="amount">
      <p class="title">{{ $t("success.buy.option") }}</p>
      <strong class="amount">+ {{ query.amount }} {{ query.earnUnit }}</strong>
    </div>
  </success-slot>
</template>

<script lang="ts">
import { Vue, Component } from "vue-property-decorator";
import { namespace } from "vuex-class";

interface UserPayPlanStatus {
  /** 状态(0:支付中; 1:已支付; 2:失败) */
  status: 0 | 1 | 2;
}

const commonModule = namespace("common");

@Component
export default class ConfirmingPage extends Vue {
  @commonModule.Mutation CHANGE_LOADING!: (bool: boolean) => void;

  get query() {
    return this.$route.query;
  }

  /**
   * 查询用户支付计划状态
   */
  async getConfirmStatus() {
    return this.axios.post<UserPayPlanStatus>(
      "/cryptoGamingPlan/searchUserPayPlanStatus",
      { userOrderPayPlanId: this.query.userOrderPayPlanId }
    );
  }

  async setTimer() {
    const data = await this.getConfirmStatus().finally(() =>
      this.CHANGE_LOADING(false)
    );

    if (data.status === 0) {
      setTimeout(() => this.setTimer(), 500);
    } else if (data.status === 1) {
      this.$router.replace({ name: "buySuccess", query: this.query });
    } else if (data.status === 2) {
      this.$router.replace({ name: "fail", query: this.query });
    }
  }

  mounted() {
    this.setTimer();
  }
}
</script>

<style scoped>
.success-buy .option-amount .title {
  font-size: 0.14rem;
  color: #bababa;
  line-height: 0.16rem;
}

.success-buy .option-amount .amount {
  font-size: 0.16rem;
  color: #333333;
  line-height: 0.18rem;
  margin-top: 0.02rem;
}
</style>

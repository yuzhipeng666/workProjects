<template>
  <success-slot class="success-buy" type="fail">
    <template #title>
      {{ $t("success.fail") }}
    </template>

    <div class="option-amount" slot="amount">
      <p class="title">{{ $t("success.buy.option") }}</p>
      <strong class="amount">+ {{ query.amount }} {{ query.earnUnit }}</strong>
    </div>

    <div slot="other">
      <router-link :to="{ name: 'assets' }" tag="button" class="link">{{
        $t("success.button.checkMyAssets")
      }}</router-link>
      <router-link :to="{ name: 'plans' }" tag="button" class="link">{{
        $t("success.button.checkMyPlans")
      }}</router-link>
      <router-link
        :to="{
          name: 'buying',
          params: {
            planId: query.planId
          }
        }"
        tag="button"
        class="link"
        >{{ $t("success.button.buyAgain") }}</router-link
      >
    </div>
  </success-slot>
</template>

<script lang="ts">
import { Vue, Component } from "vue-property-decorator";

@Component
export default class FailPage extends Vue {
  get query() {
    return this.$route.query;
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

button.link {
  margin-top: 0.12rem;
}
</style>

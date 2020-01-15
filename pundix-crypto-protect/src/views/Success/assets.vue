<template>
  <success-slot class="success-buy">
    <template #title>
      {{ $t(`success.assets.${query.type}`, { unit: query.unit }) }}
    </template>

    <div class="option-amount" slot="amount">
      <p class="title">{{ $t("success.assets.amount") }}</p>
      <strong class="amount" :class="query.type"
        >{{ amountSymbol }}{{ query.amount }} {{ query.unit }}</strong
      >
    </div>

    <div slot="other">
      <router-link :to="{ name: 'assets' }" tag="button" class="link">{{
        $t("success.button.checkMyAssets")
      }}</router-link>
      <router-link :to="{ name: 'home' }" tag="button" class="link">{{
        buyOrQuitbtn
      }}</router-link>
    </div>
  </success-slot>
</template>

<script lang="ts">
import { Vue, Component } from "vue-property-decorator";

@Component
export default class SuccessBuy extends Vue {
  get query() {
    return this.$route.query;
  }

  get buyOrQuitbtn() {
    switch (this.query.type) {
      case "deposit":
        return this.$t("success.button.startBuy");
      case "withdraw":
        return this.$t("success.button.quitOption");
      default:
        return "";
    }
  }

  get amountSymbol() {
    switch (this.query.type) {
      case "deposit":
        return "+";
      case "withdraw":
        return "-";
      default:
        return "";
    }
  }

  get wayExercise() {
    return Object.keys(this.$t("success.buy.issues.issue"));
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

.success-buy .option-amount .amount.withdraw {
  color: #df625f;
}

.success-buy .issues {
  padding: 0.6rem 0 0.22rem;
  counter-reset: issue;
}

.success-buy .issues .title {
  font-size: 0.16rem;
  color: #333333;
}

.success-buy .issues .issue {
  font-size: 12px;
  color: #7e7e7e;
  line-height: 0.16rem;
  margin-top: 0.2rem;
  padding-left: 0.22rem;
  position: relative;
}

.success-buy .issues .issue::before {
  counter-increment: issue;
  content: counter(issue);
  position: absolute;
  left: 0;
  top: 0;
  color: #ff8717;
  font-size: 0.1rem;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 0.14rem;
  height: 0.14rem;
  font-weight: 700;
}

.success-buy .issues .issue::after {
  content: "";
  position: absolute;
  left: 0;
  top: 0;
  display: inline-block;
  width: calc(0.14rem * 2);
  height: calc(0.14rem * 2);
  border: 0.01rem solid #ff8717;
  border-radius: 0.04rem;
  box-sizing: border-box;
  transform: scale(0.5);
  transform-origin: 0 0;
}

button.link {
  margin-top: 0.12rem;
}
</style>

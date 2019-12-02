<template>
  <div class="bob-amount">
    <div class="amount-list">
      <span>{{ $t("order.info.amount.productPrice") }}: </span>
      <span
        >{{ (info.productPrice * form.num) | floatNum }}
        {{ info.priceUnit }}</span
      >
    </div>
    <div class="amount-list warning">
      <span>{{ $t("order.info.amount.discount") }}: </span>
      <span
        >{{ (info.discount * form.num) | floatNum }} {{ info.priceUnit }}</span
      >
    </div>

    <div class="line"></div>

    <div class="amount-list total">
      <span>{{ $t("order.info.amount.total") }}: </span>
      <span class="amount"
        >{{ (info.discountAmount * form.num) | floatNum }}
        {{ info.priceUnit }}</span
      >
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  props: {
    info: Object
  },
  computed: mapState({
    form: state => state.orderForm
  }),

  filters: {
    // 解决浮点数问题
    floatNum(val) {
      const numStr = val.toString().split(".");

      numStr[0] = numStr[0].replace(/(\d)(?=(?:\d{3})+$)/g, "$1,");

      if (numStr[1] && numStr[1].length > 2) {
        numStr[1] = numStr[1].slice(0, 2).replace(/([0])$/, "");
      }

      return numStr.join(".");
    }
  }
};
</script>

<style scoped>
.bob-amount .amount-list {
  font-size: 0.12rem;
  color: #999999;
  line-height: 0.18rem;
  display: flex;
  justify-content: space-between;
}

.bob-amount .amount-list + .amount-list {
  margin-top: 0.1rem;
}

.bob-amount .amount-list.warning {
  color: #bd2e2e;
}

.bob-amount .amount-list.total {
  font-size: 0.14rem;
  color: #333333;
  line-height: 0.2rem;
}

.bob-amount .amount-list.total .amount {
  font-size: 0.18rem;
}

.line {
  height: 0.5px;
  background-color: #e3e3e3;
  margin: 0.12rem 0;
}
</style>

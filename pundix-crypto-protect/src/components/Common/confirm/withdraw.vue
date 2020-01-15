<template>
  <div class="withdraw">
    <div class="input border flex-center">
      <input
        type="number"
        :placeholder="$t('common.confirm.deposit.placeholder')"
        v-model.number="_value"
      />
    </div>
    <p class="usd">≈{{ rate | amount(2) }} {{ data.referenceUnit }}</p>

    <label-list :label="$t('common.confirm.withdraw.balance')">
      {{ data.amount | amount }}
    </label-list>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";

import LabelList from "@/components/Common/labelList/index.vue";
import { Format } from "@/plugins/format";

@Component({
  components: {
    LabelList
  }
})
export default class Withdraw extends Vue {
  @Prop(Object) data!: SearchWithdrawal;
  @Prop(Number) value!: number;

  get _value() {
    return this.value || "";
  }

  set _value(val) {
    this.$emit("input", val);

    this.$nextTick(() => {
      if (val > this.data.amount) {
        this.$emit("input", this.data.amount.toFixed(8));
      }
    });
  }

  get rate() {
    return this.data.exchangeRate * this.value;
  }
}
</script>

<style scoped>
/* 输入框 */
.withdraw .input {
  height: 0.4rem;
  background-color: #fbfbfb;
}

.withdraw .input::after {
  border-color: #e3e3e3;
  border-radius: 0.04rem;
}

.withdraw .input input {
  width: calc(100% - 0.01rem);
  height: calc(100% - 0.01rem);
  border: none;
  z-index: 1;
  position: relative;
  box-sizing: border-box;
  padding: 0.12rem;
}

/* usd */
.withdraw .usd {
  font-size: 0.12rem;
  color: #7e7e7e;
  margin-top: 0.02rem;
}

.withdraw .label-list {
  margin-top: 0.2rem;
}
</style>

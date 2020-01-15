<template>
  <div class="confirmation">
    <div class="info line">
      <label-list
        :success="true"
        :label="$t('common.confirm.confirmation.label.option')"
      >
        +{{ data.info.earn | amount }} {{ data.info.earnUnit }}
      </label-list>
      <label-list :label="$t('common.confirm.confirmation.label.total')">
        {{ data.info.total | amount }} {{ data.info.totalUnit }}
      </label-list>
    </div>

    <div class="need-pay line flex-align-center">
      <p class="label">{{ $t("common.confirm.confirmation.label.needPay") }}</p>
      <strong
        >{{ _value ? needPay : data.info.total | amount }}
        {{ data.info.totalUnit }}</strong
      >
    </div>

    <common-checkbox v-model="_value">
      <span class="balance flex-align-center">
        {{ $t("common.confirm.confirmation.label.balance") }}:
        {{ data.info.balance | amount }} {{ data.info.balanceUnit }}</span
      >
    </common-checkbox>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop, PropSync } from "vue-property-decorator";
import LabelList from "@/components/Common/labelList/index.vue";
import CommonCheckbox from "@/components/Common/checkbox/index.vue";

@Component({
  components: {
    LabelList,
    CommonCheckbox
  }
})
export default class Confirmation extends Vue {
  @Prop(Object) data!: IConfirmationData;
  @PropSync("value", Boolean) _value!: boolean;

  /** 需要支付的金额 */
  get needPay() {
    // 余额 - 总数
    const gap = this.data.info.balance - this.data.info.total;

    return gap >= 0 ? 0 : Math.abs(gap);
  }
}
</script>

<style scoped>
.confirmation .info {
  padding-bottom: 0.24rem;
}

.confirmation .need-pay {
  justify-content: space-between;
  padding: 0.18rem 0;
}

.confirmation .need-pay {
  font-size: 0.14rem;
}

.confirmation .common-checkbox {
  margin-top: 0.16rem;
}

.confirmation .balance {
  margin-left: 0.06rem;
  font-size: 0.12rem;
  color: #333333;
}
</style>

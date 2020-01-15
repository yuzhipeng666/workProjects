<template>
  <div class="last-time">
    <div class="formula line">
      <i18n
        :path="
          `common.confirm.lastTime.desc[${data.annualizedRate.riseRateType}]`
        "
      >
        <template #other v-if="data.annualizedRate.riseRateType === 0">
          {{
            `${returnOther} / ${getDayDiff(
              data.annualizedRate.baseExchangeRate,
              data.annualizedRate.targetExchangeRate
            )} * 365`
          }}
        </template>
        <template #other v-else-if="data.annualizedRate.riseRateType === 1">
          {{ returnOther }}
        </template>
        <span slot="rate" class="success-color">
          + {{ data.annualizedRate.annualizedRate | amount(2) }} %
        </span>
        <template #buyUnit>{{ data.investUnit }}</template>
        <template #getUnit>{{ data.earnUnit }}</template>
      </i18n>
    </div>

    <p class="ps">
      {{
        $t("common.confirm.lastTime.timePs", {
          getUnit: data.earnUnit,
          buyUnit: data.investUnit
        })
      }}
    </p>

    <div class="info">
      <label-list>
        <template #label>
          {{ data.annualizedRate.baseDt | moment("MMM DD") }}
        </template>

        <template>{{ data.annualizedRate.baseExchangeRate | amount }}</template>
      </label-list>

      <label-list>
        <template #label>
          {{ data.annualizedRate.targetDt | moment("MMM DD") }}
        </template>

        <template>
          {{ data.annualizedRate.targetExchangeRate | amount }}
        </template>
      </label-list>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";
import Timer from "@/mixins/timer";
import { IPlanList } from "@/components/Home/lite/list.vue";
import LabelList from "@/components/Common/labelList/index.vue";

@Component({
  components: {
    LabelList
  }
})
export default class ConfirmLastTime extends Vue {
  @Prop(Object) data!: IPlanList;

  get returnOther() {
    const baseDtText = this.getPriceTimeText(this.data.annualizedRate.baseDt);
    const targetDtText = this.getPriceTimeText(
      this.data.annualizedRate.targetDt
    );

    return `(${baseDtText} - ${targetDtText}) / ${targetDtText}`;
  }

  getDayDiff(start: number, end: number) {
    return this.$moment(end).diff(this.$moment(start), "days");
  }

  getPriceTimeText(time: number) {
    return this.$t("common.confirm.lastTime.priceTime", {
      time: this.$moment(time).format("MMM DD")
    });
  }
}
</script>

<style scoped>
.last-time .line,
.last-time .ps,
.last-time .info {
  padding: 0.1rem 0;
}

.last-time .formula {
  font-size: 0.15rem;
  line-height: 0.22rem;
}

.last-time .ps {
  font-size: 0.14rem;
}
</style>

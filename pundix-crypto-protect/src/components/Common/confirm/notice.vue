<template>
  <div class="notice">
    <div class="info line">
      <label-list
        :label="$t('common.confirm.notice.exerciseExpiry')"
        :error="true"
      >
        {{ dt | countdown }}
      </label-list>
      <label-list
        :label="$t(`myPlansDetail.preview.radio.${data.type}`)"
        :success="true"
      >
        + {{ data.profit | amount(2) }}%
      </label-list>
    </div>

    <i18n path="common.confirm.notice.ps" tag="p" class="ps">
      <template #unit>
        <strong class="success-color">{{ data.unit }}</strong>
      </template>
    </i18n>

    <div class="terms">
      <common-checkbox v-model="_value">
        <p>{{ $t("common.confirm.notice.terms") }}</p>
      </common-checkbox>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Mixins, Watch } from "vue-property-decorator";
import Timer from "@/mixins/timer";
import LabelList from "@/components/Common/labelList/index.vue";
import CommonCheckbox from "@/components/Common/checkbox/index.vue";

@Component({
  components: {
    LabelList,
    CommonCheckbox
  }
})
export default class Notice extends Mixins(Timer) {
  @Prop(Object) data!: CommonConfirmNoticeData;

  @Prop(Boolean) value!: boolean;

  get _value() {
    return this.value;
  }

  set _value(val) {
    this.$emit("input", val);
  }

  get dt() {
    this.timerHandler(this.data.dt);

    return this.data.dt - this.systemDt;
  }
}
</script>

<style scoped>
.notice .info {
  padding: 0.22rem 0;
}

.notice .ps {
  font-size: 0.14rem;
  color: #333333;
  margin-top: 0.24rem;
  line-height: 0.2rem;
}

.notice .terms {
  margin-top: 0.25rem;
  font-size: 0.12rem;
  color: #7e7e7e;
}

.notice .terms p {
  margin-left: 0.06rem;
}
</style>

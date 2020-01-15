<template>
  <load-more-slot class="buying-lite" :more="false" @refresh="refresh">
    <!-- Buying -->
    <home-lite-list :title="$t('buy.lite.buying.title')" :list="info" />

    <!-- Preview -->
    <box-slot
      class="preview"
      :title="$t('buy.lite.preview.title')"
      :line="false"
    >
      <div slot="header" class="header">
        <h4>{{ $t("buy.lite.preview.protect", { getUnit: "NPXS" }) }}</h4>
        <div class="time flex-align-center">
          <i class="icon icon-calender"></i>
          <span>{{ Date.now() | moment("YYYY-MM-DD") }}</span>
        </div>
      </div>
      <ul class="protect-type-list flex-align-center">
        <protect-type
          v-for="(list, index) in ProtectTypeList"
          :key="index"
          :list="list"
        />
      </ul>
      <p class="ps">
        {{
          $t("buy.lite.preview.ps", {
            buyUnit: info.investUnit,
            getUnit: info.earnUnit
          })
        }}
      </p>
    </box-slot>

    <box-slot :title="$t('buy.lite.payment.title')" class="payment">
      <form slot="header" id="form" @submit.prevent="submitHandler">
        <common-count-selector-item
          v-model.number="form.investPart"
          :max="info.maxInvestPart"
        />
      </form>

      <label-list
        class="line"
        :label="$t('buy.lite.payment.label.costPrice')"
        :valueStrong="false"
      >
        {{ info.earnToInvestExchangeRate | amount }}
      </label-list>

      <label-list class="line" :valueStrong="false">
        <i18n slot="label" path="buy.lite.payment.label.fee">
          <template #fee>{{ (info.feeRate * 100) | amount(2) }}</template>
        </i18n>
        {{ feeAmount | amount }}
      </label-list>

      <label-list
        labelSize=".16rem"
        valueSize=".16rem"
        labelColor="#333333"
        :label="$t('buy.lite.payment.label.total')"
        :labelStrong="true"
      >
        {{ totalAmount | amount }} {{ info.investUnit }}
      </label-list>
    </box-slot>

    <button class="submit" type="submit" form="form">
      {{ $t("common.button.submit") }}
    </button>
  </load-more-slot>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";
import { namespace } from "vuex-class";

import HomeLiteList from "@/components/Home/lite/list.vue";
import CommonCountSelectorItem from "@/components/Common/countSelector/item.vue";
import LabelList from "@/components/Common/labelList/index.vue";
import ProtectType, { IProtectTypeList } from "./protectType.vue";

const commonModule = namespace("common");

@Component({
  components: {
    HomeLiteList,
    CommonCountSelectorItem,
    LabelList,
    ProtectType
  }
})
export default class BuyLite extends Vue {
  @Prop(Number) planId!: number;

  @commonModule.Mutation CHANGE_LOADING!: (bool: boolean) => void;

  /** 基础信息 */
  private info = {} as BuyLitePlanDetail;

  private form = {
    investPart: 1
  };

  /**
   * 保护的币种列表
   */
  get ProtectTypeList(): IProtectTypeList[] {
    return [
      {
        type: 0,
        buyUnit: this.info.investUnit,
        getUnit: this.info.earnUnit,
        amount: this.protectBuyUnitAmount,
        limitAmount: this.info.earnToInvestExchangeRate
      },
      {
        type: 1,
        buyUnit: this.info.investUnit,
        getUnit: this.info.earnUnit,
        amount: this.getUnitAmount,
        limitAmount: this.info.earnToInvestExchangeRate
      }
    ];
  }

  /**
   * 应得收益币种
   * 每份收益 * 数量
   */
  get getUnitAmount() {
    return this.info.earnAmountOfPerPart * this.form.investPart;
  }

  /**
   * 受保护的购买币种金额
   * 每份收益 * 数量 * 汇率
   */
  get protectBuyUnitAmount() {
    return this.getUnitAmount * this.info.earnToInvestExchangeRate;
  }

  /**
   * 手续费金额
   * Cost Price * Get NPXS * Quantity * 手续费率
   */
  get feeAmount() {
    return this.protectBuyUnitAmount * this.info.feeRate;
  }

  /**
   * 需要支付的总额
   */
  get totalAmount() {
    return this.protectBuyUnitAmount * (1 + this.info.feeRate);
  }

  /**
   * 提交购买订单
   */
  submitHandler() {
    // 封装弹窗所需要的数据
    const info = {
      total: this.totalAmount,
      totalUnit: this.info.investUnit,
      earn: this.getUnitAmount,
      earnUnit: this.info.earnUnit,
      balance: this.info.availableBalance,
      balanceUnit: this.info.investUnit
    } as IConfirmationDataInfo;

    this.$emit("submit", {
      info,
      form: this.form,
      other: this.info,
      payFail: () => this.getAll()
    } as IConfirmationData);
  }

  /**
   * 获取详情信息
   */
  async getInfo() {
    const data = await this.axios.post<BuyLitePlanDetail>(
      "/cryptoGamingPlan/simplifyPlanDetail",
      {
        planId: this.planId
      }
    );

    this.info = data;
  }

  /** 下拉刷新 */
  refresh(done: Function) {
    this.getAll();

    done();
  }

  getAll() {
    Promise.all([this.getInfo()]).finally(() => this.CHANGE_LOADING(false));
  }

  created() {
    this.getAll();
  }
}
</script>

<style scoped>
.buying-lite .box-slot {
  margin-bottom: 0.18rem;
}

.buying-lite .preview .header h4 {
  font-size: 0.16rem;
  color: #333333;
}

.buying-lite .preview .time {
  font-size: 0.14rem;
  color: #333333;
  margin: 0.05rem 0 0.14rem;
}

.buying-lite .preview .time span {
  margin-left: 0.05rem;
  opacity: 0.5;
}

.buying-lite .preview .protect-type-list {
  justify-content: space-between;
}

.buying-lite .preview .ps {
  font-size: 0.13rem;
  color: #999999;
  margin-top: 0.18rem;
}

.buying-lite .payment .label-list:not(:last-child) {
  padding: 0.12rem 0;
}

.buying-lite button[type="submit"] {
  margin-top: 0.18rem;
}
</style>

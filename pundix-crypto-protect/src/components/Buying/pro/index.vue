<template>
  <load-more-slot class="buying" @refresh="refresh">
    <!-- 计划时间 -->
    <box-slot class="currency">
      <template #header>
        <coin-info
          :icon="info.earnIcon"
          :unit="info.earnUnit"
          :name="info.planName"
          :monthDay="info.monthDay"
          :dayNumber="info.dayNumber"
        />
      </template>

      <!-- 进度条 -->
      <common-progress
        class="progress"
        :beforeDay="frozenDay"
        :afterDay="optionDay"
      />

      <!-- 时间线 -->
      <timeline
        v-show="isShowTimeline"
        :type="0"
        :systemDt="systemDt"
        :frozenDt="info.investEndDt"
        :exerciseDt="info.freezeEndDt"
        :finishDt="info.exerciseEndDt"
      />

      <!-- 时间线按钮 -->
      <div
        class="timeline-btn flex-center"
        @click="isShowTimeline = !isShowTimeline"
      >
        <span class="detail-btn flex-center">
          <i class="icon icon-detail" :class="{ rotate: isShowTimeline }"></i>
        </span>
      </div>
    </box-slot>

    <!-- 计划金额详情 -->
    <box-slot class="quantity">
      <h3 slot="header">{{ $t("buy.quantity.title") }}</h3>
      <!-- 表单 -->
      <form class="line" id="form" @submit.prevent="submitHandler">
        <div class="form-item">
          <common-count-selector-item
            v-model.number="investPart"
            :max="info.maxInvestPart"
          />
        </div>

        <label-list
          class="form-item"
          :success="shareGetColor"
          :label="
            $t('buy.quantity.label.shareGet', { currency: info.earnUnit })
          "
        >
          {{ shareGet }}
        </label-list>
      </form>
      <div class="info line">
        <label-list :label="$t('buy.quantity.label.payment')">
          {{ info.investUnit }}
        </label-list>
        <label-list :label="$t('buy.quantity.label.price')">
          {{ info.earnToInvestExchangeRate | amount }}
        </label-list>
        <label-list :label="$t('buy.quantity.label.cost')">
          {{ costAmount | amount }}
        </label-list>
        <label-list :label="$t('buy.quantity.label.fee')">
          <template #label>
            ({{ (info.feeRate * 100) | amount(2) }}%)
          </template>
          {{ feeAmount | amount }}
        </label-list>
      </div>

      <!-- 总数 -->
      <div class="total form-item line">
        <strong class="label">{{ $t("buy.quantity.label.total") }}</strong>
        <strong class="value"
          >{{ investTotalAmount | amount }} {{ info.investUnit }}</strong
        >
      </div>

      <div class="balance flex-align-center">
        <p class="balance-text">
          {{
            $t("buy.quantity.label.balance", {
              amount: info.availableBalance,
              currency: info.investUnit
            })
          }}
        </p>
        <strong class="deposit-btn" @click="depositHandler">{{
          $t("buy.quantity.btn.deposit")
        }}</strong>
      </div>
    </box-slot>

    <!-- Need help -->
    <p class="help" @click="openNewPage('helpLink')">{{ $t("buy.help") }}</p>

    <div class="terms">
      <common-checkbox v-model="terms">
        <i18n path="buy.terms.all" tag="p">
          <template #terms>
            <strong class="link" @click="openNewPage('termsLink')">
              {{ $t("buy.terms.link") }}
            </strong>
          </template>
        </i18n>
      </common-checkbox>
    </div>

    <div class="bottom">
      <button type="submit" :disabled="!terms" class="submit" form="form">
        {{ $t("buy.bottom.btn") }}
      </button>
    </div>
  </load-more-slot>
</template>

<script lang="ts">
import { Component, Prop, Mixins } from "vue-property-decorator";

import CommonCountSelectorItem from "@/components/Common/countSelector/item.vue";
import CommonProgress, {
  objContent
} from "@/components/Common/progress/index.vue";
import CommonCheckbox from "@/components/Common/checkbox/index.vue";
import LabelList from "@/components/Common/labelList/index.vue";
import CoinInfo from "@/components/Common/box/coinInfo.vue";
import Timeline from "@/components/Common/box/timeline.vue";

import { config } from "@/config";
import { namespace } from "vuex-class";
import ConfirmRoute from "@/mixins/confirmRoute";
import Timer from "@/mixins/timer";
import { Format } from "@/plugins/format";

const commonModule = namespace("common");

@Component({
  components: {
    CommonCheckbox,
    CommonProgress,
    CommonCountSelectorItem,
    LabelList,
    CoinInfo,
    Timeline
  }
})
export default class Buying extends Mixins(Timer, ConfirmRoute) {
  @Prop([Number]) planId!: number;

  @commonModule.Mutation CHANGE_CONFIRM!: (obj: CommonConfirm) => void;
  @commonModule.Mutation CHANGE_LOADING!: (bool: boolean) => void;

  private info = {} as BuyProPlanDetail;
  private form = {
    investPart: 1
  };

  private shareGetColor = false;

  /** 条约选中情况 */
  private terms = false;

  // 时间线显示状态
  private isShowTimeline = false;

  get investPart() {
    return this.form.investPart;
  }

  set investPart(val) {
    this.form.investPart = val;

    !this.shareGetColor && (this.shareGetColor = true);
  }

  get costAmount() {
    return this.shareGet * this.info.earnToInvestExchangeRate;
  }

  /** 手续费金额 */
  get feeAmount() {
    return this.costAmount * this.info.feeRate;
  }

  /** 冻结时长 */
  get frozenDay() {
    return this.info.freezeEndDt - this.info.investEndDt;
  }

  /** 行权时长 */
  get optionDay() {
    return this.info.exerciseEndDt - this.info.freezeEndDt;
  }

  /** 冻结开始文案 */
  get beforeContent(): objContent {
    return {
      title: this.$t("buy.currency.progress.before") as string,
      time: this.info.investEndDt
    };
  }
  /** 行权开始文案 */
  get afterContent(): objContent {
    return {
      title: this.$t("buy.currency.progress.after") as string,
      time: this.info.freezeEndDt
    };
  }
  /** 行权结束文案 */
  get endContent(): objContent {
    return {
      title: this.$t("buy.currency.progress.end") as string,
      time: this.info.exerciseEndDt
    };
  }

  /** 收益总额 */
  get shareGet() {
    return this.info.earnAmountOfPerPart * this.form.investPart;
  }

  /** 总购买金额 */
  get investTotalAmount() {
    return this.costAmount * (1 + this.info.feeRate);
  }

  /**
   * 下拉刷新
   */
  refresh(done: Function) {
    Promise.all([this.getDetail(), done()]);
  }

  /**
   * 获取详情信息
   */
  async getDetail() {
    const data = await this.axios
      .post("/cryptoGamingPlan/planDetail", {
        planId: this.planId
      })
      .finally(() => this.CHANGE_LOADING(false));

    this.info = data;
    this.systemDt = this.info.systemDt;

    this.systemDtTimer();
  }

  /**
   * newPage
   */
  openNewPage(opt: "helpLink" | "termsLink") {
    window.PX.newPage({ link: config[opt] as string });
  }

  /**
   * 调用支付弹窗
   */
  depositHandler() {
    this.CHANGE_CONFIRM({
      type: "deposit",
      title: this.$t("common.confirm.title.deposit", {
        currency: this.info.investUnit
      }) as string,
      data: {
        unit: this.info.investUnit
      },
      confirmBtn: this.$t("common.confirm.btn.submit") as string,
      confirmHandler: async (obj: PayParamsRequest) => {
        // 调用用户充值接口
        const { data, nonceStr, sign, timestamp } = await this.axios.post<
          PayParamsResponse
        >("/user/recharge", obj);

        window.Pundix.pay(
          {
            data,
            nonceStr,
            sign,
            timestamp
          },
          this.getDetail,
          () => this.CHANGE_LOADING(false)
        );
      }
    });
  }

  /**
   * 根据路由name跳转任何地方
   */
  routeToAny(name: string, query: any) {
    // 关闭loading
    this.CHANGE_LOADING(false);

    // 跳转页面
    this.$router.replace({ name, query });
  }

  /**
   * 获取当前系统时间
   */
  systemDtTimer() {
    this.timerHandler(this.info.investEndDt, {
      timeFunc: this.systemDtTimer
    });
  }

  /**
   * 提交订单
   */
  submitHandler() {
    // 封装弹窗所需要的数据
    const info = {
      total: this.investTotalAmount,
      totalUnit: this.info.investUnit,
      earn: this.shareGet,
      earnUnit: this.info.earnUnit,
      balance: this.info.availableBalance,
      balanceUnit: this.info.investUnit
    } as IConfirmationDataInfo;

    this.$emit("submit", {
      info,
      form: this.form,
      other: this.info,
      payFail: () => this.getDetail()
    } as IConfirmationData);
  }

  created() {
    this.getDetail();
  }
}
</script>

<style scoped>
.form-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0.07rem 0;
}

.form-item .label {
  font-size: 0.13rem;
  line-height: 0.15rem;
  color: #7e7e7e;
}

.form-item .value {
  font-size: 0.14rem;
  color: #333333;
  line-height: 0.16rem;
}

/* 进度条 */
.currency .progress {
  padding-bottom: 0.1rem;
}

/* 时间线 */
.timeline-btn {
  margin-top: 0.14rem;
}

.timeline-btn .detail-btn {
  width: 0.3rem;
  height: 0.12rem;
  background-color: #f5f5f5;
  border-radius: 0.06rem;
}

.timeline-btn .detail-btn .icon {
  transform: rotate(90deg);
  transition: transform 0.3s ease;
}

.timeline-btn .detail-btn .icon.rotate {
  transform: rotate(-90deg);
}

/* Quantity box */
.quantity {
  margin: 0.12rem 0 0.18rem;
}

.quantity .info {
  padding: 0.06rem 0;
}

.quantity .total {
  padding: 0.2rem 0;
}

.quantity .total .label {
  font-size: 0.14rem;
  line-height: 0.16rem;
  color: #333333;
}

.quantity .share-get .value {
  font-size: 0.12rem;
  color: #41bd77;
}

/* 余额 */
.quantity .balance {
  padding-top: 0.1rem;
}
.quantity .balance .balance-text {
  color: #7e7e7e;
  font-size: 0.12rem;
  line-height: 0.14rem;
}

.quantity .balance .deposit-btn {
  line-height: 0.14rem;
  font-size: 0.12rem;
  margin-left: 0.1rem;
  color: #ff9028;
}

/* 帮助 */
.help {
  text-decoration: underline;
  text-align: center;
  font-size: 0.12rem;
  color: #aaaaaa;
  line-height: 0.16rem;
}

/* 条约 */
.terms {
  margin: 0.25rem 0 0.14rem;
}

.terms p {
  font-size: 0.12rem;
  line-height: 0.14rem;
  color: #7e7e7e;
  margin-left: 0.06rem;
}

.terms p .link {
  color: #ff8717;
  text-decoration: underline;
}
</style>

<template>
  <load-more-slot class="my-plans-detail" :more="false" @refresh="refresh">
    <h6 class="detail-title">{{ $t("myPlansDetail.title") }}</h6>
    <box-slot>
      <template #header>
        <coin-info
          :icon="info.earnIcon"
          :unit="info.earnUnit"
          :name="info.planName"
          :monthDay="info.monthDay"
          :dayNumber="info.dayNumber"
        />
      </template>

      <timeline
        :type="1"
        :systemDt="systemDt"
        :boughtDt="info.buyDt"
        :frozenDt="info.investEndDt"
        :exerciseDt="info.freezeEndDt"
        :finishDt="info.exerciseEndDt"
      />
    </box-slot>

    <box-slot>
      <template #header>
        <h6 class="box-title">{{ $t("myPlansDetail.position.title") }}</h6>

        <label-list
          :success="true"
          :label="$t('myPlansDetail.position.label.status')"
        >
          {{ $t("myPlansDetail.position.status")[info.status] }}
        </label-list>
        <label-list
          :label="
            $t('myPlansDetail.position.label.have', {
              unit: info.earnUnit
            })
          "
        >
          {{ info.earnAmount | amount }}
        </label-list>
        <label-list
          :label="
            $t('myPlansDetail.position.label.paid', {
              unit: info.investUnit
            })
          "
        >
          {{ info.orderInvestAmount | amount }}
        </label-list>
      </template>

      <h6 class="box-title preview">{{ $t("myPlansDetail.preview.title") }}</h6>

      <label-list
        v-if="info.status === 0 || info.status === 1"
        :success="true"
        :label="previewLabelTime"
      >
        {{ previewValueTime | countdownDay }}
      </label-list>
      <label-list v-else :success="true" :label="previewLabelTime">
        {{ previewValueTime | moment("MMM DD, HH:mm:ss") }}
      </label-list>
      <label-list
        :success="true"
        :label="$t('myPlansDetail.preview.label.floating')[info.riseRateType]"
      >
        +{{ info.riseRate | amount(2) }}%
      </label-list>
      <label-list
        :label="
          $t('myPlansDetail.preview.label.bought', {
            earnUnit: info.earnUnit,
            investUnit: info.investUnit
          })
        "
      >
        {{ info.earnToInvestExchangeRateBuy | amount }}
      </label-list>
      <label-list :label="currentPrice">
        <template #label>
          <i class="icon icon-issue" @click="issueHandler"></i>
        </template>
        {{ info.earnToInvestExchangeRateNew | amount }}
      </label-list>
    </box-slot>

    <box-slot :line="false">
      <h6 class="box-title">
        {{ $t(`myPlansDetail.preview.titleProtect[${info.status}]`) }}
      </h6>

      <div class="exercise-radio-list flex-align-center">
        <exercise-radio
          v-model="exercise"
          v-for="list in exerciseList"
          :key="list.value"
          :list="list"
          :disabled="info.status !== 1"
        />
      </div>

      <button v-if="info.status === 2" class="submit" disabled>
        {{
          $t("myPlans.planLists.timeExercise.chosen", {
            other: info.investUnit
          })
        }}
      </button>
      <button
        v-else-if="info.status === 3 || info.status === 4"
        class="submit"
        disabled
      >
        {{
          $t("myPlans.planLists.timeExercise.chosen", { other: info.earnUnit })
        }}
      </button>

      <button
        v-else
        class="submit"
        :disabled="!exercise"
        @click="exerciseHandler"
      >
        {{ $t("common.confirm.btn.submit") }}
      </button>

      <div class="tips">
        <strong class="tips-title">{{
          $t("myPlansDetail.exercise.tips")
        }}</strong>
        <p
          v-for="(tip, index) in $t('myPlansDetail.exercise.tipsList')"
          :key="index"
        >
          {{ tip }}
        </p>
      </div>
    </box-slot>
  </load-more-slot>
</template>

<script lang="ts">
import { Component, Prop, Mixins } from "vue-property-decorator";
import { namespace } from "vuex-class";

import ConfirmRoute from "@/mixins/confirmRoute";

import CoinInfo from "@/components/Common/box/coinInfo.vue";
import Timeline from "@/components/Common/box/timeline.vue";
import LabelList from "@/components/Common/labelList/index.vue";
import ExerciseRadio, {
  IExerciseRadioList
} from "@/components/MyPlansDetail/exerciseRadio.vue";
import Timer from "@/mixins/timer";

const commonModule = namespace("common");

interface IMyPlanListDetail {
  /** 购买时间 */
  buyDt: number;
  /** 结束行权时间(完成时间) */
  exerciseEndDt: number;
  /** 结束冻结时间(行权开始时间) */
  freezeEndDt: number;
  /** 涨幅 */
  annualizedRate: number;
  /** 涨幅类型(0:浮盈(Floating); 1:保护(Protected); 2:利润(Profit)) */
  riseRateType: number;
  /** 服务器当前时间 */
  systemDt: number;
  /** 用户操作时间(行权时间) */
  userOpDt: number;
  /** id */
  userPlanId: number;
  /** 某天的第几条计划 */
  dayNumber: number;
  /** 收益币种的总数量 */
  earnAmount: number;
  /** 收益币种图标 */
  earnIcon: string;
  /** 收益币种 */
  earnUnit: string;
  /** 购买币种 */
  investUnit: string;
  /** 行权日期(例如:1201) */
  monthDay: string;
  /** 订单应付金额 */
  orderInvestAmount: number;
  /** 名称 */
  planName: string;
  /** 状态(0:冻结中; 1:行权中; 2:已行权; 3:结算中; 4:完成) */
  status: number;
  /** 收益币涨幅 */
  earnRiseRate: number;
  /** 收益币种对应投资币种汇率(您购买的价格) */
  earnToInvestExchangeRateBuy: number;
  /** 收益币种对应投资币种汇率(当前价格或结束价格) */
  earnToInvestExchangeRateNew: number;
  /** 结束购买时间(冻结开始时间) */
  investEndDt: number;
  /** 购买币涨幅 */
  investRiseRate: number;
}

@Component({
  components: {
    CoinInfo,
    Timeline,
    LabelList,
    ExerciseRadio
  }
})
export default class MyPlansDetail extends Mixins(Timer, ConfirmRoute) {
  @Prop([String, Number]) userPlanId!: string | number;

  @commonModule.Mutation CHANGE_CONFIRM!: (obj: CommonConfirm) => void;
  @commonModule.Mutation CHANGE_LOADING!: (bool: boolean) => void;

  private info = {} as IMyPlanListDetail;

  private exercise = 0;

  // 行权选项
  get exerciseList(): IExerciseRadioList[] {
    return [
      // 购买币
      {
        value: 1,
        type: "protected",
        coin: this.info.investUnit,
        amount: this.info.orderInvestAmount,
        percent: this.info.investRiseRate,
        func: (unit: string) => this.exerciseFinish(unit)
      },
      // 收益币
      {
        value: 2,
        type: "profit",
        coin: this.info.earnUnit,
        amount: this.info.earnAmount,
        percent: this.info.earnRiseRate,
        func: (unit: string) => this.exerciseCancel(unit)
      }
    ];
  }

  get previewLabelTime() {
    switch (this.info.status) {
      case 0:
        return this.$t("myPlansDetail.preview.label.time.0");
      case 1:
        return this.$t("myPlansDetail.preview.label.time.1");
      default:
        return this.$t("myPlansDetail.preview.label.time.2");
    }
  }

  get previewValueTime() {
    switch (this.info.status) {
      case 0:
        return this.info.freezeEndDt - this.info.investEndDt;
      case 1:
        return this.info.exerciseEndDt - this.info.freezeEndDt;
      default:
        return this.info.exerciseEndDt;
    }
  }

  get currentPrice() {
    if (this.info.status === 0 || this.info.status === 1) {
      return this.$t("myPlansDetail.preview.label.currentPrice", {
        earnUnit: this.info.earnUnit,
        investUnit: this.info.investUnit
      });
    } else {
      return this.$t("myPlansDetail.preview.label.finished", {
        earnUnit: this.info.earnUnit,
        investUnit: this.info.investUnit
      });
    }
  }

  /**
   * 系统时间倒计时
   */
  systemDtTimer() {
    this.timerHandler(this.info.exerciseEndDt, {
      timeFunc: () => {
        if (this.systemDt >= this.info.freezeEndDt) {
          this.info.status = 1;
        }

        this.systemDtTimer();
      },
      endFunc: () => {
        // 关闭弹窗
        this.CHANGE_CONFIRM({ isShow: false });

        // 获取详情
        this.getDetail();
      }
    });
  }

  /**
   * 获取详情
   */
  async getDetail() {
    const data = await this.axios
      .post<IMyPlanListDetail>("/cryptoGamingPlan/userPlanDetail", {
        userPlanId: this.userPlanId
      })
      .finally(() => this.CHANGE_LOADING(false));

    this.info = data;
    if ([2, 3, 4].includes(this.info.status)) {
      this.exercise = this.info.status === 2 ? 1 : 2;
    }
  }

  /**
   * 跳转成功page
   */
  routeSuccess(amount: number, unit: string) {
    this.$router.push({
      name: "buyExercise",
      query: {
        amount: amount.toString(),
        unit
      }
    });
  }

  /**
   * 行权取消
   */
  async exerciseCancel(unit: string) {
    const data = await this.axios
      .post("/cryptoGamingPlan/exerciseCancelled", {
        userPlanId: this.userPlanId
      })
      .finally(() => this.CHANGE_LOADING(false));

    this.routeSuccess(data.earnAmount, unit);
  }

  /**
   * 行权结束
   */
  async exerciseFinish(unit: string) {
    const data = await this.axios
      .post("/cryptoGamingPlan/exerciseFinished", {
        userPlanId: this.userPlanId
      })
      .finally(() => this.CHANGE_LOADING(false));

    this.routeSuccess(data.orderInvestAmount, unit);
  }

  /**
   * 选择行权
   */
  async exerciseHandler() {
    // 过滤出选中的行权方式
    let unitInfo = this.exerciseList.filter(
      ele => ele.value === this.exercise
    )[0];

    this.CHANGE_CONFIRM({
      type: "notice",
      title: this.$t("common.confirm.title.notice") as string,
      data: {
        dt: this.info.exerciseEndDt - this.systemDt,
        type: unitInfo.type,
        profit: unitInfo.percent,
        unit: unitInfo.coin
      } as CommonConfirmNoticeData,
      showCancel: true,
      confirmHandler: () => {
        unitInfo.func(unitInfo.coin);
      }
    });
  }

  /**
   * 下拉刷新
   */
  async refresh(done: Function) {
    await this.getDetail();

    done();
  }

  issueHandler() {
    this.CHANGE_CONFIRM({
      type: "currentPrice",
      title: this.$t("common.confirm.title.currentPrice") as string,
      data: {
        systemDt: this.info.systemDt
      }
    });
  }

  async created() {
    await this.getDetail();

    this.systemDt = this.info.systemDt;

    this.systemDtTimer();
  }
}
</script>

<style scoped>
.my-plans-detail .detail-title {
  font-size: 0.18rem;
  color: #000000;
  margin-bottom: 0.1rem;
}

.my-plans-detail .box-slot + .box-slot {
  margin-top: 0.12rem;
}

.my-plans-detail .box-title {
  margin-bottom: 0.2rem;
  font-size: 0.16rem;
  color: #333333;
}

.my-plans-detail .preview {
  margin-top: 0.14rem;
}

.my-plans-detail .tips {
  margin-top: 0.26rem;
  margin-bottom: 0.2rem;
}

.my-plans-detail .tips .tips-title {
  display: block;
  font-size: 0.14rem;
  margin-bottom: 0.05rem;
  color: #333333;
}

.my-plans-detail .tips p {
  font-size: 0.12rem;
  color: #7e7e7e;
  line-height: 0.16rem;
  letter-spacing: 0.0015rem;
}

.my-plans-detail .submit {
  margin-top: 0.24rem;
}

.my-plans-detail .exercise-radio-list {
  justify-content: space-between;
}

.my-plans-detail .icon-issue {
  margin-left: 0.04rem;
}
</style>

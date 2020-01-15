<template>
  <box-slot class="pro-list" :class="{ disabled }">
    <template #header>
      <coin-info
        :icon="list.earnIcon"
        :unit="list.earnUnit"
        :name="list.planName"
        :monthDay="list.monthDay"
        :dayNumber="list.dayNumber"
      >
        <div class="flex-align-center">
          <round-progress :percent="list.percentSold" />
          <p class="sold">
            <span>{{ list.percentSold }}%</span> {{ $t("home.planList.sold") }}
          </p>
        </div>
      </coin-info>
    </template>

    <div class="main line">
      <label-list :success="true" :label="priceLabel">
        <template #label>
          <i class="icon icon-exchange" @click="isShare = !isShare"></i>
        </template>

        <span v-if="list.status === 0">- -</span>
        <span v-else>{{ priceAmount | amount }} {{ list.investUnit }}</span>
      </label-list>

      <label-list :label="$t('home.planList.per')">
        {{ list.earnAmountOfPerPart | amount }} {{ list.earnUnit }}
      </label-list>

      <label-list :label="$t('home.planList.time')">
        {{ list.freezeEndDt | moment("MMM DD, HH:mm:ss") }}
      </label-list>
    </div>

    <common-progress :beforeDay="frozenDay" :afterDay="optionDay" />

    <div class="bottom" v-show="!disabled">
      <div class="frozen" v-if="list.status === 0">
        <!-- 预售倒计时 -->
        <div class="time flex-center">
          <i class="icon icon-countdown"></i>
          <span>{{ waitEndCountDown | countdown }}</span>
        </div>
        <button class="wait" readonly>
          {{ $t("home.planList.waitBtn") }}
        </button>
      </div>
      <div class="invest" v-else-if="list.status === 1">
        <!-- 结束购买倒计时 -->
        <div class="time flex-center">
          <i class="icon icon-countdown"></i>
          <span>{{ buyEndCountDown | countdown }}</span>
        </div>
        <router-link
          :to="{
            name: 'buying',
            params: {
              planId: list.planId
            }
          }"
          tag="button"
          class="submit"
        >
          {{ $t("home.planList.buyBtn") }}
        </router-link>
      </div>
    </div>
  </box-slot>
</template>

<script lang="ts">
import { Vue, Component, Prop, Mixins } from "vue-property-decorator";

import CommonProgress from "@/components/Common/progress/index.vue";
import CoinInfo from "@/components/Common/box/coinInfo.vue";
import LabelList from "@/components/Common/labelList/index.vue";
import RoundProgress from "@/components/Common/progress/round.vue";
import Timer from "@/mixins/timer";
import { Time } from "@/plugins/time";
import { namespace } from "vuex-class";

const commonModule = namespace("common");

export interface IPlanProList {
  /** 某天的第几条计划 */
  dayNumber: number;
  /** 收益币种图标 */
  earnIcon: string;
  /** 收益币种对应投资币种汇率 */
  earnToInvestExchangeRate: number;
  /** 收益币种 */
  earnUnit: string;
  /** 购买币种 */
  investUnit: string;
  /** 行权日期(例如:1201) */
  monthDay: string;
  /** id */
  planId: string;
  /** 名称 */
  planName: string;
  /** 每份多少收益 */
  earnAmountOfPerPart: number;
  /** 一份多少价格 */
  exchangeRatePart: number;
  /** 结束行权时间(完成时间) */
  exerciseEndDt: number;
  /** 结束冻结时间(行权开始时间) */
  freezeEndDt: number;
  /** 结束购买时间(冻结开始时间); */
  investEndDt: number;
  /** 开始购买时间(预售结束时间) */
  investStartDt: number;
  /** 已售出百分比 */
  percentSold: number;
  /** 状态(0:预热中; 1:销售中) */
  status: 0 | 1;
  /** 服务器当前时间 */
  systemDt: number;
}

@Component({
  components: {
    CommonProgress,
    CoinInfo,
    LabelList,
    RoundProgress
  }
})
export default class HomePlanList extends Mixins(Timer) {
  @Prop(Object) list!: IPlanProList;
  @Prop(Number) index!: number;
  @Prop({ default: false }) disabled!: boolean;

  @commonModule.Mutation CHANGE_LOADING!: (bool: boolean) => void;

  private dateNow = Date.now(); // 当前时间戳
  private isShare = true;

  get priceLabel() {
    return this.isShare
      ? this.$t("home.planList.price")
      : this.$t("home.planList.coinPrice", { earnUnit: this.list.earnUnit });
  }

  get priceAmount() {
    return this.isShare
      ? this.list.exchangeRatePart
      : this.list.earnToInvestExchangeRate;
  }

  // 冻结时长
  get frozenDay() {
    return this.list.freezeEndDt - this.list.investEndDt;
  }

  // 行权时长
  get optionDay() {
    return this.list.exerciseEndDt - this.list.freezeEndDt;
  }

  // 预售倒计时
  get waitEndCountDown() {
    this.timerHandler(this.list.investStartDt, {
      timeFunc: async () => {
        const { day, hours, minus, seconds } = Time.countdown(
          this.list.investStartDt - this.systemDt
        );

        // 时间少于5秒时，判断是否已获取汇率信息
        // 没有则调用汇率接口
        if (
          day === 0 &&
          hours === 0 &&
          minus === 0 &&
          seconds <= 5 &&
          this.list.earnToInvestExchangeRate === 0
        ) {
          const data: {
            earnToInvestExchangeRate: number;
          } = await this.axios
            .post("/cryptoGamingPlan/searchPlanExchangeRate", {
              planId: this.list.planId
            })
            .finally(() => this.CHANGE_LOADING(false));

          this.list.earnToInvestExchangeRate = data.earnToInvestExchangeRate;
        }
      },
      endFunc: () => (this.list.status = 1)
    });

    return this.list.investStartDt - this.systemDt;
  }

  // 结束购买倒计时
  get buyEndCountDown() {
    this.timerHandler(this.list.investEndDt, {
      endFunc: () => this.$emit("delete", this.index)
    });

    return this.list.investEndDt - this.systemDt;
  }

  created() {
    this.systemDt = this.list.systemDt;
  }
}
</script>

<style scoped>
.pro-list {
  position: relative;
  margin-bottom: 0.24rem;
}

.pro-list.disabled::after {
  content: "";
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.3);
}

/* Header */
.pro-list .coin-info .sold {
  color: #b3b3b3;
  font-size: 0.11rem;
}

.pro-list .coin-info .sold span {
  font-size: 0.13rem;
  color: #ff9028;
  margin-left: 0.04rem;
}

/* Main */
.pro-list .main {
  padding: 0.14rem 0 0.1rem;
}

.pro-list .main .icon-exchange {
  margin-left: 0.08rem;
}

/* Bottom */
.pro-list .bottom .time {
  margin: 0.26rem 0 0.1rem;
}

.pro-list .bottom .time .icon-countdown {
  margin-right: 0.04rem;
}

.pro-list .bottom .time span {
  color: #ff8717;
  position: relative;
  font-size: 0.12rem;
}

.pro-list .bottom .wait {
  background-color: #fff1e4;
  color: #ff8717;
}
</style>

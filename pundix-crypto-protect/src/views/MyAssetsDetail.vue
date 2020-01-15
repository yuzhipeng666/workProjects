<template>
  <load-more-slot class="my-assets-detail" :more="false" @refresh="refresh">
    <div class="container">
      <div class="main">
        <strong class="balance">{{ $t("myAssetsDetail.balance") }}</strong>
        <h4>{{ detail.totalAmount | amount }} {{ unit }}</h4>
        <p class="conversion">
          &#8776;{{ detail.totalAmountConversionUnit | amount(2) }}
          {{ detail.conversionUnit }}
        </p>

        <div class="amount-box">
          <i class="icon icon-available"></i>
          <h5>{{ $t("myAssetsDetail.available") }}</h5>
          <div class="amount">
            <strong>{{ detail.availableAmount | amount }} {{ unit }}</strong>
            <p class="conversion">
              &#8776;{{ detail.availableAmountConversionUnit | amount(2) }}
              {{ detail.conversionUnit }}
            </p>
          </div>
        </div>
      </div>

      <div class="bottom">
        <button class="withdrawal" @click="withdrawalHandler">
          {{ $t("myAssetsDetail.btn.withdrawal") }}
        </button>
        <button class="deposit" @click="depositHandler">
          {{ $t("myAssetsDetail.btn.deposit") }}
        </button>
      </div>
    </div>
  </load-more-slot>
</template>

<script lang="ts">
import { Component, Prop, Mixins } from "vue-property-decorator";
import { namespace } from "vuex-class";
import ConfirmRoute from "@/mixins/confirmRoute";
import { logs } from "../plugins/logs";
import { Format } from "@/plugins/format";

const commonModule = namespace("common");

interface ISearchWithdraw {
  /** 可提现余额 */
  amount: number;
  /** 币种兑换参考币种汇率 */
  exchangeRate: number;
  /** 参考币种(目前是usd) */
  referenceUnit: string;
}

@Component
export default class MyAssetsDetail extends Mixins(ConfirmRoute) {
  @Prop(String) unit!: string;

  @commonModule.Mutation CHANGE_LOADING!: (bool: boolean) => void;

  private detail = {} as SearchAssetCoin;

  async getDetail() {
    const data = await this.axios
      .post("/user/searchAssetCoin", {
        unit: this.unit
      })
      .finally(() => this.CHANGE_LOADING(false));

    this.detail = data;
  }

  /**
   * 发起充值
   */
  async deposit(obj: PayParamsRequest) {
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
      () =>
        this.$router.push({
          name: "buyAssets",
          query: {
            type: "deposit",
            amount: obj.amount.toString(),
            unit: this.unit
          }
        })
    );

    this.CHANGE_LOADING(false);
  }

  /**
   * 充值操作
   */
  depositHandler() {
    this.CHANGE_CONFIRM({
      type: "deposit",
      title: this.$t("common.confirm.title.deposit", {
        currency: this.unit
      }) as string,
      data: {
        unit: this.unit
      },
      confirmBtn: this.$t("common.confirm.btn.submit") as string,
      confirmHandler: async (obj: PayParamsRequest) => this.deposit(obj)
    });
  }

  /**
   * 发起提现
   */
  async withdrawal(obj: withdrawalRequest) {
    try {
      const data = await this.axios.post("/user/withdraw", obj);

      window.Pundix.convert(
        {
          ...data
        },
        () =>
          this.$router.push({
            name: "buyAssets",
            query: {
              type: "withdraw",
              amount: Format.amount(obj.amount),
              unit: obj.unit
            }
          })
      );
    } catch (error) {
      logs(error);
    }
    this.CHANGE_LOADING(false);
  }

  /**
   * 提现操作
   */
  async withdrawalHandler() {
    // 查询提现信息
    const data = await this.axios
      .post<ISearchWithdraw>("/user/searchWithdraw", {
        unit: this.unit
      })
      .finally(() => this.CHANGE_LOADING(false));

    // 打开提现弹窗
    this.CHANGE_CONFIRM({
      type: "withdraw",
      title: this.$t("common.confirm.title.withdrawal", {
        unit: this.unit
      }) as string,
      data,
      confirmBtn: this.$t("common.confirm.btn.submit") as string,
      confirmHandler: async (amount: number) =>
        this.withdrawal({ amount, unit: this.unit })
    });
  }

  async refresh(done: Function) {
    await this.getDetail();

    done();
  }

  created() {
    this.getDetail();
  }
}
</script>

<style scoped>
.icon-available {
  width: 0.44rem;
  height: 0.44rem;
  background: url(../assets/ic_withdrawal.png) no-repeat center / cover;
}

.my-assets-detail {
  height: 100vh;
  box-sizing: border-box;
}

.my-assets-detail .container {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  text-align: center;
  min-height: calc(100vh - 0.32rem);
}

.my-assets-detail .balance {
  font-size: 0.16rem;
  color: #333333;
  margin-top: calc(0.28rem - 0.16rem);
  display: inline-block;
}

.my-assets-detail h4 {
  font-size: 0.28rem;
  color: #4a56b9;
  line-height: 0.34rem;
  margin: 0.02rem 0 0.06rem;
}

.my-assets-detail .conversion {
  font-size: 0.14rem;
  color: #333333;
  margin-top: 0.06rem;
}

.my-assets-detail .amount-box {
  background-color: #ffffff;
  box-shadow: 0 0.14rem 0.14rem -0.1rem rgba(26, 64, 129, 0.1);
  border-radius: 0.04rem;
  padding: 0.08rem 0.34rem 0.2rem;
  text-align: center;
  margin-top: 0.2rem;
}

.my-assets-detail .amount-box h5 {
  font-size: 0.16rem;
  color: #333333;
  margin: 0.08rem 0 0.16rem;
}

.my-assets-detail .amount-box .amount {
  background: rgba(223, 224, 235, 0.17) url(../assets/bg_line.svg) repeat-y
    center;
  background-size: 100% auto;
  padding: 0.08rem 0;
}

.my-assets-detail .amount-box .amount strong {
  font-size: 0.24rem;
  color: #ff8717;
  margin-bottom: 0.06rem;
}

.my-assets-detail .bottom button {
  margin-bottom: 0.12rem;
  font-weight: normal;
}

.my-assets-detail .bottom button.withdrawal {
  background-color: transparent;
  border: 1px solid #4a56b9;
  color: #4a56b9;
}
.my-assets-detail .bottom button.deposit {
  background-color: #4a56b9;
  box-shadow: 0 0.1rem 0.04rem -0.06rem rgba(26, 64, 129, 0.02);
  color: #ffffff;
}
</style>

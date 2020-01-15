<template>
  <div class="buying">
    <buy-lite v-if="isLite" :planId="planId" @submit="submit" />

    <buy-pro v-else :planId="planId" @submit="submit" />
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";
import { Getter, namespace } from "vuex-class";
import { Format } from "../plugins/format";

const BuyLite = () => import("@/components/Buying/lite/index.vue");
const BuyPro = () => import("@/components/Buying/pro/index.vue");

const commonModule = namespace("common");

@Component({
  components: {
    BuyLite,
    BuyPro
  }
})
export default class Buying extends Vue {
  @Prop(Number) planId!: number;

  @Getter isLite!: boolean;

  @commonModule.Mutation CHANGE_CONFIRM!: (obj: CommonConfirm) => void;
  @commonModule.Mutation CHANGE_LOADING!: (bool: boolean) => void;

  /**
   * 创建支付订单
   */
  async createPlanOrder(obj: {
    useBalance: boolean;
    form: IConfirmationDataForm;
  }) {
    return this.axios.post<BuyPlanResponse>(
      "/cryptoGamingPlan/createCryptoGamingPlanOrder",
      {
        payType: obj.useBalance ? 1 : 2,
        planId: this.planId,
        ...obj.form
      }
    );
  }

  setRouteReplace(name: string, query: object, info: BuyPlanResponse) {
    const queryObj = {
      planId: this.planId.toString(),
      earnUnit: info.earnUnit,
      investUnit: info.investUnit,
      exerciseStartDt: this.$moment(info.freezeEndDt).format(
        "MMM DD, HH:mm:ss"
      ),
      exerciseEndDt: this.$moment(info.exerciseEndDt).format(
        "MMM DD, HH:mm:ss"
      ),
      ...query
    };

    this.$router.replace({ name, query: queryObj });

    // 关闭loading
    this.CHANGE_LOADING(false);
  }

  /**
   * 购买投资计划
   * @param data 打开弹窗所需要的参数
   */
  async submit(obj: IConfirmationData) {
    this.CHANGE_CONFIRM({
      type: "confirmation",
      title: this.$t("common.confirm.title.confirmation") as string,
      data: {
        info: obj.info,
        form: obj.form
      } as IConfirmationData,
      confirmHandler: async (useBalance: boolean) => {
        // 关闭弹窗
        this.CHANGE_CONFIRM({ isShow: false });

        try {
          // 调用下单接口
          const data = await this.createPlanOrder({
            useBalance,
            form: obj.form
          });

          // data.pay: true ---> 支付成功
          if (data.pay) {
            // 跳转成功page
            this.setRouteReplace(
              "buySuccess",
              { amount: Format.amount(data.earnAmount) },
              data
            );
          } else {
            // xwallet支付所需要的参数
            const payData = {
              data: data.data,
              nonceStr: data.nonceStr,
              sign: data.sign,
              timestamp: data.timestamp
            };

            // 发起xwallet支付
            window.Pundix.pay(
              payData,
              () =>
                // 跳转确认中page
                this.setRouteReplace(
                  "confirming",
                  {
                    amount: Format.amount(data.earnAmount),
                    userOrderPayPlanId: data.userOrderPayPlanId.toString()
                  },
                  data
                ),

              // 支付失败，重新获取详情信息
              obj.payFail
            );
          }
        } catch (err) {
          this.CHANGE_LOADING(false);

          // 订单过期，跳转到首页
          if (err.code === 200805) {
            this.$router.replace({
              name: "home"
            });
          }
        }
      }
    });
  }
}
</script>

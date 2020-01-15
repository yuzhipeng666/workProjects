<template>
  <div class="transaction-list">
    <p class="time line">{{ info.dt | moment("MMM DD, YYYY HH:mm:ss") }}</p>
    <div class="box">
      <div class="left">
        <strong class="product">
          {{
            $t("myAssets.transactionHistory.list.productType")[info.productType]
          }}
        </strong>
      </div>
      <div class="right">
        <coin-info
          :name="info.title"
          :monthDay="info.monthDay || ''"
          :dayNumber="info.dayNumber"
        >
          <p class="summary-amount flex-align-center">
            <span class="summary"
              >{{
                $t("myAssets.transactionHistory.list.actionType")[
                  info.actionType
                ]
              }}:
            </span>
            <strong class="amount" :class="`status-${info.billType}`">
              {{ info.billType | billType }}{{ info.amount | amount }}
              {{ info.unit }}
            </strong>
          </p>
        </coin-info>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";
import CoinInfo from "@/components/Common/box/coinInfo.vue";

type historyBillType = 0 | 1;

export interface IHistoryList {
  /** 动作类型(7:用户提现; 9:用户充值; 10:加密游戏投资付款(应付); 11:加密游戏投资付款(手续费); 12:加密游戏投资收益; 13:加密游戏投资行权赎回)) , */
  actionType: number;
  /** 币种额度 , */
  amount: number;
  /** 账单类型(0:入账; 1:出账) , */
  billType: historyBillType;
  /** 某天的第几条计划 */
  dayNumber: number;
  /** 创建时间 , */
  dt: number;
  /** 结束行权时间(完成时间) , */
  exerciseEndDt: number;
  /** 行权日期 */
  monthDay: string;
  /** 产品类型, 0:Protect , */
  productType: number;
  /** 标题 , */
  title: string;
  /** 币种单位 */
  unit: string;
  /** id */
  id: number;
}

@Component({
  components: {
    CoinInfo
  },
  filters: {
    /**
     * 账单类型
     */
    billType(val: historyBillType) {
      switch (val) {
        case 0:
          return "+";
        case 1:
          return "-";
      }
    }
  }
})
export default class transactionList extends Vue {
  @Prop(Object) info!: IHistoryList;
}
</script>

<style scoped>
.transaction-list {
  padding: 0.08rem 0.14rem;
  box-sizing: border-box;
  background-color: #ffffff;
  box-shadow: 0 0.14rem 0.14rem -0.1rem rgba(26, 64, 129, 0.1);
  border-radius: 0.04rem;
  margin-bottom: 0.12rem;
}

.transaction-list .time {
  font-size: 0.1rem;
  color: #b1b1b1;
  padding-bottom: 0.08rem;
}

.transaction-list .box {
  display: flex;
  padding: 0.1rem 0;
}

.transaction-list .left {
  position: relative;
  flex: 0.35;
}

.transaction-list .left .product {
  font-size: 0.14rem;
  color: #ff8717;
  padding: 0.05rem 0.1rem;
  background-color: #fff6ee;
  border-radius: 0.04rem;
  display: inline-block;
}

.transaction-list .right {
  flex: 0.65;
}

.transaction-list .right .summary-amount {
  margin-top: 0.08rem;
}

.transaction-list .right .summary {
  font-size: 0.12rem;
  color: #b1b1b1;
  margin-right: 0.05rem;
}

.transaction-list .right .amount {
  font-size: 0.14rem;
}
.transaction-list .right .amount.status-0 {
  color: #41bd77;
}
.transaction-list .right .amount.status-1 {
  color: #df625f;
}
</style>

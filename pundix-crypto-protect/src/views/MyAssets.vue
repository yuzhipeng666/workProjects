<template>
  <load-more-slot
    class="my-assets"
    :padding="false"
    @refresh="refresh"
    @more="more"
  >
    <!-- 当前总金额 -->
    <common-total-assets
      :asset="assetsDetail.totalAsset"
      :balance="assetsDetail.totalBalance"
      :unit="assetsDetail.unit"
    />

    <div class="assets-detail main-padding">
      <h3>{{ $t("myAssets.assetsDetail.title") }}</h3>
      <div class="assets-detail-list">
        <assets-list :info="myPlan" :type="0" />

        <assets-list
          v-for="coin in coinDetailList"
          :key="coin.unit"
          :info="coin"
        />
      </div>

      <h3>{{ $t("myAssets.transactionHistory.title") }}</h3>
      <div v-if="transactionList.length" class="transaction-history">
        <transaction-list
          v-for="(history, index) in transactionList"
          :key="index"
          :info="history"
        />
      </div>

      <no-data v-else />
    </div>
  </load-more-slot>
</template>

<script lang="ts">
import { Component, Mixins } from "vue-property-decorator";
import { namespace } from "vuex-class";

import PageMixins from "@/mixins/page";

import CommonTotalAssets from "@/components/Common/totalAssets/index.vue";
import AssetsList, {
  IAssetCoinList
} from "@/components/MyAssets/assetsList.vue";
import TransactionList, {
  IHistoryList
} from "@/components/MyAssets/transactionList.vue";
import NoData from "@/components/NoData.vue";

const commonModule = namespace("common");

interface IMyAssets {
  /** 币种余额列表 */
  coinDetailList: IAssetCoinList[];
  /** 当前持仓金额 */
  gamingPlanAmount: IAssetCoinList;
  /** 总资产(余额+当前持仓金额) */
  totalAsset: number;
  /** 总余额(可用余额) */
  totalBalance: number;
  /** 币种 */
  unit: string;
}

@Component({
  components: {
    CommonTotalAssets,
    AssetsList,
    TransactionList,
    NoData
  }
})
export default class MyAssets extends Mixins(PageMixins) {
  @commonModule.Mutation CHANGE_LOADING!: (bool: boolean) => void;

  /** 资产详情 */
  private assetsDetail = {} as IMyAssets;
  /** 币种余额列表 */
  private coinDetailList = [] as IAssetCoinList[];
  /** 正在冻结的资产 */
  private gamingPlanAmount = {} as IAssetCoinList;
  /** 历史记录 */
  private transactionList = [] as IHistoryList[];

  get myPlan() {
    return {
      amount: this.gamingPlanAmount.amount,
      unit: this.gamingPlanAmount.unit
    };
  }

  /**
   * 获取用户资产
   */
  async getAssetsDetail() {
    const data = await this.axios.post<IMyAssets>("/user/searchAsset");

    this.assetsDetail = data;
    this.coinDetailList = data.coinDetailList;
    this.gamingPlanAmount = data.gamingPlanAmount;
  }

  /**
   * 获取资产历史记录
   */
  async getTransactionHistory() {
    return this.getListApi<IHistoryList>({
      api: "/user/searchAssetHistoryPage",
      idKey: "id"
    });
  }

  /**
   * 加载更多
   */
  async more(done: Function) {
    if (!this.hasNext) return done();

    const data = await this.getTransactionHistory().finally(() =>
      this.CHANGE_LOADING(false)
    );

    data.forEach(list => this.transactionList.push(list));

    done();
  }

  /**
   * 下拉刷新
   */
  async refresh(done?: Function) {
    this.page.prevId = 0;

    Promise.all([
      done && done(),
      this.getAssetsDetail(),
      (this.transactionList = await this.getTransactionHistory())
    ]).finally(() => this.CHANGE_LOADING(false));
  }

  created() {
    this.refresh();
  }
}
</script>

<style scoped>
.my-assets .assets-detail h3 {
  margin-bottom: 0.12rem;
  font-size: 0.18rem;
  color: #000000;
}

.my-assets .assets-detail .assets-detail-list {
  margin-bottom: 0.26rem;
}
</style>

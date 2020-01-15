<template>
  <load-more-slot
    class="home-pro"
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

    <div class="available main-padding">
      <div class="title flex-align-center">
        <h1>{{ $t("home.planTitle") }}</h1>
        <i class="icon icon-issue" @click="showConfirm"></i>
      </div>
      <transition-group v-if="lists.length" name="list" tag="div">
        <pro-list
          v-for="(list, index) in lists"
          :key="list.planId"
          :index="index"
          :list="list"
          @delete="deletePlan"
        />
      </transition-group>

      <no-data v-else />

      <history-btn v-model="isShowHistory" @click="showHistoryHandler" />

      <transition-group
        v-if="historyList.length"
        v-show="isShowHistory"
        name="list"
        tag="div"
      >
        <pro-list
          v-for="(list, index) in historyList"
          :key="list.planId"
          :index="index"
          :list="list"
          :disabled="true"
        />
      </transition-group>

      <no-data v-else />
    </div>
  </load-more-slot>
</template>

<script lang="ts">
import { Vue, Component, Prop, Mixins } from "vue-property-decorator";
import { namespace } from "vuex-class";
import PageMixins from "@/mixins/page";
import { config } from "@/config";

import ProList, { IPlanProList } from "./list.vue";
import HistoryBtn from "../historyBtn.vue";
import CommonTotalAssets from "@/components/Common/totalAssets/index.vue";
import NoData from "@/components/NoData.vue";

const commonModule = namespace("common");

interface IAssetsDetail {
  /** 总资产(余额+当前持仓金额) */
  totalAsset: number;
  /** 总余额(可用余额) */
  totalBalance: number;
  /** 币种 */
  unit: string;
}

@Component({
  components: {
    ProList,
    CommonTotalAssets,
    HistoryBtn,
    NoData
  }
})
export default class HomePro extends Mixins(PageMixins) {
  /** Loading func */
  @commonModule.Mutation CHANGE_LOADING!: (bool: boolean) => void;

  /** Confirm func */
  @commonModule.Mutation CHANGE_CONFIRM!: (confirm: CommonConfirm) => void;

  /** 用户资产 */
  private assetsDetail = {} as IAssetsDetail;
  /** 计划列表 */
  private lists = [] as IPlanProList[];
  /** 计划列表翻页 */
  private planListPage = {
    pageSize: config.planListPageSize,
    prevId: 0
  };

  /** 历史记录列表 */
  private historyList = [] as IPlanProList[];
  /** 历史记录显示开关 */
  private isShowHistory = true;

  /**
   * 获取Pro计划列表
   */
  async getList() {
    const data = await this.axios.post<PlanResponse<IPlanProList>>(
      "/cryptoGamingPlan/searchPlanPage",
      this.planListPage
    );

    this.lists = data.list;
  }

  /**
   * 获取用户资产
   */
  async getAssetsDetail() {
    const data = await this.axios.post<IAssetsDetail>("/user/searchTotalAsset");

    this.assetsDetail = data;
  }

  /**
   * 历史记录
   */
  async getHistoryList() {
    return this.getListApi<IPlanProList>({
      api: "/cryptoGamingPlan/searchPlanHistoryPage",
      idKey: "planId"
    });
  }

  /**
   * 首次加载的历史记录(page=0)
   */
  async initGetHistoryList() {
    if (!this.isShowHistory) return;

    this.historyList = await this.getHistoryList();
  }

  /**
   * 加载更多
   */
  async more(done: Function) {
    if (!this.hasNext || !this.isShowHistory) return done();

    const data = await this.getHistoryList().finally(() =>
      this.CHANGE_LOADING(false)
    );

    data.forEach(list => this.historyList.push(list));

    done();
  }

  /**
   * 下拉刷新
   */
  async refresh(done?: Function) {
    this.page.prevId = 0;

    Promise.all([
      this.getList(),
      this.getAssetsDetail(),
      this.initGetHistoryList()
    ]).finally(() => this.CHANGE_LOADING(false));

    done && done();
  }

  /**
   * 显示历史记录列表处理程序
   */
  showHistoryHandler() {
    this.initGetHistoryList().finally(() => this.CHANGE_LOADING(false));
  }

  /**
   * issue弹窗
   */
  showConfirm() {
    this.CHANGE_CONFIRM({
      title: this.$t("common.confirm.title.tips") as string,
      type: "issue",
      data: this.$t("home.planIssue")
    });
  }

  /**
   * 根据下标删除plan
   */
  deletePlan(index: number) {
    this.lists.splice(index, 1);
  }

  created() {
    this.refresh();
  }
}
</script>

<style scoped>
.home-pro .available .title {
  margin: 0 0 0.16rem;
}

.home-pro .available .title h1 {
  font-size: 0.18rem;
  color: #000000;
  line-height: 0.24rem;
  margin-right: 0.04rem;
}
</style>

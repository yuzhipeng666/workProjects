<template>
  <load-more-slot
    class="home-lite"
    :padding="false"
    @refresh="refresh"
    @more="more"
  >
    <div class="swiper">
      <common-swiper :lists="swiperLists" height="1.26rem" />
    </div>

    <div class="main-padding">
      <template v-if="lists.length">
        <lite-list v-for="(list, index) in lists" :key="index" :list="list">
          <router-link
            :to="{
              name: 'buying',
              params: {
                planId: list.planId
              }
            }"
            tag="button"
            class="submit list-btn"
            >{{ $t("home.planList.buyBtn") }}</router-link
          >
        </lite-list>
      </template>

      <no-data v-else />

      <history-btn v-model="isShowHistory" @click="showHistoryHandler" />

      <div
        v-if="historyLists.length"
        v-show="isShowHistory"
        class="history-list"
      >
        <lite-list
          v-for="(list, index) in historyLists"
          :key="index"
          :list="list"
          :disabled="true"
        />
      </div>

      <no-data v-else />
    </div>
  </load-more-slot>
</template>

<script lang="ts">
import { Component, Prop, Mixins } from "vue-property-decorator";
import { namespace } from "vuex-class";

import LiteList, { IPlanList } from "./list.vue";
import CommonSwiper, {
  ISwiperList
} from "@/components/Common/swiper/index.vue";
import PageMixins from "@/mixins/page";
import { config } from "@/config";
import HistoryBtn from "../historyBtn.vue";
import NoData from "@/components/NoData.vue";

const commonModule = namespace("common");

@Component({
  components: {
    LiteList,
    CommonSwiper,
    HistoryBtn,
    NoData
  }
})
export default class HomeLite extends Mixins(PageMixins) {
  @commonModule.Mutation CHANGE_LOADING!: (bool: boolean) => void;

  /** 轮播数据 */
  private swiperLists = [
    {
      link: "https://www.baidu.com",
      url: "https://cdn.pundix.com/bob-h5/images/banner_bg.png"
    },
    {
      link: "https://www.baidu.com",
      url: "https://cdn.pundix.com/bob-h5/images/banner_phone1.png"
    },
    {
      link: "https://www.baidu.com",
      url:
        "https://cdn.pundix.com/carnivallnvite/images/pic_black%20card_home@2x.png"
    },
    {
      link: "https://www.baidu.com",
      url:
        "https://cdn.pundix.com/carnivallnvite/images/pic_invite_complete_bg@2x.png"
    }
  ] as ISwiperList[];

  /** 页码 */
  private planListsPage = {
    pageSize: config.planListPageSize,
    prevId: 0
  };

  /** 可购买的计划列表 */
  private lists = [] as IPlanList[];
  /** 历史列表 */
  private historyLists = [] as IPlanList[];
  /** 是否显示历史列表 */
  private isShowHistory = true;

  /**
   * 获取历史列表
   */
  async getHistoryList() {
    return this.getListApi<IPlanList>({
      api: "/cryptoGamingPlan/searchSimplifyPlanHistoryPage",
      idKey: "planId"
    });
  }

  /**
   * 获取可购买的计划列表
   */
  async getList() {
    const data = await this.axios.post<ICommonListApiResponse<IPlanList>>(
      "/cryptoGamingPlan/searchSimplifyPlanPage",
      this.planListsPage
    );

    this.lists = data.list;
  }

  /**
   * 提供给页面加载完的首次获取历史记录数据
   */
  async initGetHistoryList() {
    if (!this.isShowHistory) return;

    this.historyLists = await this.getHistoryList();
  }

  /**
   * 加载更多
   */
  async more(done: Function) {
    if (!this.hasNext || !this.isShowHistory) return done();

    const data = await this.getHistoryList().finally(() =>
      this.CHANGE_LOADING(false)
    );

    data.forEach(list => this.historyLists.push(list));

    done();
  }

  /**
   * 下拉刷新
   */
  refresh(done?: Function) {
    // 重置页码
    this.page.prevId = 0;

    Promise.all([this.getList(), this.initGetHistoryList()]).finally(() =>
      this.CHANGE_LOADING(false)
    );

    done && done();
  }

  /**
   * 显示历史记录列表处理程序
   */
  showHistoryHandler() {
    this.initGetHistoryList().finally(() => this.CHANGE_LOADING(false));
  }

  created() {
    this.refresh();
  }
}
</script>

<style scoped>
.home-lite {
  padding-top: 0.36rem;
}

/* .home-lite .swiper {
  height: 1.26rem;
} */

.home-lite .list-btn {
  width: 0.7rem;
  height: 0.28rem;
  border-radius: 0.04rem;
  position: absolute;
  right: 0;
  bottom: 0;
}
</style>

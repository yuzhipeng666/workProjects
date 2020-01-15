<template>
  <load-more-slot class="my-plans-lite" @refresh="refresh" @more="more">
    <div v-if="lists.length" class="main">
      <my-plans-lite-list
        v-for="(list, index) in lists"
        :key="index"
        :list="list"
      />
    </div>

    <no-data v-else />
  </load-more-slot>
</template>

<script lang="ts">
import { Component, Mixins } from "vue-property-decorator";
import { namespace } from "vuex-class";
import MyPlansLiteList, { IList } from "./list.vue";
import PageMixins from "@/mixins/page";
import NoData from "@/components/NoData.vue";

const commonModule = namespace("common");

@Component({
  components: {
    MyPlansLiteList,
    NoData
  }
})
export default class MyPlansLite extends Mixins(PageMixins) {
  @commonModule.Mutation CHANGE_LOADING!: (bool: boolean) => void;

  /** 数据列表 */
  private lists = [] as IList[];

  /**
   * 获取列表数据
   */
  async getList() {
    return this.getListApi<IList>({
      api: "/cryptoGamingPlan/searchSimplifyUserPlanPage",
      idKey: "userPlanId"
    }).finally(() => this.CHANGE_LOADING(false));
  }

  /**
   * 加载更多
   */
  async more(done: Function) {
    if (!this.hasNext) return done();

    const data = await this.getList();

    data.forEach(list => this.lists.push(list));

    done();
  }

  /**
   * 下拉刷新
   */
  async refresh(done?: Function) {
    this.page.prevId = 0;

    done && done();

    this.lists = await this.getList();
  }

  created() {
    this.refresh();
  }
}
</script>

<style scoped>
.my-plans-lite .main {
  margin-top: 0.3rem;
}
</style>

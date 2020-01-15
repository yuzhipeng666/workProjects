<template>
  <div class="my-plans">
    <!-- Header -->
    <div class="header-menus flex-center">
      <div class="menus-btn">
        <label v-for="menu in menuLists" :key="menu.value">
          <input type="radio" :value="menu.value" v-model="status" hidden />
          <span>{{ menu.label }}</span>
        </label>
      </div>
    </div>

    <load-more-slot @refresh="refresh" @more="more">
      <transition-group v-if="planLists.length" name="list" tag="div">
        <plan-lists
          v-for="(list, index) in planLists"
          :key="list.userPlanId"
          :info="list"
          :index="index"
          @delete="deletePlan"
        />
      </transition-group>

      <no-data v-else />
    </load-more-slot>
  </div>
</template>

<script lang="ts">
import { Component, Mixins } from "vue-property-decorator";
import { namespace } from "vuex-class";

import PlanLists, { IMyPlanProList } from "./list.vue";
import NoData from "@/components/NoData.vue";
import PageMixins from "@/mixins/page";

const commonModule = namespace("common");

@Component({
  components: {
    PlanLists,
    NoData
  }
})
export default class MyPlans extends Mixins(PageMixins) {
  @commonModule.Mutation CHANGE_LOADING!: (bool: boolean) => void;

  get status() {
    return (this.$route.query.status as string) || "0";
  }

  set status(val: string) {
    // 改变路由
    this.$router.replace({ name: "plans", query: { status: val } });

    // 获取数据
    this.refresh();
  }

  get menuLists() {
    return [
      { value: "0", label: this.$t("myPlans.menusList.progress") },
      { value: "1", label: this.$t("myPlans.menusList.finished") }
    ];
  }

  private planLists = [] as IMyPlanProList[];

  /**
   * 加载更多
   */
  async more(done: Function) {
    if (!this.hasNext) return done();

    const data = await this.getPlanList().finally(() =>
      this.CHANGE_LOADING(false)
    );

    data.forEach(list => this.planLists.push(list));

    done();
  }

  /**
   * 刷新列表
   */
  async refresh(done?: Function) {
    this.page.prevId = 0;

    done && done();

    this.planLists = await this.getPlanList().finally(() =>
      this.CHANGE_LOADING(false)
    );
  }

  /**
   * 获取已购买的计划列表
   */
  async getPlanList() {
    return this.getListApi<IMyPlanProList>({
      api: "/cryptoGamingPlan/searchUserPlanPage",
      params: {
        status: this.status
      },
      idKey: "userPlanId"
    });
  }

  deletePlan(index: number) {
    this.planLists.splice(index, 1);
  }

  created() {
    this.refresh();
  }
}
</script>

<style scoped>
.my-plans .header-menus {
  padding: 0.08rem;
  background-color: #ffffff;
  position: relative;
  z-index: 10;
}

.my-plans .header-menus .menus-btn {
  background-color: #f5f7fc;
  border-radius: 0.04rem;
  margin: 0 auto;
}

.my-plans .header-menus .menus-btn label {
  display: inline-block;
}

.my-plans .header-menus .menus-btn label span {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  height: 0.28rem;
  width: 1rem;
  margin: 0.02rem;
  font-size: 0.12rem;
  color: #333333;
  opacity: 0.31;
}

.my-plans .header-menus .menus-btn label input:checked + span {
  background-color: #ffffff;
  box-shadow: 0 0.05rem 0.06rem -0.05rem #d1d8e8;
  border-radius: 0.02rem;
  opacity: 1;
}
</style>

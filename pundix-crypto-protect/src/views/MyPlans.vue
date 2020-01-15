<template>
  <div class="my-plans">
    <version-switch-btn />

    <!-- Lite -->
    <my-plans-lite v-if="isLite" />

    <!-- Pro -->
    <my-plans-pro v-else />

    <issue-btn v-show="isLite" />
  </div>
</template>

<script lang="ts">
import { Mixins, Component } from "vue-property-decorator";
import { Getter } from "vuex-class";

import ConfirmRoute from "@/mixins/confirmRoute";
import VersionSwitchBtn from "@/components/VersionSwitchBtn.vue";

const MyPlansLite = () => import("@/components/MyPlans/lite/index.vue");
const MyPlansPro = () => import("@/components/MyPlans/pro/index.vue");
const IssueBtn = () => import("@/components/MyPlans/lite/issueBtn.vue");

@Component({
  components: {
    VersionSwitchBtn,
    MyPlansLite,
    MyPlansPro,
    IssueBtn
  }
})
export default class Home extends Mixins(ConfirmRoute) {
  @Getter isLite!: boolean;
}
</script>

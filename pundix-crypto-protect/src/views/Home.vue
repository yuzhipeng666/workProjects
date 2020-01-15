<template>
  <div class="home">
    <version-switch-btn />

    <!-- Lite -->
    <home-lite v-if="isLite" />

    <!-- Pro -->
    <home-pro v-else />
  </div>
</template>

<script lang="ts">
import { Mixins, Component } from "vue-property-decorator";
import { Getter } from "vuex-class";

import ConfirmRoute from "@/mixins/confirmRoute";
import VersionSwitchBtn from "@/components/VersionSwitchBtn.vue";

const HomeLite = () => import("@/components/Home/lite/index.vue");
const HomePro = () => import("@/components/Home/pro/index.vue");

@Component({
  components: {
    VersionSwitchBtn,
    HomeLite,
    HomePro
  }
})
export default class Home extends Mixins(ConfirmRoute) {
  @Getter isLite!: boolean;
}
</script>

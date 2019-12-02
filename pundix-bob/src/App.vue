<template>
  <div id="app">
    <router-view />

    <s-loading v-show="loading" />

    <transition name="slide-up-down">
      <s-notice v-show="notice.isShow" />
    </transition>

    <pay-confirm v-show="payConfirm.isShow" />
  </div>
</template>

<script>
import sNotice from "@/components/sNotice.vue";
import sLoading from "@/components/sLoading.vue";
import payConfirm from "@/components/App/payConfirm.vue";
import { mapGetters } from "vuex";

export default {
  components: {
    sNotice,
    sLoading,
    payConfirm
  },

  computed: mapGetters(["notice", "payConfirm", "loading"])
};
</script>

<style scoped>
#app {
  height: 100vh;
}

.slide-up-down-enter-active,
.slide-up-down-leave-active {
  transition: all 0.5s;
}

.slide-up-down-enter,
.slide-up-down-leave-to {
  transform: translate(-50%, -100%);
  opacity: 0;
}
</style>

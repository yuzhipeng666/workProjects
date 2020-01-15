<template>
  <div id="app" @touchmove="touchmoveHandler">
    <div
      :style="{
        paddingBottom: isShowMenus ? '.5rem' : '0'
      }"
    >
      <router-view />
    </div>

    <menus v-show="isShowMenus" />

    <confirm v-show="confirm.isShow" />

    <transition name="toggles">
      <loading v-show="loading" />
    </transition>

    <transition name="slide-toast">
      <toast v-show="toast.isShow" :msg="toast.msg" />
    </transition>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Ref } from "vue-property-decorator";
import Menus from "@/components/Menus.vue";
import Confirm from "@/components/Common/confirm/index.vue";
import Loading from "@/components/Common/loading/index.vue";
import Toast from "@/components/Common/toast/index.vue";
import { namespace, Mutation, State } from "vuex-class";

const commonModule = namespace("common");

@Component({
  components: {
    Menus,
    Confirm,
    Loading,
    Toast
  }
})
export default class App extends Vue {
  @commonModule.Getter loading!: boolean;
  @commonModule.Getter toast!: CommonToast;
  @commonModule.Getter confirm!: CommonConfirm;

  get isShowMenus() {
    return Object.keys(this.$t("nav")).includes(this.$route.name as string);
  }

  get overflowHidden() {
    return this.loading || this.confirm.isShow;
  }

  touchmoveHandler(evt: TouchEvent) {
    // loading为打开状态时，禁止页面滚动
    this.loading && evt.preventDefault();
  }
}
</script>

<style>
#app {
  position: relative;
}

#app.overflow-hidden {
  height: 100vh;
  overflow: hidden;
}

#app .success-color {
  color: #41bd77;
}

.line,
.border {
  position: relative;
}

.line::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  width: 200%;
  height: 0.01rem;
  background-color: #f1f1f1;
  transform: scale(0.5);
  transform-origin: 0 0;
  box-sizing: border-box;
}

.border::after {
  content: "";
  position: absolute;
  left: 0;
  top: 0;
  width: 200%;
  height: 200%;
  border-width: 1px;
  border-style: solid;
  transform: scale(0.5);
  transform-origin: 0 0;
  box-sizing: border-box;
}

/* 动画 */
@keyframes opacityAnimate {
  from {
    opacity: 1;
  }
  to {
    opacity: 0.5;
  }
}

@keyframes rotateAnimate {
  from {
    transform: translateX(-50%) rotate(0deg);
  }
  to {
    transform: translateX(-50%) rotate(360deg);
  }
}

.slide-enter-active,
.slide-leave-active,
.toggles-enter-active,
.toggles-leave-active,
.slide-toast-enter-active,
.slide-toast-leave-active,
.list-enter-active,
.list-leave-active {
  transition: all 0.3s ease;
}

.toggles-enter,
.toggles-leave-to,
.list-enter,
.list-leave-to {
  opacity: 0;
}

.slide-enter,
.slide-leave-to {
  transform: translateY(100%);
}

.slide-toast-enter,
.slide-toast-leave-to {
  transform: translate(-50%, -100%);
  opacity: 0;
}
</style>

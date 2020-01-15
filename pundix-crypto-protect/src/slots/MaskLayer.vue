<template>
  <transition name="toggles">
    <div class="mask-layer" v-show="isShow">
      <div class="bg" @click="closeMask"></div>

      <slot />
    </div>
  </transition>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";

@Component
export default class ConfirmSlot extends Vue {
  @Prop({ default: false }) isShow!: boolean;
  @Prop({ default: true }) close!: boolean;

  /**
   * 关闭弹窗
   */
  closeMask() {
    this.close && this.$emit("close");
  }
}
</script>

<style scoped>
.mask-layer {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 100;
  display: flex;
  align-items: flex-end;
}

.mask-layer .bg {
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.6);
}

/* 动画 */
.toggles-enter-active,
.toggles-leave-active {
  transition: opacity 0.3s ease;
}

.toggles-enter,
.toggles-leave-to {
  opacity: 0;
}
</style>

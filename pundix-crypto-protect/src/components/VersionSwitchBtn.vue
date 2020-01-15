<template>
  <div class="version-switch-btn flex-center" @click="changeVersion">
    <span>{{ btnText }}</span>
    <i class="icon icon-change"></i>
  </div>
</template>

<script lang="ts">
import { Vue, Component } from "vue-property-decorator";
import { Getter, Mutation } from "vuex-class";

@Component
export default class VersionSwitchBtn extends Vue {
  @Getter isLite!: boolean;

  @Mutation CHANGE_IS_LITE!: Function;

  get btnText() {
    return !this.isLite
      ? this.$t("versionBtn.lite")
      : this.$t("versionBtn.pro");
  }

  changeVersion() {
    this.CHANGE_IS_LITE();

    this.$emit("version", this.isLite);
  }
}
</script>

<style scoped>
.version-switch-btn {
  width: 0.58rem;
  height: 0.26rem;
  background: #ffffff;
  box-shadow: 0 0.02rem 0.04rem 0 rgba(0, 0, 0, 0.04);
  border-radius: 1rem 0 0 1rem;
  position: fixed;
  top: 0.04rem;
  right: 0;
  z-index: 50;
}

.version-switch-btn span {
  font-size: 0.12rem;
  color: #333333;
  margin-right: 0.08rem;
}
</style>

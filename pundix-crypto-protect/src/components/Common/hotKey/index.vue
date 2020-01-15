<template>
  <span class="common-hot-key" :class="{ active }" @click="hotKeyHandler">{{
    info.label
  }}</span>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";

export interface CommonHotKeyInfo {
  value: number;
  label: number | string;
}

@Component
export default class CommonHotKey extends Vue {
  @Prop(Object) info!: CommonHotKeyInfo;
  @Prop(Number) value!: number;

  get active() {
    return this.value === this.info.value;
  }

  hotKeyHandler() {
    this.$emit("input", this.info.value);
  }
}
</script>

<style scoped>
.common-hot-key {
  display: inline-block;
  text-align: center;
}
</style>

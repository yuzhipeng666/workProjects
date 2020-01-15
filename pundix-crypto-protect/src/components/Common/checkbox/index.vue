<template>
  <label class="common-checkbox flex-align-center">
    <div class="checkbox">
      <input type="checkbox" hidden v-model="_value" />
      <i class="icon" :class="checkboxClass"></i>
    </div>
    <slot />
  </label>
</template>

<script lang="ts">
import { Vue, Component, PropSync, Prop } from "vue-property-decorator";

@Component
export default class CommonCheckbox extends Vue {
  @Prop(Boolean) value!: boolean;

  get _value() {
    return this.value;
  }

  set _value(val) {
    this.$emit("input", val);
  }

  get checkboxClass() {
    return this._value ? "icon-checkbox-sel" : "icon-checkbox-nor";
  }
}
</script>

<style scoped>
.common-checkbox .checkbox {
  display: inline-flex;
}
</style>

<template>
  <div class="label-list flex-align-center">
    <div
      class="label flex-align-center"
      :class="{ strong: labelStrong }"
      :style="{ fontSize: labelSize, color: labelColor }"
    >
      {{ label }}
      <slot name="label" />
    </div>

    <span
      class="value"
      :class="{
        'success-color': success,
        'error-color': error,
        strong: valueStrong
      }"
      :style="{ fontSize: valueSize }"
    >
      <slot />
    </span>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";

@Component
export default class LabelList extends Vue {
  @Prop(String) label!: string;
  /** 是否需要绿色高亮value值 */
  @Prop({ default: false }) success!: boolean;
  /** 是否需要红色高亮value值 */
  @Prop({ default: false }) error!: boolean;
  /** label是否加粗 */
  @Prop({ default: false }) labelStrong!: boolean;
  /** value是否加粗 */
  @Prop({ default: true }) valueStrong!: boolean;
  /** label font size */
  @Prop({ default: "0.13rem" }) labelSize!: string;
  /** value font size */
  @Prop({ default: "0.14rem" }) valueSize!: string;
  /** label font color */
  @Prop({ default: "#7e7e7e" }) labelColor!: string;
}
</script>

<style scoped>
.label-list {
  justify-content: space-between;
}

.label-list + .label-list {
  padding-top: 0.12rem;
}

.label-list .label {
  font-size: 0.13rem;
}

.label-list .value {
  font-size: 0.14rem;
  color: #333333;
}

.label-list .strong {
  font-weight: 900;
}

.label-list .error-color {
  color: #df625f;
}
</style>

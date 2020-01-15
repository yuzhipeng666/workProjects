<template>
  <div class="box-slot">
    <h3 v-if="title" class="box-title">{{ title }}</h3>
    <div class="box-block">
      <div :class="{ line, 'box-header-padding': line }">
        <slot name="header" />
      </div>
      <div class="box-main">
        <slot />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";

@Component
export default class BoxSlot extends Vue {
  /** 标题 */
  @Prop(String) title!: string;
  /** block内header的下划线 */
  @Prop({ default: true }) line!: boolean;
}
</script>

<style scoped>
/* Title */
.box-slot .box-title {
  font-size: 0.18rem;
  line-height: 0.18rem;
  color: #000000;
  margin-bottom: 0.1rem;
}

/* Block */
.box-slot .box-block {
  background-color: #ffffff;
  box-shadow: 0 0.15rem 0.14rem -0.1rem rgba(26, 64, 129, 0.1);
  border-radius: 0.08rem;
  padding: 0.16rem 0.14rem;
}

.box-slot .box-block .box-header-padding {
  padding: 0 0.02rem 0.1rem;
}

.box-slot .box-block .box-main {
  position: relative;
}
</style>

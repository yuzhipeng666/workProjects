<template>
  <div class="current-price">
    <i18n path="common.confirm.currentPrice.tips" tag="p" class="tips">
      <template #time>{{ data.systemDt | moment("HH:mm:ss") }}</template>
    </i18n>
    <p class="url-tips">{{ $t("common.confirm.currentPrice.urlTips") }}</p>

    <p class="link" @click="openLink">{{ cmcLink }}</p>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";
import { config } from "@/config";

@Component
export default class ConfirmCurrentPrice extends Vue {
  @Prop(Object) data!: {
    systemDt: number;
  };

  get cmcLink() {
    return config.cmcLink;
  }

  openLink() {
    window.PX.newPage({ link: config.cmcLink as string });
  }
}
</script>

<style scoped>
.current-price p {
  font-size: 0.14rem;
  padding: 0.1rem 0;
}

.current-price .link {
  text-decoration: underline;
  font-size: 0.16rem;
}
</style>

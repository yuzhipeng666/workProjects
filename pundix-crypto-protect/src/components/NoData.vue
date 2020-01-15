<template>
  <box-slot class="no-data" :line="false">
    <div class="main flex-center">
      <div class="logo">
        <img src="@/assets/icon/icon_Empty@svg.svg" alt="" />
      </div>
      <strong class="title">{{ $t("noData.title") }}</strong>
      <p class="ps">{{ $t("noData.ps") }}</p>
    </div>
  </box-slot>
</template>

<script lang="ts">
import { Vue, Component } from "vue-property-decorator";

@Component
export default class NoData extends Vue {}
</script>

<style scoped>
.no-data .main {
  height: 2.18rem;
  flex-direction: column;
}

.no-data .main .logo {
  width: 1.58rem;
  height: 1.1rem;
}

.no-data .main .title {
  font-size: 0.14rem;
  color: #333333;
  margin: 0.14rem 0 0.04rem;
}

.no-data .main .ps {
  font-size: 0.12rem;
  color: rgba(51, 51, 51, 0.32);
}
</style>

<template>
  <nav class="menus">
    <router-link
      v-for="[key, value] in menuList"
      :key="key"
      :to="{ name: key }"
      :class="{ active: activeRouteName === key }"
    >
      <i
        class="icon"
        :class="activeRouteName === key ? `icon-${key}-sel` : `icon-${key}-nor`"
      ></i>
      <span>{{ value }}</span>
    </router-link>
  </nav>
</template>

<script lang="ts">
import { Vue, Component } from "vue-property-decorator";

@Component
export default class Menus extends Vue {
  get activeRouteName() {
    return this.$route.name as string;
  }

  get menuList() {
    return Object.entries(this.$t("nav"));
  }
}
</script>

<style scoped>
.menus {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  height: 0.5rem;
  background-color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: space-between;
  z-index: 50;
}

.menus a {
  flex: 1;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.menus .icon {
  width: 0.2rem;
  height: 0.2rem;
}

.menus a span {
  font-size: 10px;
  color: #9da1bc;
  line-height: 0.14rem;
  margin-top: 0.04rem;
}

.menus .active span {
  color: #4a56b9;
  font-weight: 700;
}
</style>

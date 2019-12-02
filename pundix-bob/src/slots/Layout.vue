<template>
  <div class="layout-slot">
    <div class="main">
      <slot />
    </div>

    <div class="bottom">
      <slot name="bottom"></slot>
    </div>
  </div>
</template>

<style scoped>
.layout-slot {
  position: relative;
  min-height: 100%;
}

.layout-slot .main {
  overflow: auto;
  padding-bottom: 0.5rem;
}

.layout-slot .bottom {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 0.5rem;
  background: #ffffff;
  box-shadow: 0 11px 19px 0 rgba(0, 0, 0, 0.5);
  z-index: 100;
}
</style>

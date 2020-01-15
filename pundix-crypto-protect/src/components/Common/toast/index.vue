<template>
  <div class="toast flex-center">
    <i class="icon icon-toast-warning"></i>
    <span>{{ msg }}</span>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";
import { namespace } from "vuex-class";

const commonModule = namespace("common");

@Component
export default class Toast extends Vue {
  @Prop([String, Error]) msg!: string | Error;
}
</script>

<style scoped>
.icon-toast-warning {
  width: 0.1rem;
  height: 0.1rem;
  background: url(../../../assets/ic_toast_warning.svg) no-repeat center / cover;
}

.toast {
  position: fixed;
  top: 0.1rem;
  left: 50%;
  transform: translate(-50%, 0);
  padding: 0.1rem 0.32rem;
  background-color: #ff6e6e;
  box-shadow: 0 0.1rem 0.16rem -0.06rem rgba(254, 120, 120, 0.35);
  border-radius: 0.26rem;
  box-sizing: border-box;
  z-index: 100;
}

.toast span {
  font-size: 0.13rem;
  color: #ffffff;
  line-height: 0.18rem;
  white-space: nowrap;
  margin-left: 0.06rem;
}
</style>

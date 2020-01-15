<template>
  <div class="success-slot main-padding">
    <div class="box">
      <i class="icon" :class="`icon-${type}`"></i>
      <h1 :class="type"><slot name="title" /></h1>
      <div class="main">
        <slot name="amount" />
      </div>
    </div>

    <div class="other">
      <slot name="other" />
    </div>
  </div>
</template>
<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";

@Component
export default class SuccessSlot extends Vue {
  @Prop({
    default: "success",
    validator: val => ["success", "warning", "fail"].includes(val)
  })
  type!: "success" | "warning" | "fail";
}
</script>

<style scoped>
.icon-success {
  background: url(../assets/ic_gou.svg) no-repeat center / cover;
}

.icon-warning {
  background: url(../assets/ic_warning.svg) no-repeat center / cover;
}

.icon-fail {
  background: url(../assets/ic_fail.svg) no-repeat center / cover;
}

.success-slot {
  padding-top: 0.8rem;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  box-sizing: border-box;
}
.success-slot .box {
  position: relative;
  background-color: #ffffff;
  border-radius: 0.08rem;
  padding: 0.26rem 0.34rem;
  box-shadow: 0 0.14rem 0.14rem -0.1rem rgba(26, 64, 129, 0.1);
}

.success-slot .box .icon {
  width: 0.68rem;
  height: 0.68rem;
}

.success-slot .box .icon {
  position: absolute;
  top: 0;
  left: 50%;
  transform: translate(-50%, -50%);
}

.success-slot .box h1 {
  width: 2.7rem;
  line-height: 0.28rem;
  font-size: 0.26rem;
  text-align: center;
  margin: 0.4rem auto 0.28rem;
}

.success-slot .box h1.success {
  color: #41bd77;
}
.success-slot .box h1.warning {
  color: #ff8f18;
}
.success-slot .box h1.fail {
  color: #ff6e6e;
}

.success-slot .box .main {
  text-align: center;
}
</style>

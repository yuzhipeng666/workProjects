<template>
  <div class="s-checkbox">
    <input type="checkbox" v-model="_value" hidden />
    <i class="icon-box"></i>
  </div>
</template>

<script>
export default {
  props: {
    value: Boolean
  },

  computed: {
    _value: {
      get() {
        return this.value;
      },
      set(val) {
        this.$emit("input", val);
      }
    }
  }
};
</script>

<style scoped>
.s-checkbox .icon-box {
  width: 0.14rem;
  height: 0.14rem;
  display: inline-block;
  background: url("../assets/ic_box_nor.png") no-repeat center / cover;
}

.s-checkbox input[type="checkbox"]:checked + .icon-box {
  background: url("../assets/ic_box_sel.png") no-repeat center / cover;
}
</style>

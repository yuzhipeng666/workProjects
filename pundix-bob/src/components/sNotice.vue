<template>
  <div class="s-notice" :class="notice.type">{{ notice.msg }}</div>
</template>

<script>
import { mapGetters, mapMutations } from "vuex";
export default {
  data: () => ({
    timer: null
  }),

  computed: mapGetters(["notice"]),

  methods: {
    ...mapMutations(["SET_NOTICE"]),

    setTimeClose() {
      this.timer = setTimeout(() => {
        this.SET_NOTICE({ isShow: false });
      }, 1500);
    }
  },

  watch: {
    notice: {
      deep: true,
      handler(val) {
        clearTimeout(this.timer);

        val.isShow && this.setTimeClose();
      }
    }
  }
};
</script>

<style scoped>
.s-notice {
  position: fixed;
  top: 0.2rem;
  left: 50%;
  transform: translateX(-50%);
  z-index: 1000;
  color: #ffffff;
  border-radius: 0.18rem;
  padding: 0.08rem 0.2rem;
  box-sizing: border-box;
  font-size: 0.12rem;
  line-height: 0.18rem;
  white-space: nowrap;
}

.s-notice.error {
  background-color: #ff6868;
  box-shadow: 0 10px 21px -10px rgba(255, 113, 113, 0.66);
}
</style>

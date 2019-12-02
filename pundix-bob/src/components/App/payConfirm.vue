<template>
  <cover-slots class="pay-confirm">
    <div class="confirm">
      <h3 class="title">{{ $t("success.confirm.title") }}</h3>
      <p class="desc">{{ $t("success.confirm.desc") }}</p>
      <button class="submit" @click="SET_PAY_CONFIRM(false)">
        {{ $t("success.confirm.btn") }}
      </button>
    </div>
  </cover-slots>
</template>

<script>
import coverSlots from "@/slots/Cover.vue";
import { mapMutations } from "vuex";
export default {
  components: {
    coverSlots
  },

  methods: mapMutations(["SET_PAY_CONFIRM"])
};
</script>

<style scoped>
.pay-confirm .confirm {
  background-color: #ffffff;
  width: 3.1rem;
  text-align: center;
  padding: 0.14rem;
  box-sizing: border-box;
  border-radius: 0.08rem;
}

.pay-confirm .confirm .title {
  font-size: 0.24rem;
  color: #000000;
  line-height: 0.32rem;
}

.pay-confirm .confirm .desc {
  font-size: 0.14rem;
  line-height: 0.18rem;
  color: #666666;
  margin: 0.08rem 0 0.2rem;
}

.pay-confirm .confirm .submit {
  height: 0.44rem;
  border-radius: 0.06rem;
}
</style>

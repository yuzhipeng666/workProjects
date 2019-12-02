<template>
  <layout-slot>
    <div class="order-confirm">
      <div class="bob-info-amount">
        <!-- Info -->
        <bob-info :info="info" :value="form.num" :quantityBtn="false" />

        <!-- Amount -->
        <bob-amount :info="info" />
      </div>

      <div class="order-info">
        <p class="title">{{ $t("order.info.title.orderInfo") }}</p>
        <p class="info">{{ form.fullName }}</p>
        <p class="info">{{ form.phoneNumber }}</p>
        <p class="info">{{ form.email }}</p>
      </div>

      <div class="ps">
        <p>{{ $t("orderConfirm.ps") }}</p>
      </div>
    </div>

    <template #bottom>
      <button class="submit" @click="pay">
        {{ $t("orderConfirm.button.pay") }}
      </button>
    </template>
  </layout-slot>
</template>

<script>
import { mapState, mapMutations } from "vuex";

import layoutSlot from "@/slots/Layout.vue";
import bobAmount from "@/components/Order/bobAmount.vue";
import bobInfo from "@/components/Order/bobInfo.vue";

import { pundix } from "@/plugins/px";

export default {
  components: {
    layoutSlot,
    bobAmount,
    bobInfo
  },

  computed: {
    ...mapState(["userNum"]),
    ...mapState({
      info: ({ orderInfo }) => orderInfo,
      form: ({ orderForm }) => orderForm
    })
  },

  methods: {
    ...mapMutations(["SET_NOTICE", "SET_PAY_CONFIRM", "SET_LOADING"]),
    /**
     * 支付
     */
    async pay() {
      this.SET_LOADING(true);

      // 下单
      try {
        const data = await this.axios.post("/api/v1/order", {
          userNum: this.userNum,
          ...this.form
        });

        await pundix.pay(data.payParams);

        this.SET_LOADING(false);

        this.SET_PAY_CONFIRM(true);

        this.$router.replace("/");
      } catch (msg) {
        this.SET_LOADING(false);

        this.SET_NOTICE({ msg, type: "error" });
      }
    }
  }
};
</script>

<style scoped>
.order-confirm > * {
  padding-left: 0.18rem;
  padding-right: 0.18rem;
}

.order-confirm > *:not(:last-child) {
  border-bottom: 0.06rem solid #fafbfc;
}

.order-confirm .bob-info-amount {
  padding-top: 0.15rem;
}

.order-confirm .bob-info-amount .bob-info {
  background-color: #f4f6f8;
  border-radius: 0.03rem;
  padding: 0.2rem 0.2rem 0.2rem 0.06rem;
}

.order-confirm .bob-info-amount .bob-amount {
  padding-top: 0.18rem;
  padding-bottom: 0.55rem;
}

/* Order Info */
.order-confirm .order-info {
  padding-top: 0.2rem;
  padding-bottom: 0.25rem;
}

.order-confirm .order-info p {
  font-size: 0.12rem;
  color: #666666;
  line-height: 0.18rem;
}

.order-confirm .order-info p:not(:last-child) {
  margin-bottom: 0.08rem;
}

.order-confirm .order-info p.title {
  font-size: 0.14rem;
  color: #333333;
  line-height: 0.2rem;
  margin-bottom: 0.16rem;
}

/* Ps */
.order-confirm .ps {
  padding-top: 0.14rem;
  padding-bottom: 0.14rem;
}

.order-confirm .ps p {
  font-size: 0.12rem;
  line-height: 0.17rem;
  color: #999999;
}
</style>

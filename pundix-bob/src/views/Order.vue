<template>
  <layout-slot>
    <div class="order">
      <!-- Bob info and amount -->
      <div class="bob-info-amount">
        <!-- Info -->
        <bob-info :info="info" :value="form.num" />

        <!-- Amount -->
        <bob-amount :info="info" />
      </div>

      <!-- Form -->
      <form id="form" @submit.prevent="submit">
        <p class="order-info">{{ $t("order.info.title.orderInfo") }}</p>
        <s-input
          v-for="item in formItem"
          :key="item.key"
          :value="form[item.key]"
          :placeholder="$t('order.form.placeholder')[item.key]"
          :label="$t('order.form.label')[item.key]"
          :type="item.type"
          :required="item.required"
          :invalidMsg="item.invalidMsg"
          @input="inputVuex($event, item.key)"
        />

        <!-- 条款 -->
        <label class="terms">
          <s-checkbox v-model="terms" />
          <p>{{ $t("order.form.terms") }}</p>
        </label>
      </form>
    </div>

    <div slot="bottom" class="order-bottom">
      <p>
        {{ (info.discountAmount * form.num) | floatNum }} {{ info.priceUnit }}
      </p>
      <button
        form="form"
        type="submit"
        class="submit"
        :disabled="!(terms && info.stock > 0)"
      >
        {{ submitBtn }}
      </button>
    </div>
  </layout-slot>
</template>

<script>
import layoutSlot from "@/slots/Layout.vue";
import sInput from "@/components/sInput.vue";
import sCheckbox from "@/components/sCheckbox.vue";
import bobAmount from "@/components/Order/bobAmount.vue";
import bobInfo from "@/components/Order/bobInfo.vue";
import { mapMutations, mapGetters } from "vuex";

export default {
  components: {
    sInput,
    sCheckbox,
    layoutSlot,
    bobAmount,
    bobInfo
  },
  data: () => ({
    // 条款
    terms: false
  }),

  computed: {
    ...mapGetters({
      form: "orderForm",
      info: "orderInfo"
    }),

    formItem() {
      // 表单列表
      return [
        { key: "fullName", type: "text" },
        {
          key: "email",
          type: "email",
          invalidMsg: {
            typeMismatch: this.$t("error.10003")
          }
        },
        {
          key: "confirmEmail",
          type: "email",
          invalidMsg: {
            typeMismatch: this.$t("error.10003")
          }
        },
        { key: "phoneNumber", type: "tel" }
      ];
    },

    submitBtn() {
      return this.info.stock > 0
        ? this.$t("order.form.button.submit")
        : this.$t("order.form.button.outOfStock");
    }
  },

  filters: {
    // 解决浮点数问题
    floatNum(val) {
      const numStr = val.toString().split(".");

      numStr[0] = numStr[0].replace(/(\d)(?=(?:\d{3})+$)/g, "$1,");

      if (numStr[1] && numStr[1].length > 2) {
        numStr[1] = numStr[1].slice(0, 2).replace(/([0])$/, "");
      }

      return numStr.join(".");
    }
  },

  methods: {
    ...mapMutations(["SAVE_MODEL", "SET_NOTICE"]),

    // 写入vuex
    inputVuex(value, key) {
      this.SAVE_MODEL({
        key,
        value
      });
    },

    // 提交
    submit() {
      if (this.form.email !== this.form.confirmEmail)
        return this.SET_NOTICE({ msg: this.$t("error.10001"), type: "error" });

      // 跳转付款
      this.$router.push("/order-confirm");
    }
  }
};
</script>

<style scoped>
.order > * {
  padding-left: 0.18rem;
  padding-right: 0.18rem;
}

/* Bob info and amount */
.order .bob-info-amount {
  border-bottom: 0.06rem solid #fafbfc;
}

.order .bob-info-amount .bob-info {
  padding-top: 0.15rem;
}

.order .bob-info-amount .bob-amount {
  padding-top: 0.24rem;
  padding-bottom: 0.16rem;
}

/* Form */
.order form {
  padding-top: 0.14rem;
  padding-bottom: 0.9rem;
}

.order form .terms {
  margin-top: 0.18rem;
  display: flex;
}

.order form .terms p {
  line-height: 0.16rem;
  font-size: 0.12rem;
  color: #999999;
  margin-left: 0.08rem;
}

/* bottom */
.order-bottom {
  height: 100%;
  display: flex;
}

.order-bottom p {
  display: flex;
  align-items: center;
  margin-left: 0.28rem;
  font-size: 0.14rem;
  color: #333333;
  flex: 1;
}

.order-bottom .submit {
  flex-basis: 1.52rem;
}

.order-info {
  font-size: 0.14rem;
  padding-bottom: 0.2rem;
  color: #333333;
  letter-spacing: 0;
}
</style>

<template>
  <div class="confirm-deposit">
    <div class="input border flex-center">
      <input
        type="number"
        :placeholder="$t('common.confirm.deposit.placeholder')"
        v-model.number="formAmount"
      />
    </div>
    <p class="usd">≈{{ usdAmount | amount(2) }} {{ detail.referenceUnit }}</p>
    <div class="quick-filling">
      <h6>{{ $t("common.confirm.deposit.quickFilling") }}</h6>

      <div class="filling-lists">
        <common-hot-key
          v-for="(fill, index) in fillList"
          :key="index"
          :info="fill"
          v-model="_value"
        />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop, PropSync } from "vue-property-decorator";
import CommonHotKey, {
  CommonHotKeyInfo
} from "@/components/Common/hotKey/index.vue";
import { namespace } from "vuex-class";

const commonModule = namespace("common");

@Component({
  components: {
    CommonHotKey
  }
})
export default class ConfirmDeposit extends Vue {
  @Prop(Object) data!: {
    unit: string;
  };
  @PropSync("value", Number) _value!: number;

  @commonModule.Mutation CHANGE_LOADING!: (bool: boolean) => void;

  private detail = {
    coinFillConfigList: [],
    exchangeRate: 0,
    referenceUnit: ""
  } as CommonConfigDepositResponse;

  /** 充值金额 */
  get formAmount() {
    return this._value === 0 ? "" : this._value;
  }
  set formAmount(val) {
    this._value = val === "" ? 0 : val;
  }

  /** 使用汇率转换为usd价格 */
  get usdAmount() {
    return this.detail.exchangeRate * this._value;
  }

  /** 快捷填充列表 */
  get fillList() {
    return this.detail.coinFillConfigList.map(ele => ({
      value: ele.fillValue,
      label: ele.fillValue
    }));
  }

  /** 获取填充列表 */
  async getFillList() {
    const data = await this.axios
      .post("/user/searchRecharge", { unit: this.data.unit })
      .finally(() => this.CHANGE_LOADING(false));

    this.detail = data;
  }

  created() {
    this.getFillList();
  }
}
</script>

<style scoped>
/* 输入框 */
.confirm-deposit .input {
  height: 0.4rem;
  background-color: #fbfbfb;
}

.confirm-deposit .input::after {
  border-color: #e3e3e3;
  border-radius: 0.04rem;
}

.confirm-deposit .input input {
  width: calc(100% - 0.01rem);
  height: calc(100% - 0.01rem);
  border: none;
  z-index: 1;
  position: relative;
  box-sizing: border-box;
  padding: 0.12rem;
}

/* usd */
.confirm-deposit .usd {
  font-size: 0.12rem;
  line-height: 0.16rem;
  color: #7e7e7e;
  margin-top: 0.02rem;
}

/* 快捷键 */
.confirm-deposit .quick-filling h6 {
  font-size: 0.12rem;
  color: #333333;
  margin: 0.24rem 0 0.12rem;
}

.confirm-deposit .quick-filling .filling-lists .common-hot-key {
  width: 0.74rem;
  height: 0.5rem;
  line-height: 0.5rem;
  background-color: #f9fbfc;
  margin-bottom: 0.05rem;
  margin-right: 0.05rem;
  font-size: 0.14rem;
  color: #333333;
  box-sizing: border-box;
  border: 1px solid transparent;
}

.confirm-deposit .quick-filling .filling-lists .common-hot-key:nth-child(4n) {
  margin-right: 0;
}

.confirm-deposit .quick-filling .filling-lists .common-hot-key.active {
  position: relative;
  border: 1px solid #4a56b9;
  border-radius: 0.02rem;
  background-color: #ffffff;
}
</style>

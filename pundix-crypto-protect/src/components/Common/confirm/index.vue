<template>
  <mask-layer-slot :isShow="confirm.isShow" @close="closeConfirm">
    <transition name="slide">
      <div v-if="confirm.isShow" class="confirm">
        <h2 class="title">{{ confirm.title }}</h2>

        <div class="main">
          <div class="issue" v-if="confirm.type === 'issue'">
            <p v-for="(msg, index) in confirm.data" :key="index">
              {{ msg }}
            </p>
          </div>

          <deposit
            v-else-if="confirm.type === 'deposit'"
            :value.sync="depositAmount"
            :data="confirm.data"
          />

          <withdraw
            v-else-if="confirm.type === 'withdraw'"
            v-model="withdrawAmount"
            :data="confirm.data"
          />

          <confirmation
            v-else-if="confirm.type === 'confirmation'"
            :value.sync="useBalance"
            :data="confirm.data"
          />

          <notice
            v-else-if="confirm.type === 'notice'"
            v-model="noticeTerms"
            :data="confirm.data"
            @close="closeConfirm"
          />

          <last-time
            v-else-if="confirm.type === 'lastTime'"
            :data="confirm.data"
          />

          <current-price
            v-else-if="confirm.type === 'currentPrice'"
            :data="confirm.data"
          />
        </div>

        <div class="bottom flex-align-center">
          <button
            v-if="confirm.showCancel"
            class="cancel"
            @click="closeConfirm"
          >
            {{ $t("common.confirm.btn.cancel") }}
          </button>
          <button :disabled="disabled" class="submit" @click="confirmHandler">
            {{ confirm.confirmBtn || $t("common.confirm.btn.confirm") }}
          </button>
        </div>
      </div>
    </transition>
  </mask-layer-slot>
</template>

<script lang="ts">
import { Vue, Component, Watch } from "vue-property-decorator";
import { namespace } from "vuex-class";
import deposit from "./deposit.vue";
import confirmation from "./confirmation.vue";
import notice from "./notice.vue";
import withdraw from "./withdraw.vue";
import lastTime from "./lastTime.vue";
import currentPrice from "./currentPrice.vue";
import { Format } from "../../../plugins/format";

const commonModule = namespace("common");

@Component({
  components: {
    deposit,
    confirmation,
    notice,
    withdraw,
    lastTime,
    currentPrice
  }
})
export default class CommonConfirmAssemble extends Vue {
  @commonModule.Getter confirm!: CommonConfirm;
  @commonModule.Mutation CHANGE_CONFIRM!: (obj: CommonConfirm) => void;

  private depositAmount = 0;
  private withdrawAmount = 0;
  private noticeTerms = false;

  // confirmation: 使用钱包内余额
  private useBalance = true;

  /** 提交按钮禁用 */
  get disabled() {
    switch (this.confirm.type) {
      case "withdraw":
        return this.withdrawAmount === 0;
      case "deposit":
        return this.depositAmount === 0;
      case "notice":
        return this.noticeTerms === false;
      default:
        return false;
    }
  }

  confirmHandler() {
    if (this.confirm.confirmHandler) {
      switch (this.confirm.type) {
        case "deposit":
          this.confirm.confirmHandler({
            amount: this.depositAmount,
            rechargeUnit: this.confirm.data.unit
          } as PayParamsRequest);
          break;

        case "confirmation":
          this.confirm.confirmHandler(this.useBalance);
          break;

        case "withdraw":
          this.confirm.confirmHandler(this.withdrawAmount);
          break;

        default:
          this.confirm.confirmHandler();
          break;
      }
    }
  }

  closeConfirm() {
    this.CHANGE_CONFIRM({ isShow: false });
  }

  @Watch("confirm", { deep: true })
  resetAmount(val: CommonConfirm) {
    if (!val.isShow) {
      this.depositAmount = 0;
      this.withdrawAmount = 0;
      this.noticeTerms = false;
      this.useBalance = true;
    }
  }
}
</script>

<style scoped>
.confirm {
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  width: 100%;
  min-height: 2rem;
  max-height: 100%;
  overflow: auto;
  padding: 0.2rem 0.32rem;
  box-sizing: border-box;
  background-color: #ffffff;
  border-radius: 0.14rem 0.14rem 0 0;
}

.confirm .title {
  text-align: center;
  font-size: 0.2rem;
  color: #333333;
}

/* Main */
.confirm .main {
  flex: 1;
  min-height: 3rem;
  padding: 0.24rem 0;
  box-sizing: border-box;
}

.confirm .main .issue p {
  font-size: 0.14rem;
  color: #333333;
  line-height: 0.2rem;
  margin-bottom: 0.15rem;
}

/* Bottom */
.confirm .bottom button + button {
  margin-left: 0.1rem;
}

.confirm .bottom .cancel {
  background-color: #f1f1f1;
  color: #7e7e7e;
}
</style>

<template>
  <div class="common-count-selector" :class="{ focus }">
    <div class="container flex-center">
      <div class="minus btn flex-center" @click="minusHandler">
        <i class="icon icon-minus"></i>
      </div>
      <div class="main">
        <input
          type="number"
          v-model="_value"
          @focus="focus = true"
          @blur="blurHandler"
        />
      </div>
      <div class="plus btn flex-center" @click="plusHandler">
        <i class="icon icon-plus"></i>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop, PropSync } from "vue-property-decorator";
import { namespace } from "vuex-class";

const commonModule = namespace("common");

@Component
export default class CommonCountSelector extends Vue {
  @Prop(Number) max!: number;
  @Prop(Number) value!: number;

  @commonModule.Mutation CHANGE_TOAST!: (obj: CommonToast) => void;

  private focus = false;

  get _value() {
    return this.value;
  }

  set _value(val: number) {
    this.$emit("input", val);

    this.$nextTick(() => {
      if (!/[0-9]/g.test(val.toString())) return this.$emit("input", "");

      val > this.max && this.$emit("input", this.max);
    });
  }

  /**
   * 减去
   */
  minusHandler() {
    this._value > 1
      ? this._value--
      : this.CHANGE_TOAST({ msg: this.$t("errMsg.1000") as string });
  }

  /**
   * 加上
   */
  plusHandler() {
    this._value < this.max && this._value++;
  }

  /**
   * 失去焦点
   */
  blurHandler() {
    this.focus = false;

    this._value < 1 && this.$emit("input", 1);
  }
}
</script>

<style scoped>
.common-count-selector {
  position: relative;
}

.common-count-selector::after {
  content: "";
  position: absolute;
  left: 0;
  top: 0;
  width: 200%;
  height: 200%;
  border: 1px solid #e7e7e7;
  border-radius: 0.04rem;
  transform: scale(0.5);
  transform-origin: 0 0;
  z-index: 0;
}

.common-count-selector.focus::after {
  border-color: #4a56b9;
}

.common-count-selector .container {
  position: relative;
  z-index: 1;
}

.common-count-selector .icon {
  width: 0.1rem;
  height: 0.1rem;
}
.icon-minus {
  background: url(../../../assets/ic_minus.svg) no-repeat center / contain;
}
.icon-plus {
  background: url(../../../assets/ic_plus.svg) no-repeat center / contain;
}

.common-count-selector .btn {
  width: 0.28rem;
  height: 0.28rem;
}

.common-count-selector .main {
  flex: 1;
}

.common-count-selector .main input {
  width: 100%;
  height: 100%;
  box-sizing: border-box;
  border: none;
  text-align: center;
}
</style>

<template>
  <div class="history-btn">
    <span :class="{ rotate: !_value }" @click="clickHandler">
      {{ $t("home.history") }}
    </span>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";

@Component
export default class HistoryBtn extends Vue {
  @Prop(Boolean) value!: boolean;

  get _value() {
    return this.value;
  }

  set _value(val) {
    this.$emit("input", val);
  }

  /**
   * 点击处理
   */
  clickHandler() {
    this._value = !this._value;

    this.$emit("click");
  }
}
</script>

<style scoped>
.history-btn {
  text-align: center;
  margin: 0.2rem 0 0.22rem;
}

.history-btn span {
  padding: 0 0.3rem;
  background-color: #ffffff;
  font-size: 0.13rem;
  color: #4a56b9;
  border-radius: 0.4rem;
  height: 0.4rem;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.history-btn span::after {
  content: "";
  width: 0;
  height: 0;
  border-width: 0.04rem 0.04rem 0;
  border-color: #4a56b9 transparent transparent transparent;
  border-style: solid;
  margin-left: 0.05rem;
  transition: transform 0.3s ease;
}

.history-btn span.rotate::after {
  transform: rotate(180deg);
}
</style>

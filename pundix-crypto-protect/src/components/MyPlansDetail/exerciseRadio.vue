<template>
  <label class="exercise-radio">
    <input
      type="radio"
      :value="list.value"
      v-model="_value"
      :disabled="disabled"
      hidden
    />

    <div class="box">
      <i class="icon icon-gou"></i>
      <div class="info">
        <p>{{ list.coin }}</p>
        <p>{{ list.amount | amount }}</p>
      </div>

      <p class="type">
        {{ $t(`myPlansDetail.preview.radio.${list.type}`) }}
      </p>

      <p class="percent">+ {{ list.percent | amount(2) }}%</p>
    </div>
  </label>
</template>

<script lang="ts">
import { Vue, Component, Prop, PropSync } from "vue-property-decorator";

export interface IExerciseRadioList {
  value: 0 | 1 | 2;
  coin: string;
  amount: number;
  type: "protected" | "profit";
  percent: number;
  [key: string]: any;
}

@Component
export default class exerciseRadio extends Vue {
  @Prop(Number) value!: number;
  @Prop(Object) list!: IExerciseRadioList;
  @Prop(Boolean) disabled!: boolean;

  get _value() {
    return this.value;
  }

  set _value(val) {
    this.$emit("input", val);
  }
}
</script>

<style scoped>
.icon-gou {
  width: 0.14rem;
  height: 0.14rem;
  border: 0.01rem solid #ffffff;
  border-radius: 50%;
  box-sizing: border-box;
}

.exercise-radio input:checked + .box .icon-gou {
  background-color: #ffffff;
}

.exercise-radio input:checked + .box .icon-gou::before {
  content: "";
  display: inline-block;
  width: 0.08rem;
  height: 0.04rem;
  border-left: 0.01rem solid #4a56b9;
  border-bottom: 0.01rem solid #4a56b9;
  box-sizing: border-box;
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -70%) rotate(-45deg);
}

.exercise-radio {
  display: block;
  width: 48%;
  position: relative;
}

.exercise-radio .icon {
  position: absolute;
  top: 0.1rem;
  right: 0.1rem;
  z-index: 5;
}

.exercise-radio + .exercise-radio {
  margin-left: 0.08rem;
}

.exercise-radio .box {
  color: #ffffff;
  padding: 0.28rem 0.12rem;
  box-sizing: border-box;
  background-color: #b4c1c7;
  border-radius: 0.04rem;
  position: relative;
  overflow: hidden;
}

.exercise-radio .box::before {
  content: "";
  display: block;
  width: 100%;
  height: 0.32rem;
  position: absolute;
  left: 0;
  bottom: 0;
  background-color: #bbcad1;
  z-index: 1;
}

.exercise-radio .box::after {
  content: "";
  display: block;
  width: 250%;
  height: 250%;
  position: absolute;
  left: 50%;
  bottom: 0.3rem;
  background-color: #b4c1c7;
  border-radius: 40%;
  z-index: 2;
}

.exercise-radio:nth-child(1) .box::after {
  animation: rotateAnimate 10s ease-in-out infinite;
}
.exercise-radio:nth-child(2) .box::after {
  animation: rotateAnimate 10s ease-out infinite reverse;
}

.exercise-radio input:checked + .box {
  background-color: #4a56b9;
  box-shadow: 0 0.12rem 0.14rem -0.1rem rgba(74, 86, 185, 0.38);
}

.exercise-radio input:checked + .box::before {
  background-color: rgba(111, 121, 203, 0.52);
}

.exercise-radio input:checked + .box::after {
  background-color: #4a56b9;
}

.exercise-radio input:disabled:not(:checked) + .box .icon,
.exercise-radio input:disabled:not(:checked) + .box .info p,
.exercise-radio input:disabled:not(:checked) + .box .type,
.exercise-radio input:disabled:not(:checked) + .box .percent {
  opacity: 0.4;
}

.exercise-radio .box .info p,
.exercise-radio .box .type,
.exercise-radio .box .percent {
  position: relative;
  z-index: 5;
}

.exercise-radio .box .info p {
  font-size: 0.16rem;
  font-weight: 900;
}

.exercise-radio .box .type {
  font-size: 0.12rem;
  opacity: 0.7;
  margin-top: 0.18rem;
}

.exercise-radio .box .percent {
  font-size: 0.14rem;
}
</style>

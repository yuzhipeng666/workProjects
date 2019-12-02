<template>
  <div class="bob-info">
    <div class="logo">
      <img :src="info.imageUrl" :alt="info.productName" />
    </div>

    <!-- Info -->
    <div class="info">
      <p class="name">{{ info.productName }}</p>

      <div class="amount">
        <!-- 折后价 -->
        <span class="sale" :data-sale="info.discountPre">
          {{ info.discountAmount }} {{ info.priceUnit }}
        </span>

        <!-- 原价 -->
        <span class="original">
          {{ info.productPrice }} {{ info.priceUnit }}
        </span>
      </div>
    </div>

    <!-- 数量 -->
    <div class="quantity">
      <button
        v-show="quantityBtn"
        class="minus"
        :class="{ opacity: _value === 1 }"
        @click="quantityMinus"
      ></button>
      <div
        class="num"
        :style="{
          'text-align': !quantityBtn ? 'right' : 'center'
        }"
      >
        <span class="by" v-show="!quantityBtn">&#215; </span>
        <span>{{ _value }}</span>
      </div>
      <button
        v-show="quantityBtn"
        class="plus"
        :class="{ opacity: _value === info.stock }"
        @click="quantityPlus"
      ></button>
    </div>
  </div>
</template>

<script>
import { mapMutations } from "vuex";
export default {
  props: {
    info: Object,
    value: Number,
    quantityBtn: {
      default: true
    }
  },

  computed: {
    _value: {
      get() {
        return this.value;
      },
      set(val) {
        this.SAVE_MODEL({ key: "num", value: val });
      }
    }
  },

  methods: {
    ...mapMutations(["SAVE_MODEL"]),

    // 数量加减
    quantityPlus() {
      this._value < this.info.stock && this._value++;
    },
    quantityMinus() {
      this._value > 1 && this._value--;
    }
  }
};
</script>

<style scoped>
.bob-info {
  display: flex;
  justify-content: space-between;
  color: #333333;
}

.bob-info .logo {
  width: 0.4rem;
  height: 0.4rem;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.bob-info .info {
  flex: 1;
}

.bob-info .info .name {
  font-size: 0.18rem;
  line-height: 0.25rem;
}

.bob-info .info .amount {
  line-height: 0.18rem;
  font-size: 0.12rem;
}

/* 折扣价 */
.bob-info .info .amount .sale::after {
  margin-left: 0.02rem;
  margin-right: 0.08rem;
}

/* 原价 */
.bob-info .info .amount .original {
  text-decoration: line-through;
  color: #c9c9c9;
  white-space: nowrap;
}

.bob-info .quantity {
  width: 0.84rem;
  flex-shrink: 0;
  display: flex;
  align-items: center;
}

.bob-info .quantity .num {
  flex: 1;
  text-align: center;
}

.bob-info .quantity .num .by {
  font-size: 0.1rem;
}

.bob-info .quantity button {
  width: 0.2rem;
  height: 0.2rem;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  background-color: transparent;
}

.bob-info .quantity button.minus {
  background-image: url(../../assets/minus.svg);
}

.bob-info .quantity button.plus {
  background-image: url(../../assets/plus.svg);
}

.bob-info .quantity button.opacity {
  filter: opacity(0.2);
}
</style>

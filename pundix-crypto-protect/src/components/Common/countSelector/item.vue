<template>
  <div class="common-count-selector-item">
    <div class="label-item flex-align-center">
      <span>{{ $t("common.countSelector.item.labelItem") }}</span>
      <common-count-selector v-model="_value" :max="max" />
    </div>
    <p class="ps">{{ $t("common.countSelector.item.ps") }}</p>
    <div class="hot-key flex-align-center">
      <common-hot-key
        class="border"
        v-model="_value"
        v-for="(list, index) in hotKeyList"
        :key="index"
        :info="list"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";

import CommonCountSelector from "@/components/Common/countSelector/index.vue";
import CommonHotKey, {
  CommonHotKeyInfo
} from "@/components/Common/hotKey/index.vue";

@Component({
  components: {
    CommonCountSelector,
    CommonHotKey
  }
})
export default class CommonCountSelectorItem extends Vue {
  @Prop(Number) value!: number;
  @Prop(Number) max!: number;

  get _value() {
    return this.value;
  }

  set _value(val) {
    this.$emit("input", val);
  }
  /** 热键列表 */
  get hotKeyList(): CommonHotKeyInfo[] {
    return [
      { label: "1/4", value: this.getCeil(1 / 4) },
      { label: "1/2", value: this.getCeil(1 / 2) },
      { label: "3/4", value: this.getCeil(3 / 4) },
      {
        label: this.$t("common.countSelector.item.hotKeyMax", {
          num: this.max
        }) as string,
        value: this.max
      }
    ];
  }

  /**
   * 向上取整
   * @param num max / num
   */
  getCeil(num: number) {
    return Math.ceil(this.max * num);
  }
}
</script>

<style scoped>
.common-count-selector-item {
  width: 100%;
}

.common-count-selector-item .common-count-selector {
  width: 1.6rem;
}

.common-count-selector-item .label-item {
  justify-content: space-between;
}

.common-count-selector-item .label-item span {
  font-size: 0.16rem;
  color: #333333;
}

.common-count-selector-item .ps {
  font-size: 0.11rem;
  color: #999999;
  letter-spacing: 0.0016rem;
  line-height: 0.18rem;
  margin: 0.08rem 0 0.12rem;
}

.common-count-selector-item .hot-key {
  justify-content: space-between;
}
.common-count-selector-item .hot-key .common-hot-key {
  font-size: 0.12rem;
  line-height: 0.14rem;
  color: #4a56b9;
  position: relative;
  padding: 0.01rem 0.06rem;
  border-radius: 0.02rem;
}

.common-count-selector-item .hot-key .common-hot-key::after {
  border-radius: 0.04rem;
  border-color: rgba(74, 86, 185, 0.3);
}

.common-count-selector-item .hot-key .common-hot-key.active {
  color: #ffffff;
  background-color: #4a56b9;
}

.common-count-selector-item .hot-key .common-hot-key.active::after {
  border-color: #4a56b9;
}
</style>

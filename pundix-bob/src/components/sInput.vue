<template>
  <label class="s-input">
    <div class="label" :class="{ required }">{{ label }}</div>

    <div class="input-box" :class="{ focus }">
      <input
        :placeholder="placeholder"
        :type="type"
        v-model="_value"
        :required="required"
        @input="inputHandler"
        @focus="focusHandler"
        @blur="blurHandler"
        @invalid.prevent="invalidHandler"
      />

      <p class="warning" v-show="msg">{{ msg }}</p>
    </div>
  </label>
</template>

<script>
export default {
  props: {
    value: String,
    label: String,
    placeholder: String,
    required: {
      default: true
    },
    type: {
      default: "text"
    },
    invalidMsg: Object
  },

  data: () => ({
    focus: false,

    msg: ""
  }),

  computed: {
    _value: {
      get() {
        return this.value;
      },
      set(val) {
        this.$emit("input", val);
      }
    }
  },

  methods: {
    inputHandler() {
      this.msg && (this.msg = "");
    },

    focusHandler(evt) {
      this.$emit("focus", evt);
      this.focus = true;
    },

    blurHandler(evt) {
      this.$emit("blur", evt);
      this.focus = false;
    },

    invalidHandler({ target }) {
      const { validity } = target;

      if (validity.valid) return;

      for (let key in validity) {
        if (validity[key]) {
          switch (key) {
            case "valueMissing":
              return (this.msg = this.$t("error.10002"));
            default:
              return (this.msg = this.invalidMsg[key]);
          }
        }
      }
    }
  }
};
</script>

<style scoped>
.s-input {
  display: block;
}

.s-input + .s-input {
  margin-top: 0.12rem;
}

/* Label */
.s-input .label {
  font-size: 0.12rem;
  line-height: 0.17rem;
  margin-bottom: 0.05rem;
  color: #999;
}

.s-input .label.required::after {
  content: "*";
  vertical-align: top;
}

/* Input */
.s-input .input-box {
  position: relative;
  width: 100%;
  height: 0.4rem;
}
.s-input .input-box::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 200%;
  height: 200%;
  border: 1px solid #e3e3e3;
  transform-origin: 0 0;
  transform: scale(0.5);
  box-sizing: border-box;
  border-radius: 0.05rem;
}

.s-input .input-box.focus::before {
  border-color: #aeaeae;
}

.s-input input {
  box-sizing: border-box;
  width: 100%;
  height: 100%;
  border: none;
  padding: 0.08rem;
  font-size: 0.14rem;
  color: #333333;
}

.s-input .warning {
  font-size: 0.1rem;
  color: #ff6868;
}

::-webkit-input-placeholder {
  color: #aeaeae;
  font-size: 0.12rem;
  font-weight: 400;
}

::-moz-placeholder {
  color: #aeaeae;
  font-size: 0.12rem;
  font-weight: 400;
}

:-ms-input-placeholder {
  color: #aeaeae;
  font-size: 0.12rem;
  font-weight: 400;
}
</style>

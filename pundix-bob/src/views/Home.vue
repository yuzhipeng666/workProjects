<template>
  <layout-slot>
    <div class="home">
      <div class="ces-logo">
        <img src="http://cdn.pundix.com/bob-h5/dapp/ces_logo.png" />
      </div>
      <div class="banner">
        <div class="laser-color1">
          <img
            src="http://cdn.pundix.com/bob-h5/dapp/banner_laser_color1.png"
          />
        </div>
        <div class="bob-phone-bg">
          <div class="bob-shadow">
            <img src="http://cdn.pundix.com/bob-h5/dapp/banner_shadow.png" />
          </div>
          <div class="bob-bg">
            <img src="http://cdn.pundix.com/bob-h5/dapp/banner_bob.png" />
          </div>
          <div class="bob-phone">
            <img src="http://cdn.pundix.com/bob-h5/dapp/banner_phone1.png" />
          </div>
        </div>
      </div>
      <div class="main">
        <h2 class="title1">{{ $t("home.main.title1") }}</h2>
        <p class="desc">{{ $t("home.main.desc1") }}</p>
      </div>
      <!-- Amount -->
      <div class="amount">
        <p class="sale" :data-sale="info.discountPre">
          {{ info.discountAmount }} {{ info.priceUnit }}
        </p>
        <p class="original">{{ info.productPrice }} {{ info.priceUnit }}</p>
        <p class="discountPre">
          <span>{{ $t("home.main.discountPre") }} </span>
          <span>{{ $t("home.main.discountPreOff") }}</span>
        </p>
        <p class="desc time">{{ $t("home.main.time") }}</p>
        <p class="desc little">{{ $t("home.main.desc3") }}</p>
      </div>

      <!-- BOB Space -->
      <div class="bob-space">
        <div class="bob-space-list">
          <h2>{{ $t("home.bobSpace.title") }}</h2>
          <ul>
            <li v-for="bobs in bobSpecsList" :key="bobs.key">
              <p>{{ $t("home.bobSpace.list")[bobs.title] }}</p>
              <p>{{ $t("home.bobSpace.list")[bobs.desc] }}</p>
            </li>
          </ul>
        </div>
      </div>

      <div class="main">
        <h2 class="title2">{{ $t("home.main.title2") }}</h2>
        <p class="desc">{{ $t("home.main.desc2") }}</p>

        <div class="coin-logo">
          <img
            v-for="logo in coinLogoList"
            :key="logo"
            :src="`http://cdn.pundix.com/bob-h5/dapp/ic_${logo}.png`"
          />
        </div>
      </div>
      <div class="home-page-but">
        <div class="home-page" @click="routeHome">
          {{ $t("home.button.homepage") }}
        </div>
      </div>
    </div>

    <template #bottom>
      <button class="submit" @click="routeOrder">
        {{ $t("home.button.next") }}
      </button>
    </template>
  </layout-slot>
</template>

<script>
import layoutSlot from "@/slots/Layout.vue";
import { mapMutations, mapGetters, mapState } from "vuex";
import { pundix } from "@/plugins/px";

export default {
  components: {
    layoutSlot
  },

  data: () => ({
    coinLogoList: [
      "btc",
      "qtum",
      "bnb",
      "dai",
      "xem",
      "eth",
      "npxs",
      "fx",
      "dgx"
    ],
    bobSpecsList: [
      {
        title: "titleDisplay",
        desc: "descDisplay"
      },
      {
        title: "titleChipset",
        desc: "descChipset"
      },
      {
        title: "titleRAM",
        desc: "descRAM"
      },
      {
        title: "titleStorage",
        desc: "descStorage"
      },
      {
        title: "titleCameras",
        desc: "descCameras"
      },
      {
        title: "titleFrontcamera",
        desc: "descFrontcamera"
      },
      {
        title: "titleBattery",
        desc: "descBattery"
      },
      {
        title: "titleOS",
        desc: "descOS"
      },
      {
        title: "titleCharging",
        desc: "descCharging"
      },
      {
        title: "titleSensor",
        desc: "descSensor"
      },
      {
        title: "titleSIM",
        desc: "descSIM"
      }
    ]
  }),

  computed: {
    ...mapState(["userNum"]),
    ...mapGetters({
      info: "orderInfo"
    })
  },

  methods: {
    ...mapMutations(["SAVE_ALL", "SET_NOTICE", "SET_LOADING", "SAVE_USER_NUM"]),
    /**
     * 检测xwallet授权情况
     */
    async xwalletAuth(callback) {
      if (!this.userNum) {
        try {
          const data = await pundix.auth();

          this.SAVE_USER_NUM(data);

          callback && callback();
        } catch (err) {
          this.SET_NOTICE({ msg: err, type: "error" });
          throw err;
        }
      }

      // 回调
      callback && callback();
    },

    /**
     * 跳转到订单
     */
    routeOrder() {
      this.xwalletAuth(() => this.$router.push("/order"));
    },

    // 获取详情
    async getDetail() {
      this.SET_LOADING(true);

      const info = await this.axios
        .get("/api/v1/info")
        .finally(() => this.SET_LOADING(false));

      this.SAVE_ALL({ info });
    },

    // 打开新的webview
    routeHome() {
      pundix.newPage("https://functionx.io/#/bob");
    }
  },

  mounted() {
    Promise.all([
      // xwallet授权
      this.xwalletAuth(),

      this.getDetail()
    ]);
  }
};
</script>

<style scoped>
.home {
  background-color: #181d33;
}

.home > * {
  position: relative;
  z-index: 10;
}

.home .ces-logo {
  position: absolute;
  width: 100%;
  top: 0.3rem;
}

.home .ces-logo img {
  width: 0.24rem;
  height: 0.33rem;
  margin: 0 auto;
}

.home .bob-space {
  background: #101429;
  padding: 0.38rem 0.08rem 0.57rem;
}

.home .bob-space .bob-space-list h2 {
  font-size: 0.24rem;
  color: #ffffff;
  letter-spacing: 0;
  text-align: center;
  padding-bottom: 0.22rem;
}

.home .bob-space .bob-space-list ul {
  display: flex;
  flex-wrap: wrap;
}

.home .bob-space .bob-space-list ul li {
  box-sizing: border-box;
  flex: 0 0 calc(50% - 0.025rem);
  list-style: none;
  background: #252938;
  border-radius: 0.0363rem;
  padding: 0.12rem;
  margin-bottom: 0.05rem;
}

.home .bob-space .bob-space-list ul li:nth-child(odd) {
  margin-right: 0.05rem;
}

.home .bob-space .bob-space-list ul li p:first-child {
  font-size: 0.14rem;
  color: #ffffff;
  padding-bottom: 0.08rem;
}

.home .bob-space .bob-space-list ul li p:last-child {
  font-size: 0.12rem;
  color: #7c7d89;
  height: 0.28rem;
}

.home .home-page-but {
  padding-bottom: 0.4rem;
}

.home .home-page-but .home-page {
  position: relative;
  font-size: 0.12rem;
  color: #ffffff;
  padding: 0.14rem 0;
  text-align: center;
  width: 1.95rem;
  margin-left: auto;
  margin-right: auto;
}

.home .home-page-but .home-page::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 200%;
  height: 200%;
  border: 1px solid rgba(227, 227, 227, 0.5);
  transform-origin: 0 0;
  transform: scale(0.5);
  box-sizing: border-box;
  border-radius: 0.4rem;
}

.home .banner,
.home .banner .bob-phone-bg {
  position: relative;
}

.home .banner {
  padding-top: 0.75rem;
  background: url("http://cdn.pundix.com/bob-h5/dapp/banner_bright_color.png")
    top no-repeat / contain;
  z-index: 0;
}

.home .banner::after {
  content: "";
  display: block;
  width: 0.25rem;
  height: 0;
  margin: 0.1rem auto 0.18rem;
  border-bottom: 0.02rem solid #ffad00;
  border-radius: 0.03rem;
  position: relative;
}

.home .banner .laser-color1 {
  position: absolute;
  bottom: -0.3rem;
  z-index: 1;
}

.home .banner .bob-phone-bg .bob-bg {
  width: 79.5%;
  padding: 0.34rem 0.06rem 0.26rem;
  box-sizing: border-box;
  margin: 0 auto;
  position: relative;
  z-index: 2;
}

.home .banner .bob-phone-bg .bob-phone {
  width: 88.4%;
  position: absolute;
  bottom: 0.4rem;
  left: 50%;
  transform: translateX(-50%);
  z-index: 2;
}

.home .banner .bob-phone-bg .bob-shadow {
  position: absolute;
  top: -0.75rem;
}

/* 主要文字描述 */
.home .main {
  color: #ffffff;
  padding: 0 0.22rem;
  text-align: center;
}

.home .main h2 {
  font-size: 0.24rem;
  line-height: 0.3rem;
  margin-left: auto;
  margin-right: auto;
}

.home .main h2.title1 {
  width: 3.2rem;
  margin-bottom: 0.25rem;
}

.home .main h2.title2 {
  width: 2rem;
  margin-bottom: 0.15rem;
  margin-top: 0.32rem;
}

.home .main .desc,
.home .amount .desc {
  color: #a4a6ab;
  font-size: 0.14rem;
  line-height: 0.2rem;
  width: 3.16rem;
  margin-left: auto;
  margin-right: auto;
}

.home .amount .discountPre span {
  letter-spacing: 0;
  font-weight: bold;
}

.home .amount .discountPre span:first-child {
  font-size: 0.4rem;
  color: #ff9b05;
}

.home .amount .discountPre span:last-child {
  font-size: 0.19rem;
  color: #ff9b05;
}

.home .amount .desc.little {
  font-size: 0.12rem;
  line-height: 0.17rem;
  margin-top: 0.1rem;
}

.home .amount .desc.time {
  margin-bottom: 0.24rem;
  font-size: 0.14rem;
}

.home .amount {
  color: #ffffff;
  text-align: center;
  padding: 0.44rem 0 0.8rem;
  background: url("http://cdn.pundix.com/bob-h5/dapp/banner_laser_color2.png")
    right no-repeat / contain;
}

.home .amount .sale {
  font-size: 0.26rem;
  line-height: 0.36rem;
}

.home .amount .original {
  text-decoration: line-through;
  font-size: 0.15rem;
  color: #b9b9b9;
  line-height: 0.21rem;
}

.home .coin-logo {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  margin-top: 0.28rem;
  padding: 0 0.1rem 0.28rem;
  box-sizing: border-box;
}

.home .coin-logo img {
  width: 0.36rem;
  height: 0.36rem;
  margin: 0 0.2rem 0.28rem;
}
</style>

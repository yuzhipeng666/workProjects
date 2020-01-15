import Vue from "vue";
import VueRouter, { RouteConfig } from "vue-router";
import Home from "../views/Home.vue";

Vue.use(VueRouter);

const routes: RouteConfig[] = [
  {
    path: "/",
    name: "home",
    component: Home
  },
  {
    path: "/buying/:planId",
    name: "buying",
    component: () => import("@/views/Buying.vue"),
    props: true
  },
  {
    path: "/my-plans",
    name: "plans",
    component: () => import("@/views/MyPlans.vue")
  },
  {
    path: "/my-plans/:userPlanId",
    name: "plans-detail",
    component: () => import("@/views/MyPlansDetail.vue"),
    props: true
  },
  {
    path: "/my-assets",
    name: "assets",
    component: () => import("@/views/MyAssets.vue")
  },
  {
    path: "/my-assets-detail/:unit",
    name: "myAssetsDetail",
    component: () => import("@/views/MyAssetsDetail.vue"),
    props: true
  },

  /** 成功页面 */
  {
    path: "/success/buy",
    name: "buySuccess",
    component: () => import("@/views/Success/buy.vue")
  },
  {
    path: "/success/assets",
    name: "buyAssets",
    component: () => import("@/views/Success/assets.vue")
  },
  {
    path: "/success/exercise",
    name: "buyExercise",
    component: () => import("@/views/Success/exercise.vue")
  },

  /** 等待确认 */
  {
    path: "/confirming",
    name: "confirming",
    component: () => import("@/views/Confirming.vue")
  },

  /** 失败page */
  {
    path: "/fail",
    name: "fail",
    component: () => import("@/views/Fail.vue")
  }
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition;
    } else {
      return { x: 0, y: 0 };
    }
  }
});

export default router;

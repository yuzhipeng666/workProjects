import { Vue, Component } from "vue-property-decorator";
import { Route } from "vue-router";
import { namespace } from "vuex-class";
import { logs } from "@/plugins/logs";

// 注入路由守卫
Component.registerHooks([
  "beforeRouteEnter",
  "beforeRouteLeave",
  "beforeRouteUpdate" // for vue-router 2.2+
]);

const commonModule = namespace("common");

@Component
export default class ConfirmRoute extends Vue {
  @commonModule.Getter confirm!: CommonConfirm;
  @commonModule.Mutation CHANGE_CONFIRM!: (obj: CommonConfirm) => void;

  // beforeRouteEnter(to: Route, from: Route, next: () => void): void {
  //   console.log("beforeRouteEnter");
  //   next();
  // }
  // beforeRouteUpdate(to: Route, from: Route, next: () => void): void {
  //   console.log("beforeRouteUpdate"); //暂时不生效，版本问题
  //   next();
  // }
  beforeRouteLeave(
    to: Route,
    from: Route,
    next: (
      to?: string | false | void | Location | ((vm: Vue) => any) | undefined
    ) => void
  ) {
    logs("beforeRouteLeave");

    // 弹窗状态为打开时，阻止页面跳转，并关闭弹窗
    if (this.confirm.isShow) {
      // 关闭弹窗
      this.CHANGE_CONFIRM({ isShow: false });

      return next(false);
    }

    next();
  }
}

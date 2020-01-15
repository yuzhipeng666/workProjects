import Vue, { VNode } from "vue";
import { Pundix } from "./plugins/px";
import { AxiosInstance } from "axios";
import { PxMain } from "./px";

declare global {
  namespace JSX {
    // tslint:disable no-empty-interface
    interface Element extends VNode {}
    // tslint:disable no-empty-interface
    interface ElementClass extends Vue {}
    interface IntrinsicElements {
      [elem: string]: any;
    }
  }

  interface Window {
    PX: PxMain;
    Pundix: Pundix;
    axios: AxiosInstance;
    vm: Vue;
  }
}

import { AxiosStatic, AxiosPromise } from "axios";

declare module "vue/types/vue" {
  interface Vue {
    axios: AxiosStatic;
  }
}

declare module "axios" {
  interface AxiosInstance {
    post<T = any>(
      url: string,
      data?: any,
      config?: AxiosRequestConfig
    ): Promise<T>;
  }
}

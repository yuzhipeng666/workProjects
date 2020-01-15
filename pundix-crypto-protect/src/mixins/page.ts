import { Vue, Component } from "vue-property-decorator";
import { config } from "@/config";

/** 0: 重置lists数据， 1: 加载更多 */
export type getListType = 0 | 1;

interface IListApiParams {
  api: string;
  params?: object;
  idKey: "userPlanId" | "id" | "planId";
}

@Component
export default class PageMixins extends Vue {
  page = {
    pageSize: config.pageSize,
    prevId: 0
  };

  /** 是否还能翻页 */
  hasNext = false;

  async getListApi<T>({ api, params, idKey }: IListApiParams) {
    const data = await this.axios.post<ICommonListApiResponse<T>>(api, {
      ...params,
      ...this.page
    });

    this.hasNext = data.hasNext;

    if (this.hasNext) {
      this.page.prevId = (data.list[data.list.length - 1] as {
        [key: string]: any;
      })[idKey];
    }

    return data.list;
  }
}

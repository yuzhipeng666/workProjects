/**
 * 公共的列表API返回的格式
 */
interface ICommonListApiResponse<T> {
  hasNext: boolean;
  list: T[];
}

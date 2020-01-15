export function logs(...log: any[]) {
  process.env.NODE_ENV === "development" && console.log(...log);
}

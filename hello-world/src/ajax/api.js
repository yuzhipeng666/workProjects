import fetch from './fetch'

export default {
  // 登录
  login (json) { return fetch('login', json) }
}

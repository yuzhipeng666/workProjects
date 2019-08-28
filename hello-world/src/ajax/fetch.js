import axios from 'axios'

/**
 * axios请求封装
 *
 * @param {*} url
 * @param {*} json
 * @param {string} [method='post']
 * @param {number} [timeout=25000]
 * @returns
 */
function fetch (url, json, method = 'post', timeout = 25000) {
  var promise = new Promise((resolve, reject) => {
    let req = {
      url: process.env.VUE_APP_BASEURL + url,
      method: method,
      data: json,
      timeout: timeout,
      headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' }
    }
    axios(req)
      .then((response) => {
        let res = response.data
        if (res.code === 200) {
          resolve(res.data)
        } else {
          window.vm.$message.error(res.msg)
          reject(res.msg)
        }
      })
      .catch((error) => {
        console.error(`ajax error: ${url} ### ${error}`)
        if (error.message) {
          reject(error.message)
        } else {
          reject(new Error(`ajax 异常: ${url}`))
        }
      })
  })

  return promise
}

export default fetch

axios.interceptors.request.use((request) => {
  return request
}, (error) => {
  return Promise.reject(error)
})

axios.interceptors.response.use((response) => {
  return response
}, (error) => {
  return Promise.reject(error)
})

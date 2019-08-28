import Vue from 'vue'
import App from './App.vue'
import ElementUI from 'element-ui'
import router from './router'
import http from './ajax/api'
import './assets/scss/css.scss'

Vue.use(ElementUI)

Vue.config.productionTip = false
Vue.prototype.$message = ElementUI.Message
Vue.prototype.$http = http

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')

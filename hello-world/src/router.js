import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'main',
      component: () => import(/* webpackChunkName: "main" */ './views/main.vue'),
      redirect: '/downloadTemplate',
      children: [
        {
          path: '/downloadTemplate',
          name: 'downloadTemplate',
          component: () => import(/* webpackChunkName: "downloadTemplate" */ './views/downloadTemplate/index.vue'),
          meta: {
            title: '下载导入模版',
            icon: 'el-icon-s-help'
          }
        },
        {
          path: '/singleAddInterface',
          name: 'singleAddInterface',
          component: () => import(/* webpackChunkName: "singleAddInterface" */ './views/singleAddInterface/index.vue'),
          meta: {
            title: '单条添加接口数据',
            icon: 'el-icon-picture'
          }
        },
        {
          path: '/bulkData',
          name: 'bulkData',
          component: () => import(/* webpackChunkName: "bulkData" */ './views/bulkData/index.vue'),
          meta: {
            title: '批量导入数据',
            icon: 'el-icon-s-order'
          }
        },
        {
          path: '/interfaceInformation',
          name: 'interfaceInformation',
          component: () => import(/* webpackChunkName: "interfaceInformation" */ './views/interfaceInformation/index.vue'),
          meta: {
            title: '查看接口信息',
            icon: 'el-icon-s-order'
          }
        },
        {
          path: '/login',
          name: 'login',
          component: () => import(/* webpackChunkName: "login" */ './views/login/index.vue'),
          meta: {
            title: '登录',
            icon: 'el-icon-user-solid'
          }
        },
        {
          path: '/testStatistics',
          name: 'testStatistics',
          component: () => import(/* webpackChunkName: "testStatistics" */ './views/testStatistics/index.vue'),
          meta: {
            title: '测试情况统计',
            icon: 'el-icon-document-copy'
          }
        }
      ]
    }
  ]
})

const originalPush = Router.prototype.push
Router.prototype.push = function push (location) {
  return originalPush.call(this, location).catch(err => err)
}

export default router

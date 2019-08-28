<template>
<el-container class="main">
    <el-header class="header">
        <h1>自动化测试平台</h1>
    </el-header>
    <el-container>
        <el-aside width="200px">
            <el-menu
            @select="handleSelect"
            :default-active="active"
            class="el-menu-vertical-demo"
            background-color="#545c64"
            text-color="#fff"
            active-text-color="#ffd04b">
            <el-menu-item v-for="(n, index) in this.nav" :index="n.path" :key="index">
                <i :class="n.meta.icon"></i>
                <span slot="title">{{n.meta.title}}</span>
            </el-menu-item>
            </el-menu>
        </el-aside>
        <el-main class="main-content">
            <router-view></router-view>
        </el-main>
    </el-container>
</el-container>
</template>
<script>
export default {
  data () {
    return {
      nav: [],
      active: ''
    }
  },
  methods: {
    handleSelect (index, indexPath) {
      this.$router.push({
        path: index
      })
      this.active = index
    }
  },
  mounted () {
    this.nav = this.$router.options.routes[0].children
    this.active = window.location.pathname
  }
}
</script>

<style lang="scss" scoped>
.el-header {
  margin-bottom: 24px;
}
.main-content {
  margin-left: 15px;
  background: #fff;
}
.logo {
  width: 80px;
  margin: 15px 0;
}
.logout {
  font-size: 14px;
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
}
.el-header {
  position: relative;
}
.header {
  display: flex;
  h1 {
    margin: 0;
    height: 60px;
    line-height: 60px;
    font-weight: normal;
  }
}
</style>

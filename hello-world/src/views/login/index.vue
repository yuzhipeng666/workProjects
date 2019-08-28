<template>
  <div class="login">登录</div>
</template>

<script>
export default {
  data () {
    return {

    }
  },
  methods: {
    login () {
      this.$http.login({}).then(res => {
        console.log(res)
      })
    }
  }
}
</script>

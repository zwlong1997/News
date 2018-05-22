<template>
  <div class="login">
    <form @submit.prevent="submit">
      <div class="welcome"><img src="/static/img/welcome.png"></div>
      <div class="login-form">
        <div class="login-inp"><label>登录</label><input v-model="user.user_name" type="text" placeholder=""></div>
        <div class="login-inp"><label>密码</label><input type="password" v-model="user.user_pwd" placeholder=""></div>
        <div class="login-inp"><input v-on:click="submit()" type="button" value="立即注册" /></div>
      </div>
      <div class="login-txt">
        <router-link to="/login">立即登录</router-link>|<a href="demo.html#">忘记密码？</a></div>
    </form>
  </div>
</template>
<script>
  export default {
    name:'register',
    data(){
      return {
        user:{
          user_name:'',
          user_pwd:''
        }
      }
    },
    methods:{
      submit(){
          this.$store.dispatch('acUser',this.user);
      }
    }
  }
</script>

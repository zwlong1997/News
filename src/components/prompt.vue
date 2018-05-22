<template>
    <div class="isprompt" v-show="isprompt">
      <p style="margin-top: 250px;text-align: center;">您的反馈意见我们已经收到，将尽快帮您处理!</p>
      <p style="text-align: center;">页面将在3秒后跳转回主页...</p>
    </div>
</template>
<script>
  export default {
    name:'isprompt',
    computed:{
      isprompt(){
        return this.$store.state.my.isprompt;
      }
    }
  }
</script>

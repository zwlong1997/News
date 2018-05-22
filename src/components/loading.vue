<template>
    <div class="loading" v-show="isLoading">
      <img src="/static/img/loading.gif" />
    </div>
</template>
<script>
  export default {
    name:'loading',
    computed:{
      isLoading(){
        return this.$store.state.home.isLoading;
      }
    }
  }
</script>

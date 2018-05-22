<template>
  <div class="app">
    <router-view/>

    <footer-nav v-show="FooterShow"></footer-nav>
  </div>
</template>

<script>
  import footerNav from './components/footer.vue'
  export default {
    name: 'App',
    components:{footerNav},
    computed:{
    	FooterShow:function(){
    		if(this.$route.path == "/login" || this.$route.path == '/register')
    		{
    			return false;
    		}else{
    			return true;
    		}
    	}
    }
  }
</script>


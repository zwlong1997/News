<template>
  <div class="search">
    <div class="aui-searchbar" id="search" style="border-bottom:1px solid #ddd">
    <router-link to="/" @click.native="flushCom">
      <a href="javascript:" @click.navica class="aui-pull-left aui-btn" style="background:none; padding-right:0">
        <span class="aui-iconfont aui-icon-left" style="font-weight:600;">  </span>
      </a>
    </router-link>
      <div class="aui-searchbar-input aui-border-radius" tapmode>

        <i class="aui-iconfont aui-icon-search"></i>
        <form action="search.html">
          <input type="search" v-model="keywords" placeholder="请输入关键字...">
        </form>
      </div>
      <div class="aui-searchbar-cancel" tapmod style="color:#FF5E53; font-size:14px; padding-right:10px;" v-on:click="searchData">搜索</div>
    </div>

    <div class="aui-search">
      <div class="aui-search-box">
        <h3 class="b-line">热门搜索</h3>
        <ul>
          <li class="b-line" v-for="(item,index) in keywordsData">
            <em>{{index+1}}.</em>
            <router-link :to="{path:'/news_page',query:{id:item.news_id}}">
              {{item.news_title}}
            </router-link>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
<script>
  export default{
    name:'search',
    data(){
      return {
        keywords:""
      }
    },
    computed:{
      keywordsData(){
        return this.$store.state.home.searchData;
      }
    },
    methods:{
      searchData(){
         this.$store.dispatch('acsearchData',this.keywords);
      },
      flushCom(){
        this.$router.go(0);
      }
    }
  }
</script>

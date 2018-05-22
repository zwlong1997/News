<template>
  <div class="container">

    <!-- 头部信息 begin -->
    <div class="aui-header">
      <div class="aui-header-box clearfix">
        <div class="aui-header-logo">
          <a href="/collections" style="color: #fff">
            我的收藏
          </a>
        </div>
        <div class="aui-header-sou">
          <!--<a href="search.vue">-->
          <!--<span><i class="aui-iconfont aui-icon-search"></i></span>-->
          <!--</a>-->
        </div>
      </div>
    </div>
    <!-- 头部信息 end -->
  
    <!-- 内容信息 begin -->
    <div v-show="isCollect">
        <p style="margin-top: 250px;text-align: center;">您还没有收藏过哦，赶快去收藏喜欢的^_^</p>
    </div>
    <div style="padding-top:45px; padding-bottom:49px;" class='mg'>
      <section class="aui-middle-dome" v-for="item in newsData">
        <router-link :to="{path:'/news_page',query: {id: item.news_id}}">
          <a href="news-page.html" data-action-label="click-a" data-tag="news" class="aui-middle-dome-a">
            <div class="aui-middle-dome-title">
              <h3>{{item.news_title}}</h3>
              <div class="aui-middle-dome-text">
                <div class="clearfix">
                  <span class="aui-comment">{{new Date(item.news_time*1000).toLocaleString()}}</span>

                </div>
              </div>
            </div>
            <div class="aui-middle-dome-img">
              <img v-bind:src="item.news_pic ? '/static/'+item.news_pic : '/static/img/ad/a1.jpg'">
            </div>
          </a>
        </router-link>
      </section>
    </div>

    <!-- 内容信息 end -->
    
  </div>
</template>

<script>
	export default{
		name:'collections',
    created(){
      this.$store.dispatch('acCollections',this.user.user_id);
    },
    data(){
      return {
        user:JSON.parse(this.$cookie.get('user'))
      }
    },
    computed:{
      newsData(){
        return this.$store.state.my.newsData;
      },
      isCollect(){
        return this.$store.state.my.isCollect;
      }
    }
	}
</script>


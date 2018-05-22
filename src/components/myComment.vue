<template>
  <div class="container">

    <!-- 头部信息 begin -->
    <div class="aui-header">
      <div class="aui-header-box clearfix">
        <div class="aui-header-logo">
          <a href="home.vue" style="color:#fff">
           我的评论
          </a>
        </div>
        <div class="aui-header-sou">
          <a href="search.vue">
          <span><i class="aui-iconfont aui-icon-search"></i></span>
          </a>
        </div>
      </div>
    </div>
    <!-- 头部信息 end -->

    <!-- 内容信息 begin -->
    
    <div style="padding-top:45px; padding-bottom:49px;" class='mg'>
      <section v-if="ishidden == true">
        <div style='text-align: center;margin-top: 200px'>暂没有评论!</div>
      </section>
      <section  class="aui-middle-dome" v-for="item in myComment">
        <a href="#" data-action-label="click-a" data-tag="news" class="aui-middle-dome-a">
          <div class="aui-middle-dome-title">
            <h3>{{item.comment_content}}</h3>
            <div class="aui-middle-dome-text">
              <div class="clearfix">
                <span class="aui-comment">{{new Date(item.comment_time*1000).toLocaleString()}}</span>
              </div>
            </div>
            <div class="">
              <div class="clearfix">
                <span class="aui-comment">有{{item.comment_like ? item.comment_like : "0"}}人觉得你的评论很赞</span>
              </div>
            </div>
          </div>
        </a>
      </section>
    </div>

    <!-- 内容信息 end -->
    
  </div>
</template>

<script>
  
  export default{
    name:'myComment',
    created(){
      this.$store.dispatch('acmyComment',this.$route.query.user_id);
    },
    computed:{
      myComment(){
        return this.$store.state.my.myComment;
      },
      ishidden(){
        return this.$store.state.my.ishidden;
      }
    },
  }
</script>
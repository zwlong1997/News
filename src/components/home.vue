<template>
  <div class="container" >
    <!-- 头部信息 begin -->
    <div class="aui-header">
      <div class="aui-header-box clearfix">
        <div class="aui-header-logo">
          <a href="index.html">
            <img src="/static/img/logo/logo.png" alt="">
          </a>
        </div>
        <div class="aui-header-sou">
          <router-link to="/search">
            <span><i class="aui-iconfont aui-icon-search"></i></span>
          </router-link>
        </div>
      </div>
      <div class="swiper-container swiper1 b-line">
        <div class="swiper-wrapper">
          <!--<div class="swiper-slide selected">推荐</div>-->
          <div v-bind:class="index==isActive ? 'selected':''" v-for="(item,index) in channels" class="swiper-slide" v-on:click="changeData(index,item.news_cate_name)">{{item.news_cate_name}}</div>
        </div>
      </div>
    </div>
    <!-- 头部信息 end -->

    <!-- 内容信息 begin -->
    <div class="swiper-container swiper2" style="padding-top:85px; padding-bottom:49px;" >
      <div class="swiper-wrapper">
        <div class="swiper-slide swiper-no-swiping">
          <loading></loading>

          <scroller :on-refresh="refresh"
                    :on-infinite="infinite">
            <section  v-for="item in channelData" class="aui-middle-dome">
                <router-link :to="{path:'/news_page',query:{id:item.news_id}}">
                    <a href="news-page.html" data-action-label="click-a" data-tag="news" class="aui-middle-dome-a">
                      <div class="aui-middle-dome-title">
                        <h3>{{item.news_title}}</h3>
                        <div class="aui-middle-dome-text">
                          <div class="clearfix aui-pull-right" style="padding-right:20px;">
                            <span class="aui-comment">{{new Date(item.news_time*1000).toLocaleString()}} </span>
                          </div>
                        </div>
                      </div>
                      <div class="aui-middle-dome-img">
                        <img v-bind:src="item.news_pic ? '/static/'+item.news_pic : '/static/img/cover.jpeg'" alt="">
                      </div>
                    </a>
                </router-link>
            </section>
          
          
          </scroller>

        </div>
      </div>
    </div>
    <!-- 内容信息 end -->
  </div>
</template>
<script>
  import loading from './loading';
  export default {
    name:'home',
    components:{"loading":loading},
    beforeCreate(){
      if(!(this.$cookie.get('user')))
      {
        this.$router.go(0);
        this.$router.push('/login');
      }
    },
    created(){  //钩子
      let news_cate = this.$cookie.get('news_cate');
      this.$store.dispatch('acChannels');
      this.$store.dispatch('acGetData','头条');
      this.$store.dispatch('acDataCount',news_cate);
    },
    computed:{
      channels(){
        return this.$store.state.home.channels;
      },
      channelData()
      {
        return this.$store.state.home.channelData;
      },
      isActive()
      {
        return this.$store.state.home.isActive;
      }
    },
    methods:{
      changeData(index,item){
        this.$store.dispatch('acisLoading',true);
        this.$store.dispatch('acGetData',item);
        this.$store.dispatch('acIsActive',index);
      },
      refresh(done)
      {
        let news_cate = this.$cookie.get('news_cate');
        this.$store.dispatch('acRefresh');
        this.$store.dispatch('acRefreshData',news_cate);
        done();
      },
      infinite(done)
      {
        let news_cate = this.$cookie.get('news_cate');
        let news_count = this.$store.state.home.count;
        if(this.channelData.length >= news_count)
        {
          setTimeout(()=>{
            done(true);
          },1500);
          return;
        }
        setTimeout(()=>{
          this.$store.dispatch('acRefreshData',news_cate);
          done();
        },1500);
        
      }
    }

  }
</script>

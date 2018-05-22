<template>
  <div class="container">

    <!-- 头部信息 begin -->
    <div class="aui-header">
      <div class="aui-header-box clearfix">
        <div class="aui-header-logo">
          <a href="home.vue">
            <img src="/static/img/logo/logo-news.png" alt="">
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
    <div style="padding-top:45px; padding-bottom:49px;" class='mg'>
      <scroller :on-refresh="refresh"  :on-infinite="infinite" ref="my_scroller" class='mg'>
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
      </scroller>
    </div>

    <!-- 内容信息 end -->
  </div>
</template>

<script>
	export default{
		name:'news',
    beforeCreate(){
      if(!(this.$cookie.get('user')))
      {
        this.$router.go(0);
        this.$router.push('/login');
      }
    },
		created(){
			this.$store.dispatch('acnewsData');
		},
		computed:{
			newsData(){
				return this.$store.state.news.newsData;
			}
		},
		methods:{
			refresh(done){
				this.$store.dispatch('acRefresh');
				this.$store.dispatch('acnewsData');
				done();
			},
			infinite(done){
				let news_count = this.$store.state.news.count;
				if(this.newsData.length >= news_count)
				{
					setTimeout(()=>{
						done(true);
					},1500);
					return;
				}
				setTimeout(()=>{
					this.$store.dispatch('acnewsData');
						done();
					},1500);
			}
		}
	}
</script>


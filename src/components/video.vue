<template>
	<div class="container">

		<!-- 头部信息 begin -->
			<div class="aui-header">
				<div class="aui-header-box clearfix">
					<div class="aui-header-logo">
						<a href="home.vue">
							<img src="/static/img/logo/logo-vo.png" alt="">
						</a>
					</div>
					<div class="aui-header-sou">
						<!--<a href="search.vue">-->
							<!--<span><i class="aui-iconfont aui-icon-search"></i></span>-->
						<!--</a>-->
					</div>
				</div>
				<div class="swiper-container swiper1 b-line">
			        <div class="swiper-wrapper">
			          <!--<div class="swiper-slide selected">推荐</div>-->
			          <div v-bind:class="index == isActive ? 'selected' : '' " v-for="(item,index) in videoCate" class="swiper-slide" v-on:click="changeVideo(index,item.video_cate_name_ch)">{{item.video_cate_name_ch}}
			          </div>
			        </div>
			      </div>

			</div>
		<!-- 头部信息 end -->

		<!-- 内容信息 begin -->
			<div class="swiper-container swiper2" style="padding-top:85px; padding-bottom:49px;">
				<div class="swiper-wrapper">
					<div class="swiper-slide swiper-no-swiping">
						<section v-for="item in videoList" class="aui-middle-dome">
							<a @click="See(item.video_url)"  data-action-label="click-a" data-tag="news" class="aui-middle-dome-a">
								<h3 class="aui-title-h3">{{item.video_name}}</h3>
								<div class="aui-title-img"><img v-bind:src="item.video_pic ? '/static/'+item.video_pic : '/static/img/cover.jpeg'" alt=""><span class="aui-title-vio"></span></div>
								<div class="aui-title-text clearfix">
									<span><i></i>{{new Date(item.video_time*1000).toLocaleString()}}</span>
								</div>
							</a>
						</section>

					</div>
					
				</div>
			</div>
		<!-- 内容信息 end -->
	</div>
</template>

<script>
	export default{
		name:'video',
		beforeCreate(){
	      if(!(this.$cookie.get('user')))
	      {
	        this.$router.go(0);
	        this.$router.push('/login');
	      }
	    },
		created(){
			this.$store.dispatch('acvideoCate');
			this.$store.dispatch('acGetVideo','正在热映');
		},
		computed:{
			videoCate(){
				return this.$store.state.video.videoCate;
			},
			videoList(){
				return this.$store.state.video.videoList;
			},
			isActive(){
				return this.$store.state.video.isActive;
			}
		},
		methods:{
			changeVideo(index,item){
				this.$store.dispatch('acGetVideo',item);
				this.$store.dispatch('acIsActive',index);
			},
			 See (e) {
		        window.location.href = e;
		      }
		}
	}
</script>
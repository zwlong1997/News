<template>
	<div class="container">
		<header class="aui-bar aui-bar-nav aui-bar-light">2
			<router-link to="/" @click.native="flushCom">
				<a href="javascript:"  class="aui-pull-left aui-btn" >
					<span class="aui-iconfont aui-icon-left">  </span>
				</a>
			</router-link>
			<div class="aui-title">新闻列表</div>
			<a class="aui-pull-right aui-btn ">
				<span class="aui-iconfont aui-icon-more">  </span>
			</a>
		</header>

		<div class="aui-main">
			<article class="article padding-side">
				<div>
					<h1 v-on:click="getrouter()" class="article-title">{{news_page_list.news_title}}</h1>
				</div>
				<br>
				<img v-bind:src="news_page_list.news_pic ? '/static/'+news_page_list.news_pic : ''" alt="">
				<div class="article-content" v-html="news_page_list.news_content">
				</div>
			</article>
		</div>

		<div class="aui-card-list-content">
			<div class="aui-bg-like"><i id='newslike' v-on:click="newsLike()" class="aui-iconfont aui-icon-like"></i> {{news_page_list.news_like}} 人喜欢</div>
			<div class="aui-share-icon clearfix">
				<div class="aui-share-line b-line clearfix">
					<h2>分享到</h2>
				</div>
				<ul class="clearfix" style="padding-top:15px; padding-bottom:10px;">
					<li><i class="aui-iconfont aui-icon-wechat"></i></li>
					<li><i class="aui-iconfont aui-icon-wechat-circle"></i></li>
					<li><i class="aui-iconfont aui-icon-weibo" style="color:#ff6178"></i></li>
				</ul>
			</div>


			<ul class="aui-list aui-media-list">
				<p class="comments"><span onclick="showCm()">留言</span></p>
				<div class='commitCm' id='commitCm' style="display: none;">
					<textarea v-model="comment" name="" id="CmContent" cols="30" rows="10"></textarea>
					<button onclick="hideCm()">取消</button>
					<button v-on:click="commitCm()" onclick="clearVal()">提交</button>
				</div>
				<br>
				<li class="aui-list-item aui-list-item-middle" v-for="item in comments">
					<div class="aui-media-list-item-inner"> 
						<div class="aui-list-item-media">
							<img v-bind:src="item.user_pic ? item.user_pic : '../../static/img/ad/tou1.jpg'" class="aui-img-round aui-list-img-sm">
						</div>
						<div class="aui-list-item-inner ">
							<div class="aui-list-item-text">
								<div class="aui-list-item-title">{{item.user_name}}</div>
								<div  class="aui-list-item-right" id="like" v-on:click="like(item.comment_id)"><i class="aui-iconfont aui-icon-laud"></i>{{item.comment_like}}</div>
							</div>
							<div class="aui-list-item-text">
								{{item.comment_content}}
							</div>
						</div>
					</div>
				</li>
				

			</ul>
		</div>
		<div class="aui-card-list-footer aui-text-center aui-list-item-arrow">
			查看更多跟帖
		</div>
	</div>
</template>

<script>
 	export default{
 		name:'news_page',
 		data(){
 			return {
 				comment:"",
       			user:JSON.parse(this.$cookie.get('user'))
 			}
 		},
 		created(){
 			this.$store.dispatch('acnews_page_list',this.$route.query.id);
 			this.$store.dispatch('acComments',this.$route.query.id);
 		},
 		computed:{
 			news_page_list(){
 				return this.$store.state.news_page.news_page_list;
 			},
 			comments(){
 				return this.$store.state.news_page.comments;
 			}
 		},
 		methods:{
 			commitCm(){
 				this.$store.dispatch('acCommitCm',this.comment);
 				this.$store.dispatch('acComments',this.$route.query.id);
 				this.comment = "";
 			},
 			like(id){
 				this.$store.dispatch('acLike',id);
 				this.$store.dispatch('acComments',this.$route.query.id);
 			},
 			flushCom(){
 				this.$router.go(0);
 			},
 			newsLike(){
 				this.$store.dispatch('acnewsLike',this.$route.query.id);
 				this.$store.dispatch('acnews_page_list',this.$route.query.id);
 			}
 		}
 	}
 	
 	

</script>
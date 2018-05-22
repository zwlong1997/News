import axios from 'axios';
import VueCookie from 'vue-cookie'

export default{
	state:{
		news_page_list:"",
		comments:"",
		num:0
	},
	mutations:{
		munews_page_list(state,data)
		{
			state.news_page_list = data;
		},
		muComments(state,data)
		{
			state.comments = data;
		},
		muNum(state,data)
		{
			state.num = data;
		}
	},
	actions:{
		acnews_page_list({commit,state},item)
		{
			return new Promise((resolve,reject) => {
				axios.get('/api/news_page/'+item).then(news_page_list => {
					VueCookie.set('news_id','');
              		VueCookie.set('news_id',news_page_list.data['news_id']);
					commit('munews_page_list',news_page_list.data);
				})
			})
		},
		acCommitCm({commit,state},Cm)
		{
			let user_id = JSON.parse(getCookie("user")).user_id;
			let news_id = getCookie("news_id");
			return new Promise((resolve,reject) => {
				axios.get('/api/commitCm/'+Cm+'/'+user_id+'/'+news_id).then(Cm => {
					console.log('留言成功');
				})
			})
		},
		acComments({commit,state},news_id)
		{
			return new Promise((resolve,reject) => {
				axios.get('/api/comments/'+news_id).then(comments => {
					commit('muComments',comments.data);
				})
			})
		},
		acLike({commit,state},id)
		{
			return new Promise((resolve,reject) => {
				axios.get('/api/like/'+id).then(like=> {
					console.log('点赞成功');
				})
			})
		},
		acnewsLike({commit,state},news_id)
		{
			let user_id = JSON.parse(getCookie("user")).user_id;
			return new Promise((resolve,reject) => {
					axios.get('/api/newslikeAdd/'+news_id+'/'+user_id).then(insertId => {
					})
				})
		},
		acNum({commit,state})
		{
			state.num = 0;
		}

	}
}
import axios from 'axios';
import VueCookie from 'vue-cookie';


export default {
  state:{
    user:"",
    user_list:"",
    myComment:"",
    ishidden:true,
    isprompt:false,
    CtnValue:"",
    newsData:"",
    isCollect:true
  },
  mutations:{
    muUser(state,data){
      state.user = data;
    },
    muInit(state,data){
      state.user_list = data;
    },
    mumyComment(state,data){
      state.myComment = data;
    },
    muishidden(state,data){
      state.ishidden = data;
    },
    muisprompt(state,data){
      state.isprompt = data;
    },
    muCtnValue(state,data){
      state.CtnValue = data;
    },
    munewsData(state,data){
      state.newsData = data;
    },
    muisCollect(state,data){
      state.isCollect = data;
    },
  },
  actions:{
      acUser({commit,state},user){
        return new Promise((resolve,reject) => {
          //发送post 请求
          axios({
            url:"/api/register",
            method:'post',
            data:user,
            transformRequest: [function (data) {
              let ret = '';
              for (let it in data) {
                ret += encodeURIComponent(it) + '=' + encodeURIComponent(data[it]) + '&'
              }
              return ret
            }],
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            }
          }).then(res => {
            if(JSON.stringify(res.data) != "{}")
            {
                VueCookie.set('user',JSON.stringify(res.data));
                commit('muUser',res.data);
                resolve(res.data);
                location.href = 'http://localhost:8080/user';
            }else{
              location.href = "http://localhost:8080/register";
            }
          });
        });
      },
      acLogin({commit,state},user){
      	return new Promise((resolve,reject) => {
      		axios({
      			method:'post',
      			data:user,
      			url:'/api/login',
      			transformRequest: [function (data) {
		            let ret = '';
		            for (let it in data) {
		              ret += encodeURIComponent(it) + '=' + encodeURIComponent(data[it]) + '&'
		            }
		            return ret
		          }],
		          headers: {
		            'Content-Type': 'application/x-www-form-urlencoded'
		          }
      		}).then(res => {
      			if(JSON.stringify(res.data) != "{}")
      			{
      				VueCookie.set('user',JSON.stringify(res.data));
      				commit('muUser',res.data);
      				resolve(res.data);
      				location.href = 'http://localhost:8080/user';
      			}else{
      				location.href = "http://localhost:8080/login";
      			}
      		})
      	})
      },
      acInit({commit,state}){
        return new Promise((resolve,reject) => {
          axios.get('/api/initUser').then(user_list => {
            commit('muInit',user_list.data);
          })
        })
      },
      acunderLine({commit,state},underLine){
        // let underLine = JSON.parse(getCookie("underLine"));
        console.log(underLine);
      },
      acmyComment({commit,state},user_id){
        return new Promise((resolve,reject) =>{
          axios.get('/api/myComment/'+user_id).then(myCommentList => {
            if(myCommentList.data != ""){
              commit('muishidden',false);
              commit('mumyComment',myCommentList.data);
            }else{
              commit('muishidden',true);
            }
          })
        })
      },
      accommitMg({commit,state},main){
        let user_id = JSON.parse(getCookie("user")).user_id;
        main.user_id = user_id;
        if(main.Mgcontent != ""){
            return new Promise((resolve,reject) => {
              axios({
                method:'post',
                data:main,
                url:'/api/commitMg',
                transformRequest: [function (data) {
                    let ret = '';
                    for (let it in data) {
                      ret += encodeURIComponent(it) + '=' + encodeURIComponent(data[it]) + '&'
                    }
                    return ret
                  }],
                  headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                  }
              }).then(res => {
                if(res.data != ""){
                  commit('muisprompt',true);
                  setTimeout(()=>{
                    location.href="http://localhost:8080/user"
                  },3000);
                }else{
                  location.href="http://localhost:8080/message`"
                }
              })
            })
        }else{
          commit('muCtnValue','请填写内容');
        }
        
      },
      acisPrompt({commit,state},item)
      {
        commit('muisprompt',item);
      },
      acEmail({commit,state})
      {
        let email = prompt('请输入邮箱地址');
        if(email != "" && email != null)
        {
          return new Promise((resolve,reject) => {
            axios.get('/api/email/'+email).then(email => {
              if(email!= ""){
                alert('邮件已经发送，请前往邮箱进行验证！');
              }
            })
          })
        }else{
          alert('请输入邮箱地址!');
          location.href="http://localhost:8080/user";
        }
      },
      acCollections({commit,state},user_id){
        return new Promise((resolve,reject) => {
            //发送get请求
            axios.get('/api/collections/'+user_id).then(list => {
              if(list.data != ""){
                console.log('hh');
                commit('munewsData',list.data);
                commit('muisCollect',false);
              }
            });
        });
      },

     
  }
}

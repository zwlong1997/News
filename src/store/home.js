import axios from 'axios';
import VueCookie from 'vue-cookie'


export default {
  state:{
    channels:'',
    channelData:'',
    isActive:0,
    isLoading:true,
    searchData:'',
    page:0,
    count:0
  },
  mutations:{
    muChannels(state,data){    //接收提交
        state.channels = data;  //在mutations里面修改状态
    },
    muChannelRefresh(state,data){
      if(state.channelData instanceof Array)
      {
        state.channelData = state.channelData.concat(data);
      }else{
        state.channelData = data;
      }
    },
    muChannelData(state,data){
      state.channelData = data;
    },
    muIsActive(state,data){
        state.isActive = data;
    },
    muisLoading(state,data)
    {
      state.isLoading = data;
    },
    musearchData(state,data)
    {
      state.searchData = data;
    },
    muPage(state)
    {
        state.page++;
    },
    muCount(state,data)
    {
      state.count = data;
    },
    muRefresh(state)
    {
      state.channelData = "";
      state.page = 0;
      state.count = 0;
    }
  },
  actions:{
      acChannels({commit,state}){
        commit('muChannels',"");
        return new Promise((resolve,reject) => {
            //发送get请求
            axios.get('/api/channel').then(res => {
              //http://localhost:8080/api/channel
              commit('muChannels',res.data); //提交给mutations
            });
        });
      },
      acGetData({commit,state},item){
        return new Promise((resolve,reject) => {
          //发送get请求
          axios.get('/api/channel/'+item).then(res => {
              VueCookie.set('news_cate','');
              VueCookie.set('news_cate',res.data[0]['news_cate_name']);
              commit('muChannelData',res.data);
              commit('muisLoading',false);
            })
          });
      },
      acRefreshData({commit,state},item){
        commit('muPage');
        return new Promise((resolve,reject) => {
          let page = state.page;
          axios.get('/api/channelRefresh/'+item+'/'+page).then(res => {
            axios.get('/api/channelCount/'+item).then(count => {
              resolve(count);
              commit('muChannelRefresh',res.data);
              commit('muCount',count.data);
            })
          })
        })
      },
      acDataCount({commit,state},item){
        return new Promise((resolve,reject) => {
          axios.get('/api/channelCount/'+item).then(count => {
            resolve(count);
            commit('muCount',count.data);
          })
        })
      },
      acRefresh({commit,state}){
          commit('muRefresh');
      },
      acIsActive({commit,state},item){
        commit('muIsActive',item);
      },
      acisLoading({commit,state},item){
        commit('muisLoading',item);
      },
      acsearchData({commit,state},item){
        return new Promise((resolve,reject)=>{
          axios.get('/api/search/'+item).then(res=>{
            commit('musearchData',res.data);
            resolve(res);
          });
        });
      }
  }
}

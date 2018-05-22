import axios from 'axios';


export default {
  state:{
    videoCate:"",
    videoList:"",
    page:0,
    count:0,
    isActive:0
  },
  mutations:{
    muvideoCate(state,data){    //接收提交
        state.videoCate = data;
    },
    mugetVideo(state,data){
      state.videoList = data;
    },
    muIsActive(state,data){
      state.isActive = data;
    }
  },

  actions:{
      acvideoCate({commit,state}){
        commit('muvideoCate',"");
        return new Promise((resolve,reject) => {
            //发送get请求
            axios.get('/api/videoCate').then(cate => {
                commit('muvideoCate',cate.data); //提交给mutations
              })
        })
      },
      acGetVideo({commit,state},item){
        return new Promise((resolve,reject) => {
          axios.get('/api/getvideo/'+item).then(list => {
            commit('mugetVideo',list.data);
          })
        })
      },
      acIsActive({commit,state},item){
        commit('muIsActive',item);
      }
  }
}

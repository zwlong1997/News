import axios from 'axios';


export default {
  state:{
    newsData:"",
    page:0,
    count:0,
  },
  mutations:{
    munewsData(state,data){    //接收提交
      if(state.newsData instanceof Array)
      {
        state.newsData = state.newsData.concat(data);  //在mutations里面修改状态
      }else{
        state.newsData = data;
      }

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
      state.newsData = "";
      state.page = 0;
      state.count = 0;
    }
  },
  actions:{
      acnewsData({commit,state}){
        commit('muPage');
        return new Promise((resolve,reject) => {
            //发送get请求
            let page = state.page;
            axios.get('/api/news/'+page).then(list => {
              axios.get('/api/news_count').then(count => {
                resolve(count);
                commit('muCount',count.data); //提交给mutations
                commit('munewsData',list.data); //提交给mutations
              })
            });
        });
      },
      acRefresh({commit,state}){
          commit('muRefresh');
      }
  }
}

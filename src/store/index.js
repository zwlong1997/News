import Vue from 'vue';
import Vuex from 'vuex';
import home from './home'
import news from './news'
import my from './my'
import video from './video'
import news_page from './news_page'


//将vuex应用到vue当中去
Vue.use(Vuex);

export default new Vuex.Store({
  modules:{
    home:home,
    news:news,
    my:my,
    video:video,
    news_page:news_page
  }
});

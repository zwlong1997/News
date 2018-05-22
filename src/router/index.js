import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/home'
import User from '@/components/user'
import Search from '@/components/search'
import News from '@/components/news'
import Login from '@/components/login'
import Register from '@/components/register'
import Video from '@/components/video'
import News_page from '@/components/news_page'
import qrcode from '@/components/qrcode'
import myComment from '@/components/myComment'
import message from '@/components/message'
import collections from '@/components/collections'

Vue.use(Router)

export default new Router({
  mode:'history',
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path:'/user',
      name:'user',
      component:User
    },
    {
      path:'/search',
      name:'search',
      component:Search
    },
    {
      path:'/news',
      name:'news',
      component:News
    },
    {
      path:'/login',
      name:'login',
      component:Login
    },
    {
      path:'/register',
      name:'register',
      component:Register
    },
    {
      path:'/video',
      name:'video',
      component:Video
    },
    {
      path:'/news_page',
      name:'news_page',
      component:News_page
    },
    {
      path:'/qrcode',
      name:'qrcode',
      component:qrcode
    },
    {
      path:'/myComment',
      name:'myComment',
      component:myComment
    },
    {
      path:'/message',
      name:'message',
      component:message
    },
    {
      path:'/collections',
      name:'collections',
      component:collections
    }
  ]
})

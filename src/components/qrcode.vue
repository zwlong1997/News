<template>
  <div class="user">
    <section class="aui-content" id="user-info" >
      <div class="aui-list aui-media-list aui-list-noborder aui-bg-info" style="padding:14px 0">
        <div class="aui-list-item aui-list-item-middle" style="background-image:none">
          <div class="aui-media-list-item-inner ">
            <div class="aui-list-item-media" style="width:3rem;">
              <img v-bind:src="user.user_pic ? user.user_pic : 'static/img/ad/tou2.jpg'" class="aui-img-round">
            </div>
            <div class="aui-list-item-inner aui-list-item-arrow">
              <div class="aui-list-item-text text-white aui-font-size-18" style="color:#fff">{{user.user_name}}</div>
              <div class="aui-list-item-text text-white">
                <div style="color:#fff"><i class="aui-iconfont aui-icon-mobile aui-font-size-14" style="color:#fff"></i>{{user.user_phone ? user.user_phone : '未设置手机号码'}}</div>
              </div>
            </div>
          </div>
        </div>
        <div class="aui-row aui-clear-cl ">
          <div class="aui-col-xs-4 aui-border-r">
            <a href="my-newest.html">
              <div class="aui-clear-cl1">{{user_list.comment}}</div>
              <div class="aui-gird-lable aui-font-size-12">评论</div>
            </a>
          </div>
          <div class="aui-col-xs-4 aui-border-r">
            <a href="my-follow.html">
              <div class="aui-clear-cl1">{{user_list.message}}</div>
              <div class="aui-gird-lable aui-font-size-12">反馈</div>
            </a>
          </div>
          <div class="aui-col-xs-4">
            <a href="my-fans.html">
              <div class="aui-clear-cl1">67809</div>
              <div class="aui-gird-lable aui-font-size-12">粉丝</div>
            </a>
          </div>
        </div>
      </div>
    </section>
    <section class="aui-content aui-content-size">
      <div class="aui-grid">
        <div class="aui-row">
          <div class="aui-col-xs-3">
            <a href="my-subscribe.html">
              <i class="aui-iconfont aui-icon-mail aui-text-info"></i>
              <div class="aui-grid-label">邮箱验证</div>
            </a>
          </div>
          <div class="aui-col-xs-3">
            <a href="my-collection.html">
              <i class="aui-iconfont aui-icon-like aui-text-warning"></i>
              <div class="aui-grid-label">收藏</div>
            </a>
          </div>
          <div class="aui-col-xs-3">
            <router-link to="qrcode">
              <i class="aui-iconfont aui-icon-pencil aui-text-warning"></i>
              <div class="aui-grid-label">我的二维码</div>
            </router-link>
          </div>
          <div class="aui-col-xs-3">
            <a href="my-read.html">
              <i class="aui-iconfont aui-icon-date aui-text-info"></i>
              <div class="aui-grid-label">粉丝列表</div>
            </a>
          </div>

        </div>
      </div>
    </section>
    <div class="aui-he"></div>
    <section class="aui-content qrcode" style="padding-bottom:50px;text-align:center">
      <vue-qr :bgSrc="'static/img/login-bg.png'" :logoSrc="'static/img/cover.jpeg'" text="http://localhost/register?user_id=1" :size="200" :margin="0"></vue-qr>
    </section>
  </div>
</template>
<style>
  .qrcode img{
    margin:0 auto;
  }
</style>
<script>
  import VueQr from 'vue-qr'
  export default{
    name:'user',
    components: {VueQr},
    beforeCreate(){
        if(!(this.$cookie.get('user')))  //没有登录
        {
          this.$router.go(0);
          this.$router.push('/login');
        }
    },
    created(){
      this.$store.dispatch('acInit');
    },
    data()
    {
      return {
        user:JSON.parse(this.$cookie.get('user')),
      }
    },
    computed:{
      user_list(){
        return this.$store.state.my.user_list;
      }
    },
    methods:{
      logout()
      {
        this.$cookie.set('user',"");
        this.$router.push('/login');
      }
    }
  }
</script>

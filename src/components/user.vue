<template>
  <div class="user">
    <section class="aui-content" id="user-info" >
      <div class="aui-list aui-media-list aui-list-noborder aui-bg-info" style="padding:14px 0">
        <div class="aui-list-item aui-list-item-middle" style="background-image:none">
          <div class="aui-media-list-item-inner ">
            <div class="aui-list-item-media" style="width:3rem;">
              <img src="static/img/ad/tou2.jpg" class="aui-img-round">
            </div>
            <div class="aui-list-item-inner aui-list-item-arrow">
              <div class="aui-list-item-text text-white aui-font-size-18" style="color:#fff">{{user.user_name}}</div>
              <div class="aui-list-item-text text-white">
                <div style="color:#fff"><i class="aui-iconfont aui-icon-mobile aui-font-size-14" style="color:#fff"></i>{{user.user_phone ? user.user_phone : "未设置手机号码"}}</div>
              </div>
            </div>
          </div>
        </div>
        <div class="aui-row aui-clear-cl ">
          <div class="aui-col-xs-4 aui-border-r">
            <router-link :to="{path:'/myComment',query:{user_id:user.user_id}}">
              <div class="aui-clear-cl1">{{user_list.comment}}</div>
              <div class="aui-gird-lable aui-font-size-12">评论</div>
            </router-link>
          </div>
          <div class="aui-col-xs-4 aui-border-r">
            <a href="">
              <div class="aui-clear-cl1">{{user_list.message}}</div>
              <div class="aui-gird-lable aui-font-size-12">反馈</div>
            </a>
          </div>
          <div class="aui-col-xs-4">
            <a href="">
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
          <div class="aui-col-xs-3" v-on:click="Forgot()">
            <a href="#">
              <i class="aui-iconfont aui-icon-mail aui-text-info"></i>
              <div class="aui-grid-label">邮箱验证</div>
            </a>
          </div>
          <div class="aui-col-xs-3">
            <router-link to='/collections'>
              <i class="aui-iconfont aui-icon-like aui-text-warning"></i>
              <div class="aui-grid-label">收藏</div>
            </router-link>
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
    <section class="aui-content" style="padding-bottom:50px;">
      <ul class="aui-list aui-list-in " style="background-image:none">
        <router-link :to="{path:'/myComment',query:{user_id:user.user_id}}">
          <li class="aui-list-item" style="background-image:none">
            <a>
              <div class="aui-list-item-label-icon">
                <i class="aui-iconfont aui-icon-location aui-text-info"></i>
              </div>
              <div class="aui-list-item-inner aui-list-item-arrow">
                <div class="aui-list-item-title aui-black">我的评论</div>
              </div>
            </a>
          </li>
        </router-link>
        <div class="aui-he"></div>
        <li class="aui-list-item" style="background-image:none">
          <a href="my-newest.html">
            <div class="aui-list-item-label-icon">
              <i class="aui-iconfont aui-icon-like aui-text-danger"></i>
            </div>
            <div class="aui-list-item-inner aui-list-item-arrow">
              <div class="aui-list-item-title aui-black">最新动态</div>
            </div>
          </a>
        </li>
        <div class="aui-he"></div>
        <li class="aui-list-item" style="background-image:none" v-on:click="underLine()">
          <a>
            <div class="aui-list-item-label-icon">
              <i class="aui-iconfont aui-icon-image aui-text-info"></i>
            </div>
            <div class="aui-list-item-inner aui-list-item-arrow">
              <div class="aui-list-item-title aui-black">离线阅读</div>
            </div>
          </a>
        </li>
        <div class="aui-he"></div>
        <li class="aui-list-item" style="background-image:none">
          <a href="https://shop108012643.taobao.com/">
            <div class="aui-list-item-label-icon">
              <i class="aui-iconfont aui-icon-cart aui-text-info"></i>
            </div>
            <div class="aui-list-item-inner aui-list-item-arrow">
              <div class="aui-list-item-title aui-black">积分商城</div>
              <div class="aui-list-item-right aui-black">0元好物在这里</div>
            </div>
          </a>
        </li>
        <div class="aui-he"></div>
        <router-link to="/message">
          <li class="aui-list-item" style="background-image: none">
            <a href="my-feedback.html">
              <div class="aui-list-item-label-icon">
                <i class="aui-iconfont aui-icon-cert aui-text-warning"></i>
              </div>
              <div class="aui-list-item-inner aui-list-item-arrow">
                <div class="aui-list-item-title aui-black">意见反馈</div>
              </div>
            </a>
          </li>
        </router-link>
        <div class="aui-he"></div>
        <li class="aui-list-item" style="background-image: none">
          <a href="javascript:void(0)">
            <div class="aui-list-item-label-icon">
              <i class="aui-iconfont aui-icon-cert aui-text-warning"></i>
            </div>
            <div class="aui-list-item-inner aui-list-item-arrow">
              <div class="aui-list-item-title aui-black" v-on:click="logout()">退出</div>
            </div>
          </a>
        </li>
        <div class="aui-he"></div>
      </ul>
    </section>
  </div>
</template>

<script>
  export default{
    name:'user',
    beforeCreate(){
        if(!(this.$cookie.get('user')))  //没有登录
        {
          this.$router.go(0);
          this.$router.push('/login');
        }
    },
    created(){
      this.$store.dispatch('acInit');
      this.$store.dispatch('acisPrompt',false);
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
      },
      underLine(){
        this.$store.dispatch('acunderLine',this.$cookie.get('underLine'));
      },
      myComment(){
        this.$store.dispatch('acmyComment',this.user.user_id);
      },
      Forgot(){
        this.$store.dispatch('acEmail');
      }

    }
  }
</script>

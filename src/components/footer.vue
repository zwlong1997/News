<template>
  <footer class="aui-bar aui-bar-tab" id="footer" style="border-top:1px solid #ddd; background:#efefef">
    <div class="aui-bar-tab-item aui-active" tapmode>
      <router-link to="/" @click.native="flushCom">
        <i class="aui-iconfont aui-icon-home"></i>
        <div class="aui-bar-tab-label">首页</div>
      </router-link>
    </div>
    <div class="aui-bar-tab-item" tapmode>
      <router-link to="/news">
        <i class="aui-iconfont aui-icon-like"></i>
        <div class="aui-bar-tab-label">要闻</div>
      </router-link>
    </div>
    <div class="aui-bar-tab-item" tapmode>
      <router-link to="/video" @click.native="flushCom">
        <i class="aui-iconfont aui-icon-video"></i>
        <div class="aui-bar-tab-label">视频</div>
      </router-link>
    </div>
    <div class="aui-bar-tab-item" tapmode>
      <router-link to="/user">
        <i class="aui-iconfont aui-icon-my"></i>
        <div class="aui-bar-tab-label">我的</div>
      </router-link>
    </div>
  </footer>
</template>
<script>
  export default {
    name:'footer-nav',
    methods:{
      flushCom:function(){

        this.$router.go(0);
      }
    }
  }
</script>

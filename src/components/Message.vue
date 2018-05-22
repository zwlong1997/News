<template>
	<div class="container">
		<header class="aui-bar aui-bar-nav aui-bar-light">
			<a href="javascript:" onclick="history.back(); " class="aui-pull-left aui-btn" >
				<span class="aui-iconfont aui-icon-left"></span>
			</a>
			<div class="aui-title aui-font-size-14" style="color:#fff">帮助与反馈</div>
		</header>
		<prompt></prompt>
		<div v-if="isprompt == false" class="aui-content aui-margin-b-15" style="padding-top:44px;">
			<ul class="aui-list aui-form-list aui-list-wid">
				<li class="aui-list-item" style="background-image: none">
					<div class="aui-list-item-inner">

						<div class="aui-list-item-input">
							<textarea placeholder="请写下您的意见或者建议..." value="CtnValue" v-model="main.Mgcontent"></textarea>
						</div>
					</div>
				</li>
				<li class="aui-list-header">选择反馈类型</li>
				<li class="aui-list-item" style="background-image:none">
					<div class="aui-list-item-inner">
						<div class=" aui-list-item-inputs">
							<label><input v-model="main.type" class="aui-radio" type="radio" name="demo1" value="1">程序问题</label>
							<label><input v-model="main.type" class="aui-radio" type="radio" name="demo1" value="2">功能建议</label>
							<label><input v-model="main.type" class="aui-radio" type="radio" name="demo1" value="3">内容意见</label>
							<label><input v-model="main.type" class="aui-radio" type="radio" name="demo1" value="4">广告问题</label>
							<label><input v-model="main.type" class="aui-radio" type="radio" name="demo1" value="5">网络问题</label>
							<label><input v-model="main.type" class="aui-radio" type="radio" name="demo1" value="6">投诉建议</label>
						</div>
					</div>
				</li>
				<li class=aui-he></li>
				<li class="aui-list-item" style="background-image:none">
					<div class="aui-list-item-inner aui-list-item-center aui-list-item-btn">
						<div class="aui-btn aui-btn-danger aui-btn-block aui-btn-sm" v-on:click="commitMg()">提交</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
	
</template>

<script>
	import prompt from './prompt';
	export default{
		name:'message',
		components:{'prompt':prompt},
		data(){

			return {
				main:{
					type:"",
					Mgcontent:""
				}
			}
		},
		computed:{
			isprompt(){
				return this.$store.state.my.isprompt;
			},
			CtnValue(){
				return this.$store.state.my.CtnValue;
			}
		},
		methods:{
			commitMg(){
				this.$store.dispatch('accommitMg',this.main);
			},

	}
}
</script>
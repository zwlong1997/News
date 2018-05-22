
 	function showCm(){
 		var Cm=document.getElementById('commitCm');
 		var CmCtn=document.getElementById('CmContent');
 		Cm.style.display = 'block';
 	}
 	function hideCm(){
 		var Cm=document.getElementById('commitCm');
 		var CmCtn=document.getElementById('CmContent');
 		Cm.style.display = 'none';
 		CmCtn.value = "";
 	}
 	function clearVal(){
 		var CmCtn=document.getElementById('CmContent');
 		CmCtn.value = "";
 	}

	$('.aui-bar-tab-item').click(function(){
		$('.aui-bar-tab-item').removeClass("aui-active");
		$(this).addClass('aui-active');
	})



 	function getCookie(name)
	{
		var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
		if(arr=document.cookie.match(reg))
		return unescape(arr[2]);
		else
		return null;
	}

	function Forgot(){
		var email = prompt('请输入邮箱地址');
		if(email != "" && email != null){
			location.href="/user?email="+email;
			return false;
		}
	}

	function getString( objarr ){
	　　var typeNO = objarr.length;
	  　 var tree = "[";
	 　　for (var i = 0 ;i < typeNO ; i++){
	   　　　tree += "[";
	   　　　tree +="'"+ objarr[i][0]+"',";
	   　　　tree +="'"+ objarr[i][1]+"'";
	  　　　 tree += "]";
	  　　　 if(i<typeNO-1){
	    　　 　　tree+=",";
	 　　　  }
	  　 }
	  　 tree+="]";
	  　 return tree;
	}


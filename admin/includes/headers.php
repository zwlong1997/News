<?php 
//提醒信息跳转
function show_msg($msg,$url='')
{
    $str = '';
    if(!empty($url))
    {
        $str = <<<DOF
<script>
alert('$msg');
location.href = '$url';
</script>
DOF;
    }else{
        $str = <<<DOF
<script>
alert('$msg');
history.go(-1);
</script>
DOF;
    }
    echo $str;
}

/**
 * 
 * 字符截取
 * @param string $string
 * @param int $start
 * @param int $length
 * @param string $charset
 * @param string $dot
 * 
 * @return string
 */
function str_cut(&$string, $start, $length, $charset = "utf-8", $dot = '...') {
	if(function_exists('mb_substr')) {
		if(mb_strlen($string, $charset) > $length) {
			return mb_substr ($string, $start, $length, $charset) . $dot;
		}
		return mb_substr ($string, $start, $length, $charset);
		
	}else if(function_exists('iconv_substr')) {
		if(iconv_strlen($string, $charset) > $length) {
			return iconv_substr($string, $start, $length, $charset) . $dot;
		}
		return iconv_substr($string, $start, $length, $charset);
	}

	$charset = strtolower($charset);
	switch ($charset) {
		case "utf-8" :
			preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $string, $ar);
			if(func_num_args() >= 3) {
				if (count($ar[0]) > $length) {
					return join("", array_slice($ar[0], $start, $length)) . $dot;
				}
				return join("", array_slice($ar[0], $start, $length));
			} else {
				return join("", array_slice($ar[0], $start));
			}
			break;
		default:
			$start = $start * 2;
			$length   = $length * 2;
			$strlen = strlen($string);
			for ( $i = 0; $i < $strlen; $i++ ) {
				if ( $i >= $start && $i < ( $start + $length ) ) {
					if ( ord(substr($string, $i, 1)) > 129 ) $tmpstr .= substr($string, $i, 2);
					else $tmpstr .= substr($string, $i, 1);
				}
				if ( ord(substr($string, $i, 1)) > 129 ) $i++;
			}
			if ( strlen($tmpstr) < $strlen ) $tmpstr .= $dot;
			
			return $tmpstr;
	}
}

//上传文件的函数
function upload_file($name,$path,$size=12312311)
{
    //获取上传文件的错误信息
    $error = $_FILES[$name]['error'];  

    //根据error的值 来判断文件是否有上传成功
    switch($error)
    {
        case 1:
            echo "上传文件大小已经超过upload_max_size的大小";
            return false;
            break;
        case 2:
            echo "上传文件大小已经超过MAX_FILES_SIZE表单隐藏域的大小";
            return false;
            break;
        case 3:
            echo "网络出错文件上传中断";
            return false;
            break;
        case 4:
            echo "未上传文件";
            return false;
            break;    
    }

    //判断文件上传的大小是否有超过函数的配置
    $upload_size = $_FILES[$name]['size'];
    if($upload_size > $size)
    {
        return false;
    }

    //新的文件名称
    $ext = PATHINFO($_FILES[$name]['name'],PATHINFO_EXTENSION);
    $file_name = PATHINFO($_FILES[$name]['name'],PATHINFO_FILENAME);

    $new_name = $file_name."-".date("YmdHis").mt_rand(100000,999999).".".$ext;


    //最终的上传文件
    //该文件是否有通过http post上传文件
    if(is_uploaded_file($_FILES[$name]['tmp_name']))
    {
		move_uploaded_file($_FILES[$name]['tmp_name'],$path."/".$new_name);
		return $new_name;
    }else{
		return false;
	}
    
}



/**
 * 生成缩略图函数（支持图片格式：gif、jpeg、png和bmp）
 * @author ruxing.li
 * @param  string $src      源图片路径
 * @param  int    $width    缩略图宽度（只指定高度时进行等比缩放）
 * @param  int    $width    缩略图高度（只指定宽度时进行等比缩放）
 * @param  string $filename 保存路径（不指定时直接输出到浏览器）
 * @return bool
 */
function mkThumbnail($src, $width = null, $height = null, $filename = null) {
    if (!isset($width) && !isset($height))
        return false;
    if (isset($width) && $width <= 0)
        return false;
    if (isset($height) && $height <= 0)
        return false;

    $size = getimagesize($src);  //获取图像的尺寸
    if (!$size)
        return false;

    list($src_w, $src_h, $src_type) = $size;
    $src_mime = $size['mime'];
 //    索引 mime 给出的是图像的 MIME 信息，此信息可以用来在 HTTP Content-type 头信息中发送正确的信息，如：
	// header("Content-type: image/jpeg");
    switch($src_type) {
        case 1 :
            $img_type = 'gif';
            break;
        case 2 :
            $img_type = 'jpeg';
            break;
        case 3 :
            $img_type = 'png';
            break;
        case 15 :
            $img_type = 'wbmp';
            break;
        default :
            return false;
    }

    if (!isset($width))
        $width = $src_w * ($height / $src_h);
    if (!isset($height))
        $height = $src_h * ($width / $src_w);

    $imagecreatefunc = 'imagecreatefrom' . $img_type;
    $src_img = $imagecreatefunc($src);
    $dest_img = imagecreatetruecolor($width, $height);
    imagecopyresampled($dest_img, $src_img, 0, 0, 0, 0, $width, $height, $src_w, $src_h);

    $imagefunc = 'image' . $img_type;
    if ($filename) {
        $imagefunc($dest_img, $filename);
    } else {
        header('Content-Type: ' . $src_mime);
        $imagefunc($dest_img);
    }
    imagedestroy($src_img);
    imagedestroy($dest_img);
    return true;
}


//查询一条  返回一位数组
function getOne($sql){
	global $conn;
	$res=mysqli_query($conn,$sql);
	return mysqli_fetch_assoc($res);
}

//查询多条  二维数组
function getAll($sql)
{
    global $conn;
    $res = mysqli_query($conn,$sql);
    $arr = array();
    while($row = mysqli_fetch_assoc($res))
    {
        $arr[] = $row;
    }

    return $arr;
}

//插入
function insert($table,$data)
{
	global $conn;

	$keys=array_keys($data);
	$fileds='`'.implode("`,`", $keys).'`';
	$values="'".implode("','",$data)."'";

	$sql="INSERT INTO $table($fileds)VALUES($values)";
	mysqli_query($conn,$sql);
	return mysqli_insert_id($conn);
}

//更新
function update($table,$data,$where){
	global $conn;
	$str = "";
	foreach($data as $key => $item){
		$str.= "`$key`='$item',";
	}
	$set=rtrim($str,",");
	$sql="UPDATE $table SET $set WHERE $where";
	mysqli_query($conn,$sql);
	return mysqli_affected_rows($conn);
}


//删除
function delete($table,$where=1){
	global $conn;
	$sql="DELETE FROM $table WHERE $where";
	mysqli_query($conn,$sql);
	return mysqli_affected_rows($conn);
}


function get_url(){
	$str = $_SERVER['PHP_SELF'].'?';
	if($_GET){
		foreach ($_GET as $k=>$v){  //$_GET['page']
			if($k!='page'){
				$str .= $k.'='.$v.'&';
			}
		}
	}
	return $str;
}

//分页函数
/**
 *@pargam $current	当前页
 *@pargam $count	记录总数
 *@pargam $limit	每页显示多少条
 *@pargam $size		中间显示多少条
 *@pargam $class	样式
*/
function page($current,$count,$limit,$size,$class='sabrosus'){
	$str='';
	if($count>$limit){
		$pages = ceil($count/$limit);//算出总页数
		$url = get_url();//获取当前页面的URL地址（包含参数）
		
		$str.='<div class="'.$class.'">';
		//开始
		if($current==1){
			$str.='<span class="disabled">首&nbsp;&nbsp;页</span>';
			$str.='<span class="disabled">  &lt;上一页 </span>';
		}else{
			$str.='<a href="'.$url.'page=1">首&nbsp;&nbsp;页 </a>';
			$str.='<a href="'.$url.'page='.($current-1).'">  &lt;上一页 </a>';
		}
		//中间
		//判断得出star与end
	    
		 if($current<=floor($size/2)){ //情况1
			$star=1;
			$end=$pages >$size ? $size : $pages; //看看他两谁小，取谁的
		 }else if($current>=$pages - floor($size/2)){ // 情况2
				 
			$star=$pages-$size+1<=0?1:$pages-$size+1; //避免出现负数
		
			$end=$pages;
		 }else{ //情况3
		 
			$d=floor($size/2);
			$star=$current-$d;
			$end=$current+$d;
		 }
	
		for($i=$star;$i<=$end;$i++){
			if($i==$current){
				$str.='<span class="current">'.$i.'</span>';	
			}else{
				$str.='<a href="'.$url.'page='.$i.'">'.$i.'</a>';
			}
		}
		//最后
		if($pages==$current){
			$str .='<span class="disabled">  下一页&gt; </span>';
			$str.='<span class="disabled">尾&nbsp;&nbsp;页  </span>';
		}else{
			$str.='<a href="'.$url.'page='.($current+1).'">下一页&gt; </a>';
			$str.='<a href="'.$url.'page='.$pages.'">尾&nbsp;&nbsp;页 </a>';
		}
		$str.='</div>';
	}
	
	return $str;
}

 ?>

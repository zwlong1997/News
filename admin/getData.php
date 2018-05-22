<?php
include('./includes/config.php');

//查询出所有的分类
$sql = "SELECT * FROM {$pre_}news_cate";
$cate_list = getAll($sql);

if(isset($_POST['news_cate_id']) && !empty($_POST['news_cate_id']))
{
    $news_cate_id = $_POST['news_cate_id'];
    $sql = "SELECT * FROM {$pre_}news_cate WHERE news_cate_id = $news_cate_id";
    $info = getOne($sql);
    $cate_name = $info['news_cate_name'];
    $str = file_get_contents("http://api.jisuapi.com/news/get?channel=$cate_name&start=0&num=10&appkey=038378d4d815d43a");
    $arr = json_decode($str,true);
    $list = $arr['result']['list'];
    $count = $arr['result']['num'];
    $num = 0;
    foreach($list as $item)
    {
        $arr = array(
            "news_title"=>$item['title'],
            "news_content"=>$item['content'],
            "news_time"=>strtotime($item['time']),
            "news_like"=>0,
            "news_cate_id"=>$news_cate_id,
        );

        if(!empty($item['pic']))
        {
            // $data = file_get_contents($item['pic']);
            $ext = PATHINFO($item['pic'],PATHINFO_EXTENSION);
            $name = PATHINFO($item['pic'],PATHINFO_FILENAME);
            $img = $name.mt_rand(11111,99999).".".$ext;
            file_put_contents("../static/uploads/$img",$item['pic']) && $arr['news_pic'] = "uploads/".$img;
        }

        insert("{$pre_}news",$arr) && $num++;
    }

    if($count == $num)
    {
      $res=array(
        "count"=>$count,
        "result"=>true
        );
      echo json_encode($res);
      exit;
    }else{
      $res=array(
        "count"=>$count,
        "result"=>false
        );
      echo json_encode($res);
      exit;
    }
  }
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>admin</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
    
    <link rel="stylesheet" type="text/css" href="stylesheets/theme.css">
    <link rel="stylesheet" href="lib/font-awesome/css/font-awesome.css">

    <script src="lib/jquery-1.7.2.min.js" type="text/javascript"></script>
  </head>

  <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
  <!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
  <!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
  <!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
  <!--[if (gt IE 9)|!(IE)]><!--> 
  <body> 
  <!--<![endif]-->
    
    <?php include('header.php');?>
    <?php include('menu.php');?>

    <div class="content">
        <div class="header">
            <h1 class="page-title">一键采集数据</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.php">首页</a> <span class="divider">/</span></li>
            <li class="active">一键采集数据</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
                <div class="btn-toolbar">
                    <button class="btn btn-primary"><i class="icon-list"></i> 数据选项</button>
                  <div class="btn-group">
                  </div>
                </div>

                <div class="well">
                    <div id="myTabContent" class="tab-content">
                      <div class="tab-pane active in" id="home">
                        <form action="#" method="post">
                            <label>文章分类</label>
                            <select name="news_cate_name" class="input-xlarge">
                              <option value="">请选择</option>
                              <?php foreach($cate_list as $item){?>
                              <option value="<?php echo $item['news_cate_id'];?>"><?php echo $item['news_cate_name'];?></option>
                              <?php }?>
                            </select>
                            <label></label>
                            <input class="btn btn-primary" type="button" value="提交" onclick="return getData()" />
                        </form>
                      </div>
                  </div>
                </div>
                
                <footer>
                    <hr>
                    <p>&copy; 2017 <a href="#" target="_blank">copyright</a></p>
                </footer>
                    
            </div>
        </div>
    </div>
  </body>
</html>
<script src="lib/bootstrap/js/bootstrap.js"></script>
<script>
    $("[rel=tooltip]").tooltip();
    $(function() {
        $('.demo-cancel-click').click(function(){return false;});
    });

    function getData()
    {
      var news_cate_id=$("select[name='news_cate_name']").val();
      if(news_cate_id)
      {
        $.ajax({
          url:'./getData.php',
          data:'news_cate_id='+news_cate_id,
          dataType:'json',
          type:'post',
          success:function(res){
            if(res.result)
            {
              alert('采集共'+res.count+'数据成功');
              location.href="index.php";
              return false;
            }else{
              alert('采集共数据失败');
              location.href="getData.php";
              return false;
            }
          }

        });
      }
    }


</script>
<?php 
  include('./includes/config.php');
  include('./check_admin.php');
  $page=isset($_GET['page']) ? $_GET['page'] : 1;

  $limit=4;

  $size=5;

  $sql="SELECT COUNT(*) AS c FROM {$pre_}news";
  $count=getOne($sql);
  $count_page=ceil($count['c']/$limit);

  $start=($page-1)*$limit;

  $page_str = page($page,$count['c'],$limit,$size); 

  $sql="SELECT * FROM {$pre_}news as news LEFT JOIN {$pre_}news_cate as news_cate ON news.news_cate_id = news_cate.news_cate_id LIMIT $start,$limit";
  $news_list=getAll($sql);

  // $str="";

  // if($page<=1){
  //   $str.="<li><a href='#'>上一页</a>";
  // }else{
  //   $str.="<li><a href='news_list.php?page=".($page-1)."'>上一页</a></li>";
  // }


  // for($i=1;$i<$count_page;$i++){
  //   if($page==$i){
  //     $str.="<li><span>$i</span></li>";
  //   }else{
  //     $str.="<li><a href='news_list.php?page=$i'>$i</li>";
  //   }
  // }

  // if($page>=$count_page){
  //   $str.="<li><a href='#'>下一页</a>";
  // }else{
  //   $str.="<li><a href='news_list.php?page=".($page+1)."'>上一页</a></li>";
  // }

  $delete_news =isset($_POST['delete_news']) ? $_POST['delete_news'] : 0;
  if($delete_news){
    $sql="SELECT news_img FROM {$pre_}news WHERE news_id = '$delete_news'";
    $result=implode(getOne($sql), "");
    $delete_img="../".$result;
    $affect_id=delete("{$pre_}news","news_id = $delete_news");
    unlink($delete_img);
    if($affect_id){
      show_msg("删除新闻成功","news_list.php");
      exit;
    }else{
      show_msg("删除新闻失败","news_list.php");
      exit;
    }
  }

    

 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>news</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    
    

    <link rel="stylesheet" type="text/css" href="stylesheets/theme.css">
    <link rel="stylesheet" href="lib/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/page.css">
    <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">


    <script src="lib/jquery-1.7.2.min.js" type="text/javascript"></script>

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
  <!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
  <!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
  <!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
  <!--[if (gt IE 9)|!(IE)]><!--> 
  <body> 
  <!--<![endif]-->
    
        
<?php include("header.php"); ?>
    
<?php include("menu.php"); ?>
    <div class="content">
        <div class="header">
            <h1 class="page-title">新闻列表</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.php">Home</a> <span class="divider">/</span></li>
            <li class="active">Index</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                <div class="btn-toolbar">
                    <button class="btn btn-primary" onClick="location='news_add.php'"><i class="icon-plus"></i>添加新闻</button>
                </div>
                <div class="well">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>新闻标题</th>
                          <th>新闻分类</th>
                          <th>时间</th>
                          <th>操作</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php foreach($news_list as $item){ ?>
                        <tr>
                          <td><?php echo $item['news_id'] ?></td>
                          <td><?php echo $item['news_title'] ?></td>
                          <td><?php echo $item['news_cate_name'] ?></td>
                          <td><?php echo date("Y-m-d",$item['news_time']); ?></td>
                          <td>
                              <a href="news_edit.php?news_id=<?php echo $item['news_id']; ?>"><i class="icon-pencil"></i></a>
                              <a onclick="delete_news(<?php echo $item['news_id'];?>)" href="#myModal" role="button" data-toggle="modal"><i class="icon-remove"></i></a>
                          </td>
                        </tr>
                      <?php } ?>
                        
                      </tbody>
                    </table>
                </div>
                <div class="pagination" style="text-align:center;">
                    <ul>
                        <?php echo $page_str ?>
                    </ul>
                </div>

                <form action="#" method="post">
                <div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Delete Confirmation</h3>
                    </div>
                    <div class="modal-body">
                        <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete the user?</p>
                    </div>
                    <input type="hidden" name="delete_news" value="">
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </div>
                </div>
                </form>

                <footer>
                    <hr>
                    <p>&copy; 2017 <a href="#" target="_blank">copyright</a></p>
                </footer> 
            </div>
        </div>
    </div>
    
    <script src="lib/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
         function delete_news(news_id)
        {
            if(news_id)
            {
                $("input[name='delete_news']").val(news_id);
            }
        }
    </script>
    
  </body>
</html>

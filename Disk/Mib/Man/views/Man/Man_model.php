<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="/A/bootstrap-3.2.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>


    <div class="container">


 <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">APP 接口管理</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="/Man/index">路由</a></li>
            <li><a href="/Man/doc">文档</a></li>
            <li class="active"><a href="/Man/model">模块</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

        <h1>&nbsp;</h1>
      <div class="starter-template">
        <h1>接口管理  </h1>
        <p class="lead">接口配置</p>
        
        
        <table class="table table-hover table-condensed" >
  <tr>
    <td colspan="4"><a class="model_add">添加新的模块</a></td>
    </tr>
    <tr>
      <td>v/m/a</td>
      <td>&nbsp;</td>
      <td width="160">&nbsp;</td><td width="190">操作</td>
    </tr>
<?php
foreach($rc as $key=>$value) {
?>
    <tr>

        <td><?php echo $value['v']?>/<?php echo $value['m']?>/<?php echo $value['a']?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>
        <a class="Model_del" rel="<?php echo $value['id']?>">删除</a></td>
    </tr>
<?php
}
?>


</table>
执行时间 <strong>{elapsed_time}</strong> 秒
      </div>

    </div><!-- /.container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/A/jquery-2.0.3.min.js"></script>
    <script src="/A/artDialog4.1.7/artDialog.js?skin=default"></script>
    <script src="/A/CK.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/A/bootstrap-3.2.0/js/bootstrap.min.js"></script>
	<script language="javascript">
    $(document).ready(function(e) {	 
        
		
        $('.model_add').click(function(){
            $.CK({
                rel:'model_add',
                url:'/Man/Model_add',
                _this:$(this),
                buttonok	: true,
                buttoncancel: true,
                });
        });

        $('.Model_del').click(function(){
					
			var res = $.ajax({
				url : '/Man/Model_del_exc',
				type: 'post',
				data: {
					id	: $(this).attr("rel"),
					},
				dataType: "json",
				async:false,
				cache:false
			}).responseJSON;
			//==========================1
			if(res.code<0){
				alert(res.msg);
				return false;
			}else{
				location.reload();
				return true;
			}				
				
        });
    
    });
    </script>

  </body>
</html>

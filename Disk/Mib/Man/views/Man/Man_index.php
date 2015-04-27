<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="/A/bootstrap-3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="/A/bootstrap-3.2.0/font.css" rel="stylesheet">


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
            <li class="active"><a href="/Man/index">路由</a></li>
            <li><a href="/Man/doc">文档</a></li>
            <li><a href="/Man/model">模块</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

        <h1>&nbsp;</h1>
      <div class="starter-template">
        <h1>接口管理  </h1>
       
<table class="table table-hover table-condensed table-striped table-bordered" >
<tr>
  <td>  
<a href="/Man/index/v1" type="button" class="btn btn-primary" <?php if($ver === 'v1' && $mm == ''){echo 'disabled';}?>>版本 v1</a>
<a href="/Man/index/v3" type="button" class="btn btn-primary" <?php if($ver === 'v3' && $mm == ''){echo 'disabled';}?>>版本 v3</a>
<a href="/Man/index/v5" type="button" class="btn btn-primary" <?php if($ver === 'v5' && $mm == ''){echo 'disabled';}?>>版本 v5</a>
</td>
</tr>
<tr>
  <td>模块 : 
<?php
foreach($ma as $key=>$value){
?>
<a href="/Man/index/<?php echo $ver;?>/<?php echo $key;?>" type="button" class="btn btn-default" <?php if($mm === $key){echo 'disabled';}?>><?php echo $key;?></a>
<?php
}
?>
</td>
</tr>

</table> 
       
       
        <table class="table table-hover table-condensed table-striped table-bordered" >
          <tr></tr>
          <tr>
            <td width="40">
            
            </td>
            <td><a class="apiaddnew">添加新的</a></td>
            <td width="350">映射</td>
            <td width="100">调试</td>
          </tr>
          <?php
foreach($rc as $key=>$value) {
?>
          <tr>
            <td><?php echo $value['id']?></td>
            <td><a class="viewdoc" rel=<?php echo $value['id']?>><?php echo $value['name']?></a></td>
            <td>[<?php echo $value['v']?>]<?php echo $value['api']?></td>
            <td> 
            <?php
            if($value['debug'] ==1){
			?>
            <a class="changedebug" rel=0 rid=<?php echo $value['id']?>><span class="glyphicon glyphicon-ok red"></span></a>
            <?php
			}else{
			?>
            <a class="changedebug" rel=1 rid=<?php echo $value['id']?>><span class="glyphicon glyphicon-remove-circle green" ></span></a>
            <?php
			}
			?>
&nbsp; 
            <a class="apiedit" rel="<?php echo $value['id']?>"><span class="glyphicon glyphicon-wrench yellow"></span></a>
			<?php echo $value['sort']?>
            </td>
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
        

		
		$('.changedebug').click(function(){
		
				var res = $.ajax({
					url : '/Man/changedebug/'+$(this).attr('rid')+'/'+$(this).attr('rel'),
					type: 'post',
					data: {},
					dataType: "json",
					async:false,
					cache:false
				}).responseText;
				//==========================1
				if(res.code<0){
					alert(res.msg);
					return false;
				}else{
					location.reload();
					return true;
				}				
					
		
		});

        $('.apiedit').click(function(){
            $.CK({
                rel:'apiedit',
                url:'/Man/edit/'+$(this).attr("rel"),
                _this:$(this),
                buttonok	: true,
                buttoncancel: true,
                });
        });
		
        $('.viewdoc').click(function(){
            $.CK({
                rel:'viewdoc',
                url:'/Man/Docview/'+$(this).attr('rel'),
                _this:$(this),
                buttonok	: false,
                buttoncancel: true,
                });
        });

        $('.apiaddnew').click(function(){
            $.CK({
                rel:'apiaddnew',
                url:'/Man/addnew',
                _this:$(this),
                buttonok	: true,
                buttoncancel: true,
                });
        });

    
    });
    </script>


















  </body>
</html>

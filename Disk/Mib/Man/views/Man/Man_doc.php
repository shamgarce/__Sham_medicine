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
            <li><a href="/Man/index">路由</a></li>
            <li class="active"><a href="/Man/doc">文档</a></li>
            <li><a href="/Man/model">模块</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

        <h1>&nbsp;</h1>
        <h1>文档管理  </h1>
<table class="table table-hover table-condensed table-striped table-bordered" >
<tr>
  <td>  <a href="/Man/doc/v1" type="button" class="btn btn-primary" <?php if($ver === 'v1' && $mm == ''){echo 'disabled';}?>>版本 v1</a>
  <a href="/Man/doc/v3" type="button" class="btn btn-primary" <?php if($ver === 'v3' && $mm == ''){echo 'disabled';}?>>版本 v3</a></td>
</tr>
<tr>
  <td>模块 : 
<?php
foreach($ma as $key=>$value){
?>
<a href="/Man/doc/<?php echo $ver;?>/<?php echo $key;?>" type="button" class="btn btn-default" <?php if($mm === $key){echo 'disabled';}?>><?php echo $key;?></a>
<?php
}
?>
</td>
</tr>

</table>
  
  
<p>&nbsp;</p>
<?php
foreach($rc as $key=>$value){
?>
<!--  recordone ------------->
<p><a data-toggle="collapse" href="#collapseExample<?php echo $value['id']?>" aria-expanded="false" aria-controls="collapseExample">
<?php echo $value['name']?> [<?php echo $value['api']?>]</a></p>
<div class="collapse" id="collapseExample<?php echo $value['id']?>">
    <div class="well row">
<!-- testone -->
<div class="col-md-6">
<div class="panel panel-danger">
    <div class="panel-heading">接口 : <?php echo $value['name']?></div>
    <div class="panel-body">
        
        <span class="label label-primary"> <?php echo $value['v']?></span>
        <?php if($value['debug'] ==1){?>
        <span class="label label-danger">debug</span>
        <?php }?>
        <?php if($value['enable'] ==0){?>
        <span class="label label-success">close</span>
        <?php }?>
        <?php if($value['ys'] =='r/s'){?>
        <span class="label label-info">r/s</span>
        <?php }?>
        <?php if($value['request'] =='' || $value['request'] =='{}'){?>
        <span class="label label-warning">get</span>
        <?php }?>

        <h4><span class="label label-primary">版本</span> : <?php echo $value['v']?></h4>
        <h4><span class="label label-primary">接口</span> : <?php echo $value['api']?></h4>
        <h4><span class="label label-primary">映射</span> : <?php echo $value['ys']?></h4>
        <h4><span class="label label-primary">调试</span> : <?php echo $value['debug']?></h4>
        <h4><span class="label label-primary">关闭</span> : <?php echo $value['enable']?></h4>
        <h4><span class="label label-primary">说明</span> : </h4>
        </p>
    <p><pre><?php echo $value['dis']?></pre></p>
    </div>
</div>
</div>

<div class="col-md-6">
<div class="panel panel-success">
    <div class="panel-heading">代码示例</div>
    <div class="panel-body">
    提交 : 
    <pre><?php echo $value['request']?></pre>
    返回 : 
    <pre><?php echo $value['response']?></pre>
    </div>
</div>
</div>  
    <!-- / testone -->
</div>
</div>
<!--  /recordone ------------->

<?php
}
?>





        
        
        
        
        
        
      <div class="starter-template">
      <hr>
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
        
		

    
    });
    </script>


















  </body>
</html>

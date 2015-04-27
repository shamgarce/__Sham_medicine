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
                    <li><a href="/V1es">首页</a></li>
                    <li><a href="/V1es/user">用户</a></li>
                    <li><a href="/V1es/danhao">抽样单号</a></li>
                    <li class="active"><a href="/V1es/guonei">国内</a></li>
                    <li><a href="/V1es/guowai">进口</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

        <h1>&nbsp;</h1>
      <div class="starter-template">
        <h1>单号管理  </h1>
        <table class="table table-hover table-condensed table-striped table-bordered" >
          <tr>
            <td width="40"></td>
            <td>&nbsp;</td>
            <td width="350">映射</td>
            <td width="100">调试</td>
          </tr>
          <tr>
            <td>31</td>
            <td>&nbsp;</td>
            <td>[v3]login</td>
            <td><a class="changedebug" rel=1 rid=31><span class="glyphicon glyphicon-remove-circle green" ></span></a> &nbsp; <a class="apiedit" rel="31"><span class="glyphicon glyphicon-wrench yellow"></span></a> 999 </td>
          </tr>
          <tr>
            <td>32</td>
            <td>&nbsp;</td>
            <td>[v3]register</td>
            <td><a class="changedebug" rel=1 rid=32><span class="glyphicon glyphicon-remove-circle green" ></span></a> &nbsp; <a class="apiedit" rel="32"><span class="glyphicon glyphicon-wrench yellow"></span></a> 999 </td>
          </tr>
          <tr>
            <td>33</td>
            <td>&nbsp;</td>
            <td>[v3]updateApp</td>
            <td><a class="changedebug" rel=1 rid=33><span class="glyphicon glyphicon-remove-circle green" ></span></a> &nbsp; <a class="apiedit" rel="33"><span class="glyphicon glyphicon-wrench yellow"></span></a> 999 </td>
          </tr>
          <tr>
            <td>35</td>
            <td>&nbsp;</td>
            <td>[v3]updateUserInfo</td>
            <td><a class="changedebug" rel=1 rid=35><span class="glyphicon glyphicon-remove-circle green" ></span></a> &nbsp; <a class="apiedit" rel="35"><span class="glyphicon glyphicon-wrench yellow"></span></a> 999 </td>
          </tr>
        </table>
执行时间 <strong>0.0312</strong> 秒
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
		
        

    
    });
    </script>

  </body>
</html>

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
<style>
body {
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #eee;
}

.form-signin {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  height: auto;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>

<div class="container">
<div class="form-signin">
<h2 class="form-signin-heading">用户登陆</h2>
<label class="sr-only" for="inputEmail">Email address</label>
<input id="inputEmail" class="form-control" type="text" autofocus="" required="" placeholder="用户名">

<label class="sr-only" for="inputPassword">Password</label>
<input id="inputPassword" class="form-control" type="password" required="" placeholder="密码">
<small class="red" id="showmsg">&nbsp;</small>
<button class="btn btn-lg btn-primary btn-block" id="denglu" type="submit">登陆</button>
</div>
</div>





    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/A/jquery-2.0.3.min.js"></script>
    <script src="/A/artDialog4.1.7/artDialog.js?skin=default"></script>
    <script src="/A/CK.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/A/bootstrap-3.2.0/js/bootstrap.min.js"></script>
	<script language="javascript">
    $(document).ready(function(e) {	 
		
		$('#denglu').click(function(){
		
		
				var res = $.ajax({
					url : '/V1es/login_excu/',
					type: 'post',
					data: {
						username 		: $('#inputEmail').val(),
						userpassword 	: $('#inputPassword').val(),
						},
					dataType: "json",
					async:false,
					cache:false
				}).responseJSON;
				//console.log(res);
				//==========================1
				$('#showmsg').html(res.msg);
				if(res.code<0){
					return false;
				}else{
					//location.reload();
					return true;
				}				
					
		
		});
    
    });
    </script>

  </body>
</html>

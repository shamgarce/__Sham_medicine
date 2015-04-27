<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
      业务逻辑库(library) &mdash; ECOS百科全书    </title>
<link rel="stylesheet" href="/_static/default.css" type="text/css" />

<link rel="stylesheet" href="/_static/pygments.css" type="text/css" />
<script type="text/javascript" src="/A/syntaxhighlighter_3.0.83/scripts/shCore.js"></script>
<script type="text/javascript" src="/A/syntaxhighlighter_3.0.83/scripts/shBrushJScript.js"></script>
<script type="text/javascript" src="/A/syntaxhighlighter_3.0.83/scripts/shBrushPhp.js"></script>
<link type="text/css" rel="stylesheet" href="/A/syntaxhighlighter_3.0.83/styles/shCoreDefault.css"/>
<script type="text/javascript">SyntaxHighlighter.all();</script>

  </head>
  <body>
  <!-- insert your head here -->
        <div class="related">
      <h3>导航</h3>
      <ul>
 <li class="right" style="margin-right: 10px">
          <a href="/Doc/index" title="总目录" accesskey="I">索引</a>
        </li>
        
        
        
        <?php if(get_cookie('set_addnew') == 1){?>
        <li class="right" >
        	<a calss="mbtest" id="vmanage_add">添加</a> |
        </li>
		<?php }?>
        <?php if(get_cookie('set_sort') == 1){?>
        <li class="right" >
        	<a calss="mbtest" relid="<?php echo $listid;?>" id="vmanage_sort">排序</a> |
        </li>
		<?php }?>
        
        
        <!-- li class="right" >
          <a href="outline.html" title="概述" accesskey="N">下一页</a> |
        </li --> 
        
        <li>
        	<a href="/Doc/">Easy</a> &raquo; 
        </li>
<?php
foreach($nav as $key=>$value){
	if($value['id'] != $listid){
?>
<li><a href="/Doc/index/<?php echo $value['id']; ?>"><?php echo $value['title']?></a> &raquo;</li>
<?php
	}else{
		?>
<li><a href="/Doc/nrview/<?php echo $value['id']; ?>"><?php echo $value['title']?></a> &raquo;</li>
		<?php
		}
}
?>
          </ul>
    </div>
    
    <div class="document">
      <div class="documentwrapper">
        <div class="bodywrapper">
          <div class="body">
            <h1><?php echo $mcmain['title']?>  <?php if(get_cookie('set_edit') == 1){?>
        <a class="aredit" relid=<?php echo $mcmain['id']; ?>><span style="font-size:11px;background-color:#006600;color:#DFC5A4;">编辑</span></a>
        <?php }?>
        </h1>
<?php echo $mcmain['content']?>

<?php
foreach($mc as $key=>$value){
?>
<h2><a name="id<?php echo $value['id']?>"><?php echo $value['title']?></a> <?php if(get_cookie('set_edit') == 1){?>
        <a class="aredit" relid=<?php echo $value['id']; ?>><span style="font-size:11px;background-color:#006600;color:#DFC5A4;">编辑</span></a>
        <?php }?></h2>
<?php 
echo $value['content'];
?>

<?php
}
?>

          </div>
        </div>
      </div>
      <div class="doczensidebar">
        <div class="doczensidebarwrapper">
          <h3><a href="/Doc/index">內容目录</a></h3>
          
<ul>
<?php
foreach($mc as $key=>$value){
?>
    <li><a href="#id<?php echo $value['id']?>" class="reference internal"><?php echo $value['title']?></a>
<?php
}
?>
</ul>
<!-- 
<h4>上一个主题</h4>
<p class="topless"><a href="index.html"
title="上一章">Ecos命名规则</a></p>
<h4>下一个主题</h4>
<p class="topless"><a href="model-conventions.html"
title="下一章">数据库表,数据库表定义文件及模型命名规则</a></p>
-->          
          <h3>快速搜索</h3>
<!--           <form method=get action="http://www.google.com.hk/search" target="_blank">
  <input type=text name=q>
  <input type=submit name=btnG value="搜索">

  <input type=hidden name=ie value="UTF-8">
  <input type=hidden name=oe value="UTF-8">
  <input type=hidden name=hl value="zh-CN">
  <input type=hidden name=domains value="www.ec-os.net">
  <input type=hidden name=sitesearch value="www.ec-os.net">
</form> -->
          <form action="http://www.baidu.com/baidu" target="_blank"> 
            <input type=text name=word> 
            <input type=submit value="搜索"> 
            <input name=ie type=hidden value="UTF-8">
            <input name=tn type=hidden value="baidu"> 
            <input name=cl type=hidden value="3"> 
            <input name=ct type=hidden value="2097152"> 
            <input name=si type=hidden value="www.ec-os.net"> 
          </form>
          <p class="searchtip" style="font-size: 90%">
          输入相关的模块，术语，类或者函数名称进行搜索
          </p>
        </div>
      </div>

      <div class="clearer"></div>
    </div>

        <div class="related">
      <h3>导航</h3>
      <ul>
        <li class="right" style="margin-right: 10px">
          <a href="/Doc/index" title="总目录" accesskey="I">索引</a>
        </li>
                <!-- li class="right" >
          <a href="outline.html" title="概述" accesskey="N">下一页</a> |
        </li -->
        
<li><a href="/Doc/">Easy</a> &raquo;</li>
<?php
foreach($nav as $key=>$value){
?>
<li><a href="/Doc/index/<?php echo $value['id']; ?>"><?php echo $value['title']?></a> &raquo;</li>
<?php
}
?>                </ul>
    </div>
        <div class="footer"></div>
<script src="/A/jquery-2.0.3.min.js"></script>
<script src="/A/artDialog4.1.7/artDialog.js?skin=default"></script>
<script src="/A/CK.js"></script>
<script src="/A/CommonIni.js"></script>





<script language="javascript">
    $(document).ready(function() {	
	KindEditor = null;


	$('.aredit').click(function(){
		 $.CK({
			rel:'aredit',
			url:'/Doc/vset_edit/'+$(this).attr("relid"),
			width:'500px',
			_this:$(this),
			buttonok	: true,
			buttoncancel: true,
			});
	});   

	 
	$('#vmanage').click(function(){
		 $.CK({
			rel:'vset',
			url:'/Doc/vset',
			width:'500px',
			_this:$(this),
			buttonok	: true,
			buttoncancel: true,
			});
	});   
	

	
	$('#vmanage_add').click(function(){
		 $.CK({
			rel:'vset_add',
			url:'/Doc/vset_addnew',
			width:'500px',
			_this:$(this),
			buttonok	: true,
			buttoncancel: true,
			});
	});   
	

	$('#vmanage_sort').click(function(){
		 $.CK({
			rel:'vmanage_sort',
			url:'/Doc/vset_sort/'+$(this).attr("relid"),
			width:'500px',
			_this:$(this),
			buttonok	: true,
			buttoncancel: true,
			});
	});   	
		
	});
</script>


  </body>
</html>

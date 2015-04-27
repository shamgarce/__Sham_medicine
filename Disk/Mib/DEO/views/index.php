<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>
    
    
<link rel="stylesheet" href="/_static/default.css" type="text/css" />
<link rel="stylesheet" href="/_static/pygments.css" type="text/css" />

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
?>
<li><a href="/Doc/index/<?php echo $value['id']; ?>"><?php echo $value['title']?></a> &raquo;</li>
<?php
}
?>
                      </ul>
    </div>
    
    <div class="document">
      <div class="documentwrapper">
        <div class="bodywrapper">
          <div class="body">
            <h1><?php echo $rc['title']; ?></h1>
            
<ul>
<?php
foreach($leaf['child'] as $key=>$value){
?>

	<?php
	if($value['_leaf'] !=1 && $value['_pure'] !=1){
    ?>
        <li><?php echo $TA[$value['titleonly']]; ?> <a href="/Doc/index/<?php echo $value['id']; ?>" class=""><?php echo $value['title']; ?></a>  
        <?php if(get_cookie('set_edit') == 1){?>
        <a class="aredit" relid=<?php echo $value['id']; ?>><span style="font-size:11px;background-color:#006600;color:#DFC5A4;">编辑</span></a>
        <?php }?>
	<?php
	}else{
    ?>
        <li><?php echo $TA[$value['titleonly']]; ?> <a href="/Doc/nrview/<?php echo $value['id']; ?>" class=""><?php echo $value['title']; ?></a>
        <?php if(get_cookie('set_edit') == 1){?>
        <a class="aredit" relid=<?php echo $value['id']; ?>><span style="font-size:11px;background-color:#006600;color:#DFC5A4;">编辑</span></a>
        <?php }?>
	<?php
	}
    ?>


	
	<?php
    if(!empty($value['child'])){
	?>
        <ul>
	    <?php
		foreach($value['child'] as $key2=>$value2){
		?>


			<?php
            if($value2['_leaf'] !=1 && $value2['_pure'] !=1){
            ?>
            <li><?php echo $TA[$value2['titleonly']]; ?> <a href="/Doc/index/<?php echo $value2['id']; ?>" class=""><?php echo $value2['title']; ?></a>
			<?php if(get_cookie('set_edit') == 1){?>
            <a class="aredit" relid=<?php echo $value2['id']; ?>><span style="font-size:11px;background-color:#006600;color:#DFC5A4;">编辑</span></a>
            <?php }?>

            <?php
            }else{
            ?>
            <li><?php echo $TA[$value2['titleonly']]; ?> <a href="/Doc/nrview/<?php echo $value2['preid']; ?>#id<?php echo $value2['id']; ?>" class=""><?php echo $value2['title']; ?></a>
			<?php if(get_cookie('set_edit') == 1){?>
            <a class="aredit" relid=<?php echo $value2['id']; ?>><span style="font-size:11px;background-color:#006600;color:#DFC5A4;">编辑</span></a>
            <?php }?>

            <?php
            }
            ?>

		<?php
		}
		?>
        </ul>
	<?php
	}
	?>
<?php
}
?>
</ul>
          </div>
        </div>
      </div>

      <div class="doczensidebar">
        <div class="doczensidebarwrapper">
          <h3><a href="/Doc/index">內容目录</a></h3>
          
<ul>
</ul>

<h4>下一个主题</h4>
<p class="topless"></p>
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
?>        
        
              </ul>
    </div>
        <div class="footer">
        <a calss="mbtest" id="vmanage">管理</a>
       </div>

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

<form id="__sort">
<table width="550" border="0" class="table table-">
  <?php
$count = count($rc);  
  
foreach($rc as $key=>$value){
?>

  <tr>
    <td><?php echo $value['title'];?></td>
    <td width="100">
        <input name="hsort[<?php echo $value['id'];?>]" type="text" id="textfield" value="<?php echo ($count - $key)*2 ?>" size="10" />
</td>
  </tr>
<?php
}
?>
  </table>
  </form>
<script type="text/dialog">
		
			
			
	
	this.opt = {				//确定按钮的点击
		ok:function(){
				var res = $.ajax({
				url : '/Doc/vset_sort_exc',
				type: 'post',
				data : $('#__sort').serialize(),			//重要偷懒的方法
				dataType: "json",
				async:false,
				cache:false
			}).responseJSON;
			//console.log(res);
			//==========================1
			if(res.code<0){
				alert(res.msg);
				return false;
			}else{
				location.reload();
				return true;
			}
			return true;
		},
		cancel:function(){},						//点击cancel按钮
		close:function(){},							//关闭对话框 不是回调
	}	
				
			

</script>
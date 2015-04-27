<table class="table" >
<tr>
<td valign="top"><table class="table table-bordered table-hover  table-condensed" >
  <tr>
    <td>排序 
      <input type="text" class="rowsort" id="textfield7" value="<?php echo $row['sort']?>" /></td>
  </tr>
  <tr>
    <td>接口映射<?php echo $row['id']?></td>
  </tr>
  <tr>
    <td>版本
      <input class="rowid" type="hidden" id="textfield" value="<?php echo $row['id']?>" />
      <input class="rowv" type="text" id="textfield" value="<?php echo $row['v']?>" /></td>
  </tr>
  <tr>
    <td>接口
      <input class="rowapi" type="text" id="textfield2" value="<?php echo $row['api']?>" size="60" /></td>
  </tr>
  <tr>
    <td valign="top">名称
      <input type="text" class="rowname" id="textfield5" value="<?php echo $row['name']?>" /></td>
  </tr>
  <tr>
    <td>映射
      <input type="text" class="rowys" id="textfield3" value="<?php echo $row['ys']?>" /></td>
  </tr>
  <tr>
    <td>调试 ：
      <input name="vsdebug" type="radio" class="debug" value="0" <?php if ($row['debug'] ==0 ) {echo 'checked="checked"';} ?>  />
      关闭
      <input type="radio" name="vsdebug" class="debug" value="1" <?php if ($row['debug'] ==1 ) {echo 'checked="checked"';} ?>/>
      开启</td>
  </tr>
  <tr>
    <td>关闭 ：
      <input type="radio" name="vsenable" class="enable" value="1" <?php if ($row['enable'] ==1 ) {echo 'checked="checked"';} ?> />
      有效
      <input type="radio" name="vsenable" class="enable" value="0" <?php if ($row['enable'] ==0 ) {echo 'checked="checked"';} ?>/>
      无效</td>
  </tr>
  <!-- tr>
  <td>默认 ：
    <input type="radio" name="radio" id="radio7" value="radio" />
    关闭
    <input type="radio" name="radio" id="radio5" value="radio" />
   200
    <input type="radio" name="radio" id="radio6" value="radio" />
 500</td>
</tr -->
</table></td>
<td><table class="table table-hover table-condensed" >
  <tr>
    <td valign="top">模拟提交：
      <br />      <textarea name="textfield3" cols="60" rows="6" class="rowrequest" id="textfield10"><?php echo $row['request']?></textarea></td>
  </tr>
  <tr>
    <td>模拟返回：
      <br />      <textarea name="textfield" cols="60" rows="6" class="rowresponse" id="textfield6"><?php echo $row['response']?></textarea></td>
  </tr>
  
  <tr>
    <td>
    <p>说明
        <br />
        <textarea name="textfield2" cols="60" rows="6" class="rowdis" id="textfield4"><?php echo $row['dis']?></textarea>
    </p>
    </td>
  </tr>
  
  
  <!-- tr>
  <td>默认 ：
    <input type="radio" name="radio" id="radio7" value="radio" />
    关闭
    <input type="radio" name="radio" id="radio5" value="radio" />
   200
    <input type="radio" name="radio" id="radio6" value="radio" />
 500</td>
</tr -->
</table></td>
</tr>
</table>
<script type="text/dialog">

this.opt = {				//确定按钮的点击
	ok:function(){
		
//var able = $("input[name='vsenable']:checked").val();
//alert(able);		
			var res = $.ajax({
			url : '/Man/edit_exec',
			type: 'post',
			data: {
				id 		: $('.rowid').val(),
				v 		: $('.rowv').val(),
				api 	: $('.rowapi').val(),
				ys 		: $('.rowys').val(),
				dis 	: $('.rowdis').val(),
				request 	: $('.rowrequest').val(),
				response 	: $('.rowresponse').val(),
				name 	: $('.rowname').val(),
				sort 	: $('.rowsort').val(),
				
				
				debug 	: $("input[name='vsdebug']:checked").val(),
				enable 	: $("input[name='vsenable']:checked").val(),
				
//$("input[@type=radio][@checked]").val();				
				},
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
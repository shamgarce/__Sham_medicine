<table class="table table-hover table-condensed" >
  <tr>
    <td valign="top"><table class="table table-hover table-condensed" >
      <tr>
        <td>接口映射</td>
      </tr>
      <tr>
        <td>版本 : 
          <input name="textfield3" type="text" class="addnew_v" value="v1" /></td>
      </tr>
      <tr>
        <td>接口 : 
          <input name="textfield2" type="text" class="addnew_api" size="50" /></td>
      </tr>
      <tr>
        <td>名称 : 
<input type="text" name="textfield6" class="addnew_ypiname" /></td>
      </tr>
      <tr>
        <td>映射 : 
          <input name="textfield" type="text" class="addnew_ys" value="r/s" />
          后台填写</td>
      </tr>
      <tr>
        <td>调试 : 
          <input name="vsdebug" type="radio" class="debug" value="0" />
关闭
<input name="vsdebug" type="radio" class="debug" value="1" checked="checked"/>
开启</td>
      </tr>
      <tr>
        <td>关闭 : 
          <input name="vsenable" type="radio" class="enable" value="1" checked="checked"/>
有效
<input type="radio" name="vsenable" class="enable" value="0"/>
无效</td>
      </tr>
    </table></td>
    <td><table class="table table-hover table-condensed" >
      <tr>
        <td>模拟提交<br />
          <textarea name="textfield7" cols="60" rows="6" class="addnew_apirequest"></textarea></td>
      </tr>
      <tr>
        <td>模拟回复<br />
          <textarea name="textfield7" cols="60" rows="6" class="addnew_apiresponse"></textarea></td>
      </tr>
      <tr>
        <td>说明<br />
          <textarea name="textfield7" cols="60" rows="6" class="addnew_dis">模块 :
说明 :
参数 :
成功 :
失败 :</textarea></td>
      </tr>
    </table></td>
  </tr>
</table>
<script type="text/dialog">

this.opt = {				//确定按钮的点击
	ok:function(){
			var res = $.ajax({
			url : '/Man/addnew_exc',
			type: 'post',
			data: {
				addnew_v 		: $('.addnew_v').val(),
				addnew_api 		: $('.addnew_api').val(),
				addnew_ys 		: $('.addnew_ys').val(),
				addnew_dis 		: $('.addnew_dis').val(),

				debug 	: $("input[name='vsdebug']:checked").val(),
				enable 	: $("input[name='vsenable']:checked").val(),

				addnew_ypiname 		: $('.addnew_ypiname').val(),
				addnew_apirequest 	: $('.addnew_apirequest').val(),
				addnew_apiresponse 	: $('.addnew_apiresponse').val(),
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
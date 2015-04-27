<table class="table table-hover table-condensed" >
    <tr>
        <td>添加新模块</td>
    </tr>
    <tr>
        <td><input type="text" name="textfield3" class="model_v"></td>
    </tr>
    <tr>
        <td><input name="textfield2" type="text" class="model_m" size="60"></td>
    </tr>

    <tr>
        <td><input type="text" name="textfield3" class="model_a"></td>
    </tr>
    <tr>
        <td>操作</td>
    </tr>
</table>


<script type="text/dialog">

this.opt = {				//确定按钮的点击
	ok:function(){
			var res = $.ajax({
			url : '/Man/Model_add_exe',
			type: 'post',
			data: {

				model_v 		: $('.model_v').val(),
				model_m 		: $('.model_m').val(),
				model_a 		: $('.model_a').val(),

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
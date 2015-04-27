<table width="750" border="0" cellspacing="1">
  <tr>
    <td>归属 : 
    <input name="textfield3" type="text" id="selectguishu" value="无" size="70" rel=0 /></td>
  </tr>
  <tr>
    <td>
    标题 : 
      <input name="textfield" type="text" id="addnew_articletitle" size="70" /></td>
  </tr>
  <tr>
    <td>标题模式 ： 
      <input type="checkbox" name="titleonly" id="titleonly" value="1"/>
    <label for="checkbox"></label></td>
  </tr>
  <tr>
    <td>内容 :<br />      <textarea id="editor_id" name="content" style="width:650px;height:300px;"></textarea></td>
  </tr>
  <tr>
    <td>URL :
      <br />      <textarea name="textfield2" cols="70" rows="5" id="addnew_url"></textarea></td>
  </tr>
</table>
<script type="text/dialog">

	
var editor2;
$.getScript('/A/kindeditor-4.1.10/kindeditor-min.js', function() {
	KindEditor.basePath = '/A/kindeditor-4.1.10/';
	editor = KindEditor.create('#editor_id',{
		resizeType : 1,
		allowPreviewEmoticons : false,
		allowImageUpload : true,
		allowFileManager : true,
		items : [
 'source', '|', 'undo', 'redo', '|', 'preview',  'template', 'code', 'cut', 'copy', 'paste',
'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage',
'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
'anchor', 'link', 'unlink', '|'	
		
		]
	});
});
	
			//bz_nr: editor.html(),
			
	 
        $('#selectguishu').click(function(){
			 $.CK({
                rel:'#selectguishu',
                url:'/Doc/vset_select',
				width:'500px',
                _this:$(this),
                buttonok	: true,
                buttoncancel: true,
                });
        });   			
			
			
	
	this.opt = {				//确定按钮的点击
		ok:function(){
				var res = $.ajax({
				url : '/Doc/vset_addnew_exc',
				type: 'post',
				data: {
					bguishu : $('#selectguishu').attr("rel"),
					btiaoti : $('#addnew_articletitle').val(),
					bnr 	: editor.html(),
					burl 	: $('#addnew_url').val(),
					titleonly 	: $("input[name='titleonly']:checked").val(),
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
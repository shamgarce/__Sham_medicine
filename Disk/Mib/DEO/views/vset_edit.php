<table width="750" border="0" cellspacing="1">
  <tr>
    <td>归属 : 
    <input name="textfield3" type="text" id="selectguishu" value="<?php echo $_rc[$rc['preid']]['title']?>" size="70" rel=<?php echo $rc['preid']?> />
    
<input name="textfield3" type="hidden" id="ssid" value="<?php echo $rc['id']?>" />
    
    
    
    </td>
  </tr>
  <tr>
    <td>
    标题 : 
      <input name="textfield" type="text" id="addnew_articletitle" value="<?php echo $rc['title']?>" size="70" />
      <input name="titleonly" type="checkbox" id="titleonly" value="1" <?php if($rc['titleonly'] ==1){?>checked="checked"<?php }?>/> 仅标题
     </td>
  </tr>
<?php if($rc['titleonly'] !=1){?>
  
  <tr>
    <td>内容 :<br />      <textarea id="editor_id" name="content" style="width:650px;height:300px;"><?php echo $rc['content']?></textarea></td>
  </tr>
  <tr>
    <td>URL :
      <br />      <textarea name="textfield2" cols="70" rows="5" id="addnew_url"><?php echo $rc['url']?></textarea></td>
  </tr>
<?php }?>    
  
</table>
<script type="text/dialog">

<?php if($rc['titleonly'] !=1){?>
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
<?php }?>    
	
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
				url : '/Doc/vset_edit_exc',
				type: 'post',
				data: {
					
					id 		: $('#ssid').val(),
					bguishu : $('#selectguishu').attr("rel"),
					btiaoti : $('#addnew_articletitle').val(),
					<?php if($rc['titleonly'] !=1){?>
					bnr 	: editor.html(),
					<?php }?>    
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
<?php unset($rc['_id']);?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">国外 ： 单号<?=$danhao?>  - <?php echo $rc['sampleDepartment']['sampleDate']?></h4>
</div>

<div class="modal-body">

  <img src="http://m.so/<?php echo $rc['PictureSrc']?>" class="img-responsive" alt="Responsive image">

      <table class="table">
        <tr>
          <td>节点</td>
          <td>节点</td>
          <td>值</td>
          <td>说明</td>
        </tr>   
<?php foreach($rc as $key=>$value){?>        
    <tr>
    <td><?=$key?></td>
    <td>&nbsp;</td>
    <td><?php if(!is_array($value))echo $value?></td>
    <td>&nbsp;</td>
    </tr>
    <?php if(is_array($value)){?>
    
			<?php foreach($value as $key2=>$value2){?>        
                <tr>
                <td></td>
                <td><?=$key2?></td>
                <td><?php if(!is_array($value2))echo $value2?></td>
                <td><span class="gray">描述</span></td>
                </tr>
            <?php }?>
	<?php }?>
<?php }?>
      </table>
      
<br>
<h4 class="modal-title">抽样情况</h4>
<br>

      <table class="table">
        <tr>
          <td>序号</td>
          <td>箱号</td>
          <td>第一份</td>
          <td>第二份</td>
          <td>第三份</td>
        </tr>
        <?php foreach($rc_con as $key=>$value){?>
        <tr>
          <td><?=$value['xuhao']?></td>
          <td><?=$value['xianghao']?></td>
          <td><?=$value['one']?></td>
          <td><?=$value['two']?></td>
          <td><?=$value['three']?></td>
        </tr>
        <?php }?>
  </table>
<br>
<h4 class="modal-title">抽样单位</h4>
<br>

      <table class="table">
        <tr>
          <td>序号</td>
          <td>密码</td>
          <td>经手人</td>
        </tr>
        <?php 
		foreach($rc_dep as $key=>$value){?>
        <tr>
          <td><?=$value['xuhao']?></td>
          <td><?=$value['mima']?></td>
          <td><?=$value['jingshouren']?></td>
        </tr>
        <?php }?>
  </table>
      <p>&nbsp;</p>
      
      
      
      
      
</div>

<div class="modal-footer">
    <!--button type="button" class="btn btn-white" data-dismiss="modal">Close</button -->
    <button type="button" class="btn btn-info"  data-dismiss="modal">关闭</button>
</div>



<script type="text/dialog">
</script>



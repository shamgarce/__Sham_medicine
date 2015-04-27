<table class="table table-hover table-condensed table-striped table-bordered" width="700px;" >

<?php

foreach($log as $key=>$value){
?>
<tr>
  <td>
  <?=$value['code']?>/<?=$value['info']?>/<?=$value['time']['timecu']?>/
  <br />
  <?=$value['mothod']?>/<?=$value['class']?>/
  
<?php if(!empty($value['_POST'])){?>
<br />	_POST : <?=$value['_POST']?>
<?php }?>


<?php if(!empty($value['_GET'])){?>
<br />	_GET :<?=$value['_GET']?>
<?php }?>

<?php if(!empty($value['sign'])){?>
<br />	sign :<?=$value['sign']?>
<?php }?>



  </td>
</tr>
<?php }?>


</table>



<ul>
    <li><input name="set_edit" type="checkbox" onClick="setc('set_edit')" <?php if(get_cookie('set_edit') == 1){?>checked="CHECKED"<?php }?>>      打开: 编辑
    <li><input type="checkbox" name="set_url" onClick="setc('set_url')" <?php if(get_cookie('set_url') == 1){?>checked="CHECKED"<?php }?>>      打开: 显示引用/资源地址 
    <li><input type="checkbox" name="set_sort" onClick="setc('set_sort')" <?php if(get_cookie('set_sort') == 1){?>checked="CHECKED"<?php }?>>      打开: 排序界面
    <li><input type="checkbox" name="set_addnew" onClick="setc('set_addnew')" <?php if(get_cookie('set_addnew') == 1){?>checked="CHECKED"<?php }?>>      打开: addnew
</ul>
<ul>
    <li>
    说明 : 文字模式 没有内容的 自动为标题 有内容的就不是标题了 所有内容都是标题和内容组成 
    另外还有一个url地址收集,内容上会有url相关地址,可以点过去检索,
    根据url地址获得信息,再次编辑,不断完善 内容也可以排序
    </li>
</ul>
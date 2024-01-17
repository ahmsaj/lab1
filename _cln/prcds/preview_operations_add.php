<? include("../../__sys/prcds/ajax_header.php");
?><div class="win_body"><?
if(isset($_POST['id'] , $_POST['p_id'] , $_POST['v_id'])){
	?><div class="form_body so"><?
	$id=pp($_POST['id']);
	$p_id=pp($_POST['p_id']);
	$v_id=pp($_POST['v_id']);	
	
	if($id!=0){
		$sql="select * from cln_x_pro_x_operations where id='$id' and doc='$thisUser'";
		$res=mysql_q($sql);
		if(mysql_n($res)>0){
			$r=mysql_f($res);
			$opration=$r['opration'];
			$hospital=$r['hospital'];
			$opr_date=$r['date'];
			$duration=$r['duration'];
			$price=$r['price'];
			$tools=$r['tools'];
		}else{out();}
	}
    $cData=getColumesData('ym8ku0n475',1);?>
    <form name="form_oper" id="form_oper" action="<?=$f_path?>X/cln_preview_operations_save.php" method="post" cb="operations([1]);getTopStatus('x',3);" bv="id">
    	<input type="hidden" value="<?=$id?>" name="id"/>
        <input type="hidden" value="<?=$v_id?>" name="v_id"/>
        <input type="hidden" value="<?=$p_id?>" name="p_id"/>
        <table class="fTable" cellpadding="0" cellspacing="0" border="0">
            <?=co_getFormInput(0,$cData['qrbonid0ch'],$opration,1);?>
			<?=co_getFormInput(0,$cData['r3d7penbgy'],$hospital,1);?>
            <tr><td n><?=k_oper_dat_tim?>:</td>
            <td i><input name="opr_date" type="text" class="DateTime" required value="<?=$opr_date?>" /></td></tr>
            
            <tr><td n><?=k_oper_dur?>:</td>
            <td i><input name="duration" type="text" class="DUR" value="<?=$duration?>" /></td></tr>
            
            <tr><td n><?=k_oper_cost?>:</td>
            <td i><input name="price" type="text" value="<?=$price?>" /></td></tr>			
            
           <!-- <tr><td n><?=k_oper_tools?>:</td>
            <td i>
            <div class="oprToolEdit f1" onclick="opr_tools()"><?=k_def_oper_tool?></div>
            <div id="opr_tools_d"><?=getTools($tools)?></div>         
            <input type="hidden" value="<?=$tools?>" id="otools" name="tools"/>
            </td></tr>-->
        </table>
        </form>
    </div>        
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info2')"><?=k_cancel?></div>
        <div class="bu bu_t1 fr" onclick="sub('form_oper')"><?=k_save?></div>            
    </div><?
}?>
</div>
<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['val'])){	
	$val=$_POST['val'];
	$pars=explode('|',$val);?>
	<div class="win_body">
	<div class="form_header">
	    <div class="lh40 clr1 fs18 fl f1"><?=k_ent_prp?></div>	
	</div>
	<div class="form_body so" >
        <table width="100%" border="0" cellspacing="0" type="static" cellpadding="4" class="grad_s" >
            <tr><td txt><?=k_table?></td><td dir="ltr"><?=tablesList('parent_table','coll',$pars[0])?></td></tr>
            <tr><td txt><?=k_val?> </td>
            <td><div link="coll" link_id="par_val" v dir="ltr"><?=columeList($pars[0],$pars[1],'par_val')?></div></td></tr>
            <tr><td txt><?=k_menu?></td>
            <td><div link="coll" link_id="par_txt" l dir="ltr"><?=columeList($pars[0],$pars[2],'par_txt')?></div></td></tr>		
            <tr><td txt><?=k_condition?></td><td dir="ltr"><input type="text" id="par_con" value="<?=$pars[4]?>"/></td></tr>		
        </table>
	</div>
	<div class="form_fot fr">
		<div class="bu bu_t1 fl" onclick="saveParentVals_a()"><?=k_end?></div>
		<div class="bu bu_t2 fr" onclick="win('close','#m_info')"><?=k_close?></div>
	</div>
	</div>
	<script>makeColumrName('coll_<?=$id?>')</script><?
}?>


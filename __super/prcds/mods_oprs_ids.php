<? include("../../__sys/prcds/ajax_header.php");
?><div class="win_body"><div class="form_body so"><?
if(isset($_POST['id']) &&  isset($_POST['val'])){
	$id=$_POST['id'];
	$val=$_POST['val'];
	if($val==''){$vals=array('','','','','','','');}else{$vals=explode(',',$val);}
	$texts=array(k_name,k_l_name,k_fth_name,k_mothr_name,k_plc_birth,k_birth_dat,k_nat_num);	
	$cData=getColumesData($id);$a=1?>
    <form name="idsWinForm" id="idsWinForm" action="<?=$f_path?>M/mods_oprs_ids_save.php" method="post">
    <input type="hidden" name="id" value="<?=$id?>"/>
    <table width="100%" border="0" class="fTable" cellspacing="0" cellpadding="0"><? 
	for($a=0;$a<count($texts);$a++){
		echo '<tr><td n>'.$texts[$a].':</td><td><select name="a'.$a.'"><option value="0">-------------</option>';
		foreach($cData as $data){
			$sel='';
			if(in_array($data[3],array(1,2))){
				if($vals[$a]==$data['c'])$sel=' selected ';
				echo '<option value="'.$data['c'].'" '.$sel.'>'.get_key($data[2]).'</option>'; 
			}
		}
		echo '</select></td></tr>';
    }?>
    </table>
	</form><?
}?>
</div>
<div class="form_fot fr">
    <div class="bu bu_t2 fr" onclick="win('close','#m_info')"><?=k_close?></div>
    <div class="bu bu_t3 fl" onclick="sub('idsWinForm')"><?=k_save?></div>
</div>
</div>
    
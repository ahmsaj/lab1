<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$v=array(0,0,0,0,0,0,0);
	$r=getRec('gnr_m_offers',$id);
	$perc=$pp=$cob='';
	$parts=array();
	$sett=$r['sett'];
	$type=$r['type'];
	if($sett){
		$s=explode('|',$sett);
		$perc=$s[0];		
		$parts=explode(',',$perc);
		$cob=$s[1];
		$cob_re=$s[2];
		if($cob_re){list($cob_s,$cob_e)=explode(',',$cob_re);}
	}?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18"><?=$r['name']?></div>
	<div class="form_body so">
	<form name="offerSet" id="offerSet" action="<?=$f_path?>X/gnr_offers_set_save.php" method="post" cb="loadModule('v1n0krhfvd') " bv="">
	<input type="hidden" value="<?=$id?>" name="id"/>
	
	<table class="fTable" cellpadding="0" cellspacing="0" border="0"><?
		if($type>2){
			foreach($clinicTypes as $k => $part){
				if($part){
					echo '<tr>
						<td n width="100">'.$part.' :</td>
						<td i><input type="number" name="p[]" value="'.$parts[$k-1].'" ></td>
					</tr>';
				}
			}
			if($type==5){
				echo '
				<tr><td n>'.k_coupons_num.': </td>
				<td i><input name="cob" value="'.$cob.'" type="number" ></td></tr>
				<tr><td n>'.k_start_num.' : </td>
				<td i><input name="cob_s" value="'.$cob_s.'" type="number" ></td></tr>
				<tr><td n>'.k_ending_num.' : </td>
				<td i><input name="cob_e" value="'.$cob_e.'" type="number" ></td></tr>';
			}
		}?>
	</table>
	</form>
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
		<div class="bu bu_t3 fl" onclick="saveOffSet()"><?=k_save?></div>
    </div>
    </div><?
}?>
<? include("../../__sys/prcds/ajax_header.php");?>
<div class="win_body">
<div class="form_header so lh40 clr1 f1 fs18"><?=k_choose_tube?></div>
<div class="form_body so cbg4"><?
$sql="select * from lab_m_samples_packages order by id ASC";
$res=mysql_q($sql);
while($r=mysql_f($res)){
	$id=$r['id'];
	echo '<div class="fl w100 lh40 bord cbgw mg5v Over" tube="'.$id.'">		
		<div class="fl">'.get_samlpViewC(0,$id).'</div>		
	</div>';
}
?>
</div>
<div class="form_fot fr">
	<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>     
</div>
</div>
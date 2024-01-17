<? include("../../__sys/prcds/ajax_header.php");?>
<div class="win_body">
	<div class="form_header" type="full"></div>
    <div class="form_body so"><?
 	$sql="select * from lab_m_services_templates order by id ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$name=$r['name'];
			$temp=$r['temp'];			
			echo '<div class="tamplist2" onclick="loadThisTemp(\''.$temp.'\')">'.$name.'</div>';
		}
	}else{
		echo '<div class="f1 fs14 clr5 lh40">'.k_nsvd_tmpt.'</div>';
	}?>
    </div>
    <div class="form_fot fr"><div class="bu bu_t2 fr" onclick="win('close','#m_info3');"><?=k_close?></div></div>
</div>
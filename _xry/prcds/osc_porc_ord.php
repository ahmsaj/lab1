<? include("../ajax/_ajax_header.php");
?><div class="win_body"><div class="form_body so" type="full">
<div class="oscWList"><?
if(isset($_POST['id'])){
	$id=$_POST['id'];
	$srv=get_val_c('xry_x_visits_services','id',$id,'visit_id');
	$sql="select * from xry_x_osc_report where vis='$id' order by ord ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$s_id=$r['id'];
			$report=$r['report'];
			$name=get_val('xry_m_osc_report','name_'.$lg,$report);
			$ord=$r['ord'];
			echo '<div class="f1 bu_t1 cbg1 lh40 clrw  mg10v fs16 TC" no="'.$s_id.'" ord="'.$ord.'"  >'.$name.'</div>';			
		}
	}else{
		echo '<div class="f1 fs18 lh40 clr5">'.k_no_proceds_to_ord.'</div>';
	}?>
    </div>
	</div>
	<div class="form_fot fr">
		<? if($rows){?>
			<div class="bu bu_t3 fl" onclick="saveOscOrd();"><?=k_save?></div>
		<? }?>
		<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_cancel?></div>
	</div>
</div>
<? }?>    
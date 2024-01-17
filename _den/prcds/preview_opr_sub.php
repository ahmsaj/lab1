<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('den_x_opr_teeth',$id);
	if($r['r']){
		$opr=$r['opr'];?>
		<div class="win_body">
		<div class="form_header so lh40 clr1 f1 fs18"><ff> <?=$r['teeth']?> | </ff><?=get_val('den_m_set_teeth','name_'.$lg,$opr)?></div>
		<div class="form_body so">
			<div class="f1 fs18 lh40 clr1111 uLine"><?=k_sub_stat_choose?></div><?
			 $sql ="select * from den_m_set_teeth_sub where act=1 and status_id='$opr' order by ord ASC";
			 $res=mysql_q($sql);
			 while($r=mysql_f($res)){
			 	echo '<div class="bu bu_t1" onclick="saveTeethOprSubDo('.$id.','.$r['id'].')">'.$r['name_'.$lg].'</div>';
			 }?>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>     
		</div>
		</div><?
	}
}?>
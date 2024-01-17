<? include("../header.php");
if(isset($_POST['vis'])){
	$id=pp($_POST['vis']);	
	$r2=getRecCon('cln_m_addons'," code='$giCode' and act=1" );
	$r=getRec('cln_x_visits',$id);
	if($r['r'] && $r2['r']){
		$color=$r2['color'];
		$name=$r2['name_'.$lg];
		$icon=$r2['icon'];
		$short_code=$r2['short_code'];
		$iconT='def';
		if($icon){$iconT=$icon;}
		$pay_type=$r['pay_type'];
		$vis_status=$r['status'];?>
		<div class="fl mp_list_tit" style="background-color:<?=$color?>;">			
			<div class="mp_list_tit_txt ff" style="background-image:url(../images/add/<?=$iconT?>.png);"><?=$name?></div>
			<div class=""></div>
		</div>
		<div class="fl w100 lh40 cbg444 b_bord f1" id="gi_ItTot"></div>
		<div class="fl ofx so pd10f prvTpmlist" id="gi_ItData" fix="hp:117|wp:0" actButt="act"></div><?
	}
}?>
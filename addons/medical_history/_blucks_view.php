<? include("../header.php");
if(isset($_POST['vis'],$_POST['pat'],$_POST['mood'],$_POST['code'])){
	$vis=pp($_POST['vis']);
	$pat=pp($_POST['pat']);
	$mood=pp($_POST['mood']);
	$code=pp($_POST['code'],'s');
	$rv=getRecCon('cln_x_visits'," id='$vis' and patient='$pat' and doctor='$thisUser'");
	$r=getRecCon('cln_x_addons_per'," user='$thisUser'");
	if($r['r']&& $rv['r']){
		$butt='عرض كافة البيانات ';
		$Xmood=2;
		$bClr='icc11';
		if($mood==2){$butt='عرض زياراتي فقط';$Xmood=1;$bClr='icc33';}
		list($sex,$birth)=get_val('gnr_m_patients','sex,birth_date',$pat);
		list($v_name,$type)=get_val('cln_m_vital','name_'.$lg.',type',$id);
		$birthCount=birthCount($birth);?>		
		<div class="lh40 clr1111 f1s fs14x"><?
		echo get_p_name($pat);
		echo ' <span class="clr1 f1 fs14 "> ( '.$sex_types[$sex]. ' ) </span>
		<ff class="clr55"> '.$birthCount[0].' </ff>
		<span class="clr55 f1 fs14 clr55"> '.$birthCount[1]. '</span>';?>
		</div>^<?
		$title=splitNo(get_val_con('cln_m_addons','name_'.$lg,"short_code='$code'"));
		echo '<div class="f1 fs16 clr1 lh40 uLine of" fix="h:50">
		<div class="fr ic30 '.$bClr.' ic30_info ic30Txt" mood="'.$Xmood.'" vCode="'.$code.'" >'.$butt.'</div>'.$title.'</div>
		<div class=" ofx so" fix="hp:60">'.showPartDet($vis,$pat,$mood,$code).'</div>';
	}
}
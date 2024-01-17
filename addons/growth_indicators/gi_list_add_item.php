<? include("../header.php");
if(isset($_POST['vis'],$_POST['pat'],$_POST['id'])){
	$vital=pp($_POST['id']);
	$vis=pp($_POST['vis']);
	$pat=pp($_POST['pat']);
	$act=pp($_POST['act']);
	$r=getRecCon('cln_x_visits'," id='$vis' and patient='$pat'");
	if($r['r']){	
		list($sex,$birth)=get_val('gnr_m_patients','sex,birth_date',$pat);			
		list($norVal,$norAdd,$v_type)=vitalNorVal($vital,$sex,$birth);
		$vnTxt=$val='';
		if($norVal){
			list($val,$clr,$vnTxt,$nv1,$nv2)=vsGetVal($v_type,$value,$norVal,$norAdd);
		}
		echo '<tr n="v'.$vital.'">
		<td class="f1">'.get_val('cln_m_vital','name_'.$lg,$vital).'</td>
		<td><input type="number" value="'.$val.'" name="vs_'.$vital.'" t="'.$v_type.'" nv1="'.$nv1.'" nv2="'.$nv2.'" vsIn set="0"/></td>
		<td>'.$vnTxt.'</td>
		<td><div class="i30 i30_del" vsDn="'.$vital.'" set="0"></div></td>
		</tr>';
	}
}?>
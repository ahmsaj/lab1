<? include("../header.php");
if(isset($_POST['vis'],$_POST['pat'],$_POST['id'])){
	$id=pp($_POST['id']);
	$vis=pp($_POST['vis']);
	$pat=pp($_POST['pat']);
	$r=getRecCon('cln_x_visits'," id='$vis' and patient='$pat'");
	if($r['r']){		
		$color=get_val_con('cln_m_addons','color',"code='ww0i5f8nzz'");
		list($sex,$birth)=get_val('gnr_m_patients','sex,birth_date',$pat);	
		$birthCount=birthCount($birth);
		$selectedVital=array();
		if($id){
			$r=getRec('cln_x_vital',$id);
			if($r['r']>0){
				$selectedV=get_vals('cln_x_vital_items','vital'," session_id='$id' ");
				$selectedVital=explode(',',$selectedV);	
				$id2=$id;
			}
			if($thisUser!=$r['doc']){exit; out();}
		}else{
			$id2=get_val_con('cln_x_vital','id'," patient ='$pat' and doc='$thisUser' "," order by date DESC" );
			if($id2){
				$selectedV=get_vals('cln_x_vital_items','vital'," session_id='$id2' ");
				$selectedVital=explode(',',$selectedV);	
			}
		}
		echo '<div class="f1 fs14 TC fs16 clr1111">أختر المؤشرات </div>^';
		$sql="select * from cln_m_vital where act=1 order by ord";
		$res=mysql_q($sql);
		while($r=mysql_f($res)){
			$v_id=$r['id'];
			$v_type=$r['type'];
			$name=$r['name_'.$lg];
			$h='';
			if(in_array($v_id,$selectedVital)){$h='hide';}
			$vital_normaVal=vitalNormaVal($v_id,$sex,$birth);
			$data='t="'.$v_type.'" ';
			if($vital_normaVal[0]){
				$data.='nv1="'.$vital_normaVal[1].'" ';
				$data.='nv2="'.$vital_normaVal[2].'" ';					
			}			
			echo '<div class="f1 fs14 TC '.$h.'" vs_but="'.$v_id.'" style="background-color:'.$color.';">'.$name.'</div>';
		}?>^
		<div class="lh40 clr1111 f1 fs14"><?
		echo get_p_name($pat);
		echo ' <span class="clr1 f1 fs14 "> ( '.$sex_types[$sex]. ' ) </span>
		<ff class="clr55"> '.$birthCount[0].' </ff>
		<span class="clr55 f1 fs14 clr55"> '.$birthCount[1]. '</span>';?>
		</div>^
		<div class="f1 clr1111 fs14 lh40">المؤشرات المختارة</div>
		<form name="vitalAdd" id="vitalAdd" action="<?=$addPathVs?>/vs_list_items_save.php" method="post" cb="vs_save_cb([1]);" bv="a" >
			<div class="f1 lh50">تاريخ مخصص : 
		<input fix="w:120|h:30" type="text" name="date" class="Date TC"/></div>
			<input type="hidden" name="id" value="<?=$id?>" />
			<input type="hidden" name="vis" value="<?=$vis?>" />
			<input type="hidden" name="pat" value="<?=$pat?>" />
			<table width="100%" border="0" cellspacing="5" cellpadding="4" class="vs_table f9" id="vs_table">
				<tr>
				<th>المؤشر</th>
				<th width="80">القيمة</th>
				<th>المعدل الطبيعي</th>
				<th width="30"></th>
				</tr><?
				$sql="select *from cln_x_vital_items where session_id ='$id2' order by id ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){						
					while($r=mysql_f($res)){
						$v_id=$r['id'];
						$vital=$r['vital'];
						$value=$nv1=$nv2='';
						if($id){$value=$r['value'];}
						$v_type=$r['v_type'];
						$norVal=$r['normal_val'];
						$norAdd=$r['add_value'];					

						if(!$id){list($norVal,$norAdd)=vitalNorVal($vital,$sex,$birth);}
						$vnTxt=$val='';
						if($norVal){
							list($value,$clr,$vnTxt,$nv1,$nv2)=vsGetVal($v_type,$value,$norVal,$norAdd);
						}
						echo '<tr n="v'.$vital.'">
						<td class="f1">'.get_val('cln_m_vital','name_'.$lg,$vital).'</td>
						<td><input type="number" value="'.$value.'" name="vs_'.$vital.'" t="'.$v_type.'" nv1="'.$nv1.'" nv2="'.$nv2.'" vsIn set="0"/></td>
						<td>'.$vnTxt.'</td>
						<td><div class="i30 i30_del" vsDn="'.$vital.'" set="0"></div></td>
						</tr>';						
					}
				}?>
			</table>
			<div class="ic40 ic40_save icc2 ic40Txt fl mg10v" vsSave><?=k_save?></div>
		</form><?
	}
}?>
<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['t'],$_POST['p'])){
	$id=pp($_POST['id']);
	$id2=$id;
	$type=pp($_POST['t']);
	$patient=pp($_POST['p']);
	list($sex,$birth)=get_val('gnr_m_patients','sex,birth_date',$patient);	
	$birthCount=birthCount($birth);
	$selectedVital=array();
	if($id){
		$r=getRec('cln_x_vital',$id);
		if($r['r']>0){
			$selectedV=get_vals('cln_x_vital_items','vital'," session_id='$id' ");
			$selectedVital=explode(',',$selectedV);			
		}
		if($thisUser!=$r['doc']){exit; out();}
	}else{
		$id2=get_val_con('cln_x_vital','id'," patient ='$patient' and doc='$thisUser' "," order by date DESC" );
		if($id2){
			$selectedV=get_vals('cln_x_vital_items','vital'," session_id='$id2' ");
			$selectedVital=explode(',',$selectedV);	
		}
	}?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18">
	<div class="fr ic40 icc1 ic40_ref" onclick="vatilSession(<?=$id?>,<?=$type?>,<?=$patient?>)"></div><?
		echo get_p_name($patient);
		echo ' [ <ff class="clr5"> '.$birthCount[0].' </ff> <span class="clr1 f1 fs18 clr5">'.$birthCount[1]. '</span> ] <span class="clr1 f1 fs18 "> [ '.$sex_types[$sex]. ' ] </span>';?>
	</div>
	<form name="vitalAdd" id="vitalAdd" action="<?=$f_path?>X/cln_vital_session_save.php" method="post" cb="loadVital(<?=$type?>);" bv="" >
		<input type="hidden" name="id" value="<?=$id?>" />
		<input type="hidden" name="t" value="<?=$type?>" />
		<input type="hidden" name="p" value="<?=$patient?>" />
	<div class="form_body of" type="pd0">
		<div class="r_bord fl" fix="w:225|hp:0">
			<div class="f1 fs18 lh50 clr11 uLine TC"><?=k_vital_signs?></div>
			<div class="ofx so vitslList pd10" fix="hp:60">
			<?		
			$sql="select * from cln_m_vital where act=1 order by ord";
			$res=mysql_q($sql);
			while($r=mysql_f($res)){
				$v_id=$r['id'];
				$v_type=$r['type'];
				$h='';
				if(in_array($v_id,$selectedVital)){$h='hide';}
				$vital_normaVal=vitalNormaVal($v_id,$sex,$birth);
				$data='t="'.$v_type.'" ';
				if($vital_normaVal[0]){
					$data.='nv1="'.$vital_normaVal[1].'" ';
					$data.='nv2="'.$vital_normaVal[2].'" ';					
				}
				
				echo script('v_nv_arr['.$v_id.']="'.addslashes($vital_normaVal[3]).'" ;');
				echo '<div class="f1 fs14 TC '.$h.'" n="'.$v_id.'" '.$data.' >'.$r['name_'.$lg].'</div>';
			}
			?>
			</div>
		</div>
		<div class="fl" fix="wp:225|hp:0">
			<div class="f1 fs18 lh50 clr11 uLine pd10"><?=k_date?> : <input class="Date" type="text" name="date" fix="w:200"/></div>
			<div class="ofx so pd10" fix="wp:0|hp:60">
				<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static" id="vital_table">
					<tr>
					<th><?=k_mark?></th>
					<th width="100"><?=k_val?></th>
					<th><?=k_norm_rate?></th>
					<th width="30"></th>
					</tr>
					<?
					$sql="select *from cln_x_vital_items where session_id ='$id2'  order by id ASC";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows){						
						while($r=mysql_f($res)){
							$v_id=$r['id'];
							$vital=$r['vital'];
							if($id){$value=$r['value'];}
							$type=$r['v_type'];
							$normal_val=$r['normal_val'];
							$add_value=$r['add_value'];
							$bg='#eee';
							$normal_val_text='';
							$nv1=$nv2='';							
							if($normal_val){
								$vital_normaVal=vitalNormaVal($vital,$sex,$birth);
								$normal_val_text=$vital_normaVal[3];
								$vvn=explode(',',$normal_val);
								if($type==1){									
									if($value>$vvn[1] && $value<$vvn[2]){
										$bg=$yClr;
									}else{
										$bg=$xClr;
									}
									if($vvn[0]==0){
										$normal_val_text='<span class="clr6"><ff> [ '.$vvn[1].' - '.$vvn[2].' ] </ff></span>';
									}else{							
										$normal_val_text='<span class="clr5"><ff>[ '.$vvn[0].'</ff><span class="clr6"><ff> [ '.$vvn[1].'</ff> - <ff>'.$vvn[2].' ] </ff></span><ff> '.$vvn[3].' ] </ff></span>';
									}
									$nv1=$vvn[1];
									$nv2=$vvn[2];
								}
								if($type==2){
									if($vvn[0]==0){if($value>$vvn[1]){$bg=$yClr;}else{$bg=$xClr;}}
									if($vvn[0]==1){if($value<$vvn[1]){$bg=$yClr;}else{$bg=$xClr;}}
									if($vvn[0]==2){if($value>=$vvn[1]){$bg=$yClr;}else{$bg=$xClr;}}
									if($vvn[0]==3){if($value<=$vvn[1]){$bg=$yClr;}else{$bg=$xClr;}}
									if($vvn[0]==4){if($value==$vvn[1]){$bg=$yClr;}else{$bg=$xClr;}}
									if($vvn[0]==5){if($value!=$vvn[1]){$bg=$yClr;}else{$bg=$xClr;}}
									$normal_val_text='<span class="clr6 f1 fs14">'.$vital_T2_types[$vvn[0]].' <ff>'.$vvn[1].'</ff></span>';
									$nv1=$vvn[0];
									$nv2=$vvn[1];
								}						
							}
							echo '<tr n="v'.$vital.'">
							<td class="f1 fs14">'.get_val('cln_m_vital','name_'.$lg,$vital).'</td>
							<td><input type="number" value="'.$value.'" name="vs_'.$vital.'" t="'.$type.'" nv1="'.$nv1.'" nv2="'.$nv2.'"/></td>
							<td>'.$normal_val_text.'</td>
							<td><div class="ic40 icc2 ic40_del" onclick="delValrow('.$vital.')"></div></td>
							</tr>';
							echo script('setVitalInput('.$vital.');');
						}
					}
					?>
				</table>
			</div>
		</div>
		</form>
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#full_win1');"><?=k_close?></div>
		<div class="bu bu_t3 fl" onclick="saveVitalVals(<?=$id?>);"><?=k_save?></div>
    </div>
    </div><?
}?>
<style>
	
</style>
<script>
	
</script>
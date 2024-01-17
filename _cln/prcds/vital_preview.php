<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['t'],$_POST['v'],$_POST['p'])){
	$type=pp($_POST['t']);
	$vis=pp($_POST['v']);
	$patient=pp($_POST['p']);	
	if($type==1){
		echo '<div class="f1 fs18 lh50 clr1 uLine">'.k_meas_sessions.'
		<div class="fr ic40 icc1 ic40_add mg5v" title="'.k_add_new_sess.'" onclick="vatilSession(0,'.$type.','.$patient.')"></div>';
		$GI=modPer('m30s6iicso',0);		
		if($GI){
			echo '<div class="fr bu bu_t4 buu mg5v" onclick="growthIndic('.$patient.')">'.k_grow_indicators.' </div>';
		}
		echo '</div>';
		$sql="select *from cln_x_vital where patient='$patient' order by date DESC limit 10";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		$vital_ids=array();
		$vital_data=array();
		if($rows>0){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s " type="static" over="0"><tr><th width="200"></th>';
			while($r=mysql_f($res)){				
				echo '<th class="Over"  onclick="sesView('.$r['id'].')"><ff>'.date('Y-m-d',$r['date']).'</ff></th>';
				array_push($vital_ids,$r['id']);
			}
			echo '</tr>';
			$vital_ids_x=implode(',',$vital_ids);
			$sql="select *from cln_x_vital_items where session_id IN($vital_ids_x) order by date DESC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			while($r=mysql_f($res)){
				$s_id=$r['session_id'];
				$vital=$r['vital'];
				$value=$r['value'];
				$v_type=$r['v_type'];
				$normal_val=$r['normal_val'];
				$add_value=$r['add_value'];
				
				$vital_data[$s_id][$vital]['v']=$value;				
				$vital_data[$s_id][$vital]['n']=$normal_val;
				$vital_data[$s_id][$vital]['a']=$add_value;
			}
			
			$sql="select *from cln_m_vital where act=1 order by ord ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);			
			while($r=mysql_f($res)){
				$vm_id=$r['id'];
				$name=$r['name_ar'];				
				$unit=$r['unit'];
				$type=$r['type'];				
				$equation=$r['equation'];
				$d_row='';
				$counter=0;
				foreach($vital_ids as $se){
					$vvv=$vital_data[$se][$vm_id]['v'];
					$vnor=$vital_data[$se][$vm_id]['n'];
					if($vvv){
						$counter++;
						$bg='#eee';
						if($vnor){
							$vvn=explode(',',$vnor);
							if($type==1){								
								if($vvv>$vvn[1] && $vvv<$vvn[2]){
									$bg=$yClr;
								}else{
									$bg=$xClr;
								}
							}
							if($type==2){
								if($vvn[0]==0){if($vvv>$vvn[1]){$bg=$yClr;}else{$bg=$xClr;}}
								if($vvn[0]==1){if($vvv<$vvn[1]){$bg=$yClr;}else{$bg=$xClr;}}
								if($vvn[0]==2){if($vvv>=$vvn[1]){$bg=$yClr;}else{$bg=$xClr;}}
								if($vvn[0]==3){if($vvv<=$vvn[1]){$bg=$yClr;}else{$bg=$xClr;}}
								if($vvn[0]==4){if($vvv==$vvn[1]){$bg=$yClr;}else{$bg=$xClr;}}
								if($vvn[0]==5){if($vvv!=$vvn[1]){$bg=$yClr;}else{$bg=$xClr;}}
							}
						}
					
					}else{$vvv='-'; $bg='';}
					$d_row.='<td style="background-color:'.$bg.'"><ff style="background-color:'.$bg.'">'.$vvv.'</ff></td>';
					
				}
				if($counter){
					echo '<tr>';
					echo '<th class="f1 Over cbg2" onclick="vitalChart('.$patient.','.$vm_id.',\''.$name.'\')">'.$name.'</th>'.$d_row;
					echo '</tr>';
				}
			}
			
			echo '</table>';
			
		}else{
			echo '<div class="f1 fs16">'.k_no_pre_meas_sess.' </div>';
		}
	}
	
}?>
<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('cln_x_vital',$id);
	if($r['r']){
		$doc=$r['doc'];
		$depart_type=$r['depart_type'];
		$patient=$r['patient'];
		list($sex,$birth)=get_val('gnr_m_patients','sex,birth_date',$patient);	
		$birthCount=birthCount($birth);
		?>
		<div class="win_body">
		<div class="form_header so lh40 clr1 f1 fs18"><?
			echo get_p_name($patient);
			echo ' [ <ff class="clr5"> '.$birthCount[0].' </ff> <span class="clr1 f1 fs18 clr5">'.$birthCount[1]. '</span> ] <span class="clr1 f1 fs18 "> [ '.$sex_types[$sex]. ' ] </span>';?>
		</div>
		<div class="form_body so">
			<div class="f1 fs16 clr11 lh40"><?=k_metered?> : <?=get_val('_users','name_'.$lg,$doc);?></div>
			<?
			$sql="select *from cln_x_vital_items where session_id ='$id'  order by id ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows){
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s " type="static" over="0">
				<tr><th>'.k_pointer.'</th><th>'.k_val.'</th><th>'.k_norm_rate.'</th></tr>';
				while($r=mysql_f($res)){				
					$vital=$r['vital'];
					$value=$r['value'];
					$type=$r['v_type'];
					$normal_val=$r['normal_val'];
					$add_value=$r['add_value'];
					$bg='#eee';
					$normal_val_text='';
					if($normal_val){
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
						}
						if($type==2){
							if($vvn[0]==0){if($value>$vvn[1]){$bg=$yClr;}else{$bg=$xClr;}}
							if($vvn[0]==1){if($value<$vvn[1]){$bg=$yClr;}else{$bg=$xClr;}}
							if($vvn[0]==2){if($value>=$vvn[1]){$bg=$yClr;}else{$bg=$xClr;}}
							if($vvn[0]==3){if($value<=$vvn[1]){$bg=$yClr;}else{$bg=$xClr;}}
							if($vvn[0]==4){if($value==$vvn[1]){$bg=$yClr;}else{$bg=$xClr;}}
							if($vvn[0]==5){if($value!=$vvn[1]){$bg=$yClr;}else{$bg=$xClr;}}
							$normal_val_text='<span class="clr6 f1 fs14">'.$vital_T2_types[$vvn[0]].' <ff>'.$vvn[1].'</ff></span>';
						}						
					}
					echo '<tr>
					<td class="f1 fs14">'.get_val('cln_m_vital','name_'.$lg,$vital).'</td>
					<td style="background-color:'.$bg.'"><ff>'.$value.'</ff></td>
					<td>'.$normal_val_text.'</td>
					</tr>';

				}
				echo '</table>';
			}?>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div><? if($doc==$thisUser){
				echo '<div class="bu bu_t1 fl" onclick="win(\'close\',\'#m_info\');
				vatilSession('.$id.','.$depart_type.','.$patient.');">'.k_edit.'</div>';
			}?>
		</div>
		</div><?
	}
}?>
<? include("../../__sys/prcds/ajax_header.php");
if(isset($_GET['type'] , $_GET['id'])){
	$type=pp($_GET['type']);
	$id=pp($_GET['id']);
	$thisCode=$type.'-'.$id;
	$pageSize='pp4';
	if($type==1){$titlee=k_report;}
	$style_file=styleFiles('P');?>
	<head><link rel="stylesheet" type="text/css" href="<?=$m_path.$style_file?>"></head>
	<body dir="<?=$l_dir?>">    
    <div class="<?=$pageSize?>">
		<div class="ppin"><?
			echo printHeader(4);		
			/**************************************************/		
			if($type==1){
				$r=getRec('osc_x_visits_services',$id);		
				if($r['r']){
					$id_no=convTolongNo($r['visit_id'],7);
					$thisCode='7-'.$id_no;
					$date=$r['d_start'];
					$patient=$r['patient'];
					$pat=get_p_name($r['patient'],3);

					echo '<div class="fl f1 fs16 lh40 ">'.k_med_report.'  ( '.get_val('osc_m_services','name_'.$lg,$r['service']).' ) </div>
					<div class="fr baarcode3 lh40 TC"><img src="'.$f_path.'bc/'.$thisCode.'"  style="margin-top:5px"/></div>
					<div class="cb  lh1">&nbsp;</div>';?>
					<div class="border2">
						<table width="100%" border ="0" cellpadding="5">
							<tr>
								<td class="f1 fs16"><?=k_patient_name?>  : <?=$pat[0].' | '.$sex_types[$pat[4]]?></td>
								<td class="f1 fs16" align="<?=$Xalign?>"><?=k_tdate_time?>  : <ff dir="ltr"><?=date('Y-m-d A h:i:s',$date)?></ff></td>
							</tr>
							<tr>
							<td class="f1 fs16" ><?=k_birth_dat?>  : <ff dir="ltr"><?=$pat[5]?></ff> | <?=$pat[1]?></td>
								<td class="f1 fs16" align="<?=$Xalign?>"><?=k_ref_from_dr?> :</td>
							</tr>
						</table>
					</div>
					<div class="f1 fs18 lh50 TC"><?=k_detal_rep?> </div>
					<div class="border2"><?
					$sql=" SELECT m.name_$lg , x.* FROM osc_m_report m , osc_x_report x where x.srv='$id' and x.report=m.id ORDER BY x.ord ASC";	
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){	
						echo '<table width="100%" class="table5" border="0" cellpadding="7" cellspacing="0">';
						while($r=mysql_f($res)){
							$r_id=$r['id'];
							$report=$r['report'];
							$report_txt=$r['name_'.$lg];
							$type=$r['report_type'];
							$val=$r['report_val'];					
							echo '<tr><td width="20%" valign="top" class="f1 fs14 lh30" >'.$report_txt.' :</td><td>';
							if($type==1 || $type==2){
								$valls=explode(',',$val);
								foreach($valls as $v){
									$report_val=get_val_arr('osc_m_report_items','name_'.$lg,$v,'repVal1');
									echo '<div class="f1 fs14 lh30 " >- '.splitNo($report_val).'</div>';
								}

							}
							if($type==3){
								echo '<div class="f1 fs14 lh30 uLine" >'.splitNo(nl2br($val)).'</div>';
							}
							echo '</td></tr>';
						}
						echo '</table>';			
					}

					?></div>
					<div class="cb  lh30">&nbsp;</div>
					<?
					$r2=getRec('osc_x_visits_services_add',$id);
					?>
					<div class="border2">
						<table width="100%" border ="0" cellpadding="5">
							<tr>
								<td class="f1 fs16 TC"><?=k_endoscopy_dr?>  </td>
								<td class="f1 fs16 TC" ><?=k_anesthesia_dr?> </td>					
							</tr>
							<tr>
								<td class="f1 fs14 TC"><?=get_val('_users','name_'.$lg,$r2['doc'])?></td>
								<td class="f1 fs14 TC" ><?=get_val('osc_m_team','name_'.$lg,$r2['tec_anesthesia'])?></td>
							</tr>
						</table>
					</div>
					<div class="cb  lh30">&nbsp;</div><?
				}
			}
			?>&nbsp;
		</div>
	</div>
    </body><?
}?>
<script>window.print();setTimeout(function(){window.close();},800);</script>
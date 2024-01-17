<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('lab_x_visits_requested',$id);
	?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18"><?=get_p_name($r['patient'])?></div>
	<div class="form_body so">
	<? if($r['r']){
		if($r['status']==1){
			$clinic=get_val_c('gnr_m_clinics','id',2,'type');
			$action="viSts(2,[1]);";?>	
			<form name="n_visit" id="n_visit" action="<?=$f_path?>X/gnr_visit_add_save.php" method="post" cb="<?=$action?>" bv="id">				
				<input type="hidden" name="c" value="<?=$clinic?>">
				<input type="hidden" name="p" value="<?=$r['patient']?>">
				<input type="hidden" name="vis" value="0">
				<input type="hidden" name="t" value="2">
				<input type="hidden" name="lab_req" value="<?=$id?>">

				<table width="100%" id="srvData" border="0" cellspacing="0" cellpadding="6" class="grad_s holdH" type="static">
				<th width="40"><?=k_emergency?></th><th><?=k_analysis?></th><th><?=k_type_sample?></th><th> <?=k_price?></th><?
				$anas=get_vals('lab_x_visits_requested_items','ana',"r_id='$id' and action=1 ");
				if($anas){
					$sql="select * from lab_m_services where id IN($anas)";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){
						$all_price=0;
						while($r=mysql_f($res)){
							$a_id=$r['id'];
							$con=$r['conditions'];
							$sample_type=$r['sample_type'];
							$time_req=$r['time_req'];
							$ch_sample=$r['ch_sample'];							
							$fast=$r['fast'];
							$short_name=$r['short_name'];
							$unit=$r['unit'];
							$price=$unit*_set_x6kmh3k9mh;
							$all_price+=$price;
							$consTxt='';
							$fastTxt='';
							if($ch_sample){
								$nn=make_Combo_box('lab_m_samples','name_'.$lg,'id','','s_'.$a_id,1,$sample_type,' t ');
							}else{
								$nn=get_val('lab_m_samples','name_'.$lg,$sample_type).'<input type="hidden" name="s_'.$a_id.'" value="'.$sample_type.'" />';
							}
							
							if($con){
								$sql="select * from lab_m_services_condition where id IN($con)";
								$res2=mysql_q($sql2);
								$rows2=mysql_n($res2);
								if($rows2>0){
									$cons='';		
									while($r2=mysql_f($res2)){
										$name=$r2['name_'.$lg];
										if($cons!='')$cons.=' | ';
										$cons.=$name;
									}
									$consTxt.='<div class="fa  f1 fs14 clr5">'.k_conditions.' : '.$cons.'</div>';
								}
							}

							if($fast){$fastTxt='<input type="checkbox" name="f_'.$a_id.'"/>';}
							echo'
							<tr>
							<input name="ser_'.$a_id.'" type="hidden" value="'.$price.'">
							<td>'.$fastTxt.'</td>
							<td class=" ff B fs18 lh30 ws">'.$short_name.$consTxt.'</td>
							<td class="f1 fs14">'.$nn.'</td>
							<td ><ff>'.number_format($price).'</ff></td>					
							</tr>';
						}
						echo'
                        <tr>							
                        <td colspan="3" class="fs16 f1">'.k_total.'</td>							
                        <td ><ff class="clr5">'.number_format($all_price).'</ff></td>					
                        </tr>';
					}
				}?>
				</table>
			</form><?
		}else{
			echo '<div class="f1 fs18 clr5 lh40">'.k_req_cant_complete.'</div>';
		}
	}else{
		echo '<div class="f1 fs18 clr5 lh40">'.k_no_req_num.'</div>';
	}?>
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
		<? if($rows>0){?><div class="bu bu_t3 fl " onclick="sub('n_visit');"><?=k_save?></div><?}?>
    </div>
    </div><?
}?>
<? include("../../__sys/prcds/ajax_header.php");
$apiTypesArr_in2=array('','Text','Date','boolean','Photo','Text','Text','Custom');
if(isset($_POST['n'] , $_POST['t'])){
	$n=pp($_POST['n']);
	$t=pp($_POST['t']);
	$q='';
	if($n!=999){$q=" and id='$n' ";}
	if($t==1 || $n==999){
		$sql="select content_$lg,title_$lg from api_pages where `show` =1 $q order by ord ASC";
		$res=mysql_q($sql);		
		while($r=mysql_f($res)){
			echo '<div class="f1 fs18 lh60 uLine">'.$r['title_'.$lg].'</div>';
			echo '<div class="f1 fs14 lh30" >'.$r['content_'.$lg].'</div>';
		}
	}
	if($t==0 || $n==999){
		if($n==1 || $n==999){
			$sql="select * from api_errors order by ord ASC";
			$res=mysql_q($sql);
			while($r=mysql_f($res)){			
				echo '<div class="f1 fs16 lh40 uLine" ><ff class="clr5 fs16 pd10" fix="w:80">'.$r['no'].' - </ff> '.$r['name_'.$lg].' </div>';
			}
		}
		if($n==2 || $n==999){
			$sql="select * from api_noti_list where act=1 order by ord ASC";
			$res=mysql_q($sql);
			while($r=mysql_f($res)){			
				/*echo '
				<div class="f1 fs16 lh40 " ><ff class="clr5 fs16 pd10" fix="w:80|ph:0">'.$r['no'].' - </ff> '.$r['name_'.$lg].' </div>
				<div class="f1 fs14 lh30 ">'.$r['body_'.$lg].'</div>
				<div class="f1 clr6 uLine"> ( '.$r['rec_'.$lg].' ) </div>';*/
				
				echo '
				<div class="fl w100 uLine">
					<div class="clr5 fs16 fl TC" fix="w:50|ph:0">'.$r['no'].'  </div>
					<div class="fl l_bord pd5">
						<div class="f1 fs16 lh30 ">'.$r['name_'.$lg].' </div>
						<div class="f1 fs14 lh30 ">'.$r['body_'.$lg].'</div>
						<div class="f1 clr6 lh20"> ( '.$r['rec_'.$lg].' ) </div>
					</div>
				</div>';
			}
		}
	}
	if($t==2 || $n==999){
		$pers=get_val('api_users','pers',$thisUser);
		$pers=str_replace(',',"','",$pers);
		$sql2="select * from api_module where code IN('$pers') $q order by ord ASC";
		$res2=mysql_q($sql2);
		$rows2=mysql_n($res2);
		if($rows2){
			while($r2=mysql_f($res2)){
				$n=$r2['id'];
				$code=$r2['code'];
				$mod=$r2['module'];
				$title=$r2['title_'.$lg];
				$des=$r2['des_'.$lg];
				$rpp=$r2['rpp'];
				$type=$r2['type'];
				$sub_type=$r2['sub_type'];
				$need_reg=$r2['need_reg'];
				$need_reg_temp=$r2['need_reg_temp'];

				$need_regTxt=k_no;
				$need_reg2Txt=k_no;
				if($need_reg){$need_regTxt=k_yes;}
				if($need_reg_temp){$need_reg2Txt=k_yes;}
				echo '<div class="f1 fs18 lh60 uLine">'.$title.'</div>
				<div class="f1 lh30 ">'.k_descraption.'  : '.$des.'</div>
				<div class="f1 lh30 ">'.k_request_type.' : POST</div>
				<div class="f1 lh30 ">'.k_procedure_code.' (mod) : <ff14 class="clr5">'.$code.'</ff14></div>
				<div class="f1 lh30 ">'.k_procedure_type.' : '.$apiTypesArr[$type].'  ( '.get_val('api_module_proce','name_'.$lg,$sub_type).' )</div>				
				<div class="f1 lh30 ">'.k_needs_pat_account.'  : <span class="f1 lh30 clr5">'.$need_regTxt.'</span></div>
				<div class="f1 lh30 ">'.k_needs_temporary_account.'  : <span class="f1 lh30 clr5">'.$need_reg2Txt.'</span></div>';
				if($sub_type==4){
					echo '<div class="f1 lh30">'.k_number_records_per_page.'  : <ff14 class="clr5">'.$rpp.'</ff14></div>';
				}
				?>
				<div class="f1 fs18 lh40 uLine clr1"><?=k_inputs?></div>
				<div class="f1 fs16 lh40"><?=k_url.' : '.$jurl?></div>
				<div class="f1 fs16 lh40"><?=k_head_pars?> :</div>
				<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >			
					<tr >				
						<th class="f1 fs14"><?=k_input?></th>
						<th class="f1 fs14"><?=k_descraption?></th>
						<th class="f1 fs14"><?=k_type?></th>							
						<th class="f1 fs14"><?=k_search?></th>
						<th class="f1 fs14"><?=k_req_fld?></th>
					</tr>
					<tr>					
						<td><ff class="clr55">user</ff></td>					
						<td class="f1">user name</ff></td>
					<td><ff>Text</ff></td>
					<td class="f1 "><?=$yn[0]?></td>
					<td class="f1"><?=$yn[1]?></td>
				</tr>
				<tr>					
					<td><ff class="clr55">uCode</ff></td>					
					<td class="f1">user code</ff></td>
					<td><ff>Text</ff></td>
					<td class="f1 "><?=$yn[0]?></td>
					<td class="f1"><?=$yn[1]?></td>
				</tr>
				<tr>					
					<td><ff class="clr55">mod</ff></td>					
					<td class="f1">Procedure Code</ff></td>
					<td><ff>Text</ff></td>
					<td class="f1"><?=$yn[0]?></td>
					<td class="f1"><?=$yn[1]?></td>
				</tr><?
				if($need_reg_temp || $need_reg){?>
					<tr>					
						<td><ff class="clr55">token</ff></td>					
						<td class="f1 fs14">token</ff></td>
						<td><ff>Text</ff></td>
						<td class="f1"><?=$yn[0]?></td>
						<td class="f1"><?=$yn[1]?></td>
					</tr><?
				}
				/*************************************/
				$sql="select * from api_modules_items_in where mod_id = '$n' and act=1 order by ord ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){
					while($r=mysql_f($res)){
						$in_name=$r['in_name'];
						$name=$r['name_'.$lg];
                        $note=$r['note_'.$lg];
						$type=$r['type'];
						$in_sub_type=$r['sub_type'];
						$search=$r['search'];				
						$requerd=$r['requerd'];
						$addValsIN='';
						if($type==6){							
							$in_sub_type=str_replace(':',' : ',$in_sub_type);
							$in_sub_type=str_replace('|',' , ',$in_sub_type);
							$addValsIN.=' <br>'.get_key($in_sub_type);
						}?>
						<tr>					
							<td><ff><?=$in_name?></ff></td>					
							<td class="f1 fs14"><?=$name.$addValsIN?>
                            <div class="f1 clr5 lh20"><?=$note?></div></td>
							<td><ff><?=$apiTypesArr_in2[$type]?></ff></td>
							<td class="f1 fs14"><?=$yn[$search]?></td>
							<td class="f1 fs14"><?=$yn[$requerd]?></td>
						</tr><?
					}
					
				}
				?></table><?
				/*************************************/
				echo '<div class="f1 fs18 lh40 uLine clr1">'.k_outputs.'</div>';
				echo '<div class="f1 fs14 lh30 uLine clr55">'.k_second_array.'</div>';
				if($sub_type==1 || $sub_type==2 || $sub_type==5){
					echo '<div class="f1 lh20"><ff>0 : </ff>'.k_record_number.'</div>';
				}				
				if($sub_type==3){
					echo '<div class="f1 lh20 clr1"><ff>0 : </ff>'.k_record_number.'</div>';
					echo '<div class="f1 lh20"><ff>1 : </ff>'.k_num_of_rec.'</div>';
				}
				if($sub_type==4){
					echo '<div class="f1 lh20"><ff>0 : </ff>'.k_page_no.'</div>';
					echo '<div class="f1 lh20"><ff>1 : </ff>'.k_num_of_rec.'</div>';
					echo '<div class="f1 lh20"><ff>2 : </ff>'.k_starts_record.' ???</div>';
					echo '<div class="f1 lh20"><ff>3 : </ff>'.k_ends_record_no.' ???</div>';
				}
				if($sub_type==6){
					if($code=='dt0s84elc5'){
						echo '<div class="f1 fs14"><ff>0 : </ff>'.k_link_status.'</div>';
						echo '<div class="f1 fs14"><ff>1 : </ff>'.k_token.'</div>';
					}
					if($code=='0nmf6rpgth'){
						echo '<div class="f1 lh20"><ff>0 : </ff>'.k_no_appoint_available.'</div>';
						echo '<div class="f1 lh20"><ff>1 : </ff>'.k_duration_appoint.'</div>';
						echo '<div class="f1 lh20"><ff>2 : </ff>'.k_clinic.'</div>';
						echo '<div class="f1 lh20"><ff>3 : </ff>'.k_doctor.'</div>';
					}
					if($code=='br4856vgwz'){
						echo '<div class="f1 lh20"><ff>0 : </ff>'.k_record_number.'</div>';
					}
					if($code=='02w0t5tzp5'){
						echo '<div class="f1 lh20"><ff>0 : </ff>'.k_record_number.'</div>';
					}
				}
							
				$sql="select * from api_modules_items_out where mod_id = '$n' and `show`=1 order by ord ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){
					echo '<div class="f1 fs14 lh40 uLine ">'.k_data.':</div>';?>
					<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >		
					<tr>				
						<th class="f1"><?=k_output?></th>
						<th class="f1"><?=k_details?></th>
						<th class="f1"><?=k_type?></th>							
					</tr><?
					while($r=mysql_f($res)){
						$out_name=$r['out_name'];
						$name=$r['name_'.$lg];
                        $note=$r['note_'.$lg];
						$type=$r['type'];
						$sub_type=$r['sub_type'];
						$addValsIN='';
						if($type==6){							
							$sub_type=str_replace(':',' : ',$sub_type);
							$sub_type=str_replace('|',' , ',$sub_type);
							$addValsIN.=' <br>'.get_key($sub_type);
						}?>
						<tr>					
							<td><ff><?=$out_name?></ff></td>					
							<td class="f1 fs14"><?=$name.$addValsIN?>
                            <div class="f1 clr5 lh20"><?=$note?></div></td>
							<td><ff><?=$apiTypesArr_in2[$type]?></ff></td>
						</tr><?
					}
					?></table><?
				}
			}
		}
	}
}?>
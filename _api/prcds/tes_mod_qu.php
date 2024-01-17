<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['mod'])){
	$outInfo='';
    //$_POST=$_POST['data'];
	$mod=pp($_POST['mod'],'s');
	$token=pp($_POST['token'],'s');
	$user=pp($_POST['user'],'s');
	$uCode=pp($_POST['uCode'],'s');	
	$page=pp($_POST['page']);
	$rec_id=pp($_POST['rec_id']);
	$data=array();
	$conect=1;
	$error=0;	
	$req_no=pp($_POST['req_no'],'s');
	$data[0]=array($req_no,$conect,$error);
	if(!$req_no){$req_no=0;}
	if(getTotalCO('_users',"un='$user' and code='$uCode' and grp_code='02ca6aal0r' and act=1")){
		$r=getRecCon('api_module'," code='$mod'");
		if($r['r']){
			$pat_id=0;
			$mod_id=$r['id'];
			$module=$r['module'];
			$type=$r['type'];
			$sub_type=$r['sub_type'];
			$need_reg=$r['need_reg'];
			$need_reg_temp=$r['need_reg_temp'];
			$mod_table=$r['table'];
			$conditions=$r['conditions'];
			$ref_col=$r['ref_col'];
			$rpp=$r['rpp'];
			if($rpp==0){$rpp=10;}
			$title=$r['title_ar'];			
			/******************************************/
			$dataSendet='<div class="lh40 f1 fs16 uLine TC">'.k_sent_data.'</div>
			<div dir="ltr">				
				<div class="lh20"><ff class="clr111">?</ff><ff class="clr1">user : </ff><ff class="clr6">'.$user.'</ff></div>
				<div class="lh20"><ff class="clr111">&</ff><ff class="clr1">uCode : </ff><ff class="clr6">'.$uCode.'</ff></div>
				<div class="lh20"><ff class="clr111">&</ff><ff class="clr1">mod : </ff><ff class="clr6">'.$mod.'</ff></div>'; 
			if($req_no){
				$dataSendet.='
				<div class="lh20"><ff class="clr111">&</ff><ff class="clr1">req_no : </ff><ff class="clr6">'.$req_no.'</ff></div>';
			}
			if($need_reg || $need_reg_temp){
				$dataSendet.='
				<div class="lh20"><ff class="clr111">&</ff><ff class="clr1">token : </ff><ff class="clr6">'.$token.'</ff></div>'; 
			}
			if($sub_type==2){				
				$dataSendet.='
				<div class="lh20"><ff class="clr111">&</ff><ff class="clr1">rec_id : </ff><ff class="clr6">'.$rec_id.'</ff></div>';
				
			}
			if($sub_type==3){
				if(($need_reg==0 && $need_reg_temp==0) || (($need_reg==1 || $need_reg_temp==1) && $ref_col!='id') ){
					$dataSendet.='
				<div class="lh20"><ff class="clr111">&</ff><ff class="clr1">rec_id : </ff><ff class="clr6">'.$rec_id.'</ff></div>';
				}
			}
			if($sub_type==4){
				$dataSendet.='
				<div class="lh20"><ff class="clr111">&</ff><ff class="clr1">page : </ff><ff class="clr6">'.$page.'</ff></div>'; 
			}     
			$res_in=mysql_q("select * from api_modules_items_in where mod_id='$mod_id' and `act`=1 order by ord ASC");
			$rows_in=mysql_n($res_in);
			$fillter='';
			if($rows_in){	
				while($r=mysql_f($res_in)){
					$inName=get_key($r['in_name']);
					$in_name=$r['in_name'];
					$star='';					
					if(isset($_POST[$in_name])){
						$inVal=pp($_POST[$in_name],'s');
						$colum=$r['colum'];
						$intype=$r['type'];
						$showVal=$inVal;
						if($intype==4){$showVal='';}
						$dataSendet.='
						<div class="lh20"><ff class="clr111">&</ff><ff class="clr1">'.$inName.' : </ff><ff class="clr6">'.$showVal.'</ff></div>';
						if($r['search'] && $inVal){
							if($fillter){$fillter.=" and ";}
							$fillter= " `$colum`= '$inVal' " ;
						}
					}
				}
			}
			$dataSendet.='</div>';
			/******************************************/
			list($eXdata,$obj,$error)=apidataObject($mod,2);
			if($error==0){
				if($eXdata){$data[1]=$eXdata;}
				if($obj){$data[2]=$obj;}
			}
		}
	}else{		
		$error=2;
	}
	if($error){$conect=0;}
	/******************************************/
	$data[0]=array($req_no,$conect,$error);
	$json=json_encode($data,JSON_UNESCAPED_UNICODE);
	//$json=str_replace(',','*',$json);
	/******************************************/
	$clrs=array('clr6','clr6');
	$msg1='<span class="f1 clr6"> | '.k_request_succes.' </span>';
	$msg2='<span class="f1 clr6"> | '.k_no_errors.' </span>';
	if($conect==0){$clrs[0]='clr5';$msg1='<span class="f1 clr5"> | '.k_there_error.'  </span>';}
	if($error!=0){$clrs[1]='clr5';$msg2='<span class="f1 clr5"> | '.get_val('api_errors','name_'.$lg,$error).' </span>';}
	$outInfo='<div class="f1 fs14 lh40 clr5 uLine">'.k_first_array.'</div>
	<div class="lh30 f1 ">'.k_request_no.'  : <ff14 class="clr6">'.$req_no.'</ff14></div>
	<div class="lh30 f1 ">'.k_result_request.' : <ff14 class="'.$clrs[0].'">'.$conect.'</ff14>'.$msg1.'</div>
	<div class="lh30 f1 uLine">'.k_error.' : <ff14 class="'.$clrs[1].'">'.$error.'</ff14>'.$msg2.'</div>';
	if($error==0){
		$outInfo.='<div class="f1 fs14 lh40 clr5 uLine">'.k_second_array.'</div>';
		if($sub_type==1 || $sub_type==2){
			$outInfo.='
			<div class="lh30 f1 ">'.k_record_number.' : <ff14 class="clr6">'.$eXdata[0].'</ff14></div>';
			if($mod=='4etvw21vfc'){
				if($eXdata[1]){$outInfo.='<div class="lh30 f1">'.k_visit_type.' : <ff class="clr6">'.$eXdata[1].'</ff></div>';}
				if($eXdata[2]){$outInfo.='<div class="lh30 f1">'.k_visit_num.' : <ff class="clr6">'.$eXdata[2].'</ff></div>';}
			}
			if($mod=='1oxi7bn088'){
				if($eXdata[1]){
                    $outInfo.='<div class="lh30 f1">'.k_mobile.' : <ff14 class="clr6">'.$eXdata[1].'</ff14></div>';
				    $outInfo.='<div class="lh30 f1">'.k_token.' : <ff14 class="clr6">'.$eXdata[2].'</ff14></div>';
                }
			}
			if($mod=='fy7hpfoewv'){
				if($eXdata[1]){$outInfo.='<div class="lh30 f1">'.k_token.' : <ff14 class="clr6">'.$eXdata[1].'</ff14></div>';}
			}
		}
		if($sub_type==3){
			$outInfo.='
			<div class="lh30 f1">'.k_record_number.' : <ff14 class="clr6">'.$eXdata[0].'</ff14></div>
			<div class="lh30 f1">'.k_num_of_rec.'  : <ff14 class="clr6">'.$eXdata[1].'</ff14></div>';
		}
		if($sub_type==4){
            if($mod=='r89ez2jnw8'){
                $outInfo.='
                <div class="lh30 f1">'.k_records_left.' : <ff14 class="clr6">'.$eXdata[0].'</ff14></div>
                <div class="lh30 f1">'.k_pointer.' : <ff14 class="clr6">'.$eXdata[1].'</ff14></div>       
                ';
            }else{
                $outInfo.='
                <div class="lh30 f1">'.k_page_no.' : <ff14 class="clr6">'.$eXdata[0].'</ff14></div>
                <div class="lh30 f1">'.k_num_of_rec.' : <ff14 class="clr6">'.$eXdata[1].'</ff14></div>
                <div class="lh30 f1">'.k_starts_record.' : <ff14 class="clr6">'.$eXdata[2].'</ff14></div>
                <div class="lh30 f1 uLine">'.k_ends_record_no.' : <ff14 class="clr6">'.$eXdata[3].'</ff14></div>';
            }
		}
		if($sub_type==6){
			if($mod=='dt0s84elc5'){				
				if($eXdata[0]==1){
					$outInfo.='<div class="lh30 f1">'.k_link_status.' : <span class="lh30 f1 clr6">'.k_successfully_linked.'</span></div>';
					$outInfo.='<div class="lh30 f1">'.k_token.' : <ff14 class="clr6">'.$eXdata[1].'</ff14></div>';
				}
			}
			if($mod=='0nmf6rpgth'){				
				if($eXdata[0]){					
					$outInfo.='<div class="lh30 f1">'.k_no_appoint_available.' : <ff14 class="clr6">'.$eXdata[0].'</ff14></div>';
					$outInfo.='<div class="lh30 f1">'.k_duration_appoint.' : <ff14 class="clr6">'.$eXdata[1].'</ff14></div>';
					$outInfo.='<div class="lh30 f1">'.k_clinic.' : <ff14 class="clr6">'.$eXdata[2].'</ff14></div>';
					$outInfo.='<div class="lh30 f1">'.k_doctor.' : <ff14 class="clr6">'.$eXdata[3].'</ff14></div>';
					
				}
			}
			if($mod=='br4856vgwz'){				
				if($eXdata[0]){					
					$outInfo.='<div class="lh30 f1">'.k_record_number.' : <ff14 class="clr6">'.$eXdata[0].'</ff14></div>';
				}
			}
			if($mod=='02w0t5tzp5'){				
				if($eXdata[0]){					
					$outInfo.='<div class="lh30 f1">'.k_record_number.' : <ff14 class="clr6">'.$eXdata[0].'</ff14></div>';
				}
			}
			if($mod=='33rlemvnl8'){				
				if($eXdata[1]==0){$msg=k_unregistered;}
				if($eXdata[1]==1){$msg=k_registered_patient;}
				if($eXdata[1]==2){$msg=k_registered_temp_user;}
				$outInfo.='<div class="lh30 f1">'.k_token_status.' : <ff14 class="clr6">'.$eXdata[1].' </ff14> | '.$msg.'</div>';
			}
			if($mod=='dlm92yifc9'){				
				if($eXdata[0]==0){$msg=k_unregistered;}
				if($eXdata[0]==1){$msg='غير محظور';}
				if($eXdata[0]==2){$msg='محظور';}
				$outInfo.='<div class="lh30 f1">'.k_status.' : <ff14 class="clr6">'.$eXdata[0].' </ff14> | '.$msg.'</div>';
			}
			if($mod=='g26ei7rtyf'){				
				if($eXdata[1]==0){$msg=k_unregistered;}
				if($eXdata[1]==1){$msg=k_registered_patient;}
				if($eXdata[1]==2){$msg=k_registered_temp_user;}
				$outInfo.='<div class="lh30 f1">'.k_email_status.' : <ff14 class="clr6">'.$eXdata[1].' </ff14> | '.$msg.'</div>';
			}
			if($mod=='k21len1in2'){				
				if($eXdata[0]){					
					$outInfo.='<div class="lh30 f1">'.k_token.' : <ff14 class="clr6">'.$eXdata[0].'</ff14></div>';
				}
			}
			if($mod=='xdcobwrf'){				
				if($eXdata[0]){					
					$outInfo.='<div class="lh30 f1">'.k_mobile.' : <ff14 class="clr6">'.$eXdata[0].'</ff14></div>';
				}
				if($eXdata[1]){					
					$outInfo.='<div class="lh30 f1">'.k_token.' : <ff14 class="clr6">'.$eXdata[1].'</ff14></div>';
				}
			}
			if($mod=='95kkqyhjr'){
				if($eXdata[0]){					
					$outInfo.='<div class="lh30 f1">'.k_mobile.' : <ff14 class="clr6">'.$eXdata[0].'</ff14></div>';
                    $outInfo.='<div class="lh30 f1">'.k_token.' : <ff14 class="clr6">'.$eXdata[1].'</ff14></div>';
				}
			}
			if($mod=='6hdhsb1y0r'){
				if($eXdata[0]){					
					$outInfo.='<div class="lh30 f1">'.k_mobile.' : <ff14 class="clr6">'.$eXdata[0].'</ff14></div>';
				}
			}
			if($mod=='cwkz3hao7z'){
				if($eXdata[0]){$outInfo.='<div class="lh30 f1">'.k_clinic.' : <ff14 class="clr6">'.$eXdata[0].'</ff14></div>';}
				if($eXdata[1]){$outInfo.='<div class="lh30 f1">'.k_drs.' : <ff14 class="clr6">'.$eXdata[1].'</ff14></div>';}
			}
			if($mod=='qatkkiejr'){
				if($eXdata[0]){$outInfo.='<div class="lh30 f1">'.k_email.' : <ff14 class="clr6">'.$eXdata[0].'</ff14></div>';}
				if($eXdata[1]){$outInfo.='<div class="lh30 f1">'.k_token.' : <ff14 class="clr6">'.$eXdata[1].'</ff14></div>';}
				if($eXdata[2]){					
					if($eXdata[2]==1){$msg=k_registered_patient;}
					if($eXdata[2]==2){$msg=k_registered_temp_user;}

					$outInfo.='<div class="lh30 f1">'.k_token.' : <ff14 class="clr6">'.$msg.'</ff14></div>';
				}
			}			
			if($mod=='hprdpyyscs'){
				if($eXdata[0]){					
					if($eXdata[0]==1){$msg=k_done_successfully;}									
					$outInfo.='<div class="lh30 f1">'.Res.' : <ff14 class="clr6">'.strip_tags($eXdata[0]).'</ff14></div>';
				}
			}
			if($mod=='62ggqe6t5t'){
				if($eXdata[0]!=''){					
					if($eXdata[0]==1){$msg=k_done_successfully;}
					if($eXdata[0]==0){$msg=k_cd_entd;}					
					$outInfo.='<div class="lh30 f1">'.k_token.' : <ff14 class="clr6">'.$msg.'</ff14></div>';
				}
			}
			if($mod=='yn4fp973uv'){
				//if($eXdata[0]!=''){				
					$outInfo.='<div class="lh30 f1">'.k_divices.' : <ff14 class="clr6">'.$eXdata[0].'</ff14></div>';
				//}
			}
			if($mod=='o29kxy0kkl'){
				//if($eXdata[0]!=''){				
					$outInfo.='<div class="lh30 f1">'.k_total.' : <ff14 class="clr6">'.$eXdata[0].'</ff14></div>';
				//}
			}
            if($mod=='qlc4ru6qfd'){								
				$outInfo.='<div class="lh30 f1">'.k_doctor.' : <ff14 class="clr6">'.$eXdata[0].'</ff14></div>';
			}
            if($mod=='rcepurhniu'){								
				$outInfo.='<div class="lh30 f1">'.k_setting.' : <ff14 class="clr6">'.$eXdata[0].'</ff14></div>';
			}
            if($mod=='wwi7u8xgog'){
                $outInfo.='<div class="lh30 f1">'.k_no.' : <ff14 class="clr6">'.$eXdata[0].'</ff14></div>';
            }
		}
		if($sub_type==7){
			if($mod=='155337qq98'){
				$outInfo.='			
				<div class="lh30 f1">'.k_num_of_rec.' : <ff14 class="clr6">'.$eXdata[0].'</ff14></div>
				</div>';				
			}
		}
	}
	
	$outInfo.='<form id="api_data_send" action="'.$jurl.'" method="post" target="blank">';
	if($need_reg || $need_reg_temp){$outInfo.='<input type="hidden" name="token" value="'.$token.'"/>';}
	$outInfo.='
	<input type="hidden" name="user" value="'.$user.'"/>	
	<input type="hidden" name="uCode" value="'.$uCode.'"/>
	<input type="hidden" name="mod" value="'.$mod.'"/>	
	<input type="hidden" name="req_no" value="'.$req_no.'"/>';
	if($sub_type==3){
		$outInfo.='<input type="hidden" name="rec_id" value="'.$rec_id.'"/>';
	}
	if($sub_type==4){
		$outInfo.='<input type="hidden" name="page" value="'.$page.'"/>';
	}
	if($sub_type==7){
		if($mod=='155337qq98'){
			$outInfo.='
			<input type="hidden" name="date" value="'.pp($_POST['date'],'s').'"/>
			<input type="hidden" name="doctor" value="'.pp($_POST['doctor']).'"/>
			<input type="hidden" name="clinic" value="'.pp($_POST['clinic']).'"/>';
		}
	}
	$res_set=mysql_q("select * from api_modules_items_in where mod_id='$mod_id' and `act`=1 order by ord ASC");
	$rows_set=mysql_n($res_set);			
	if($rows_set){	
		while($r=mysql_f($res_set)){
			$name=get_key($r['name_'.$lg]);
			$inName=$r['in_name'];
			$inVal=pp($_POST[$inName],'s');
			$outInfo.='<input type="hidden" name="'.$inName.'" value="'.$inVal.'"/>';
		}
	}
	$outInfo.='<div class="bu bu_t3" id="sendAPIData">'.k_send_actual_link.'</div>';
	$outInfo.='</form>';	
	/******************************************/
	//$outInfo=str_replace(',','*',$outInfo);
	echo $dataSendet.'^'.$outInfo.'^'.$json; 
	
}?>
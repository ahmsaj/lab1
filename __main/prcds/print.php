<? include("../../__sys/prcds/ajax_header.php");
if(isset($_GET['type'] , $_GET['id'])){
	$type=pp($_GET['type']);
	$id=pp($_GET['id']);//prescription id
	$pars=pp($_GET['par'],'s');
	$thisCode=$type.'-'.$id;
	$address=_info_477lvyxqhi;//f
	$mailBox=_info_sozi33uok5;//nf
	$fax=_info_1gw3l8c7m3;//nf
	$website=_info_npjhwjnbsh;//nf
	$email=_info_lktpmrxb64;//nf
	$phone=_info_r9a7vy4d6n;///f
	$head_ph=_set_50wxlrujf;///nf
    $head_hi=_set_76nyqowzwb;
    $thisDoctor=$thisUser;
    $pageSize='prnit_med_page5';
    if($type==1 || $type==7){
        $pageSize='prnit_med_page';
        $head_ph=_set_f4uxc868xc;///nf
        $head_hi=3.5;
    }
    if($head_ph){
        $head_banner='';
        $image=getImages($head_ph);
        $file=$image[0]['file'];
        $folder=$image[0]['folder'];        
        $fullfile=$m_path.'upi/'.$folder.$file;
        if(file_exists("../../sData/".$folder.$file)){
            $head_banner= '<img src="'.$fullfile.'" width="100%" />';
        }
    }
    $patient=0;
	if($type<7){		
//		($type==1){$v_id=$id;}
        /*****header*********/
        $document_date=$now;
		if($type==2){
			if(_set_9jfawiejb9==1){
				list($v_id,$patient,$document_date)=get_val('lab_x_visits_requested','visit_id,patient,date',$id);                
			}else{
				list($v_id,$patient,$document_date)=get_val('cln_x_pro_analy','v_id,p_id,date',$id);                
			}
		}
		if($type==3){list($v_id,$patient,$document_date)=get_val('xry_x_visits_requested','visit_id,patient,date',$id);}
		if($type==4){$v_id=$id;}
		if($type==5){$v_id=get_val('cln_x_pro_referral','v_id',$id);}
		if($type==6){$v_id=get_val('cln_x_pro_x_operations','v_id',$id);}
		if($type==1){			
			list($doc,$patient)=get_val('gnr_x_prescription','doc,patient',$id);
		}else{
			$doc=get_val('cln_x_visits','doctor',$v_id);
		}
        if($patient==0){$patient=get_val('cln_x_visits','patient',$v_id);}
		$doc_name=get_val('_users','name_'.$lg,$doc);
		$sex=get_val('gnr_m_patients','sex',$patient);
		if($sex==1){$p_sex_word1=k_patient;}else{$p_sex_word1=k_s_patient;}		
			
		//if($thisUser==$doc){        
        
        
        switch ($type){
            case 1:$pageType=k_precpiction;break;
            case 2:$pageType=k_test_req;break;				
            case 3:$pageType=k_med_ima_request;break;
            case 4:$pageType=k_med_report;break;
            case 5:$pageType=k_referral;break;
            case 6:$pageType=k_ref_to_oper;break;
        }	
        $patient_name=get_p_name($patient);
        $style_file=styleFiles('P');?><head><link rel="stylesheet" type="text/css" href="<?=$m_path.$style_file?>"></head>

        <body dir="<?=$l_dir?>">
            <div class="<?=$pageSize?>">
                <div class="pmp_head" style="height:<?=$head_hi?>cm "><?=$head_banner?></div>
                <div class="pmp_info b_bord">                    
                    <table class="infoTable" border="0" cellpadding="0" cellspacing="0">
                        <? if($type==1){?>                   
                            <tr>
                                <td>
                                    <div class="f1 fs14"><?=$p_sex_word1?> <?=$patient_name?></div>
                                    <div class="f2 fs12 fl"><?=getPatAge($patient)?> - <?=$sex_types[$sex]?></div>
                                    <div class="ff B fs16 fr" dir="ltr"><?=date('Y/m/d',$document_date)?></div>
                                </td>
                                <td class="f1 fs14 rx_logo" rowspan="2"></td>
                            </tr>
                        <?}else{?>
                            <tr>
                                <td class="f1 fs18"><?=$pageType?></td>
                                <td class="ff B fs16" dir="ltr"><?=date('Y/m/d',$document_date)?></td>
                            </tr>
                            <tr>
                                <td class="f1 fs14"><?=$p_sex_word1?> <?=$patient_name?> <?=getPatAge($patient)?></td>
                                <td></td>
                            </tr>
                        <? }?>
                    </table>
                </div>
                
                <div class="pmp_data"><?
                    if($type==1){
                        list($thisDoctor,$diagnosis)=get_val('gnr_x_prescription','doc,complaint_txt',$id);
                        echo getMdcList($id,1);
                    }else{
                        if($type==2){
                            $diagnosis=get_vals('lab_x_visits_requested','diagnosis',"id=$id");
                            if($diagnosis){
                               echo '<div class="f1 lh30 pd5f"">'.k_diagnoses.': '.$diagnosis.'</div>';
                            }
                        }
                        if($type==3){
                            $diagnosis=get_vals('xry_x_visits_requested','diagnosis',"id=$id");
                            if($diagnosis){
                               echo '<div class="f1 lh30 pd5f"">'.k_diagnoses.': '.$diagnosis.'</div>';
                            }
                        }?>
                        <div style="padding-top:0.1cm"><?
                            if($type==2){
                                echo getAnaList($id,1);                            
                                if(_set_9jfawiejb9==1){
                                    $thisDoctor=get_val('lab_x_visits_requested','doc',$id);
                                }
                            }
                            if($type==3){
                                echo getXpList($id,$pars,1);
                                if(_set_9jfawiejb9==1){
                                    $thisDoctor=get_val('xry_x_visits_requested','doc',$id);
                                }
                            }
                            if($type==4){echo '<div class="sel_mdc_p f1" style="line-height:18px;">'.nl2br(get_val('cln_x_visits','report',$id)).'</div>';}
                            if($type==5){echo getAssi($id);}
                            if($type==6){echo getOpration($id);}?>								
                        </div>

                    <? }
                    
                    $info_doc=presc_info_doctor($thisDoctor);
                    echo '
                    <div class="doctor_sign">
                        <div class="f1 fs12 TC">'.$info_doc['name'].'</div>
                        <div class="f2 fs12 TC">'.nl2br($info_doc['specialization']).'</div>                        
                        <ff class="fs12 TC">'.$info_doc['mobile'].'</ff>
                    </div>'?>
                </div>
                <div class="pmp_footer f2">
                    <?
                    if(_set_xubr8mskw9 && $type==1){
                         $out.='<div class="p_footer_presc cb fs12 TC lh20 f2" sheet_foot>'.nl2br(_set_xubr8mskw9).'</div>';
                    }else if(_set_ply0ipnzod && $type==2){                    
                         $out.='<div class="p_footer_presc cb TC lh20 fs12 f2" sheet_foot>'.nl2br(_set_ply0ipnzod).'</div>';
                    }else if(_set_rsl9opwx0x){
                        $footData=array();
                        array_push($footData,_info_7dvjz4qg9g);
                        if($address){array_push($footData,'العنوان: '.$address);}
                        if($mailBox){array_push($footData,'صندوق بريد:'.$mailBox);}
                        if($phone){array_push($footData,'الهاتف: '.$phone);} 
                        if($fax){array_push($footData,'فاكس: '.$fax);}
                        if($email){array_push($footData,'البريد الإلكتروني: '.$email);}
                        if($website){array_push($footData,'الموقع الالكتروني: '.$website);}
                        $out.='<div class="p_footer_presc cb fs14 TC lh20 fs14" sheet_foot >
                        '.implode(' - ',$footData).'</div>';
                    }
                    echo $out;?>
                </div>
            </div>
        </body><?
		//}
	}
	if($type==7){
		$rec=getRec('gnr_x_prescription',$id);
		$v_id=$rec['visit'];
		$p_id=$rec['patient'];
		$doc=$rec['doc'];
		$p_note=$rec['note'];
		$sex=get_val('gnr_m_patients','sex',$p_id);
		if($sex==1){$p_sex_word1='المريض';}else{$p_sex_word1='المريضة';}	
		$thisCode='36-'.$id;
		$pageType=k_precpiction;?>
		<head>
			<link rel="stylesheet" type="text/css" href="<?=$m_path?>printCSS<?=$l_dir[0]?>M.css">
			<link rel="stylesheet" type="text/css" href="<?=$m_path?>_phr/css/style_p.php?d=<?=$l_dir?>">
		</head>
		<body dir="ltr">
			<div class="print_page_presc">             
				<?=presc_printed_page($p_sex_word1,$id,$p_id,$thisCode,$doc,$v_id,$p_note)?>
			</div>
		</body>
<?
	}
}?>
<script>window.print(); setTimeout(function () { window.close(); }, 1000); </script>
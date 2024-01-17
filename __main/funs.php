<?
function indexStartFuns(){
    resetRles();loadTodayDates();//fixVisitS();    
    //$url=createPayment(3,1,2,5000);
    //echo '('.mtn_createPayment(3,1,1,1000).')';
}
function getCustomFiled($rec,$val){
    $id=$rec['id'];
	global $mod_data;
	switch ($val){				
		/**************GNR*************************************/
		case 'p_name':return get_p_name($id);break;		
		case 'clinic_srv':return clinicServisLink($id);break;
		case 'insur1':return setInsurPrice($id,1);break;
		case 'insur2':return setInsurPrice($id,2);break;
		case 'insur3':return setInsurPrice($id,3);break;
		case 'insur4':return setInsurPrice($id,4);break;
		case 'insur7':return setInsurPrice($id,7);break;
		case 'payInsur':return payInsur($id);break;
		case 'offerSet':return offerSet($id);break;
		case 'pa_visits':return pa_visits($id);break;
		case 'pa_visitss':return pa_visitss($id);break;
		case 'show_docs':return show_docs($id);break;
		case 'medRec':return showMedRec($id);break;		
		/**************CLN*************************************/
		case 'u_date':return u_date($id);break;
		case 'p_his_b':return p_his_b($id);break;
		case 'vis_det':return vis_det($id);break;
		case 's_price1':return s_price($id,1);break;
		case 's_price3':return s_price($id,3);break;
		case 's_price4':return s_price($id,4);break;
		case 's_price5':return s_price($id,5);break;
		case 's_price7':return s_price($id,7);break;
		case 'acc_but':return acc_but($id);break;
		case 'vital_nor':return vital_normal($id);break;
		/**************LAB*************************************/
		case 'lab_avr_set':return lab_avr_set($id);break;
		case 'mis_vis':return mis_vis($id);break;
		case 'equations':return equations($id);break;
		case 'lab_vis':return lab_vis($id);break;
		case 'OlabPrice':return OlabPrice($id);break;
		case 'test':return equations($id);break;
		case 'lab_getout_sdate':return lab_getout_sdate($id);break;
		case 'outlab_test_reciept_code':return outlab_test_reciept_code(1,$id);break;
		case 'outlab_test_reciept_shnme':return outlab_test_reciept_code(2,$id);break;
		/**************STR*************************************/	
		case 'strAddItems':return strAddItems($id);break;
		case 'strTransItems':return strTransItems($id);break;
		case 'strTransItems2':return strTransItems2($id);break;
		case 'str_items_bal':return items_bal($id);break;
		/**************XRY*************************************/
		case 'prinx_rep':return prinx_rep($id);break;
        /**************BTY*************************************/	
        case 'lsrSrv':return lsrSrv($id);break;
		/***************************************************************/
        case 'nurs_st':return nurs_st($id);break;
        /*****Api**********************************************************/
        case 'prmo_content':return prmo_content($rec);break;
        case 'prmo_audience':return prmo_audience($rec);break;
        case 'prmo_send':return prmo_send($rec);break;
	}
}
function getCustomFiledIN($opr,$fun,$id,$val,$filed=''){
	global $mod_data;
	switch ($fun){
		case 'print_card':return print_card($id,$opr,$filed,$val);break;
		case 'u_clinic':return u_clinic($id,$opr,$filed,$val);break;
		case 'linkX':return linkX($id,$opr,$filed,$val,3);break;
		case 'linkX2':return linkX($id,$opr,$filed,$val,2);break;
		case 'p_name':return get_p_name($val,0,$opr,$filed);break;
		case 'p_name5':return get_p_name($val,5,$opr,$filed);break;
		case 'servisNames':return servisNames($id,$val,1);break;
		
		case 'ofItPrice':return ofItPrice($id,$opr,$filed,$val);break;
		case 'gi_age':return gi_age($id,$opr,$filed,$val);break;
		case 'oldMPats':return oldMPats($id,$opr,$filed,$val);break;
		case 'str2min':return clocFromstr($val);break;
		case 'srv_name':return srv_name($id);break;
            
        case 'rate1':return rateing($id,$opr,$val,1);break;
        case 'rate2':return rateing($id,$opr,$val,2);break;
        case 'rate3':return rateing($id,$opr,$val,3);break;
        case 'rate4':return rateing($id,$opr,$val,4);break;
        case 'rate5':return rateing($id,$opr,$val,5);break;
        case 'rate6':return rateing($id,$opr,$val,6);break;
        case 'rate7':return rateing($id,$opr,$val,7);break;
		/**************Clinic**********************************/
		case 'prvTime':return dateToTimeS2($val);break;
		case 'servTime1':return servTime($id,$opr,$filed,$val,1);break;
		case 'servTime3':return servTime($id,$opr,$filed,$val,3);break;
		case 'servTime4':return servTime($id,$opr,$filed,$val,4);break;
		case 'servTime5':return servTime($id,$opr,$filed,$val,5);break;
		case 'servTime7':return servTime($id,$opr,$filed,$val,7);break;
		case 'vital_links':return vital_links($id,$val);break;
		case 'accShowSrv':return accShowSrv($id,$val);break;
        case 'postStatus':return postStatus($id,$opr,$filed,$val);break;
		
		/**************Lab**********************************/		
		case 'report_de':return report_de($id,$opr,$filed,$val);break;
		case 'rack_xy':return rack_xy($id,$opr,$filed,$val);break;
		case 'lab_getout_ana':return lab_getout_ana($val);break;
		/**************Stores**********************************/
		case 'str_sub_part':return str_sub_part($id,$opr,$filed,$val);break;
		case 'packing':return packing($id,$opr,$filed,$val);break;	
		/**************Den********************************************/
		case 'cavities':return cavities($id,$opr,$filed,$val);break;
        case 'den_add_val':return denClincal($id,$opr,$filed,$val);break;            
		/**************Lab********************************************/
		case 'labDevData':return labDevData($id,$opr,$filed,$val);break;
        /**************API********************************************/
        case 'appLink':return appLink($id,$opr,$filed,$val);break;
            
	}
}
function modEvents($fun,$id,$event_no){
	global $mod_data;
	switch ($fun){
		case 'printPcard':return printCard($id);break;
        case 'fixMobile':return fixMobileNoT($id);break;
		case 'str_resSpart':return str_resSpart($id);break;
		case 'patCopyData':return patCopyData($id);break;
		case 'updatePat':return updatePat($id,$event_no);break;
		case 'vacaDel':return vacaDel($id,$event_no);break;
		case 'boxPay':return boxPayFix($id);break;
        case 'sncLabSrv':return sncLabSrv($id,1);break;
        case 'sncLabSrvIn':return sncLabSrv($id,2);break;
        case 'updatAPIData':return updatAPIUserData($id);break;        
        case 'antibiotics':return sncAntibiotics($id);break;
        case 'bacteria':return sncbacteria($id);break;
        case 'swabs':return sncswabs($id);break;
        case 'del_pay':return del_pay($id,$event_no);break;
	}
}
function addFunctionsTime(){
	global $thisGrp,$MO_ID;
	sysAlerts();
	if(chProUsed('gnr')){checkDocPrv();}	
	if($thisGrp=='b3pfukslow'){checkRackAlert();}
    $out=[];
    $alerts=checkAlert();
    if($alerts){
        $out['alerts']=$alerts;
    }
    if($out){
        echo json_encode($out);
    }
	//if(_set_ruqswqrrpl && $thisGrp=='pfx33zco65'){checkForwardPayAlert();}
	//if($thisGrp=='hrwgtql5wk' && chProUsed('gnr')){sencDocWork();}    
    //resetRles();
}
//---------Pablic Project functionS ----------------------------------------------
function checkAlert(){
	global $thisUser;
    $alert=get_val('_sys_notification_live','no',$thisUser);	
    if($alert){return $alert;}
}?>
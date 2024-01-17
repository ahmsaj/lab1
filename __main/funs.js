function alert_function(){	
	$('#alert_win').dialog('close');
	switch(alert_no){
		case 1:visitDel(alert_data);break;
		case 4:$('#m_info').html(loader_win);cancel_ana(alert_data);break;
		case 44:$('#m_info').html(loader_win);cancel_xph(alert_data);break;
		case 5:$('#assignment').html(loader_win);del_assi(alert_data);break;
		case 6:endSrvDo(alert_data,'');break;
		case 7:delpho(alert_data);break;
		case 8:saveDefWay(alert_data);break;
		case 9:delOpr(alert_data);break;
		case 10:delVisDo(alert_data);break;
		case 11:newRoels_do(alert_data);break;
		case 12:addPay_do(alert_data);break;
		case 13:backPay_do(alert_data);break;
		case 16:cardPayDo(alert_data);break;
		case 17:cancelVisitDo(alert_data);break;
		case 18:caclSrvDo(alert_data);break;
		case 19:changePayDo(alert_data);break;
		case 20:anaEqu_del_do(alert_data);break;
		case 21:lssv_del_do(alert_data);break;
		case 22:finshLS_do(alert_data);break;
		case 23:caclSrvDoL(alert_data);break;
		case 24:RSDeL(2,alert_data);break;
		case 25:RSDeL(1,alert_data);break;
		case 26:delItemDo(alert_data);break;
		case 27:shipItemsEndDo(alert_data);break;
		case 28:transItemsEndDo(alert_data);break;
		case 29:cancelSampleDo(alert_data);break;
		case 30:delSpare_do(alert_data);break;
		case 31:marageAnaSaveDO(alert_data);break;

		case 'gnr_pay':changeVisType(alert_data);break;
		case 'proc_exc':delProcessDo(alert_data,'s');break;
		case 'proc_exc_o':delProcessDo(alert_data,'o');break;

		case 'lab_1':sendSG_do(alert_data);break;
		case 'lab_2':receiptSG_do(alert_data);break;
		case 'lab_3':returnReport_do(alert_data);break;
		case 'lab_4':delReqAna_do(alert_data);break;
		case 'lab_5':delSamDo(alert_data);break;
        case 'lab_printOrd':printAnaOrderDo(alert_data);break;
        case 'lab_reOpen':reOpenLabVisDo(alert_data);break;
        case 'lab_sDel':accDelAnaDo(alert_data);break;

		case 'cln_1':vitalNormal_del_do(alert_data);break;
        case 'gnr_rv':reopenVisDo(alert_data);break;
		case 'cln_vs':vitalSec_del_do(alert_data);break;
		case 'cln_gi':GISec_del_do(alert_data);break;	
		case 'ins_2':delSerINsurDo(alert_data);break;
		case 'ins_3':insurReqCancleDelDo(alert_data,1);break;
		case 'ins_4':insurReqCancleDelDo(alert_data,2);break;	
		case 'ins_5':backInsurDo(alert_data);break;
		case 'ins_6':delInsurDo(alert_data);break;
		//---------------------------------------
		case 'den_1':teethOprDel_do(alert_data);break;
		case 'den_2':den_oprs_action(5);break;
        case 'den_22':d_den_oprs_action(5);break;
		case 'den_3':delLevDenDo(alert_data);break;
        case 'den_33':dellevTxtDo(alert_data);break;
		case 'den_5':teethStatusSaveDo(alert_data);break;
		case 'den_6':den_oprs_action(alert_data);break;
        case 'den_66':d_den_oprs_action(alert_data);break;
        case 'den_delh':delHisItDDo(alert_data);break;
        case 'den_cln_del':delClinicalinfoDo(alert_data);break;
		case 'den_srv_del':delDenSeviceDo(alert_data);break;
		//---------------------------------------
		case 'dts_1':dtsDelDo(alert_data);break;
		case 'dts_2':returnPaymentDo(alert_data);break;
		case 'dts_3':dtsAppAccpDo(alert_data);break;
        case 'dts_4':reserveDateDo(alert_data);break;
		//case 'bty1':bty_finshSrvDo(alert_data);break;
		case 'lsr_1':bty_caclSrvDo(alert_data);break;
		case 'bty_1':cancelBtyVisitDo(alert_data);break;
		case 'bty3':delLaserServDo(alert_data);break;//laser
		case 'bty4':delLaserNoteDo(alert_data);break;//laser
		case 'xry_1':xry_caclSrvDo(alert_data);break;
		case 'xry_2':cancelXryVisitDo(alert_data);break;
        case 'xry_printOrd':printXryOrderDo(alert_data);break;
        case 'osc_c':cancelOscVisitDo(alert_data);break;
		case 'osc_3':osc_pro_delDo(alert_data);break;
		case 'osc_4':osc_srv_delDo(alert_data);break;
		//---------------------------------------
		case 'gnr_1':delServDo(alert_data);break;
		case 'gnr_2':payTypeReqCancleDo(alert_data);break;
		case 'gnr_3':delOffSrvDo(alert_data);break;
		case 'gnr_4':mergeDo(alert_data);break;
		case 'gnr_5':delPrescrDo(alert_data);break;
		case 'gnr_6':delPatDocDo(alert_data);break;
		case 'gnr_7':delGIDo(alert_data);break;
		case 'gnr_8':vacaSub(alert_data);break;
		case 'offer_1':cancelSrvOfferDo(alert_data);break;
		case 'offer_2':delSellOfferDo(alert_data);break;
		case 'gnr_rec1':addPatToOfferDo(alert_data);break;
        
        case 'api1':publishPostDo(alert_data);break;
	}
	fixPage();
}
function refPage(s,time){
	thisTime=time;
	clearTimeout(ref_page);
	busyReq=chReqStatus();
	if(winIsOpen()==0 && busyReq==0){
		switch(s){
			case 'cln1':cln_prv_ref(0);break;		
			case 1:cln_vit_d_ref(0);break;		
			case 2:rev_ref(0,visit_id);break;
			case 3:res_ref(0);break;
			case 4:sch_ref(0);break;
			case 5:exe_ref(0);break;
			case 6:chr_ref(0);break;		
			case 8:samples_ref(0);break;
			case 9:r_samples_ref(0);break;
			case 10:r_samples_work(0);break;
			case 11:r_rev(0);break;
			case 12:l_res_ref(0);break;
			case 13:l_alert_ref(0);break;		
			case 'den1':den_vit_d_ref(0);break;
			case 'den2':den_prv(0);break;
            case 'denNew':den_prv_ref(0);break;
			case 'gnr1':ins_ref(0);break;
			case 'bty1':bty_vit_d_ref(0);break;
            case 'bty2':bty_rev_ref(1,visit_id);break;
			case 'lsr_1':bty_rev_ref(0,visit_id);break;
			case 'btyt2':btyl_rev_ref(0,visit_id);break;
			case 'xry1':xRep_ref(0);break;
			case 'xry2':xry_vit_d_ref(0);break;
			case 'xry3':xry_rev_ref(0,visit_id);break;
			case 'osc2':rev_osc_live(visit_id);break;
			case 'dts1':dtsApp();break;
			case 'osc1':osc_vit_d_ref(0);break;
			case 'gnr_box':box_opr_ref(0);break;
			case 'pres_1':presc_loadPrescriptions(0);break;                
            case 'api_compl':refComplaints(0);break;
            case 'phr_main':phr_main(0);break;
		}
	}else{thisTime=800;}
	ref_page=setTimeout(function(){refPage(s,time)},thisTime);
}
function CLE(s,filed,val){//Custom List Event	
	switch(s){
		case 'storePsrt':selStorSpart(val);break;
		case 'SUG':selUserGroup(val);break;
		case 'vaca1':vacSelDoc(val);break;
	}
}
//---------------------------------------------------------------------------------	
function DuplEntry(id){ 
	win('close','#opr_form0');
	loadWindow('#m_info',1,k_dup_ent,600,0);
	$.post(f_path+"X/gnr_patient_new_check.php",{id:id}, function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixForm();
	})	
}
function print_(pro,type,id){
	url=f_path+'Print-'+pro+'/T'+type+'-'+id;popWin(url,800,600);
} 
function fixPage_add(){
	var CSI_H=hhh-141;
	var CSI_W=www;
	//---------For Project ---------------------
	if(sezPage=='Resp' || sezPage=='vis_lab'){			
		$('.ana_list').height($('.ana_list').parent().height()-90);
		$('#anaSelected').height($('#anaSelected').parent().height()-50);
		$('.anaSel').width($('.anaSel').parent().width()-384);
		if(in_array('dts',proUsed)==true){setSlider();}
	}
	if(sezPage=='rd_win'){
		$('.rd_b1 , .rd_b2').height($('.rd_b1').parent().height()-10);
		$('.rd_b2').width(www-339);
		orderRD();
	}
	if(sezPage=='vis_l_r'){
		rr=$('.rackTable').attr('x');
		rtw=$('.rackTable').width()
		tdW=(rtw-10)/rr
		$('.rackTable td[s]').width(tdW);
		$('.rackTable td[s]').height(tdW);
	}	
	if(sezPage=='l_rep_rev'){
		$('.rr_t2').width($('.rr_t2').parent().width()-222);
	}
	/****Stores***********************************************/
	if(sezPage=='Shipments' || sezPage=='Transfers'){
		$('.shItTree').height(hhh-50)
		$('.shItDet').height(hhh-50)
		$('.shItDet').width(www-290)
		$('.shItTreeIN').height(hhh-150);
		$('.strItDetIn').height(hhh-120)
		$('.strItDetIn').width(www-310)
		
	}
	if(sezPage=='Material-Consumption' ||  sezPage=='Preview-Xray' || sezPage=='Preview-Clinic'){
		$('.shItTree , .shItDet').css('margin-top','-10px');
		$('.shItTree ').css('margin-'+k_align,'-10px');
		$('.strIttitle ').css('margin-top','0px');
		$('.shItDet ').css('margin-'+k_align,'261px');
		$('.shItDet ').css('padding','10px');
		fh=$('.shItTree').closest('.form_body').height();
		$('.shItTree').height(fh+20);
		$('.shItDet').height(fh)
		$('.shItDet').width(www-333)
		$('.shItTreeIN').height(fh-70);
		$('.strItDetIn').height(hhh-120)
		$('.strItDetIn').width(www-310)
	}
	
	if(sezPage=='vis_l_work'){
		rl_h=$('.lr_int').closest('.form_body').height();
		rl_w=$('.lr_int').closest('.form_body').width();
		$('.lr_int , .lr_list').height(rl_h);
		$('.lr_list').width(rl_w-274);
	}
	if(sezPage=='Preview-Xray' || sezPage=="vis_xry"){fixRepEdit();}
}
//---------Pablic Project function ----------------------------------------------
//if(sezPage=='Preview-Clinic'){setProview();}})
function showPayAlert(t){	
	if(t!=0){
		aBox=$('#alert_box').html(); 		
		if(aBox==''){
			a_txt='<div class="alert_nav_in2 fl " title="'+k_alerts+'" onclick="hideAlert()" ><div id="abn">'+t+'</div></div>';
			$('#alert_box').html(a_txt);			
		}else{
			$('#abn').html(t);
		}
		$('#alert_box').show(500);
	}else{
		aBox=$('#alert_box').hide(500);
	}
	//$('#a'+vis).show(500);
	//if($('#alert_box').not(':visible')){$('#alert_box').fadeIn(500);}	
}
function hideAlert(){aBox=$('#alert_box').hide(500);}
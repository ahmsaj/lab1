 /***DEN***/
var actTeethType=1;var actTeeth=0;var actTeethPart=0;var TeethactStyle='';var PartethactStyle='';var PartethactFaces='';var TeethactOpr='';var selteParts=0;var actDenSrv=0;var actOprSrv=0;var actCavOrd=0;var actCavNo=0;var actSp=0;var desHisAct=0;
var cavCodes=new Array('','i','p','b','d','l','m','ml','dl','db','mb','mb1','mb2');
function denPrvSet(t){
	actTeethType=t;
	$('.butDen > div').click(function(){
		n=$(this).attr('n');
		if(n==1){loadTeeth(0);}
		if(n==2){loadDenOpers();}
	})
	loadTeeth(0);
}
function loadTeeth(s){	
	if(s==0){
		$('#denData').html(loader_win);			
	}else{
		$('#teethData').html(loader_win);
	}
	$.post(f_path+"X/den_preview_teeths.php",{vis:visit_id,t:actTeethType,s:s},function(data){
		d=GAD(data);		
		if(s==0){
			$('#denData').html(d);
			loadTeeth(1);
		}else{
			$('#teethData').html(d);			
			setTeeth();
			setDenOpr();
		}
		fixPage();
		fixForm();
	})
}
function loadDenOpers(srv=0){	
	$('#denData').html(loader_win);
	$.post(f_path+"X/den_preview_oprs.php",{vis:visit_id,pat:patient_id},function(data){
		d=GAD(data);		
		$('#denData').html(d);	
		setOPeSrvDen();
		if(srv){denRefOpr(srv);}
		fixPage();
		fixForm();		
	})
}
function setOPeSrvDen(){
	$('.oprDen > div').click(function(){
		no=$(this).attr('no');
		denRefOpr(no);
	})
	$('[addSrv]').click(function(){addNewSrv();})
}
function denRefOpr(srv){
	actOprSrv=srv;
	$('#denOprInfo').html(loader_win);
	$.post(f_path+"X/den_preview_oprs_info.php",{vis:visit_id,pat:patient_id,srv:srv},function(data){
		d=GAD(data);
		$('#denOprInfo').html(d);
		$('[levAdd]').click(function(){
			levId=$(this).closest('[lev]').attr('lev');
			mLlevId=$(this).closest('[mlev]').attr('mlev');
			srv=$(this).closest('[srv]').attr('srv');
			addLevDen(levId,mLlevId,srv);
		})
		$('[levDel]').click(function(){levId=$(this).attr('no');delLevDen(levId);})
		$('[levDone]').click(function(){levId=$(this).closest('[lev]').attr('lev');den_oprs_action(2,levId);})
		$('[levRes]').click(function(){levId=$(this).closest('[lev]').attr('lev');den_oprs_action(3,levId);})
		$('[endAll]').click(function(){den_oprs_action(4);})
		$('[srvDel]').click(function(){denSrvDel();})
		$('[srvPrice]').click(function(){changeDenPrice();})
		fixForm();
		fixPage();
	})
}
function startSrv(a){
	open_alert(a,'den_6','سيصبح هذا الأجراء باسمك لا يمكن تعديل هذا لاحقا ،هل تود بدء هذا الإجراء ؟',k_start_proce);
}
function den_oprs_action(a,l=0){
	loader_msg(1,k_loading);
	win('close','#m_info');	
	$.post(f_path+"X/den_preview_oprs_action.php",{a:a,v:visit_id,p:patient_id,s:actOprSrv,l:l}, function(data){
		d=GAD(data);
		if(d==1){
			msg=k_done_successfully;mt=1;
			loadDenOpers(actOprSrv);
		}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);
	})
}
function addLevDen(lev,mLlev,srv){
co_selLongValFree('il4a2im33',"saveLevDen([id],"+lev+")|level="+mLlev+"||service:"+srv+":h,level:"+mLlev+":h|",0);
}
function saveLevDen(id,lev){
	loader_msg(1,k_loading);
	$.post(f_path+"X/den_preview_oprs_lev_save.php",{lev:lev,des:id}, function(data){
		d=GAD(data);
		if(d==1){
			msg=k_done_successfully;mt=1;
			denRefOpr(actOprSrv);
		}else{msg=k_error_data;mt=0;}	
		loader_msg(0,msg,mt);		
	})
}
function delLevDen(id){
	open_alert(id,'den_3',k_confirm_note_del,k_delete_note);
}
function delLevDenDo(id){
	loader_msg(1,k_loading);
	win('close','#m_info');
	$.post(f_path+"X/den_preview_oprs_lev_del.php",{id:id}, function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;denRefOpr(actOprSrv);}else{msg=k_error_data;mt=0;}	
		loader_msg(0,msg,mt);		
	})
}
function denSrvDel(){	
	open_alert(0,'den_2',k_confirm_proce_del,k_del_proce);
}
function mSelTeeth(teeth){
	$('td[tdno]').removeAttr('sel');
	if(teeth!='0'){
		t=teeth.split(',');
		for(i=0;i<t.length;i++){
			$('td[tdno='+t[i]+']').attr('sel','1');
		}
	}	
}
function finshDenVis(){
	loadWindow('#m_info',0,k_endvis,www,hhh);
	$.post(f_path+"X/den_preview_end.php",{id:visit_id},function(data){
		d=GAD(data);
		$('#m_info').html(d);		
		fixForm();
		fixPage();
	})
}
function endVisDenDo(){
	pay=parseInt($('#denPay').val());
	maxPay=parseInt($('#denPay').attr('max'));
	if(pay>maxPay){
		nav(4,k_mnt_gr_val);
	}else{
		loader_msg(1,k_loading);
		$.post(f_path+"X/den_preview_end_do.php",{id:visit_id,pay:pay},function(data){
			d=GAD(data);	
			if(d==1){				
				loader_msg(1,k_done_successfully,1);				
				loc('_visit-Den');
			}else{				
				loader_msg(0,k_error_data,0);
			}			
		})
	}
}
function editCav(id){
	loadWindow('#m_info',0,k_canals_stats,800,400);
	val=$('#cavVal').val();
	$.post(f_path+"X/den_cavities_set.php",{id:id,val:val},function(data){
		d=GAD(data);
		$('#m_info').html(d);		
		loadFormElements('#cavit');
		setCav();
		fixForm();
		fixPage();
	})
}
function setCav(){
	$('#cavit').find('div[par]').click(function(){
		n=$(this).attr('par');
		v=$(this).attr('ch_val');
		val=CBV('c_'+n+'_'+v);
		if(val==1){			
			if(v=='1'){hideCBox(n,'2,3,4,5,6,7,8,9,10,11,12');}
			if(v=='2'){hideCBox(n,'1,4,5,6,7,8');}
			if(v=='3'){hideCBox(n,'1,4,,6,7,8,9,10,11,12');}
			if(v=='4'){hideCBox(n,'1,2,3,5,8,9,11,12');}
			if(v=='5'){hideCBox(n,'1,2,4,6,7,8,9,10,1,12');}
			if(v=='6'){hideCBox(n,'1,2,3,5,7,8,9,10,11,12');}
			if(v=='7'){hideCBox(n,'1,2,3,5,6,11,12');}
			if(v=='8'){hideCBox(n,'1,2,3,4,5,6,11,12');}
			if(v=='9'){hideCBox(n,'1,3,4,5,6');}
			if(v=='10'){hideCBox(n,'1,3,5,6,11,12');}
			if(v=='11'){hideCBox(n,'1,3,4,5,6,7,8,10');}
			if(v=='12'){hideCBox(n,'1,3,4,5,6,7,8,10');}
		}
	})
}
function hideCBox(cNo,cdata){
	cd=cdata.split(',');
	for(i=0;i<cd.length;i++){
		CBC('c_'+cNo+'_'+cd[i],0);
	}
}
function saveCavsSet(){
	var cavRows=3;
	var cavOptions=12;	
	da='';
	dr='';
	dat='';
	drt='';
	for(i=0;i<=cavRows;i++){
		dr='';
		drt='';
		for(ii=1;ii<=cavOptions;ii++){
			f='c_'+i+'_'+ii
			if(CBV(f)==1){
				if(dr!=''){dr+=',';drt+=' , ';}
				dr+=ii;
				drt+=cavCodes[ii];				
			}
		}
		if(da!='' && dr!=''){da+='|';dat+=' | ';}		
		da+=dr;
		dat+=drt;
	}
	if(da!=''){
		$('#cavTxt').html(dat);
		$('#cavVal').val(da);
		win('close','#m_info');
	}else{
		nav(3,k_one_status_must_sel);
	}
}
function setDenOpr(){
	$('.tt_icon_c').click(function(){
		actTeethType=2;loadTeeth(1);$('.tt_icon_c').hide();$('.tt_icon_a').show();
	})
	$('.tt_icon_a').click(function(){
		actTeethType=1;loadTeeth(1);$('.tt_icon_a').hide();$('.tt_icon_c').show();
	})	
}
function denConsAdd(doc,pat){
	loader_msg(1,k_loading);
	$.post(f_path+"X/den_consult_add.php",{doc:doc,pat:pat}, function(data){
		d=GAD(data);
		loader_msg(0,'',0);
		win('close','#m_info');
		if(d!=0){viSts(4,d);}
	})
}
function denVisitStatus(id){
	loadWindow('#m_info',1,k_visit_details,600,0);
	$.post(f_path+"X/den_visit_add_save_status.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		loadFormElements('#denElm');
		fixForm();
		fixPage();
	})
}
function den_vit_d_ref(l){	
	if(l==1){$('#d2,#d3,#d4').html(loader_win);}
	$.post(f_path+"X/den_visit_doc_live.php",{},function(data){
		d=GAD(data);
		dd=d.split('^');
		$('.top_icons').html(dd[0]);
		$('#d1').html(dd[1]);
		$('#d2').html(dd[2]);
		$('#d3').html(dd[3]);
		$('#d4').html(dd[4]);
		fixPage();
		fixForm();		
	})
}
function den_prv(l){
	$.post(f_path+"X/den_preview_info_live.php",{vis:visit_id},function(data){
		d=GAD(data);
		dd=d.split('^');
		$('#timeBar').html(dd[0]);			
		fixPage();		
	})
}
function setTeeth(){
	$('div[TNO]').click(function(){teethInfo($(this).attr('TNO'),1,1);});
	$('td[RNO]').click(function(){teethInfo($(this).attr('RNO'),2,1);});
}
function teethInfo(n,t,l){
	actTeeth=n;
	actTeethPart=t;
	loadWindow('#full_win1',l,k_tooth_details,www,hhh);
	$.post(f_path+"X/den_preview_teeth_info.php",{n:n,vis:visit_id,t:t,r:actCavOrd},function(data){
		d=GAD(data);
		$('#full_win1').html(d);
		fixForm();
		fixPage();
		$('td[TNO2]').click(function(){actCavOrd=0;teethInfo($(this).attr('TNO2'),t,1);});
		$('.teethHis > div').click(function(){setOprDet($(this).attr('n'));});
		$('.tBoxInfo [tsp]').click(function(){setSubPartS($(this).attr('tsp'));});
		$('.tToolI div').click(function(){actSp=0;setSubPartSave($(this).attr('no'),0);});
		if(t==1){
			actCavOrd=0;		
		}else{
			$('.tRoott div[rn]').click(function(){actSp=0;setSubPartSave($(this).attr('rn'),0);})
		}
	})
}
function setSubPartS(sp){
	actSp=sp;
	loadWindow('#m_info',0,k_sub_status,600,400);
	$.post(f_path+"X/den_preview_ts_add.php",{n:actTeeth,t:actTeethPart,p:sp},function(data){
		d=GAD(data);
		$('#m_info').html(d);	
		fixForm();
		fixPage();
		$('div[spss]').click(function(){setSubPartSave($(this).attr('spss'));})
	})
}
function setSubPartSave(v){
	loader_msg(1,k_loading);
	$.post(f_path+"X/den_preview_ts_save.php",{n:actTeeth,t:actTeethPart,p:actSp,v:v,vis:visit_id,c:actCavOrd},function(data){
		d=GAD(data);
		dd=d.split(',');
		if(dd.length==4){
			win('close','#m_info');
			if(dd[1]==0){
				teethInfo(actTeeth,actTeethPart,0);
				loader_msg(0,k_done_successfully,1);
			}else{
				loader_msg(0,'',1);
				selSubTStatus(dd[1],dd[2],dd[3]);
			}
		}else{
			loader_msg(0,k_error_data,0);
		}
	})
}
function selSubTStatus(rec,type,statusId){
	if(type==1){col='2xz6xm5kc5';}
	if(type==2){col='ipu43tu83i';}
	co_selLongValFree(col,"selSubTStatusSave("+rec+",[id])|status_id="+statusId+"||status_id:"+statusId+":h",0);
}
function selSubTStatusSave(id,v){
	loader_msg(1,k_loading);
	win('close','#m_info');	
	$.post(f_path+"X/den_preview_ts_save_sub.php",{id:id,v:v}, function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;teethInfo(actTeeth,actTeethPart,0);}else{msg=k_error_data;mt=0;}		
		loader_msg(0,msg,mt);
	})
}
function setOprDet(n){
	loadWindow('#m_info',0,k_oper_det,600,200);
	$.post(f_path+"X/den_preview_opr_info.php",{id:n},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
}
function TOV_all(t){
	loadWindow('#m_info',0,k_oper_det,www,hhh);
	$.post(f_path+"X/den_preview_opr_info.php",{t:t},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
}
function saveTeethOprSub(id){
	loadWindow('#m_info',0,k_tooth_substatus,500,200);
	$.post(f_path+"X/den_preview_opr_sub.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
}
function saveTeethOprSubDo(id,opr_sub){
	loader_msg(1,k_loading);
	win('close','#m_info');
	$.post(f_path+"X/den_preview_opr_sub_do.php",{id:id,opr_sub:opr_sub}, function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;teethInfo(actTeeth,actTeethPart,0);}else{msg=k_error_data;mt=0;}		
		loader_msg(0,msg,mt);		
	})
}
function teethOprDel(id){
	open_alert(id,'den_1',k_confirm_proce_del,k_del_proce);
	win('close','#m_info');
}
function teethOprDel_do(id){
	loader_msg(1,k_loading);
	win('close','#m_info');
	$.post(f_path+"X/den_preview_opr_del.php",{id:id}, function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;teethInfo(actTeeth,actTeethPart,0);}else{msg=k_error_data;mt=0;}		
		loader_msg(0,msg,mt);
	})
}
function addNewSrv(){co_selLongValFree('lgz47bd87',"selDenSrv([id])|||",0);}
function selDenSrv(cat){co_selLongValFree('lmgcp54921',"selDenSrvSave([id],0)|cat="+cat+"||",0);}
function selDenSrvSave(id,tooth){
	actDenSrv=id;
	loader_msg(1,k_loading);
	win('close','#m_info');
	$.post(f_path+"X/den_preview_services_add.php",{id:id,tooth:tooth,vis:visit_id},function(data){
		d=GAD(data);		
		dd=d.split('^');
		if(dd.length==2){
			if(dd[0]=='1'){
				loader_msg(0,'',1);
				loadDenOpers(dd[1]);
				changeDenPrice(dd[1]);
			}else if(dd[0]=='0'){
				selTeeth(dd[1],"selDenSrvSave("+id+",[data]);");
				denRefOpr(id);
				loader_msg(0,'');
			}else{
				loader_msg(0,'');
				nav(5,k_err_add_procedure);
			}				
		}else{
			loader_msg(0,k_error_data,0);
		}
	})
}
function changeDenPrice(id=0){
	if(id==0){id=actOprSrv;}
	loadWindow('#m_info',0,k_price_serv,500,600);
	$.post(f_path+"X/den_preview_services_price.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info').html(d);		
		fixForm();
		fixPage();
	})
}
function changeDenPriceSave(id){
	dPrice=$('#srvDPrice').val();	
	win('close','#m_info');
	loader_msg(1,k_loading);
	$.post(f_path+"X/den_preview_services_price_save.php",{id:id,p:dPrice}, function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;}else{msg=k_error_data;mt=0;}	
		loader_msg(0,msg,mt);
		if(sezPage=='Den-Services-review'){loadModule('m7q26gogu');}else{denRefOpr(actOprSrv);}
	})
}
function selTeeth(type,cb){
	loadWindow('#m_info4',0,k_chos_teeth,800,200);
	$.post(f_path+"X/den_teeth_set.php",{type:type,cb:cb},function(data){
		d=GAD(data);
		$('#m_info4').html(d);
		setTeethSet(type);
		fixForm();
		fixPage();
	})
}
function setTeethSet(t){	
	$('td[tno2]').click(function(){
		if(t==1){$('td[tno2]').removeAttr('act');$(this).attr('act','');}
		if(t==2){
			if($(this).attr('act')==''){
				$(this).removeAttr('act');
			}else{				
				$(this).attr('act','');
			}
		}		
	});
}
function setTeethSetSave(){
	da='';
	$('td[tno2][act]').each(function(){
		no=$(this).attr('tno2');
		if(da!=''){da+=',';}
		da+=no;		
	})
	if(da==''){nav(3,k_one_tooth_sel);}else{setTeethSetDo(da);}		
}
function denHis(id,vis){
	desHisAct=id;
	loadWindow('#full_win1',1,k_proced_his,www,hhh);
	$.post(f_path+"X/den_preview_his.php",{id:id,vis:vis},function(data){
		d=GAD(data);
		$('#full_win1').html(d);
		hisMood=$('#dHisType').val();
		loadHisMood(hisMood,0);
		fixForm();
		fixPage();		
	})
}
function loadHisMood(t,t_id){
	$('#hisDes , #hisList').html(loader_win);
	$.post(f_path+"X/den_preview_his.php",{id:desHisAct,type:t,vis:t_id},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
			$('#hisList').html(dd[0]);
			$('#hisDes').html(dd[1]);			
			fixForm();
			fixPage();
		}
	})
}
function teethStatus(id){
	desHisAct=id;
	loadWindow('#full_win1',1,k_teeth_status,www,hhh);
	$.post(f_path+"X/den_tooth_status.php",{id:id},function(data){
		d=GAD(data);
		$('#full_win1').html(d);				
		fixForm();
		fixPage();		
	})
}
function teethStatusSave(id){  
	open_alert(id,'den_5',k_confirm_teeth_status_save,k_teeth_status_save);
}
function teethStatusSaveDo(id){
	loader_msg(1,k_loading);
	win('close','#m_info');
	$.post(f_path+"X/den_tooth_status_save.php",{id:id}, function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;teethStatus(id);}else{msg=k_error_data;mt=0;}		
		loader_msg(0,msg,mt);		
	})
}
function showTeethStatus(id){
	$('#stutusDes').html(loader_win);
	$.post(f_path+"X/den_tooth_status.php",{sub_id:id},function(data){
		d=GAD(data);
		$('#stutusDes').html(d);
		fixForm();
		fixPage();		
	})
}
function patRecDen(id){loadWindowFull('X/den_preview_his_pr','#m_info3',k_dental_procedures,id);}
function printDenInv(id){	
	loadWindow('#m_info4',1,'طباعة فاتورة',800,0);
	$.post(f_path+"X/gnr_patient_acc_invoice.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info4').html(d);
		loadFormElements('#denElm');
		fixForm();
		fixPage();
	})
}
function printDenInvDo(id){
	vals='';
	$('[name=denPrint]').each(function(){
		vals+=$(this).val()+'A';
	})
	if(vals){
		vals=vals.substring(0,vals.length-1);
		printInvoice(44,id,vals);
	}
}
function editPat(id,loc=1){
    page='_Preview-Den';
    if(loc==2){page='_Preview-Den-New';}
	co_loadForm(patient_id,3,"87zc6kbbs5||loc('"+page+"."+visit_id+"')|");
}
/***************Prview New*******************/
$(document).ready(function(e){
    if(sezPage=='denPrvNew'){setDenPrv();setDenteeth();setDenOther();setDenClinical();}
    if(sezPage=='Dental-Clinical-Set-Items'){        
        $('body').on('change click keyup','[name="cof_5oprvbuuug"]',function(){
            t=$('input[name="cof_5oprvbuuug"]').val();            
            denCln_showAddVals(t);
        })
    }
})
var actPrvOpr=1;
var actTeethType=1;
var d_actOpr=0;
var actoprTypeList=1;
function setDenPrv(){
    den_prv_ref();
    refPage('denNew',10000);
    //$('[prvVisTool] [help]').click(function(){alert(1);})
    //$('[prvVisTool] #patWs').click(function(){alert(2);})
    $('[prvVisTool] [back]').click(function(){loc('_Visit-Den');})
    $('[prvVisTool] [finish]').click(function(){prvDEnd();})
    $('#exWinD').click(function(){inWinDClose();})
    /****/
    $('.d_c1 [dOpr]').click(function(){denOprSel($(this).attr('dOpr'));})
    $('.centerSideInFull').on('change','[oprList]',function(){actoprTypeList=$(this).val();showOprsList();})
    $('#denListSec').on('click','[oprNo]',function(){d_showOpr($(this).attr('oprNo'));})    
    /****/
    $('.centerSideInFull').on('click','[addOprD]',function(){d_newOpr();})
    $('.inWinD').on('click','.denCatList [no]',function(){d_newOprShow($(this).attr('no'));})
    $('.inWinD').on('click','.denOprList [no]',function(){d_newOprSDet($(this).attr('no'));})
    $('.inWinD').on('keyup','#oprSear',function(){serOpr();})
    $('.inWinD').on('click','[selTeeth] [s]',function(){calTooh();})
    $('.inWinD').on('click','[saveDopr]',function(){sub('ths');})
    $('.inWinD').on('click','[endDenVis]',function(){prvEndDo();})    
    $('.inWinD').on('click','[saveSrvPrice]',function(){prvDenPriceSave();})
    
    $('#denDetiaSec').on('click','[startSrv]',function(){d_startSrv(1);})
    $('#denDetiaSec').on('click','[srvDel]',function(){denSrvDel();})    
    $('#denDetiaSec').on('click','[endAll]',function(){d_den_oprs_action(4);})
    $('#denDetiaSec').on('click','[levRes]',function(){
        levId=$(this).closest('[lev]').attr('lev');
        d_den_oprs_action(3,levId);
    })    
    $('#denDetiaSec').on('click','[levDone]',function(){
        levId=$(this).closest('[lev]').attr('lev');
        d_den_oprs_action(2,levId);
    })
    /****levels****/
    $('#denDetiaSec').on('click','[lev] [levAdd]',function(){
        id=$(this).closest('[lev]').attr('lev');
        newLevNote(id);
    })
    $('#denDetiaSec').on('click','[lev] [levY]',function(){
        id=$(this).closest('[lev]').attr('lev');
        addLevTxt();
    })
    $('#denDetiaSec').on('click','[lev] [levX]',function(){
        id=$(this).closest('[lev]').attr('lev');
        closelevTxt();
    })
    $('#denDetiaSec').on('click','[levTxt] [levDel]',function(){
        id=$(this).closest('[levTxt]').attr('levTxt');
        dellevTxt(id);        
    })
    $('#denDetiaSec').on('click','[levTxt] [levEdit]',function(){
        id=$(this).closest('[levTxt]').attr('levTxt');
        editlevTxt(id);
    })
    $('#denDetiaSec').on('click','[srvPrice]',function(){prvDenPrice();})
    denOprView();
    denOprSel(1);
}
function den_prv_ref(){
	$.post(f_path+"X/den_prv_live.php",{vis:visit_id},function(data){
		d=GAD(data);
		dd=d.split('^');	
		$('#timeSecDen').html(dd[0]);		
		$('#patNo').html(dd[1]);
		$('#patWs').attr('class','fl cbg3 '+dd[2]);
		fixPage();		
		fixForm();
	})
}
function denOprSel(o){
    actPrvOpr=o;
    denOprView();
    $('[sc]').hide();
    $('[sc='+o+']').show();
}
function denOprView(){
    if(actPrvOpr==1){
        showOprsList();
    }else if(actPrvOpr==2){
        showTeethMap();
    }else if(actPrvOpr==3){
        showClinicalinfo();
    }
    $('.centerSideInFull').attr('viewType',actPrvOpr);
    inWinDClose();
}
function showOprsList(id=0,l=1){
    if(l==1){
        $('#denListSec').html(loader_win);
        $('#denDetiaSec').html('');
    }
	$.post(f_path+"X/den_prv_oprs_list.php",{vis:visit_id,pat:patient_id,t:actoprTypeList,id:id},function(data){
		d=GAD(data);
        dd=d.split('^');
		$('#denListSec').html(dd[0]);
        $('#denDetiaSec').html(dd[1]);
        if(id){d_showOpr(id,l);}
		fixForm();
		fixPage();		
	})
}
function d_showOpr(id,l=1){
    d_actOpr=id;
    if(l==1){
        $('#denDetiaSec').html(loader_win);
    }else{
        loader_msg(1,k_loading);
    }
	$.post(f_path+"X/den_prv_oprs_info.php",{vis:visit_id,pat:patient_id,t:actoprTypeList,id:d_actOpr},function(data){
		d=GAD(data);
		$('#denDetiaSec').html(d);
        loader_msg(0,'');
		fixForm();
		fixPage();
	})
}
function openLasWin(title=''){
	$('.inWinD').show();
	$('#iwT').html(title);
	$('#iwB').html(loader_win);
}
function inWinDClose(){inWinD();$('.inWinD').hide();}
function inWinD(title='',body=''){
    $('.inWinD').show();       
	if(body==''){body=loader_win;}
	if(title!=0){$('#iwT').html(title);}
	$('#iwB').html(body);
	$('[inWinD]').show();
    fixPage();
}
/***************************/
function d_newOpr(){
    openLasWin('إجراء جديد');
    $.post(f_path+"X/den_prv_oprs_new.php",function(data){
		d=GAD(data);
		$('#iwB').html(d);
		fixPage();
		fixForm();
	})
}
function d_newOprShow(id){
    $('#d_oprList').html(loader_win);
    $('#d_oprDet').html('');
    $('#oprSear').val('');
    $.post(f_path+"X/den_prv_oprs_new_list.php",{id:id},function(data){
		d=GAD(data);
		$('#d_oprList').html(d);
        $('#oprSear').focus();
		fixPage();
		fixForm();
	})
}
function serOpr(){
    str=$('#oprSear').val();
	str=str.toLowerCase();
	$('.denOprList div').each(function(index, element){
		txt=$(this).attr('txt').toLowerCase();		
		n = txt.search(str);
		if(n!=(-1)){$(this).show(300);}else{$(this).hide(300);}
	})
}
function d_newOprSDet(id){
    $('#oprSear').val('');
    serOpr();
    $('#d_oprDet').html(loader_win);
    $.post(f_path+"X/den_prv_oprs_new_det.php",{id:id,vis:visit_id,pat:patient_id},function(data){
		d=GAD(data);		
		$('#d_oprDet').html(d);
        loadFormElements('#ths');			
		setupForm('ths','');
		fixPage();
		fixForm();
	})
}
function saveDopr(d){
    dd=d.split('^');
    if(dd[0]==1){
        showOprsList(dd[1]);
        inWinDClose()
    }else{
        nav(3,k_error_data);
    }
}
function calTooh(){
    noStr='';
    $('[selTeeth] [s][act]').each(function(){
        if(noStr){noStr+=',';}
        noStr+=$(this).html();
    })
    $('input[name=tooth]').val(noStr);
}

function d_startSrv(a){
	open_alert(a,'den_66','سيصبح هذا الأجراء باسمك لا يمكن تعديل هذا لاحقا ،هل تود بدء هذا الإجراء ؟',k_start_proce);
}
function denSrvDel(){	
	open_alert(0,'den_22',k_confirm_proce_del,k_del_proce);
}
function d_den_oprs_action(a,l=0){
	loader_msg(1,k_loading);
	win('close','#m_info');	
	$.post(f_path+"X/den_prv_oprs_action.php",{a:a,v:visit_id,p:patient_id,s:d_actOpr,l:l}, function(data){
		d=GAD(data);
		if(d==1){
			msg='';
            mt=1;
			showOprsList(d_actOpr,0);            
		}else{
            msg=k_error_data;mt=0;
            loader_msg(0,msg,mt);
        }
		
	})
}
/******************************/
var actLevelAdd=0;
var actLevTxtEdit=0;
function newLevNote(id,lev=0){
    actLevelAdd=id;
    addnotrInput(lev);
}
function addnotrInput(lev=0){
    actLevTxtEdit=lev;
    notBlc=$('[lev='+actLevelAdd+']');
    txt='';
    $('[levtxt]').show();
    $('[levAdd]').show();
    if(lev){
        txt=$('[levtxt='+lev+'] [t]').html();
        $('[levtxt='+lev+']').hide();
    }else{
        $('[noteInput][no]').remove();
        notBlc.find('[levAdd]').hide();
    }
    row=`<div levAddRow>
        <div levT><input type="text" value="${txt}"/></div>
        <div levY class="i30 i30_done"></div>
        <div levX class="i30 i30_x"></div>
    </div>`;
       
    $('[noteInput]').html('');
    if(lev){
        $('[levtxt='+lev+']').after('<div noteInput no="'+lev+'">'+row+'</div>');
    }else{
        notBlc.find('[noteInput]').html(row);
    }
    notBlc.find('input').focus();
    setEnterBut(notBlc);
}
function addLevTxt(){
    notBlc=$('[lev='+actLevelAdd+']');
    levTxt=notBlc.find('input').val();
    if(levTxt){
        notBlc.find('[levAddRow]').hide();
        notBlc.find('[noteinput]').append(loader_win);
        $.post(f_path+"X/den_prv_oprs_lev_add.php",{vis:visit_id,lev:actLevelAdd,txt:levTxt,id:actLevTxtEdit},function(data){
            d=GAD(data);
            if(d){
                notBlc.find('.loadeText').remove();
                if(actLevTxtEdit){                    
                    addStrLevTxt(d,levTxt);
                }else{                                        
                    addStrLevTxt(d,levTxt);
                    addnotrInput();                    
                    $('[lev='+actLevelAdd+'] [levdone][req="1"]').show();
                }
            }else{
                notBlc.find('[levadd]').show();
                nav(3,'خطأ بإدخال البيانات');
            }
            $('[lev]').find('.loadeText').remove();
            fixPage();		
            fixForm();            
        })
    }
}
function closelevTxt(){
    notBlc=$('[lev='+actLevelAdd+']');
    notBlc.find('[levAdd]').show();
    notBlc.find('[noteInput]').html('');
}
function addStrLevTxt(id,txt){
    notBlc=$('[lev='+actLevelAdd+']');    
    var d = new Date($.now());
    dt=d.getFullYear()+"-"+(d.getMonth() + 1)+"-"+d.getDate();
    if(actLevTxtEdit){
        $('[levTxt='+id+'] [t]').html(txt);
        $('[levTxt='+id+']').attr('new',1);
        $('[levTxt='+id+']').slideDown(500);        
    }else{
        levTxt=`<div class="levTxt w100 hide" levTxt="${id}" new>
            <div d><ff14>${dt} |</ff14></div>
            <div t class="f1 fs14">${txt}</div>
            <div class="i30 i30_del" title="`+k_delete_note+`" levDel butt></div>
            <div class="i30 i30_edit" title="`+k_edit+`" levEdit butt></div>            
        </div>`;
        notBlc.find('[levtxts]').append(levTxt);
        $('[levTxt='+id+']').hide();
        $('[levTxt='+id+']').slideDown(500);        
    }
}
function setEnterBut(notBlc){
	notBlc.find('input').keypress(function(e){
		var key = e.which;
		if(key==13){addLevTxt();}
	});   
}
function editlevTxt(txtId){
    id=$('[levtxt='+txtId+']').closest('[lev]').attr('lev');
    newLevNote(id,txtId)
}
function dellevTxt(id){
	open_alert(id,'den_33',k_confirm_note_del,k_delete_note);
}
function dellevTxtDo(id){
	loader_msg(1,k_loading);    
    $('[levtxt='+id+']').css('background-color','#faa');    
	$.post(f_path+"X/den_prv_oprs_lev_del.php",{id:id}, function(data){
		d=GAD(data);
		if(d==1){
            $('[levtxt='+id+']').find('[butt]').remove();
            $('[levtxt='+id+']').slideUp(1500,function(){$(this).remove();});
            //alert($('[lev='+actLevelAdd+'] [levtxt]').length)
            if($('[lev='+actLevelAdd+'] [levtxt]').length<=1){
                $('[lev='+actLevelAdd+'] [levdone][req="1"]').hide();    
            }
            msg='';
            mt=1;
        }else{
            msg=k_error_data;mt=0;            
            $('[levtxt='+id+']').css('background-color','');
        }
		loader_msg(0,msg,mt);
	})
}
function prvDEnd(rate=1){	
    openLasWin(k_endvis);
	$.post(f_path+"X/den_prv_end.php",{id:visit_id,rate:rate},function(data){
		d=GAD(data);        
        if(d=='rate'){
            loader_msg(0,'',0);
            inWinDClose();
            rateNurs(4,visit_id);
        }else{
            $('#iwB').html(d);
        }
		fixForm();
		fixPage();
	})
}
function prvEndDo(){
	pay=parseInt($('#denPay').val());
	maxPay=parseInt($('#denPay').attr('max'));
	if(pay>maxPay){
		nav(4,k_mnt_gr_val);
	}else{
        inWinDClose();
		loader_msg(1,k_loading);
		$.post(f_path+"X/den_prv_end_do.php",{id:visit_id,pay:pay},function(data){
			d=GAD(data);	
			if(d==1){				
				loader_msg(1,k_done_successfully,1);				
				loc('_visit-Den');
			}else{				
				loader_msg(0,k_error_data,0);
			}			
		})
	}
}
function prvDenPrice(){
    openLasWin(k_price_serv);
	$.post(f_path+"X/den_prv_srv_price.php",{id:d_actOpr},function(data){
		d=GAD(data);		
        $('#iwB').html(d);
		fixForm();
		fixPage();
	})
}
function prvDenPriceSave(){
	dPrice=$('#srvDPrice').val();	
	inWinDClose();
	loader_msg(1,k_loading);
	$.post(f_path+"X/den_prv_srv_price_save.php",{id:d_actOpr,p:dPrice}, function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;}else{msg=k_error_data;mt=0;}	
		loader_msg(0,msg,mt);
        d_showOpr(d_actOpr);		
	})
}
/*********************************************************/
var actTeethType=1;
var actTeeth=0;
var actTStatus=0;
var actTStatusSub=0;
var actTType=0;
var actTClr=0;
var actTeethSub=1;
function setDenteeth(){
    $('#teethDetiaSec').on('click','[teethSw]',function(){swTeethType();})
    $('#denDetiaSec').on('click','[t]',function(){
        actTeeth=$(this).attr('t');
        showTeeth();
    })
    $('.tToolH [no]').click(function(){
        no=$(this).attr('no');
        $('.tToolH [no],.tToolH [noS],.tToolH [noP]').removeClass('disBlock');        
        if(no!=actTStatus){mo=1;}else{mo=2;}
        selTeethMood(mo,no,1);
    })
    $('.tToolH [noS]').click(function(){
        no=$(this).attr('noS');
        $('.tToolH [no],.tToolH [noS]').removeClass('disBlock');        
        if(no!=actTStatusSub){mo=1;}else{mo=2;}
        selTeethMood(mo,no,2);
    })
    $('.tToolH [noP]').click(function(){
        no=$(this).attr('noP');
        actTStatus=no;
        if($('.tToolH [subTee='+no+']').is(':hidden')){
            $('.tToolH [subTee='+no+']').slideDown(500);
        }else{
            $('.tToolH [subTee='+no+']').slideUp(500);
        }
        $('.tToolH [no]').removeClass('disBlock');
        $('.tToolH [noS]').removeClass('disBlock');
        $('.tToolH [noP]').removeClass('disBlock');
        if(no!=actTStatus){mo=1;}else{mo=2;}
        selTeethMood(2,0,2);
    })
    $('#teethMap[selMood]').on('click','[t]',function(){
        n=$(this).attr('t');
        if(actTType==0){
            showTeeth(1,n)
        }else{
            changeTeethSt(actTType,n);
        }
    });
    $('#teethMap[selMood]').on('click','[r]',function(){
        n=$(this).attr('r');
        if(actTType==0){
            showTeeth(2,n)
        }else{
            changeTeethSt(actTType,n);
        }
    });
    $('[closeTeeth]').click(function(){$('[theethMap]').attr('theethMap',1);actTeeth=0;showTeethMap();})
    $('[closeTee]').click(function(){
        //$('[theethMap]').attr('theethMap',1);
        selTeethMood(2,0,2);
    })
    /***************************************/
    $('.tToolHS [no]').click(function(){
        no=$(this).attr('no');
        $('.tToolHS[teethSub="'+actTeethSub+'"] [no],.tToolHS[teethSub="'+actTeethSub+'"] [noS],.tToolHS[teethSub="'+actTeethSub+'"] [noP]').removeClass('disBlock');        
        if(no!=actTStatusS){mo=1;}else{mo=2;}
        selTeethMoodSub(mo,no,1);
    })
    $('.tToolHS [noS]').click(function(){
        no=$(this).attr('noS');
        $('.tToolHS[teethSub="'+actTeethSub+'"] [no],.tToolHS[teethSub="'+actTeethSub+'"] [noS]').removeClass('disBlock');        
        if(no!=actTStatusSubS){mo=1;}else{mo=2;}
        selTeethMoodSub(mo,no,2);
    })
    $('.tToolHS [noP]').click(function(){
        no=$(this).attr('noP');
        actTStatusS=no;
        if($('.tToolHS[teethSub="'+actTeethSub+'"] [subTee='+no+']').is(':hidden')){
            $('.tToolHS[teethSub="'+actTeethSub+'"] [subTee='+no+']').slideDown(500);
        }else{
            $('.tToolHS[teethSub="'+actTeethSub+'"] [subTee='+no+']').slideUp(500);
        }
        $('.tToolHS[teethSub="'+actTeethSub+'"] [no]').removeClass('disBlock');
        $('.tToolHS[teethSub="'+actTeethSub+'"] [noS]').removeClass('disBlock');
        $('.tToolHS[teethSub="'+actTeethSub+'"] [noP]').removeClass('disBlock');
        if(no!=actTStatusS){mo=1;}else{mo=2;}
        selTeethMoodSub(2,0,2);
    })
    $('[teethInfo][selMoodS]').on('click','[p]',function(){               
        n=$(this).attr('tsp');
        if(actTTypeS!=0){            
            changeTeethStSub(actTTypeS,n);
        }
    });
    $('[teethInfo][selmoods]').on('click','[crn]',function(){               
        crn=$(this).attr('crn');   
        actCavOrd=crn;
        showTeeth(actTeethSub,actTeeth);
    });
    $('[closeTeeS]').click(function(){selTeethMoodSub(2);})       
}
function selTeethMood(mo,no=0,t=1){  
    selTeethMoodSub(2);
    if(mo==1){
        if(t==1){//main Opr
            actTStatus=no;            
            $('.tToolH [no]:not([no="'+no+'"]').addClass('disBlock');
            $('.tToolH [noP]').addClass('disBlock');
            $('.tToolH [noS]').addClass('disBlock');
            actTClr=$('.tToolH [no="'+no+'"]').attr('clr');
            tTxt=$('.tToolH [no="'+no+'"]').attr('txt');
            actTType=$('.tToolH [no="'+no+'"]').attr('partType');
            $('.theethMsg').css('background-color',actTClr);
            $('.theethMsg span').html(tTxt);
            $('.theethMsg').slideDown(500);
            $('#teethMap').attr('selMood',actTType);
        }else{// Sub Opr
            actTStatusSub=no;
            actTStatus=$('.tToolH [noS="'+no+'"]').attr('pno');
            $('.tToolH [no]').addClass('disBlock');
            $('.tToolH [noP]').addClass('disBlock');
            $('.tToolH [noS]:not([noS="'+no+'"]').addClass('disBlock');
            actTClr=$('.tToolH [noP="'+actTStatus+'"]').attr('clr');
            tTxt=$('.tToolH [noS="'+no+'"]').attr('txt');
            actTType=$('.tToolH [noS="'+no+'"]').attr('partType');
            $('.theethMsg').css('background-color',actTClr);
            $('.theethMsg span').html(tTxt);
            $('.theethMsg').slideDown(500);
            $('#teethMap').attr('selMood',actTType);
        }
    }else{
        $('.theethMsg').slideUp(500);
        $('.tToolH [no],.tToolH [noS],.tToolH [noP]').removeClass('disBlock');
        actTType=0;
        actTStatus=0;
        actTStatusSub=0;        
        $('#teethMap').attr('selMood','0');
    }
}
function changeTeethSt(type,n){
    if(type==1){
        t=$('#teethMap[selMood="1"] [t="'+n+'"]');
        st=t.attr('s');
        if(actTStatus!=st){
            t.css('background-color','#333');
            t.attr('s',actTStatus);
            saveTheethSt(t,type,n,0);
        }else{
            t.css('background-color','');
            t.attr('s','0');
            saveTheethSt(t,type,n,0,2);
        }
    }else{
        r=$('#teethMap[selMood="2"] [r="'+n+'"]');        
        st=r.attr('s');
        if(actTStatus!=st){
            r.css('background-color','#333');
            r.attr('s',actTStatus);
            saveTheethSt(r,type,n,0);
        }else{
            r.css('background-color','');
            r.attr('s','0');
            saveTheethSt(r,type,n,0,2);
        }
    }
}
function saveTheethSt(obj,type,teeth,teeth_part,oprT='1'){//oprT=1 --> ADD oprT=2 -- >Delete    
    obj.addClass('tLoader');
	$.post(f_path+"X/den_prv_teeth_opr.php",{vis:visit_id,type:type,teeth:teeth,opr:actTStatus,oprSub:actTStatusSub,oprT:oprT,teeth_part:teeth_part},function(data){
		d=GAD(data);
        if(oprT==1){
            obj.css('background-color',actTClr);
            obj.attr('title',tTxt);
        }else{
            obj.css('background-color','');
            obj.removeAttr('title');
        }
        obj.removeClass('tLoader');
        fixForm();
		fixPage();		
	}) 
}
function swTeethType(){
    $('#teethDetiaSec [tt='+actTeethType+']').slideUp(300);
    if(actTeethType==1){actTeethType=2;}else{actTeethType=1}
    $('#teethDetiaSec [tt='+actTeethType+']').slideDown(300);    
    showTeethMap();
}
function showTeethMap(id=0,l=1){
    if(l==1){$('#teethMap').html(loader_win);}
    $('#teethMap').attr('selMood','0');
    selTeethMood(2);
    $('[theethMap]').attr('theethMap',1);
	$.post(f_path+"X/den_prv_teeth.php",{vis:visit_id,id:id,t:actTeethType},function(data){
		d=GAD(data);
        $('#teethMap').html(d);        
        fixForm();
		fixPage();		
	})   
}
function showTeeth(t,n){
    selTeethMoodSub(2);
    $('[teNote]').hide();
    actTeethSub=t;
    $('[actTeethSel]').removeAttr('actTeethSel');
    if(t==1){
        $('[t="'+n+'"]').attr('actTeethSel','1');       
    }else{
        $('[r="'+n+'"]').attr('actTeethSel','1');
    }
    actTeeth=n;
    $('[teethSub]').hide();
    $('[teethSub="'+t+'"]').show();
    $('[teethTitle]').html('');
    $('[theethMap]').attr('theethMap',2);
    $('[teethInfo]').html(loader_win);
	$.post(f_path+"X/den_prv_teeth_info.php",{vis:visit_id,n:actTeeth,t:t,r:actCavOrd},function(data){
		d=GAD(data);
        dd=d.split('^');
        $('[teethTitle]').html(dd[0]);
        $('[teethInfo]').html(dd[1])        
		fixForm();
		fixPage();
	})
}
/******************************/
var actTTypeS=0;
var actTStatusS=0;
var actTStatusSubS=0;
function selTeethMoodSub(mo,no=0,t=1){    
    if(mo==1){
        if(t==1){//main Opr
            actTStatusS=no;
            $('.tToolHS [no]:not([no="'+no+'"]').addClass('disBlock');
            $('.tToolHS [noP]').addClass('disBlock');
            $('.tToolHS [noS]').addClass('disBlock');
            actTClr=$('.tToolHS [no="'+no+'"]').attr('clr');
            tTxt=$('.tToolHS [no="'+no+'"]').attr('txt');
            actTTypeS=$('.tToolHS [no="'+no+'"]').attr('partType');
            $('.theethMsgS').css('background-color',actTClr);
            $('.theethMsgS span').html(tTxt);
            $('.theethMsgS').slideDown(500);
            $('[teethInfo]').attr('selMoodS',actTTypeS);
        }else{// Sub Opr
            actTStatusSubS=no;
            actTStatusS=$('.tToolHS [noS="'+no+'"]').attr('pno');
            $('.tToolHS [no]').addClass('disBlock');
            $('.tToolHS [noP]').addClass('disBlock');
            $('.tToolHS [noS]:not([noS="'+no+'"]').addClass('disBlock');
            actTClr=$('.tToolHS [noP="'+actTStatusS+'"]').attr('clr');
            tTxt=$('.tToolHS [noS="'+no+'"]').attr('txt');
            actTTypeS=$('.tToolHS [noS="'+no+'"]').attr('partType');
            $('.theethMsgS').css('background-color',actTClr);
            $('.theethMsgS span').html(tTxt);
            $('.theethMsgS').slideDown(500);
            $('[teethInfo]').attr('selMoodS',actTTypeS);
        }
    }else{
        $('.theethMsgS').slideUp(500);
        $('.tToolHS [no],.tToolHS [noS],.tToolHS [noP]').removeClass('disBlock');
        actTTypeS=0;
        actTStatusS=0;
        actTStatusSubS=0;        
        $('[teethInfo]').attr('selMoodS','0');
    }
}
function changeTeethStSub(type,n){
    if(type==1){        
        t=$('[teethInfo][selMoodS] [tsp="'+n+'"]');        
        st=t.attr('a');        
        if(actTStatusS!=st){
            t.css('background-color','#333');
            t.attr('a',actTStatusS);
            saveTheethStSub(t,type,n);
        }else{
            t.css('background-color','');
            t.attr('a','0');
            saveTheethStSub(t,type,n,2);
        }
    }else{
        r=$('[teethInfo][selMoodS] [tsp="'+n+'"]');        
        st=r.attr('s');
        if(actTStatusS!=st){
            r.css('background-color','#333');
            r.attr('s',actTStatusS);
            saveTheethStSub(r,type,n);
        }else{
            r.css('background-color','');
            r.attr('s','0');
            saveTheethStSub(r,type,n,2);
        }
    }
}
function saveTheethStSub(obj,type,teeth_part,oprT='1'){//oprT=1 --> ADD oprT=2 -- >Delete     
    obj.addClass('tLoader');
	$.post(f_path+"X/den_prv_teeth_opr_part.php",{vis:visit_id,type:type,teeth:actTeeth,opr:actTStatusS,oprSub:actTStatusSubS,oprT:oprT,teeth_part:teeth_part,c:actCavOrd},function(data){
		d=GAD(data);
        if(oprT==1){
            obj.css('background-color',actTClr);
            obj.attr('title',tTxt);
        }else{
            obj.css('background-color','');
            obj.removeAttr('title');
        }
        obj.removeClass('tLoader');
        fixForm();
		fixPage();		
	})
}
/*****************************************/
function denHisN(id,vis){
	desHisAct=id;
	openLasWin(k_proced_his);
	$.post(f_path+"X/den_prv_his.php",{id:id,vis:vis},function(data){
		d=GAD(data);
		$('#iwB').html(d);
		hisMood=$('#dHisType').val();
		loadHisMoodN(hisMood,0);
		fixForm();
		fixPage();		
	})
}
function loadHisMoodN(t,t_id){
	$('#hisDes , #hisList').html(loader_win);
	$.post(f_path+"X/den_prv_his.php",{id:desHisAct,type:t,vis:t_id},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
			$('#hisList').html(dd[0]);
			$('#hisDes').html(dd[1]);			
			fixForm();
			fixPage();
		}
	})
}
/*****************************/
var actHis_cat=0;
var actRecN=0;
var serd_his='';
function setDenOther(){    
    $('.centerSideInFull').on('click','[addHisItem]',function(){denMenHis_add();})
    $('#iwB').on('change','#addCat',function(){actHis_cat=$(this).val();denMenHis_items();})
    $('#iwB').on('click','[hisCat]',function(){actHis_cat=$(this).attr('hisCat');denMenHis_items();})
    $('#iwB').on('keyup','#his_src',function(){his_it_srDen();})
    $('#iwB').on('click','[loadMore]',function(){
		actRecN++;
		$('#his_ItData').append(loader_win);
		$(this).remove();
		denMenHis_items(actRecN);
	})
    $('#iwB').on('click','[ih]',function(){
        let id=$(this).attr('ih')
        loadDenHisIt(id);
    })
    $('#iwB').on('click','#saveHisDen',function(){sub('mHis');})
     $('#iwB').on('click','[addHisNItDen]',function(){		
		cat=$('#addCat').val();
		src=$('#his_src').val();
		addNewHItDen(cat,src);
	})
    $('.centerSideInFull').on('click','[edthisD]',function(){denMenHis_add($(this).attr('edthisD'));})
    $('.centerSideInFull').on('click','[delhisD]',function(){delHisItD($(this).attr('delhisD'));})
}
function addNewHItDen(cat,src){
	it='';
	if(cat!=0){it='cat:'+cat+':h';}	
	co_loadForm(0,3,"sd53d8g39x|id|loadDenHisIt([id])|"+it);	
}
function denMenHis_add(id=0){
    actHis_cat=0;
    actRecN=0;
    openLasWin('إضافة سوابق مرضية');
	$.post(f_path+"X/den_prv_medhis_add.php",{id:id,vis:visit_id,pat:patient_id},function(data){
		d=GAD(data);		
        $('#iwB').html(d);
        $('#his_src').focus()
        if(id){
            loadDenHisIt(0,id);
        }else{
            denMenHis_items();
        }
		fixForm();
		fixPage();
	})
}
function his_it_srDen(){clearTimeout(serd_his);serd_his=setTimeout(function(){denMenHis_items();},800);}
function denMenHis_items(r=0){
	actRecN=r;
    $('#addCat').val(actHis_cat);
	sr=$('#his_src').val();
	his_cat=$('#addCat').val();
	if(r==0){$('#his_ItData').html(loader_win);}
	$.post(f_path+"X/den_prv_medhis_add_items.php",{vis:visit_id,r:r,sr:sr,cat:actHis_cat},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
			$('#his_ItTot').html(dd[0]);
			if(r==0){
				$('#his_ItData').html(dd[1]);
			}else{
				$('#his_ItData').append(dd[1]);
				$('#his_ItData .loadeText').remove();
			}
		}else{
			$('#his_ItTot').html('');
			$('#his_ItData').html('');
		}
		//his_set();
		fixPage();
		fixForm();
	})
}
function loadDenHisIt(itId,id=0){
    $('#denHsform').html(loader_win);	
	$.post(f_path+"X/den_prv_medhis_add_form.php",{vis:visit_id,itId:itId,id,id},function(data){
		d=GAD(data);
		$('#denHsform').html(d);
		loadFormElements('#mHis');			
		setupForm('mHis','');		
		fixPage();
		fixForm();
	})
}
function viewMHisCB(){    
    inWinDClose();
    showOprsList();
}
function delHisItD(id){
    open_alert(id,'den_delh','هل توجد حذف هذا العنصر ؟','حذف العنصر');
}
function delHisItDDo(id){
	$('[his_items]').html(loader_win);
	$.post(f_path+"X/den_prv_medhis_add_del.php",{vis:visit_id,pat:patient_id,id:id},function(data){
		d=GAD(data);
		$('[his_items]').html(d);
		viewMHisCB();
		fixPage();
		fixForm();
	})
}
/****************/
var actClDNSel=0;
function setDenClinical(){    
    $('.centerSideInFull .clinicDenList').on('click','[n]',function(){        
        showClinicalinfo($(this).attr('n'));
    })
    $('.centerSideInFull').on('click','[addDenCln]',function(){
        id=$(this).attr('addDenCln');
        r_id=$(this).attr('n');
        title=$(this).closest('.clinicDenListIn [tit]').find('[t]').html();
        addClinicalinfo(id,title,r_id);
    })
    $('#iwB').on('click','[par=chDC]',function(){
        ch_name=$(this).attr('ch_name');
        ch=CBV(ch_name);
        if(ch){            
            $('[name='+ch_name+'_in]').show();
            $('[name='+ch_name+'_in]').focus();
        }else{
            $('[name='+ch_name+'_in]').hide();
        }
    })
    $('#iwB').on('click','[par=riDC]',function(){        
        ri_name=$(this).attr('name');
        riIn=$('#ri_'+ri_name).val();        
        parVal='';
        if(riIn){
            parVal=$('.radioBlc[name='+ri_name+']').find('[ri_val='+riIn+']').attr('par');
        }        
        if(parVal=='1'){            
            $('[name='+ri_name+'_in]').show();
            $('[name='+ri_name+'_in]').focus();
        }else{
            $('[name='+ri_name+'_in]').hide();
        }
    })
    $('#iwB').on('click','[saveDenCLn]',function(){sub('dcf');})
    $('.centerSideInFull').on('click','[delDenCln]',function(){
        id=$(this).attr('delDenCln');
        delClinicalinfo(id);
    })
}
function showClinicalinfo(id=0,l=1){
    showDenClinc(id);
}
function showDenClinc(n){
    actClDNSel=n;
    $('#denClinicaDet').html(loader_win);    
	$.post(f_path+"X/den_prv_cln.php",{id:n,vis:visit_id,pat:patient_id},function(data){
		d=GAD(data);
		$('#denClinicaDet').html(d);        
        fixPage();
        fixForm();
	})
}
function addClinicalinfo(n,title='',r=0){
    openLasWin(title);   
	$.post(f_path+"X/den_prv_cln_add.php",{id:n,r:r,vis:visit_id,pat:patient_id},function(data){
		d=GAD(data);
		$('#iwB').html(d);
        loadFormElements('#dcf');			
		setupForm('dcf','');
        fixPage();
        fixForm();
	})
}
function denClnSaCb(){
    inWinDClose();
    showDenClinc(actClDNSel);
}
function delClinicalinfo(id){
    open_alert(id,'den_cln_del','هل تود حذف هذا السجل','حذف السجل');
}
function delClinicalinfoDo(id){    
    loader_msg(1,k_loading);
	win('close','#m_info');	
	$.post(f_path+"X/den_prv_cln_del.php",{id:id}, function(data){
		d=GAD(data);
		if(d==1){
			msg=k_done_successfully;mt=1;
			denClnSaCb();
		}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);
	})
}
/***************/
function denCln_showAddVals(t){    
    $('#denCalSet').html(loader_win);
    f=$('#denCalSet').attr('f');    
	$.post(f_path+"X/den_cln_set.php",{t:t,f:f,val:val},function(data){
		d=GAD(data);
		$('#denCalSet').html(d);
        loadFormElements('#co_form0');
        fixPage();
        fixForm();
	})
}
function showDCData(data){    
    $('#denCalSet input').val(data);    
}

function coDos_send(doc=0){
	data=get_form_vals('#wr_input');
	if(doc==0){//show the main report
		$('#coDos_data').html(loader_win);		
		$('[sendCpData]').hide();
		$.post(f_path+"X/den_continuing_report.php",data,function(data){
			d=GAD(data);
			$('#coDos_data').html(d);
			$('[sendCpData]').show(200);
			fixForm();
			fixPage();
		})
	}else{//show x patient list
		loadWindow('#m_info',0,'المرضى الغير مستمرين',www,hhh);		
		data.user=doc;		
		$.post(f_path+"X/den_continuing_report_pats.php",data,function(data){
			d=GAD(data);
			$('#m_info').html(d);			
			fixForm();
			fixPage();
		})
	}
}
/****************************************** */
function delDenSevice(id){	
	open_alert(id,'den_srv_del','سيتم حذف هذه الخدمة وملحقاتها','حذف الخدمة');
}
function delDenSeviceDo(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/den_delete_service_x.php",{id:id},function(data){
		d=GAD(data);
		if(d==1){
			msg=k_done_successfully;mt=1;	
			loadModule('m7q26gogu');		
		}else{
			msg=k_error_data;mt=0;
		}
		loader_msg(0,msg,mt);
	})
}
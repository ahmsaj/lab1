/***BTY***/
$(document).ready(function(e){    
    if(sezPage=='Preview-Laser'){selLsrPreview();}
})
function btyVisitStatus(id,t){
	loadWindow('#m_info',1,k_visit_details,600,0);
	$.post(f_path+"X/bty_visit_add_save_status.php",{id:id,t:t},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
	});
}
function bty_vit_d_ref(l){	
	if(l==1){$('#d2,#d3,#d4').html(loader_win);}
	$.post(f_path+"X/bty_visit_doc_live.php",{},function(data){
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
function bty_rev_ref(l,vis){
	$.post(f_path+"X/bty_preview_info_live.php",{vis:vis},function(data){
		d=GAD(data);
		dd=d.split('^');
		$('#stu_1').html(dd[0]);
		$('#stu_2').html(dd[1]);
		$('#sevises_list').html(dd[2]);
		$('#prv_slider').html(dd[3]);		
		$('#timeStatus').attr('class',dd[4]);
		fixPage();
	});
}
function btyAddNewServ(id){
	loadWindow('#m_info',1,k_services,600,0);	
	$.post(f_path+"X/bty_preview_services_add.php",{id:id}, function(data){
		d=GAD(data);
		$('#m_info').html(d);
		loadFormElements('#n_visit');			
		setupForm('n_visit','m_info');
		fixForm();
		fixPage();
		$('div[par=ceckServ]').click(function(){serTotalCountB();});
	});
}
function serTotalCountB(){
	save=0;
	total=0;
	$('div[par=ceckServ]').each(function(index, element) {
        v=parseInt($(this).attr('ch_val'));
		ch=$(this).children('div').attr('ch');
		if(ch=='on'){total+=v;save=1;}		
    });
	$('#serTotal').html(total);
	if(save==1){
		$('#saveButt').show(200);
		$('#dirButt').hide(200);
		$('#fast_v').show(200);
	}else{
		$('#saveButt').hide(200);
		$('#dirButt').show(200);
		$('#fast_v').hide(200);
	}	
}
function bty_finshSrv(srv,t){
	if(t==2){loc('_Beauty-Visits');}else{
		if(srv==0){bty_endPrv();}else{
			//open_alert(srv,'bty1',k_srv_fsh,k_ed_srv);
			btyEndServis(srv);
		}
	}	
}
function btyEndServis(srv){
	loadWindow('#m_info',1,k_end_pre,500,0);
	$.post(f_path+"X/bty_preview_visit_note.php",{v_id:visit_id,srv:srv},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixPage();
		fixForm();
	});
}
function bty_finshSrvDo(srv){
	loader_msg(1,k_loading);
	note=$('#b_note').val();
	win('close','#m_info');
	$.post(f_path+"X/bty_preview_services_end.php",{vis:visit_id,srv:srv,note:note} ,function(data){
		bty_rev_ref(1,visit_id);
		loader_msg(0,'',0);
	});
}
function bty_endPrv(){
	loader_msg(1,k_loading);
	$.post(f_path+"X/bty_preview_visit_end.php",{v_id:visit_id},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd[0]==1){
			loader_msg(0,'',0);
			loadWindow('#m_info',1,k_end_pre,400,0);
			$('#m_info').html(dd[1]);
			fixPage();
			fixForm();
		}
		if(dd[0]==2){loc('_Beauty-Visits');}
		if(dd[0]==3){loader_msg(0,'',0);nav(2,k_srv_fsh_fr);}
	});
}
var CaleSerTAct=0;
function bty_caclSrv(id,type){
	CaleSerTAct=type;
	textMsg=k_wnt_cnl_srv;
	if(type==2){textMsg=k_rtrn_srv;}	
	open_alert(id,'lsr_1',textMsg,k_cncl_serv);
}
function bty_caclSrvDo(srv){
	$.post(f_path+"X/bty_preview_services_cancel.php",{vis:visit_id,srv:srv},function(data){
		if(CaleSerTAct==1 || CaleSerTAct==2){bty_rev_ref(1,visit_id);}
	});
}
function bty_loadHistory(p_id,t){	
	if(t==0){
		$('#p_his').html(loader_win);
	}else{
		loadWindow('#m_info',1,k_med_his,600,hhh-20);		
	}	
	$.post(f_path+"X/bty_patient_history.php",{p_id:p_id,v_id:visit_id,t:t}, function(data){
		d=GAD(data);
		if(t==0){				
			$('#p_his').html(d);	
		}else{
			$('#m_info').html(d);
			fixForm();		
		}
		fixPage();
	});
}
/****laser***********************************/
var actLPart=0;
var actTypeDelSrv=0;
function setLasVisit(){
	sezPage='BPreview';
	btyl_rev_ref(1);refPage('btyt2',12000);
	fixPage();
	loadLaserServ();
	$('#exWin').click(function(){closeLasWin();})
	$('[addLasSrv]').click(function(){btyLasAddNewServ();})	
}
function openLasWin(title=''){
	$('.inWin').show();
	$('#iwT').html(title);
	$('#iwB').html(loader_win);
}
function closeLasWin(){
	$('.inWin').hide();
	$('#iwT').html('');
	$('#iwB').html('');
}
function btyl_rev_ref(){
	$.post(f_path+"X/bty_lsr_preview_info_live.php",{vis:visit_id},function(data){
		d=GAD(data);
		dd=d.split('^');	
		$('#timeSc').html(dd[0]);		
		$('#patNo').html(dd[1]);
		$('#patWs').attr('class','fl cbg3 '+dd[2]);
        $('#devInfo').html(dd[3]);        
		fixPage();		
		fixForm();		
	})
}
function loadLaserServ(l=0,part=0){
	actLPart=part;
	if(l==1){$('#lsrSerDet').html(loader_win);}
	$.post(f_path+"X/bty_lsr_preview_srv.php",{vis:visit_id,part:part},function(data){
		d=GAD(data);		
		$('#lsrSerDet').html(d);		
		setLasSirvice();
		fixPage();
	})
}
function setLasSirvice(){	
	$('#lasSrvs [s]').click(function(){id=$(this).attr('s');saveLasVals(id);})
	$('#lasSrvs [r]').click(function(){id=$(this).attr('r');returnLasVals(id);})
	$('#lasSrvs [d]').click(function(){id=$(this).attr('d');loadLaserServ(1,id);})	
	$('[delLsrv]').click(function(){id=$(this).attr('delLsrv');delLaserServ(1,id);})
	$('[delPart]').click(function(){delLaserServ(2,actLPart);})
}
function saveLasVals(id){
	err=0;		
	data=get_form_vals('[part'+id+']');
	jQuery.each(data,function(k,val){ 
		if(val==''){
			$('[part'+id+'] [name='+k+']').css('border','1px #f00 solid');
			err=1;
		}else{
			$('[part'+id+'] [name='+k+']').css('border','');
		}
	});
	if(err==0){
		loader_msg(1,k_loading);
		$.post(f_path+"X/bty_lsr_preview_srv_save.php",{vis:visit_id,id:id,data:data},function(data){
			d=GAD(data);		
			if(d==1){msg=k_done_successfully;mt=1;loadLaserServ()}else{msg=k_error_data;mt=0;}
			loader_msg(0,msg,mt);
		})
	}else{
		nav(2,k_req_fields_must_filled);
	}
}
function btyLasAddNewServ(){
	loadWindow('#m_info',1,k_services,600,0);	
	$.post(f_path+"X/bty_lsr_preview_services_add.php",{id:visit_id}, function(data){
		d=GAD(data);
		$('#m_info').html(d);
		loadFormElements('#n_visit');			
		setupForm('n_visit','m_info');
		fixForm();
		fixPage();
		//$('div[par=ceckServ]').click(function(){serTotalCountB();});
	});
}
function delLaserServ(type,id){
	actTypeDelSrv=type;
	open_alert(id,'bty3',k_wld_del_part,k_part_del);
}
function delLaserServDo(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/bty_lsr_preview_srv_del.php",{vis:visit_id,id:id,type:actTypeDelSrv},function(data){
		d=GAD(data);
		if(d==1){			
			loadLaserServ(1);		
			loader_msg(0,k_done_successfully,1);
		}else{
			loader_msg(0,k_error_data,0);
		}		
		fixPage();
		fixForm();
	});	
}
function lasNotes(){
	openLasWin(k_notes);
	$.post(f_path+"X/bty_lsr_notes.php",{vis:visit_id},function(data){
		d=GAD(data);
		dd=d.split('^');
		$('#iwT').html(dd[0]);
		$('#iwB').html(dd[1]);
		$('[addNote]').click(function(){addNewNote();})
		$('[ne]').click(function(){id=$(this).attr('ne');addNewNote(id);})
		$('[nd]').click(function(){id=$(this).attr('nd');delLNote(id);})
		fixPage();
		fixForm();
	});
}
function addNewNote(id=0){co_loadForm(id,3,"2kl1y51jl8|id|lasNotes();|patient:"+patient_id+":h");}
function delLNote(id){open_alert(id,'bty4',k_delete_note,k_confirm_note_del);}
function delLaserNoteDo(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/bty_lsr_notes_del.php",{id:id},function(data){
		d=GAD(data);
		if(d==1){			
			lasNotes();		
			loader_msg(0,k_done_successfully,1);
		}else{
			loader_msg(0,k_error_data,0);
		}		
		fixPage();
		fixForm();
	});
}
function returnLasVals(id){	
	loader_msg(1,k_loading);
	$.post(f_path+"X/bty_lsr_preview_srv_back.php",{vis:visit_id,id:id},function(data){
		d=GAD(data);		
		if(d==1){msg=k_done_successfully;mt=1;loadLaserServ()}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);
	})
}
function bty_finshLsr(){	
	openLasWin(k_endvis);
	$.post(f_path+"X/bty_lsr_preview_visit_end.php",{vis:visit_id},function(data){
		d=GAD(data);				
		$('#iwB').html(d);
		$('#l_c , #l_cS , #l_p , #l_d').click(function(){calLser();});
		$('#l_c , #l_cS , #l_p , #l_d').keyup(function(){calLser();});
		fixPage();
		fixForm();
	});	
}
function calLser(){
	//macC=parseInt($('[macC]').attr('macC'));
    macC=$('#l_cS').val();
	dis=$('#l_d').val();
	lp=$('#l_p').val();if(lp!=''){lp=parseFloat(lp);}else{lp=0;}
	lc=$('#l_c').val();if(lc!=''){lc=parseInt(lc);}else{lp=0;}	
	l_cT=0;
	l_pT=0;
	l_pF=0;
	l_pF2=0;
	if(lc>macC){l_cT=lc-macC;}
	l_pT=l_cT*lp;
	if(l_pT>0){
		l_pF=Math.round(l_pT / 50)*50;
		l_pF2=l_pF;
		if(dis>0){
			l_pF2=l_pF-dis;
		}
	}
	$('#l_cT').html(l_cT);
	$('#l_pT').html(l_pT);
	$('#l_pT2').html(l_pF);
	$('#l_pF').html(l_pF2);
}
function bty_finshLsrDo(){
	p=$('#l_p').val();
    s=$('#l_cS').val();
	c=$('#l_c').val();
	d=$('#l_d').val();
	n=$('#l_note').val();
	if(p!='' && c!=''){
		loader_msg(1,k_loading);
		$.post(f_path+"X/bty_lsr_preview_visit_end_save.php",{vis:visit_id,p:p,c:c,s:s,d:d,n:n},function(data){
			d=GAD(data);
			if(d==1){
				win('close','#m_info');				
				loc('_Laser-Visit');
			}else{
				loader_msg(0,k_error_data,0);
			}	
		});
		
	}else{
		nav(2,k_fields_fill);
	}
}
function bty_cancel(id,t){
	loader_msg(1,k_loading);
	$('#lsrSerDet').html(loader_win);
	$.post(f_path+"X/bty_lsr_preview_visit_cancel.php",{id:id,t:t},function(data){
		d=GAD(data);
		if(d==1){
			if(t==1){loc('_Laser-Visit');}
			if(t==2){btyl_rev_ref(1,visit_id);loader_msg(0,k_done_successfully,1);}
		}else{			
			loader_msg(0,k_error_data,0);
		}
		$('#lsrSerDet').html('');
		fixPage();
		fixForm();
	});	
}
/************************/

function clbir(){
	loadWindow('#m_info',1,k_titration,650,0);
	$.post(f_path+"X/bty_lsr_calibration.php",{vis:visit_id},function(data){
		d=GAD(data);
		$('#m_info').html(d);		
		loadFormElements('#calFor');			
		setupForm('calFor','m_info');
		fixPage();
		fixForm();
	});	
}
function calibCb(){
	if(sezPage=='BPreview'){btyl_rev_ref(1,visit_id);}
	if(sezPage=='vis_bty'){bty_vit_d_ref(1);}
}
function copyLsrVal(id){
	$('[name=flun]').val($('[lv1_'+id+']').html());
	$('[name=pulse]').val($('[lv2_'+id+']').html());
	$('[name=rate]').val($('[lv3_'+id+']').html());
	$('[name=wave]').val($('[lv4_'+id+']').html());
}
function lsrSrvSaveBC(id,data){	
	if(data=='1'){loadLaserServ(id,2);btyl_rev_ref(1,visit_id);}else{
		loader_msg(0,'',0);
		if(data=='x1'){nav(2,k_counter_indicator_less);}
		if(data=='x2'){nav(2,k_no_empty_or_zero);}
	}
}
function cancelBtyVisit(id){
	open_alert(id,'bty_1',k_wnt_trns_cnl_vis,k_cancel_visit);
}
function cancelBtyVisitDo(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/bty_preview_visit_cancel.php",{id:id},function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;loc('_Beauty-Visits'); }else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);
	})
}
function selLsrPreview(){
    $('#lsrSerDet').on('click','[LDN]',function(){changeLsrDev($(this).attr('LDN'));})
}
function changeLsrDev(id){
    $('#lsrSerDet').html(loader_win);
    $.post(f_path+"X/bty_change_device.php",{vis:visit_id,id:id},function(data){
		d=GAD(data);
		loadLaserServ(1);
        btyl_rev_ref();
	})
}
/***OSC***/

function oscVisitStatus(id){	
	loadWindow('#m_info',1,k_visit_details,700,0);
	$.post(f_path+"X/osc_visit_add_save_status.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
}
var oscActSrv=0;
function rev_osc_live(vis){
	$.post(f_path+"X/osc_preview_live.php",{vis:vis},function(data){
		d=GAD(data);		
		$('#oscTime').html(d);
		fixPage();
	})
}
function osc_vit_d_ref(l){	
	if(l==1){$('#d2,#d3,#d4').html(loader_win);}
	$.post(f_path+"X/osc_visit_doc_live.php",{},function(data){
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
function selTeam(id){
	loadWindow('#m_info',1,k_staff,700,0);
	$.post(f_path+"X/osc_team.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info').html(d);		
		loadFormElements('#oscTeam');
		setupForm('oscTeam','m_info');
		fixForm();
		fixPage();
	})
}
function teamInfo(id){
	$('#oTeam').html(loader_win);
	$.post(f_path+"X/osc_team_info.php",{id:id},function(data){
		d=GAD(data);
		$('#oTeam').html(d);
		fixForm();
		fixPage();
	})
}
function setOsc_pro_butts(){
	$('#osc_pro_butts div').click(function(){
		type=$(this).attr('t');
		no=$(this).attr('no');		
		osc_sel_pro(type,no);
	})
}
function osc_sel_pro(type,no,val){
	//alert(type+'-'+no);
	if(type==1){
		co_selLongValFree('xe9oge6kf',"osc_sel_proDo("+no+",[id])|report_id="+no+"||report_id:"+no+":h",0);
	}
	if(type==2){
		co_selLongValFreeMulti('xe9oge6kf',"osc_sel_proDo("+no+",'[id]')|report_id="+no+"||report_id:"+no+":h|"+val,0);
	}
	if(type==3){
		enter_osc_openText(no);
	}
}
function osc_sel_proDo(report,val){
	loader_msg(1,k_loading);
	$.post(f_path+"X/osc_porc_save.php",{srv:oscActSrv,rep:report,val:val},function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;osc_loadProc();}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);
	})
}
function osc_loadProc(){	
	$('#proc').html(loader_win);
	$('#proc_fin').html(loader_win);
	$.post(f_path+"X/osc_porc_view.php",{id:oscActSrv},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
			$('#proc').html(dd[0]);
			$('#proc_fin').html(dd[1]);
			setOsc_pro_butts();
		}
	})
}
function enter_osc_openText(id){
	loadWindow('#m_info',1,k_ent_report,700,0);
	$.post(f_path+"X/osc_porc_opentxt.php",{id:id,srv:oscActSrv},function(data){
		d=GAD(data);
		$('#m_info').html(d);		
		fixForm();
		fixPage();
	})
}
function enter_osc_openText_save(report){
	report_val=$('#reportT2').val();
	if(report_val!=''){
		osc_sel_proDo(report,report_val);
		win('close','#m_info');
	}else{
		nav(2,k_report_not_enterd);
	}	
}
function osc_pro_del(id){
	open_alert(id,'osc_3',k_would_you_like_delete_item,k_report_del);
}
function osc_pro_delDo(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/osc_porc_del.php",{id:id,srv:oscActSrv},function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;osc_loadProc();}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);
	})
}
function oscVisEnd(t){	
	loadWindow('#m_info',1,k_endvis,700,0);
	$.post(f_path+"X/osc_visit_end.php",{v_id:visit_id,t:t},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd[0]==1){
			loader_msg(0,'',0);
			loadWindow('#m_info',1,k_end_pre,400,0);
			$('#m_info').html(dd[1]);
			fixPage();
			fixForm();
		}
		if(dd[0]==2){loc('_Visits-Osc');}		
	})
}
function OSCAddSrv(id){
	co_selLongValFree('iph9atknk',"OSCAddSrvDo([id])|||",0);	
}
function OSCAddSrvDo(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/osc_srv_add.php",{id:id,vis:visit_id},function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;loadOSCaddSrv();}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);
	})
}
function loadOSCaddSrv(){
	$('#oscAddSrv').html(loader_win);
	$.post(f_path+"X/osc_srv_info.php",{id:visit_id},function(data){
		d=GAD(data);
		$('#oscAddSrv').html(d);
		fixForm();
		fixPage();
	})
}
function osc_srv_del(id){
	open_alert(id,'osc_4',k_would_you_like_delete_item,k_del_add_srvs);
}
function osc_srv_delDo(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/osc_srv_del.php",{id:id,vis:visit_id},function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;loadOSCaddSrv();}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);
	})
}
function printOscRep(id){
	print_('osc',1,id);
	//print4(2,id);
}
function oscShowVd(v_id){
	loadWindow('#m_info',1,k_visit_details,700,400);
	$.post(f_path+"X/osc_preview_visit_info.php",{id:v_id},function(data){
		d=GAD(data);				
		$('#m_info').html(d);		
		fixForm();	
		fixPage();
	})
}
function ordOsc(){	
	loadWindow('#m_info',1,k_ord_proceds,400,0);
	$.post(f_path+"X/osc_porc_ord.php",{id:visit_id}, function(data){
		d=GAD(data);	
		$('#m_info').html(d);
		oscOdrSet();
		fixForm();
		fixPage();
	})
}
function oscOdrSet(){
	$('.oscWList').sortable({
		axis: "y",
		cursor: "move",
		distance: 10,
		items: " > div",		
		revert: true,
		tolerance: "pointer"
	});	
}
function saveOscOrd(){
	vals='';
	$('.oscWList div[no]').each(function(){
		n=$(this).attr('no');		
		if(vals){vals+=',';}
		vals+=n;
	})
	if(vals){
		loader_msg(1,k_deleting);		
		$.post(f_path+"X/osc_porc_ord_save.php",{id:visit_id,vals:vals},function(data){
			d=GAD(data);
			if(d==1){
				msg=k_done_successfully;mt=1;
				win('close','#m_info');
				osc_loadProc();
			}else{
				msg=k_error_data;mt=0;
			}
			loader_msg(0,msg,mt);
		})
	}	
}
function cancelOscVisit(id){
	open_alert(id,'osc_c',k_wnt_trns_cnl_vis,k_cancel_visit);
}
function cancelOscVisitDo(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/osc_preview_visit_cancel.php",{id:id},function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;
			loc('_Visits-OSC');			
		}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);
	})
}
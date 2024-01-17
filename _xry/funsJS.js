/***XRY***/
var xnOprId=0;
function xry_vit_d_ref(l){	
	if(l==1){$('#d2,#d3,#d4,#d5').html(loader_win);}
	$.post(f_path+"X/xry_visit_doc_live.php",{},function(data){
		d=GAD(data);
		dd=d.split('^');
		$('.top_icons').html(dd[0]);
		$('#d1').html(dd[1]);
		$('#d2').html(dd[2]);
		$('#d3').html(dd[3]);
		$('#d4').html(dd[4]);
		$('#d5').html(dd[5]);
		fixPage();
		fixForm();
	})
}
function xry_rev_ref(l,vis){
	$.post(f_path+"X/xry_preview_info_live.php",{vis:vis},function(data){
		d=GAD(data);
		dd=d.split('^');//alert(dd[0])
		$('#stu_1').html(dd[0]);
		$('#stu_2').html(dd[1]);		
		$('#prv_slider').html(dd[2]);		
		$('#timeStatus').attr('class',dd[3]);
		fixPage();		
		fixForm();
	})
}
var xryActSrv=0;
function xry_prv_srvs(vis,srv){
	xryActSrv=srv;
	$('#sevises_list').html(loader_win);
	$.post(f_path+"X/xry_preview_services.php",{id:vis,srv:srv},function(data){
		d=GAD(data);
		dd=d.split('^');
		$('#xsrvN').html(dd[0]);
		$('#sevises_list').html(dd[1]);		
		fixPage();
		x_report(xryActSrv,0);
	})
}
var actXryRep='';
function x_report(id,r){
	actXryRep=id;
	$('#sevises_data').html(loader_win);
	$.post(f_path+"X/xry_preview_x_report.php",{id:id,r:r}, function(data){
		d=GAD(data);
		dd=d.split('^');
		$('#srvTitle').html(dd[0]);
		/*$('#srvAction').html(dd[1]);*/
		$('#sevises_data').html(dd[1]);
		$('[repEdit]').click(function(){XeditReport();})
		loadFormElements('#x_rep_form');			
		setupForm('x_rep_form','');
		fixForm();
		fixPage();
		
	})
}
function XeditReport(t=0){
	loadWindow('#full_win5',1,k_report_edit,www,hhh);
	$.post(f_path+"X/xry_preview_x_report_edit.php",{id:actXryRep,t:t}, function(data){		
		d=GAD(data);		
		$('#full_win5').html(d);
		fixForm();
		fixPage();
		// $("textarea.m_editor").ckeditor(function(){
		// 	$(this).height(500)
		// 	fixForm();
		// 	fixPage();
		// });
		setEditor();
	})
}
function saveXRep(){
	content=$('#report_txt').val()
	
	// content = CKEDITOR.instances.report_txt.getData();		
	// content=content.replace(/:/g,'&colon;').replace(/\n/g,'<br>');
	loader_msg(1,k_loading);	
	$.post(f_path+"X/xry_preview_x_report_save.php",{id:actXryRep,rep:content},function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;$('.xRepView').html(content);win('close','#full_win5');			
		}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);
	})
	
}
function xry_caclSrv(id,type){
	CancleSerTypeAct=type;
	textMsg=k_wnt_cnl_srv;
	if(type==2){textMsg=k_rtrn_srv;}	
	open_alert(id,'xry_1',textMsg,k_cncl_serv);
}
function xry_caclSrvDo(srv){
	$.post(f_path+"X/xry_preview_services_cancel.php",{vis:visit_id,srv:srv},function(data){
		if(CancleSerTypeAct==1 || CancleSerTypeAct==2){		
			xry_prv_srvs(visit_id,srv);;
		}else{xryShowVd(visit_id);}
	})
}
function xry_openSrv(id,vis=0){
	vvv=visit_id;
	if(vis!=0){vvv=vis;}
	$.post(f_path+"X/xry_preview_services_open.php",{vis:vvv,srv:id},function(data){
		if(sezPage=='Preview-Xray'){xry_prv_srvs(vvv,id);}
		if(sezPage=='vis_xry'){xry_erep(id);}
		
	})
}
function xryShowVd(v_id){
	loadWindow('#m_info',1,k_visit_details,700,400);
	$.post(f_path+"X/xry_preview_visit_info.php",{id:v_id},function(data){
		d=GAD(data);				
		$('#m_info').html(d);		
		fixForm();	
		fixPage();
	})
}
function xry_endPrv(){
	loader_msg(1,k_loading);
	$.post(f_path+"X/xry_preview_visit_end.php",{v_id:visit_id},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd[0]==1){
			loader_msg(0,'',0);
			loadWindow('#m_info',1,k_end_pre,400,0);
			$('#m_info').html(dd[1]);
			fixPage();
			fixForm();
		}
		if(dd[0]==2){loc('_Visits-XRY');}
		if(dd[0]==3){loader_msg(0,'',0);nav(2,k_srv_fsh_fr);}
	})
}
function newReportX(id,srv,doc){
	co_loadForm(0,3,'pb6203sn8y|id|x_report('+id+',[id])|doc:'+doc+':h,srv:'+srv+':h');
}
function loadXryRep(id,pat){
	$('#report_txt').val(loader_win);
	$.post(f_path+"X/xry_preview_x_report_template_apply.php",{id:id,pat:pat}, function(data){
		d=GAD(data);
		//$('textarea[name=cof_8q8n7fk5g2]').val(d);
		$('#report_txt').val(d);
		fixForm();
		fixPage();
	})	
}
function x_report_print(id){
	print_('xry',1,id);
}
var actXClinic=0;
function new_xphoto(id,c,type,name){
	actXClinic=c;
	nx_id=id;nx_type=type;nx_name=name;nx_c=c;
	ttt=k_radio_graphies;
	if(type==2){ttt=name;}
	loadWindow('#m_info2',1,ttt,www,hhh);
	$.post(f_path+"X/xry_preview_radiology_new.php",{v_id:visit_id,id:id,t:type,c:c}, function(data){
		d=GAD(data);
		$('#m_info2').html(d);
		loadFormElements('#l_xp');		
		setupForm('l_xp','m_info2');
		resXXSet();
		resXXSet2(0);
		fixForm();
		fixPage();
	})		
}

function xph_ls(){
	$('.xph_ls').click(function(){
		a_id=$(this).attr('a_id');
		act_xph_detales=a_id;
		slexp_d(a_id);
	})
}
function drowXPRow(an_id){	
	this_a=$(".ana_list_mdc div[mdc='"+an_id+"']");
	del=this_a.attr('del');	
	if(del==0){
		name=this_a.attr('name');
		price=this_a.attr('price');
		this_a.attr('del','1');			
		fixPage();
		if($('.list_del[no="'+an_id+'"]').length==0){
			dd='<tr class="aalLinst " mdc="'+an_id+'" p="'+price+'"><input name="s_'+an_id+'" type="hidden" value="1"><td class=" f1 fs14 lh30 ws">'+name+'</td><td><div class="ic40 icc2 ic40_del fl" delAna="'+an_id+'" title="'+k_delete+'"></div></td>\
			</tr>';
			$('#srvData').append(dd);
			$('#saveButt').show(300);
			resXXSet2(an_id);
		}
		$('#ssin').val('');$('#ssin').focus();
		serServIN('');
	}
}
function resXXSet(){
	$('.ana_list_cat div').click(function(){
		num=$(this).attr('cat_num');
		if(actAnaCat!=num){
			$(this).addClass('actCat');
			$(this).removeClass('norCat');						
			$('.ana_list_cat div[cat_num='+actAnaCat+']').addClass('norCat');
			$('.ana_list_cat div[cat_num='+actAnaCat+']').removeClass('actCat');				
			if(num==0){
				$('.ana_list_mdc div[del=0]').slideDown(400);	
			}else{	
				$('.ana_list_mdc div[del=0]').slideUp(400);
				$('.ana_list_mdc div[cat_mdc='+num+'][del=0]').slideDown(400);								
			}
			actAnaCat=num;
			$('#ssin').val('');$('#ssin').focus();serServIN('');
		}		
	})
	$('.ana_list_mdc div[s="0"]').click(function(){
		mdc=$(this).attr('mdc');		
		drowXPRow(mdc);
	})
}
function resXXSet2(id){
	$('.ana_list_mdc div[del=1]').slideUp(300);
	$('[delAna='+id+']').click(function(){
		id=$(this).attr('delAna');
		$(this).closest('tr').remove();				
		$('.ana_list_mdc div[mdc='+id+']').slideDown(400);
		$('.ana_list_mdc div[mdc='+id+']').attr('del','0');
		if($('[delAna]').length==0){
			$('#saveButt').hide(300);
		}
	})
}
/*function EditXReport(s_id,id,m_id){	co_loadForm(s_id,3,'ggtkw9gfn8||slexp_d('+id+')|xph_id:'+id+':h,mad_id:'+m_id+':h,status:1:hh');
}*/

function edit_xphoto(){
	new_xphoto(act_xph_detales,0,2,'');
}


function xrySendpx(id){
	loadWindow('#m_info2',1,k_send_tests,700,350);	
	$.post(f_path+"X/xry_preview_radiology_send.php",{id:id},function(data){
		d=GAD(data);		
		$('#m_info2').html(d);		
		loadFormElements('#l_xp');
		setupForm('l_xp','m_info2');		
		fixForm();
		fixPage();		
	})
}
function xrySendpxN(id){	
    loader_msg(1,k_loading);
	$.post(f_path+"X/xry_preview_radiology_send.php",{id:id},function(data){
		d=GAD(data);
		if(d==1){
			msg=k_done_successfully;mt=1;             
            m_xphotoN(id);
		}else{
			msg=k_error_data;mt=0;
		}		
		loader_msg(0,msg,mt);		
	})
}
function pxRequ(id){
	loadWindow('#m_info',1,k_send_tests,700,350);	
	$.post(f_path+"X/xry_preview_radiology_receive.php",{id:id},function(data){
		d=GAD(data);		
		$('#m_info').html(d);		
		loadFormElements('#n_visit');
		setupForm('n_visit','m_info');
		fixForm();
		fixPage();		
	})
}
function veiwPxResult(id){
	loadWindow('#m_info2',1,k_img_view,600,hhh);	
	$.post(f_path+"X/xry_preview_radiology_view.php",{id:id},function(data){
		d=GAD(data);		
		$('#m_info2').html(d);			
		fixForm();
		fixPage();		
	})
}
function prvSaveXp(id){
	res_v=$('#anaresTxt').val();
	res_photo=$('[name=xryPhoto]').val();
	if(res_v!=''){
		loader_msg(1,k_loading);
		$.post(f_path+"X/xry_preview_radiology_enter.php",{id:id,val:res_v,photo:res_photo},function(data){
			d=GAD(data);
			if(d==1){
				msg=k_done_successfully;mt=1;veiwPxResult(id);
			}else{
				msg=k_error_data;mt=0;
			}		
			loader_msg(0,msg,mt);			
		})
	}else{
		nav(2,k_fill_rep_bfr_save);
	}
}
function prvEditPx(){
	loadWindow('#m_info2',0,k_img_view,600,hhh);
	$('#anaresTxt').show();
	$('#xphotoDiv').show();	
	$('#saveB').show();
	$('#resView').hide();
	$('#editB').hide();	
	fixForm();	
}
function xRep_ref(l){
	if(l==1){$('.centerSideIn').html(loader_win);}
	$.post(f_path+"X/xry_enter_report_live.php",{},function(data){
		d=GAD(data);
		$('.centerSideIn').html(d);
		fixPage();
		fixForm();
	})
}
function xry_erep(id,r=0){
	actXryRep=id;
	loadWindow('#full_win1',1,k_ent_report,www,hhh);	
	$.post(f_path+"X/xry_enter_report_enter.php",{id:id,r:r},function(data){
		d=GAD(data);		
		$('#full_win1').html(d);
		// $("textarea.m_editor").ckeditor(function(){
		// 	$(this).height('100%')
		// 	fixForm();
		// 	fixPage();
		// });
		setEditor();
		fixPage();
		fixForm();
	});
}
function xry_erepSave(){
	report_txt=$('#report_txt').val();	
	if(report_txt==''){
		nav(2,k_report_must_entered);
	}else{
		loader_msg(1,k_deleting);
		$.post(f_path+"X/xry_enter_report_save.php",{id:actXryRep,rep:report_txt},function(data){
			d=GAD(data);
			if(d==1){
				win('close','#full_win1');
				msg=k_done_successfully;mt=1;
				if(sezPage=='vis_xry'){xry_vit_d_ref(1);xry_erep(actXryRep);}
				if(sezPage=='xRep'){xRep_ref(1);xry_erep(actXryRep);}
			}else{
				msg=k_error_data;mt=0;
			}
			loader_msg(0,msg,mt);
		});
	}
}
function xryVisitStatus(id){	
	loadWindow('#m_info',1,k_visit_details,700,0);
	$.post(f_path+"X/xry_visit_add_save_status.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
}
function cancelXryVisit(id){
	open_alert(id,'xry_2',k_wnt_trns_cnl_vis,k_cancel_visit);
}
function cancelXryVisitDo(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/xry_preview_visit_cancel.php",{id:id},function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;
			loc('_Visits-XRY');			
		}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);
	})
}
function addXryTmpRep(){
	content=$('#report_txt').val();
	content=content.replace(/:/g,'&colon;').replace(/\n/g,'<br>');
	loadWindow('#m_info2',1,k_temp_save,400,0);
	$('#m_info2').html('<div class="win_body"><div class="form_body so"><div class="f1 fs18 clr1 lh40">'+k_temp_adrs+' :</div><input type="text" id="tmpName"/></div><div class="form_fot fr"><div class="bu bu_t3 f1 fl" onclick="saveXTmp()">'+k_save+'</div><div class="bu bu_t2 fr" onclick="win(\'close\',\'#m_info2\');">'+k_close+'</div></div></div>');
	fixForm();
	fixPage();
}
function saveXTmp(){
	tpmName=$('#tmpName').val();
	if(tpmName!=''){
		content = CKEDITOR.instances.report_txt.getData();
		content=content.replace(/:/g,'&colon;').replace(/\n/g,'<br>');
		loader_msg(1,k_loading);
		$.post(f_path+"X/xry_preview_x_report_template_save.php",{id:actXryRep,name:tpmName,rep:content},function(data){ 
			d=GAD(data);
			if(d){
				msg=k_done_successfully;
				mt=1;
				if(sezPage=='Preview-Xray'){XeditReport(d);win('close','#m_info2');}
				if(sezPage=='vis_xry'){xry_erep(actXryRep,d);win('close','#m_info2');}
			}else{msg=k_error_data;mt=0;}
			loader_msg(0,msg,mt);
		})
	}else{nav(2,k_tmp_nm_ent
);}
}
/**********************Dicom**************************************/
//*******show studies of patient*******
var study=0;
var syncStop=1;
var first_opr=0;
var sync_err=0;
var clr_act='#A6CAD2';
var clr_main='#ebf3f5';
var succ=0; var err_co=0;
var dcm_max_up_files_count;
var dmc_repEditorView=0;
var files=[];
var txtError={
	err1:k_err_file_size,
	err2:k_err_file_type,
	err3:k_err_file_copy,
	err4:k_err_save_related_file
};
var actDiHold='';
function loadpatientStudies(patient,service=0,report=0,hold=''){
	dmc_repEditorView=report;
	if(hold!=''){actDiHold=hold;}
	loadWindow('#full_win3',1,k_pats_sutdies,www,hhh);
	$.post(f_path+"X/xry_dcm_patient_studies.php",{type:"view",patient:patient,service:service,hold:hold}, function(data){
		syncStop=1;
		d=GAD(data);
		dd=d.split('^');
		title=dd[0];		
		$('#full_win3').dialog('option','title',title);
		$('#full_win3').html(dd[1]);
		study=$('.studies_list:first').attr('study');
		$('.studies_list:first').attr('act','1');
		dcm_get_study_details(study,patient,service)
		dcm_fix_studies_view(patient,service);
		fixForm();
		fixPage();		
	})	
}
function upDICOMst(patient,service){
	win('close','#full_win3');
	if(actDiHold){
		$.post(f_path+"X/xry_dcm_patient_status.php",{patient:patient,service:service},function(data){
			d=GAD(data);
			$('#'+actDiHold).html(d);
			fixForm();
			fixPage();		
		})
	}
}
function dcm_fix_studies_view(patient,service){
	$('.studies_list[study='+study+'] div[att]').css('background-color',clr_act);
	$('.studies_list').click(function(){
		$('div[att]').css('background-color',clr_main);
		$(this).find('div[att]').css('background-color',clr_act);//('act','1');
		new_study=$(this).attr('study');
		if(new_study!=study){syncStop=1;}
		study=new_study;
		dcm_get_study_details(study,patient,service);

	})
}
function dcm_fix_study_icons(study,patient,service){
	if(study){
		$('#s_v').click(function(){get_viewer('study',study);});
		$('#s_e').click(function(){dcm_editName(study);});
		$('#s_d').click(function(){ deleteStudy(study,patient,service,1);})
	}
}
function dcm_editName(study){
	loadWindow('#m_info3',1,k_study_name,500,400);
	$.post(f_path+"X/xry_dcm_patient_study_edit.php",{type:'view',study:study},function(data){
		d=GAD(data);
		$('#m_info3').html(d);
		fixForm();
		fixPage();
	});
}
function dcm_get_study_details(study,patient,service){//filter
	if(study && study!=0  && study!=''){
		$('.details_study').html(loader_win);
		$.post(f_path+"X/xry_dcm_patient_studies.php",{type:'get_details',study:study},function(data){
			d=GAD(data);
			dd=d.split('^');
			view=dd[1];
			icons=dd[0];
			$('.details_study').html(view);
			$('#study_icons').html(icons);
			dcm_fix_SynchDoView(study);
			dcm_fix_study_icons(study,patient,service);
			fixPage();
			fixForm();
		});
	}
	
			
}

//*******delete patient study*******
function deleteStudy(study,patient,service,checkPerm){
	files=[];
	loader_msg(1,'');
	$.post(f_path+"X/xry_dcm_patient_study_delete.php",{checkPerm:checkPerm,study:study}, function(data){
		d=GAD(data);
		if(d==1){
			msg=k_done_successfully;mt=1;
			//win('close','#m_info1');
			win('close','#m_info3');
			loadpatientStudies(patient,service);
		}else{
			msg=k_error_data;mt=0;
		}
		loader_msg(0,msg,mt);

	})
}
function editTitle(study,patient,service){
	loader_msg(1,'');
	studyTit=$('#studyTit').val();
	$.post(f_path+"X/xry_dcm_patient_study_edit.php",{type:'process',study:study,title:studyTit},function(data){
		d=GAD(data);
		if(d==1){
			msg=k_done_successfully;mt=1;
			win('close','#m_info3');
			loadpatientStudies(patient,service);
		}else{
			msg=k_error_data;mt=0;
		}
		loader_msg(0,msg,mt);
	})
}

//*******upload multi files******
//open view to upload
function loadFormAddStudy(patient,service){
	loadWindow('#m_info3',1,k_pats_sutdies,600,hhh);
	$.post(f_path+"X/xry_dcm_patient_study_add.php",{type:'view',patient:patient,service:service}, function(data){
		d=GAD(data);
		$('#m_info3').html(d);
		fixFormAddStudy();
		$(document).keyup(function(e) {
		  if (e.keyCode === 27) { dcm_close_win_add(patient,service)}  // esc
		});
		fixForm();
		fixPage();

	})
}
function fixFormAddStudy(){
	document.getElementById("files").addEventListener("change", function(event) {
	files = event.target.files;
	if(files.length>0){
		//fix view
		$('#m_info3 div[close]').show();
		$('#info_head').show();
		$('#dcm_co ff').html(files.length);
		// print info of files
		filesView='';
		for(i=0;i<files.length;i++){
			filesView+='\
				 <div class="cb" fix="wp:0" index="'+i+'">\
					<div class="ic40 ic_dicom_file fl"> </div>\
					<div class="fl fs14 lh40">'+files[i].webkitRelativePath+'</div>\
					<div class="short_loader fl hide"></div>\
					<div class="cb err_dcm hide" >\
						<div class="fl ic_err"></div>\
						<div class="fl f1 fs12" errTxt></div>\
					</div>\
				</div>';
		}
		$('#listing').html(filesView);

		//
			dcm_max_up_files_count=parseInt($('#limit').val());
		}else{
			nav(50,k_sel_fld_dnt_contin_dicom);
		}
	}, false);
}
function dcm_close_win_add(patient,service){	
	win('close','#m_info3');
	files=[];
	loadpatientStudies(patient,service);
}
//run upload In batches
function upload_start(patient,service,study=0,index=0){
	studyTit=$('#studyTit').val();
	ok=true;
	if(study==0){
		if(study==0 && (studyTit.length==0 || files.length==0)){
			navC(50,k_sel_all_fields,'#f00');
			ok=false;
		}else{
			succ=err_co=0;
			$('div[up]').hide();
			$('#m_info3 div[close]').hide();
			$( "#m_info3" ).dialog({ closeOnEscape: false });
			fixForm();
			fixPage();
		}
	}
	//prepare request
	if(ok){
		form_data = new FormData();
		form_data.set("type", 'process');
		form_data.set("files_count",files.length);
		form_data.set("study", study);
		form_data.set("patient", patient);
		form_data.set("index", index);
		form_data.set("service", service);
		if(studyTit.length>0){form_data.set("studyTit",studyTit);}
		form_data.delete('files[]');
		if(index<files.length){
			i=0;
			while(i<dcm_max_up_files_count && index<files.length){
				$('div[index='+index+']').children('.short_loader').show();
				form_data.set("files["+i+"]",files[index]);
				if(i!=dcm_max_up_files_count-1){	index++;	}
				i++;
			}
		}else{//complete
			ok=false;
			if(err_co==0){
				resTxt=k_succ_download_send_to_pacs;
				resView='<div class="fs16 f1 clr5">'+resTxt+'</div>';
				$('#listing').html(resView);
			}else{
				navC(50,k_som_file_not_uploaded_pacs,'#f00');
				/*loadWindow('#m_info1',1,'دراسات المريض',600,300);
				$.post(f_path+"X/xry_dcm_patient_study_add.php",{type:'view_finish',study:study}, function(data){
					d=GAD(data);
					$('#m_info1').html(d);
					fixForm();
					fixPage();
				})*/
				$('#m_info3 div[del_study]').show();
			}
			succ=err_co=0;
			files=[];
			$('#m_info3 div[sync]').show();
			$('#m_info3 div[close]').show();
			$( "#m_info3" ).dialog({ closeOnEscape: true });
			fixPage();
			$('div[sync]').click(function(){getSyncStartView(study);});
			$('div[del_study]').click(function(){deleteStudy(study,patient,service,0);});
		}
	}
	//send request
	if(ok){
		$.ajax({
			url:f_path+"X/xry_dcm_patient_study_add.php",
			method:"POST",
			data: form_data,
			contentType: false,
			cache: false,
			processData: false,
			success:function(data){
				d=GAD(data.trim());
				if(d!='err'){no_complete_upload(patient,service,d); }
				else{1
					win('close','#m_info3');
					navC(30,k_dnld_fail_data_lack,'#f00');
				}
			}

		})
	}
}
function no_complete_upload(patient,service,cbVals){
	cbVal=cbVals.split(',');
	study=cbVal[0]; next_index='';
	for(i=1;i<cbVal.length;i++){
		if(cbVal[i]!='' && cbVal[i].substring(0,2)!='er'){
			succ++;
			index=parseInt(cbVal[i]);
			$('div[index='+index+']').remove();
		}else{
			err_co++;
			dd=cbVal[i].split('-');
			errTxt=dd[0]; index=parseInt(dd[1]);
			$('div[index='+index+']').children('.short_loader').hide();
			$('div[index='+index+'] .err_dcm').show();
			$('div[index='+index+'] div[errTxt]').html(txtError[errTxt]);

			$('#fail_co').show().find('ff').html(err_co);

		}
	}
	next_index=index+1;
	rest_files=files.length-(succ+err_co);
	$('#dcm_co ff').html(rest_files);
	setTimeout(function(){upload_start(patient,service,study,next_index);},100);
}


/*****sync with pacs*****/
function dcm_fix_SynchDoView(study){
	if(syncStop==1){$('#ssb').attr('class','fr ic40 icc3 ic40_pus');}
	else if(syncStop==0){$('#ssb').attr('class','fr ic40 icc4 ic40_play');}
	
	$("#ssb").click(function(){
		if(syncStop==0){
			$(this).attr('class','fr ic40 icc3 ic40_pus');
			syncStop=1;
			fixPage();
		}
		else if(syncStop==1){
			$(this).attr('class','fr ic40 icc4 ic40_play');
			syncStart(study,0,1);
			$('.form_fot div[imp_close]').hide();
			fixPage();
		}
  });

  $("#ssb").mouseover(function(){
	   if(syncStop==0){
			$(this).attr('class','fr ic40 icc4 ic40_stop');
		    $(this).attr('title',k_pse);
		}
		else if(syncStop==1){
			$(this).attr('class','fr ic40 icc3 ic40_play');
			$(this).attr('title',k_start_pacs_send);
		}
   });

  $("#ssb").mouseout(function(){
		if(syncStop==0){
			$(this).attr('class','fr ic40 icc4 ic40_play');
			$(this).attr('title',k_start_pacs_send);
		}
		else if(syncStop==1){
			$(this).attr('class','fr ic40 icc3 ic40_pus');
		}
    });
}
function syncStart(study,offset=0,ss=0){
	if(syncStop==1){first_opr=1;syncStop=0;}else{first_opr=0;}
	$.post(f_path+"X/xry_dcm_pacs_sync.php",{study:study,first_opr:first_opr,type:'process'},function(data){
 		d=GAD(data);
		if(d=='complete'){
			syncStop=1;
			$('#ssb').remove();
			$('#expected_time').closest('div[time]').remove();
		}else{
			dd=d.split('^');
			$('#snc2Bloc').show();
			$('#ssb').show();
			$('div[sync_progress]').width(dd[2]+'%');
			$('#counter_exc').html(dd[1]);
			waitTime=dd[0];
			$('#expected_time').html(waitTime);
			
			series_ref=dd[4];
			$('#series_view').html(series_ref);
			
			info_study_ref=dd[5];
			$('.studies_list[study='+study+']').html(info_study_ref);
			$('.studies_list[study='+study+'] div[att]').css('background-color',clr_act);
			
			err=parseInt(dd[6]);
			if(err==1){
				syncStop=1;
				$('#ssb').attr('class','fr ic40 icc3 ic40_pus');
				load_win_error();
			}else if(dd[3]=='not_complete' && syncStop==0){
				setTimeout(function(){syncStart(study);},100);
			}			
			
		}
		fixForm();
		fixPage();
	})
	fixForm();
	fixPage();
}

function load_win_error(){
	loadWindow('#m_info3',1,k_pacs_send,500,300);
	$.post(f_path+"X/xry_dcm_error_alarm.php",'', function(data){
		d=GAD(data);
		$('#m_info3').html(d);
		fixForm();
		fixPage();

	})
}
/*****viewer studies******/
function get_viewer(status,id){
	loadWindow('#full_win4',1,k_pats_sutdies,www,hhh);	
	$.post(f_path+"X/xry_dcm_viewer.php",{status:status,id:id}, function(data){
		d=GAD(data);
		if(d!=0){
			dd=d.split('^-^');
			viewer=dd[0];
			title=dd[1];
			$('#full_win4').html(viewer);
			$('#dcm_loader').show();
			//$('#foo').load(function (){
				$('#full_win4').dialog('option','title',title);
				$('#dcm_loader').hide();
				fixForm();
			//});
			$('[repEdit]').click(function(){XeditReport();})
			if(dmc_repEditorView==1){moveXryReport('send');fixForm();}
		}else{
			navC(50,k_send_to_pacs_first,'#f00');
			win('close','#full_win4');
		}
		fixForm();
		fixPage();
	})
}

function fixRepEdit(){
	chTop=$('.cke_top').height();				
	$('.cke_contents').height(hhh-chTop-130);
}
function moveXryReport(opr){
	if(dmc_repEditorView==1){
		if(opr=='send'){
			report=$('#report_txt').val();
			$('.editorHolder').html('');
			text='<textarea name="cof_8q8n7fk5g2" class="f1 fs16 lh20 m_editor" id="report_txt">'+report+'</textarea>';
			$('.editorInV').html(text);			
			// $("textarea.m_editor").ckeditor(function(){
			 	fixRepEdit();
			 	fixForm();
			// });	
			setEditor();
		}
		if(opr=='back'){
			report=$('#report_txt').val();
			$('.editorInV').html('');
			text='<textarea name="cof_8q8n7fk5g2" class="f1 fs16 lh20 m_editor" id="report_txt">'+report+'</textarea>';
			$('.editorHolder').html(text);			
			//$("textarea.m_editor").ckeditor();
			setEditor();
		}
	}
}

function saveRep(){
	s=1;	
	mas=$('input[name=mas]').val();
	if(mas!=''){mas=parseInt(mas);if(mas<1 || mas>400){s=0;nav(2,k_mas_val_range);}}
	if(s==1){
		kv=$('input[name=kv]').val();
		if(kv!=''){kv=parseInt(kv);if(kv<30 || kv>125){s=0;nav(2,k_kv_val_range);}}
	}	
	if(s==1){
		sub('x_rep_form');
	}
}
function selXPart(srv,val){
	co_selLongValFreeMulti('8dux5qbhex',"recXP("+srv+",[id],[txt])|srv="+srv+"||srv:"+srv+":h|"+val,0);
}
function recXP(srv,ids,txt){
	outTxt='<div class="fl ic40 ic40_edit icc1" onclick="selXPart('+srv+',\''+ids+'\')"></div><input type="hidden" name="part" value="'+ids+'" />';
	if(txt){
		t=txt.split(',');
		for(i=0;i<t.length;i++){
			outTxt+='<div class="fr cMulSel">'+t[i]+'</div>';
		}
	}						
	$('#xParts').html(outTxt);
}
function xryRepToday(){
	loadWindow('#m_info',1,k_day_reps,www,0);
	$.post(f_path+"X/xry_reports_today.php",{},function(data){
		d=GAD(data);
		$('#m_info').html(d);		
		fixForm();
		fixPage();
	})
}
function xry_xRep(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/xry_preview_report_drop.php",{id:id},function(data){ 
		d=GAD(data);
		if(d==1){
			msg=k_done_successfully;
			mt=1;win('close','#full_win1');			
			if(sezPage=='vis_xry'){xry_vit_d_ref(0);}
			
		}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);
	})
}
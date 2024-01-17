/***CLN***/
var aact_roType=0;var paySend=0;var paytype=0;var actVisDelType=0;var act_tik=0;var act_card=0;var nx_id='';var nx_type='';var nx_name='';var nx_c=0;var act_xph_detales=0;var act_operwin=0;var delOprType=1;var repPointer='';var isOverTool=0;var act_assi_detales=0;var selected_madc=0;var act_ana_detales=0;var CancleSerTypeAct=0;var anaPAct=0;var visit_id=0;var patient_id=0;var ser_madTimer='';var ser_in_type='';var analisisOprId=0;var md_ways=new Array(0,0,0,0);var actBtab=0;var act_pat=0;var act_clinic=0;var act_clinic_name='';var act_clinic_type=0;var ser_invTimer='';var madTextArr=new Array('',k_editing_allergies,k_edit_previous_operations,k_edit_chronic_diseases,k_edt_prv_mdc);
var visPa_ser='';
/********************************************/
function sers_set(){
	$('div[par=ceckServ]').click(function(){serTotalCount();});
	//$('#servSelSrch').focus();
	$('#servSelSrch').keyup(function(){serServList();})
}
function addNewServ(id){
	loadWindow('#m_info',1,k_services,600,0);	
	$.post(f_path+"X/cln_preview_services_add.php",{id:id}, function(data){
		d=GAD(data);
		$('#m_info').html(d);
		loadFormElements('#n_visit');			
		setupForm('n_visit','m_info');
		fixForm();
		fixPage();
		sers_set();
	})
}

var PayActMood=0;
function addPay(id,pay,type,mood){
	PayActMood=mood;
	paytype=type;
	var ok=1;
	var msg='';
	if(type==2 || type==4){
		pp=$('#l_pay').val();
		pp_max=parseInt($('#l_pay').attr('max'));
		if(pp==''){ok=0;msg=k_mnt_entrd;}else{if(pp_max < parseInt(pp))
		{ok=0;msg=k_mnt_grt_val;}else{pay=pp;}}
	}
	if(ok==1){
		paySend=pay
		open_alert(id,12,k_srv_pd+' <ff>'+pay+'</ff> ؟',k_addtn_srvs);
	}else{
		$('#l_pay').css('background-color','#F99');
		nav(1,msg)
	}
}
function addPay_do(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/cln_visit_additional_payment.php",{id:id,t:paytype,p:paySend,mood:PayActMood}, function(data){
		d=GAD(data);	
		if(d==1){
			msg=k_done_successfully;mt=1; win('close','#m_info');
			printTicket(PayActMood,id);			
		}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);		
		res_ref(1);
	})
}
var backPayActMood=0;
function backPay(id,pay,mood){
	backPayActMood=mood;
	open_alert(id,13,k_mnt_rfnd+' <ff>'+pay+'</ff> ؟',k_rfnd_mnt);
}
function backPay_do(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/cln_visit_payment_back.php",{id:id,mood:backPayActMood}, function(data){
		d=GAD(data);	
		if(d==1){
			msg=k_done_successfully;mt=1; win('close','#m_info');			
			printTicket(backPayActMood,id)
		}else{msg=k_error_data;mt=0;}loader_msg(0,msg,mt);res_ref(1)
	})
}
function loadADDClinic(){
	loadWindow('#m_info',1,k_addtn_cln,660,0);	
	$.post(f_path+"X/cln_visit_additional_clinics.php",{}, function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
}
function printAnalysis(){printWindow(2,act_ana_detales);}
function print_xphoto(){printWindow(3,act_xph_detales);}
function print_operation(){printWindow(6,act_opr_detales);}
function printAnalysis2(){
	printWindow(2,act_ana_detales);/*
	loadWindow('#m_info3',1,k_xp_dat,500,0);	
	$.post(f_path+"X/cln_preview_analysis_out.php",{id:act_ana_detales}, function(data){
		d=GAD(data);
		$('#m_info3').html(d);
		loadFormElements('#x_out');			
		setupForm('x_out','m_info3');
		setXOUT();
		fixForm();
		fixPage();
	})*/
}
function serTotalCount(){
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
function clnVisitStatus(id){	
	loadWindow('#m_info',1,k_visit_details,700,0);
	$.post(f_path+"X/cln_visit_add_save_status.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
}
function dateDocInfo(id){
	loadWindow('#m_info4',1,k_doc_info,600,0);	
	$.post(f_path+"X/gnr_doctor_time.php",{id:id}, function(data){
		d=GAD(data);
		$('#m_info4').html(d);
		fixPage();
		fixForm();
	})
}
function stopDocToday(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/cln_schedule_stop.php",{id:id}, function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1; $('#m_info4').dialog('close');}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);
		sch_ref(0)
	})
}
function opentick(){
	d='<div class="win_body"><div class="form_body so">\
	<div id="nv_l1">\
	<div class="fs18 f1 clr1 lh40">'+k_ent_tik_num+'</div>\
	<input type="text" id="t_no" onkeyup="check_tik(0)"/>\
	</div><div id="nv_l2"></div></div>\
	<div class="form_fot fr"><div class="bu bu_t2 fr" onclick="win(\'close\',\'#m_info\')">'+k_cancel+'</div>\
    <div class="bu bu_t3 fl" onclick="check_tik(1)">'+k_search+'</div></div>';
	loadWindow('#m_info',1,k_sr_tk,400,200);
	$('#m_info').html(d);
	$('#t_no').focus();
	fixPage();
	fixForm();
}
function check_tik(t){
	t_no=$('#t_no').val();
	if(t_no!=''){if(t==1){check_tik_do(t_no);}else{if(t_no.length>=10){check_tik_do(t_no);}}}
}
function check_tik_do(t_no){	
	act_tik=t_no;
	$('#t_no').val('');
	$('#nv_l1').hide();	
	$('#nv_l2').html(loader_win);
	$.post(f_path+"X/gnr_visit_ticket_info.php",{t:act_tik},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd[0]==0){
			$('#nv_l1').show();
			$('#t_no').focus();
			$('#nv_l2').html(dd[1]);
			fixForm();
			fixPage();
		}else{
			if(sezPage=='l_Resp'){
				$('.centerSideIn').html(dd[1]);
				win('close','#m_info');
			}else{
				loadWindow('#m_info',1,k_ticket_info,650,200);
				$('#m_info').html(dd[1]);						
			}
			fixForm();
			fixPage();
		}
	})	
}
function openCard(){
	d='<div class="win_body"><div class="form_body so">\
	<div id="nv_l1">\
	<div class="fs18 f1 clr1 lh40">'+k_ent_cr_nm+'</div>\
	<input type="text" id="t_no" onkeyup="check_card(0)"/>\
	</div><div id="nv_l2"></div></div>\
	<div class="form_fot fr"><div class="bu bu_t2 fr" onclick="win(\'close\',\'#m_info2\')">'+k_cancel+'</div>\
    <div class="bu bu_t3 fl" onclick="check_card(1)">'+k_search+'</div></div>';
	loadWindow('#m_info2',1,k_sr_pa,400,200);
	$('#m_info2').html(d);
	$('#t_no').focus();
	fixPage();
	fixForm();
}
function check_card(t){
	t_no=$('#t_no').val();
	if(t_no!=''){if(t==1){check_card_do(t_no);}else{if(t_no.length>=7){check_card_do(t_no);}}}
}
function check_card_do(t_no){
	act_card=t_no;
	$('#t_no').val('');
	$('#nv_l1').hide();	
	$('#nv_l2').html(loader_win);
	$.post(f_path+"X/cln_visit_card_info.php",{t:act_card},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd[0]==0){
			$('#nv_l1').show();
			$('#t_no').focus();
			$('#nv_l2').html(dd[1]);
			fixForm();
			fixPage();
		}else{
			loadWindow('#m_info2',1,k_patient_info,650,200);
			$('#m_info2').html(dd[1]);						
			fixForm();
			fixPage();
		}
	})	
}
function dateSc(c,n){
	if(c==0){t=k_schdl_wrk;}else{t=k_tm_tb+'   [ '+n+' ]'}
	loadWindow('#m_info2',1,t,www,hhh);
	$.post(f_path+"X/gnr_clinics_time.php",{c:c},function(data){
		d=GAD(data);
		$('#m_info2').html(d);
		fixForm();
		fixPage();
	})	
}
function cln_vit_d_ref(l){	
	if(l==1){$('#d2,#d3,#d4').html(loader_win);}
	$.post(f_path+"X/cln_visit_doc_live.php",{},function(data){
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

function open_Tools(){closeOpenWin(1);if($('.toolsCont').is(':visible')){$('.toolsCont').slideUp(250);}else{$('.toolsCont').slideDown(250);}}
function closeOpenWin(t){
	if(t!=1){if($('.toolsCont').is(':visible')){$('.toolsCont').slideUp(250);};}
	if(t!=2){if($('.swWin').is(':visible')){$('.swWin').slideUp(250);};}
	if(t!=3){if($('.bloods').is(':visible')){$('.bloods').hide();};}
}
function setProview(){
	listButt();
	$('.blod_box').click(function(){setBlood();});
}
function setBlood(){
	closeOpenWin(3);
	bCode=$('.blod_box').attr('b');
	if($('.bloods').is(':visible')==true){
		$('.bloods').hide();
	}else{
		$('.bloods').show();
	}
	$('.bloods > div').click(function(){
		$('.blod_box').removeClass('blod_box_0');
		$('.bloods').hide(300);
		Bcode=$(this).attr('co');
		Bcode2=Bcode.replace('+','1');
		Bcode2=Bcode2.replace('-','0');
		$('.bloods').hide();
		$('.blod_box').html('?');
		$.post(f_path+"X/cln_preview_blood_change.php",{p_id:patient_id,code:Bcode}, function(data){
			if(Bcode==''){
				$('.blod_box').addClass('blod_box_0');
			}
			$('.blod_box').html(Bcode);
			fixPage();
		})			
	})
	
}
function loadMadInfo(){
	$('.mad_info').html(loader_win);
	$.post(f_path+"X/cln_preview_medical_info.php",{p_id:patient_id}, function(data){
		d=GAD(data);				
		$('.mad_info').html(d);
	})	
}
function editMadInfo(n){
	madType=n;
	loadWindow('#m_info',1,madTextArr[n],800,hhh-20);
	$('#m_info').dialog('option','closeOnEscape',false);
	$.post(f_path+"X/cln_preview_medical_info_edit.php",{p_id:patient_id,n:n}, function(data){
		d=GAD(data);				
		$('#m_info').html(d);
		ser_mad();
		fixForm();
		fixPage_add();		
	})	
}
function ser_mad(){
	serm=$('#serMad').val();
	$('#list_mad').html(loader_win);
	$.post(f_path+"X/cln_preview_medical_info_edit_list.php",{p_id:patient_id,serm:serm,type:madType}, function(data){
		d=GAD(data);					
		$('#list_mad').html(d);
		op_list2(madType);
	})
}
function ser_mad_T(p){clearTimeout(ser_madTimer);ser_madTimer=setTimeout(function(){ser_mad()},ser_wittig);}
function op_list2(type){
	$('.op_list2 div[type='+type+']').click(function(){
		if($('#serMad').val()!=''){$('#serMad').val('');ser_mad();}
		num=$(this).attr('num');
		type=$(this).attr('type');
		val=$(this).attr('name');
		makeButt2(type,num,val);
		saveButt2(type,num,0);
		$(this).hide(500);
		listButt();
	})
}
function makeButt2(type,num,val){
	b='';
	b+='<div class="listButt fl hide" id="m'+type+'-'+num+'">';
	b+='<div class="delTag" onclick="delOprList2('+type+','+num+')"></div>';
	b+='<div class="strTag">'+val+'</div>';
	b+='</div>';
	$('#sel_mad_in').append(b);
	$('#m'+type+'-'+num).show(500);	
}
function saveButt2(type,num,mode){	
	$.post(f_path+"X/cln_preview_medical_info_edit_save.php",{type:type,num:num,p_id:patient_id}, function(data){
		d=GAD(data);
		$('#'+d).css('background-color',clr1);		
		if(mode==1)	ser_mad();					
	})
}
function delOprList2(type,num){
	if($('#serMad').val()!=''){$('#serMad').val('');ser_mad();}
	$('#m'+type+'-'+num).css('background-color',clr4);
	$('#m'+type+'-'+num).children('.delTag').remove();
	$.post(f_path+"X/cln_preview_medical_info_edit_del.php",{type:type,num:num,p_id:patient_id}, function(data){						
		$('#m'+type+'-'+num).hide(500,function(){
			$('#m'+type+'-'+num).remove();
		});		
		ser_mad();
	})
}
function addToMadList(type){
	if(type==1)modSend='u6uv4o4oo';
	if(type==2)modSend='5kez33fbf9';
	if(type==3)modSend='ythubs8yzp';
	if(type==4)modSend='cojv8jivop';
	val=$('#serMad').val();	co_loadForm(0,3,modSend+"|id,name_(L)|addToMadList_in([id],'[name_(L)]',"+type+")|name_(L):"+val);
}
function addToMadList_in(id,val,type){	
	makeButt2(type,id,val);
	saveButt2(type,id,1);	
	listButt();
	$('#serMad').val('');
}
function colsemad(){
	loadMadInfo();	
	win('close','#m_info');	
}

function pro_timer(){
	clearTimeout(timer2);
	pre_timer=parseInt(pre_timer);
	var d = new Date();
	var n =parseInt(d.getTime()/1000);	
	aaa=getTimeStr(n-pre_timer);	
	$('#prev_timer').html(aaa);
	timer2=setTimeout(function(){pro_timer()},1000);
}
function listButt(){
	$('.listButt').mouseover(function(){
		detWidth=$(this).width();
		detHeight=$(this).height();
		$(this).children('.delTag').width(detWidth);
		$(this).children('.delTag').height(detHeight);
		$(this).children('.delTag').show();
	})
	$('.listButt').mouseout(function(){
		$(this).children('.delTag').hide();
	})
}
function editList_2(type,id){	
	if(type==1){mody='u6uv4o4oo'};
	if(type==2){mody='5kez33fbf9'};
	if(type==3){mody='ythubs8yzp'};
	if(type==4){mody='cojv8jivop'};
	co_loadForm(id,3,mody+"||editMadInfo("+type+")|");	
}

var actAnType=1;
function Analysis(id,anType){
	actAnType=anType;
	if(anType==1){$('#bwtto').remove();}
	loadWindow('#m_info',1,k_lab_tests,850,hhh-20);
	$.post(f_path+"X/gnr_preview_analysis.php",{p_id:patient_id,v_id:visit_id}, function(data){
		d=GAD(data);
		$('#m_info').html(d);
		ana_ls();
		fixPage();
		if(id!=0){loadAna(id);}
	})	
}
function newAnalysis(id){
	loadWindow('#m_info2',1,k_test_req,850,hhh-20);
	$.post(f_path+"X/cln_preview_analysis_add.php",{v_id:visit_id,id:id}, function(data){
		d=GAD(data);				
		$('#m_info2').html(d);
		ana_list_cat();
		ana_list_cat2();		
		fixPage();
	})
}
/*function exportAOut(){
	type=$('#ri_type').val();
	vals='';
	$('div[par=lxo]').each(function(index, element){
		val=$(this).find('div[ch]').attr('ch');
		if(val=='on'){
			name=$(this).attr('ch_name');
			name=name.substr(4)
			if(vals!=''){vals+='a';}
			vals+=name;
		}
	});
	if(vals!=''){
		if(type==1){id=$('#id').val();printXOut(id,vals,2);}
		if(type==2){sub('a_out');}
	}else{nav(2000,k_onitm_sel);}
}*/
function ana_list_cat(){
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
		}		
	})
	ana_basy=0;
	$('.ana_list_mdc div').click(function(){
		if(ana_basy==0){
			ana_basy=1
			mdc=$(this).attr('mdc');
			name=$(this).attr('name');	
			$(this).attr('del','1');
			butt_m='<div class="sel_Ana sel_AnaHov loader" mdc="'+mdc+'" style="color:#ccc" title="'+k_delete+'">'+name+'</div>';	
			$('#anaSelected').append(butt_m)
			$(this).slideUp(400,function(){				
				$.post(f_path+"X/cln_preview_analysis_item_save.php",{ana:analisisOprId,mdc:mdc}, function(data){
					d=GAD(data);							
					$('.sel_Ana[mdc='+d+']').css('color','');
					$('.sel_Ana[mdc='+d+']').removeClass('loader');		
					fixPage();	
					ana_list_cat2();
					ana_basy=0
				})	
			});
		}
	})
}
function ana_list_cat2(){
	$('.ana_list_mdc div[del=1]').hide();
	$('.sel_Ana').click(function(){		
		m_id=$(this).attr('mdc');
		$('.sel_Ana[mdc='+m_id+']').removeClass('sel_AnaHov');	
		$('.sel_Ana[mdc='+m_id+']').addClass('loader');	
		$('.sel_Ana[mdc='+m_id+']').css('color','#eee');				
		$.post(f_path+"X/cln_preview_analysis_item_del.php",{id:m_id,ana:analisisOprId}, function(data){
			d=GAD(data);						
			$('.sel_Ana[mdc='+d+']').slideUp(400,function(){
				$('.sel_Ana[mdc='+d+']').remove();
				$('.ana_list_mdc div[mdc='+d+']').slideDown(400);
				$('.ana_list_mdc div[mdc='+d+']').attr('del','0');
				listPrescr_ser();	
			});		
		})		
	})
}
function editAnalysis(){newAnalysis(act_ana_detales);}
function end_ana(id){
	act_ana_detales=id;
	if($('.sel_Ana').length>0){
		win('close','#m_info2');	
		Analysis(id,actAnType);
		//getTopStatus('x',1);
		prvClnoprCount('ana');
	}else{
		delAnalysis(2);
	}
}
function cancel_ana(id){
	$('#m_info').html(loader_win);
	$.post(f_path+"X/cln_preview_analysis_del.php",{id:id}, function(data){
		win('close','#m_info2');
		Analysis(0,actAnType);
		//getTopStatus('x',1);
		prvClnoprCount('ana');
		$('#m_info2').dialog('option','closeOnEscape',true);
	})
}

function getTopStatus(n,t){
	box='';
	if(t==1)box=$('.top_ana_star');
	if(t==2)box=$('.top_xp_star');
	if(t==3)box=$('.top_opr_star');
	if(n=='x'){
		box.hide();
		$.post(f_path+"X/gnr_preview_counter.php",{p_id:patient_id,t:t}, function(data){
			d=GAD(data);	
			n=d;	
			if(n>0){box.html(n);box.show(200);}else{box.hide();}					
		})
	}else{
		if(n>0){box.html(n);box.show(200);}else{box.hide();}
	}	
}
function delAnalysis(t){
	if(t==1){mssg=k_m_delete_test;}else{mssg=k_no_ana_del_yn;}
	open_alert(act_ana_detales,4,mssg,k_delete_test);
}

function operations(n){
	act_xph_detales=0;	
	act_operwin=n;
	loadWindow('#m_info',1,k_operations,850,hhh-20);
	$.post(f_path+"X/cln_preview_operations.php",{p_id:patient_id,v_id:visit_id}, function(data){ 
		d=GAD(data);				
		$('#m_info').html(d);
		opr_ls();
		if(n>0){slopr_d(n,1,'');}
		fixPage();
	})
}
function opr_ls(){
	$('.opr_ls').click(function(){
		a_id=$(this).attr('a_id');		
		slopr_d(a_id,1,'')
	})
}
function slopr_d(a_id,t,d){
	act_opr_detales=a_id
	if(t==1){$('#part_detail').html(loader_win);}
	if(t==2){loadWindow('#m_info3',1,k_operations,850,hhh-20);}
	$.post(f_path+"X/cln_preview_operations_info.php",{id:a_id,t:t,d:d}, function(data){
		d=GAD(data);	
		if(t==1){
			$('#part_detail').html(d);		
			$('.opr_ls').css('background-color','');
			$('.opr_ls[a_id='+a_id+']').css('background-color','#aaa');
			$('#bwtto').show();
		}
		if(t==2){$('#m_info3').html(d);}
		fixPage();	
	})	
}
function new_operation(id){
	loadWindow('#m_info2',1,k_add_oper,600,hhh-20);
	$.post(f_path+"X/cln_preview_operations_add.php",{p_id:patient_id,v_id:visit_id,id:id}, function(data){
		d=GAD(data);				
		$('#m_info2').html(d);			
		loadFormElements('#form_oper');
		setupForm('form_oper','m_info2');
		fixPage();			
		fixForm();	
	})		
}
function edit_opration(){new_operation(act_opr_detales);}
function delOperation(){
	id=act_opr_detales;
	open_alert(id,9,k_del_oper_yn,k_del_oper);	
}
function delOpr(id){
	loader_msg(1,k_deleting)	
	$.post(f_path+"X/cln_preview_operations_del.php",{id:id}, function(data){
		loader_msg(0,k_done_successfully,1);
		if(delOprType==1){			
			operations(0);	
			getTopStatus('x',3);
		}else{
			win('close','#m_info');
			getTopStatus('x',3);
			//reloadRP();
		}
		operations(0);
		
	})	
}
function opr_tools(){
	loadWindow('#m_info3',1,k_oper_tools,600,hhh-20);
	otools=$('#otools').val();
	$.post(f_path+"X/cln_preview_operations_tools.php",{t:otools}, function(data){
		d=GAD(data);				
		$('#m_info3').html(d);
		loadFormElements('#wayForm');
		tollCheckSel();
		fixForm();		
		fixPage();
	})		
}
function tollCheckSel(){
	$('.toolrow').click(function(){
		if(isOverTool==0){status=$(this).attr('s');
			if(status=='x'){$(this).attr('s','y');$(this).find('input').focus();}else{$(this).attr('s','x');}		
		}else{isOverTool=0;}
	})
	$('.toolrow').find('input').click(function(){isOverTool=1;$(this).attr('s','x');})
}
function new_tool(){
	co_loadForm(0,3,"alnffavfe|id,name_(L)|addTool([id],'[name_(L)]')|");	
} 
function addTool(id,name){
	$('#m_info2').dialog('option', 'height',hhh-20);
	str='<div class="toolrow" s="y" tNum="'+id+'" n="'+name+'">'+name+'<div class="fr">\
	<input type="text" value="" placeholder="'+k_quantity+'" ></div></div>';
	$('.toolList').append(str);	
	$('.toolrow[tnum='+id+']').click(function(){
		if(isOverTool==0){status=$(this).attr('s');
			if(status=='x'){$(this).attr('s','y');$(this).find('input').focus();}else{$(this).attr('s','x');}		
		}else{isOverTool=0;}
	})
	$('.toolrow[tnum='+id+']').find('input').click(function(){isOverTool=1;$(this).attr('s','x');})	
}
function save_selTool(){
	err=0;
	idds='';
	texts='';
	f=0;
	$('.toolrow[s=y]').each(function(index, element) {
        tn=$(this).attr('tNum');
		t_val=parseInt($(this).find('input').val());		
		if($.isNumeric(t_val)){}else{t_val='';}
		$(this).find('input').val(t_val);
		if(t_val=='' || t_val==0){$(this).find('input').css('background-color','#ffd2d2');err=1;}else{
			$(this).find('input').css('background-color','');
			n=$(this).attr('n');
			if(f==1){idds+='|';}
			idds+=tn+':'+t_val;
			texts+='<div class="cb"><div class="fl f1">- '+n+' </div><div class="fl ff" nb>( '+t_val+' )</div></div>';
			f=1;
		}		
    });
	if(err==0 && f==1){
		win('close','#m_info3');
		$('#otools').val(idds)
		$('#opr_tools_d').html(texts);
		fixForm();		
	}
}
function save_Operation_re(id){
	setupForm('form_oper_'+id,'m_info2');
	sub('form_oper_'+id);
}
function reloadRP(){
	dd=repPointer.split('-');
	win('close','#m_info3');
	if(dd.length==3){
		loadReport(dd[1],dd[2],dd[0]);
	}
}
function med_report(){
	loadWindow('#m_info',1,k_med_report,600,hhh-20);
	$.post(f_path+"X/cln_preview_report.php",{v_id:visit_id,p_id:patient_id}, function(data){
		d=GAD(data);			
		$('#m_info').html(d)
		fixForm();
		fixPage();        
		setEditor();
	})
}
function saveReport(){
	rep=$('#report').val();
	loader_msg(1,k_saving)
	$.post(f_path+"X/cln_preview_report_save.php",{v_id:visit_id,p_id:patient_id,r:rep}, function(data){
		loader_msg(0,k_done_successfully,1);        
		if(rep!=''){$('#bwtto').show();}
	})	
}
function visNote(){
	loadWindow('#m_info',1,k_notes_visit,600,hhh-20);
	$.post(f_path+"X/cln_preview_note.php",{v_id:visit_id,p_id:patient_id}, function(data){
		d=GAD(data);			
		$('#m_info').html(d)
		fixForm();
		fixPage();
	})
}
function saveNote(){
	rep=$('#report').val();
	loader_msg(1,k_saving)
	$.post(f_path+"X/cln_preview_note_save.php",{v_id:visit_id,p_id:patient_id,r:rep}, function(data){
		loader_msg(0,k_done_successfully,1);
		win('close','#m_info');
	})	
}
function assignment(){
	loadWindow('#m_info',1,k_referrals,850,hhh-20);
	$.post(f_path+"X/cln_preview_referrals.php",{p_id:patient_id,v_id:visit_id}, function(data){
		d=GAD(data);				
		$('#m_info').html(d);
		assi_ls();		
		fixPage();
	})	
}
function newAssignment(n){
	actBtab=0;
	loadWindow('#m_info2',1,k_medical_referral,640,0);	
	$('#m_info2').dialog('option', 'height','auto');
	$.post(f_path+"X/cln_preview_referrals_add.php",{p_id:patient_id,v_id:visit_id,n:n}, function(data){
		d=GAD(data);				
		$('#m_info2').html(d);		
		assi_action();		
		fixPage();						
		loadFormElements('#form_assi');	
		fixForm();		
		setupForm('form_assi','m_info2');		
	})	
}
function assi_save(id){
	assignment();
	assi_ls_show(id)			
	fixPage();
}
function delassi(){
	open_alert(act_assi_detales,5,k_m_delete_referral,k_delete_referral);
}
function del_assi(id){
	$.post(f_path+"X/cln_preview_referrals_del.php",{id:id}, function(data){
		assignment(0);								
		fixPage();
	})	
}
function editassi(){
	newAssignment(act_assi_detales)
}
function print_assi(){
	printWindow(5,act_assi_detales)
}
function assi_ls(){
	$('.assi_lis').click(function(){
		a_id=$(this).attr('a_id');
		assi_ls_show(a_id)
	})
}
function assi_ls_show(a_id){
	$('#bwtto').hide();	
	$('.blc_win_content_in').html(loader_win);
	act_ana_detales=a_id;
	$.post(f_path+"X/cln_preview_referrals_info.php",{id:a_id}, function(data){
		d=GAD(data);		
		$('.assi_ls').css('background-color','');
		$('.assi_ls[a_id='+a_id+']').css('background-color','#ccc');
		$('#bwtto').show();	
		$('#part_detail').html(d);	
		act_assi_detales=a_id;
		fixPage();										
	})		
}
function rev_ref(l,vis){
	$.post(f_path+"X/cln_preview_info_live.php",{vis:vis},function(data){
		d=GAD(data);
		dd=d.split('^');
		$('#stu_1').html(dd[0]);
		$('#stu_2').html(dd[1]);
		$('#sevises_list').html(dd[2]);
		$('#prv_slider').html(dd[3]);		
		$('#timeStatus').attr('class',dd[4]);
		fixPage();
	})
}
function caclSrv(id,type){
	CancleSerTypeAct=type;
	textMsg=k_wnt_cnl_srv;
	if(type==2){textMsg=k_rtrn_srv;}	
	open_alert(id,18,textMsg,k_cncl_serv);
}
function caclSrvDo(srv){
	$.post(f_path+"X/cln_preview_services_cancel.php",{vis:visit_id,srv:srv},function(data){
		if(CancleSerTypeAct==1 || CancleSerTypeAct==2){rev_ref(1,visit_id);}else{showVd(visit_id,0);}
	})
}


function chrPay(chr,amount){co_loadForm(0,3,"8ivv95gecw||loc('')|chr:"+chr+":h,amount:"+amount);}

function calboxTotal(){
	vv=0;
	$('.boxtt').each(function(index, element){
        v=$(this).val();
		if(v=='')v=0;
		vv+=parseInt(v);
    });
	$('#boxttt').html(vv)
}
/*
function changeDocPrice(id){
	loadWindow('#m_info2',1,k_srv_prc,500,0);	
	$.post(f_path+"X/srv_ch_price.php",{id:id}, function(data){
		d=GAD(data);
		$('#m_info2').html(d);
		setupForm('srv_ch','m_info2');
		calNPr();
		fixPage();
		fixForm();
	})
}*/
function calNPr(){
	$('input[ppp]').keyup(function(){
		p1=parseInt($('#p1').val());
		p2=parseInt($('#p2').val());
		$('#pp').html(p1+p2);
	})
}
function chkSrvBefEnd(srv,rec){
	loader_msg(1,k_loading);
	$.post(f_path+"X/cln_preview_services_end_check.php",{srv:srv,rec:rec},function(data){
		d=GAD(data);
		loader_msg(0,'');
		if(d!='0'){		
			doScript(d);
		}else{
			finshSrv(rec,1);
		}			
	})
}
function finshSrv(srv,t){
	if(t==2){loc('_Visits');}else{
		if(srv==0){endPrv();}else{open_alert(srv,6,k_srv_fsh,k_ed_srv);}
	}	
}
function endSrvDo(srv,itCost){
	$.post(f_path+"X/cln_preview_services_end.php",{vis:visit_id,srv:srv,itCost:itCost},function(data){rev_ref(1,visit_id);})
}
function view_list_Ser(p){
clearTimeout(ser_in_type);ser_in_type=setTimeout(function(){view_list(p)},ser_wittig);
}
function view_list(type){
	serl=$('#serList'+type).val();
	$('#list_option'+type).html(loader_win);
	fixPage()
	$.post(f_path+"X/cln_preview_procedure.php",{type:type,serl:serl,v_id:visit_id}, function(data){
		d=GAD(data);		
		$('#list_option'+type).html(d);
		op_list(type);
	})
}
function addToList(type){
	if(type==1){modSend2='m2d04h6g3';}
	if(type==2){modSend2='pwi020p58g';}
	if(type==3){modSend2='3zjxa7kckv';}
	if(type==4){modSend2='xbnv3hfhz9';}
	val=$('#serList'+type).val();	
	co_loadForm(0,3,modSend2+"|id,name|addToMadL_in([id],'[name]',"+type+")|name:"+val);
}
function addToMadL_in(id,val,type){	
	makeButt(type,id,val);
	saveButt(type,id,1);
	listButt();	
	$('#serList'+type).val('');
	view_list(type)
}
function op_list(type){
	$('.op_list div[type='+type+']').click(function(){
		if($('#serList'+type).val()!=''){$('#serList'+type).val('');view_list(type);}
		num=$(this).attr('num');
		val=$(this).attr('name');
		makeButt(type,num,val);
		saveButt(type,num,0);
		$(this).hide(500);
	})
}
function makeButt(type,num,val){
	b='';
	b+='<div class="listButt fl hide" id="'+type+'-'+num+'">';
	b+='<div class="delTag" onclick="delOprList('+type+','+num+')"></div>';
	b+='<div class="strTag">'+val+'</div>';
	b+='</div>';
	$('#sel_option'+type).append(b);listButt();
	$('#'+type+'-'+num).show(500);		
}
function saveButt(type,num,mode){	
	$.post(f_path+"X/cln_preview_procedure_save.php",{type:type,num:num,v_id:visit_id,p_id:patient_id}, function(data){
		d=GAD(data);
		$('#'+d).css('background-color',clr1);	
		if(mode==1)view_list(type);		
	})
}
function delOprList(type,num){
	if($('#serList'+type).val()!=''){$('#serList'+type).val('');}
	$('#'+type+'-'+num).css('background-color',clr4);
	$('#'+type+'-'+num).children('.delTag').remove();
	$.post(f_path+"X/cln_preview_procedure_del.php",{type:type,num:num,v_id:visit_id}, function(data){
		$('#'+type+'-'+num).hide(500,function(){
			$('#'+type+'-'+num).remove();
		});		
		view_list(type);
	})
}
function editList_1(type,id){	
	if(type==1){mody='m2d04h6g3'};
	if(type==2){mody='pwi020p58g'};
	if(type==3){mody='3zjxa7kckv'};
	if(type==4){mody='xbnv3hfhz9'};	
	co_loadForm(id,3,mody+"|name_(L)|editBack("+type+","+id+",'[name_(L)]')|");	
}
function editBack(type,num,val){
	$('.listButt[id='+type+'-'+num+']').remove();
	makeButt(type,num,val);
	$('.listButt[id='+type+'-'+num+']').css('background-color',clr1);	
}
function loadHistory(p_id,t){	
	if(t==0){
		$('#p_his').html(loader_win);
	}else{
		loadWindow('#m_info',1,k_med_his,600,hhh-20);		
	}	
	$.post(f_path+"X/cln_patient_history.php",{p_id:p_id,v_id:visit_id,t:t}, function(data){
		d=GAD(data);
		if(t==0){				
			$('#p_his').html(d);	
		}else{
			$('#m_info').html(d);
			fixForm();		
		}
		fixPage();
	})
}
function showVd(v_id,type){
	//visit_id=v_id;
	win_titel=new Array(k_services,k_visit_details_num+' ('+v_id+')',k_precpiction,k_analysis,k_medical_photo,k_the_medical_report,k_referral);
	loadWindow('#full_win1',1,win_titel[type],800,800);
	$.post(f_path+"X/cln_preview_visit_info.php",{v_id:v_id,type:type}, function(data){
		d=GAD(data);				
		$('#full_win1').html(d);		
		fixForm();	
		fixPage();
		tabs(15);
		changTab('15-'+type);
	})
}
function assi_action(){
	$('.b_tabs > div').mouseover(function(){		
		n=$(this).children('div').attr('n');
		if(actBtab!=n){		
			if(n=='1'){$(this).children('div').css('background-position',[0,'center'])}
			if(n=='2'){$(this).children('div').css('background-position',['-200px','center'])}
			if(n=='3'){$(this).children('div').css('background-position',['-400px','center'])}
		}
	})
	$('.b_tabs > div').mouseout(function(){
		n=$(this).children('div').attr('n');
		if(actBtab!=n){				
			if(n=='1'){$(this).children('div').css('background-position',['-100px','center'])}
			if(n=='2'){$(this).children('div').css('background-position',['-300px','center'])}
			if(n=='3'){$(this).children('div').css('background-position',['-500px','center'])}
		}
	})
	$('.b_tabs > div').click(function(){
		n=$(this).attr('n');
		changebTab(n);		
	})
}

function endPrv(){
	loader_msg(1,k_loading);
	$.post(f_path+"X/cln_preview_visit_end.php",{v_id:visit_id},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd[0]==1){
			loader_msg(0,'',0);
			loadWindow('#m_info',1,k_end_pre,400,0);
			$('#m_info').html(dd[1]);
			fixPage();
			fixForm();
		}
		if(dd[0]==2){loc('../_Visits');}
		if(dd[0]==3){loader_msg(0,'',0);nav(2,k_srv_fsh_fr);}
	})
}
function cancelVisit(id){
	open_alert(id,17,k_wnt_trns_cnl_vis,k_cancel_visit);
}
function cancelVisitDo(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/cln_preview_visit_cancel.php",{id:id},function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;
			loc('_Visits');			
		}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);
	})
}

function print_xphoto2(){
	loadWindow('#m_info3',1,k_xp_dat,500,0);	
	$.post(f_path+"X/cln_preview_radiology_out.php",{id:act_xph_detales}, function(data){
		d=GAD(data);
		$('#m_info3').html(d);
		loadFormElements('#x_out');			
		setupForm('x_out','m_info3');
		setXOUT();
		fixForm();
		fixPage();
	})
}
function setXOUT(){
	$('.radioBlc[par=swt] .radioBlc_each').click(function(){
		v=$(this).attr('ri_val');
		if(v==1){
			$('tr[mood=1]').show();
			$('tr[mood=1]').find('div[ch]').attr('ch','off')
			$('tr[mood=2]').find('div[ch]').attr('ch','off')
		}else{
			$('tr[mood=1]').hide();
			$('tr[mood=1]').find('div[ch]').attr('ch','off')
			$('tr[mood=2]').find('div[ch]').attr('ch','off')
		}		
	})
}
function exportXOut(){
	type=$('#ri_type').val();
	vals='';
	$('div[par=lxo]').each(function(index, element){
		val=$(this).find('div[ch]').attr('ch');
		if(val=='on'){
			name=$(this).attr('ch_name');
			name=name.substr(4)
			if(vals!=''){vals+='a';}
			vals+=name;
		}
	});
	if(vals!=''){
		if(type==1){id=$('#id').val();printXOut(id,vals,3);}
		if(type==2){sub('x_out');}
	}else{nav(2000,k_onitm_sel);}
}
function printXOut(id,vals,type){printWindow2(type,id,vals);}
function changebTab(n){
	This=$('.b_tabs > div[n='+n+']');
	This2=$('.b_tabs > div[n='+n+']').parent();		
	This_act=$('.b_tabs > div[n='+actBtab+']');
	This_act2=$('.b_tabs > div > div[n='+actBtab+']').parent();	 
	ass_title=$('.b_tabs > div[n='+n+'] > span').html();	
	$('.bt_blbs').hide();
	$('.btc'+n).show();
	if(n==2){$('[name=cof_8kbf0kv9on]').closest('tr').hide();$('[name=cof_drvx6e5xwl]').closest('tr').hide();}
	if(n==3){$('[name=cof_wiilprmlc]').closest('tr').hide();$('[name=cof_drvx6e5xwl]').closest('tr').hide();}
	actBtab=n;
	$('#assi_type').val(actBtab);
	$('.b_tabs').hide();
	$('.b_tabs_in').show();	
	$('#ass_title').html(ass_title)
	$('#m_info2').dialog('option','height',hhh-20);
	$('#assiSave').show();
	fixForm();
	fixPage();
}
function sch_ref(l){
	if(l==1){$('.centerSideIn').html(loader_win);}
	$.post(f_path+"X/cln_schedule_live.php",{},function(data){
		d=GAD(data);
		$('.centerSideIn').html(d);
		fixPage();
		fixForm();
	})	
}
function prvXCost(srv,itCost){
	$.post(f_path+"X/gnr_preview_consumption.php",{vis:visit_id,srv:srv,itCost:itCost},function(data){});
}
function changSPrice(id){
	p1=parseInt($('input[name=p1_'+id+']').val());
	p2=parseInt($('input[name=p2_'+id+']').val());
	$('#p3_'+id).html(p1+p2);
}
function docCostAdd(d){
	if(d!=''){
		$.post(f_path+"X/gnr_cost_add.php",{d:d},function(data){
			d=GAD(data);
			$('#m_info').html(d);
			fixForm();
			fixPage();
		})
	}
}

function diractPay(p,c){
	win('close','#m_info');
	$.post(f_path+"X/cln_visit_add_direct.php",{p:p,c:c,d:selctedDoc},function(data){
		d=GAD(data);		
		if(d!='x'){printReceipt(d,1);}
	})
}
function chrFixSrv(id,t){
	loader_msg(1,k_loading);
	$.post(f_path+"X/gnr_charity_reactive.php",{id:id,t:t}, function(data){
		d=GAD(data);	
		if(d==1){
			msg=k_done_successfully;mt=1;
			win('close','#m_info');			
		}else{
			msg=k_error_data;mt=0;
		}
		loader_msg(0,msg,mt);		
		res_ref(1)
	})	
}
function changePatVisit(t,id){
	loadWindow('#m_info2',1,k_modify_patient,400,200);
	$.post(f_path+"X/cln_visit_change_patient.php",{id:id,t:t}, function(data){
		d=GAD(data);	
		$('#m_info2').html(d);
		setupForm('change_pat','m_info2');
		fixForm();
		fixPage();
		$('#newPat').focus();
	})	
}

function vitalNormal(id){
	anaPAct=id;
	loadWindow('#full_win1',1,k_norl_rates,500,0);	
	$.post(f_path+"X/cln_vital_normal.php",{id:id}, function(data){
		d=GAD(data);
		$('#full_win1').html(d);
		fixPage();
		fixForm();
	})
}
function vitalNormal_add(r_id,id,type){
	loadWindow('#m_info2',1,k_ad_nor_rng,600,0);	
	$.post(f_path+"X/cln_vital_normal_add.php",{r_id:r_id,id:id,t:type}, function(data){
		d=GAD(data);
		$('#m_info2').html(d);
		loadFormElements('#lvv_form');	
		setupForm('lvv_form','m_info2');
		fixPage();
		fixForm();
	})
}
function vitalNormal_save(type){
	ageChk=1;
	sel_sex=1;
	typeChek=1;
	em='';
	if(sel_sex==1){}
	if(sel_age==1){ageChk=vitalCheckAge();}
	/****************************************************/
	if(type==1){		
		p1=parseFloat($('#p1').val());ErStl('#p1',0);
		p2=parseFloat($('#p2').val());ErStl('#p2',0);
		p3=parseFloat($('#p3').val());ErStl('#p3',0);
		p4=parseFloat($('#p4').val());ErStl('#p4',0);
		p5=parseFloat($('#p5').val());ErStl('#p5',0);
		if(isNaN(p2)){ErStl('#p2',1);typeChek=0;}
		if(isNaN(p4)){ErStl('#p4',1);typeChek=0;}
		if(typeChek==1){
			if(p2>=p4){
				ErStl('#p2',1);ErStl('#p4',1);typeChek=0;em+=k_err_nor_val;
			}
		}else{em=k_ent_req_val;}
		if(typeChek==1){
			if(p3!=''){
				if(p3<p2 || p3 >p4){
					ErStl('#p3',1);typeChek=0;em+=k_err_ent_defval;
				}
			}
		}
		if(typeChek==1){
			if(!isNaN(p1) || !isNaN(p5)){
				if(!isNaN(p1) && !isNaN(p5)){
					if(p1>p2){ErStl('#p1',1);typeChek=0;em+=k_err_ent_val;}
					if(p5<p4){ErStl('#p5',1);typeChek=0;em+=k_err_ent_val;}
					
				}else{
					ErStl('#p1',1);ErStl('#p5',1);typeChek=0;em+=k_bo_val_ent;
				}
			}
		}
		
	}
	/****************************************************/
	if(type==2){
		p2=parseFloat($('#p2').val());ErStl('#p2',0);
		if(isNaN(p2)){ErStl('#p2',1);typeChek=0;em=k_ent_req_val;}		
	}
	/****************************************************/
	if(em!=''){nav(1,em);}
	if(ageChk==1 && sel_sex==1 && typeChek==1){
		$('#lvv_form').submit();
	}	
}
function vitalCheckAge(){
	age_f=$('#l_age1').val();
	age_t=$('#l_age2').val();
	if(age_f=='')age_f=0;	
	if(age_t=='')age_t=0;	
	age_f=parseFloat(age_f);
	age_t=parseFloat(age_t);
	if(age_f>age_t){
		ErStl('#l_age1',1);ErStl('#l_age2',1);
		return 0;
	}else{
		ErStl('#l_age1',0);ErStl('#l_age2',0);
		return 1;
	}	
}
function vitalNormal_del(id){open_alert(id,'cln_1',k_wnt_cnl_val,k_cnl_norl_val);}
function vitalNormal_del_do(id){
	$.post(f_path+"X/cln_vital_normal_del.php",{id:id}, function(data){
		d=GAD(data);if(d==1){vitalNormal(anaPAct);}
	})
}
function vital_links(id){
	loadWindow('#m_info2',1,k_ass_other_vals,600,0);	
	$.post(f_path+"X/cln_vital_links.php",{id:id}, function(data){
		d=GAD(data);
		$('#m_info2').html(d);
		fixPage();
		fixForm();
	})
}
function setVital_links(){	
	$('.q_list3 div[no]').click(function(){
		no=$(this).attr('no');
		txt=$(this).attr('txt');
		r='<div class="fl" title="'+txt+'" v val="'+no+'" type="v" t="v">['+no+']</div>';
		addValQV(r,'v');
	})
	$('.q_tool div[v]').click(function(){
		no=$(this).attr('no');
		r='<div class="fl" n val="'+no+'" type="v" t="n">'+no+'</div>';
		addValQV(r,'v');
	})
	$('.q_tool div[o]').click(function(){
		no=$(this).attr('no');
		txt=$(this).attr('txt');
		r='<div class="fl" o val="'+no+'" type="o" t="o">'+txt+'</div>';
		addValQV(r,'o');
	})
	
	$('.q_tool > div[n] > div[nn]').click(function(){
		no=$('#qnoO').val();
		$('#qnoO').val('');
		if(no!=''){
			r='<div class="fl" n val="'+no+'" type="v" t="n">'+no+'</div>';		
			addValQV(r,'v');
		}
	})
	$('.q_tool > div[c]').click(function(){
		$('#nqn div:last-child').remove();
	})
}
function addValQV(val,type){
	l=$('#nqn div').length
	e=0;
	if(l==0){
		if(type=='o'){
			e_mas=k_equ_init_cal;
			e=1;
		}else{actQItme='v';}
	}else{
		t=$('#nqn div:last-child').attr('type');
		if(type==t){
			e_mas=k_error_data;
			e=1;
		}else{actQItme=type;}
			
	}
	if(e==1){
		nav(1,e_mas);
	}else{
		$('#nqn').append(val);
		fixForm();
	}
}
function saveQuV(id){
	l=$('#nqn div').length;
	v='';
	$('#nqn div').each(function(index, element) {
        vv=$(this).attr('val');
		tt=$(this).attr('t');
		if(v!='')v+=',';
		v+=tt+':'+vv;
    });
	if(l>0){
		if(tt=='o'){
			nav(1,k_equ_ntend_signl);
		}else{		
			$.post(f_path+"X/cln_vital_links_save.php",{id:id,v:v}, function(data){
				d=GAD(data);
				if(d==1){loadModule('rpr4hyts0r');win('close','#m_info2')}
			})
		}
	}else{nav(1,k_onitm_sel);} 
}
function setQListV(){	
	$('.q_list3 div[no]').click(function(){
		no=$(this).attr('no');
		txt=$(this).attr('txt');
		r='<div class="fl" title="'+txt+'" v val="'+no+'" type="v" t="v">['+no+']</div>';
		addValVQ(r,'v');
	})
	$('.q_tool div[v]').click(function(){
		no=$(this).attr('no');
		r='<div class="fl" n val="'+no+'" type="v" t="n">'+no+'</div>';
		addValVQ(r,'v');
	})
	$('.q_tool div[o]').click(function(){
		no=$(this).attr('no');
		txt=$(this).attr('txt');
		r='<div class="fl" o val="'+no+'" type="o" t="o">'+txt+'</div>';
		addValVQ(r,'o');
	})
	
	$('.q_tool > div[n] > div[nn]').click(function(){
		no=$('#qnoO').val();
		$('#qnoO').val('');
		if(no!=''){
			r='<div class="fl" n val="'+no+'" type="v" t="n">'+no+'</div>';		
			addValVQ(r,'v');
		}
	})
	$('.q_tool > div[c]').click(function(){
		$('#nqn div:last-child').remove();
	})
}
function addValVQ(val,type){
	l=$('#nqn div').length
	e=0;
	if(l==0){
		if(type=='o'){
			e_mas=k_equ_init_cal;
			e=1;
		}else{actQItme='v';}
	}else{
		t=$('#nqn div:last-child').attr('type');
		if(type==t){
			e_mas=k_error_data;
			e=1;
		}else{actQItme=type;}
			
	}
	if(e==1){
		nav(1,e_mas);
	}else{
		$('#nqn').append(val);
		fixForm();
	}
}
function loadVital(t){	
	$('#vital_p').html(loader_win);
	$.post(f_path+"X/cln_vital_preview.php",{t:t,v:visit_id,p:patient_id}, function(data){
		d=GAD(data);
		$('#vital_p').html(d);
		fixPage();
		fixForm();
		
	})
}
var v_nv_arr=new Array();
function vatilSession(id,t,p){
	loadWindow('#full_win1',1,k_meas_session,www,hhh);	
	$.post(f_path+"X/cln_vital_session.php",{id:id,t:t,p:p}, function(data){
		d=GAD(data);
		$('#full_win1').html(d);
		fixPage();
		fixForm();
		setupForm('vitalAdd','full_win1');
		setVitalSel();
	})
}
function setVitalSel(){
	$('.vitslList > div').click(function(){
		n=$(this).attr('n');
		t=$(this).attr('t');
		text=$(this).html();
		nv1=nv2=nvt='';
		if(t>0){
			nv1=$(this).attr('nv1');
			nv2=$(this).attr('nv2');
			nvt=$(this).attr('nvt');
		}			
		if($("tr[n=v"+n+"]").length==0){
			$('.vitslList > div[n='+n+']').hide(100);
			v_row='<tr n="v'+n+'"><td class="f1 fs14">'+text+'</td><td><input type="number" name="vs_'+n+'" t="'+t+'" nv1="'+nv1+'" nv2="'+nv2+'"/></td><td>'+v_nv_arr[n]+'</td><td><div class="ic40 icc2 ic40_del" onclick="delValrow('+n+')"></div></td></tr>';
			$('#vital_table').append(v_row);
			setVitalInput(n);
			fixPage();
		}
	})
}
function setVitalInput(n){
	$('input[name=vs_'+n+']').keyup(function(){
		t=$(this).attr('t');
		v=$(this).val();
		nv1=parseFloat($(this).attr('nv1'));
		nv2=parseFloat($(this).attr('nv2'));			
		stat='';
		if(!isNaN(nv1)){
			if(t==1){
				if(v>=nv1 && v<=nv2){stat='n';}else{stat='x';}
			}
			if(t==2){
				if(nv1==0){if(v>nv2){stat='n';}else{stat='x';}}
				if(nv1==1){if(v<nv2){stat='n';}else{stat='x';}}
				if(nv1==2){if(v>=nv2){stat='n';}else{stat='x';}}
				if(nv1==3){if(v<=nv2){stat='n';}else{stat='x';}}
				if(nv1==4){if(v==nv2){stat='n';}else{stat='x';}}
				if(nv1==5){if(v!=nv2){stat='n';}else{stat='x';}}
			}
		}

		if(stat=='n'){$(this).css('border-bottom','3px #0c0 solid');}
		if(stat=='x'){$(this).css('border-bottom','3px #f00 solid');}
		if(stat==''){$(this).css('border-bottom','3px #ccc solid');}
	})
}
function delValrow(n){
	$("tr[n=v"+n+"]").remove();
	$('.vitslList > div[n='+n+']').show(100);
	fixPage();
}

function saveVitalVals(rec){
	if($('input[nv1]').length>0){
		err=0;
		$('input[nv1]').each(function(){
			if($(this).val()==''){err=1;}
		})
		if(err==0){sub('vitalAdd');}else{nav(1,k_all_fields_must_filled);}
	}else{
		if(rec==0){
			nav(1,k_one_ind_must_add);
		}else{sub('vitalAdd');}
	}
}
function sesView(id){
	loadWindow('#m_info',1,k_ses_det,600,hhh);	
	$.post(f_path+"X/cln_vital_session_view.php",{id:id}, function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixPage();
		fixForm();
	})
}
function vitalChart(p,id,name){
	loadWindow('#m_info',1,name,800,hhh);	
	$.post(f_path+"X/cln_vital_session_chart.php",{p:p,id:id}, function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixPage();
		fixForm();
	})
}
function srvAlertPay(vis,mood){
	winWidth=800;
	if(mood==4){winWidth=www;}
	loadWindow('#m_info',1,k_alert_details,winWidth,hhh);	
	$.post(f_path+"X/gnr_visit_alert.php",{vis:vis,mood:mood}, function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixPage();
		fixForm();
	})
}
var actDocPay=0;
function denForwardPay(vis,pat){
	amount=$('#denPay').val();
	doc=$('#docs').val();	
	maxAmount=parseInt($('#denPay').attr('max'));	
	if((amount <= maxAmount && doc!='') || amount==0 ){
		actDocPay=doc;
		forwardPayment(vis,amount,4,pat);
	}else{
		nav(3,k_amount_not_exceed);
	}
}
function forwardPayment(vis,amount,mood,pat){
	loader_msg(1,k_loading);
	win('close','#m_info');
	$.post(f_path+"X/gnr_visit_alert_pay.php",{v:vis,a:amount,mood:mood,doc:actDocPay}, function(data){
		d=GAD(data);	
		if(d==1){
			msg=k_done_successfully;mt=1;
			if(mood==4){
				win('close','#m_info');				
				accStat(pat);
			}else{
				printReceipt(vis,mood);
			}
		}else{
			msg=k_error_data;mt=0;
		}
		loader_msg(0,msg,mt);		
		res_ref(1);
		actDocPay=0;
	})	
}
/***********/
var actCompla=0;
function complaintSet(){
	$('#complaSr').keyup(function(){complaSr();});
	$('#complaCats div.norCat').click(function(){
		actCompla=$(this).attr('cat_num');
		$('#complaCats div.actCat').attr('class','norCat');
		$(this).attr('class','actCat');
		loadCompla();
	});
}
function complaSr(){
	str=$('#complaSr').val();
	str=str.toLowerCase();		
	strSel='[icpc_no]';
	if(str==''){
		$('[icpc_no][sel=0]').show();
	}else{			
		$('[icpc_no][sel=0]').each(function(index, element){
			s_id=$(this).attr('icpc_no');
			code=$(this).attr('code').toLowerCase();
			txt=$(this).attr('name').toLowerCase();						
			n = txt.search(str);
			n2 = code.search(str);
			if(n!=(-1) || n2!=(-1)){$(this).show(300);}else{$(this).hide(300);}
		})
	}	
}
function loadCompla(){
	$('#complaCdet').html(loader_win);	
	$.post(f_path+"X/cln_preview_compla.php",{vis:visit_id,cat:actCompla}, function(data){
		d=GAD(data);
		$('#complaCdet').html(d);
		$('div[icpc_no]').click(function(){
			id=$(this).attr('icpc_no');
			code=$(this).attr('code');
			name=$(this).attr('name');
			addValCompla(id,code,name);
		});
		fixPage();
		fixForm();
	})
}
function addValCompla(id,code,name){	
	$('[icpc_no='+id+']').hide(200);
	win('close','#m_info');
	$.post(f_path+"X/cln_preview_compla_add.php",{v:visit_id,p:patient_id,id:id}, function(data){
		d=GAD(data);	
		if(d==1){
			$('#complaSr').val('');
			complaSr();
			$('#complaSel').append('<tr id="Crow'+id+'"><td><ff>'+code+'</ff></td><td txt>'+name+'</td><td width="30"><div class="ic40 icc2 ic40_del" onclick="compla_del('+id+')"></div></td></tr>');
			$('[icpc_no='+id+']').hide(200);
			$('[icpc_no='+id+']').attr('sel','1');			
		}else{
			$('[icpc_no='+id+']').show(200);
			nav(2,k_error_data);
		}	
	})	
}
function compla_del(id){
	$('#Crow'+id).hide(200);
	win('close','#m_info');
	$.post(f_path+"X/cln_preview_compla_del.php",{v:visit_id,p:patient_id,id:id}, function(data){
		d=GAD(data);	
		if(d==1){
			$('#complaSr').val('');
			complaSr();
			$('#Crow'+id).remove();
			$('[icpc_no='+id+']').show(200);
			$('[icpc_no='+id+']').attr('sel','0');
		}else{
			nav(2,k_error_data);
			$('#Crow'+id).show(200);
		}
				
	})	
}
/***********/
var actDiagn=0;
function diagnosisSet(){
	$('#diagnSr').keyup(function(){diagnSr();});
	$('#diagnCats div.norCat').click(function(){
		actDiagn=$(this).attr('cat_num');
		$('#diagnCats div.actCat').attr('class','norCat');
		$(this).attr('class','actCat');
		loadDiagnSr();
	});
}
function diagnSr(){
	str=$('#diagnSr').val();
	str=str.toLowerCase();		
	strSel='[icd_no]';
	if(str==''){
		$('[icd_no][sel=0]').show();
	}else{			
		$('[icd_no][sel=0]').each(function(index, element){
			s_id=$(this).attr('icd_no');
			code=$(this).attr('code').toLowerCase();
			txt=$(this).attr('name').toLowerCase();						
			n = txt.search(str);
			n2 = code.search(str);
			if(n!=(-1) || n2!=(-1)){$(this).show();}else{$(this).hide();}
		})
	}	
}
function loadDiagnSr(){
	$('#diagnCdet').html(loader_win);	
	$.post(f_path+"X/cln_preview_diagn.php",{vis:visit_id,cat:actDiagn}, function(data){
		d=GAD(data);
		$('#diagnCdet').html(d);
		$('div[icd_no]').click(function(){
			id=$(this).attr('icd_no');
			code=$(this).attr('code');
			name=$(this).attr('name');
			addValDiagn(id,code,name);
		});
		fixPage();
		fixForm();
	})
}
function addValDiagn(id,code,name){	
	$('[icd_no='+id+']').hide(200);
	win('close','#m_info');
	$.post(f_path+"X/cln_preview_diagn_add.php",{v:visit_id,p:patient_id,id:id}, function(data){
		d=GAD(data);	
		if(d==1){
			$('#diagnSr').val('');
			diagnSr();
			$('#DiagnSel').append('<tr id="CDrow'+id+'"><td><ff>'+code+'</ff></td><td txt>'+name+'</td><td width="30"><div class="ic40 icc2 ic40_del" onclick="diagn_del('+id+')"></div></td></tr>');
			$('[icd_no='+id+']').hide(200);
			$('[icd_no='+id+']').attr('sel','1');			
		}else{
			$('[icd_no='+id+']').show(200);
			nav(2,k_error_data);
		}	
	})	
}
function diagn_del(id){
	$('#CDrow'+id).hide(200);
	win('close','#m_info');
	$.post(f_path+"X/cln_preview_diagn_del.php",{v:visit_id,p:patient_id,id:id}, function(data){
		d=GAD(data);	
		if(d==1){
			$('#diagnSr').val('');
			diagnSr();
			$('#CDrow'+id).remove();
			$('[icd_no='+id+']').show(200);
			$('[icd_no='+id+']').attr('sel','0');
		}else{
			nav(2,k_error_data);
			$('#CDrow'+id).show(200);
		}
				
	})	
}

function changePrice(id){
	loadWindow('#m_info',1,k_srv_prc,500,0);	
	$.post(f_path+"X/cln_preview_x_change_price.php",{id:id}, function(data){
		d=GAD(data);
		$('#m_info').html(d);
		$('input[name=price]').focus();
		setupForm('srv_ch','m_info');
		//calNPr();
		fixPage();
		fixForm();
	})
}
function madhisCatAdd(){
	co_selLongValFree('w3ns60tb60',"madhisAdd([id])|||",0);	
}
function madhisAdd(id){
	co_selLongValFree('3mxjmxcaq5',"newmadHis(0,[id])|cat="+id+"||cat:"+id+":h",0);
}
function newmadHis(id,sta){
	loadWindow('#m_info',1,k_add_med_history,600,0);	
	$.post(f_path+"X/cln_preview_madhis.php",{id:id,sta:sta}, function(data){
		d=GAD(data);
		$('#m_info').html(d);
		loadFormElements('#madHis');			
		setupForm('madHis','m_info');
		fixPage();
		fixForm();
	})
}
/*****************New Design***************************/
var visit_id=0;
var pActList='';
var addons_ex=1;
function startPrv(){
	refPage('cln1',10000);	
	setTimeout(function(){cln_prv_ref();},300);	
	setTimeout(function(){loadAddons(1);},600);
	if(addons_ex==1){setTimeout(function(){loadPrvDetails(1);},2000);}	
	$('.cp_s1_b2').click(function(){loadService(1);});
	$('[paInfo]').click(function(){
        patInfo(patient_id,1);
        //co_loadForm(patient_id,3,"87zc6kbbs5||loc('_Preview-Clinic."+visit_id+"')|");
    });
	$('[addSet]').click(function(){setAddons();});
	$('[finish]').click(function(){s=$(this).attr('s');prvEnd(s);});
	$('[help]').click(function(){openHelpWin('pqgs99e0kf',1);});
	$('[back]').click(function(){loc('_Visits');});
	$('#exWin').click(function(){inWinClose();})
	$('[mmbA]').click(function(){setBlockAll();})
	$('[prvSw]').click(function(){loadPrvSwitch();})
	loadService(1);
	fixPage();
}
function cln_prv_ref(){
	$.post(f_path+"X/cln_prv_live.php",{vis:visit_id},function(data){
		d=GAD(data);
		dd=d.split('^');	
		$('#timeSec').html(dd[0]);		
		$('#patNo').html(dd[1]);
		$('#patWs').attr('class','fl cbg3 '+dd[2]);
		fixPage();		
		fixForm();
		if(pActList=='srv'){loadService();}
	})
}
function loadAddons(l=0){
	if(l==1){$('#addons').html(loader_win);}
	$.post(f_path+"X/cln_prv_addons.php",{vis:visit_id},function(data){
		d=GAD(data);
		$('#addons').html(d);
		setAddonsClick();
		fixPage();
		fixForm();
	})
}
function unActAddons(){$('.addons > div').attr('act','0');}
function setAddons(){
	loader_msg(1,k_loading);
	$.post(f_path+`X/cln_prv_addons_set.php`,{}, function(data){
		d=GAD(data);
		loader_msg(0,'',0);
		eval(d);
	})	
}
function setAddonsSave(data){
	loader_msg(1,k_loading);
	$.post(f_path+"X/cln_prv_addons_save.php",{data:data}, function(data){
		d=GAD(data);
		loader_msg(0,'',0);
		loc('');
	})	
}
function loadService(l=0){
	if(l==1){prvLoader(1);}
	//inWinClose();
	pActList='srv';
	$.post(f_path+"X/cln_prv_srvs.php",{vis:visit_id},function(data){
		d=GAD(data);
		if(pActList=='srv'){
			loadPrvData('srv',d);
			prvLoader(0);
			setServers();
		}
		fixPage();
		fixForm();
	})
}
function setServers(){
	$('.cp_srvList div[done]').click(function(){n=$(this).closest('[sn]').attr('sn');pSrvOpr(1,n);});
	$('.cp_srvList div[cancel]').click(function(){n=$(this).closest('[sn]').attr('sn');pSrvOpr(2,n);});
	$('.cp_srvList div[res]').click(function(){n=$(this).closest('[sn]').attr('sn');pSrvOpr(3,n);});
	$('.cp_srvList div[price]').click(function(){n=$(this).closest('[sn]').attr('sn');prvChangePrice(n);});
	$('[addSrv]').click(function(){prvAddNewServ();});
	$('[doneAll]').click(function(){pSrvOpr(4);});
}
function pSrvOpr(opr,n=0,add=''){
	prvLoader(1);
	$.post(f_path+"X/cln_prv_srvs_oprs.php",{opr:opr,vis:visit_id,srv:n,add:add},function(data){
		d=GAD(data);
		dd=d.split('^');
		msg='';
		if(dd[0]==1){
			loadService();		
		}else{
			msg=k_error_data;
		}
		loader_msg(0,msg,0);
		if(dd[1]){eval(dd[1]);}		
	})	
}
function loadPrvData(n,list=0,des=0){
	pActList=n;
	if(list==1){list=loader_win;}
	if(des==1){des=loader_win;}
	if(list!=0){$('#listSec').html(list);}
	if(des!=0){$('#desSec').html(des);}
	$('.addons > div').attr('act','0');
	$('.addons > div[code='+n+']').attr('act','1');
}
function prvLoader(s){
	if(s==1){
		$('.prvLoader').show();
		$("#listSec").css({ opacity: 0.4 });
	}else{
		$('.prvLoader').hide(); 
		$("#listSec").css({ opacity: 1 });
	}
}
/******************************************************/
function prvChangePrice(id){
	loadWindow('#m_info',1,k_srv_prc,500,0);	
	$.post(f_path+"X/cln_prv_srvs_price.php",{id:id}, function(data){
		d=GAD(data);
		$('#m_info').html(d);
		$('input[name=price]').focus();
		setupForm('srv_ch','m_info');		
		fixPage();
		fixForm();
	})
}
function prvAddNewServ(){
	loadWindow('#m_info',1,k_services,600,0);	
	$.post(f_path+"X/cln_prv_srvs_add.php",{id:visit_id}, function(data){
		d=GAD(data);
		$('#m_info').html(d);
		loadFormElements('#n_visit');			
		setupForm('n_visit','m_info');
		$('#servSelSrch').focus();
		$('#servSelSrch').keyup(function(){serServList();})
		fixForm();
		fixPage();
		//sers_set();
	})
}
function addSrvDo(){
	err=0;
	$('input[qunt]').each(function(){		
		v=parseInt($(this).val());
		if(v>10){
			$(this).css('border','1px #f00 solid');
			$(this).focus();
			err=1;
			msg=k_ser_not_repeat;
		}else{
			$(this).css('border','');
		}
	})
	if(err==0){
		sel=$('[par=ceckServ] [ch=on]').length;		
		if(sel==0){
			err=1;
			msg=k_must_sel_srvc
		}
	}
	if(err==0){sub('n_visit');}else{nav(3,msg);}
}
function prvEnd(s,rate=1){
	if(s==2){
		loc('_Visits');
	}else{
		loader_msg(1,k_loading);
		$.post(f_path+"X/cln_prv_vis_end.php",{v_id:visit_id,rate:rate},function(data){
			d=GAD(data);
			dd=d.split('^');
			if(dd[0]==1){
				loader_msg(0,'',0);
				loadWindow('#m_info',1,k_end_pre,400,0);
				$('#m_info').html(dd[1]);
				fixPage();
				fixForm();
			}
			if(dd[0]==2){loc('_Visits');}
			if(dd[0]==3){loader_msg(0,'',0);nav(2,k_srv_fsh_fr);}
            if(dd[0]==4){loader_msg(0,'',0);rateNurs(1,visit_id);}
		})
	}
}
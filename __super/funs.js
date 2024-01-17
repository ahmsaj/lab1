var txtT='';var thisrow='';var all_rows=0;var DelModType=1;var ord_data=new Array();var v_fix;var stopCheck=0;var actModItem=0;var act_listNum=0;var act_ParNum=0;var act_PhotoNum=0;
/*******************************************************************************/
function loadFileds(table,c_link,ordName){
	$('div[link='+c_link+']').html(loader_win);
	$.post(f_path+"M/mods_items_colums.php",{table:table,o:ordName}, function(data){
		d=GAD(data);        
        dd=d.split('^');
		$('div[link_id][v]').html(dd[0]);
        $('div[link_id][l]').html(dd[1]);
		makeColumrName(c_link);
	})
}
function makeColumrName(c_link){
	$('div[link='+c_link+']').each(function(index, element){
		id=$(this).attr('link_id');
		$(this).children('select').attr('name',id);
		$(this).children('select').attr('id',id);			
	});
}
function changeColType(id,type,prams){
	out_d='';
	$('#pars_'+id).html('');
	$('#def_'+id).html('');
	$('#req_'+id).html('');
	loadReqDefInput(id,type);
	
	$('#filter_'+id).val('0');
	$('#filter_'+id+' option').remove();
	$('#filter_'+id).append('<option value="0">'+k_sl_sr_tp+'</option>');
	if(type==1 || type==2 || type==5 || type==6 || type==7 || type==14 ){
		$('#filter_'+id).append('<option value="1">'+k_equ+'</option>');
	}
	if(type==1 || type==4 || type==5 || type==7 || type==8 || type==13 || type==14 ){
		$('#filter_'+id).append('<option value="2">'+k_like+'</option>');
	}
	if(type==2 || type==14){$('#filter_'+id).append('<option value="3">'+k_range+'</option>');}
	if(type==3 || type==11 || type==14){$('#filter_'+id).append('<option value="4">'+k_sorted+'</option>');}
	
	linkText='';
	if(type==5){linkText=k_lk_sl_sv_fo;}
	$('#link_'+id).html(linkText);
	if(type==1){		
		out_d+=txtT.replace('[id]',id);		
		$('#pars_'+id).html(out_d);
	}	
	if(type==2){		
		out_d+=`<select name="date_${id}">
            <option value="0" selected>${k_norm_date}</option>
            <option value="1">${k_date_sec}</option>
            <option value="2">${k_date_moment_auto}</option>
            <option value="3">${k_date_moment_auto} (Update)</option>
        </select>`;
		$('#pars_'+id).html(out_d);
	}
	if(type==3){
		out_d+='<select name="actType_'+id+'"><option value="1"  selected>'+k_independent+'</option><option value="2" >'+k_linked+'</option></select><input type="checkbox" name="actShow_'+id+'" value="1" checked/><div class="fl f1 lh40">'+k_con_butt+'</div>';
		$('#pars_'+id).html(out_d);
	}
	if(type==5){
		out_d='<input type="hidden" name="parent_'+id+'" id="parent_'+id+'" value=""/>\
		<div class="f1 clr5 Over" onclick="parlist('+id+')">'+k_edt_prp+'</div><div id="parent_t'+id+'" dir="ltr"></div>';
		$('#pars_'+id).html(out_d);
	}
 	if(type==10){
		$('#pars_'+id).html(loader_win);
		$.post(f_path+"M/mods_items_chiled.php",{id:id,type:type,prams:prams}, function(data){
			d=GAD(data);
			$('#pars_'+id).html(d);
		})
	}
    if(type==12){		
		out_d+=`<input type="checkbox" value="1" name="passType_${id}'"/>
        <div class="fl f1 lh40">فحص كلمة السر</div>`;
		$('#pars_'+id).html(out_d);
	}
	if(type==4){
        /*
		out_d='<select name="photo_'+id+'"><option value="0" selected >'+k_one_photo+'</option><option value="1" >'+k_many_photo+'</option></select>\
        <input type="text" placeholder="لواحق محددة"/>\
        <input type="text" placeholder="العرض الأقصى"/>\
        <input type="text" placeholder="الارتفاع  الأقصى"/>\
        ';
		$('#pars_'+id).html(out_d);*/
        out_d+='<input type="hidden" name="photo_'+id+'" id="photo_'+id+'"/>\
		<div class="f1 clr5 Over" onclick="photoSetting('+id+')">'+k_edt_prp+'</div>\
		<div id="photoSett_'+id+'"></div>';
		$('#pars_'+id).html(out_d);
	}
	if(type==8){
		out_d+='<select name="file_'+id+'" ><option value="0">'+k_all_types+'</option><option value="1">'+k_documents+'</option> <option value="2">'+k_compressed_files+'</option> </select>';
		$('#pars_'+id).html(out_d);
	}
	if(type==11){
		out_d+='<table cellpadding="4"><tr>\
		<td>'+k_type+'<br><select name="static_'+id+'" onchange="static_ch('+id+',this.value)" ><option value="1">User ID</option><option value="2">GET ID</option><option value="3">POST ID</option><option value="4">GET</option><option value="5">POST</option><option value="6">Variable</option><option value="7">Static Value</option></select></td>\
		<td id="show_sta_'+id+'" class="hide">'+k_val+'<br><input type="text" name="static_val_'+id+'"/></td></tr></table>';
		$('#pars_'+id).html(out_d);
	}
	if(type==6){
		out_d+='<input type="hidden" name="list_'+id+'" id="list_'+id+'"/>\
		<div class="f1 clr5 Over" onclick="addTolist('+id+')">'+k_edt_mnu+'</div>\
		<div id="list_t'+id+'"></div>';
		$('#pars_'+id).html(out_d);
	}
	if(type==15 || type==14){
		out_d+=k_val+' : <input style="width:100px" type="text" name="cus_val_'+id+'"/>';
		$('#pars_'+id).html(out_d);
	}
	loadFormElements('#modForm');
}
function loadReqDefInput(id,type){
	if(type==1 || type==7 || type==13){
		$('#def_'+id).html('<input type="text" name="defult_'+id+'" />');
	}
	if(type==3){
		$('#def_'+id).html('<input type="checkbox" value="1" name="defult_'+id+'" /><div class="fl f1 lh40">'+k_active+'</div>');
	}	
	if(type!=3 &&  type!=11 && type!=14){
		$('#req_'+id).html('<input type="checkbox" name="req_'+id+'" />');	
	}
	if(type==5  || type==6){
	$('#def_'+id).html('<input type="checkbox" value="1" name="par_m_'+id+'" />'+k_mt_vl+'<div class="fl f1 lh40"></div>');
	}	
}
function static_ch(id,val){
	if(val>=4 || val==1){$('#show_sta_'+id).show();}else{$('#show_sta_'+id).hide();}
}
/************************************************************************/
function addOnButts(id){
	loadWindow('#m_info',1,k_ad_ta,600,400);
	$.post(f_path+"M/mods_oprs_buttons.php",{id:id}, function(data){
		d=GAD(data);				
		$('#m_info').html(d);
		fixForm();
        fixPage();
		setupForm('add_task_form','m_info');
	})
}
function addRowForTasks(){
	all_rows++;
	out='<tr id="tk_row_'+all_rows+'">\
	<td><input type="text" name="title[]" /></td>\
	<td><input type="text" name="function[]"/></td>\
	<td><input type="text" name="style[]"/></td>\
	<td><div class="i30 i30_del" onclick="deletRow(\'tk_row_'+all_rows+'\')"></div></td></tr>';
	$('#tab_tasks').append(out);	
}
function deletRow(id){$('#'+id).remove();}
//--------------
var actModOpr='';
function modLinkes(mod){
    actModOpr=mod
	loadWindow('#m_info',1,k_lks,600,0);	
	$.post(f_path+"M/mods_oprs_linkes.php",{mod:mod}, function(data){
		d=GAD(data);				
		$('#m_info').html(d);		
		fixForm();
		fixPage();
	})
}
function modLinkesAdd(id=0){    
	loadWindow('#m_info2',1,k_nw_lk,400,0);
	$.post(f_path+"M/mods_oprs_linkes_add.php",{mod:actModOpr,id:id}, function(data){
		d=GAD(data);				
		$('#m_info2').html(d);
		makeColumrName('link_col');
        setupForm('add_link_form','m_info2');
		fixForm();
        fixPage();
	})
}
function modLinkesDel(id){
    loader_msg(1,k_loading);
	$.post(f_path+"M/mods_oprs_linkes_del.php",{mod:actModOpr,id:id},function(data){
		d=GAD(data);
		if(d==1){
			msg=k_done_successfully;mt=1;
			modLinkes(actModOpr);			
		}else{
			msg=k_error_data;mt=0;
		}
		loader_msg(0,msg,mt);
	})	
}
/********************************/
function modCons(mod){
    actModOpr=mod;
	loadWindow('#m_info',1,k_conditions_program,600,hhh-20);
	$.post(f_path+"M/mods_oprs_cons.php",{mod:mod}, function(data){
		d=GAD(data);				
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
}
function modConsAdd(id=0){
	loadWindow('#m_info2',1,k_ad_prgm_cond,400,0);
	$.post(f_path+"M/mods_oprs_cons_add.php",{mod:actModOpr,id:id}, function(data){
		d=GAD(data);				
		$('#m_info2').html(d);
        setupForm('add_cons_form','m_info2');
		fixForm();		
	})
}
function modConsDel(id){
    loader_msg(1,k_loading);
	$.post(f_path+"M/mods_oprs_cons_del.php",{mod:actModOpr,id:id},function(data){
		d=GAD(data);
		if(d==1){
			msg=k_done_successfully;mt=1;
			modCons(actModOpr);			
		}else{
			msg=k_error_data;mt=0;
		}
		loader_msg(0,msg,mt);
	})	
}
/********************************/
function mLinkWin(id){
	loadWindow('#m_info2',1,k_ad_lk_fd,500,0);
	$.post(f_path+"M/link_set.php",{id:id}, function(data){
		d=GAD(data);				
		$('#m_info2').html(d);
		fixForm();		
	})
}
function link_setVal(p_id,s_id){
	loadWindow('#m_info2',1,k_tlk_ch_fd,500,0);
	$.post(f_path+"M/link_set_col.php",{p_id:p_id,s_id:s_id}, function(data){
		d=GAD(data);
		$('#m_info2').html(d);
		fixForm();
		fixPage();
	})
}
function link_setSave(p_id,s_id,col){
	$('#m_info2').html(loader_win);

	$.post(f_path+"M/link_set_save.php",{p_id:p_id,s_id:s_id,col:col}, function(data){
		sub('modForm');
		setTimeout(function(){modItem(actModItem);}, 2000);
		win('close','#m_info2');
		
	})
}
function mLinkDel(id,opr){
	loadWindow('#m_info2',1,k_dt_lk,500,0);
	$.post(f_path+"M/link_set_del.php",{id:id,opr:opr}, function(data){
		d=GAD(data);	
		if(opr==1){			
			$('#m_info2').html(d);
			fixForm();
		}else{
			sub('modForm');
			setTimeout(function(){modItem(actModItem);}, 2000);
			win('close','#m_info2');			
		}
	})
}
function delMod(id,type){
	DelModType=type;
	loadWindow('#m_info',1,k_dt_md,500,0);
	$.post(f_path+"M/mods_del_info.php",{id:id,type:type},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		loadFormElements('#delMod');	
		fixForm();		
	})
}
function DM(id){
	loader_msg(1,k_deleting);
	t=0;
	if($('input[name=d_table]').val()=='on'){t=1;}
	win('close','#m_info')
	$.post(f_path+"M/mods_del_do.php",{id:id,t:t,type:DelModType}, function(data){
		loader_msg(0,k_done_successfully,1);	
		loadModule();
	})
}
/***************************************************/
function selIcon(i,f){
	$('#'+f).val(i);
	if($('#'+f+'_in div[ico='+i+']').attr('sw')=='on'){
		$('#'+f+'_in div[ico='+i+']').attr('sw','off');
		$('#'+f).val('');
	}else{
		$('#'+f+'_in div[ico]').attr('sw','off');
		$('#'+f+'_in div[ico='+i+']').attr('sw','on');
	}
}
/***************************************************/
function loadModMenu(l){
	if(l==1){
		$('.modm_m').html(loader_win);
		$('.modm_mod').html(loader_win);
	}
	$.post(f_path+"M/menu_co.php",{}, function(data){
		d=data.split('<!--***-->');	
		//$('.centerSideIn').html(d[1]);
		$('.modm_m').html(d[1]);
		$('.modm_mod').html(d[2]);
		set_modMenu();
	})
}
function set_modMenu(){
	$(function(){
		$(".d_move").draggable({						
			cursor: 'all-scroll',
			opacity: 0.9,
			start: function(event,ui){
				$('.d_move[movemodMe]').attr("movemodMe",0);
				$(this).attr("movemodMe",1);
				mf_id= $(this).attr("no");
				mf_type= $(this).attr("type");
				mf_p= $(this).attr("p");
				$(this).css('position','relative');
				$(this).css('z-index','50000');
				$(this).css('background-color',clr5);
				$(this).css('top',mouseY);
				$(this).css('left',mouseX);
				$(this).closest('.modm_mod_list').css('overflow-x','visible');

			},
			drag: function(event, ui){				
				$(this).css('top',mouseY);
				$(this).css('left',mouseX);
			},		
			revert: true ,
			stop: function(event,ui){
				$('.d_res').css("background-color","");
				$(this).css('background-color',"");
				$(this).css('z-index','');
			}	
			
		});	
		$(".d_res").droppable({
			over: function(event,ui){$(this).css("background-color",'#eee');},
			out: function(event,ui){$(this).css("background-color","");},
			drop: function(event,ui){				
				mt_id= $( this ).attr("no");
				mt_type= $( this ).attr("type");
				data=mf_id+'|'+mt_id+'|'+mf_type+'|'+mt_type;
				if(mf_p!=mt_id){
					menuEffect(data);				
					$('div[movemodMe=1]').hide(500);
				}
			}
		});
		$(".d_res2").droppable({
			over: function(event,ui){
				$(this).css("background-color",'#ccc');
				$(".d_res").droppable("disable");
				$(".d_res").css("background-color","");
			},
			out: function(event,ui){
				$(this).css("background-color","");
				$(".d_res").css("background-color",'#eee');
				$(".d_res").droppable("enable");
			},
			drop: function(event,ui){				
				mt_id= $( this ).attr("no");
				mt_type= $( this ).attr("type");
				data=mf_id+'|'+mt_id+'|'+mf_type+'|'+mt_type;
				if(mf_p!=mt_id){
					menuEffect(data);				
					$('div[movemodMe=1]').hide(500);
				}
			}
		});
	});
}
function menuEffect(data){//alert(data)
	$.post(f_path+"M/menu_move.php",{data:data}, function(data){loadModMenu();})
}
function newModMenu(id){
	loadWindow('#m_info',1,k_ad_lst,600,0);
	$.post(f_path+"M/menu_new.php",{id:id}, function(data){
		d=GAD(data);	
		$('#m_info').html(d);		
		setupForm('co_menu','m_info');
		loadFormElements('#co_menu');
		fixForm();
		fixPage();
	})	
}
function delModMenu(id){
	open_alert(id,'s8',k_q_delete_rec,k_delete_item);	
}
function delModMenuDo(id){
	$.post(f_path+"M/menu_del.php",{id:id}, function(data){loadModMenu();})
}
function menuOrder(id){
	loadWindow('#m_info',1,k_ord_lst,400,0);
	$.post(f_path+"M/menu_order.php",{id:id}, function(data){
		d=GAD(data);	
		$('#m_info').html(d);
		setmenuOrder();
		fixForm();
		fixPage();
	})
}
/***********************************************/
function setmenuOrder(){
	$('.mOrdMod div').each(function(index, element) {
        //$(this).width(CSW-20);
    }); 
	$('.mOrdMod').sortable({
		axis: "y",
		cursor: "move",
		distance: 3,
		items: "div",
		placeholder:"orderPlace",
		revert: true,
		tolerance: "move",
		create: function(event,ui){creatOrderMArray();$(".d_res").droppable("disable");$(".d_res2").droppable("disable");},
		start: function(event,ui){$(".d_res").droppable("disable");$(".d_res2").droppable("disable");},
		stop: function(event,ui){sendOrderMChang();//$(".d_res").droppable("enable");$(".d_res2").droppable("enable");
		},
	});
}
function creatOrderMArray(){	
	o=0;	
	$('.mOrdMod div').each(function(index, element) {
		o_id=$(this).attr('no');
		ord=$(this).attr('ord');
		ord_data[o]=[o_id,ord];
		o++;
	});	
}
function sendOrderMChang(){
	o=0;
	f_ord=0;
	ord_change='';
	$('.mOrdMod div').each(function(index, element) {
		o_id=$(this).attr('no');
		ord=$(this).attr('ord');
		if(o_id!=ord_data[o][0]){
			if(f_ord!=0)ord_change+='|';
			ord_change+=o_id+':'+ord_data[o][1];
			$(this).attr('ord',ord_data[o][1])
			f_ord=1;
		}		
		o++;
	});
	if(ord_change!=''){saveOrderMChang(ord_change);creatOrderArray();}	
}
function saveOrderMChang(change){
	$.post(f_path+"M/menu_order_ord.php",{d:change}, function(data){
		loadModMenu();
		creatOrderMArray();
	})
}
function idsWin(id,val){
	loadWindow('#m_info',1,k_set_fld,500,200);
	$.post(f_path+'M/mods_oprs_ids.php',{id:id,val:val}, function(data){
		d=GAD(data);
		$('#m_info').html(d);		
		fixForm();
		setupForm('idsWinForm','m_info');
		loadFormElements('#idsWinForm');							
	})	
}
function mm_file(id,t){
	loadWindow('#m_info',1,k_edt_cod,www,200);
	$.post(f_path+'M/files_edit.php',{id:id,t:t}, function(data){
		d=GAD(data);
		$('#m_info').html(d);		
		fixForm();
		fixPage();
		setupForm('fEditeForm','m_info');
		loadFormElements('#fEditeForm');							
	})	
}
function modItem(id){
	actModItem=id;
	loadWindow('#full_win1',1,k_module_Items,www,hhh);
	$.post(f_path+'M/mods_items.php',{id:id}, function(data){
		d=GAD(data);
		$('#full_win1').html(d);		
		setupForm('modForm','full_win1');
		loadFormElements('#modForm');
		fixPage();
		fixForm();
		setOrder();				
	})	
}
function exCol(code){
	loader_msg(1,k_loading);
	$.post(f_path+'M/mods_oprs_exclusion.php',{code:code}, function(data){
		d=GAD(data);
		loader_msg(0,'',0);
		eval(d);
	})	
}
function exColSave(code,data){
	loader_msg(1,k_loading);
	$.post(f_path+"M/mods_oprs_exclusion_save.php",{code:code,data:data}, function(data){
		d=GAD(data);
		loader_msg(0,'',0);
		loadModule()
	})	
}
function oChild(o,id){
	if(o==1){
		open_alert(id,'s3',k_ad_fs_sc,k_add);
	}else{
		open_alert(id,'s4',k_wnt_dt_fd,k_dt_fd);
	}
}
function MChild(o,id){
	$.post(f_path+"M/mods_items_new.php",{id:id,o:o}, function(data){modItem(actModItem)})
}
function delvl(){
	$('.il_blc').click(function(){
		val=$(this).html();
		act_listNum=$(this).attr('num');			
		update_list_val(val,'del');
		$(this).remove();
	})
}
function fixOrder(){
	loader_msg(1,k_debug);
	$.post(f_path+'M/mods_items_fixorder.php',{id:actModItem}, function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;modItem(actModItem)}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);
	})	
}
/***********************************/
function addTolist(id){
	act_listNum=id;
	val=$('#list_'+id).val();
	loadWindow('#m_info',1,k_lst_itm,600,hhh);
	$.post(f_path+'M/mods_items_list.php',{id:id,val:val}, function(data){
		d=GAD(data);
		$('#m_info').html(d);		
		fixForm();
		fixPage();
		setListOrder();
	})	
}
function saveListVals(){
	vals='';
	Textss='';	
	$('tr[ml]').each(function (){
		li_v=$(this).find('input[v]').val();
		li_t=$(this).find('input[t]').val();
		if(li_v!='' && li_t!=''){
			if(vals!=''){vals+='|';}
			vals+=li_v+':'+li_t;
			Textss+='<div>'+li_v+':'+li_t+'</div>';
		}
	})
	$('#list_t'+act_listNum).html(Textss);
	$('#list_'+act_listNum).val(vals);
	win('close','#m_info');
}
function delmodLi(id){$('#tr'+id).remove();}
function setListOrder(){
	$('.mlord tbody tr').each(function(index, element) {$(this).width(CSW-20);});
	$('.mlord tbody').sortable({
		axis: "y",
		cursor: "move",
		distance: 3,
		items: " > tr",
		placeholder:"orderPlace",
		revert: true,
		tolerance: "pointer"
	});	
}
function modLiAdd(){
	ran=parseInt(Math.random()*100000);
	row='<tr ml id="tr'+ran+'"><td></td><td><input type="text" v/></td><td><input type="text" t/></td>\
		<td><div class="i30 i30_del" onclick="delmodLi('+ran+')"></div></td></tr>';	
	$('.mlord').append(row);
	setListOrder();
}
/***********************************/
function photoSetting(id){
	act_PhotoNum=id;
	val=$('#photo_'+id).val();
	loadWindow('#m_info',1,k_settings,500,hhh);
	$.post(f_path+'M/mods_items_photo.php',{id:id,val:val}, function(data){
		d=GAD(data);
		$('#m_info').html(d);		
		fixForm();
		fixPage();		
	})	
}
function savePhotoVals(){
	vals='';
	Textss='';	
	ph_type=$('#ph_type').val();
    ph_ex=$('#ph_ex').val();
    ph_w=$('#ph_w').val();
    ph_h=$('#ph_h').val();
    vals=ph_type+'|'+ph_ex+'|'+ph_w+'|'+ph_h;
    ph_typeTxt=k_one_photo;
    if(ph_type==1){ph_typeTxt=k_many_photo;}
    Textss=ph_typeTxt+'|'+ph_ex+'|'+ph_w+'|'+ph_h;
	$('#photoSett_'+act_PhotoNum).html(Textss);
	$('#photo_'+act_PhotoNum).val(vals);
	win('close','#m_info');
}
/***********************************/
function parlist(id){
	act_ParNum=id;
	val=$('#parent_'+id).val();
	loadWindow('#m_info',1,k_edt_prp,500,hhh);
	$.post(f_path+'M/mods_items_parent.php',{id:id,val:val}, function(data){
		d=GAD(data);
		$('#m_info').html(d);		
		fixForm();
		fixPage();		
	})	
}
function saveParentVals(){
	vals='';
	t=$('#parent_table_'+act_ParNum).val();
	n=$('#par_val_'+act_ParNum).val();
	v=$('#par_txt_'+act_ParNum).val();
	v2=$('#par_txt2_'+act_ParNum).val();
	m=$('#par_mod_'+act_ParNum).val();	
	c=$('#par_con_'+act_ParNum).val();
	e=$('#par_evn_'+act_ParNum).val();
	if(t!=''){
		vals=t+'|'+n+'|'+v+'|'+v2+'|'+m+'|'+c+'|'+e;
		$('#parent_t'+act_ParNum).html(vals);
		$('#parent_'+act_ParNum).val(vals);
	}
	win('close','#m_info');
}
function ChangeMlang(id){
	loader_msg(1,k_loading);
	$.post(f_path+'M/lang_change.php',{id:id}, function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;loadModule()}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);
	})	
}
function modEvent(id){
	loadWindow('#m_info',1,k_events,600,0);	
	$.post(f_path+"M/mods_oprs_events.php",{id:id}, function(data){
		d=GAD(data);				
		$('#m_info').html(d);
		fixForm();
		setupForm('add_evnt_form','m_info');
	})
}
//----------------------------
function control_style(n){
	$('.gnr_but').hide();
	$('#info_data').html(loader_win);
	$.post(f_path+"M/css_generator.php",{n:n},function(data){
		d=GAD(data);			
		$('#info_data').html(d);
		$('.gnr_but').show();
		fixForm();
		fixPage();
	})
}
//--------------------------------------------------------
function exp_fix_choose_mod(){
	$('#modsList div').click(function(){		
		let code=$(this).attr('mod');
        let title=$(this).attr('mTitle');
        $(this).slideUp(200);
        $(this).attr('sel','1');
		addModEx(code,title);
	})
	$('#ser_prescr').keyup(function(){serModEx();})
    $('[expDo]').click(function(){
        if($('tr[mod]').length>0){
            sub('form_lib_exp');
            setTimeout(function(){
                $('#exModTab tr').each(function(){
                    mod=$(this).attr('mod');
                    exp_mod_del(mod);
                    $('[name=enc_code]').val('');
                })                
            },1000);
        }else{
            nav(3,k_ndef_val)
        }
    })
}
function serModEx(){
    str=$('#ser_prescr').val();
    if(str==''){
        $('#modsList div[sel=0]').show();
    }else{			
        $('#modsList div').each(function(){            
            txt=$(this).attr('mTitle');
            sel=$(this).attr('sel');
            n = txt.search(str);			
            if(n!=(-1) && sel==0){$(this).show(100);}else{$(this).hide(100);}
        })
    }	
	
}
function addModEx(code,title){
	view='<tr mod="'+code+'" >\
        <td txtS>'+title+'<input type="hidden" name="mods[]" value="'+code+'"/></td>\
        <td txtS><input type="checkbox" name="d_'+code+'" value="1"/></td>\
        <td >\
            <div class="fr ic30 icc1 ic30_info fl" title="'+k_details+'" onclick="exp_infoItemExport(\''+code+'\')" ></div>\
            <div class="fr ic30 icc2 ic30_del fl" title="'+k_delete+'" onclick="exp_mod_del(\''+code+'\')" ></div>\
        </td>\
    </tr>';
    $('#exModTab').append(view);
    loadFormElements('#form_lib_exp');
}
function exp_mod_del(mod){	
    $('tr[mod='+mod+']').remove();
	$('#modsList [mod='+mod+']').slideDown(200);
    $('#modsList [mod='+mod+']').attr('sel','0');  
}
function exp_infoItemExport(mod,cat_num){
	loadWindow('#m_info',1,k_module_info,500,0);
	$.post(f_path+"M/exp_export_info.php",{mod:mod},function(data){
 		d=GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();        
	});
}/*
function exp_file_action(sel,elem){
	
	$(sel).toggleClass('show hide');
	if($(sel).hasClass('show')){
		$(elem).css('transform','rotate(270deg)');
	}else{
		$(elem).css('transform','rotate(90deg)');
	}
	//$('#ex_file').removeClass('hide');
}*/
/*import*/
function exp_import_file_add(){
    loadWindow('#m_info',1,k_module_info,500,0);
    $.post(f_path+"M/exp_import_live.php",{state:'wind_add'},function(data){
        d=GAD(data);
        $('#m_info').html(d);
        fixForm();
        fixPage();
    });
}
function exp_content_exported_file(file=0){
	$('.ti_bak').hide();
	$('#result').hide();
	if(file==0){file=$('#exp_mwd').val();}
	win('close','#m_info');
	$('#content').html(loader_win);
	$.post(f_path+"M/exp_import_live.php",{state:'live',file:file},function(data){
		d=GAD(data);
		dd=d.split('^');
		$('.centerSideInHeader').html(dd[1]);
		$('#content').html(dd[0]);
		
		fixForm();
		fixPage();
		
		loadFormElements('#exp_form_mod_import');		
		setupForm('exp_form_mod_import','');

	});
}
function exp_infoItemImport(mod,cat_num,file){
	loadWindow('#m_info',1,k_module_info,500,0);
	$.post(f_path+"M/exp_import_live.php",{state:'wind_info',mod:mod,file:file},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
	});
}
function exp_prog_add(prog,file){
	co_loadForm(0,3,"mbzlqp8a0m||exp_content_exported_file('"+file+"')|code:"+prog+":h",'',k_prog_add);
}
function exp_mod_import_do_confirm(cat=0,mod=0){
	data=cat+'-'+mod;
	open_alert(data,'exp_1',k_confirm_mods_import,k_confirm_import);
}
function exp_mod_import_do(data){
	d=data.split('-');
	cat=d[0];
	mod=d[1];
	if(mod!=0){
		isSel=$('div[ch_val='+mod+'] input').val();
		if(!isSel){
			$('div[ch_val='+mod+']>div').attr('ch','on');
			$('div[ch_val='+mod+']>div').html('<input name="sel['+cat+'][]" type="hidden" value="'+mod+'">');
		}
		$('div[ch_name]>div[ch=on]').each(function(){
			ch_val=$(this).closest('div[ch_name]').attr('ch_val');

			if(ch_val!=mod){
				$(this).attr('ch','off');
				$(this).find('input').remove();

			}
		})
	}
	sub('exp_form_mod_import');
}
function exp_callBack_import(file,a){
	res=a.split(',');
	m=res[0].split('-');
	m_=res[1].split('-');
	t_data=res[2].split('-');
	f=res[3].split('-');
	$('td[m]').html(k_imprtd+' '+m[0]+' '+k_bmod+' '+k_out_of+' '+m[1]+' '+k_req_mods);
	$('td[m_]').html(k_imprtd+' '+m_[0]+' '+k_amod+' '+k_out_of+' '+m_[1]+' '+k_req_mods);
	$('td[m_f]').html(k_imprtd+' '+m_[2]+' '+k_add_mod_file+' '+k_out_of+' '+m_[3]+' '+k_files);
	$('td[t_data]').html( k_imprtd+' '+t_data[0]+' '+k_out_of+' '+t_data[1]+' '+k_req_tables);
	$('td[f]').html(k_imprtd+' '+f[0]+' '+k_out_of+' '+f[1]+' '+k_files);
	
	if(m[0]<m[1]){$('td[m]').closest('tr').addClass('cbg555');}
	if(m_[0]<m_[1]){$('td[m_]').closest('tr').addClass('cbg555');}
	if(m_[2]<m_[3]){$('td[m_f]').closest('tr').addClass('cbg555');}
	if(t_data[0]<t_data[1]){$('td[t_data]').closest('tr').addClass('cbg555');}
	if(f[0]<f[1]){$('td[f]').closest('tr').addClass('cbg555');}
	
	
	$('#result').show();
	delUFile(file);
	$('.ti_bak').hide();
	$('#content').html('');
	$('.centerSideInHeader').html(k_imprt_done);
}
/*********index*************/
function index_tableCols(){
	table=$("[name=cof_fxgwayb8wm]").val();
	column=$("[name=cof_53ymnmcchq]").val();
	loadWindow('#m_info4',1,k_index_cols,500,400);
	$.post(f_path+"M/index_table_cols.php",{table:table,column:column}, function(data){
		d=GAD(data);
		$('#m_info4').html(d);
		setListOrder();
		loadFormElements('#index_cols');
		fixForm();
		fixPage();
		$('.form_checkBox').click(function(){
			val=$(this).find('ch[on]');
			if(val){
				$(this).closest('tr').toggleClass('cbg44');
				$(this).closest('tr').removeClass('cbg555');
			}
		})
	});
	
}
function index_col_save(){	
	i=1; view=vals=''; err=0;
	$('#m_info4 div[ch=on]').each(function(){
		//الاظهار
		lenV='';
		tr=$(this).closest('tr');
		col_name=tr.find('td[col]').attr('col');
		isTxt=tr.find('#prefix_length').attr('text');
		prefix_len=parseInt(tr.find('#prefix_length').val());
		col_len=parseInt(tr.find('#prefix_length').attr('col_length'));
		if(!prefix_len){prefix_len='';}
		if(!col_len){col_len=0;}
		if(isTxt){
			if(prefix_len==''||!prefix_len){tr.addClass('cbg555');err=1;}
			else if(col_len && prefix_len!=0 && prefix_len!='' && col_len<prefix_len){tr.addClass('cbg555');err=1;}
		}
		if(!err){
			if(prefix_len&&prefix_len!=''){lenV=' ('+prefix_len+')';}
			view+='<div dir="ltr">'+i+':'+col_name+lenV+'</div>';
			i++;
			//التخزين
			if(vals!=''){vals+='|';}
			vals+=col_name+'-'+prefix_len;
		}
	})
	if(!err){
		$('[name=cof_53ymnmcchq]').val(vals);
		win('close','#m_info4');
		$('#index_cols').html(view);
	}else{
		navC(50,k_col_prefix_length_shld,'#f00');
	}
	
	
}
function index_delete(id){
	loadWindow('#m_info4',1,k_del_rec,600,0);
	$.post(f_path+"M/index_delete.php",{id:id,status:'view'}, function(data){
		d=GAD(data);
		$('#m_info4').html(d);
		loadFormElements('#indexDelForm');
		setupForm('indexDelForm','');
		fixForm();
		fixPage();
	});
}
function index_delete_result(res){
	temp=res.slice(0,3);
	if(temp=='err'){
		dd=res.split('err*');
		index_errors(dd[1]);
	}
	loadModule('mxk640owj');
}
function index_errors(err){
	loader_msg(0,'');
	temp=err.split('-!-');
	sql=temp[0]; 	err=temp[1];
	loadWindow('#m_info4',1,k_del_rec,600,0);
	out='<div class="win_body">\
		<div class="form_header so lh40 clr1 f1 fs18">\
			<div class="fs18 clr5 lh40 f1">'+k_err_in_query+':</div>\
		</div>\
		<div class="form_body so">\
			<div class="fs16 f1 lh30 clr1111">'+k_thquery+':</div>\
			<div class="fs12 lh30 fr cb" dir="ltr">'+sql+'</div>\
			<div class="fs16 f1 lh30 clr1111 cb">'+k_error+':</div>\
			<div class="fs12 lh30 fr cb" dir="ltr">'+err+'</div>\
	   </div>\
		<div class="form_fot fr">\
			<div class="bu bu_t2 fr" onclick="win(\'close\',\'#m_info4\');">'+k_close+'</div>\
		</div>\
		</div>';
	$('#m_info4').html(out);
	fixForm();
	fixPage();
}
function index_type_review(filed,val){
	if(val==2 ||val==3){ //fulltext 3 spatial 2
		//اخفاء تحديد النوع الفيزيائي
		$('div[name=cof_vge9mquh2a]').hide();
		$('div[name=cof_vge9mquh2a]').find('[ch=on]').attr('ch','off');
		$('input[name=cof_vge9mquh2a]').val('');
		//اخفاء خيار inplace
		$('div[name=cof_tzgu0h2fwv]').find('[ri_val=2]').hide();
		$('div[name=cof_tzgu0h2fwv]').find('[ch=on]').attr('ch','off');
		$('input[name=cof_tzgu0h2fwv]').val('');
	}else{
		$('div[name=cof_vge9mquh2a]').show();
		$('div[name=cof_tzgu0h2fwv]').find('[ri_val=2]').show();
	}
	
}
function fix_view_index(status,field,id=0){
	if(status==1){
		$("[name="+field+"]").attr("onchange","$('#sel_cols').show()");
	}else if(status==3){
		$("[onclick='co_del_rec("+id+")']").attr('onclick','index_delete('+id+')'); $('.ic40_edit').remove();
	}
		
	if(status==1 || status==2){
		$("[name="+field+"]").closest("tr").find("td:first").append("<span>*</span>");
	}
	
}
/***repair && optimize*****/
function repair_view_fix(){
	$('div[t]').click(function(){
		$('div[t]').removeClass();
		$('div[t]').addClass("cbg4 fl clr11 f1 mg10 pd10 Over lh40");
		$(this).removeClass();
		$(this).addClass("cbg11 fl clrw f1 mg10 pd10 lh40");
		status=$(this).attr('id');
		$('#result').html(loader_win);
		$.post(f_path+"M/repair_optimize_tables.php",{status:status},function(data){
			d=GAD(data);
			$('#result').html(d);
			fixForm();
			fixPage();
		})
	});
}
/*****lang process (join-sync-export-import)******/
function lang_process_view_fix(){
	$('[langSncOpr] div[a]').click(function(){			
		a=$(this).attr('a');
		if(a=='k_exp'){langKeysExport();}
		else if(a=='k_imp'){langKeysImportView();}
		else if(a=='startSenc'){langKeysSencDo(1);}        
		else if(a=='startSenc2'){langKeysSencDo(2);}
        else if(a=='startSenc3'){langKeysSencDo(3);}
	});
}
function langKeysSencDo(t){
    $('[langSncOpr] div[a]').hide();
    $('.langLoader').show();
	$('#k_import').hide();
    $('#snc2Bloc').show();
    $('#snc2BlocIn').html(loader_win);
    $('.loadeText').html(k_sync);
    $.post(f_path+"M/lang_keys_files_senc_do.php",{t:t}, function(data){
        $('#snc2Bloc').hide();
        $('#done_senc').show();
        $('[langSncOpr] div[a]').show();
        $('.langLoader').hide();
        d=GAD(data);
        dd=d.split('^');
        /*var table='<tr><th>'+k_lang+' </th> <th>'+ k_file_name +'</th><tr>';
        var files=dd[1].split(',');
        var langs=dd[3].split(',');
        for(i=0;i<dd[0];i++){
            table+='<tr> <td>'+langs[i]+'</td> <td>'+files[i]+'</td> </tr>';
        }*/
        $('#startSenc').hide();
        $('#num1').html(dd[0]+' '+k_file2);
        $('#num2').html(dd[1]+' '+k_key2);
        $('#table').html(dd[2]);
        //$('.centerSideIn').html(d);
    })
	
}
function langKeysImportView(){
	$('#k_import').show();
	$('#snc2Bloc').hide();
	$('#done_senc').hide();
	//-------
	file=$('#ex').length;
	if(file){file=$('#ex').val();}else{file=0;}
	$('#k_import').html(loader_win);
	$.post(f_path+"M/lang_keys_import.php",{file:file,status:'view'}, function(data){
		d=GAD(data);
		$('#k_import').html(d);
		fixForm();
		fixPage();
	});
}
function langKeysImport(file){
	$('#k_import').html(loader_win);
	$.post(f_path+"M/lang_keys_import.php",{file:file,status:'process'}, function(data){
		d=GAD(data);
		$('#k_import').html(d);
		fixForm();
		fixPage();
	});
}
function langKeysExport(){
	l=f_path+'M/lang_keys_export.php';
	loc(l);
	loader_msg(0,'');
}
/***********************************************************/
var actColLM='';
function addModTojoin(){
	co_selLongValFree('39g24312dm',"addModTojoinCol(1,\'[code]\')||code||",0);
}
function addModTojoinCol(opr,id){
	actColLM=id;
	$('#j_info,#j_ser').html(loader_win);
	$.post(f_path+"M/join_lang_fields_info.php",{opr:opr,id:id},function(data){
		d=GAD(data);
		dd=d.split('^');
		$('#j_info').html(dd[0]);
		$('#j_ser').html(dd[1]);
		$('#j_title').html(k_thdata);
		$('#j_data').html('');
		if(opr==2){
			getlMData();
			setFilterLM(0);
		}
		fixForm();
		fixPage();
	})
}
function getlMData(){
	filter=getFormFilterML();
	mlf=$('#fil_lgm').val();
	$('#j_data').html(loader_win);
	$.post(f_path+"M/join_lang_fields_info.php",{opr:3,id:actColLM,fil:filter,mlf:mlf},function(data){
		d=GAD(data);
		dd=d.split('^');
		$('#j_title').html(dd[0]);
		$('#j_data').html(dd[1]);				
		fixForm();
		fixPage();
	})
}
function langMrgOpr(t){	
	if(t==1){mlTitle=k_wld_add_intrmd;}
	if(t==2){mlTitle=k_wld_del_intrmd;}	
	open_alert(t,'s10',mlTitle,k_merge_field);
}
function langMrgOprDo(opr){	
	//actLangMl=opr;
	$('#j_info,#j_data,#j_ser').html(loader_win);
	$.post(f_path+"M/join_lang_fields_opr.php",{opr:opr,id:actColLM},function(data){
		d=GAD(data);		
		addModTojoinCol(2,actColLM);		
		fixForm();
		fixPage();
	})
}
var actLangMl='';
function langMrgTot(t,l=''){
	actLangMl=l;
	if(t==1){mlTitle=k_one_lang_merge+' ( '+l+' )';}
	if(t==2){mlTitle=k_empty_fields_mrge;}
	if(t==3){mlTitle=k_equal_fields_merge;}
	if(t==4){mlTitle=k_lrgr_fields_merge;}
	if(t==5){mlTitle=k_merge_data_alert;}
	open_alert(t,'s9',mlTitle,k_data_merge);
}
function langMrgTotDo(opr){
	filter=getFormFilterML();
	mlf=$('#fil_lgm').val();
	loader_msg(1,k_loading)
	$.post(f_path+"M/join_lang_fields_mrg.php",{opr:opr,id:actColLM,fil:filter,mlf:mlf,lg:actLangMl},function(data){
		d=GAD(data);		
		if(d==1){
			msg=k_done_successfully;mt=1;
			if(opr==5){addModTojoinCol(1,actColLM);}else{getlMData();}
		}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);
	})
}
function lgMrgRec(id,lg){
	$('#td_'+id).html(loader_win);	
	$.post(f_path+"M/join_lang_fields_opr.php",{opr:3,id:actColLM,rec:id,lg:lg},function(data){
		d=GAD(data);
		if(d==1){
			out='<span class="clr6">'+$('#td_'+lg+'_'+id).html()+'</span>';
			if($('#fil_lgm').val()=='0'){
				$('#tr_'+id).remove();
				mltot=parseInt($('#mlTot').html());				
				$('#mlTot').html(mltot-1);
			}
		}else{
			out='<ff class="clr5">Err</ff>';
		}
		$('#td_'+id).html(out);
		fixForm();
		fixPage();
	})
}
/*********************************/
function setFilterLM(id){
	if(id==0){
		$('.filterFormLM input[type=text]').keyup(function(){loadFilterLM();});
		$('.filterFormLM input[type=number]').keyup(function(){loadFilterLM();});
		$('.filterFormLM input[type=text][class=fil_Date]').change(function(){loadFilterLM();});
		$('.filterFormLM select').change(function(){
			filPar=$(this).parent().attr('filPar');
			if(typeof filPar != typeof undefined && filPar != false){
				filValSe=$(this).val();
				checkFilterSuns(filPar,filValSe);
			}else{
				loadFilterLM();
			}
		});
		$('.filBut').click(function (){
			fil_link=$(this).attr('link');
			fil_val=$(this).attr('val');
			last_val=$('#'+fil_link).val();

			$('.filBut[link='+fil_link+']').each(function(index, element){
				$(this).css('background-color','');
				$(this).css('color','');            
			});  

			if(fil_val==last_val){
				$('#'+fil_link).val('');
			}else{			
				$('#'+fil_link).val(fil_val);
				$(this).css('background-color',clr1111);
				$(this).css('color','#fff');
			}
			loadFilterLM();
		})
		date_picker_fil();
	}else{		
		$('#filSun_'+id+' select').change(function(){
			filPar=$(this).parent().attr('filPar');			
			if(typeof filPar != typeof undefined && filPar != false){
				filValSe=$(this).val();
				checkFilterSunsLM(filPar,filValSe);				
			}else{				
				loadFilterLM();
			}
		});
		haveSun=0;
		filPar=$('#filSun_'+id).attr('filPar');
		if(typeof filPar != typeof undefined && filPar != false){
			filValSe=$('#filSun_'+id).val();
			checkFilterSuns(filPar,filValSe);
			haveSun=1;
		}
		return haveSun;		
	}
}
function checkFilterSunsLM(sun,val){
	$('#filSun_'+sun).html(loader_win);
	$.post(f_path+"X/_co_list_filter.php",{id:sun,val:val},function(data){
		d=GAD(data);		
		$('#filSun_'+sun).html(d);
		if(setFilter(sun)==0){
			loadFilterLM();
		}
	})
}
function loadFilterLM(){	
	clearTimeout(filtimer);
	filtimer=setTimeout(function(){getlMData();},800);
}
function getFormFilterML(){
	if(fil_pars!=''){
		data='';
		fileds=fil_pars.split('|');
		for(i=0;i<fileds.length;i++){
			if(fileds[i]!=''){
				el=fileds[i].split(':');				
				if(el[1]==2){
					if(el[2]==1){
						val=$('#fil_'+el[0]).val();
						if(val!=''){data+=el[0]+':'+val+':|';}
					}else{
						val1=$('input[name=fil_'+el[0]+'_1]').val();						
						val2=$('input[name=fil_'+el[0]+'_2]').val();
						if(val1!='' || val2!='' ){data+=el[0]+':'+val1+':'+val2+'|';}
					}			
				}else{
					val=$('#fil_'+el[0]).val();
					if(val!=''){data+=el[0]+':'+val+':|';}
				}
			}
		}
		return data;
	}
}
/*********************************/
/***reset library***/
function reset_fix(){
	$('div[t]').click(function(){
		type=$(this).attr('t');
		$('div[t]').css('background-color','');
		$(this).css('background-color','#0d6a8c;');
		reset_get_view(type);
	})
}
function reset_get_view(type){
	$.post(f_path+"M/reset_process.php",{type:type},function(data){
		d=GAD(data);
		$('#details').html(d);
		reset_fix_progs();
		reset_fix_files();
		loadFormElements('#indexDelForm');
		setupForm('indexDelForm','');
		fixForm();
		fixPage();
		loadFormElements('#reset_mod');
		setupForm('reset_mod','');
	});
}
function reset_fix_progs(){
	$('#progs>div').click(function(){
		prog=$(this).attr('prog');
		isAll=parseInt($(this).attr('all'));
		$('#progs>div[all=0]').removeClass('cbg66').addClass('cbg6');
		if(isAll){
			reset_do('prog');
			$('#details_progs').html('');
			$('#noti').html('');
		}
		else{
			$(this).removeClass('cbg6').addClass('cbg66');
			$.post(f_path+"M/reset_process.php",{type:'progs_mod',prog:prog},function(data){
				d=GAD(data);
				dd=d.split('^');
				$('#noti').html(dd[0]);
				$('#details_progs').html(dd[1]);
				$('input[name=prog]').val(prog);

				fixForm();
				fixPage();
				loadFormElements('#reset_mod');
				setupForm('reset_mod','');

			});
		}
	})
}
function reset_fix_files(){
	$('#files>div').click(function(){
		opr=$(this).attr('opr');
		$('#reset_mod').append('<input type="hidden" name="opr" value="'+opr+'">');
		reset_do('opr');
	})
}
function reset_do(type){
	t1=''; t2=k_lib_initial;
	if(type=='opr'){
        t1=k_continueq;
    }else{
        t1=k_cofirm_lib_del;
    }
    open_alert(0,'reset_lib',t1,t2);
}
/************************/
var actHlpType=0;
function addModHelp(){	
	loadWindow('#m_info',1,k_add_help_item,400,0);
	$.post(f_path+"M/help_add.php",{}, function(data){
		d=GAD(data);	
		$('#m_info').html(d);		
		fixForm();
		fixPage();
	})
}
function hlpSelMod(t){
	win('close','#m_info');
	actHlpType=t;
	if(t==0){
		saveHlpRec('');
	}else if(t==1){		
		co_selLongValFree('dpqj53ynuz',"saveHlpRec(\'[id]\')|||",0);
	}else{
		co_selLongValFree('d127wbsiq',"saveHlpRec(\'[id]\')|||",0);
	}
}
function saveHlpRec(mod){	
	loader_msg(1,k_loading);
	$.post(f_path+"M/help_save.php",{t:actHlpType,mod:mod}, function(data){
		d=GAD(data);
		if(d){
			msg=k_done_successfully;
			mt=1;
			loadModule('ldb0roebqs');
			co_loadForm(d,1,0)
		}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);	
	})
}
function hlpListVids(code){
	loadWindow('#m_info',1,k_videos,800,0);
	$.post(f_path+"M/help_vedios.php",{code:code}, function(data){
		d=GAD(data);	
		$('#m_info').html(d);
		setOrder();
		fixForm();
		fixPage();
	})
}
function addHVid(code,id=0){
	co_loadForm(id,3,"506ghqvzdv||hlpListVids('"+code+"')|h_code:"+code+":hh");
}
function delHV(code,id){
	co_del_rec_cb('506ghqvzdv',id,'hlpListVids(\''+code+'\')')
}
function hlpListTxt(code){
	loadWindow('#m_info',1,k_texts,800,0);
	$.post(f_path+"M/help_text.php",{code:code}, function(data){
		d=GAD(data);	
		$('#m_info').html(d);
		setOrder();
		fixForm();
		fixPage();
	})
}
function addHTxt(code,id=0){
	co_loadForm(id,3,"6fvt9xsdyc||hlpListTxt('"+code+"')|h_code:"+code+":hh");
}
function delHTxt(code,id){
	co_del_rec_cb('6fvt9xsdyc',id,'hlpListTxt(\''+code+'\')')
}
function dirLog(id){
	$.post(f_path+"M/direct_entry.php",{id:id}, function(data){
		d=GAD(data);	
		loc(f_path);
	})
}
function modSenc(type=1,mod=''){
	$('#recStatus').html(loader_win);
	$.post(f_path+"M/mods_conv_to_files.php",{type:type,mod:mod}, function(data){
		d=GAD(data);
		$('#recStatus').html(d);
		fixForm();
		fixPage();
	})
}
function viewPhMa(t){
    $('#pmCont').html(loader_win);
    r=$('input[r]').val();
    p=$('input[p]').val();
    d=$('input[d]').val();
	$.post(f_path+"M/files_cleaning.php",{t:t,r:r,p:p,d:d}, function(data){
		d=GAD(data);	
		$('#pmCont').html(d);		
		fixForm();
		fixPage();
	})
}
function fixPhData(){
    s=$('input[s]').val();    
    f=$('input[f]').val();
    t=$('input[t]').val();
	$.post(f_path+"M/files_cleaning_fix.php",{s:s,f:f,t:t}, function(data){
		d=GAD(data);	
		$('#dd').html(d);		
		fixForm();
		fixPage();
	})
}
/******************API**********************/
function apiInputsWin(id){
	actApi=id;
	loadWindow('#full_win1',1,k_inputs,www,hhh);
	$.post(f_path+'M/api_item_in.php',{id:id}, function(data){
		d=GAD(data);
		$('#full_win1').html(d);		
		fixPage();
		fixForm();
		setOrder();				
	})	
}
function apiOutputsWin(id){
	actApi=id;
	loadWindow('#full_win1',1,k_outputs,www,hhh);
	$.post(f_path+'M/api_item_out.php',{id:id}, function(data){
		d=GAD(data);
		$('#full_win1').html(d);	
		fixPage();
		fixForm();
		setOrder();				
	})	
}
function apiOutputItem(mod,id){
	co_loadForm(id,3,"63vjfvhyd|id|apiOutputsWin([id]);apiOutputsWin("+mod+");|mod_id:"+mod+":hh");
}
function apiInputItem(mod,id){
	co_loadForm(id,3,"udvs23g96t|id|apiOutputsWin([id]);apiInputsWin("+mod+");|mod_id:"+mod+":hh");
}
function setApiSelType(a_filid){
	$('#cof_a1lxdx94xf , #cof_mq5ezqa9yc').change(function (){
		at=$(this).val();	
		changeColTypeA(at,a_filid);
	})
}
var txtT='';
function changeColTypeA(type,a_filid){
	out_d='';
	$('#apiSubtype').html('');
	if(type==1){
		out_d+='<select name="'+a_filid+'" t><option value="1" selected>نص</option><option value="2">رقم</option></select>';
		$('#apiSubtype').html(out_d);		
	}	
	if(type==2){		
		out_d+='<select name="'+a_filid+'" t><option value="1" selected>'+k_norm_date+'</option><option value="2">'+k_date_sec+'</option></select>';
		$('#apiSubtype').html(out_d);
	}
	if(type==3){
		out_d='<input type="hidden" name="'+a_filid+'" value=""/>';
		$('#apiSubtype').html(out_d);
	}
	if(type==4){
		out_d='<input type="text" name="'+a_filid+'"/>';
		$('#apiSubtype').html(out_d);
	}
	if(type==5){
		out_d='<input type="hidden" name="'+a_filid+'" id="parent" value=""/>\
		<div class="f1 clr5 Over TC" onclick="parlist_a()">'+k_edt_prp+'</div><div class="TC" id="parent_t" dir="ltr"></div>';
		$('#apiSubtype').html(out_d);
	}
	if(type==6){
		out_d+='<input type="hidden" name="'+a_filid+'" id="list"/>\
		<div class="f1 clr5 Over TC" onclick="addTolist_a()">'+k_edt_mnu+'</div>\
		<div class="TC" id="list_t"></div>';
		$('#apiSubtype').html(out_d);
	}	
	if(type==7){
		out_d+='<input type="text" name="'+a_filid+'"/>';
		$('#apiSubtype').html(out_d);
	}
    if(type==8){
		out_d+=subApiLoad(a_filid);
	}
}
function subApiLoad(f){	
	$('#apiSubtype').html(loader_win);
	$.post(f_path+'M/api_subApiLoad.php',{f:f}, function(data){
		d=GAD(data);		
        $('#apiSubtype').html(d);
	})	
}
function parlist_a(){	
	val=$('#parent').val();
	loadWindow('#m_info',1,k_edt_prp,500,hhh);
	$.post(f_path+'M/api_modParent.php',{val:val}, function(data){
		d=GAD(data);
		$('#m_info').html(d);	
		fixForm();
		fixPage();		
	})	
}
function saveParentVals_a(){
	vals='';
	t=$('#parent_table').val();
	n=$('#par_val').val();
	v=$('#par_txt').val();	
	c=$('#par_con').val();	
	if(t!=''){
		vals=t+'|'+n+'|'+v+'|'+c;
		$('#parent_t').html(vals);
		$('#parent').val(vals);
	}
	win('close','#m_info');
}
function addTolist_a(){	
	val=$('#list').val();
	loadWindow('#m_info',1,k_lst_itm,600,hhh);
	$.post(f_path+'M/api_modIList.php',{val:val}, function(data){
		d=GAD(data);
		$('#m_info').html(d);		
		fixForm();
		fixPage();
		setListOrder();
	})	
}
function saveListVals_a(){
	vals='';
	Textss='';	
	$('tr[ml]').each(function (){
		li_v=$(this).find('input[v]').val();
		li_t=$(this).find('input[t]').val();
		if(li_v!='' && li_t!=''){
			if(vals!=''){vals+='|';}
			
			vals+=li_v+':'+li_t;
			Textss+='<div>'+li_v+':'+li_t+'</div>';
		}
	})
	$('#list_t').html(Textss);
	$('#list').val(vals);
	win('close','#m_info');
}
/**************Fix Data***********************/
var fixActMod='';
var fixActCol='';
$(document).ready(function(){
    $('.centerSideFullIn').on('click','[mc]',function(){
        fixActMod=$(this).attr('mc')
        fix_selMom();
    })
    $('.centerSideFullIn').on('click','[fc]',function(){
        $('#fixSer').val('');
        fixActCol=$(this).attr('fc')
        fix_selFild();
    })
    $('.centerSideFullIn').on('click','#tData tr',function(){
        no=$(this).attr('no');
		clickTr(no);
    })
    $('#fixSer').keyup(function(){if(fixActMod && fixActCol){SerF();}})
    $('[fixButt]').click(function(){fixNow();})
    $('[serMod]').keyup(function(){serMou();})
    customEvents();
})
function serMou(){
    str=$('[serMod]').val();
	str=str.toLowerCase();
	$('[Ctxt]').each(function(index, element){
		txt=$(this).attr('Ctxt').toLowerCase();
		ct=$(this).attr('t');
		n = txt.search(str);
		if(n!=(-1)){$(this).show(300);}else{$(this).hide(300);}
	})
}
function SerF(col){clearTimeout(v_fix);v_fix=setTimeout(function(){fix_selFild();},800);}
function fix_selMom(){    
    fixActCol='';
    $('#cols').html(loader_win);
    $('#fix_data').html('');
    $.post(f_path+"M/fix_data.php",{opr:1,code:fixActMod},function(data){
		d=GAD(data);
        $('#cols').html(d);
        fixForm();
		fixPage();		
	}) 
}
function fix_selFild(){
    s=$('#fixSer').val();
    $('#fix_data').html(loader_win);
    $.post(f_path+"M/fix_data.php",{opr:2,code:fixActCol,s:s},function(data){
		d=GAD(data);
        $('#fix_data').html(d);
        fixForm();
		fixPage();		
	}) 
}
function setTData(){
	$('#tData tr').click(function(){				
		no=$(this).attr('no');
		clickTr(no);
	})
}
function clickTr(no){
	if(stopCheck==0){
		tr=$('#tData tr[no='+no+']');
		ch=tr.attr('ch');
		if(ch=='off'){
			tr.css('background-color','#efe');
			tr.find('.chMain').html('<div onclick="stopCheck=1">\
			<input type="radio" name="main" val="'+no+'" checked required/></div>');
			tr.attr('ch','on');
		}else{
			tr.css('background-color','');
			tr.find('.chMain').html('');
			tr.attr('ch','off');
		}
	}else{
		stopCheck=0;
	}
}
function fixNow(){
	var min_id='';
	var fix_id='';
	$('#tData tr[ch=on]').each(function(index,element){
		no=$(this).attr('no');
		ch=$('input[name=main][val='+no+']').is(':checked');
		if(ch==true){
			min_id=no;
		}else{
			if(fix_id!=''){fix_id+=',';}
			fix_id+=no;
		}
	});
	if(fix_id==''){nav(3,k_sl_tw_vl_fx);}
	if(min_id==''){nav(3,k_bs_vl_detrmn);}
	if(fix_id!='' && min_id!=''){
		$('#data').html(loader_win);
		$.post(f_path+'M/fix_data.php',{id:fixActCol,min_id:min_id,fix_id:fix_id},function(data){
			d=GAD(data);
			nav(5,d);
            fix_selFild();
		})
	}
}
/***********************************************/
function modBackup(type=1){
    $('#bkView').html(loader_win);
	$.post(f_path+"M/mods_backup.php",{type:type}, function(data){
		d=GAD(data);
		$('#bkView').html(d);
	})
}
function loadModBackup(file,type){
    $('#mwb').append(loader_win);
    $('#mwb [file]').hide();
	$.post(f_path+"M/mods_backup_re.php",{file:file,type:type}, function(data){
		d=GAD(data);
        $('#mwb .loadeText').remove();
        if(d==1){        
            $('[file="'+file+'"]').remove();
            $('[file]').show();
            nav(3,'تمت العملية بنجاح');
        }
	})
}
/***************/
function customEvents(){    
    $('body').on('click','[ri_name=cof_obdqayyi7a]',function(){
        loadNotiTypeslist($('#ri_cof_obdqayyi7a').val());        
    })
}
function loadNotiTypeslist(type){
    $('#noti_val').html(loader_win);
    f=$('#noti_val').attr('f');
	$.post(f_path+"M/notis_typeslist.php",{type:type,f:f}, function(data){
		d=GAD(data);
		$('#noti_val').html(d);
	})
}
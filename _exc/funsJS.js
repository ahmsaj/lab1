function printData_checkErr(level,id,end=0){
	if(level==1){
		file=$('#ex').val();
		if(file){
			$.post(f_path+"X/exc_check_type_file.php",{file:file},function(data){
			d=GAD(data);
				if(d=='1'){
					navC(50,k_shld_be_csv,'#f00');
					$('#ex').val('');
					$('.file_box').remove();
				}else{
					saveForm(level);
				}
			})
		}
	}else{
		if(!checkError(level,end)){//التحقق من الاغلاط قبل الانتقال للمرحلة التالية
				saveForm(level);
		}
	}
}
function refreshImportExcelPage(){
	link=window.location.href;
	link_attr=link.split('/');
	last_attr=link_attr[link_attr.length-1];
	temp_process=last_attr.split('-');
	process=template=0;
	if(temp_process.length==2){
		process=temp_process[0];
		template=temp_process[1];
	}else{
		process=last_attr;
	}
	level=$('div[level]').attr('level');
	printData(level,process,template);
}
importStop=0;
var reject=0;
function getimportStartView(id_process,newImport=0){
	importStop=1;
	setTimeout(function(id_process){loader_msg(0,'');},10);
	reject=0;
	start_row=$('input[name=start_row]').val();
	end_row=$('input[name=end_row]').val();
	loadWindow('#m_info',1,k_import_do,600,600);
	$.post(f_path+"X/exc_import_do.php",{id:id_process,start_row:start_row,end_row:end_row,state:'view',newImport:newImport},function(data){
 		d=GAD(data);
		$('#m_info').html(d);
		setImportDoView(id_process);
 		fixForm();
		fixPage(); 
	})	
}

function importStart(id_process,offset=0,ss=0){
	importStop=0;
	start_row=$('input[name=start_row]').val();
	end_row=$('input[name=end_row]').val();
	$.post(f_path+"X/exc_import_do.php",{id:id_process,start_row:start_row,end_row:end_row,state:'process',offset:offset,first_opr:ss},function(data){
 		d=GAD(data);
		dd=d.split('^');
		$('#snc2Bloc').show();
		$('#ssb').show();
		$('#finishInfo').show();
		$('div[exc_progress]').width(dd[2]+'%');
		$('#counter_exc').html(dd[1]);
		reject+=parseInt(dd[4]);
		if(reject>0){
			rejectTxt=dd[0];
			$('div[reject_table]').removeClass('hide');
			$('#tableContent').append(rejectTxt);
		}
		totReq=dd[5];
		count_rows=dd[6];
		$('ff[tot]').html(totReq);
		$('ff[reject]').html(reject);
		offset=parseInt(dd[7]);
		waitTime=dd[8];
		txt1=txt2=func='';
		if(dd[3]=='not_complete' && importStop==0){
			setTimeout(function(){importStart(id_process,offset);},100);
		}else{
			if(dd[3]=='complete'){
				importStop=1;
				$('#ssb').remove();
				$('div[imp_close]').show();
				$( "#m_info" ).dialog({ closeOnEscape: true }); fixPage();
				loadWindow('#m_info2',1,k_imprt_done,350,200);
				$.post(f_path+"X/exc_import_finish.php",{tot:totReq,reject:reject,count_rows:count_rows},function(data){
					d=GAD(data);
					$('#m_info2').html(d);
					$('div[aria-describedby=m_info2] .ui-dialog-titlebar').prepend(
						'<div class="winButts2">\
							<div class="wB_x fr" onclick="win(\'close\',\'#m_info2\');fixForm(); fixPage();">\
							</div>\
						</div>');
					fixForm();
					fixPage();
				});
				reject=0; rejectTxt='';
			}
			view=txt1+'<span onclick="'+func+'" class="f1 fs16 clr1 Over"> '+txt2+'</span>';
		}
		$('#expected_time').html(waitTime);
		fixForm();
		fixPage();	
	})
	fixForm();
	fixPage();	
}
function select_current_class(){
	current_class='';
	len_class=$('.ic40_pus').length;
	if(len_class>0){
		current_class='ic40_pus'; 
	}
	else{
		len_class=$('.ic40_play').length;
		if(len_class>0){
			current_class='ic40_play';
		}
		else{
			len_class=$('.ic40_stop').length;
			if(len_class>0){
			current_class='ic40_stop';
		}
		}
	}
	return current_class;
}
function setImportDoView(id_process){	
  $("#ssb").click(function(){
	if(importStop==0){
		$(this).attr('class','fr ic40x icc3 ic40_pus');
		importStop=1;
		$('.form_fot div[imp_close]').show();
		$( "#m_info" ).dialog({ closeOnEscape: true }); fixPage();
	}
	else if(importStop==1){
		$(this).attr('class','fr ic40x icc4 ic40_play');
		completeImport(id_process);
		$('.form_fot div[imp_close]').hide();
		$( "#m_info" ).dialog({ closeOnEscape: false }); fixPage();
		
	}
  });
  
  $("#ssb").mouseover(function(){
	  if(importStop==0){
		$(this).attr('class','fr ic40x icc4 ic40_stop');
		}
		else if(importStop==1){
			$(this).attr('class','fr ic40x icc3 ic40_play');
		}
   });
   
  $("#ssb").mouseout(function(){
	  if(importStop==0){
		$(this).attr('class','fr ic40 icc4 ic40_play');
		}
		else if(importStop==1){
			$(this).attr('class','fr ic40 icc3 ic40_pus');
		}
    });
}
function closeImportDo(id_process){
	importStop=1;
	win('close','#m_info');
}
function completeImport(id_process){
	importStart(id_process,0,1);
	importStop=0;
}
function stopImport(){
	importStop=1;
	$('#ssb').hide();
}
function printData(level,id,template=0){
	if(level==1){$('.centerSideIn').css('overflow-x','hidden');}
	if(level==2 && id!=0){
		view=k_chs_imprt_fields+'\
			<div class="ic40 icc4 ic40_down2 fr" title="'+k_template_download+'" onclick="templateDown('+id+')"></div>';
		$('.centerSideInHeader').html(view);
		$('#mm').html(loader_win);
	}
	if(level==3){
		$('.centerSideInHeader').hide();
		$('.centerSideIn').hide();
		$('.centerSideInFull').show();
	}
	$.post(f_path+"X/exc_tables_live.php",{level:level,id:id,template:template},function(data){
 		d=GAD(data);
		if(level==1){$('#mm').html(d);}
		else{
			dd=d.split('^');
			if(level==2){
				$('#mm').html(dd[0]);
				cId=dd[1];
				cols=dd[2];
				fixImportInfoLive(cId,cols);
			}
			else if(level==3){
				$('#dataSett').html(dd[0]);
				$('#dataLink').html(dd[1]);
				fixEmptyFieldView();
				fixLinkTable();		
			}
		}
		fixForm();
		fixPage();	
	})
}
function backToLevel_2(id){
	$.post(f_path+"X/exc_tables_live.php",{id:id,state:'back'},function(data){
 		d=GAD(data);
		if(d>0){loc(window.location.href);}
	})
}
function checkError(level,countRows=0,type=''){
	var err=0 ,txt=0;
	if(level==1){
		
	}else
	if(level==2){
		colsCount=$("input[name=colsCount]").val();
			var isFieldSel=0;
			for(i=1;i<=colsCount;i++){
				sel=$("input[name=selCol_"+i+"]").val();
				if(sel){
					if(isFieldSel==0){isFieldSel=1;}
				}
			}
			if(isFieldSel==0){err=1; txt+="\n"+k_err_sel_one_col;}
		if(err){navC(50,txt,'red')}
	}else
	if(level==3){
		/*--test from to field--*/
		if(type=='from_to'||type==''){
			txt=0;
			start_row=parseInt($("input[name=start_row]").val());
			end_row=parseInt($("input[name=end_row]").val());
			$("input[name=start_row]").css("border-color","#ccc");
			$("input[name=end_row]").css("border-color","#ccc");
			if(start_row >end_row){$("input[name=start_row]").css("border-color","red");}
			if(end_row >countRows){$("input[name=end_row]").css("border-color","red");}
			$("#error[f_t]").html('');
			if(end_row >countRows){
				err=1;
				txt=k_err_end_line_grtr_file_rows;
			}else if( start_row >end_row ){
				err=1;
				txt=k_start_line_grtr_end_line;
			}
			
			if(err){
				$("#error[f_t]").html(txt);
			}
		/*--test module field--*/
		}
		/*--test module choice--*/
		if(type=='module'||type==''){
			$('select[name=selModule]').css("border-color","#ccc");
			$("#error[m]").html('');
			var selModue=$('select[name=selModule]').val();
			if(selModue==0){
				$('select[name=selModule]').css("border-color","red");
				txt=k_linked_module_specify;
				err=1; 
				if(type==''){
					nav(50,txt);
				}
			}
			/*-----------------*/
			if(!err){
				err=1;
				$('#dataLink tr[id]').each(function(){
					col=$(this).attr('id');
					is_found_col_field=$('select[name=selFileCols_'+col+']');
					if(is_found_col_field){
						err=0;
						return 0;
					}
				})
				if(err==1){
					nav(50,k_sel_file_field_associated_item);
				}
			}
			
		}
		/*--test date item repeated--*/
		$('select[date]').closest('tr').each(function(){
			$(this).css('background-color','white');
			date=[];
			date1=$(this).find('select[txt=date_1]').val();
			date2=$(this).find('select[txt=date_2]').val();
			date3=$(this).find('select[txt=date_3]').val();
			if(date1==date2 || date2==date3 || date1==date3){
				err=1;
				$(this).css('background-color','pink');
				nav(50,k_invalid_date_duplicated);
				$(this).find('select[date]').change(function(){
					$(this).closest('tr').css('background-color','white');
				})
			}
		});
		
	}
return err;
	
	
}
function setAllCheckbox(selCount,elem){
	setCheckbox('selAllCol');
	ch=$(elem).children('div[ch]').attr('ch');
	for(i=1;i<=selCount;i++){
		$('div[ch_name=selCol_'+i+']>div').attr('ch','off');
		if(ch=='off'){
			$('div[ch_name=selCol_'+i+']>div>input').remove();
		}else if(ch=='on'){
			setCheckbox('selCol_'+i);
		}
	}
}
function setCheckbox(id){
	var r=CBV(id);
	if(r=='1'){
		CBC(id,0);
	}
	if(r=='0'){
		CBC(id,1);
	}	

}
function fixImportInfoLive(cId,cols){
	$('#importInfo .form_checkBox').each(function(){
		ch_name=$(this).attr('ch_name');
		if(ch_name!='selAllCol'){setCheckbox(ch_name);}
	})
	$(".ti_save" ).show();
	setUpHeader(cId,cols);
	setUpForm('importInfo','importInfo');
}
function setUpForm(formID,formName){
	loadFormElements('#'+formID);		
	setupForm(formName,'');
	fixForm();
	fixPage();
}
function setUpHeader(cId,cols){
	$("div[f="+cId+"]").click(function(){
		row=$(this).attr('r');
		for(i=1;i<=cols;i++){
			$("input[name=header_line]").val(row);
			val=$("tr[row="+row+"] > td[col="+i+"]").html();
			$("input[name=col_"+i+"]").val(val);		
		}
	})
	
	row=$("div[f="+cId+"][v=1]").attr('r');
	for(i=1;i<=cols;i++){
		$("input[name=header_line]").val(row);
		val=$("tr[row="+row+"] > td[col="+i+"]").html();
		$("input[name=col_"+i+"]").val(val);	
	}
}
function addNewRow(){
	view='<tr rank="not_field">\
			<td><div class="mover"></div></td>\
			<td colspan="4" class="pd10"><input not_field type="text" placeholder="'+k_enter_txt+'" /></td>\
			<td><div class="fr ic40 icc2 ic40_del" onclick="delField(this)"></div></td>\
		  </tr>';
	$('table[choosen] tbody').append(view);
	fixPage();
	fixForm();
}
function addFieldEmpty(id){
	choosenFields=$('input[name=emptyFields]').val();
	loadWindow('#m_info',1,k_file_fields,600,600);
	$.post(f_path+"X/exc_fields_win.php",{id:id,fields:choosenFields}, function(data){
		d=GAD(data);				
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
	 
}
function fixEmptyFieldView(){
	$('#list_f div[notFound]').hide();
	fields=$('input[name=emptyFields]').val();
	if(!fields||fields==0||fields==''){$('#list_f div[notFound]').show(); }
}
function choiceField(rank,nameF){
	isFound=$('div[all] div[field_rank='+rank+']').html();
	if(isFound){
		$('div[choosen] div[field_rank='+rank+']').show();
		$('div[choosen] div[field_rank='+rank+']').attr('exist','');
		$('div[all] div[field_rank='+rank+']').hide();
		fixForm();
		fixPage();
	}
}
function delChoosenField(rank,win='pop'){
	if(win=='pop'){
		isFound=$('div[choosen] div[field_rank='+rank+']').html();
		if(isFound){
			$('div[choosen] div[field_rank='+rank+']').hide();
			$('div[choosen] div[field_rank='+rank+']').removeAttr('exist');
			$('div[all] div[field_rank='+rank+']').show();
		}
	}else if(win=='live'){
		new_emptyFields='';
		emptyFields=$('input[name=emptyFields]').val();
		temp=emptyFields.split(',');
		for(i=0;i<temp.length;i++){
			if(new_emptyFields!=''){new_emptyFields+=',';}
			if(temp[i]!=rank){new_emptyFields+=temp[i];}
			else{$('#list_f div[rank='+rank+']').hide();}
			
		}
		$('input[name=emptyFields]').val(new_emptyFields);
		fixEmptyFieldView();
	}
	fixForm();
	fixPage()
}
function emptyFieldSave($col){
	choosen='';
	$('div[choosen] div[field_rank][exist]').each(function(){
		if(choosen!=''){choosen+=',';}
		choosen+=$(this).attr('field_rank');
	})
	$('input[name=emptyFields]').val(choosen);
	
	win('close','#m_info');
	if(choosen!=''){
		$('#list_f div[notFound]').hide();
		choosen_arr=choosen.split(',');
		$('#list_f div[rank]').each(function(){
			rank=$(this).attr('rank');
			if(choosen_arr.includes(rank)){
				$(this).show();
			}
			else{$(this).hide();}
		})
	}else{
		$('#list_f div[rank]').hide();
		$('#list_f div[notFound]').show();
	}
	fixPage();
	fixForm();
}
function saveForm(level){
	if(level==1){
		file=$('#ex').val();
		$.post(f_path+"X/exc_import_info_set.php",{level:level,file:file}, function(data){
			d=GAD(data);				
			goLevel(d);
		})
	}else if(level==2){
	    t=$("div[comp]").html();
		$('form[name=importInfo]').append(t);
		sub('importInfo');
	}else if(level==3){
		sub('linkAdvancedSet');
	}		
}
function delProcess(id,user='s'){
	if(user=='s'){open_alert(id,'proc_exc',k_confirm_proce_del,k_del_proce);}
	else if(user=='o'){open_alert(id,'proc_exc_o',k_confirm_proce_del,k_del_proce);}
}
function delProcessDo(id,user='s'){//s=>واجهة الإجراءات, o=>واجهة استيراد ملف
	if(user=='s'){loader_msg(1,k_deleting);}
	$.post(f_path+"X/exc_import_info_set.php",{id:id,process:'del'},function(data){
		d=GAD(data);
		if(d==1){
			msg=k_done_successfully;mt=1;
			if(user=='s'){
				win('close','#m_info');
				printData(1,0);
			}else if(user=='o'){ loadModule('is7z48epg');}
		}else{
			msg=k_error_data;mt=0;
		}
		loader_msg(0,msg,mt);
	})
	
}
function moduleChange(){
	$('select[name=selModule]').css("border-color","#ccc");
	id=$('input[name=id_process]').val();
	module=$('#selModule').val();
	$.post(f_path+"X/exc_tables_live.php",{level:3,id:id,module:module},function(data){
		d=GAD(data);
		$('#dataLink').html(d);
		fixLinkTable();	
		fixEmptyFieldView();
		fixForm();
		fixPage();
	})
}
function fixChangeSelType(){
	$('select[txt=part_type]').change(function(){
		part_type_change(this,'change','tr');
	})
	$('select[txt=part_type]').each(function(){
		part_type_change(this,'loop','tr');
	})
	fixForm();
	fixPage();
}
function selFileCols_change(elem,state){
	id=$(elem).closest('tr').attr('id');
	sel='tr[id='+id+'] td[prop]> div';
	$(sel+'[join]').hide();
	$(sel+'[notJoin]').hide();
	/* new
	يجب أن نظهر الحقول التي اخفيناه عند معالجة حالة حقل مخصص أي العودة للحالة الافتراضية*/
	elem_part_type=sel+'[notJoin] select[txt=part_type]';
	sel_part_type=sel+'[notJoin] span';
	$(elem_part_type).show();  
	$(sel_part_type+'[imp_type_tit]').show(); 
	$(sel_part_type+'[exc_custom]').hide();
	$(sel_part_type+'[exc_true]').hide();
				
	//-----------
	val=$(elem).val();
	if(val){
		if(val=='join'){
			$(sel+'[notJoin]').hide();
			$(sel+'[join]').show();
			//اظهار عبارة تحرير الخصائص
			$(sel+'[join] div[propEdit]').removeClass('hide');
		}else{
			$(sel+'[join]').hide();
			$(sel+'[notJoin]').show();
			/////////////////
			/*new 
			في حالة (حقل مخصص) فهنا نقوم بتنفيذ (نوع الاستيراد: استيراد مخصص) من خلال:
			1) نضغ قيمة سيليكت نوع الاستيراد =6 
			2) ننفذ التابع الذي يتنفذ عند تغيير سيليكت نوع الاستيراد وهو (part_type_change)
			نخفي السيليكت ونظهر فقط عبارة تحرير الكود (3 
			4) يجب أن نظهر الحقول التي اخفيناه وإخفاء التي أظهرناه بحيث نعود للحالة الافتراضية وذلك عند تنفيذ التابع الذي يتنفذ عند تغيير سيليكت حقل الملف (selFileCols_change)*/
			if(val=='custom'){
				elem_part_type=sel+'[notJoin] select[txt=part_type]';
				sel_part_type=sel+'[notJoin] span';
				$(elem_part_type).val(6);//1
				part_type_change(elem_part_type,state,sel_part_type);//2
				$(elem_part_type).hide();  $(sel_part_type+'[imp_type_tit]').hide(); //3
			}
		} 
	}
}
function part_type_change(elem,state,sel){
	$(sel+'[indexStart]').hide();
	$(sel+'[partCount]').hide();
	$(sel+'[exc_custom]').hide();
	$(sel+'[exc_true]').hide();//new
	
	val=$(elem).val();
	if(val){
		if(val==6){
			$(sel+'[exc_custom]').show();
			clr=$(sel+'[exc_custom]').attr('class');
			if(clr){if(clr.indexOf('clr6')>=0){$(sel+'[exc_true]').show();}}//new
		}
		else{
			if(val>3){
				$(sel+'[indexStart]').show();
				$(sel+'[partCount]').show();
			}else if(val!=1){
				$(sel+'[partCount]').show()
			}
		}
		if(state=='change'){
			//الإرجاع إلى القيمة الافتراضية
			$(sel+'[indexStart] input').val(1);
			$(sel+'[partCount] input').val('');
		}
	}
}
function fixLinkTable(){
	var dateArr = {dd:'dd',mm:'mm',yyyy:'yyyy'};
	$('select[txt=date_1]').change(function(){
		val=$(this).val();
		$('span[date_1]').html(dateArr[val]);
	})
	$('select[txt=date_2]').change(function(){
		val=$(this).val();
		$('span[date_2]').html(dateArr[val]);
	})
	$('select[txt=date_3]').change(function(){
		val=$(this).val();
		$('span[date_3]').html(dateArr[val]);
	})
	$('input[name=dateChar]').change(function(){
		val=$(this).val();
		$('span[dateChar]').html(val);
	})
	$('select[txt=part_type]').change(function(){
		id=$(this).closest('tr').attr('id');
		part_type_change(this,'change','tr[id='+id+'] span');
	})
	$('select[txt=part_type]').each(function(){
		id=$(this).closest('tr').attr('id');
		part_type_change(this,'loop','tr[id='+id+'] span');
	})
	/*--------------------*/
	selFileColsVal=$('select[txt=selFileCols]').val()
	$('select[txt=selFileCols]').each(function(){
		selFileCols_change(this,'loop');
	})
	$('select[txt=selFileCols]').change(function(){
		selFileCols_change(this,'change');
	})
}
function getCustomWin(related_id,view){
	code=$('input[name=custom_'+related_id+']').val();
	loadWindow(view,1,k_exc_custom,800,800);
		$.post(f_path+"X/exc_custom_win.php",{related_id:related_id,code:code,view:view}, function(data){
			d=GAD(data);				
			$(view).html(d);
			fixForm();
			fixPage();
		})
}
function saveCustomField(related,view){
	codeCus=$('textarea[name=exc_code]').val();
	code=codeCus.replace(/"/g,"\\'");
	if(view=='#m_info'){//live
		sel='#linkAdvancedSet input[name=custom_'+related+']';
		if($(sel).length>0){
			$(sel).val(code);
		}else{
			$('#linkAdvancedSet').append('<input type="hidden" name="custom_'+related+'" value="'+code+'" />');
		}
		id='#linkAdvancedSet';
		if(code && code!=''){
			$(id+' tr[id='+related+'] span[exc_custom]').removeClass('clr5').addClass('clr6').html(k_edt_cod);
			$(id+' tr[id='+related+'] div[notJoin] span[exc_true]').show();
		}else{
			$(id+' tr[id='+related+'] span[exc_custom]').removeClass('clr6').addClass('clr5').html(k_cod_enter);
			$(id+' tr[id='+related+'] div[notJoin] span[exc_true]').hide();
		}
	}
	else if(view=="#m_info3"){//join
		$('input[name=custom_'+related+']').val(code);
		id='div[aria-describedby=m_info2]';
		if(code && code!=''){
			$(id+' tr[exc_custom] span[codeEnter]').removeClass('clr5').addClass('clr6').html(k_k_cod_enter);
			$(id+' tr[exc_custom] span[exc_true]').show();
		}else{
			$(id+' tr[exc_custom] span[codeEnter]').removeClass('clr6').addClass('clr5').html(k_k_cod_enter);
			$(id+' tr[exc_custom] span[exc_true]').hide();
		}
	}
	win('close',view);
}
function getJoinWin(id_process,col){
	joinFields=[]; fields={};
	$('input[name^="join_prop_'+col+'"]').each(function() {
		value=$(this).val();
		name=$(this).attr('name');
		ff=name.split('[');
		field=ff[2].substring(0,ff[2].length-1);
		if(field!='not_field'){
			prop=ff[3].substring(0,ff[3].length-1);
			if(!fields[field]){fields[field]={};}
			fields[field][prop]=value;
			if(prop=='custom'||prop=='part_num'){joinFields.push(fields); fields={};}
		}else{
			fields[field]=value;
			joinFields.push(fields); fields={};
		}
	});
	loadWindow('#m_info',1,k_merge_fields,www,hhh);
		$.post(f_path+"X/exc_join_win.php",{id:id_process,state:'fields_sort',fields:joinFields,col_id:col}, function(data){
			d=GAD(data);				
			$('#m_info').html(d);
			setListOrder();
			fixChangeSelType();
			fixForm();
			fixPage();
		})
}
function infoWin(field_rank,name){
	loadWindow('#m_info2',1,k_field_import_props,500,0);
	$.post(f_path+"X/exc_join_win.php",{field_rank:field_rank,state:'add',name:name}, function(data){
		d=GAD(data);				
		$('#m_info2').html(d);
		fixChangeSelType();
		fixForm();
		fixPage();
	})
		
}
function infoWinEditDel(name,row){
	field_rank=$('tr[row='+row+']').attr('rank');
	index_s=part_num=1;
	custom='';
	type=parseInt($('tr[row='+row+']').attr('part_type'));
	if(type==6){
		custom=$('tr[row='+row+']').attr('custom');
	}else{
		index_s=$('tr[row='+row+']').attr('index_s');
		part_num=$('tr[row='+row+']').attr('part_num');
	}
	loadWindow('#m_info2',1,"",500,0);
		$.post(f_path+"X/exc_join_win.php",{field_rank:field_rank,state:'edit',type:type,index_s:index_s,part_num:part_num,custom_code:custom,name:name,row:row}, function(data){
			d=GAD(data);				
			$('#m_info2').html(d);
			fixChangeSelType();
			fixForm();
			fixPage();
		})
}
function saveSortProcess(col_id){
//	rows=parseInt($('table[choosen]').attr('rows'));
	col_prop=fieldJoin_txt='';
	var data=[];
	input='';
	attr='join_prop_'+col_id;
	$('#linkAdvancedSet input['+attr+']').remove();
	$('table[choosen] tr[rank]').each(function(i){
		field_rank=$(this).attr('rank');
		name='join_prop_'+col_id+'['+i+']['+field_rank+']';
		if(field_rank=='not_field'){
			value=$(this).find('input[not_field]').val();
			input+='<input type="hidden" name="'+name+'" value="'+value+'" />';
			if(value==''){value=' ';}
			fieldJoin_txt+=value;
		}else{
			type=$(this).attr('part_type');
			input+=
			'<input '+attr+' type="hidden" name="'+name+'[part_type]" value="'+type+'" />';
			if(type!=6){
				index_s=$(this).attr('index_s');
				part_num=$(this).attr('part_num');
				input+='<input '+attr+' type="hidden" name="'+name+'[index_s]" value="'+index_s+'" />';
			 	input+='<input '+attr+' type="hidden" name="'+name+'[part_num]" value="'+part_num+'" />';
			}else{
				custom=$(this).attr('custom');
				input+='<input '+attr+' type="hidden" name="'+name+'[custom]" value="'+custom+'" />';
			}
			
			fieldJoin_txt+='['+$(this).children('td:nth-child(3)').html()+']';
		}
		i=i+1;
	})
	
	win('close','#m_info');
	$('tr[id='+col_id+'] div[fieldJoin_txt]').html(fieldJoin_txt);
	if(fieldJoin_txt!=''){
		$('tr[id='+col_id+'] div[propEdit]').removeClass('clr5').addClass('clr6');
		$('tr[id='+col_id+'] div[join] span[exc_true]').show();
	}else{
		$('tr[id='+col_id+'] div[propEdit]').removeClass('clr6').addClass('clr5');
		$('tr[id='+col_id+'] div[join] span[exc_true]').hide();
	}
	$('#linkAdvancedSet').append(input);
	
	
}
contentTxt={
	1:k_all_content,
	2:k_words,
	3:k_letters,
	4:k_words,
	5:k_letters
};
startTxt={
	1:' ',
	2:k_wordLast,
	3:k_charLast,
	4:k_start_word,
	5:k_start_letter
};
function saveAddEdit(rank,name,state,row){
	type=parseInt($('select[name=part_type_'+rank+']').val());
	index_s=part_num=1;
	custom=attrs='';
	content=start='';
	if(type!=6){
		index_s=parseInt($('input[name=index_s_'+rank+']').val());
		part_num=parseInt($('input[name=part_num_'+rank+']').val());
		start=startTxt[type];
		if(type>3){start+=' <ff class="fs16">'+index_s+"</ff>";}
		if(type!=1){content='<ff class="fs16">'+part_num+"</ff> ";}
		content+=contentTxt[type];	
		
		attrs='index_s="'+index_s+'" part_num="'+part_num+'"';
	}else{
		custom=$('input[name=custom_'+rank+']').val();
		attrs='custom="'+custom+'"';
	}

	func="infoWinEditDel('"+name+"','"+row+"')";
	
	view='<tr ml row="'+row+'" rank="'+rank+'" part_type="'+type+'"  '+attrs+' >';
	tds='<td><div class="mover"></div></td>'+
		'<td><ff class="fs16">'+rank+'</ff></td>'+
		'<td class="fs14">'+name+'</td>';
	if(type==6){
		tds+='<td colspan="2"> '+k_exc_custom+'</td>';
	}else{
		tds+='<td class="fs14">'+content+'</td>'+
			'<td class="fs14">'+start+'</td>';
	}
	tds+='<td>'+
			'<div class="fl ic40 icc1 ic40_edit" onclick="'+func+'"></div>'+
			'<div class="fr ic40 icc2 ic40_del" onclick="delField(this)" ></div>'+
		'</td>';
	view+=tds+'</tr>';

	win('close','#m_info2');
	$('table[choosen] ').show();
	if(state=='add'){
		$('table[choosen] tbody').append(view);
	}else{
		$('tr[row='+row+']').attr('part_type',type);
		if(type!=6){
			$('tr[row='+row+']').attr('index_s',index_s);
			$('tr[row='+row+']').attr('part_num',part_num);
		}else{
			$('tr[row='+row+']').attr('custom',custom);
		}
		$('tr[row='+row+']').html(tds);
	} 
	fixForm();
	fixPage();
}
function delField(elem){
	$(elem).closest('tr').remove();
}
/*-----------------------------*/
function templateDown(id){
	loadWindow('#m_info',1,k_import_templates,400,400);
	$.post(f_path+"X/exc_templates_win.php",{id:id,state:'down'}, function(data){
		d=GAD(data);				
		$('#m_info').html(d);
		fixTemplateChoice_win();
		fixForm();
		fixPage();
	})
}
function fixTemplateChoice_win(){
	$('input[class=ser_icons]').keyup(function(){
		valSearch=$(this).val();
		if(valSearch!=''){
			$('#m_info div[class=listOptbutt]').hide();
			$('#m_info div[class=listOptbutt]').each(function(){
				nameThis=$(this).attr('name');
				if(nameThis.includes(valSearch) || valSearch.includes(nameThis)){
					$(this).show();
				}
			})
		}else{
			$('#m_info div[class=listOptbutt]').show();
 		}
	})
	proc_id=$('#m_info input[name=process]').val();
	$('#m_info div[class=listOptbutt]').click(function(){
		template=$(this).attr('template');
		
		$.post(f_path+"X/exc_template_set.php",{id_process:proc_id,template:template,state:'down'}, function(data){
			d=GAD(data);
			if(d>0){goLevel(proc_id+'-'+template);}
			else{ 
				loader_msg(1,k_processing);
				win('close','#m_info');
				loader_msg(0,k_error_data,0);
			}
		})
		
	})
}
function templateUp(id){
	loadWindow('#m_info',1,k_import_templates,600,600);
	$.post(f_path+"X/exc_templates_win.php",{id:id,state:'up'}, function(data){
		d=GAD(data);				
		$('#m_info').html(d);
		//fixTemplateChoice_win();
		fixForm();
		fixPage();
	})
}
function resetAdvancedForm(id){
	win('close','#m_info');
	$('#linkAdvancedSet').attr('action',"../X/exc_import_info_set.php");
	$('#linkAdvancedSet').attr('cb',"getimportStartView("+id+")");
	$('#linkAdvancedSet input[name=state]').remove();
	$('#linkAdvancedSet input[name=name_template]').remove();
	setUpForm("linkAdvancedSet","linkAdvancedSet");
}
function templateSave(id){
	template=$('input[name=template_name]').val();
	if(template!=''){
		$.post(f_path+"X/exc_template_set.php",{id_process:id,state:'test_repeat_name',name_template:template}, function(data){
			d=GAD(data);
			if(d=='error'){
				navC(50,k_template_duplicate_name,'#f00');
			}else{
				$('#linkAdvancedSet').attr('action',f_path+"/X/exc_template_set.php");
				$('#linkAdvancedSet').attr('cb','resetAdvancedForm('+id+')');
				$('#linkAdvancedSet').append('<input type="hidden" name="state" value="up" />');
				$('#linkAdvancedSet').append('<input type="hidden" name="name_template" value="'+template+'" />');
				setUpForm("linkAdvancedSet","linkAdvancedSet");
				sub('linkAdvancedSet');
				//resetAdvancedForm(id);
			}
		});
			
	}else{
		navC(50,k_tmp_nm_ent,'#f00');
	}
}
function info_import_view(id){
	loadWindow('#m_info',1,k_field_import_props,500,0);
	$.post(f_path+"X/exc_load_forms.php",{id:id,state:'info_level1'}, function(data){
		d=GAD(data);				
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
}
function getForm_file(cb){
	loadWindow('#m_info',1,k_excel_file_import,600,600);
		$.post(f_path+"X/exc_load_forms.php",{level:1,state:'add_process',cb:cb}, function(data){
			d=GAD(data);				
			$('#m_info').html(d);
			fixForm();
		})
}
/*****NEW********/
function getSettingWin(id){
	loadWindow('#m_info',1,k_add_rec,600,600);
	$.post(f_path+"X/exc_temp_addtion_page.php",{state:'view',id:id},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		$('.upimageCon').removeClass('upimageCon');
		
		$('input[name=cof_xa3rhuufiq]').closest('tr').click(function(){
			$(this).css('background-color','');
		})
		$('input[name=cof_fo5i5z27zd]').closest('tr').click(function(){
			$(this).css('background-color','');
		})
		$('input[name=cof_7oq1hki4c]').closest('tr').click(function(){
			$(this).css('background-color','');
		})
		setUpForm('importForm','importForm');
	})
}
function getStartImport(template){
	$.post(f_path+"X/exc_temp_addtion_page.php",{template:template,state:'changeTemplate'},function(data){
 		d=GAD(data);
		if(d!=''){
			$('input[name=cof_fo5i5z27zd]').val(parseInt(d));
		}
	})
}
function selectionTemplate(){
	loadWindow('#m_info2',1,k_template_choose_list,350,350);
	$.post(f_path+"X/exc_temp_addtion_page.php",{state:'view_select_temp'},function(data){
 		d=GAD(data);
		$('#m_info2').html(d);
		//$('#list_ex').removeAttr('class list id');
		$('#list_ex').removeAttr('class  id');
		$('.imgUpHol').removeClass('fl');
		$('.upimageCon').addClass('exc_upimageCon');
		fixForm();
		fixPage();
	})
}
function selectTempDo(id,name){
	win('close','#m_info2');
	$('#temps_list').val(id);
	$('#name_temp').html(name);
	//change start line
	$.post(f_path+"X/exc_temp_addtion_page.php",{template:id,state:'changeTemplate'},function(data){
 		d=GAD(data);
		if(d!=''){
			$('input[name=cof_fo5i5z27zd]').val(parseInt(d));
		}
	})
}
function getDetailsProcess_client(id){
	loadWindow('#m_info',1,k_import_props,450,450);
	$.post(f_path+"X/exc_temp_import_prop_win.php",{id:id,state:'info'},function(data){
 		d=GAD(data);
		$('#m_info').html(d);
		
		fixForm();
		fixPage();
		
	})
}
function tempFileImport(template){
	file=$('#ex').val();
	$.post(f_path+"X/exc_temp_import_prop_win.php",{id:template,state:'import',file:file},function(data){
 		d=GAD(data);
		dd=d.split('^');
		id=dd[0];
		name=dd[1];
		selectTempDo(id,name);
	})
}
function getTemplateProp(id){
	loadWindow('#m_info',1,k_template_properties,www,'200');
	$.post(f_path+"X/exc_temp_template_prop_win.php",{id:id,state:'info'},function(data){
 		d=GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage(); 
	})
 }
function saveAdditionPage_client(id=0){
	from=$('input[name=cof_fo5i5z27zd]').val();
	to=$('input[name=cof_7oq1hki4c]').val();
	template=$('#temps_list').val();
	if(!from){$('input[name=cof_fo5i5z27zd]').closest('tr').css('background-color','pink');}
	if(!to){$('input[name=cof_7oq1hki4c]').closest('tr').css('background-color','pink');}
	if(!template){$('#temps_list').closest('tr').css('background-color','pink');}
	if(template && from && to){
		res='';
		loader_msg(1,k_loading);
		$.post(f_path+"X/exc_temp_addtion_page.php",{from:from,to:to,template:template,id:id,state:'checkError'},function(data){
			d=GAD(data);
			dd=d.split('^');
			res=dd[0];
			if(res==1){
				rowCount=dd[1];
				$('#importForm input[name=count_rows]').val(rowCount);
				$('#importForm input[name=id_process]').val(id);
				sub('importForm');
 				/*loadModule();
				win('close','#m_info');*/
 			}else if(res!=''){loader_msg(0,''); nav(50,res);}
		})
 	}
 }
function getImportView_client(){
	$.post(f_path+"X/exc_temp_import_client_live.php",{state:1},function(data){
 		d=GAD(data);
		$('#table_files').html(d);
	})
}
function search_template(){
	name=$('#list_ser_option').val();
	$('div[temp]').hide();
	$('div[temp='+name+']').show();
}
function check_type_file(sel){
	file=$(sel).val();
	if(file){
		$.post(f_path+"X/exc_check_type_file.php",{file:file},function(data){
 		d=GAD(data);
			if(d=='1'){
				navC(50,k_shld_be_csv,'#f00');
				a=$('#cof_xa3rhuufiq').val('');
				$('.file_box').remove();
			}else{
				sub('co_form0');
			}
		})
	}
}
function get_enc_code(temp){
	loadWindow('#m_info',1,k_export_import_template,300,300);
	$.post(f_path+"X/exc_export.php",{state:'view',temp:temp},function(data){
 		d=GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
}
function doExport(){
	code=$('input[name=enc_code]').val();
	if(code && code!=''){
		sub('ex_code');
		win('close','#m_info');
	}else{
		navC(50,k_enter_encryption_code,'#f00');
	}
}
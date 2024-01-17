/***************pharmacy* (medical prescription)***********************/
var search_time=0;
var patient=0;
function presc_loadPrescriptions(l=0){
	if(l==1){$('#presc_data').html(loader_win); $('#patient_barcode').val(''); }
	barcode=$('#patient_barcode').val();
	$.post(f_path+"X/phr_medical_prescription_live.php",{barcode:barcode},function(data){
		d=GAD(data);
		dd=d.split('^');
		rows=dd[2];
		table=dd[1];
		patientName=dd[0];
		all_presc=dd[3];
		exchanged_presc=dd[4];
		not_exchanged_presc=dd[5];
		part_exchanged_presc=dd[6];
		$('#patient_name').html(patientName);
		$('#m_total').html(rows);
		$('#presc_data').html(table);
		$('#all_presc').html(all_presc);
		$('#exchanged_presc').html(exchanged_presc);
		$('#not_exchanged_presc').html(not_exchanged_presc);
		//$('#notExist_drug').html(notExist_drug);
		$('#part_exchanged_presc').html(part_exchanged_presc);
		presc_fix_patient_view();
		
		fixForm(); 
		fixPage();		
	})
}

function presc_fix_patient_view(){
	$('#patient_barcode').keyup(function(){
		$('#presc_data').html(loader_win);
		clearTimeout(search_time);
		search_time=setTimeout(function(){presc_loadPrescriptions();},800);
	})
}
function presc_infoPrescription(id,l=0){
	isFirst=0;
	if(!l){loadWindow('#m_info',1,k_prescription_details,www,hhh);isFirst=1;}
	$.post(f_path+"X/phr_medical_prescription_info.php",{id:id,status:'view',isFirst:isFirst},function(data){
		d=GAD(data);
		dd=d.split('^');
		price=dd[1];
		view=dd[0];
		$('#m_info').html(view);
		$('ff[tot_price]').html(price);
		
		fixForm(); 
		fixPage();	
		loadFormElements('#presc_exchange');		
		setupForm('presc_exchange','');

		presc_fix_exchange_view(id,'old');
		
	})
}
function presc_price_edit(elem){
	input=$(elem).closest('tr').find('input[presc_price]');
	ff=$(elem).closest('tr').find('ff[presc_price]');
	input.removeClass('hide');
	input.removeClass('no_event');
	input.focus();
	ff.addClass('hide');
	fixForm();
	fixPage();
}
//td[ch][alter]=>البدائل المضافين حاليا فقط
//[child]>td[ch]=>البدائل كلها سواء تمت اضافتها سابقا او حاليا
function presc_fix_exchange_view(id,sel){
	presc_updatePrice_changeCbg();
	$('[par=grd_chek]').each(function(){presc_one_ch_on(this); presc_fix_altrs(this);});//كل البدائل

	$('[par=check_all]').click(function(){
		act=$('.not_active').find('[ch=on]').attr('ch','off').html('');
		presc_updatePrice_changeCbg();
		$('[par=grd_chek]').each(function(){presc_one_ch_on(this); presc_fix_altrs(this);});//كل البدائل
	});
	$('['+sel+']').find('[par=grd_chek]').click(function(){ 
		presc_updatePrice_changeCbg();
		presc_one_ch_on(this,'click');
	});
	//----------------------------
	$('['+sel+']').find('.switch_butt').click(function(){
		elem=$(this);
		setTimeout(function(){
			val=parseInt(elem.attr('v'));
			if(val==1){
				elem.closest('tr').removeClass('not_active');
				elem.closest('tr').find('td[add_altr]').addClass('no_event');
				elem.closest('tr').find('td[add_altr]>div').addClass('cbg4');
				elem.closest('tr').find('td[add_altr]>div').removeClass('icc1');
			}else{
				elem.closest('tr').addClass('not_active');
				elem.closest('tr').find('[ch=on]').attr('ch','off').html('');
				elem.closest('tr').removeClass('cbg44');
				elem.closest('tr').find('td[add_altr]').removeClass('no_event');
				elem.closest('tr').find('td[add_altr]>div').addClass('icc1');
				elem.closest('tr').find('td[add_altr]>div').removeClass('cbg4');
			}
			r=elem.attr('r');
			$.post(f_path+"X/phr_medical_prescription_info.php",{
				id:r,exist:val,status:'process_exist'},function(data){
				d=GAD(data);
				if(d==1){
					presc_updatePrice_changeCbg();
				}else{
					loader_msg(0,k_error_data,0);
				}
			})
		},1000);
		
		
	});
	//-------------
	$('['+sel+']').find('[presc_price]').on('focusout change',function(event){
			$(this).addClass('no_event');
			price=parseInt($(this).val());
			r=$(this).attr('r');
			elem=$(this);
			if(event.type=='change'){
				$.post(f_path+"X/phr_medical_prescription_info.php",{
					id:r,price:price,status:'process_change_price'},function(data){
					d=GAD(data);
					if(d==1){
						elem.closest('td').find('ff[presc_price]').html(price);
						presc_updatePrice_changeCbg();
					}else{
						loader_msg(0,k_error_data,0);
					}
				})
			}else{
				$(this).addClass('hide');
				$(this).closest('td').find('ff').removeClass('hide');
			}
		})
	//------
	$('['+sel+']').find('input[req_qantity]').on('change',function(event){
		isSel=$(this).closest('tr').find('[ch=on]');
		if(isSel.length){
			presc_updatePrice_changeCbg();
		}
	});
	
	$('[child]>td[ch]').click(function(){presc_fix_altrs(this); presc_one_ch_on(this,'click')}); //كل البدائل
	
	$('tr[child]').each(function(){
		origin=$(this).attr('origin');
		$('#add_altr'+origin).removeClass('icc1').closest('td').addClass('no_event');
		$('#add_altr'+origin).addClass('cbg4');
	});
	
}

function presc_one_ch_on(elem,status=''){
	child=$(elem).closest('tr[child]').length;
	ch=$(elem).find('div[ch=on]').length;
	if(ch){
		if(child){
			if(status=='click'){
				origin=$(elem).closest('tr').attr('origin');
				$('tr').find('[ch_val='+origin+']').find('[ch=on]').attr('ch','off').html('');
			}
		}else{
			origin=$(elem).attr('ch_val');
			$('tr[origin='+origin+']').find('[ch=on]').attr('ch','off').html('');
			//$(elem).closest('tr').('tr[child]').find('[ch=on]').attr('ch','off').html('');
		}
	}
}
function presc_fix_altrs(elem){
	ch=$(elem).find('div[ch=on]').length;
	origin=$(elem).closest('tr').attr('origin');
	if(ch){
		drug=$(elem).find('div[ch=on]>input').val();
		$(elem).closest('tr').append('<input type="hidden" name="alters['+origin+']" value="'+drug+'" />');
	}else{
		$(elem).closest('tr').find('[name="alters['+origin+']"]').remove();
	}
}
function presc_updatePrice_changeCbg(){
	tot_cost=0; i=1;
	$('[ch]').each(function(){
		ch=$(this).attr('ch');
		complete=$(this).closest('tr').attr('complete');
		//change cbg
		if(complete==1){
			$(this).closest('tr').addClass('cbg_pink');
		}
		
		if(ch=='on'){
			if(complete==1){$(this).closest('tr').toggleClass('cbg_pink cbg44');}
			else{$(this).closest('tr').addClass('cbg44');}
			//begin calculate price
			drug=$(this).find('input').val();
			if(drug!='on'){ //not check all
				req_quantity=parseInt($('[name="req_quantity['+drug+']"]').val());
				price=parseInt($('[r='+drug+'][presc_price]').val());
				tot_cost+=(req_quantity*price);
			}
			i++;
			//end calculate price
		}else{
			$(this).closest('tr').removeClass('cbg44');
		}
		
	});
	$('ff[tot_price]').html(tot_cost);
	
	
}


function presc_callBack_process(id,res){
	loader_msg(0,'');
	if(parseInt(res)==1){
		win('close','#m_info');
		presc_print2(id);
	}else{
		drugs_errs=res.split('-');
		if(drugs_errs[0]=='err'){
			for(i=0;i<drugs_errs.length;i++){
				$('[name="req_quantity['+drugs_errs[i]+']"]').css('border-color','red');
				$('[name="req_quantity['+drugs_errs[i]+']"]').css('color','red');
			}
			nav(50,k_according_hos_policy);
		}
	}
}

function presc_exchange_do(){
	isSel=$('[par=grd_chek] > [ch=on]').length;
	if(isSel){
		sub('presc_exchange');
	}else{
		nav(50,k_select_med_first);
	}
}
var elem_click=0; var origin_drug=0;
function presc_add_alter_view(presc,drug,elem,s=0){
	if(s==0){loadWindow('#m_info4',1,k_sl_val_lst,400,0);}
	else{$('#drug_list').html(loader_win);}
	obj=$('#list_ser_option').val();
	$.post(f_path+"X/phr_medical_prescription_drugs_list.php",{status:'view',drug:drug,presc:presc,obj:obj}, function(data){
		d=GAD(data);
		if(s==1&& obj){$('#drug_list').html(d); }
		else{
			$('#m_info4').html(d);
			elem_click=elem;
			origin_drug=drug; 
		}
		fixForm();
		fixPage();
	})
	
}

function presc_add_alter_search(presc,drug){
	setTimeout(function(){presc_add_alter_view(presc,drug,0,1);},1000)
}

function presc_add_alter_process(presc,drug){
	$.post(f_path+"X/phr_medical_prescription_drugs_list.php",{status:'process',drug:drug,presc:presc,origin_drug:origin_drug},function(data){
		d=GAD(data);
		win('close','#m_info4');
		$(d).insertAfter($(elem_click).closest('tr'));
		
		loadFormElements('#presc_exchange');		
		setupForm('presc_exchange','');
		presc_fix_exchange_view(presc,'new');
		fixForm();
		fixPage();
		
		
	})
}

function presc_del_altr(elem,origin){
	exist=$('.switch_butt[r='+origin+']').attr('v');
	if(exist==0){
		$('#add_altr'+origin).closest('td').removeClass('no_event');	
		$('#add_altr'+origin).removeClass('cbg4');
		$('#add_altr'+origin).addClass('icc1');
	}
	elem.closest('tr').remove();
}

function presc_add_note(id,status='presc'){	
	loadWindow('#m_info3',1,k_add_note,550,200);
	$.post(f_path+"X/gnr_preview_medicine_note.php",{id:id,status:status}, function(data){
		d=GAD(data);
		$('#m_info3').html(d);
		fixPage();
		fixForm();			
	})
}
function presc_save_note(id,status='presc'){
	note=$('#maNote').val();	
	loader_msg(1,k_loading);
	$.post(f_path+"X/gnr_preview_medicine_note_save.php",{id:id,note:note,status:status},function(data){
		d=GAD(data);
		if(d==1){
			msg=k_done_successfully;mt=1;
			win('close','#m_info3');
			if(status=='medicin'){
				$('[mn="'+id+'"]').html(note);
			}else if(status=='presc'){
				$('[pn="'+id+'"]').html(note);
			}
		}else{
			msg=k_error_data;mt=0;
		}
		loader_msg(0,msg,mt);
	})
}

function presc_rep(pres,dru){
	//alert(1);
	return "co_loadForm(0,3,'38tgwuqvh||presc_add_alter_view("+pres+","+dru+",0,1)|','',k_add_rec);";
}


function editMdcQ(id){
	loadWindow('#m_info3',1,k_modify_req_quan,550,200);
	$.post(f_path+"X/gnr_preview_medicine_quan.php",{id:id}, function(data){
		d=GAD(data);
		$('#m_info3').html(d);
		fixPage();
		fixForm();
	})
}
function editMdcQsave(id){
	qun=$('#maQun').val();
	loader_msg(1,k_loading);
	$.post(f_path+"X/gnr_preview_medicine_quan_save.php",{id:id,qun:qun},function(data){
		d=GAD(data);
		if(d==1){
			msg=k_done_successfully;mt=1;
			win('close','#m_info3');			
			$('#mq_'+id).html(qun);
		}else{
			msg=k_error_data;mt=0;
		}
		loader_msg(0,msg,mt);
	})
}

function presc_send_toPhr(presc,status){
	loader_msg(1,k_loading);
	$.post(f_path+"X/gnr_presc_send_toPhr.php",{id:presc,status:status},function(data){
		d=GAD(data);
		if(d==1){
			msg=k_done_successfully;mt=1;
			//addPrescr(presc,1);
            showPrescr(presc);
			/*win('close','#m_info3');			
			$('#mq_'+id).html(qun);*/
		}else{
			msg=k_error_data;mt=0;
		}
		loader_msg(0,msg,mt);
	})
}
/************************** New code ******************************/
var actPres=0;
var phr_se='';
$(document).ready(function(){    
    if(sezPage=='Pharmacy-operations'){        
        refPage('phr_main',10000);
        phr_main(1);
        $('#mainKistRef').click(function(){phr_main(1);});
        $('body').on('click','[prec]',function(){showPrec($(this).attr('prec'));});
        $('[printPres]').click(function(){processPres(1);})
        $('[givePres]').click(function(){processPres(2);})
        $('#patForm input').keyup(function(){phr_main_serch();})
        $('#patForm select').change(function(){phr_main_serch();})
    }
})
function phr_main_serch(){
    clearTimeout(phr_se);    
    phr_se=setTimeout(function(){phr_main(1);},800);
    
}
function phr_main(l){    
	if(l==1){
		$('#per_list').html(loader_win);
	}
    data=objectifyForm('#patForm')
	$.post(f_path+"X/phr_main_list.php",{act:actPres,data:data},function(data){
		d=GAD(data);
        dd=d.split('^');
        if(dd.length==2){
            $('#pr_total').html(' ( '+dd[0]+' )');
		    $('#per_list').html(dd[1]);
        }
		fixPage();
		fixForm();		
	})
}
function objectifyForm(form) {
    var items = {};
    inputs=$(form).find('input , select');
    for (var i = 0; i < inputs.length; i++){
        items[inputs[i]['name']] = inputs[i]['value'];
    }    
    return items;
}
function showPrec(id){
    actPres=id;
    $('#per_info').html(loader_win);
    $('#pr_actions').hide();
    $('[givePres]').show();
    $('[prec].cbg7').addClass('cbgw');
    $('[prec]').removeClass('cbg7');
    $('[prec="'+id+'"]').removeClass('cbgw');
    $('[prec="'+id+'"]').addClass('cbg7');
    $.post(f_path+"X/phr_main_list_info.php",{id:id},function(data){
		d=GAD(data);        
        dd=d.split('^');
        if(dd.length==2){
            if(dd[0]==2){
                $('[givePres]').hide();
            }
            $('#pr_actions').slideDown(200);
            $('#per_info').html(dd[1]);
            fixPage();
            fixForm();	
        }else{
            $('#per_info').html('');
        }
	})    
}
function processPres(type){//1:print,2:give
    thisId=actPres;
    if(actPres){
        loader_msg(1,k_loading);
        $.post(f_path+"X/phr_main_list_process.php",{id:actPres,type:type},function(data){
            d=GAD(data);
            if(d==1){
                msg=k_done_successfully;mt=1;                
                showPrec(actPres);
                if(type==1){                    
                    printPrescr(1,thisId);
                }
            }else{
                msg=k_error_data;mt=0;
            }
            loader_msg(0,msg,mt);
        })
    }
}


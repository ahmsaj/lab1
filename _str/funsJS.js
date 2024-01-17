/***STR***/
var actShip=0;var actItemsType=1;var treeType=1;var pac_vals=new Array();var pttVal=0;var ItemBalans=0;var tree_ser;var actTrans=0;var atcStorage=0;var actTreeSear=1;
function newCons(strage,data,bc,title){	
	t=k_consumption_items;
	atcStorage=strage;
	if(title!=''){t+=' ( '+title+' )';}
	loadWindow('#full_win1',1,t,720,400);
	$.post(f_path+"X/str_consumption_item.php",{s:strage,d:data,bc:bc},function(data){
		d=GAD(data);
		$('#full_win1').html(d);
		treeSearDo(3);
		fixForm();	
		fixPage();			
		setupForm('cons','full_win1');
	})
}
function selStorSpart(v){
	$('#stoSpatr').html(loader_win);
	f=$('#stoSpatr').attr('f');
	$.post(f_path+"X/str_warehouse_sett.php",{v:v,f:f}, function(data){
		d=data.split('<!--***-->');
		$('#stoSpatr').html(d);
		fixForm();
		fixPage();		
	})
}
function editPac(){
	pacData=$('#ItemePakeg').val();
	loadWindow('#m_info',1,k_packing,620,400);
	$.post(f_path+"X/str_item_packages.php",{d:pacData},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
		countPac();
	})	
}
function countPac(){
	err=0;
	v=0;	
	$('#pcTotal').html(1);
	$('#endButt').hide();
	n1=parseInt($('#pNo1').val());
	n2=parseInt($('#pNo2').val());

	p1=parseInt($('#pacT1').val());
	p2=parseInt($('#pacT2').val());

	ErStl('#pacT1',0);ErStl('#pNo1',0);ErStl('#pacT2',0);ErStl('#pNo2',0);
	if(n1!=0 || p1!=0){
		v=1;			
		if(p1==0){ErStl('#pacT1',1);err=1;}else{ErStl('#pacT1',0);}
		if(n1==0){ErStl('#pNo1',1);err=1;}else{ErStl('#pNo1',0);}

		if(p2==0){ErStl('#pacT2',1);err=1;}else{ErStl('#pacT2',0);}			
		if(n2==0){ErStl('#pNo2',1);err=1;}else{ErStl('#pNo2',0);}
		n1tot=n1;
		n2tot=n2;
	}else{
		if(n2!=0 || p2!=0){
			v=1;
			if(n2==0){ErStl('#pacT2',1);err=1;}else{ErStl('#pacT2',0);}
			if(p2==0){ErStl('#pNo2',1);err=1;}else{ErStl('#pNo2',0);}
			n1tot=1;
			n2tot=n2;
		}
	}		
	if(err==0 && v==1){
		$('#pcTotal').html(n1tot*n2tot);
		$('#endButt').show();
	}
}
function endPac(){
	n1=parseInt($('#pNo1').val());
	n2=parseInt($('#pNo2').val());
	p1=parseInt($('#pacT1').val());
	p2=parseInt($('#pacT2').val());
	pacVal=p1+'-'+n1+'-'+p2+'-'+n2;
	pacData='';
	if(n1){
		p1v1=$('#pacT1 option:selected').text();
		pacData+='<div class="f1 fs12 lh20">'+k_main_category+' : '+p1v1+' <ff class="ff fs16">( '+n1+' )</ff></div>';
	}
	p1v2=$('#pacT2 option:selected').text();
	pacData+='<div  class="f1 fs12 lh20">'+k_subcategory+' : '+p1v2+' <ff class="ff fs16">( '+n2+' )</ff></div>';
	pacTotal=$('#pcTotal').html();
	pacData+='<div  class="f1 fs12 lh20">'+k_total_units_coating+' <ff class="ff fs16">( '+pacTotal+' )</ff></div>';
	$('#ItemePakeg').val(pacVal);
	$('#dataPakeg').html(pacData);
	win('close','#m_info');
}
function shipItems(id){
	actShip=id;
	actItemsType=1;
	loadWindow('#full_win1',1,k_invoice_details,620,400);
	$.post(f_path+"X/str_invoice_items.php",{id:id},function(data){
		d=GAD(data);
		$('#full_win1').html(d);
		fixForm();
		fixPage();
		treeSet(1);
		loadShipItems(actShip);
	})	
}
function shipItemsInfo(id){	
	loadWindow('#m_info',1,k_invoice_details,720,400);
	$.post(f_path+"X/str_invoice_items_info.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();		
	})
}
function loadShipItems(id){
	$('#shipItems').html(loader_win);
	$.post(f_path+"X/str_invoice_items_list.php",{id:id},function(data){
		d=GAD(data);
		$('#shipItems').html(d);
		fixForm();
		fixPage();
		s_val=$('#treeSer').val();
		if(s_val!=''){$('#treeSer').val('');treeSear(1);}
	})
}
function treeSet(t){
	treeType=t;
	$('.treeButt').click(function(){		
		sw=$(this).attr('sw');
		if(sw=='on'){
			$(this).attr('sw','off');
			$(this).html('+');
			$('.shItTreeIN div[sw=on]').attr('sw','off');
			$('.shItTreeIN > div > div[blc]').slideUp(function(){
				$('.shItTreeIN > div[blc]').slideUp();	
			});			
		}else{
			$(this).attr('sw','on');
			$(this).html('-');
			$('.shItTreeIN div[sw=off]').attr('sw','on');
			$('.shItTreeIN > div[blc]').slideDown(function(){
				$('.shItTreeIN > div > div[blc]').slideDown();	
			});
			
		}
	})
	$('.shItTreeIN div[m]').click(function(){
		no=$(this).attr('no');
		sw=$(this).attr('sw');
		if(sw=='on'){
			$(this).attr('sw','off');
			$('div[blc=c'+no+']').slideUp();
		}else{
			$(this).attr('sw','on');
			$('div[blc=c'+no+']').slideDown();
		}
	})
	$('.shItTreeIN div[s]').click(function(){
		no=$(this).attr('no');
		sw=$(this).attr('sw');
		if(sw=='on'){
			$(this).attr('sw','off');
			$('div [blc=cs'+no+']').slideUp();
		}else{
			$(this).attr('sw','on');
			$('div [blc=cs'+no+']').slideDown();
		}
		
	})
	$('.shItTreeIN div[i]').click(function(){
		no=$(this).attr('no');		
		if($('#transTable tr[it='+no+']').length==0){	
			loadItem(no,0,t);	
			
		}else{
			nav(2,k_item_cannot_added_more_once);
		}
	})
}
function loadItem(iteme,id,t){
	actItemsType=t;	
	if(t==3){
		newItemRow(iteme);
	}else{
		loadWindow('#m_info2',1,k_add_item,500,400);
		if(t==1){p_id=actShip;}
		if(t==2){p_id=actTrans;}
		$.post(f_path+"X/str_item_add.php",{id:id,p_id:p_id,iteme:iteme,t:t},function(data){
			d=GAD(data);
			$('#m_info2').html(d);
			fixForm();
			fixPage();	
			setupForm('siaForm','m_info2');
			$('#pacTot').focus();
		})
	}
}
function setPacInt(){
	$('#pacType').change(function(){QCal();})
	$('#pacTot').keyup(function(){QCal();})
	QCal();
}
function QCal(){
	$('#Qmasg').hide();
	pty=parseInt($('#pacType').val());
	pto=parseInt($('#pacTot').val());
	ptt=pto;
	if(pty==1){ptt=(pac_vals[1]*pac_vals[2])*pto;}
	if(pty==2){ptt=pac_vals[2]*pto;}
	pttVal=ptt;
	$('#ptt').html(ptt);
	if(actItemsType==2){
		if(pttVal>ItemBalans){$('#Qmasg').show();}
	}
}
function treeSear(t){clearTimeout(tree_ser);tree_ser=setTimeout(function(){treeSearDo(t);},800);}
function treeSearDo(t){
	actTreeSear=t;
	s_val=$('#treeSer').val();
	if(t==3){$('#itreeD').html(loader_win);}
	$('#itreeD').html(loader_win);
	$.post(f_path+"X/str_item_tree.php",{s:s_val,t:t},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd[0]=='tree'){
			$('#itreeD').html(dd[1]);
			fixForm();
			fixPage();
			treeSet(t);
		}else{
			loadItem(dd[1],0,t);
			$('#treeSer').val('');
			treeSearDo(t);
		}
	})
}
function delItem(id){open_alert(id,26,k_would_you_like_delete_item,k_delete_item);}
function delItemDo(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/str_item_del.php",{id:id,t:actItemsType},function(data){
		d=GAD(data);		
		if(d==1){if(actItemsType==1){loadShipItems(actShip);}else{loadTransItems(actTrans);}
		loader_msg(0,k_done_successfully,1);}else{loader_msg(0,k_error_data,0);}
	})	
}
function shipItemsEnd(id){open_alert(id,27,k_if_receive_inv_nt_abl_edit_items,k_receipt_invoice);}
function shipItemsEndDo(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/str_invoice_items_end.php",{id:id},function(data){
		d=GAD(data);
		if(d==1){loadModule();loader_msg(0,k_done_successfully,1);}else{loader_msg(0,k_error_data,0);}
	})	
}
function newTrans(t,id){
	if(t==1){loadWindow('#m_info',1,k_new_transfer,500,200);}else{win('close','#m_info');}
	$.post(f_path+"X/str_trans_add.php",{t:t,id:id},function(data){
		d=GAD(data);
		if(t==1){			
			$('#m_info').html(d);
			fixForm();
			fixPage();
		}else{
			loadModule();
			transItems(d);
		}		
	})	
}
function transItems(id){
	actTrans=id;
	actItemsType=2;
	loadWindow('#full_win1',1,k_sent_items,620,400);
	$.post(f_path+"X/str_trans_itemes.php",{id:id},function(data){
		d=GAD(data);
		$('#full_win1').html(d);
		treeSearDo(2)
		fixForm();
		fixPage();
		treeSet(2);
		loadTransItems(actTrans);
	})	
}
function transItemsInfo(id){	
	loadWindow('#m_info',1,k_details_of_the_transfer,720,400);
	$.post(f_path+"X/str_trans_itemes_info.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();		
	})
}
function loadTransItems(id){
	$('#shipItems').html(loader_win);
	$.post(f_path+"X/str_trans_itemes_list.php",{id:id},function(data){
		d=GAD(data);
		$('#transItems').html(d);
		fixForm();
		fixPage();
		s_val=$('#treeSer').val();
		if(s_val!=''){$('#treeSer').val('');treeSearDo(actTreeSear);}
		//treeSear(2);
	})
}
function siaFormFormCheck(){
	if(actItemsType==2){
		if(pttVal>ItemBalans){nav(1,k_spec_quan_greater_balance)}else{sub('siaForm');}
	}else{
		sub('siaForm');
	}
}
function transItemsEnd(id,t){
	if(t==1){open_alert(id,28,k_has_items_been_sent,k_send_items);}
	if(t==2){open_alert(id,28,k_has_items_been_received,k_receive_items);}
}
function transItemsEndDo(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/str_trans_itemes_end.php",{id:id},function(data){
		d=GAD(data);
		if(d==1){
			win('close','#m_info');
			loadModule();
			loader_msg(0,k_done_successfully,1);
		}else{loader_msg(0,k_error_data,0);}
		
	})	
}
function newItemRow(iteme){
	div_it=$('.shItTreeIN div[i][no='+iteme+']');
	bal=div_it.attr('bal');
	name=div_it.attr('it');
	if($('#consTable tr[it='+iteme+']').length==0){		
		row='<tr it="'+iteme+'"><td class="f1 fs14">'+name+'</td>\
		<td><input cons name="i'+iteme+'" no="'+iteme+'" type="number" required min="1" max="'+bal+'" value="1" name="i'+iteme+'" /></td><td><ff>'+bal+'</ff></td><td><div class="ic40 icc2 ic40_del fl" onclick="delConRec('+iteme+')"></div></td></tr>';
		$('#consTable').append(row);
		checkConButt();
		fixPage();
	}else{
		nav(2,k_item_cannot_added_more_once);
	}
}
function delConRec(id){
	$('#consTable tr[it='+id+']').remove();
	checkConButt();
	
}
function checkConButt(){
	if($('#consTable tr[it]').length==0){$('#endConsButt').show(300);}else{$('#endConsButt').hide(300);}
}
function save_cons(){
	ids='';
	err=0;
	$('input[cons]').each(function(){
		no=$(this).attr('no');
		max=$(this).attr('max');
		v=parseInt($(this).val());
		if(v<=0 || v>max){
			err=1;ErStl($(this),1);
		}else{
			ErStl($(this),0);
			if(ids!=''){ids+=',';}
			ids+=no;
		}
	})
	if(ids!=''){
		$('#cons_ids').val(ids);
		if(err==0){sub('cons');}
	}else{
		nav('2',k_one_item_must_seld);
	}
}
function iteme_bal_det(id,t){
	title=k_detailed_balance;
	wi=500;
	if(t==2){title=k_item_movement;wi=800;}
	loadWindow('#m_info',1,title,wi,400);
	$.post(f_path+"X/str_item_balance.php",{id:id,t:t},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();		
	})
}
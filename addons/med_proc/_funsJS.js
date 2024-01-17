/***med_proc***/
var addPath=f_path+"Add.med_proc/";
var sr_mp='';
var actRecN=0;
var actMp='';
var tmpClic=0;
var add_codes=new Array('','com','dia','cln','str','not');
function addMpSel(code,t){
	actRecN=0;
	actMp=code;
	prvLoader(1);
	$.post(addPath+"prv_mp_list.php",{vis:visit_id,t:t},function(data){
		d=GAD(data);
		loadPrvData(code,d);
		prvLoader(0);
		$('#pm_src').keyup(function(){addMpSelTempSr(t,0);})
		addMpSelTemp(t,0);
		fixPage();
		fixForm();
	})
}
function mp_it_set(){
	$('.prvlBlc [add]').click(function(){
		t=$(this).attr('t');
		openBlock(add_codes[t]);
		mp_in(t,0);
	})
	$('.prvlBlc [info]').click(function(){
		code=$(this).attr('info');	
		viewAddDets(1,code);
	})
	item=$('.prvlBlc [item][set=0]');
	item.find('[del]').click(function(){
		t=$(this).closest('[item]').attr('t');
		n=$(this).closest('[item]').attr('n');			
		mp_del(t,n);
	})
	item.dblclick(function(){
		t=$(this).attr('t');
		n=$(this).attr('n');
		inTxt=$('.prvlBlc [item][t='+t+'][n='+n+'] [txt]').html();
		mp_in(t,n,inTxt);
	})
	item.find('[edit]').click(function(){
		t=$(this).closest('[item]').attr('t');
		n=$(this).closest('[item]').attr('n');
		inTxt=$('.prvlBlc [item][t='+t+'][n='+n+'] [txt]').html();
		mp_in(t,n,inTxt);		
	})
	item.find('[temp]').click(function(){
		t=$(this).closest('[item]').attr('t');
		n=$(this).closest('[item]').attr('n');		
		mp_tmp_save(t,n);
	})	
	item.attr('set','1');
}
function mp_in(t,n,txt=''){
	$('.prvlBlc [inpu]').remove();
	$('.prvlBlc [item]').show();
	openBlock(add_codes[t]);
	eForm='<div inpu t="'+t+'" n="'+n+'" ><div class="fl" contenteditable="true" inTxt fix="wp:60">'+txt+'</div><div class="fl i30 i30_done" title="حفظ" save></div><div class="fl i30 i30_del" title="الغاء" close></div></div>';
	if(n==0){
		$('.prvlBlc [items][t='+t+']').append(eForm);
		$('.prvlBlc [inpu][t='+t+'][n='+n+'] [intxt]').focus();
		$('.prvlBlc [inpu][t='+t+'][n='+n+'] [intxt]').keyup(function(){serTemp(t,$(this).html());});
	}else{
		$('.prvlBlc [item][t='+t+'][n='+n+']').after(eForm);
		$('.prvlBlc [item][t='+t+'][n='+n+']').hide();
	}	
	setEnterButt(t,n);	
	mp_in_set(t,n);
	if(actMp!=add_codes[t]){
		setTimeout(function(){addMpSel(add_codes[t],t);},300);
	}
	fixPage();
}
function serTemp(t,txt){$('#pm_src').val(txt);addMpSelTempSr(t);}
function setEnterButt(t,n){
	$('.prvlBlc [inpu][t='+t+'][n='+n+'] [intxt]').keypress(function(e){
		var key = e.which;
		if(key==13){mp_in_save(t,n);}
	});   
}
function mp_in_set(t,n){
	$('div[inpu][t='+t+'][n='+n+'] [save]').click(function(){mp_in_save(t,n);})
	$('div[inpu][t='+t+'][n='+n+'] [close]').click(function(){mp_in_close(t,n);})
}
function mp_in_close(t,n){
	$('div[inpu][t='+t+'][n='+n+']').remove();
	$('.prvlBlc [item][t='+t+'][n='+n+']').show();
}
function mp_del(t,n){
	$('.prvlBlc [item][t='+t+'][n='+n+']').css('background-color','#f99');
	$('.prvlBlc [item][t='+t+'][n='+n+'] [tool]').hide();
	$.post(addPath+'prv_list_del.php',{vis:visit_id,t:t,id:n},function(data){
		d=GAD(data);		
		if(d==1){
			$('.prvlBlc [item][t='+t+'][n='+n+']').remove();
		}else{
			nav(3,'حدث خطأ بالإدخال');
			$('.prvlBlc [item][t='+t+'][n='+n+'][tool]').show();
		}
		fixPage();
		fixForm();
		blcTotal();
	})
}
function mp_in_save(t,n,val=''){
	if(val==''){val=$('div[inpu][t='+t+'][n='+n+'] [intxt]').html();}
	if(val==''){
		nav(3,'لايوجد بيانات مدخلة');
		$('.prvlBlc div[in='+t+']').focus();
	}else{
		$('.prvlBlc [inpu][t='+t+'][n='+n+']').hide();
		if(n==0){
			$('.prvlBlc [items][t='+t+']').append(loader_win);			
		}else{
			$('.prvlBlc [item][t='+t+'][n='+n+']').after(loader_win);
		}
		//itmFocus($('.prvlBlc [item][t='+t+'][n]').last());		     
		$.post(addPath+'prv_list_add.php',{vis:visit_id,t:t,id:n,val:val},function(data){
			d=GAD(data);
			dd=d.split(',');
			if(dd.length==3){
				if(dd[0]){
					mp_in_save_end(t,n,dd[1],dd[2]);				
				}else{
					nav(3,'حدث خطأ بالإدخال');
					$('.prvlBlc [inpu][t='+t+'][n='+n+']').show();
				}
			}
			mp_resetSer(t);
			fixPage();
			fixForm();
		})
	}
}
function mp_in_save_end(t,n,id,txt){	
	out='<div item t="'+t+'" n="'+id+'" set="0"><div class="fr" tool ><div class="fl i30 i30_edit" title="تحرير" edit></div><div class="fl i30 i30_up" title="حفظ كنموذج" temp></div><div class="fl i30 i30_del" title="حذف" del></div></div><div txt class="fs12 pd10">'+txt+'</div></div>';
	$('.prvlBlc .loadeText').remove();
	$('.prvlBlc [inpu][t='+t+'][n='+n+']').remove();
	if(n==0){
		$('.prvlBlc[blc='+t+'] div[items]').append(out);
		blc=$('.prvlBlc [item][t='+t+'][n='+id+']');
		flashBlc(blc);
		itmFocus(blc);
		mp_it_set();
		if(dirInter==0 || tmpClic==0){
			mp_in(t,0);
		}
		tmpClic=0;
	}else{
		$('.prvlBlc [item][t='+t+'][n='+n+'] [txt]').html(txt);
		$('.prvlBlc [item][t='+t+'][n='+n+']').show();
		
	}
	blcTotal();
}
function addMpSelTempSr(t){
	clearTimeout(sr_mp);
	sr_mp=setTimeout(function(){addMpSelTemp(t,0);},800);
}
function addMpSelTemp(t,r){
	actRecN=r;
	sr=$('#pm_src').val();	
	if(r==0){$('#mp_ItData').html(loader_win);}
	$.post(addPath+"prv_mp_list_items.php",{vis:visit_id,t:t,r:r,sr:sr},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
			$('#mp_ItTot').html(dd[0]);
			if(r==0){
				$('#mp_ItData').html(dd[1]);
			}else{
				$('#mp_ItData').append(dd[1]);
				$('#mp_ItData .loadeText').remove();
			}
		}else{
			$('#mp_ItTot').html('');
			$('#mp_ItData').html('');
		}
		mpTemSet(t);
		fixPage();
		fixForm();
	})
}
function mpTemSet(t){
	item=$('#mp_ItData > div[set=0]');
	item.click(function(){
		tmpClic=1;
		tn=$(this).attr('tn');
		inTxt=$(this).attr('val');
		mp_tmp_count(t,tn);
		if(dirInter==1){
			//mp_in(t,0,inTxt);
			mp_in_save(t,0,inTxt);
		}else{
			mp_in(t,0,inTxt);			
		}
		mp_resetSer(t);	
		
	})
	item.find('[deltmp]').click(function(e){
		e.stopPropagation();
		tn=$(this).closest('[tn]').attr('tn');
		mp_tmp_del(t,tn);
	})
	
	item.find('[edittmp]').click(function(e){
		e.stopPropagation();
		tn=$(this).closest('[tn]').attr('tn');
		mp_tmp_edit(t,tn);		
	})
	$('#mp_ItData [loadMore]').click(function(e){
		actRecN++;
		$('#mp_ItData').append(loader_win);
		$(this).remove();
		addMpSelTemp(t,actRecN);
	})
	item.attr('set','1');
}
function mp_resetSer(t){
	s=$('#pm_src').val();
	if(s!=''){
		$('#pm_src').val('');
		addMpSelTempSr(t,0);
	}
}
function mp_tmp_count(t,id){
	$.post(addPath+"prv_mp_list_items_count.php",{t:t,id:id},function(data){})
}
function mp_tmp_del(t,n){
	$('#mp_ItData [tn='+n+']').hide();
	$('#mp_ItData [tn='+n+']').after(loader_win);
	$.post(addPath+"prv_mp_list_items_del.php",{t:t,id:n},function(data){
		ds=GAD(data);
		if(ds==1){txt='تم الحذف';clr=clr666;}else{txt='حدث خطاء ';clr=clr555;}
		$('#mp_ItData .loadeText').html(txt);
		$('#mp_ItData .loadeText').css('background-color',clr);
		setTimeout(function(){			
			$('#mp_ItData .loadeText').remove();			
			if(ds==1){
				$('#mp_ItData [tn='+n+']').remove();				
			}else{
				$('#mp_ItData [tn='+n+']').show();
			}
		},2000);
		fixPage();
		fixForm();
	})
}
function mp_tmp_edit(t,n){
	$('#mp_ItData [tn='+n+']').hide();
	val=$('#mp_ItData [tn='+n+']').attr('val');	
	tmpIn='<div tne="'+n+'"><div class="mg10 f1 fs14 clr1" tit ><div class="fl" contenteditable="true" inTxt fix="wp:0">'+val+'</div></div><div class=" lh30 fs16 ff B b_bord pd10" ><div class="i30 i30_del fr" cancelTmp title="'+k_cancel+'"></div><div class="i30 i30_done fl" saveTmp title="'+k_save+'"></div></div></div>';	
	$('#mp_ItData [tn='+n+']').after(tmpIn);
	fixPage();
	item=$('#mp_ItData > div[tne='+n+']');
	item.find('[cancelTmp]').click(function(e){				
		$('#mp_ItData [tne='+n+']').remove();
		$('#mp_ItData [tn='+n+']').show();
	})	
	item.find('[saveTmp]').click(function(e){		
		val=item.find('[intxt]').html();
		mp_tmp_edit_save(t,n,val);
	})
	item.find('[intxt]').keypress(function(e){
		var key = e.which;
		val=item.find('[intxt]').html();
		if(key==13){mp_tmp_edit_save(t,n,val);}
	});  
	
}
function mp_tmp_edit_save(t,n,val){
	$('#mp_ItData [tne='+n+']').hide();
	$('#mp_ItData [tne='+n+']').after(loader_win);
	$.post(addPath+"prv_mp_list_items_edit.php",{t:t,id:n,val},function(data){
		ds=GAD(data);
		if(ds==1){txt='تم التعديل';clr=clr666;}else{txt='حدث خطاء ';clr=clr555;}
		$('#mp_ItData .loadeText').html(txt);
		$('#mp_ItData .loadeText').css('background-color',clr);
		setTimeout(function(){			
			$('#mp_ItData .loadeText').remove();
			$('#mp_ItData [tn='+n+']').attr('val',val);
			$('#mp_ItData [tn='+n+'] [tit]').html(val);
			$('#mp_ItData [tn='+n+']').show();
			if(ds==1){
				$('#mp_ItData [tne='+n+']').remove();				
			}else{
				$('#mp_ItData [tne='+n+']').show();
			}
		},2000);
		fixPage();
		fixForm();
	})
}
function mp_tmp_save(t,n){
	$('.prvlBlc [item][t='+t+'][n='+n+']').hide();
	$('.prvlBlc [item][t='+t+'][n='+n+']').after(loader_win);
	$.post(addPath+'prv_mp_list_items_save.php',{t:t,id:n}, function(data){
		d=GAD(data);
		if(d==1){txt='تم الحفظ';clr=clr666;}else{txt='حدث خطاء ';clr=clr555;}
		$('.prvlBlc .loadeText').html(txt);
		$('.prvlBlc .loadeText').css('background-color',clr);
		setTimeout(function(){			
			$('.prvlBlc .loadeText').remove();
			$('.prvlBlc [item][t='+t+'][n='+n+']').show();
			if(d==1){
				if(actMp!=add_codes[t]){
					addMpSel(add_codes[t],t);
				}else{
					addMpSelTemp(t,0);
				}
			}
		},2000);
		fixPage();
		fixForm();
	})
}
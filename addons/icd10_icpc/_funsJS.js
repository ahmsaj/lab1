/***icd10_icpc***/
var addPath2=f_path+"Add.icd10_icpc/";
var sr_ic='';
var actRecN=0;
var actMp='';
var add_codes2=new Array('','icd','icp');
function icd_it_set(){
	item=$('.prvlBlc [ic_item][set=0]');
	item.find('[del]').click(function(){
		t=$(this).closest('[ic_item]').attr('t');
		n=$(this).closest('[ic_item]').attr('n');
		o=$(this).closest('[ic_item]').attr('opr');
		icd_del(t,n,o);
	})	
	item.attr('set','1');
	$('.prvlBlc [addIc]').click(function(){
		t=$(this).attr('t');
		openBlock(add_codes2[t]);
		if(actMp!=add_codes2[t]){icd_sel(add_codes2[t],t);}	
	})
}
function icd_sel(code,t){
	actRecN=0;
	actMp=code;
	prvLoader(1);
	$.post(addPath2+"icd_list.php",{vis:visit_id,t:t},function(data){
		d=GAD(data);
		loadPrvData(code,d);
		prvLoader(0);
		$('#pm_src').keyup(function(){icd_it_sr(t,0);})
		icd_it(t,0);
		$('#addCat').change(function(){
			icd_it(t,actRecN);
		})
		fixPage();
		fixForm();
	})
}
function icd_it_sr(t){clearTimeout(sr_ic);sr_ic=setTimeout(function(){icd_it(t,0);},800);}
function icd_it(t,r){
	actRecN=r;
	sr=$('#pm_src').val();
	ic_cat=$('#addCat').val();
	if(r==0){$('#mp_ItData').html(loader_win);}
	$.post(addPath2+"icd_list_items.php",{vis:visit_id,t:t,r:r,sr:sr,cat:ic_cat},function(data){
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
		icd_set(t);
		fixPage();
		fixForm();
	})
}
function icd_set(t){
	item=$('#mp_ItData > div[set=0]');
	item.click(function(){		
		ic=$(this).attr('ic');
		inTxt=$(this).attr('val');
		code=$(this).attr('code');
		openBlock(add_codes2[t]);
		icd_save(t,ic,code,inTxt);
		icd_resetSer(t);		
	})	
	$('#mp_ItData [loadMore]').click(function(e){
		actRecN++;
		$('#mp_ItData').append(loader_win);
		$(this).remove();
		icd_it(t,actRecN);
	})
	item.attr('set','1');
}
function icd_save(t,n,code,val){
	$('#mp_ItData [ic='+n+']').hide(300);
	$('[ic_items][t='+t+']').append(loader_win);
	//itmFocus($('[ic_item][t='+t+'][n]').last());
	$.post(addPath2+"icd_list_items_save.php",{vis:visit_id,t:t,id:n},function(data){
		di=GAD(data);
		if(di){
			$('[ic_blc='+t+'] .loadeText').remove();
			itemTxt='<div ic_item t="'+t+'" n="'+di+'" opr="'+n+'" set="0"><div class="fr" tool ><div class="fl i30 i30_del" title="حذف" del></div></div><div txt class="fs12 pd10"><ff>'+code+' | </ff>'+val+'</div></div>';
			$('[ic_blc='+t+'] [ic_items]').append(itemTxt);
			blcTotal();
			blc=$($('[ic_item][t='+t+'][n='+di+']'));
			flashBlc(blc);
			itmFocus(blc);
			icd_it_set();
		}else{
			$('#mp_ItData [ic='+n+']').show(300);
			$('[ic_blc='+t+'] .loadeText').html('حدث خطاء ');
			$('[ic_blc='+t+'] .loadeText').css('background-color',clr555);
			setTimeout(function(){			
				$('[ic_blc='+t+'] .loadeText').remove();
			},2000);
		}
		fixPage();
		fixForm();
	})
}
function icd_resetSer(t){
	s=$('#pm_src').val();
	if(s!=''){
		$('#pm_src').val('');
		icd_it(t,0);
	}
}
function icd_del(t,n,o){
	$('.prvlBlc [ic_item][t='+t+'][n='+n+']').css('background-color','#f99');
	$('.prvlBlc [ic_item][t='+t+'][n='+n+'] [tool]').hide();
	$.post(addPath2+'icd_del.php',{vis:visit_id,t:t,id:n},function(data){
		d=GAD(data);		
		if(d==1){
			$('.prvlBlc [ic_item][t='+t+'][n='+n+']').remove();
			$('#mp_ItData[t='+t+'] [ic='+o+']').show(300);
			blcTotal();
		}else{
			nav(3,'حدث خطأ بالإدخال');
			$('.prvlBlc [ic_item][t='+t+'][n='+n+'][tool]').show(300);
		}
		fixPage();
		fixForm();
	})
}
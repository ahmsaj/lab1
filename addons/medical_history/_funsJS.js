/***medical_history***/
var addPath3=f_path+"Add.medical_history/";
var sr_his='';
var actRecN=0;
function his_sel(code){
	actRecN=0;	
	prvLoader(1);
	$.post(addPath3+"his_list.php",{vis:visit_id,pat:patient_id},function(data){
		d=GAD(data);
		loadPrvData(code,d);
		prvLoader(0);
		$('#his_src').keyup(function(){his_it_sr(0);})		
		$('#addCat').change(function(){his_it(0);})
		his_it(0);
		fixPage();
		fixForm();
	})
}
function his_it_sr(){clearTimeout(sr_his);sr_his=setTimeout(function(){his_it(0);},800);}
function his_it(r){
	actRecN=r;
	sr=$('#his_src').val();
	his_cat=$('#addCat').val();
	if(r==0){$('#his_ItData').html(loader_win);}
	$.post(addPath3+"his_list_items.php",{vis:visit_id,r:r,sr:sr,cat:his_cat},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
			$('#his_ItTot').html(dd[0]);
			if(r==0){
				$('#his_ItData').html(dd[1]);
			}else{
				$('#his_ItData').append(dd[1]);
				$('#his_ItData .loadeText').remove();
			}
		}else{
			$('#his_ItTot').html('');
			$('#his_ItData').html('');
		}
		his_set();
		fixPage();
		fixForm();
	})
}
function his_set(t){
	item=$('#his_ItData > div[set=0]');
	item.click(function(){		
		ih=$(this).attr('ih');		
		his_resetSer();		
		loadHisIt(ih,0);
	})	
	$('#his_ItData [loadMore]').click(function(e){
		actRecN++;
		$('#his_ItData').append(loader_win);
		$(this).remove();
		his_it(actRecN);
	})
	$('#his_ItData [hisCat]').click(function(){
		cat=$(this).attr('hisCat');
		$("#addCat").val(cat);
		his_it(actRecN);
	})
	$('[addHisNIt]').click(function(){		
		cat=$('#addCat').val();
		src=$('#his_src').val();
		addNewHIt(cat,src);
	})
	item.attr('set','1');
}
function addNewHIt(cat,src){
	it='';
	if(cat!=0){it='cat:'+cat+':h';}
	//if(src){it+='name_'+lg+':'+src;}
	co_loadForm(0,3,"sd53d8g39x|id|loadHisIt([id],0)|"+it);	
}
function his_resetSer(t){
	s=$('#his_src').val();
	if(s!=''){$('#his_src').val('');his_it(0);}
}
function loadHisIt(itId,id){
	winTitle='إضافة عنصر للتاريخ الطبي ';
	if(id>0){winTitle='تحرير عنصر للتاريخ الطبي ';}
	inWin(winTitle);
	$.post(addPath3+"his_list_items_add.php",{vis:visit_id,itId:itId,id,id},function(data){
		d=GAD(data);
		inWin(0,d);
		loadFormElements('#mHis');			
		setupForm('mHis','');
		$('#saveHis').click(function(){sub('mHis');});
		fixPage();
		fixForm();
	})
}
function viewMHis(){
	inWinClose();
	$('[his_items]').html(loader_win);
	$.post(addPath3+"his_list_items_show.php",{vis:visit_id,pat:patient_id},function(data){
		d=GAD(data);
		$('[his_items]').html(d);
		setHisItemsIn();
		fixPage();
		fixForm();
	})
}
function setHisItemsIn(){
	$('[addMHis][set=0]').click(function(){	
		openBlock('his');
		his_sel('his');
		$(this).attr('set','1');
	})	
	$('[mhit] [edthis]').click(function(){
		no=$(this).closest('[mhit]').attr('no');
		loadHisIt(0,no);
	})
	$('[mhit] [delhis]').click(function(){
		no=$(this).closest('[mhit]').attr('no');
		delHisIt(no);
	})
}
function delHisIt(id){
	$('[his_items]').html(loader_win);
	$.post(addPath3+"his_list_items_del.php",{vis:visit_id,pat:patient_id,id:id},function(data){
		d=GAD(data);
		$('[his_items]').html(d);
		viewMHis();
		fixPage();
		fixForm();
	})
}

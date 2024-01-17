/***growth_indicators***/
var addPath5=f_path+"Add.growth_indicators/";
var sr_ic='';
var actRecN=0;
var actMp='';
var actGI=0;
var giCode='ww0i5f8nzz';
var giSCode='grw';
function gi_it_set(){
	if($('.prvlBlc [addgi]').length>0){
		$('.prvlBlc [addgi]').click(function(){
			t=$(this).attr('t');
			openBlock(giSCode);
			if(actMp!=giSCode){gi_sel(giSCode);}
			gi_add();			
		})
	}
	gi_itRep_set();
}
function gi_itRep_set(){
	$('.prvlBlc [ch]').click(function(){	
		n=$(this).attr('ch');
		giViewChart(n);
	})
	$('.prvlBlc [patGi]').click(function(){editPatinfo();})
	$('.prvlBlc [giInfo]').click(function(){
		n=$(this).attr('giInfo');
		if(actMp!=giSCode){
			gi_sel(giSCode,n);
		}else{
			gi_sel_it(n);
		}
	})
}
function gi_sel(code,act=0){
	actRecN=0;
	actMp=code;
	prvLoader(1);
	$.post(addPath5+"gi_list.php",{vis:visit_id},function(data){
		d=GAD(data);
		loadPrvData(code,d);
		prvLoader(0);
		gi_sel_it(act);		
		fixPage();
		fixForm();		
	})
}
function gi_sel_it(act=0){
	$('#gi_ItTot').html('');
	$('#gi_ItData').html(loader_win);
	$.post(addPath5+"gi_list_items.php",{vis:visit_id,pat:patient_id,act:act},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
			$('#gi_ItTot').html(dd[0]);
			$('#gi_ItData').html(dd[1]);			
		}else{
			$('#gi_ItTot').html('');
			$('#gi_ItData').html('');
		}
		gi_set();
		$('#gi_ItData').attr('set','0');
		if(act!=0){gi_view(act);}
		fixPage();
		fixForm();
	})
}
function gi_set(){
	item=$('#gi_ItData > div[set=0]');
	item.click(function(){		
		gi=$(this).attr('gi');
		gi_view(gi);
	})
	$('#listSec [addgi]').click(function(e){gi_add();})
	item.attr('set','1');
}
function gi_add(gi_id=0){
	inWin();	
	$.post(addPath5+"gi_list_items_add.php",{vis:visit_id,pat:patient_id,id:gi_id},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
			inWin(dd[0],dd[1]);
			giAdd_set();
			giAdd_set_item();
			setupForm('growAdd','');
			fixPage();
			fixForm();
		}
	})
}
function giAdd_set(){
	$('#gi_ItData [gi_but]').click(function(){
		n=$(this).attr('gi_but');		
		$('[gi_but='+n+']').hide(300);
		$('#gi_table').append(loader_win);
		getGiIt(n);
	})
	$('[giSave]').click(function(){sub('growAdd');})	
}
function giAdd_set_item(){
	$('#gi_table [giDn][set=0]').click(function(){
		n=$(this).attr('giDn');
		$(this).closest('tr').remove();
		$('[gi_but='+n+']').show(300);		
	})
	$('#gi_table [giDn][set=0]').attr('set','1');	
	$('#gi_table [giIn][set=0]').keyup(function(){
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
		if(stat=='n'){$(this).css('background-color',clr666);}
		if(stat=='x'){$(this).css('background-color',clr555);}
		if(stat==''){$(this).css('background-color','');}
	})
	$('#gi_table [giIn][set=0]').attr('set','1');
}
function getGiIt(n){
	$.post(addPath5+"gi_list_add_item.php",{vis:visit_id,pat:patient_id,id:n},function(data){
		d=GAD(data);
		$('#gi_table .loadeText').remove();
		$('#gi_table').append(d);
		giAdd_set_item();
	})
}
function gi_save_cb(id){gi_sel_it(id);giVeiwIn();}
function gi_view(gi_id){
	actGI=gi_id;
	inWin(k_ses_det);
	$.post(addPath5+"gi_list_items_view.php",{vis:visit_id,pat:patient_id,id:gi_id},function(data){
		d=GAD(data);
		inWin('',d);
		fixPage();
		fixForm();
		$('[giVdel]').click(function(){open_alert(actGI,'cln_gi','هل تود حذف جلسة القياس','حذف جلسة القياس');})
		$('[giVedit]').click(function(){gi_add(actGI);})			
	})
}
function GISec_del_do(id){
	inWin('',loader_win);
	$.post(addPath5+"gi_list_items_del.php",{vis:visit_id,pat:patient_id,id:id},function(data){
		d=GAD(data);
		if(d==1){			
			gi_sel_it();			
			giVeiwIn();
			inWinClose();			
		}
		fixPage();
		fixForm();			
	})
}
function giVeiwIn(){
	$('[blccon=grw]').html(loader_win);
	$.post(addPath5+"gi_veiw.php",{vis:visit_id,pat:patient_id},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
			$('[giTot]').html(dd[0]);
			$('[blccon=grw]').html(dd[1]);
			gi_itRep_set();
			//gi_sel(giCode);
			blcTotal();
			fixPage();
			fixForm();
		}
	})
}
function giViewChart(type){
	inWin('');
	$.post(addPath5+"gi_list_items_chart.php",{vis:visit_id,pat:patient_id,type:type},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
	;		inWin(dd[0],dd[1]);
			fixPage();
			fixForm();
		}
	})
}
function editPatinfo(){
	inWin();
	$.post(addPath5+"gi_pat_info.php",{vis:visit_id,pat:patient_id},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
			inWin(dd[0],dd[1]);
			giAdd_set_item();
			loadFormElements('#patInfo');
			setupForm('patInfo');
			$('[giPatSave]').click(function(){sub('patInfo');})
			fixPage();
			fixForm();
		}
	})
}
function gi_pat_cb(){inWinClose();giVeiwIn();}
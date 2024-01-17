/***vital_signs***/
var addPath4=f_path+"Add.vital_signs/";
var sr_ic='';
var actRecN=0;
var actMp='';
var actVS=0;
var vsCode='ww0i5f8nzz';
var vsSCode='vit';
var addVSOpen=0;
var addVs=0;
function vs_it_set(){
	if($('.prvlBlc [addvs]').length>0){
		$('.prvlBlc [addvs]').click(function(){
			t=$(this).attr('t');
			openBlock(vsSCode);
			if(actMp!=vsSCode){vs_sel(vsSCode);addVs=1;}else{vs_add();}
		})	
	}
	vs_itRep_set();
}
function vs_itRep_set(){
	$('.prvlBlc [vsRep]').click(function(){	
		n=$(this).attr('vsRep');
		vsViewChart(n);
	})
}
function vs_sel(code,act=0){
	actRecN=0;
	actMp=code;
	prvLoader(1);
	$.post(addPath4+"vs_list.php",{vis:visit_id},function(data){
		d=GAD(data);
		loadPrvData(code,d);
		prvLoader(0);
		vs_sel_it(act);		
		fixPage();
		fixForm();
		if(addVs==1){vs_add();addVs=0;}
	})
}
function vs_sel_it(act=0){
	$('#vs_ItTot').html('');
	$('#vs_ItData').html(loader_win);
	$.post(addPath4+"vs_list_items.php",{vis:visit_id,pat:patient_id,act:act},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
			$('#vs_ItTot').html(dd[0]);
			$('#vs_ItData').html(dd[1]);			
		}else{
			$('#vs_ItTot').html('');
			$('#vs_ItData').html('');
		}
		vs_set();
		$('#vs_ItData').attr('set','0');
		if(act!=0){vs_view(act);}
		fixPage();
		fixForm();
	})
}
function vs_set(){
	item=$('#vs_ItData > div[set=0]');
	item.click(function(){		
		vs=$(this).attr('vs');
		vs_view(vs);		
	})	
	$('#listSec [addvs]').click(function(e){vs_add();})
	item.attr('set','1');
}
function vs_add(vs_id=0){
	inWin();
	$('#vs_ItTot').html('');
	$('#vs_ItData').html(loader_win);
	addVSOpen=1;
	$.post(addPath4+"vs_list_items_add.php",{vis:visit_id,pat:patient_id,id:vs_id},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==4){			
			$('#vs_ItTot').html(dd[0]);
			$('#vs_ItData').html(dd[1]);
			$('#exWin').click(function(){
				if(addVSOpen==1){
					vs_sel(vsCode);
					addVSOpen=0;
				}
			});
			inWin(dd[2],dd[3]);
			vsAdd_set();
			vsAdd_set_item();
			setupForm('vitalAdd','');
			fixPage();
			fixForm();
		}
	})
}
function vsAdd_set(){
	$('#vs_ItData [vs_but]').click(function(){
		n=$(this).attr('vs_but');		
		$('[vs_but='+n+']').hide(300);
		$('#vs_table').append(loader_win);
		getVsIt(n);
	})
	$('[vsSave]').click(function(){vsSave();})	
}
function vsAdd_set_item(){
	$('#vs_table [vsDn][set=0]').click(function(){
		n=$(this).attr('vsDn');
		$(this).closest('tr').remove();
		$('[vs_but='+n+']').show(300);		
	})
	$('#vs_table [vsDn][set=0]').attr('set','1');	
	$('#vs_table [vsIn][set=0]').keyup(function(){
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
	$('#vs_table [vsIn][set=0]').attr('set','1');
}
function getVsIt(n){
	$.post(addPath4+"vs_list_add_item.php",{vis:visit_id,pat:patient_id,id:n},function(data){
		d=GAD(data);
		$('#vs_table .loadeText').remove();
		$('#vs_table').append(d);
		vsAdd_set_item();
	})
}
function vsSave(){
	err='';
	if($('input[nv1]').length>0){		
		$('input[nv1]').each(function(){
			if($(this).val()==''){err='يجب ملئ جميع الحقول';}
		})
	}else{
		err='يجب إضافة مؤشر واحد على الاقل';
	}
	if(err){
		nav(1,err);
	}else{
		sub('vitalAdd');
	}
}
function vs_save_cb(id){vs_sel(vsCode,id);vsVeiwIn();}
function vs_view(vs_id){
	actVS=vs_id;
	inWin(k_ses_det);
	$.post(addPath4+"vs_list_items_view.php",{vis:visit_id,pat:patient_id,id:vs_id},function(data){
		d=GAD(data);
		inWin('',d);
		fixPage();
		fixForm();
		$('[vsVdel]').click(function(){open_alert(actVS,'cln_vs','هل تود حذف جلسة القياس','حذف جلسة القياس');})
		$('[vsVedit]').click(function(){vs_add(actVS);})			
	})
}
function vitalSec_del_do(id){
	inWin('',loader_win);
	$.post(addPath4+"vs_list_items_del.php",{vis:visit_id,pat:patient_id,id:id},function(data){
		d=GAD(data);
		if(d==1){
			vs_sel(vsCode);
			inWinClose();
			vsVeiwIn();
		}
		fixPage();
		fixForm();			
	})
}
function vsVeiwIn(){
	$('[blccon=vit]').html(loader_win);
	$.post(addPath4+"vs_veiw.php",{vis:visit_id,pat:patient_id},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
			$('[vsTot]').html(dd[0]);
			$('[blccon=vit]').html(dd[1]);
			vs_itRep_set();
			vs_sel(vsCode);
			blcTotal();
			fixPage();
			fixForm();
		}
	})
}
function vsViewChart(id){
	inWin('');
	$.post(addPath4+"vs_list_items_chart.php",{vis:visit_id,pat:patient_id,id:id},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
	;		inWin(dd[0],dd[1]);
			fixPage();
			fixForm();
		}
	})
}
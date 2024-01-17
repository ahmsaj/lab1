/***ACC***/
function addSrvToAcc(id=0){
	actOfferSet=id;
	loadWindow('#m_info2',1,'',400,600);
	$.post(f_path+"X/acc_srv_add.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info2').html(d);		
		setupForm('accSrv','m_info2');		
		//setOPSet();
		fixForm();
		fixPage();	
	})
}
function selclicCatAcc(t,mood,id=''){
	if(mood==0){
		$('#subcT1').html('');
		$('#subcT2').html('');
		$('#subcT3').html('');		
	}else{		
		if(t==1){
			$('#subcT2').html('');			
		}
		if(t==3){			
			$('#subcT3').show();
		}else{
			$('#subcT'+t).html(loader_win);
			$('#subcT3').hide();
			$.post(f_path+"X/acc_srv_sub.php",{id:id,mood:mood,t:t}, function(data){
				d=GAD(data);
				$('#subcT'+t).html(d);				
				fixForm();
				fixPage();
			})
		}
	}
}
function accSelSrv(type){
	acc_m=$('[name=acc_m]').val();
	acc_n=$('[name=acc_n]').val();
	cost=$('[name=cost]').val();
	if(acc_m!='' && acc_n!='' && cost!=''){
		sub('accSrv');
	}else{
		nav(3,'يجب ملء كافة الحقول');
	}
}

var actBOs='';
function setBoxOpr(){
	loadBo('dash');
	refPage('gnr_box',10000);	
	$('.bo_oprs > div').click(function(){
		boCode=$(this).attr('code');		
		loadBo(boCode);
	})
}
function box_opr_ref(l=0){
	if(actBOs=='dash'){loadBo('dash',0,0);}
}
function loadBo(code,l=1){
	actBOs=code;
	$('.bo_oprs > div').removeAttr('act');
	$('.bo_oprs > div[code='+code+']').attr('act','');
	if(l==1){$('#bo_dets').html(loader_win);}
	$.post(f_path+"X/acc_box_info.php",{code:code},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
			$('#bo_title').html(dd[0]);
			$('#bo_dets').html(dd[1]);
		}
		fixForm();
		fixPage();
	})	
}
function boxPayFix(id){
	loadWindow('#m_info',1,k_stm,500,0);	
	$.post(f_path+"X/acc_box_fix.php",{id:id}, function(data){
		d=GAD(data);
		$('#m_info').html(d);
		setupForm('for_box','m_info');
		loadFormElements('#for_box')	
		fixPage();
	})
}
function boReload(){loadBo(actBOs);}
function boxPay(box,amount){co_loadForm(0,3,"q8uc9l7htf||boReload()|box:"+box+":h,amount:"+amount);}
function addExpen(){co_loadForm(0,3,"dutuht1wyf||boReload()|");}
function addBoxOprs(){co_loadForm(0,3,"q48u9d8o1||boReload()|");}
function boxOpr(pt,t,src=0){
	loadWindow('#m_info',1,'إجراءات الصندوق',500,0);	
	$.post(f_path+"X/acc_box_pay_add.php",{pt:pt,t:t,src:src}, function(data){
		d=GAD(data);
		$('#m_info').html(d);
		setupForm('boxpay','m_info');		
		fixPage();
	})
}

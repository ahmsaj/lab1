/***DTS***/
var actSelClinc=0;
var actSelDate=0;
var daPa_ser;
var actSelDoc=0;
$(document).ready(function(){
    if(sezPage=='Setup-app-dates-discount'){setAppDts();}
    if(sezPage=='Correcting-app-discounts'){setDisfix();}
})
function selDtSrvs(clc_n,dts,pat){
	loadWindow('#m_info',1,'خدمات الموعد',600,200);
	$.post(f_path+"X/dts_new_service.php",{c:clc_n,d:dts,p:pat},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		loadFormElements('#n_date');		
		setupForm('n_date','m_info');
		sers_dt_set();		
		fixForm();
		fixPage();
		serTotalDaCount();
		//if(act_clinic_type==1 || act_clinic_type==5){
			$('#servSelSrch').focus();
			$('#servSelSrch').keyup(function(){serServList();})
		//}
	})
}
function sers_dt_set(){
	$('div[par=ceckServDt]').click(function(){serTotalDaCount();});
	$('div[par=ceckServDtOSC]').click(function(){sub('n_date');});
	actClanType=4;
	$('div[teethTime]').click(function(){
		tTime=$(this).attr('teethTime');
		$('#teethTime').val(tTime);
		sub('n_date');
	})	
}
function serTotalDaCount(){
	save=0;
	total=0;
	$('div[par=ceckServDt]').each(function(index, element) {
        v=parseInt($(this).attr('ch_val'));
		ch=$(this).children('div').attr('ch');
		if(ch=='on'){total+=v;save=1;}		
    });
	$('#serTotal').html(total);	
	if(save==1){$('#saveButt').show(200);}else{$('#saveButt').hide(200);}	
}
function selDate(id){
	actSelDate=id;
	actSelDoc=0;
	loadWindow('#full_win1',1,'الموعد',600,200);
	$.post(f_path+"X/dts_new_date.php",{id:id},function(data){
		d=GAD(data);
		$('#full_win1').html(d);
		loadDaSc(0);
		$('.dat_list').click(function(){changDocDt($(this).attr('no'));})
		fixForm();
		fixPage();
	})
}
function changDocDt(id){
	actSelDoc=id;
	$('.dat_list').removeAttr('act');
	$(".dat_list[no="+id+"]").attr('act','1');
	loadDaSc(0);
}
function loadDaSc(n){
	if(n==0){$('.dt_bd').html('<div class="lh40">'+loader_win+'</div>');}
	$('#dts_dt_load').html('<div class="lh40">'+loader_win+'</div>');
	if(n==0){$('.dt_point').html('<div class="lh30">'+loader_win+'</div>');}
	$.post(f_path+"X/dts_new_date_list.php",{id:actSelDate,n:n,d:actSelDoc},function(data){
		d=GAD(data);	
		if(n==0){
			dd=d.split('^');			
			$('.dt_point').html(dd[0]);
			$('.dt_bd').html(dd[1]);			
		}else{
			$('#dts_dt_load').replaceWith(d);
		}
		dt_set();
		fixForm();		
	})
}
function dt_set(){
	$('.dblc_1[set=0]').click(function(){
		sd=$(this).attr('s');
		ed=$(this).attr('e');
		selEmptyArea(actSelDate,sd,ed);
		$(this).attr('set','1');
	})
}
function selEmptyArea(d,s,e){
	loadWindow('#m_info2',1,'تحديد الزمن',600,200);
	$.post(f_path+"X/dts_new_date_in.php",{d:d,s:s,e:e,doc:actSelDoc},function(data){
		d=GAD(data);
		$('#m_info2').html(d);
		setSlider();		
		loadFormElements('#n_d_d');		
		setupForm('n_d_d','m_info2');
		fixForm();
		fixPage();		
	})
}
function setSlider(){
	sliderM=parseInt($("#dSlid").css('left',0));
	dslide=$('#slidBar').width()-20;
	ta=parseInt($('#slidBar').attr('ta'));//total time by mints
	tn=parseInt($('#slidBar').attr('tn'));//this block time by mints	
	ts=parseInt($('#slidBar').attr('ts'));//time steps
	th=parseInt($('#slidBar').attr('th'));//block time statr by secunds
	slideIN=tn*dslide/ta;	
	if(tn==ta){slideIN=dslide;}	
	$("#dSlid").width(slideIN);
	$("#dSlid").draggable({
		axis: "x",drag: function(){cal_sliderTime();},        
	});
	$("#dSlid").draggable({ containment: "parent" });	
}
function cal_sliderTime(){
	sliderM=parseInt($("#dSlid").css('left'));
	if(sliderM<0){sliderM=sliderM*(-1);}
	mitLp=sliderM/dslide*ta;	
	s_block=th+(parseInt(Math.round(mitLp/ts))*ts)*60;
	e_block=s_block+(tn*60);
	$(".slidBar_t").html('<div class="fl">'+clockStr(s_block,1)+'</div>');	
	$('#ds').val(s_block);
	$('#de').val(e_block);
}
function selDaPat(id,t,type){
	actSelDate=id;
	winTitle='تحديد المريض';
	if(t==2){winTitle='تثبيت المريض';}
	loadWindow('#m_info',1,winTitle,www,hhh);
	$.post(f_path+"X/dts_new_patient.php",{id:id,t:t},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		$('input[ser_p][focus]').focus();
		setDaPat(t,type);
		fixForm();
		fixPage();		
	})
}
function setDaPat(t,type){
	$('input[ser_p]').keyup(function(){
		$('#daPatList').html(loader_win);
		clearTimeout(daPa_ser);
		daPa_ser=setTimeout(function(){setDaPatDo(t,type);},800);
	})
	setDaPatDo(t,type);
}
function checkDateStatus(s,id,t,type){
	if(s==1){
		selDaPat(id,t,type);
		win('close','#full_win1');
	}else{
		if(s.substr(0,1)=='x'){
			loader_msg(0,'');
			xErr=s.split('-');
			if(xErr.length==2){
				msg="مشكلة بإدخال البيانات";
				if(xErr[0]=='x1'){msg='يوجد تعارض مع الموعد رقم <ff> ( '+xErr[1]+' ) </ff>';}
				if(xErr[0]=='x2'){msg='لايتطابق الموعد مع الزمن المتاح للطبيب ';}
				if(xErr[0]=='x3'){msg='لا يجب ان يكون مجموع الدفعات اكبر من قيمة الخدمات';}
			}
			navC(4,msg,'#f99');
		}
	}
}
function setDaPatDo(t,type){
	$('#daPatList').html(loader_win);
	ser_par='';
	$('input[ser_p],select[ser_p]').each(function(){ 
		sp=$(this).attr('ser_p');
		s_val=$(this).val();
		if(ser_par!=''){ser_par+='|';}
		ser_par+=sp+':'+s_val;
	})
	
	$.post(f_path+"X/dts_new_patient_list.php",{d:actSelDate,pars:ser_par,t:t},function(data){
		d=GAD(data);
		$('#daPatList').html(d);
		fixForm();
		fixPage();
		$('.plistD > div[pn]').click(function(){
			pn=$(this).attr('pn');
			if(t==1){saveDaPa(actSelDate,pn,1);}
			if(t==2){addPatToDts(actSelDate,pn,type);}
		})
		$('.plistD > div[pn2]').click(function(){
			pn=$(this).attr('pn2');
			if(t==1){saveDaPa(actSelDate,pn,2);}
			//if(t==2){addPatToDts(actSelDate,pn,type);}
		})
	})
}
function saveDaPa(d_id,p,t){
	loader_msg(1,k_loading);
	$.post(f_path+"X/dts_new_patient_save.php",{d:d_id,p:p,t,t}, function(data){
		d=GAD(data);	
		if(d){
			msg=k_done_successfully;mt=1;
			win('close','#m_info');					
			loader_msg(0,msg,mt);
			if(d==1){dateINfo(actSelDate);}
			if(d==2){dateAsReview(actSelDate);}
			res_ref(1);
		}
	})
}
function dateAsReview(id){
	loadWindow('#m_info',1,'تعديل معلومات الموعد',500,300);
	$.post(f_path+"X/dts_change.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
}
function dateAsReviewSave(id){
	dTime=$('#dtsNewTime').val();
	loader_msg(1,k_loading);
	$.post(f_path+"X/dts_change_save.php",{id:id,dTime:dTime},function(data){
		d=GAD(data);		
		if(d==1){
			loader_msg(0,k_done_successfully,1);
            if(sezPage!='RespNew'){
                dateINfo(id);
                win('close','#m_info');
            }else{
			    dateInfoN(id);
            }
		}else{
			loader_msg(0,k_error_data,0);
		}
	})
}
function newPaDa(d,t,vals,type){
	if(t==1){co_loadForm(0,3,"u18qfm9oyb|id|saveDaPa("+d+",[id],2)|");}
	if(t==2){co_loadForm(0,3,"p7jvyhdf3|id|addPatToDts("+d+",[id],"+type+")|"+vals);}
}
function editDate(id){
	selDate(id);
}
function dateINfo(id){
	loadWindow('#m_info',1,'معلومات الموعد',600,300);
	$.post(f_path+"X/dts_info.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
}
function dtsBachTosrvs(id){
	win('close','#full_win1');
	selDtSrvs(0,id,0);
}
function dtsDel(id){
	open_alert(id,'dts_1','هل تود حذف هذا الموعد ؟','حذف الموعد');
}
function dtsDelDo(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/dts_delete.php",{id:id},function(data){
		d=GAD(data);		
		if(d==1){
            if(sezPage!='RespNew'){
                win('close','#full_win1');
			    win('close','#m_info');                
            }else{
                closeRecWin();
            }
			
			loader_msg(0,k_done_successfully,1);
		}else{
			loader_msg(0,k_error_data,0);
		}
	})	
}
function confirmDate(id,c_type){
	loader_msg(1,'جاري تأكيد حضور المريض');
	$.post(f_path+"X/dts_confirm.php",{id:id},function(data){
		d=GAD(data);		
		if(d>0){			
			loader_msg(0,k_done_successfully,1);
            actRecOpr=1;
			viSts(c_type,d);
		}else{
			loader_msg(0,k_error_data,0);
		}
	})	
}
function addPatToDts(d_id,pat,type){
	loader_msg(1,k_loading);
	$.post(f_path+"X/dts_add_patToDts.php",{id:d_id,p:pat},function(data){
		d=GAD(data);		
		if(d==1){
			win('close','#full_win1');
			win('close','#m_info');
			loader_msg(0,k_done_successfully,1);
			confirmDate(d_id,type)
		}else{
			loader_msg(0,k_error_data,0);
		}
	})	
}
function printDate(id){
	 printTicket(9,id);
}
function dtsCancel(id){co_loadForm(0,3,"fa4axv3mqg|id|fixCancelDate("+id+");|dts:"+id+":h",'','إلغاء الموعد');}
function fixCancelDate(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/dts_cancel_complete.php",{id:id},function(data){
		d=GAD(data);		
		if(d==1){			
			loader_msg(0,k_done_successfully,1);
			dateINfo(id);
		}else{
			loader_msg(0,k_error_data,0);
		}
	})	
}
function returnPayment(id){
	open_alert(id,'dts_2','هل تود إعادة قيمة الموعد ؟','ارجاع الدفعة');
}
function returnPaymentDo(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/dts_return_payment.php",{id:id},function(data){
		d=GAD(data);		
		if(d==1){			
			loader_msg(0,k_done_successfully,1);
			dateINfo(id);
		}else{
			loader_msg(0,k_error_data,0);
		}
	})
}
function showDtsClr(){
	loadWindow('#m_info',1,'ألوان المواعيد',400,200);
	$.post(f_path+"X/dts_color_info.php",{},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
}
function dtsApp(l){
	if(l==1){$('.centerSideIn').html(loader_win);}
	$.post(f_path+"X/dts_app_live.php",{},function(data){
		d=GAD(data);
		dd=d.split('^');
		$('#tot').html(dd[0]);
		$('.centerSideIn').html(dd[1]);
		fixPage();
	})
}
var actAppDts=0;
function confAppDts(id){actAppDts=id;loadWindowFull('X/dts_app_view','#m_info','مراجعة الموعد',id);}
function dtsAppAccp(opr){
	open_alert(opr,'dts_3','هل تود المتابعة ؟','مراجعة  الموعد');
}
function dtsAppAccpDo(opr){
	loader_msg(1,k_loading);
	$.post(f_path+"X/dts_app_end.php",{id:actAppDts,opr:opr},function(data){
		d=GAD(data);		
		if(d==1){			
			loader_msg(0,k_done_successfully,1);
			dtsApp(0);win('close','#m_info');
		}else{
			loader_msg(0,k_error_data,0);
		}
	})
}
/******************NewRec********************/
var actDtsDay=0;
var dtsInfoBasy=0;
function recNewDtsDoc(id,doc=0){
    actSelDate=id; 
	openRecWin('موعد جديد : الطبيب',1,1,2);
	$.post(f_path+"X/dts_rec_add_doc.php",{id:id,doc:doc}, function(data){
		d=GAD(data);
		$('.rwBody').html(d);
		fixObjects($('.rwBody'));		
		fixPage();
		fixForm();
	})
}
function recNewDtsDocDats(doc,n=0){
    actSelDoc=doc;
    if(n==0){
        $('[dateListView]').html(loader_win);
    }else{
        $('[dateListView]').append(loader_win);
    }
	$.post(f_path+"X/dts_rec_add_doc_list.php",{id:actSelDate,d:doc,n:n}, function(data){
		d=GAD(data);
        dd=d.split('^');
        if(dd.length==2){
            if(n==0){
                $('[dateListView]').html(dd[0]);
            }else{
                $('.dtsTab').append(dd[0]);
                $('[dateListView] .loadeText').remove();
            }
            actDtsDay=dd[1];
            fixObjects($('.rwBody'));		
            fixPage();
            fixForm();
        }
	})    
}
function recNewDtsDocDatsIN(s,e){
    openRecWin('موعد جديد : تحديد الزمن',1,0,2);
	$.post(f_path+"X/dts_rec_add_doc_set.php",{id:actSelDate,doc:actSelDoc,s:s,e:e}, function(data){
		d=GAD(data);
		$('.rwBody').html(d);
		fixObjects($('.rwBody'));
        setSliderN();
        loadFormElements('#n_d_d');		
		setupForm('n_d_d','m_info2');
		fixPage();
		fixForm();
	}) 
}
function loadDateInfo(id,t,sel){ 
    if(dtsInfoBasy==0){
        s=sel;
        dtsInfoBasy=1;
        $.post(f_path+"X/dts_rec_date_view.php",{id:id,t:t}, function(data){        
            d=GAD(data);
            dd=d.split('^');        
            s.data("ui-tooltip-title",d);
            s.attr("title",d);
            s.attr('t','1');
            
            $('.PageLoaderWin').css('opacity','0');
            $('.PageLoaderWin').show();
            setTimeout(function(){
                $('.PageLoaderWin').hide();
                $('.PageLoaderWin').css('opacity','');
                dtsInfoBasy=0;
            },50);
        })
    }
}
function setSliderN(){
	parseInt($("#dSlidN").css('left',0));	
	ta=parseInt($('.dtsSlider').attr('ta'));//total time by mints
	tn=parseInt($('.dtsSlider').attr('tn'));//this block time by mints	
	ts=parseInt($('.dtsSlider').attr('ts'));//steps 
    th=parseInt($('.dtsSlider').attr('th'));//block time start by secunds    
	$('#dSlidN').draggable({axis: "x",containment:'parent',drag: function(){cal_sliderTimeN();}});    
}
function cal_sliderTimeN(){
	sliderM=parseInt($("#dSlidN").css('left'));
    dslide=$('.dtsSlider').width();
	if(sliderM<0){sliderM=sliderM*(-1);}
	mitLp=sliderM/dslide*ta;    
	s_block=th+(parseInt(Math.round(mitLp/ts))*ts)*60;
	e_block=s_block+(tn*60);
	$(".slidBar_s").html(clockStr(s_block,1));
    $(".slidBar_e").html(clockStr(e_block,1));
	$('#ds').val(s_block);
	$('#de').val(e_block);
}
function checkDateStatusN(s,id,p){
	if(s==1){		
        if(p){
            dateInfoN(id);
        }else{
		  recNewDtsPat(id);
        }
        
	}else{
		if(s.substr(0,1)=='x'){
			loader_msg(0,'');
			xErr=s.split('-');
			if(xErr.length==2){
				msg="مشكلة بإدخال البيانات";
				if(xErr[0]=='x1'){msg='يوجد تعارض مع الموعد رقم <ff> ( '+xErr[1]+' ) </ff>';}
				if(xErr[0]=='x2'){msg='لايتطابق الموعد مع الزمن المتاح للطبيب ';}
				if(xErr[0]=='x3'){msg='لا يجب ان يكون مجموع الدفعات اكبر من قيمة الخدمات';}
			}
			navC(4,msg,'#f99');
		}
	}
}
function recNewDtsPat(id,conf=0){
    actSelDate=id;
    patEvent=3;
	openRecWin('موعد جديد : المريض',1,1,actRecOpr);
	$.post(f_path+"X/dts_rec_add_pat.php",{id:id,conf:conf},function(data){
		d=GAD(data);
		$('.rwBody').html(d);
        if(d==1){
            dateInfoN(id);
        }else{
            setPatForm();
            pm=2;
            if(conf){pm=3;}            
            veiwPatList(pm,id);
            fixObjects($('.rwBody'));	
        }
		fixPage();
		fixForm();
	})
}
function saveDaPaN(d_id,p,t){
	loader_msg(1,k_loading);
	$.post(f_path+"X/dts_new_patient_save_new.php",{d:d_id,p:p,t,t}, function(data){
		d=GAD(data);
        msg=k_done_successfully;mt=1;
        loader_msg(0,msg,mt);
        if(d==1){
            if(t==3){//عند تبديل المريض المؤقت 
                confirmDateN(actSelDate,actConfDtsMood);
            }else{
                dateInfoN(d_id);
            }
        }
	})
}
function dateInfoN(id){
    actSelDate=id;
    openRecWin('معلومات الموعد',1,0,2);
	$.post(f_path+"X/dts_infoN.php",{id:id},function(data){
		d=GAD(data);		
        $('.rwBody').html(d);
		fixObjects($('.rwBody'));
		fixForm();
		fixPage();
	})
}
function dateEnd(id){
    loader_msg(1,k_loading);
	$.post(f_path+"X/dts_new_end.php",{id:id}, function(data){
		d=GAD(data);
        msg=k_done_successfully;mt=1;        					
        loader_msg(0,msg,mt);
        dateInfoN(id);        
	})
}
function dtsCancelN(id){
    actSelDate=id;
    openRecWin('الغاء الموعد',1,0,2);
	$.post(f_path+"X/dts_cancel.php",{id:id},function(data){
		d=GAD(data);		
        $('.rwBody').html(d);
		fixObjects($('.rwBody'));
        loadFormElements('#CanD');        
        setupForm('CanD','');        
		fixForm();
		fixPage();
	})
}
function confirmDateN(id,mood){
	loader_msg(1,'جاري تأكيد حضور المريض');
	$.post(f_path+"X/dts_confirm.php",{id:id},function(data){
		d=GAD(data);		
		if(d>0){
			loader_msg(0,k_done_successfully,1);
            recNewVisSrvSta(d,mood);
		}else{
			loader_msg(0,k_error_data,0);
		}
	})	
}
function reserveDate(id){
    open_alert(id,'dts_4','هل تود إنشاء موعد إحتياطي ؟','إنشاء موعد إحتياطي');
}
function reserveDateDo(id){    
    loader_msg(1,k_loading);
	$.post(f_path+"X/dts_new_reserve.php",{id:actSelDate,ref_id:id}, function(data){    
		d=GAD(data);
        if(d){
			msg=k_done_successfully;mt=1;
			recNewDtsPat(actSelDate);
		}else{
			msg=k_error_data;
			mt=0;
		}
		loader_msg(0,msg,mt);
	})
}
function viewClinsDates(id=0){    
    openRecWin(' مواعيد العيادة اليومي',1,0,2);
	$.post(f_path+"X/dts_clinic_listN.php",{id:id},function(data){
		d=GAD(data);		
        $('.rwBody').html(d);
        viewClinsDatesIn(id);
		fixObjects($('.rwBody'));
		fixForm();
		fixPage();
	})
}
function viewClinsDatesIn(id){
    $('[datCLis]').html(loader_win);
	$.post(f_path+"X/dts_clinic_listN_in.php",{id:id},function(data){
        $('#dDsrc').val('');
		d=GAD(data);        
        $('[datCLis]').html(d);
        $('#dDsrc').focus();
		fixObjects($('.rwBody'));
		fixForm();
		fixPage();
	})
}
function srcInDate(){
    str=$('#dDsrc').val();
    if(str==''){
        $('tr[dtsTr]').show();
    }else{			
        $('tr[dtsTr]' ).each(function(index, element){            			
            txt=$(this).attr('dtsTr').toLowerCase();            
            n = txt.search(str);			
            if(n!=(-1)){$(this).show(100);}else{$(this).hide(100);}
        })
    }
}
function addPatToDtsN(d_id,pat,type){
	loader_msg(1,k_loading);
	$.post(f_path+"X/dts_add_patToDts.php",{id:d_id,p:pat},function(data){
		d=GAD(data);		
		if(d==1){
            closeRecWin();
			loader_msg(0,k_done_successfully,1);
			confirmDateN(d_id,type);
		}else{
			loader_msg(0,k_error_data,0);
		}
	})	
}
function setAppDts(){
    loadFormElements('#setAppDis');		
	setupForm('setAppDis','m_info');
}

/********************************************************/
var actSrvDisFix=0;
function setDisfix(){
    $('[send]').click(function(){sendDataDisFix();});
    $('#vis_info').on('click','[saveDis]',function(){disfixSave();});
    
}
function sendDataDisFix(){
    mood=$('#mood').val();
    actSrvDisFix=$('#vis').val();
    if(vis){
        $('#vis_info').html(loader_win);		
        $.post(f_path+"X/dts_app_discounts_fix.php",{mood:mood,vis:actSrvDisFix},function(data){
            d=GAD(data);
            $('#vis_info').html(d);
            loadFormElements('#dis_fix_form');		
	        setupForm('dis_fix_form','');
            fixForm();
            fixPage();
        })
    }else{
        nav(3,'يجب إدخال رقم الزيارة');
    }
}
function disfixSave(){
    sub('dis_fix_form');
    //actSrvDisFix
    //service=
}

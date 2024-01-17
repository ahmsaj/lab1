/***Addons**/
var addMPath=f_path+"Add.medical_history/";
var dirInter=1;
function inWinClose(){inWin();$('.inWin').hide();}
function inWin(title='',body='',size=1){
    $('.inWin').show();
    $('[inWin]').attr('inWin',size);    
	if(body==''){body=loader_win;}
	if(title!=0){$('#iwT').html(title);}
	$('#iwB').html(body);
	$('[inWin]').show();
    fixPage();
}
function setAddonsClick(){
	$('.addons > div').click(function(){
		code=$(this).attr('code');		
		if(code=='com'){addMpSel(code,1);}
		if(code=='dia'){addMpSel(code,2);}
		if(code=='cln'){addMpSel(code,3);}
		if(code=='str'){addMpSel(code,4);}
		if(code=='not'){addMpSel(code,5);}
		if(code=='icd'){icd_sel(code,1);}
		if(code=='icp'){icd_sel(code,2);}
		if(code=='his'){his_sel(code);}
		if(code=='vit'){vs_sel(code);}
		if(code=='grw'){gi_sel(code);}
		inWinClose();
		blcFocus(code);
	});
	
}
function blcFocus(code){
	openBlock(code);
	blcPos=$('#b_'+code).position().top;
	desPos=$('#desSec').scrollTop();
	m=desPos+blcPos-40;
	$("#desSec").animate({scrollTop:m});
	flashBlc($('#b_'+code));
}
function itmFocus(blc){
	openBlock(blc);
	blcPos=blc.position().top;
	desPos=$('#desSec').scrollTop();
	m=desPos+blcPos-120;
	$("#desSec").animate({scrollTop:m});	
}
function flashBlc(blc,t=3000){
	blc.addClass('blcFl');
	setTimeout(function(){blc.removeClass('blcFl');},t);
}
function setBlock(){
	$('[mmb]').click(function(){
		sta=$(this).attr('s');
		code=$(this).attr('mmb');
		if(sta==1){			
			$('[blcCon='+code+']').hide();
			$(this).attr('s',0);
			$(this).attr('title','تكبير');
			$(this).removeClass('i30_min');
			$(this).addClass('i30_max');
		}else{
			$('[blcCon='+code+']').show();
			$(this).attr('s',1);
			$(this).attr('title','تصغير');
			$(this).removeClass('i30_max');
			$(this).addClass('i30_min');
		}
		fixPage();
	})	
	if(actAddons){
		adds=actAddons.split(',');
		for(i=0;i<adds.length;i++){
			a=adds[i];
			if(a=='medical_history'){setHisItemsIn();}
			if(a=='med_proc'){mp_it_set();}
			if(a=='icd10_icpc'){icd_it_set();}
			if(a=='vital_signs'){vs_it_set();}
			if(a=='growth_indicators'){gi_it_set();}
			if(a=='ecg'){}
			if(a=='eko_heart'){}
		}
	}
}
function openBlock(code){
	selB=$("[mmb='"+code+"']");
	if(selB.attr('s')==0){
		$('[blcCon='+code+']').show();
		selB.attr('s',1);
		selB.attr('title','تصغير');
		selB.removeClass('i30_max');
		selB.addClass('i30_min');
	}
	fixPage();
	
}
function setBlockAll(){
	b=$('[mmbA]')
	sta=b.attr('s');
	if(sta==1){		
		b.attr('s',0);
		b.attr('title','تكبير');
		b.removeClass('i30_min');
		b.addClass('i30_max');
		$('[mmb]').each(function(){	
			$('[blcCon]').hide();
			$(this).attr('s',0);
			$(this).attr('title','تكبير');
			$(this).removeClass('i30_min');
			$(this).addClass('i30_max');
		})	
	}else{		
		b.attr('s',1);
		b.attr('title','تصغير');
		b.removeClass('i30_max');
		b.addClass('i30_min');
		$('[mmb]').each(function(){
			$('[blcCon]').show();
			$(this).attr('s',1);
			$(this).attr('title','تصغير');
			$(this).removeClass('i30_max');
			$(this).addClass('i30_min');
		})			
	}
	fixPage();	
}
function loadPrvDetails(){
	$('#desSec').html(loader_win);
	$.post(addMPath+'_blucks.php',{vis:visit_id},function(data){
		d=GAD(data);
		$('#desSec').html(d);		
		setBlock();	
		blcTotal();
		fixForm();
		fixPage();
	})
}
function viewAddDets(mood,code){
	inWin();
	$.post(addMPath+'_blucks_view.php',{vis:visit_id,pat:patient_id,mood:mood,code:code},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){inWin(dd[0],dd[1]);}
		$('[vCode]').click(function(){
			 mood=$(this).attr('mood');
			 code=$(this).attr('vCode');
			 viewAddDets(mood,code);
		})
		
		fixForm();
		fixPage();
	})
}
function blcTotal(){
	$('ff14[tot]').each(function(){
		blc=$(this).attr('tot');		
		tot=$(this).closest('.prvlBlc').find('['+blc+']').length
		$(this).html('('+tot+')');
	})
}
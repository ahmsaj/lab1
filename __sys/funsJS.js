var mouseX;var mouseY;var XMO=0;var YMO=0;var ctrP=false;
$(document).mousemove(function(e){XMO=mouseX=e.pageX;YMO=mouseY=e.pageY;});
window.onresize = function(){loadPageMove();}
$(document).keydown(function(e){if(e.which=="17");ctrP=true;});
$(document).keyup(function(){ctrP=false;});
$(document).ajaxComplete(function(){ajaxEnd();});
$(document).ajaxStart(function(){ajaxStart();});
$(document).bind("ajaxSend",function(){ajaxSend();})
var p_load='';var ser_wittig=500;var Dwidth=480;var Dheight=480;var winSpaceHeight=40;var addHeight=0;var www=0;var hhh=0;var traks_no=0;var ser_open=0;var speed1=600;var open_tree=0;var stopShow=0;var menuTimer='';var menuTimer2='';var menu_speed=300;var menuTimerSpeed=4000;var menushowSpeed=300;var maxWindo=0;var alert_no=0;var alert_data='';var backType='d';var actR_page='';var actR_tab='';var actR_fil='';var upFile_Size=0;var activeUploader='';var upimg=0;var navTimer='';var NSA_col=new Array('','#d7d8da','#e5e7ea','#edeef0','#f7f8f9');var CSW=$('.centerSide').width();
//*******************************************************************************
$(document).ready(function(){
	$('.PageStart').fadeOut(1000);	
	setTimeout(function(){dblWin()},1000);
	$('a[href]').click(function(){if(!ctrP){loader_msg(1,k_loading);}});
    upboxSet();
	set_backup();
	checkGrp();
    sel_2();
	/*****************Tabs****************************/
	tabs(0);
	$('.navMSG').click(function(){$(this).hide();})	
    $('body').on('click','.PageLoaderWin[cls]',function(){$(this).hide();})
    $('body').on('click','[tpCode]',function(){
        let code=$(this).attr('tpCode');
        editPageTxt(code);
    })
    setbjBil();
    $(function(){
        $(document).tooltip({
            track:true,content:function(){return $(this).prop('title');}
        });
    });
	/*****************switch button*************************/	
	g_switch_butt();
	loadGrad();
	//fixPage();
	/*************************************************/	
	
	
	for(i=0;i<6;i++){
		$('#opr_form'+i).dialog({
		resizable:false,
		modal: true,autoOpen: false,
		width:600,minHeight:100,closeOnEscape:false,
            open: function( event,ui){
                $(this).dialog( "option", "position",{ my: "center", at: "center", of: window } );
            },
        })
		$('#opr_form'+i).dialog('option', 'title',k_add_rec);
		//$('#opr_form'+i).dialog('option','dialogClass','bord5');
	}
	for(i=1;i<6;i++){
		$('#full_win'+i).dialog({modal: true,autoOpen: false,closeOnEscape:false,resizable: false, draggable:false,width:'100%',height:'100%',
        open: function( event,ui){
            $(this).dialog( "option", "position",{ my: "center", at: "center", of: window } );
        },})			
	}
	$('#m_info').dialog({		
		resize: function(event,ui){fixPage();},modal: true,autoOpen: false,
		width:600,minHeight:100,closeOnEscape:true,        
        open: function( event,ui){
            $(this).dialog( "option", "position",{ my: "center", at: "center", of: window } );
        },        			
	})	
	for(i=1;i<6;i++){
		$('#m_info'+i).dialog({
			resize: function(event,ui){fixPage();},modal: true,autoOpen: false,
			width:600,minHeight:100,closeOnEscape:true,
            open: function( event,ui){
                $(this).dialog( "option", "position",{ my: "center", at: "center", of: window } );
            },
		})
	}
	//-----------------------------------------
	$('#add').dialog({
		position: ['auto',10],	
		modal: true, 
		autoOpen: false,
		width:650,
		minHeight:300,
		closeOnEscape:true		
	})
	$('#add').dialog('option','title',k_add_rec);
	//-----------------------------------------
	$('#edit').dialog({
		modal: true,
		autoOpen: false,
		width:550,
		minHeight:300,
		closeOnEscape:true		
	})
	$('#edit').dialog('option', 'title',k_edt_rec);
	//-----------------------------------------
	$('#dele').dialog({modal: true,autoOpen: false,minHeight:150})
	$('#dele').dialog('option', 'title',k_del_rec);
	//-----------------------------------------
	$('#alert_win').dialog({modal: true,width:350,autoOpen: false,minHeight:150})
	//$('#alert_win').dialog( "option", "dialogClass", "bord5" );
    
	//-----------------------------------------------------	
    $('body').on('mouseover','[HhB]',function(){loadHintData($(this));})
    //-----------------------------------------------------		
	fixPage();
    updateClock();
});
$(document).on('click', function(e) {
    if(!$(e.target).closest('[nwn]').is(':visible')){		
		$('[nwn]').hide();
	}
});
function setWin(win,title=''){
	if (!$(win).hasClass('ui-dialog-content')) {
		$('#mwFooter').append('<div id="'+win+'" class="JQwin"></div>');
		$('#'+win).dialog({
			resizable:false,
			modal: true,autoOpen: false,
			width:600,minHeight:100,closeOnEscape:false,
			open: function( event,ui){
				$(this).dialog( "option", "position",{ my: "center", at: "center", of: window } );
			},
		})
		if(title){
			$('#'+win).dialog('option', 'title',title);
		}
		

			
	}
}
function updateClock() {
    var now = new Date();
    h=now.getHours();
    m=now.getMinutes();
    s=now.getSeconds();
    if(m<10){m='0'+m;}
    if(h > 12) {h -= 12;}else if(h===0){h=12;}
    time=h+':'+m
    $('[clc]').html(time);
    setTimeout(updateClock, 1000);
}
 // initial call
function loadPageMove(){
	fixPage();
	fixForm();
	clearTimeout(p_load);
	p_load=setTimeout(function(){fixPage();fixForm();},150);
}
var mainPage='';
function winIsOpen(){
	openWin=0;
	$(".ui-dialog-content").each(function(index,element){if($(this).dialog("isOpen")){openWin=1;}});	
	return openWin;
}
function fixPage(){
	www=$(window).width(); 
	//hhh=$(window).height();
	hhh=window.innerHeight;
	//$('.top_title ').html('<ff>'+www+'-'+hhh+'</ff>');
	/***********************************/
	var mvsZoom=0.7;
	var mvsZoomPer=mvsZoom*100;
	var mvsSel=$('meta[name=viewport').attr('content')
	if(www<hhh){		
		if(www<Dwidth){		
			if(mvsSel=='width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;'){
				$('meta[name=viewport').attr('content','width=device-width; initial-scale='+mvsZoom+'; maximum-scale='+mvsZoom+'; user-scalable=0;');
				loadPageMove();return;			
			}		
		}
		if(mvsSel=='width=device-width; initial-scale='+mvsZoom+'; maximum-scale='+mvsZoom+'; user-scalable=0;'){
			if((www/100*mvsZoomPer)>Dwidth){
				$('meta[name=viewport').attr('content','width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;');
				loadPageMove();return;
			}
		}
	}else{
		/***********************************/
		if(hhh<Dheight){		
			if(mvsSel=='width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;'){		
				$('meta[name=viewport').attr('content','width=device-width; initial-scale='+mvsZoom+'; maximum-scale='+mvsZoom+'; user-scalable=0;');
				loadPageMove();return;			
			}		
		}
		if(mvsSel=='width=device-width; initial-scale='+mvsZoom+'; maximum-scale='+mvsZoom+'; user-scalable=0;'){
			if((hhh/100*mvsZoomPer)>Dheight){
				$('meta[name=viewport').attr('content','width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;');
				loadPageMove();return;
			}
		}
	}
	/****************add OPration*******************/	
	if(sezPage=='c_new'){$('#c_cat').width(CSW-75);}
	/***********************************************/
	loadGrad();		
	fixForm();
	// $('.body').width(www);
	// $('.body').height(hhh+25);
	fottH=$('#mwFooter').height();
    if(!fottH){fottH=0;}
	$('.centerSide').height(hhh-(40+fottH));
	$('.centerSide').width(www);
	CSW=$('.centerSide').width();
	$('.sub_menu').height(hhh);
	var CSI_H=hhh-150;
	var CSI_W=www;
	fil_width=0;		
	if(ser_open==1 && $('.co_filter').is(':visible')){
		fil_width=$('.co_filter').width()+20; 
		$('.co_filter').css('top',headH+40);		
		$('.co_filter').height(hhh-(headH+fottH+70));
		CSI_W=CSI_W-fil_width
	}else{			
		$('.co_filter').height('');
	}
	fil_h=$('.co_filter').height();
	$('.filterForm').height(fil_h-40);
	
	headH=0;
	if($('header').length>0){headH=$('header').height();}
	sidInH_h=0
	if($('.centerSideInHeader').length>0){sidInH_h=$('.centerSideInHeader').height();}
	$('.centerSideInHeader,.centerSideIn').width(CSI_W-20);	
	$('.centerSideIn').height(hhh-(headH+fottH+sidInH_h+40));
	sidInH_h_f=0;
	if($('.centerSideInHeaderFull').length>0){sidInH_h_f=$('.centerSideInHeaderFull').height();}	
	$('.centerSideInFull,.centerSideInHeaderFull').width(CSI_W);
	$('.centerSideInFull').height(hhh-(headH+fottH+sidInH_h_f+40));
	
	center2_h=hhh-headH-48;
	$('.grad_s').each(function(index){
		table_type=$(this).attr('type');
		if(table_type!='static'){
			g_hhh=$(this).height();			
		}
	});	
	$('.infoTable').each(function(index){						
		table_type=$(this).attr('type');
		if(table_type!='static'){
			$(this).width(www-90);
		}
	});	
	$('header').width(www);
	HHTitSec=$('.top_txt_sec').width();
	HHIco=$('.top_icons').width();	
	$('.top_txt_sec').width(www-HHIco);	
	HHTit=$('.top_title').width();	
	if(www<(HHIco+HHTit)){	
		$('.top_txt_sec').width(www);
		$('.top_txt_sec').css('border-bottom','2px #e5e7ea solid');
		$('.top_txt_sec').css('background-color',clr1111);
		$('.top_txt_sec').css('color','#fff');
	}else{
		$('.top_txt_sec').css('border-bottom','');
		$('.top_txt_sec').css('background-color','');
		$('.top_txt_sec').css('color','');
	}
	//----form---------------------------------------------------------------------------
	formFiled=250;		
	form_width=$('.form').width();		
	fo_sec_width=parseInt((form_width-20)/(formFiled+44));		
	f_w =parseInt(((form_width-20)/fo_sec_width)-(44)); 

	$('.form section').width(f_w);
	$('.ser_line').width(CSW-40);	
	$('.fo').width(CSW-20);	
	$('.fo_line').each(function(inf, element){			
		fo_c2=$(this).attr('fo_co');
		par_width=$(this).parent().width();			
		fo_width=parseInt(((par_width-20)-(20*fo_c2))/fo_c2);
		$(this).children('section').width(fo_width);
	})	
	$('.add_sel').each(function(inf, element){
		ads_widdth=$(this).parent().width();
		$(this).width(ads_widdth-45);
	})
	setTabs();
	fieldsOrder();
	fixForm();
	fixPage_add();
	fieldsOrder();
	date_picker();
	$("[rel^='lf']").prettyPhoto({
		social_tools: false,        
        changepicturecallback: function(){
            $('.pp_expand').hide();
            $('.pp_close').html('');
        },
	});
	holdTableHeader();	
	
    $('[title=""]').removeAttr('title');
	fixObjects($('body'));
    fxObjects($('body'));
    fxObjects($('.win_body'));
    sel_2();
    fixForm();
}
function sel_2(){
    $('[sel2]').each(function(){
        $(this).select2();
        $(this).removeAttr('sel2');
        $(this).on(':open', () => {            
            $(this).children('.select2-search__field').focus();
            change.select2  
        });
    })
    $('[sel2m]').each(function(){
        $(this).select2({
            multiple: true,            
            //closeOnSelect: false
        });
        if(!$(this).val()){
            $(this).val(null);
            $('.select2-selection__rendered').html('');
        }
        $(this).removeAttr('sel2m');
    })
}
function setTabs(){
	//----Tabs-------------------------------------------------------------------------------
	$('.tabs').each(function(index1, element){
		pTab=$(this).parent().width();
		$(this).width(pTab);
		tabs_in=parseInt($(this).attr('ttotal'));
		tab_width=parseInt((pTab-((tabs_in)-1))/tabs_in);
		tab_width2=parseInt((pTab)-(((tab_width)*(tabs_in-1))+(tabs_in)));		
		$(this).children('div').width(tab_width);
		$(this).children('div').each(function(index1, element){
			icon=$(this).attr('icon');
			if (typeof icon !== typeof undefined && icon !== false && icon!=''){				
				$(this).css('text-indent',45);
				$(this).css('background-image','url('+m_path+'im/'+icon+'.png)');
			}
		})		
		if(tabs_in>1){
			$(this).children('div:last-child').width(tab_width2);
		}else{
			$(this).children('div:last-child').width(tab_width2-1); 
		}
	})	
	/*************Spacial Tabs**************************************************/
	$('.tab12').height(center2_h-82);
	$('.tab15').parent().css('padding-top',0);
	$('.tab15').parent().css('padding-bottom',0);
	$('.tab15').height($('.tab15').parent().height()-20)
	$('.tab16').height(center2_h-52);
	/**************************************************************************/
	$('.tabc').each(function(index1, element){		
		pt=$(this).parent().width()-22;
		$(this).width(pt);
		pt_h=$(this).parent().height()-60;
		$(this).height(pt_h);
		//alert('-'+pt_h);
		$(this).children('section').height(pt_h);
		$(this).children('section').addClass('so');
	})
}
function g_switch_butt(){
	$('.switch_butt').click(function(){
	v=$(this).attr('v');
	if(v!='x'){
		id=$(this).attr('id');
		f=$(this).attr('f');
		r=$(this).attr('r');
		t=$(this).attr('t');
		if(t==1){	
			if(v==1){
				coll='#999';xv=0;
				$('#'+id+' div').animate({marginLeft:2}, menu_speed);
			}else{
				coll='#317716';xv=1;
				$('#'+id+' div').animate({marginLeft:16}, menu_speed);							
			}
		}
		if(t==2 && v==0){
			xv=1;
			$('div[f='+f+'] div').animate({marginLeft:2}, menu_speed,function(){
				$('#'+id+' div').animate({marginLeft:16}, menu_speed);
			});			
		}		
		$('#'+id+' div').addClass('fl3');
		$('#'+id).attr('v','x');		
		$.post(f_path+"S/sys_switch.php",{f:f,r:r,v:xv,id:id}, function(data){		
			d=GAD(data);
			$('#'+id+' div').removeClass('fl3');
			if(t==1){
				$('#'+id+' div').css('background-color',coll);				
				$('#'+id).attr('v',xv);				
			}
			if(t==2){
				$('div[f='+f+'] div').css('background-color','#999');
				$('div[f='+f+']').attr('v','0');
				
				$('#'+id+' div').css('background-color','#317716');				
				$('#'+id).attr('v','1');				
			}
			
			stopShow=0;
		})
	}	
})}
function fieldsOrder(){
	$('section[c_ord]').each(function(index, element) {
		c_width= $(this).attr('w');if(typeof c_width == typeof undefined || c_width == false || c_width==''){c_width=100;}
		c_margin= $(this).attr('m');if(typeof c_margin == typeof undefined || c_margin == false || c_margin==''){c_margin=0;}
		c_width=parseInt(c_width);
		c_margin=parseInt(c_margin);
		full_width=$(this).parent().width()-3;
		c_count=parseInt(full_width/(c_width+c_margin));		
		if(c_count==0){c_count=1;}		
		allRowCo=$(this).find('*[c_ord]').length;
		if(c_count>allRowCo)c_count=allRowCo;
		c_count2=parseInt(full_width/c_count)-c_margin;		
		if(c_count2>full_width)c_count2=full_width;        
		$(this).find('*[c_ord]').width(c_count2);		
	});
}
function date_picker(){
	$('.Date').datetimepicker({
		lang:lg,
		timepicker:false,
		format:'Y-m-d',
		formatDate:'Y-m-d',
		defaultTime:'1:00',
		scrollMonth:false,
		scrollInput: false,
		closeOnDateSelect:true,
		yearRange: '-100:+0'        
	})
	$('.DateTime').datetimepicker({
		lang:lg,
		format:'Y-m-d H:i:00',
		formatDate:'Y-m-d H:i:00',
		defaultTime:'12:00 a',
		yearRange: '-100:+0',
		step:15
	})
	$('.DUR').each(function(index, element) {
		step_v=10;if($(this).attr('step')){step_v=$(this).attr('step');}
	    d_time='1:00';if($(this).attr('d_time')){d_time=$(this).attr('d_time');}
		$(this).datetimepicker({			
			datepicker:false,
			defaultTime:d_time,
			format:'H:i',
			formatDate:'H:i',
			yearRange: '-100:+0',
			step:step_v
		});
	});
	$('.DUR2').each(function(index, element) {
		step_v=30;
		if($(this).attr('step')){step_v=parseInt($(this).attr('step'));}        
	    d_time='1:00';
		if($(this).attr('d_time')){d_time=$(this).attr('d_time');}
		$(this).datetimepicker({			
			datepicker:false,
			defaultTime:d_time,
			format:'A h:i',
			formatDate:'A h:i',
			yearRange: '-100:+0',
			stepping:step_v,
            step:step_v,
			locale: {
			  format: 'M/DD hh:mm A'
			}
		});
	});
}
function SelectOpr(){
	$('div[par=check_all]').click(function(){
		ch=$(this).children().attr('ch');
		CHicon=$(this).attr('ch_name');
		if(ch=='on'){SH_Icon(1,CHicon);}else{SH_Icon(0,CHicon);}
		form=$(this).closest('form').attr('id');
		$('#'+form).find("div[par=grd_chek]").each(function(index, element) {
			id=$(this).attr('id');
            checkBoxClick($(this),ch);
        });
	})
	$('div[par=grd_chek]').click(function(){
		form=$(this).closest('form').attr('id');		
		CHicon=$(this).closest('form').find('div[par=check_all]').attr('ch_name');
		var check=0;
		var not_chek=0;
		$('#'+form).find('div[par=grd_chek]').each(function(index, element) {
			if($(this).children().attr('ch')=='on'){check++;}else{not_chek++;}			
        });		
		if(check==0){
			checkBoxClick($('#'+form).find('div[par=check_all]'),'off');
			SH_Icon(0,CHicon);
		}else{SH_Icon(1,CHicon);}
		if(not_chek==0){
			checkBoxClick($('#'+form).find('div[par=check_all]'),'on');	
		}
	})
}
function changTab(tab_num){
	div=$('div [tn='+tab_num+']');
	div.parent().children('div').removeClass('tab_act');
	div.parent().children('div').removeClass('tf_act tl_act tn_act');
	div.parent().children('div').addClass('tab_nor');	
	tab_t=div.attr('tab_t');	
	if(tab_t=='ft'){div.addClass('tf_act');}
	if(tab_t=='lt'){div.addClass('tl_act');}
	if(tab_t=='nt'){div.addClass('tn_act');}	
	div.removeClass('tab_nor');
	div.addClass('tab_act');
	tta=div.parent().parent('section').children('.tabc');
	tta.children('section').hide();
	$('section [tab='+tab_num+']').show();
	fixPage();
}
function tabs(n){
	$('.tabs').each(function(index1, element){
		order=index1;		
		if($(this).attr('num')){
			order=$(this).attr('num');
		}
		if(n==order || n==0){
			tc=0;
			allTc=$(this).children('div').length		
			$(this).children('div').each(function(index2, element){
				$(this).addClass('fl');				
				if(index2==0){
					$(this).attr('tab_t','ft');
					$(this).addClass('tab_act tf_act ');
				}else if((index2+1)==allTc){ 
					$(this).attr('tab_t','lt');
					$(this).addClass('tab_nor');
				}else{
					$(this).attr('tab_t','nt');
					$(this).addClass('tab_nor');
				}
				$(this).attr('tn',order+'-'+index2);
				tc++;			
			});
			$(this).attr('ttotal',tc);			
			Tcontent=$(this).parent('section').children('.tabc')
			Tcontent.children('section').each(function(index3, element){
				if(index3==0){$(this).show();}
				$(this).attr('tab',order+'-'+index3);				
			})		
		}
	})
	$('.tabs > div').click(function(){
		tab_num=$(this).attr('tn');
		changTab(tab_num);		
	})
}
function hideMenu(){$('.sub_menu').hide("slide",{direction: k_align},menu_speed);}
function dblWin(){
	$('.ui-widget-header').dblclick(function(e){
		winn=$(this).parent().attr('aria-describedby');
		$('#'+winn).dialog('option','width',www);
		$('#'+winn).dialog('option','height',hhh);
        $('#'+winn).dialog('option','position',{ my: "center", at: "center", of: window });
		fixForm();
		fixPage();		
	});
}
function open_alert(data,n,msg,title){
	if(title=='')title='|'
	$('#alert_win').dialog('option', 'title',title);
	$('#alert_win_cont').html(msg);
	$('#alert_win').dialog('open');
	alert_data=data;
	alert_no=n;
	fixPage();
}
function delete_rec(id){	
	$('#del_id').val(id)
	$('#dele').dialog('open');
}
function SH_Icon(s,icon){
	if(s==1){
		$('.'+icon).slideDown(300);fixPage();
	}else{
		$('.'+icon).slideUp(300,function(){fixPage();});
	}
}
function chekAll(rows){var ch=false;
	if($('#check_all').is(':checked')==true){ch=true;$('.ti_del').show();}else{$('.ti_del').hide();}	
	$('.grd_chek').prop('checked',ch);	
}


function loc(url){if(!ctrP){loader_msg(1,k_loading);}document.location=url;}
function popWin(url,www,hhh){
	window.open(url,'win','width='+www+',height='+hhh+',toolbar=0 ,menubar=0 ,location=0 ,status=0 ,scrollbars=0, resizable=0 ,left=0,top=0');
	return false;
}
/*
function Open_filter(n){
	if($('.filter').is(':visible') || n==1){
		$('.filter').hide();
		$('.ti_search').css('background-color','#fff');
		$('.ti_search div').css('color','#a1aab7');
		$('.ti_search').css('background-image','url(../images/icon_t_search.png)');
	}else{
		$('.filter').show();
		$('.ti_search').css('background-color',clr11);
		$('.ti_search div').css('color','#bfd3ea');
		$('.ti_search').css('background-image','url(../images/icon_t_search2.png)');
	}
}*/
function sub(form){
	err=0;	
	$("form[name="+form+"]").find('input[required]').each(function(index, element) {
        v=$(this).val();
		if(v==''){
			err=1;			
			$(this).closest('tr').css('background-color','#eaa');
			$(this).closest('[inputHolder]').css('background-color','#eaa');            
		}else{			
			$(this).closest('tr').css('background-color','');
			$(this).closest('[inputHolder]').css('background-color','');            
		}
    });
    $("form[name="+form+"]").find('textarea[required]').each(function(index, element) {
        v=$(this).val();        
		if(v==''){
			err=1;			
			$(this).closest('tr').css('background-color','#eaa');
			$(this).closest('[inputHolder]').css('background-color','#eaa');            
		}else{			
			$(this).closest('tr').css('background-color','');
			$(this).closest('[inputHolder]').css('background-color','');            
		}
    });
	$("form[name="+form+"]").find('select[required]').each(function(index, element) {
        v=$(this).val();
		if(v=='' || v==0){
			err=1;
            $(this).closest('tr').css('background-color','#eaa');
			$(this).closest('[inputHolder]').css('background-color','#eaa');
		}else{			
            $(this).closest('tr').css('background-color','');
			$(this).closest('[inputHolder]').css('background-color','');
		}
    });	
    $("form[name="+form+"]").find('[passCheck="1"]').each(function(index, element) {
        v=$(this).val();
        if(v!='******'){            
            if (checkPassStrength(v) != true) {               
                err=1;
                $(this).closest('tr').css('background-color','#eaa');
                $(this).closest('[inputHolder]').css('background-color','#eaa');
            }else{			
                $(this).closest('tr').css('background-color','');
                $(this).closest('[inputHolder]').css('background-color','');
            }
        }
    });	
	if(err==0){$("form[name="+form+"]").submit();}
}
function checkPassStrength(password) {
  let strongPassword = new RegExp(
    "(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{6,})(?=.*[^A-Za-z0-9])"
  );
  if (strongPassword.test(password)) {
    return true;
  }
}
function newBp(){
	loadWindow('#m_info',1,k_m_create_backup,400,0);
	$.post(f_path+"S/sys_backup.php",{}, function(data){		
		loc('_Backup');
	})
}
function recBp(){	
	loadWindow('#m_info',1,k_ext_restore,400,0);
	$.post(f_path+"S/sys_backup_rec.php",{}, function(data){
		d=GAD(data);					
		$('#m_info').html(d);
		fixForm();		
	})
}
function save_recav(){
	backType='f';
	id=$('input[name=bk]').val();
	if(id!=''){resBup(id);}
}
function delBup(id){$.post(f_path+"S/sys_backup_del.php",{id:id}, function(data){loc('_Backup');})}
function resBup(id){	
	str='<div class="winOprNote_err fs14 f1">'+k_wait_restor_msg+'</div>';
	$('#m_info').html('<div class="win_body"><div class="form_body">'+str+loader_win+'</div></div><div> </div>');	
	loadWindow('#m_info',0,k_m_being_restore,600,0);
	fixForm();
	$.post(f_path+"S/sys_backup_res.php",{id:id,t:backType}, function(data){
		d=GAD(data);		
		$('#m_info').html(d);
		fixPage();			
	})
}
function resizeCols(Paeant,colmn,mini_width,margin){
	if($(Paeant).length>0){
		p_width=$(Paeant).width()-2;
		col_width=parseInt(p_width/mini_width);
		col_w=parseInt(p_width/col_width);
		$(colmn).width(col_w-margin);
	}
}
function ReloadReport(){loadReport(actR_page,actR_tab,actR_fil);}
function loadReport(page,tab,fil){
	actR_page=page;actR_tab=tab;actR_fil=fil;
	val=$('#rep_fil').val();
	df=$('#df').val();
	dt=$('#dt').val();
	$('.rep_header div').removeClass('act');
	$('.rep_header div[n=n'+tab+']').addClass('act');
	f=$('.rep_header div[n=n'+tab+']').attr('f');
	if(f=='1'){$('#rep_fil').show();}else{$('#rep_fil').hide();}
	$('#reportCont').html(loader_win);
	$('#rep_header_add').html('');
	fixPage();
    $.post(f_path+"X/"+repCode+"_reports.php",{p:page,t:tab,v:val,f:fil,df:df,dt:dt},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length>0){
		h_out='';
		b_out='';
		if(dd.length==1){b_out=dd[0];}
		if(dd.length==2){h_out=dd[0];b_out=dd[1];}		
		$('#rep_header_add').html(h_out);
		$('#reportCont').html(b_out);
		fixPage();
		fixForm();
		}
	});
}
function setReportEl(page,tab,autoLoad=1){	
	$('select[rpSel]').change(function(){		
		tab=$(this).val();
		actR_tab=tab;
		showRepFill(tab);	
		loadRep(page,tab,0,1);
	})
	$('#repFilH select').change(function(){
		reloadRep();
	})
	
	showRepFill(tab);
    if(autoLoad){
	   loadRep(page,tab);
    }
    $('body').on('click','[refRep]',function(){
        reloadRep($(this).attr('refRep'));
    })
}
function showRepFill(t){
	f=$('select[rpSel]').children('option[value='+t+']').attr('f');    
	if(f=='1'){$('#repFilH').show();}else{$('#repFilH').hide();}
}
function reloadRep(type=0){loadRep(actR_page,actR_tab,actR_fil,1,1);}
function loadRep(page,tab,fil=0,ch=1,d=0){
	actR_page=page;actR_tab=tab;actR_fil=fil;
    type=$('select[rpSel]').children('option[value='+tab+']').attr('t');
    
	val=$('#repFilH select').val();
	if(!val){val=0};
	df=$('#df').val();
	dt=$('#dt').val();
	$('#reportCont').html(loader_win);
	$('#rep_header_add').html('');
	if(ch==0){$('[rpsel] option').removeAttr('selected');}
	$('[rpsel] option[value='+actR_tab+']').attr('selected','1');
	fixPage();
    $.post(f_path+"X/"+repCode+"_reports.php",{p:page,t:tab,v:val,f:fil,type:type,df:df,dt:dt,data:d},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length>0){
			h_out='';
			b_out='';
			if(dd.length==1){b_out=dd[0];}
			if(dd.length==2){h_out=dd[0];b_out=dd[1];}
			$('#rep_header_add').html(h_out);
			$('#reportCont').html(b_out);        
            if(type>0){$('.refRep').show();}
			fixPage();
			fixForm();
		}
	});
}
function changeRVal(val){$('#rep_fil').val(val);ReloadReport();}
function chnRepVal(val){$('#repFilH select').val(val);reloadRep();}
function printReport(t){
	ac=$('#R_form').attr('part');
	if(t==1){$('#R_form').attr('action','Report-'+ac);}
	if(t==2){$('#R_form').attr('action','Export-'+ac);}
	//if(ac=='old'){$('#R_form').attr('action','Print-R');}
	$('#R_form').submit();
}
/**********************************************************/
function imgeSelected(id){	
	var count = document.getElementById('fi_'+id).files.length;
	for (var index = 0; index < count; index ++){
		var file = document.getElementById('fi_'+id).files[index];
		var fileSize = 0;
		upFile_Size=file.size;
		uploadImage(id);
		upimg=1;
	}
}
function uploadImage(id){
	activeUploader=id;
	$('.loadWin').show();
	$('.loadWin').html('<div class="lod_img_con hide f1 fs22" >'+k_ld_pht+'\
	<div class="progressShow"><div></div></div>\
	<div class="progressData ff fs24">0%</div>\
	</div>');
	$('.lod_img_con').slideDown(500);
	var fd = new FormData();
	var count = document.getElementById('fi_'+id).files.length;
	for (var index = 0; index < count; index ++){
		var file = document.getElementById('fi_'+id).files[index];
		fd.append(file.name, file);
	}
	var xhr = new XMLHttpRequest();
	xhr.upload.addEventListener("progress", uploadProgress, false);
	xhr.addEventListener("load", uploadComplete, false);
	xhr.addEventListener("error", uploadFailed, false);
	xhr.addEventListener("abort", uploadCanceled, false);
	xhr.open("POST",f_path+"S/sys_upImage.php");
	xhr.send(fd);
}
function uploadComplete(evt){	
	upimg=0;
	out=evt.target.responseText;
	d=out.split('<!--***-->');
	errr=0;
	er_msg='';
	if(d[1]!=''){
		data=d[1].split(',');
		if(data[0]!='xxx'){
			if(data[2]!=''){		
				$('.upimageCon[no='+activeUploader+'] div[list]').append('<div class="fl uibox" style="background-image:url('+data[2]+')"\
				no="'+data[0]+'" org="'+data[1]+'" group="'+activeUploader+'" sc="0" w="'+data[3]+'" h="'+data[4]+'"></div>');		
			}			
			idess=checkImagesIds(activeUploader);
			upCB=$('.upimageCon[no='+activeUploader+']').attr('cb');
			if(upCB!=''){				
				upCB=upCB.replace('[id]',data[0]);
				upCB=upCB.replace('[ids]',idess);				
				doScript(upCB);
			}
		}else{
			errr=1;
			if(data[1]==1){er_msg=k_nfile_snt;}
			if(data[1]==2){er_msg=k_err_ld;}
			if(data[1]==3){er_msg=k_fl_lrg_sz;}
			if(data[1]==4){er_msg=k_fl_nrq_typ;}
			if(data[1]==5){er_msg=k_fl_ncpd;}
			if(data[1]==6){er_msg=k_fl_nrgt_db+' ';}
		}		
	}
	if(errr==1){
		$('.lod_img_con').html('<span class="f1 winOprNote_err">'+er_msg+'</span>');
		setTimeout(function(){$('.loadWin').hide();},1000);
	}else{
		setTimeout(function(){$('.progressShow').slideUp(500,function(){$('.loadWin').hide();})},500);
	}
	//document.getElementById('out').innerHTML = evt.target.responseText;	
}
function checkImagesIds(id){
	ides='';
	$('.uibox[group='+id+']').each(function(index, element) {
        if(ides!='')ides+=',';
		ides+=$(this).attr('no');
    });
	$('.upimageCon[no='+id+']').children('input[name='+id+']').val(ides);
	imgClick();
	return ides;
}
function imgClick(){
	$('.imgUpHol').click(function(){upimg=1;})
	$('.uibox[sc=0]').each(function(index,element){        
		$(this).click(function(){
			no=$(this).attr('no');
			showImg(no);
		})
		$(this).attr('sc',1);
    });
}
function showImg(id){
	$('.loadWin').show();
	org=$('.uibox[no='+id+']').attr('org');
	group=$('.uibox[no='+id+']').attr('group');
	i_w=$('.uibox[no='+id+']').attr('w');
	i_h=$('.uibox[no='+id+']').attr('h');		
	$('.imgHolder').width(www-20);	
	$('.imgHolder').height(hhh-70);
	$('.loadWin').html('<div class="imagw_h_bar">\
	<div class="winButts">\
	<div class="wB_x" onclick="closeImage();"></div>\
	<div class=""></div>\
	<div class="wB_del" onclick="delUpImage('+id+');"></div>\
	</div>\
	</div>\
	<div class="imgHolder" onclick="">\
	<img src="'+org+'" height="100%" w="'+i_w+'" h="'+i_h+'"/></div>');
	fixImage();	
}
function fixImage(){
	if($('.imgHolder').length>0){
		i_w=$('.imgHolder').children('img').attr('w');
		i_h=$('.imgHolder').children('img').attr('h');
		if(((www-20)/(hhh-20))>(i_w/i_h)){			
			$('.imgHolder').children('img').attr('height',hhh-70);
			$('.imgHolder').children('img').attr('width','');
			$('.imgHolder').children('img').css('margin-top','');
		}else{
			$('.imgHolder').children('img').attr('width',www-20);
			$('.imgHolder').children('img').attr('height','');
			img_m=((hhh-80)-(((www-20)*i_h)/i_w))/2;
			$('.imgHolder').children('img').css('margin-top',img_m);			
		}
	}
}
function closeImage(){
	$('.loadWin').html('');
	$('.loadWin').hide();	
}
function delUpImage(id){
	open_alert(id,'s7',k_wnt_dlt_pht,k_delete_photo);
	closeImage();
}
function delUpImageDo(id){	
	upCB=$('.uibox[no='+id+']').closest('.upimageCon').attr('cb');
	no=$('.uibox[no='+id+']').closest('.upimageCon').attr('no');
	$('.uibox[no='+id+']').remove();
	idess=checkImagesIds(no);	
	upCB=upCB.replace('[id]',id);
	upCB=upCB.replace('[ids]',idess);
	doScript(upCB);
	setTimeout(function(){delImgFile(id);},800);	
}
/*********************************************************/
function fileSelected(id){	
	var count = document.getElementById('fi_'+id).files.length;
	for (var index = 0; index < count; index ++){
		var file = document.getElementById('fi_'+id).files[index];
		var fileSize = 0;
		upFile_Size=file.size;
		uploadFil(id);
		upimg=1;
	}
}
function uploadFil(id){
	activeUploader=id;
	$('.loadWin').show();
	$('.loadWin').html('<div class="lod_img_con hide f1 fs22" >'+k_ld_pht+'\
	<div class="progressShow"><div></div></div>\
	<div class="progressData ff fs24">0%</div>\
	</div>');
	$('.lod_img_con').slideDown(500);
	var fd = new FormData();
	var count = document.getElementById('fi_'+id).files.length;
	for (var index = 0; index < count; index ++){
		var file = document.getElementById('fi_'+id).files[index];
		fd.append(file.name, file);
	}
	var xhr = new XMLHttpRequest();
	xhr.upload.addEventListener("progress", uploadProgress, false);
	xhr.addEventListener("load", uploadFComplete, false);
	xhr.addEventListener("error", uploadFailed, false);
	xhr.addEventListener("abort", uploadCanceled, false);
	xhr.open("POST",f_path+"S/sys_upFile.php");
	xhr.send(fd);
}
function uploadFComplete(evt){	
	upFil=0;
	out=evt.target.responseText;
	d=out.split('<!--***-->');
	errr=0;
	er_msg='';
	if(d[1]!=''){
		data=d[1].split(',');		
		if(data[0]!='xxx'){
			if(data[1]!=''){		
				$('.upimageCon[no='+activeUploader+'] div[list]').append('<div class="fl ff file_box" set="0" no="'+data[0]+'" title="'+data[1]+'" group="'+activeUploader+'">'+data[2]+'</div>');
				FileClick();
			}	
			idess=checkFileIds(activeUploader);
			upCBf=$('.upimageCon[no='+activeUploader+']').attr('cb');
			if(upCBf!=''){				
				upCBf=upCBf.replace('[id]',data[0]);
				upCBf=upCBf.replace('[ids]',idess);				
				doScript(upCBf);
			}
		}else{
			errr=1;
			if(data[1]==1){er_msg=k_nfile_snt;}
			if(data[1]==2){er_msg=k_err_ld;}
			if(data[1]==3){er_msg=k_fl_lrg_sz;}
			if(data[1]==4){er_msg=k_fl_nrq_typ;}
			if(data[1]==5){er_msg=k_fl_ncpd;}
			if(data[1]==6){er_msg=k_fl_nrgt_db+' ';}
		}		
	}
	if(errr==1){
		$('.lod_img_con').html('<span class="f1 winOprNote_err">'+er_msg+'</span>');
		setTimeout(function(){$('.loadWin').hide();},1000);
	}else{
		setTimeout(function(){$('.progressShow').slideUp(500,function(){$('.loadWin').hide();})},500);
	}
	//document.getElementById('out').innerHTML = evt.target.responseText;	
}
function checkFileIds(id){
	ides='';
	$('.file_box[group='+id+']').each(function(index, element) {
        if(ides!='')ides+=',';
		ides+=$(this).attr('no');
    });
	$('.upimageCon[no='+id+']').children('input[name='+id+']').val(ides);
	FileClick();
	return ides;
}
var actFGroup='';
function FileClick(){
	$('.imgUpHol').click(function(){upFil=1;})
	$('.file_box[set=0]').each(function(index,element){        
		$(this).click(function(){
			no=$(this).attr('no');
			actFGroup=$(this).attr('group');
			showDetFile(no);
		})
		$(this).attr('sc',1);
    });
}
function showDetFile(id){
	loadWindow('#m_info5',1,'',500,200);
	$.post(f_path+"S/sys_upFile_d.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info5').html(d);
		fixForm();
		fixPage();
	})
}
function delUpFile(id){
	open_alert(id,'s77',k_wld_del_file,k_del_file);	
}
function delUpFileDo(id){
	win('close','#m_info5')
	upCBf=$('.file_box[no='+id+']').closest('.upimageCon').attr('cb');
	no=$('.file_box[no='+id+']').closest('.upimageCon').attr('no');
	$('.file_box[no='+id+']').remove();
	idess=checkFileIds(no);	
	if(upCBf!=''){
		upCBf=upCBf.replace('[id]',id);
		upCBf=upCBf.replace('[ids]',idess);
		doScript(upCBf);
	}
	setTimeout(function(){delUFile(id);},800);	
}
function delUFile(id){$.post(f_path+"S/sys_upFileDel.php",{id:id},function (data){});}
/*********************************************************/
function uploadProgress(evt){
	if(evt.lengthComputable){
		per=evt.loaded * 100 / evt.total;
		var percentComplete = Math.round(per);		
		if (upFile_Size > 1024 * 1024){
			fileSize = (Math.round(upFile_Size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
		}else{
			fileSize = (Math.round(upFile_Size * 100 / 1024) / 100).toString() + 'KB';
		}
		loadSize=upFile_Size*per/100		
		if (loadSize > 1024 * 1024){
			loadSize2 = (Math.round(loadSize * 100 / (1024 * 1024)) / 100).toString() + 'MB';
		}else{
			loadSize2 = (Math.round(loadSize * 100 / 1024) / 100).toString() + 'KB';
		}		
		$('.progressShow').children('div').width(percentComplete+'%');
		$('.progressData').html(percentComplete.toString() + '% - '+fileSize+' / '+loadSize2);
	}else{
		//document.getElementById('progress').innerHTML = 'unable to compute';
	}
}
function fullscreen(element) {
  if(element.requestFullscreen){element.requestFullscreen();}
  else if(element.mozRequestFullScreen){element.mozRequestFullScreen();}
  else if(element.webkitRequestFullscreen){element.webkitRequestFullscreen();}
  else if(element.msRequestFullscreen){element.msRequestFullscreen();}
}
function delImgFile(id){$.post(f_path+"S/sys_upImageDel.php",{id:id},function (data){});}
function uploadFailed(evt){upimg=0;alert("There was an error attempting to upload the file.");}
function uploadCanceled(evt){upimg=0;alert("The upload has been canceled by the user or the browser dropped the connection.");}
function in_array(str,arr){
    var arr_l=arr.length;
    for(i=0;i<length;i++){if(arr[i]==str)return true;}
    return false;
}
var actDashTab=1;
var showDashS=0;
var dashTime=15000;
var dashTi='';
function dashRef(){clearTimeout(dashTi);dashTi=setTimeout(function(){dashRef();dash(0,actDashTab);},dashTime);}
function dash(l=0,n=1){
	actDashTab=n;
	if(l==1){$('.centerSideInFull').html(loader_win);}
	busyReq=chReqStatus();	
	if(winIsOpen()==0 && busyReq==0){
		$.post(f_path+"N/man_dash.php",{n:n,s:showDashS}, function(data){
			d=GAD(data);dd=d.split('^');if(dd.length==2){$('.centerSideInFull').html(dd[1]);$('.centerSideInHeaderFull').html(dd[0]);
			}else{$('.centerSideInFull').html(d);}
			fixForm();
			fixPage();		
		});
	}else{
		clearTimeout(dashTi);
		dashTi=setTimeout(function(){dashRef();dash(0,actDashTab);},800);
	}
}
function loadDashDataUpdate(d){
	data=d.split('|');
	for(i=0;i<data.length;i++){
		d2=data[i].split(':');
		if(d2.length==2){
			if(d2[1]==0){				
				$('#'+d2[0]).closest('.dashBloc').hide();
				$('#'+d2[0]).html('0');
			}else{
				$('#'+d2[0]).closest('.dashBloc').show();
				loadNewNum(d2[0],parseInt(d2[1])); 
			}
		}
	}
}
function log_h_ref(){setTimeout(function(){log_h_ref();log_h_ref_Do();},10000);}
function log_h_ref_Do(){
	lf=$('#log_fil').val();
	$.post(f_path+"S/sys_log_his.php",{u:lf}, function(data){d=GAD(data);$('.centerSideIn').html(d);fixPage()});}
function loadNewNum(id,n){
	allTime=1000;
	chTime=100;
	old=$('#'+id).html();
	o=parseInt(old.replace(',',''));
	if(o!=n){
		b=n-o;		
		moveingSteps=allTime/chTime;		
		changSteps=b/moveingSteps;
		changNum(moveingSteps,chTime,id,n);
		
	}
}
function changNum(MS,chTime,id,n){
	old2=$('#'+id).html().replace(',','');
	oo=parseFloat(old2);
	newValN=oo+MS;
	if(newValN>n){
		newValN=n;		
	}else{
		setTimeout(changNum(id,o,n),chTime);
	}
	$('#'+id).html(newValN);
}
function loadDashData(t,n){
	loadWindow('#full_win1',1,k_detal_rep,0,0);
	$.post(f_path+"N/man_dash_data.php",{t:t,n:n}, function(data){d=GAD(data);$('#full_win1').html(d);fixPage();fixForm();})
}
function nav(time,msg){
	clearTimeout(navTimer);
	$('.navMSG > div').hide( function(){
	$('.navMSG > div').html(msg);
	$('.navMSG').show();
	$('.navMSG > div').slideDown(500,function(){
	navTimer=setTimeout(function(){$('.navMSG > div').fadeOut(500,function(){
		$('.navMSG').hide();});
		$('.navMSG > div').css('background-color','');
		},time*1000);
	});
	});
}
function navC(time,msg,color){
	$('.navMSG > div').css('background-color',color);
	nav(time,msg);
}
function clockStr(d,mod){
	h=parseInt(d/3600);
	t='';
	if(mod==1){if(h==12){t=' PM';} else if(h>12){t=' PM';h=h-12;}else{t=' AM';}}
	m=parseInt((d%3600)/60);
	if(m<10){m='0'+m};	
	return h+':'+m+t;
}
function setMintBlc(){
	$('div[mintBlc]').each(function(){
		no=$(this).attr('no');
		$('[mint_h='+no+']').keyup(function(){mintCal($(this).attr('mint_h'));});
		$('[mint_m='+no+']').keyup(function(){mintCal($(this).attr('mint_m'));});
	})
}
function mintCal(n){	
	m_h=$('[mint_h='+n+']').val();
	m_m=$('[mint_m='+n+']').val();
	if(m_h==''){m_h=0;}else{m_h=parseInt(m_h);}
	if(m_m==''){m_m=0;}else{m_m=parseInt(m_m);}	
	if(m_m>=60 || m_m<0){m_m=0;$('[mint_m='+n+']').val(0);}
	realMin=(m_h*60)+m_m;
	
	$('[mint='+n+']').val(realMin);
	if(m_m<10){m_m='0'+m_m;}
	viewMin=m_h+':'+m_m;
	viewMin=m_h+':'+m_m;
	$('[mint_v='+n+']').html(viewMin);	
}
var printW=800;
var printH=600;
function doScript(str){eval(str);}
function printWindow(type,id){url=f_path+'Print/T'+type+'/'+id;popWin(url,printW,printH);}
function printWindow2(type,id,pars){url=f_path+'Print/T'+type+'/'+id+'-'+pars;popWin(url,printW,printH);}
function printWindowC(type,id){url=f_path+'PrintC/T'+type+'/'+id;popWin(url,printW,printH);}
function printWindowC2(type,id,pars){url=f_path+'PrintC/T'+type+'/'+id+'-'+pars;popWin(url,printW,printH);}
function print4(type,id){url=f_path+'Print4/T'+type+'/'+id;popWin(url,printW,printH);}
function print5(type,id){url=f_path+'Print5/T'+type+'/'+id;popWin(url,printW,printH);}
function print6(type,id){url=f_path+'Print6/T'+type+'/'+id;popWin(url,printW,printH);}
function printLab(type,id){url=f_path+'PrintLab/T'+type+'/'+id;popWin(url,printW,printH);}
function printTicket(type,id){url=f_path+'Ticket/T'+type+'/'+id;popWin(url,printW,printH);}
function printTicket2(type,id,pars){url=f_path+'Ticket/T'+type+'/'+id+'-'+pars;popWin(url,printW,printH);}
function printInvoice(type,id,pars=''){
	if(pars!=''){pars='-'+pars;}
	url=f_path+'Invoice/T'+type+'/'+id+pars;popWin(url,printW,printH);
}
function printFixed(type,id,pars=''){
	if(pars!=''){pars='-'+pars;}
	url=f_path+'FixPage/T'+type+'/'+id+pars;
	popWin(url,printW,printH);
}
function ErStl(id,s){
	if(s==1){$(id).css('border-bottom','3px #f00 solid');}else{$(id).css('border','');}
}
function CL(str){console.log(str);}
function chReqStatus(){
	$(function(){
		$(document).ajaxStart(function(){busyReq=1;});
		$(document).ajaxStop(function(){busyReq=0;});
	});	
	return busyReq;
}
function isEx(s){
	if(typeof s!==typeof undefined && s!==false){
		return true;
	}else{
		return false;
	}
}
var userOn=new Array();
function sys_online(){
	$.post(f_path+"S/sys_online_live.php",{},function(data){
		d=GAD(data);
        var obj = jQuery.parseJSON(d);
        actUser=[];
        $('.onlBlc [mod]').html('');
        $.each(obj, function (key,data){
            if(jQuery.inArray(data[0], actUser) === -1){actUser.push(data[0]);}
            $('.onlBlc [t='+data[0]+']').html(clockStr(data[1]));
            $('.onlBlc [u='+data[0]+']').attr('ti',data[1]);
            $('.onlBlc [mod='+data[0]+']').append('<div b="'+data[3]+'">'+data[2]+'</div>');
            u=$('.onlBlc [u='+data[0]+']');            
            if(u.attr('s')=='0'){shHiBlc(u,1);}
        })
        $('.onlBlc [u][s=1]').each(function(){
			un=$(this).attr('u');	
            if(jQuery.inArray(un, actUser) === -1){
                u=$('.onlBlc [u='+un+']');
                shHiBlc(u,0);
            }
		})
        $('#m_total').html('<ff> ( '+actUser.length+ ' )</ff> ');
        sortOnTable();
		fixForm();
		fixPage();
	})
}
function sortOnTable(){
    s=1;
    i=0;
    t=1;
    while(s==1 && t<1000){
        s=0;
        for(i=0;i<=$('#onlBlc div[s=1]').length;i++){
            sel1=$('#onlBlc div[s=1]:eq('+i+')');
            sel2=$('#onlBlc div[s=1]:eq('+(i+1)+')');        
            r1=parseInt(sel1.attr('ti'));
            r2=parseInt(sel2.attr('ti'));
            if(r2){
                if (r2<r1){
                    $(sel2).after(sel1);                    
                    s=1;
                    i=0;                    
                }
            }
        }
        t++;
    }
}
function shHiBlc(u,s){
    if(s==0){
        u.animate({backgroundColor:'#f99'},5000,'swing',function(){
            u.css('background-color','#faa');
            u.attr('s',s);
        });
    }
    if(s==1){
        u.attr('s',s);
        u.css('background-color','#9f9');
        u.animate({backgroundColor:'#fff'},5000,'swing');
    }
}
function timeToIntger(t){
	out=0;
	if(t!=''){
		c=t.substr(0,2);
		h=parseInt(t.substr(3,2));
		m=parseInt(t.substr(6,2));
		if(c=='PM' && h!=12){h+=12;}
		out=(h*3600)+(m*60);
	}
	return out;
}
function get_form_vals(sel){
	var data={};
	$(sel).find('[name]').each(function(){
		elm=$(this).attr('name');
		val=$(this).val();
		data[elm]=val;
	})
	return data;
}

function selSetCat(c){
	$('.setTab tr[pro]').hide();
	$('.setTab tr[pro='+c+']').show();
}
var reqs=0;
function ajaxSend(){reqs++;showConectSta();}
function ajaxStart(){$('#conectS div[c]').show();}
function ajaxEnd(){
    if(reqs>0){reqs--;}else{reqs=0;}   
    if(reqs==0){reqsTime=0;}
    showConectSta();
}
function showConectSta(){
    $('#conectS').html(reqs);
    sCol='#7ef890';
    if(reqs>2){sCol='#f9e964';}
    if(reqs>4){sCol='#ff4040';}
    if(reqs){
		$('#conectS').css('background-color',sCol);
        $('#conectS').css('color',sCol);
        $('#conectS div[c] div').css('background-color',sCol);
	}else{
		$('#conectS').css('background-color','');
        $('#conectS').css('color','');
        $('#conectS div[c]').hide();
	}
}
var hintTime='';
function loadHintData(obj){
    clearTimeout(hintTime);    
    hintTime=setTimeout(function(){        
        let code=obj.attr('HhB');
        $.post(f_path+"S/sys_hints.php",{code:code},function(data){             
            d=GAD(data);
            obj.attr("title",d);
            obj.data("ui-tooltip-title",d);
            $('.PageLoaderWin').show();        
            setTimeout(function(){$('.PageLoaderWin').hide();},1);            
            obj.tooltip({track:true,content:function(){return $(this).prop('title');},});
            obj.on("tooltipclose",function(event,ui){$(this).attr('title','');})

        })
    },3000);
}
function nl2br(str){if(str){return str.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g,'$1<br>');}}
function br2nl(str){if(str){return str.replace(/<\s*\/?br\s*[\/]?>/gi,"\n");}}
function number_format(number, decimals, dec_point='.',thousands_sep=',') {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}
/***********************************************/
var actUpBox='';
var maxFileUp=1;
var maxUpSize=100;//MB
var aniSpeed=200;
var setUpbox=0;
function upboxSet(){
    if(setUpbox==0){
        setUpbox=1;
        if($('#ubUp').length==0){
           $('body').append('<input type="file" id="ubUp" style="display:none"/>');
        }
        $('body').on('dragover','[upBox] [addImg]',function(){        
            $(this).addClass('upBox_over');return false;
        })
        $('body').on('dragleave','[upBox] [addImg]',function(){        
            $(this).removeClass('upBox_over');return false;
        })
        $('body').on('drop','[upBox] [addImg]',function(e){ 
            $(this).removeClass('upBox_over');				
            e.preventDefault();			  
            var files_list = e.originalEvent.dataTransfer.files;			
            fileSelectedN($(this).closest('[upBox]'),files_list);
        })
        $('body').on('click','[upBox] [addImg]',function(){        
            item=$(this).closest('[upBox]');        
            $('#ubUp').trigger('click');        
            $('#ubUp').change(function(e){			
                var files_list = document.getElementById('ubUp').files;					
                fileSelectedN(item,files_list);
            });
        })
        $('body').on('click','[upBox] [delI]',function(){
            c_id=$(this).attr('delI');            
            obj=$(this).closest('[upBox]');
            actUpBox=obj.attr('upBox');
            r_id=obj.attr('r_id');
            code=obj.attr('c');
            proge=`<div class="progResDel in  w100" no="${actUpBox}">
                <div class="f1">${k_deleting}</div>
            </div>`;
            obj.prepend(proge);
            obj.find('.progResDel').slideDown(200);            
            $(".progResDel[no='"+actUpBox+"']").slideDown(aniSpeed,function(){
                if(r_id=='0'){
                    $.post(f_path+"S/sys_upImageDelN.php",{id:c_id,code:code},function(data){
                        d=GAD(data);		
                        if(d==1){upBobDelUI(obj,actUpBox);actUpBox='';}
                    })
                }else{
                    upBobDelUI(obj,actUpBox);
                    actUpBox='';
                }
                
            })
        })
    }
}
function upBobDelUI(obj,actUpBox){
    let multi=obj.attr('m');//multi
    if(multi=='0'){                        
        obj.find('[addImg]').show();
        $(".dataBar[no='"+actUpBox+"']").hide();
        $("input[name='"+actUpBox+"']").val('');
    }else{
        newVal='';
        old_val=$("input[name='"+actUpBox+"']").val();
        old_valArr=old_val.split(',');
        if(old_valArr.length>1){
            for(i=0;i<old_valArr.length;i++){
                if(old_valArr[i]!=c_id){
                    if(newVal!=''){newVal+=',';}
                    newVal+=old_valArr[i];
                }   
            }
        }
        $("input[name='"+actUpBox+"']").val(newVal);
    }
    $("[upBox] [imgc='"+c_id+"']").remove();
    obj.find('.progResDel').slideUp(200,function(){$(this).remove();});    
}
/***/
function fileSelectedN(obj,files_list){
	if(actUpBox==''){
        ub_code=obj.attr('c');
		ub_exe=obj.attr('t');
        fileTypes=ub_exe.split(',');
        ub_multi=obj.attr('m');        
		ub_name=obj.attr('upBox');
		var formData = new FormData();		
		formData.append('name', ub_name);
        formData.append('code', ub_code);
		if(files_list.length<=maxFileUp){
			for(var i=0; i<files_list.length; i++){				
				formData.append('file[]',files_list[i]);
				ub_type=files_list[i]['type'];
				ub_size=files_list[i]['size'];
				ub_name=files_list[i]['name'];
				ub_type=files_list[i]['name'].split('.').pop();
                ub_type=ub_type.toLowerCase();
				if(jQuery.inArray(ub_type,fileTypes)<0){
					nav(3,k_fl_nrq_typ)
				}else if(ub_size>(maxUpSize*1024*1024)){
					nav(3,k_fl_lrg_sz+'('+(maxUpSize/1024/1024)+'MB)');
				}else{
					actUpBox=obj.attr('upBox');
                    proge='<div class="progRes in hide w100" no="'+actUpBox+'">\
                    <div class="w100 fl ub_sta" >\
                        <ff sz>'+number_format(ub_size/1024/1024,2)+'MB </ff> | '+ub_name+'\
                    </div>\
                    <div class="progBar fl w100"><div ubBar="'+actUpBox+'" class="fn2 fl">0%</div></div>\
                    </div>';
                    obj.prepend(proge);
                    obj.find('.progRes').slideDown(200);
					$(".progRes[no='"+actUpBox+"']").slideDown(aniSpeed,function(){
						sendFileData(formData);	
					});
				}
			}
		}else{
			nav(3,k_only_one_file_up);
		}
	}
}
function sendFileData(formData){    
	var xhr = new XMLHttpRequest();
	xhr.upload.addEventListener("progress", uploadProgressN, false);
	xhr.addEventListener("load",uploadCompleteN,false);
	//xhr.addEventListener("error", uploadFailed, false);
	//xhr.addEventListener("abort", uploadCanceled, false);
	xhr.open("POST",f_path+"S/sys_upImageN.php");
	xhr.send(formData);
}
function uploadProgressN(evt){
	if(evt.lengthComputable){
		upFile_Size=evt.total;
		loaded_Size=evt.loaded;
		per=loaded_Size * 100 / upFile_Size;
		var complete = Math.round(per);	
		fileSize=sizeMood(upFile_Size);
		loadSize=upFile_Size*per/100;
		loadSize2=sizeMood(loadSize);
		$(".progRes[no="+actUpBox+"] [sz] ").html(loadSize2+' / '+fileSize);
        
		$("[ubBar='"+actUpBox+"']").width(complete+'%');
		$("[ubBar='"+actUpBox+"']").html(complete+'%');
	}else{
		nav(3,k_upload_not_completed);
		$(".progRes[no='"+actUpBox+"']").slideUp(aniSpeed,function(){$(this).remove();});
		//$("[upbox='"+actUpBox+"']").slideDown(aniSpeed);
	}
}
function sizeMood(n){
	out=n;
	if (n>1024*1024){
		out=(Math.round(n*10/(1024*1024))/10).toString()+' MB';
	}else{
		out=(Math.round(n*10/1024)/10).toString()+' KB';
	}
	return out;
}
function uploadCompleteN(evt){
	$('#ubUp').val('');	
    let box=$("[upbox='"+actUpBox+"']");
    cb=box.attr('cb');    
    multi=box.attr('m');
    res=evt.target.responseText;
    let obj = JSON.parse(res);
    let status= obj['status'];
    if(status=='1'){
        if(cb){            
            cb=cb.replace('[data]',res);            
            eval(cb);
        }
        let no= obj['no'];
        let themp= obj['themp'];
        let file= obj['file'];
        let org_file= obj['org_file'];
        let width= obj['width'];
        let height= obj['height']; 
        let size= sizeMood(obj['size']);
        let ex= obj['ex'];
        addFileName='';
        if(ex=='mp4'){addFileName='?iframe=true&width=80%&height=80%';}        
        if(multi=='0'){box.find('[addImg]').hide();}
        if(multi=='1'){
            box.find('[addImg]').removeAttr('add');
            box.find('[addImg]').attr('addB','');
        }
        $(".dataBar[no='"+actUpBox+"']").slideDown(aniSpeed);
        view=`
            <div class="w100 fl" imgC="${no}"  width="50">
                <div class="fl Over" href="${file}${addFileName}" rel="lf"><img class="alb_imgs" width="50" src="${themp}"/></div>
                <div class="fl of">
                    <div delI="${no}"></div>
                    <div class=" lh30 fs14">${org_file}</div>
                    <div class=" lh20 B" szI>${size}</div>
                </div>
            </div>
        `;
        if(multi){
            let val=$("input[name='"+actUpBox+"']").val();
            if(val!=''){val+=',';}
            val+=no;
            $("input[name='"+actUpBox+"']").val(val);
            $(".dataBar[no='"+actUpBox+"']").append(view);
        }else{
            $("input[name='"+actUpBox+"']").val(no);            
            $(".dataBar[no='"+actUpBox+"']").html(view);
        }
    }else{
        let errNo= obj['errNo'];
        let errMsg= obj['errMsg'];
        navC(3,errMsg,'#f00');
    }
    $(".progRes[no='"+actUpBox+"']").slideUp(aniSpeed,function(){$(this).remove();});	
	actUpBox='';
    fixPage();	
}
/***********************************************/
var ptDataArr=[];
var ptDataCols={'1':1,'11':2,'111':3,'12':2,'21':2};
var tpt='';
var actPTTmpe=0;
var PTTmpeListData=[];
var actPTCode='';
function editPageTxt(code,tpVal=''){
    actPTCode=code
    loadWindow('#full_win1',1,k_data,0,0);
    if(tpVal==''){
        tpVal=$('[name='+code+']').val();        
    }
    
	$.post(f_path+"S/sys_tp_main.php",{code:code,val:tpVal}, function(data){
        d=GAD(data);
        $('#full_win1').html(d);
        fxObjects($('.win_free'));
        setTpEditor();               
        fixPage();
    })
}
function setTpEditor(){
    $('.tpEditor').on('click','[saveTpAll]',function(){tp_save();})
    $('.tpEditor').on('click','[tp_row]',function(){tp_addRow($(this).attr('tp_row'));})
    $('.tpEditor').on('click','[saveTp]',function(){tp_saveData($(this));}) 
    $('.tpEditor').on('click','[editTp]',function(){tp_editData($(this));})
    $('.tpEditor').on('click','[tpDelRow]',function(){tp_delDataRow($(this));})
    $('.tpEditor').on('click','[delTp]',function(){tp_delData($(this).closest('[tpblcCode]'));})
    
    $('.tpEditor').on('click','[tpTempSave]',function(){tpTempSave();})
    
    $('body').on('click','[tptn]',function(){
        tptn=($(this).attr('tptn'));
        actPTTmpe=tptn;        
        $('[tptd]').hide();
        $('[tptd="'+tptn+'"]').show();
    })
    $('.tpEditor').on('click','[tpTempLoad]',function(){tpTempLoad();})
    $('.tpEditor [ptType]').draggable({
            revert: true ,
            start: function(event,ui){                
                $('.tp_toolList').css('overflow-x','visible');  
                tpt=$(this).attr('pttype');
            },
            stop: function(event,ui){
                $('.tp_toolList').css('overflow-x','hidden');
                tpt='';
            },
            drag: function(event, ui){},		
			revert:true,
    });
    $('.tpEditorRows').each(function(index, element){        
        $(this).sortable({
            axis:"y",
            cursor:"move",
            distance:3,
            items:"[tp_r] ",				
            handle:".reSoHold",
            revert:true,
            tolerance: "pointer",
        });		
	});
    tp_setDrop();          
    fixPage();
    loadTpData();
}
function loadTpData(){ 
    ptDataArr=[];
    $('[tpBlcCode]').each(function(){            
        tp_code=$(this).attr('tpBlcCode');
        tp_type=$(this).attr('tptype');            
        if(tp_type=='h2' || tp_type=='h3' || tp_type=='h4'){
            ptTitle=$(this).find(tp_type).html();                
            ptDataArr[tp_code]={type:tp_type,'ptTitle':ptTitle}
        }else if(tp_type=='p'){
            ptText=br2nl($(this).find('p').html());
            ptDataArr[tp_code]={type:tp_type,'ptText':ptText}        
        }else if(tp_type=='hp'){
            ptTitle=$(this).find('h2').html();
            ptText=br2nl($(this).find('p').html());
            ptDataArr[tp_code]={type:tp_type,'ptTitle':ptTitle,'ptText':ptText}        
        }else if(tp_type=='img'){
            imgId=$(this).find('img').attr('no');
            imgSrc=$(this).find('img').attr('src')
            imgLink=$(this).find('a').attr('href');
            
            ptDataArr[tp_code]={type:tp_type,'id':imgId,'src':imgSrc,'link':imgLink}        
        }else{
            ptDataArr[tp_code]={type:''}        
        }
    })
    //CL(ptDataArr)
}
function tp_setDrop(){
    $('.tpEditor [tpBlcCode][s="0"]').droppable({
        drop: function(event,ui){			
            tpCode= $(this).attr("tpBlcCode");            
            if(tpt){
                tp_buildTemp(tpCode,tpt);
            }
        },
        over: function(event,ui){
            if($(this).attr('tptype')==''){
                $(this).css("background-color",'#afa');
            }
        }
    });
    $('.tpEditor [tpBlcCode][s="0"]').attr('s','1');
}
function tp_buildTemp(code,type,data='',editR=0){
    if($('[tpBlcCode='+code+']').attr('tptype')=='' || editR==1){
        $('[tpBlcCode='+code+']').css('background-color','#ffa');
        imgId='';
        tpEdit=0;
        if(editR==0){$('[tpBlcCode='+code+']').attr('tptype',tpt);}
        tp_out='<div>';
        if(type=='h2' || type=='h3' || type=='h4' || type=='hp'){
            val='';
            if(data.ptTitle){val=data.ptTitle;}
            tp_out+='<input type="text" class="mg10v" placeholder="العنوان" value="'+val+'" tpd_title/>';         
        }
        if(type=='hp' || type=='p'){
            val='';
            if(data.ptText){
                val=data.ptText.replace(/\n\n/g,"\n");                
            }        
            tp_out+='<textarea class="mg10v w100 so" t placeholder="الفقرة" tpd_text>'+val+'</textarea>'; 
        }
        if(type=='img'){
             tp_out='<div>';
            val=''; 
            imgId=data.id;            
            if(editR && imgId){
                tp_link=data.link;
                tp_out+='<div toImg="'+code+'">'+loader_win+'</div>';
                tp_out+='<div><input type="text" class="mg10v" placeholder="الرابط" value="'+tp_link+'" tpd_link/></div>';                
                tpEdit=1;
            }else{
                tpImgTemp=$('#tpImage').html();            
                tpImgTemp=tpImgTemp.replace(/tp_photo/g,code);
                tp_out+=tpImgTemp;
                ptDataArr[code]={'type':'img'}
                tp_out+='<div><input type="text" class="mg10v" placeholder="الرابط" value="" tpd_link/></div>';                
            }
            tp_out+='</div>';
        }
        tp_out+=`
            </div>
            <div class="t_bord pd5v">
                <div class="fl i30 i30_save" saveTp title="`+k_save+`"></div>
                <div class="fr i30 i30_x " delTp title="`+k_delete+`"></div>
            </div>`;
        $('[tpBlcCode='+code+']').html(tp_out);
        if(tpEdit){
            loadEditTpImg(code,imgId);
        }
    }
}
function tp_addRow(n){
    cols=ptDataCols[n];
    tp_row=`<div tp_r="${cols}" tp_type="${n}"><div class="reSoHold" title="${k_ord_lst}"><div></div></div>`;
    for(i=0;i<cols;i++){
        let r = Math.floor((Math.random() * 100000) + 1);
        tp_row+=`<div tpBlcCode="tp_${r}" tpType="" s="0"></div>`;
        ptDataArr['tp_'+r]=''; 
    }
    tp_row+=`<div><div class="i40 i40_del" title="${k_delete}" tpDelRow></div></div></div>`;
    $('.tpEditorRows').append(tp_row);
    tp_setDrop();
}
function tp_saveData(obj){
    pt_o=obj.closest('[tpBlcCode]');
    tp_code=pt_o.attr('tpBlcCode');
    tp_type=pt_o.attr('tpType');    
    if(tp_type=='h2' || tp_type=='h3' || tp_type=='h4'){
        ptDataArr[tp_code]={'type':tp_type,'ptTitle':pt_o.find('[tpd_title]').val()}
    }else if(tp_type=='p'){
        ptDataArr[tp_code]={'type':tp_type,'ptText':pt_o.find('[tpd_text]').val()}        
    }else if(tp_type=='hp'){
        ptDataArr[tp_code]={
            'type':tp_type,
            'ptTitle':pt_o.find('[tpd_title]').val(),
            'ptText':pt_o.find('[tpd_text]').val()
        }        
    }else if(tp_type=='img'){
        ptDataArr[tp_code].link=pt_o.find('[tpd_link]').val();
        
    }else{        
        ptDataArr[tp_code]={'type':''}
    }
    tp_blcView(tp_code,tp_type);    
}
function tp_editData(obj){
    pt_o=obj.closest('[tpBlcCode]');
    tp_code=pt_o.attr('tpBlcCode');
    tp_type=pt_o.attr('tpType');    
    tp_buildTemp(tp_code,tp_type,ptDataArr[tp_code],1)    
}
function tp_delData(pt_o){
    //pt_o=obj.closest('[tpBlcCode]');
    tp_code=pt_o.attr('tpBlcCode');
    tp_type=pt_o.attr('tpType');
    $('[tpBlcCode='+tp_code+']').html('');
    $('[tpBlcCode='+tp_code+']').attr('tptype','');
    $('[tpBlcCode='+tp_code+']').css('background-color','#fff');
    ptDataArr[tp_code]={type:''};
    //CL(ptDataArr)
}
function tp_delDataRow(obj){
    pt_o=obj.closest('[tp_r]');
    pt_o.find('[tpBlcCode]').each(function(){tp_delData($(this));})
    pt_o.remove();
}
function tp_blcView(code,tp_type){
    tp_str='<div>';
    tpErr=0;tpErr=0
    data=ptDataArr[code];
    if(tp_type=='h2' || tp_type=='h3' || tp_type=='h4' ){
        if(data.ptTitle){
            tp_str+='<'+tp_type+'>'+data.ptTitle+'</'+tp_type+'>';        
        }else{
             tp_str+=emptyTP_data(tp_type);
        }
    }else if(tp_type=='p'){        
        if(data.ptText){
            tp_str+='<p>'+nl2br(data.ptText)+'</p>';        
        }else{
             tp_str+=emptyTP_data(tp_type);
        }
    }else if(tp_type=='hp'){
        if(data.ptTitle || data.ptText){
            tp_str+='<h2>'+data.ptTitle+'</h2>';
            tp_str+='<p>'+nl2br(data.ptText)+'</p>';        
        }else{
             tp_str+=emptyTP_data(tp_type);
        }
    }else if(tp_type=='img'){
        if(data!=''){
            if(data.src){
                tp_str+='<img src="'+data.src+'" no="'+data.id+'" width="100%"/>';
            }else{
                tp_str+=emptyTP_data(tp_type);
            }
            if(data.link){
                tp_str+='<a href="'+data.link+'" class="f1 clrw" target="blank"><div class="f1 fs14 icc22 clrw TC">الرابط</div></a>';
            }
        }else{
            tpErr=1;
            nav(3,'')
        }
    }
    tp_editButt='</div><div class="t_bord pd5v"><div class="fr i30 i30_edit" title="'+k_edit+'" editTp></div><div class="fr i30 i30_x" title="'+k_delete+'" delTp></div></div>';
    if(tpErr==0){
        $('[tpBlcCode='+code+']').html(tp_str+tp_editButt); 
        $('[tpBlcCode='+code+']').css('background-color','#fff'); 
    }
}
function emptyTP_data(type){
    return '<div emptyTp="'+type+'"></div>';    
}
function tp_save(){
    if($('.tpEditorRows [savetp]').length){
        nav(3,'يجب حفظ الفقرات المفتوحة قبل الحفظ');
    }else{
        s_code=$('.tpEditorRows').attr('code');
        savTpData=[];
        $('.tpEditorRows [tp_r]').each(function(){
            rn=$(this).attr('tp_r');
            rType=$(this).attr('tp_type');         
            blocks=[{'rt':rType}];
            $(this).find('[tpBlcCode]').each(function(){
                bCode=$(this).attr('tpBlcCode');
                //alert(ptDataArr[bCode])
                blocks.push(ptDataArr[bCode]);
            })
            //savTpData.push=['-'+rType,blocks];
            savTpData.push(blocks);
        })
        //CL(savTpData)
        tpJSON = JSON.stringify(savTpData);
        $('input[name='+s_code+']').val(tpJSON);
        let ptSize = tpJSON.length;
        $('[tpCode='+s_code+'] [sz]').html(sizeMood(ptSize*8));
        win('close','#full_win1');        
        //CL(ptDataArr)
    }
}
function tpImgLoad(code,data=''){    
    ptDataArr[code].id=data['no'];
    ptDataArr[code].src=data['file'];
    //CL(ptDataArr)
}
function loadEditTpImg(code,id){
    if(id){
        $.post(f_path+"S/sys_tp_edit_img.php",{id:id,code:code}, function(data){
            d=GAD(data);
            $('[toimg='+code+']').html(d);
        });
    }
}
var actTpTemp='';
function tp_saveTemp(){
    if($('.tpEditorRows [savetp]').length){
        nav(3,'يجب حفظ الفقرات المفتوحة قبل الحفظ');
    }else{
        s_code=$('.tpEditorRows').attr('code');
        savTpData=[];
        $('.tpEditorRows [tp_r]').each(function(){
            rn=$(this).attr('tp_r');
            rType=$(this).attr('tp_type');         
            blocks=[{'rt':rType}];
            $(this).find('[tpBlcCode]').each(function(){
                bCode=$(this).attr('tpBlcCode'); 
                blocks.push({type:ptDataArr[bCode].type});
            })
            savTpData.push(blocks);
        })
        tpJSON = JSON.stringify(savTpData);
        return tpJSON;
    }
}
function tpTempSave(){
    loadWindow('#m_info5',1,k_save_as_temp,600,0);
    d=tp_saveTemp();
    actTpTemp=d;
	$.post(f_path+"S/sys_tp_temp.php",{data:d}, function(data){
		d=GAD(data);					
		$('#m_info5').html(d);
        $('#tpTempName').focus();
        $('[tpTempDo]').click(function(){tpTempSaveDo();})
		fixForm();
        fixPage();
	})
}
function tpTempSaveDo(){
    tempName=$('#tpTempName').val();
    if(tempName){
        loader_msg(1,k_loading);
        $.post(f_path+"S/sys_tp_temp_save.php",{name:tempName,data:actTpTemp}, function(data){
            d=GAD(data);
            if(d==1){
                msg=k_done_successfully;mt=1;                
                win('close','#m_info5')
            }else{
                msg=k_error_data;mt=0;
            }
            loader_msg(0,msg,mt);	
        })
    }else{
        nav(3,'يجب ادخال اسم النموذج');
    }
}
function tpTempLoad(){
    loadWindow('#m_info5',1,k_templates,800,0);
    d=tp_saveTemp();   
	$.post(f_path+"S/sys_tp_temp_load.php",{data:d}, function(data){
		d=GAD(data);					
		$('#m_info5').html(d);
        fxObjects($('.win_body'));
        $('[tpTempLoadDo]').click(function(){tpTempLoadDo();})
		fixForm();
        fixPage();
	})
}
function tpTempLoadDo(){
    win('close','#m_info5');
    data=PTTmpeListData[actPTTmpe];
    editPageTxt(actPTCode,data)
}
/*******IV Image***********************************/
$(document).ready(function(e){setImgViewer();})   
var ivX=0;
var ivY=0;
function setImgViewer(){
    var viImgW=0;//image width
    var viImgH=0;//image Heigt
    var viVw=0;//viewer width
    var viVh=0;//viewer height
    $('body').on('click','[imgViewer] [iv]',function(){
        imgCode=$(this).attr('iv');
        openimgViewer(imgCode);
    })    
    
}
function openimgViewer(code){
    if($('body .IVWin').length==0){
        iVwin=`        
        <div class="IVWin">
            <div class="ivInfo pd10f ofx so"></div>
            <div class="ivTool">
                <div class="fr" x title="`+k_close+`"></div>
                <div ti class="fl" zOut title="تكبير"></div>
                <div ti class="fl" zIn title="تصغير"></div>
                <div ti class="fl" org title="الحجم الاصلي"></div>
                <div ti class="fl" str title="بحجم الشاشة"></div>
                <div ti class="fl clrw lh40 pd10 fs16" viScl></div>
            </div>
            <div class="ivSrc so" dir="ltr"><div id="ivBox" ></div></div>
        </div>`;
        $('body').append(iVwin);
        $('.IVWin').on('click','[x]',function(){closeIv();})
        $('.IVWin').on('click','[zOut]',function(){ivZoom('in');})
        $('.IVWin').on('click','[zIn]',function(){ivZoom('out');})
        $('.IVWin').on('click','[org]',function(){ivZoom('org');})
        $('.IVWin').on('click','[str]',function(){ivZoom('str');})
        $('#ivBox').draggable({stop: function(event, ui){}});
        setImgScroll();
    }
    loadImgViewer(code);
}
function loadImgViewer(code){
    $('.ivTool div[ti]').hide();
    $('body .IVWin').show();
    $('.IVWin .ivInfo').html(loader_win);
    $('.IVWin .ivSrc > div').html('');    
	$.post(f_path+"S/sys_iv_info.php",{code:code},function(data){
		d=GAD(data);		
        let obj = JSON.parse(d);    
        status= obj['status'];
        if(status=='1'){
            name= obj['name'];
            status= obj['status'];
            date= obj['date'];
            size= obj['size'];
            ex= obj['ex'];
            img= obj['img'];
            src= obj['src'];
            srcW= obj['w'];
            srcH= obj['h'];
            viImgW=srcW;
            viImgH=srcH;
            imgInfo=`
                <div><img src="${img}"/></div>
                <div class="iv_infoIn">
                    <div t>الأبعاد:</div>
                    <div v class="uc">${srcW}X${srcH}</div>
                    <div t>الحجم:</div>
                    <div v>${size}</div>
                    <div t>اللاحقة:</div>
                    <div v class="uc"> ${ex} </div>
                    <div t>الملف:</div>
                    <div v>${name}</div>
                    <div t>التاريخ:</div>
                    <div v>${date}</div>
                </div>
            `;
            $('.IVWin .ivInfo').html(imgInfo);
            loadImgViPhoto('../'+src);
        }
		fixPage();
		fixForm();
	})
}
function loadImgViPhoto(file){
    ivLoader=`
    <div ivLoader class="pd10f">
        <div t>جار التحميل <span vil>( 0% )</span></div>
        <div l><div></div></div>
    </div>`;
    $('#ivBox').css('left','');            
    $('#ivBox').css('top','');
    $('.IVWin .ivSrc > div').html(ivLoader);    
    $.ajax({
        xhr: function () {
            var xhr = new window.XMLHttpRequest();            
            xhr.addEventListener("progress", function (evt) {
                if(evt.lengthComputable){
                    var percentComplete =evt.loaded/evt.total;                    
                    prWidth=percentComplete*100;
                    $('[ivLoader] [l] div').css('width',prWidth+'%');
                    $('[ivLoader] span').html(' ( '+Math.round(prWidth)+'% )');
                }
            },false);
            return xhr;
        },
        type: 'POST',url:file,success: function (data){
            $('.IVWin .ivSrc > div').html('<img src="'+file+'"/>');
            ivZoom('str');
            $('.ivTool div[ti]').show(200);
        }
    });
    
}
function closeIv(){
    $('.IVWin').hide();
    $('.IVWin .ivInfo').html('');
    $('.IVWin .ivSrc > div').html('');
    $('[viScl]').html('');
}
function setImgScroll(){
    $(window).bind('mousewheel', function(event) {
        ivX = event.pageX - $('#ivBox').offset().left;
        ivY = event.pageY - $('#ivBox').offset().top;
        //CL(ivX)
        if (event.originalEvent.wheelDelta >= 0){
            ivZoom('in',1);
        }else{
            ivZoom('out',1);
        }
    });
}
function ivZoom(d,scrll=0){
    yPOs=0;
    xPOs=0;
    xPerc=50;
    yPerc=50;
    newWidth=0;
    viVw=$('.ivSrc').width();
    viVh=$('.ivSrc').height();
    
    ivBoxW=$('#ivBox').width();
    ivBoxH=$('#ivBox').height();     
    switch(d){
        case 'in':
            newWidth=$('#ivBox img').width()*1.1
            if(newWidth<9000){
                $('#ivBox img').width(newWidth);
            }
        break;
        case 'out':
            newWidth=$('#ivBox img').width()*0.9
            if(newWidth>100){
                $('#ivBox img').width(newWidth);
            }
        break;
        case 'org':
            $('#ivBox img').width('');
            margX=((viImgW-viVw)/2)*(-1);
            if(margX<0){$('#ivBox').css('left',margX);}
            margY=((viImgH-viVh)/2)*(-1);
            if(margY<0){$('#ivBox').css('top',margY);}
            viScl=100;
        break;
        case 'str':
            exV=viVw/viVh;
            exI=viImgW/viImgH;
            if(exV<exI){
                viwF=viVw;
            }else{
                viwF=(viImgW*viVh)/viImgH;
            }
            $('#ivBox img').width(viwF); 
            newWidth=$('#ivBox img').width();
        break;
    }   
    viScl=Math.round(newWidth *100/viImgW);    
    if(d=='org'){viScl='100';}
    $('[viScl]').html(viScl+'%'); 
    if(newWidth>100 && newWidth<9000){
        $('#ivBox').css('top','');
        $('#ivBox').css('left','');
        if(scrll){
            xPerc=(ivX*100/ivBoxW);
            yPerc=(ivY*100/ivBoxH);
        }
        if(d=='in' || d=='out'){
            posMarginX=ivBoxW-viVw;
            if(d=='out'){ posMarginX=posMarginX*0.8;}
            if(d=='in'){ posMarginX=posMarginX*1.2;}
            xPOs=(xPerc*posMarginX/100)*(-1);
            if(ivBoxW>viVw){$('#ivBox').css('left',xPOs+'px');}

            posMarginY=ivBoxH-viVh;
            if(d=='out'){ posMarginY=posMarginY*0.8;} 
            if(d=='in'){ posMarginY=posMarginY*1.2;}
            yPOs=(yPerc*posMarginY/100)*(-1);
            if(ivBoxH>viVh){$('#ivBox').css('top',yPOs+'px');}
        }
    }
}
/************Object Biulder************/
var objBRow='';
var objBData='';
var objBCB= '';
var objB_actCode='';
function setbjBil(){
    $('body').on('click','[objBil]',function(){
        let code=$(this).attr('objBil');
        loadObjBil(code);
    })
    $('body').on('click','[addToObj]',function(){        
        objBilAdd();
    })
    $('body').on('click','[delToObj]',function(){        
        $(this).closest('tr').remove();
    })
    $('body').on('click','[endToObj]',function(){        
        getObjData();
    })    
}
function loadObjBil(code){
    objB_actCode=code;
    objBCB=$('[objBil="'+code+'"]').attr('objCb');    
    loadWindow('#m_info5',1,k_lst_itm,800,0);
    val=$('[inp_'+code+']').val();    
	$.post(f_path+"S/sys_objBil.php",{code:code,val:val},function(data){
        d=GAD(data);
        $('#m_info5').html(d);
        objBilAdd(2);
        setObjOrder()
        fixPage();
        fixForm();
	})
}
function objBilAdd(n=1){
    for(i=0;i<n;i++){$('[OLTab] tbody').append(objBRow);}
}
function getObjData(){
    objBData=[];
    text='';
    objRow=0;    
    $('[OLTab] tbody tr').each(function(){ 
        objAdd={};
        rowTitle={};
        objText='';
        rowTitleTxt='';
        rowId=$(this).find('input[v]').val();
        $(this).find('input[t]').each(function(){
            rowTitle[$(this).attr('lg')]=$(this).val();
            rowTitleTxt+='('+$(this).attr('lg')+':'+$(this).val()+')';
        })
        addFiled=0;
        $(this).find('td[d]').each(function(){
            addFiled=1;
            txt=val;
            valObj={};
            txtObj={};
            lang=$(this).attr('l');            
            inpType=$(this).find('[objInpType]').attr('objInpType');
            inpName=$(this).find('[objInpName]').attr('objInpName');            
            if(inpType=='text'){
                if(lang=='1'){  
                    txt='[';
                    $(this).find('input').each(function(){
                        oVal=$(this).val();
                        lgCode=$(this).attr('lg');
                        valObj[lgCode]=oVal;
                        txt+=lgCode+':'+oVal;
                    })
                    txt+=']';                    
                }else{
                    val=$(this).find('input').val();
                }
            }
            if(inpType=='textarea'){val=$(this).find('textarea').val();}
            if(inpType=='list'){
                val=$(this).find('select').val();
                txt=$(this).find('select option[value='+val+']').html();                
            }
            if(inpType=='act'){
                val=0;
                if($(this).find('input:checked').length){val=1;}
            }
            
            if(lang=='1'){
                objAdd[inpName]=valObj;
            }else{                
                objAdd[inpName]=val;
            }
            objText+=':'+txt;
        })
        
        if(rowId){
            text+=rowId+':'+rowTitleTxt+objText+'<br>';            
            if(addFiled){
                objBData.push({'id':rowId,'title':rowTitle,objAdd});
            }else{
                objBData.push({'id':rowId,'title':rowTitle});
            }
        }
        objRow++;
    })
    objBData = JSON.stringify(objBData);    
    objBCB=objBCB.replace('[txt]',text); 
    objBCB=objBCB.replace('[obj]',objBData);
    $('[txt_'+objB_actCode+']').html(text)
    eval(objBCB);
    win('close','#m_info5');
}
function setObjOrder(){	
	$('[OLTab] tbody').sortable({
		axis: "y",
		cursor: "move",
		distance: 3,
		items: " > tr ",
		placeholder:"orderPlace",
		revert: true,
		tolerance: "pointer"
	});	
}
function copyContent(sel){
    txt=$(sel).html();    
    loader_msg(1,'',1);
    loader_msg(0,'تم نسخ البيانات بنجاح',1);
    navigator.clipboard.writeText(txt);
}
function checkGrp(){	
	$('body').on('click','[chGrp]',function(){
		v=$(this).attr('chGrp');
		var ch=false;
		if($(this).is(':checked')==true){ch=true;}	
		$('['+v+']').prop('checked',ch);
	})
}
/****************************** */
var act_back_id='';
function set_backup(){	
	if(sezPage=='Backup'){
		$('[addBackup]').click(function(){backup_add();	})
		$('body').on('click','[prepareBackup]',function(){prepareBackup();})
		$('body').on('click','[saveBackup]',function(){saveBackup();})
		$('body').on('click','[restorBackup]',function(){restorBackup();})
		$('body').on('click','[restorBackupDo]',function(){restorBackupDo();})
		$('body').on('click','[backupDel]',function(){BackupDel($(this).attr('backupDel'));})
		
		backupList();
	}
}
function backup_add(){
	$('#backup_data').html(loader_win);
	$.post(f_path+"S/sys_backup_add.php",{},function(data){
        d=GAD(data);
        $('#backup_data').html(d);
        fixPage();
        fixForm();
	})
}
function prepareBackup(){
	let data='';
	$('[_pro]').each(function(){
		if($(this).prop('checked')){
			row={};
			table=$(this).closest('tr').attr('tab');			
			content=0;
			if($(this).closest('tr').find('[_proc]').prop('checked')){
				content=1;
			}			
			data+=table+','+content+'|';
		}
	})
	let name=$('#backupName').val();
	$('[prepareBackup]').hide();
	$('[prepareBackup]').after(loader_win);	
	$.post(f_path+"S/sys_backup_prepare.php",{name:name,data:data}, function(data){		
		$('.loadeText').remove();
		d=GAD(data);
		let obj = getObj(d);
		if(obj){
			if(obj.err){				
            	loader_msg(0,k_error_data,0);
				$('[prepareBackup]').show();
				$('.loadeText').remove();
			}else{				
				backupList(obj.msg);				
			}
		}
	})
}
function backupList(id=''){
	$('#backUpList').html(loader_win);
	$('#backup_data').html(loader_win);
	$.post(f_path+"S/sys_backup_list.php",{id:id}, function(data){
		$('.loadeText').remove();
		d=GAD(data);
		$('#backUpList').html(d);
		if(id){
			loadSavedBackup(id);
		}
		fixPage();
        fixForm();		
	})
}
function loadSavedBackup(id){
	act_back_id=id;
	$('#backup_data').html(loader_win);
	$.post(f_path+"S/sys_backup_info.php",{id:id}, function(data){		
		$('.loadeText').remove();
		d=GAD(data);
		$('#backup_data').html(d);
		chekAll();
		fixPage();
        fixForm();	
		fixObjects($('body'));	
	})
}
function saveBackup(id=1){		
	$('[saveBackup]').hide();	
	$('[n='+id+']').removeClass('cbg4');
	$('[n='+id+']').addClass('cbg5');
	$.post(f_path+"S/sys_backup_save.php",{b_id:act_back_id,id:id},function(data){
        d=GAD(data);
		//if(typeof d =='object'){alert(1)
			obj =jQuery.parseJSON(d);
			$('#saveBU_info').html(obj.prog);
			id=obj.id;
			next=obj.next;
			if($('[n='+id+']').length){
				$('[n='+id+']').removeClass('cbg5');
				$('[n='+id+']').addClass('cbg6');
				location.href = '#s_'+id;
				if(next){
					saveBackup(next);
				}else{
					backupList(act_back_id);				
				}
			}
			//alert(obj.rows)
		//}
	})
}
function restorBackup(){
	tables=[];
	$('[resTabs]').each(function(){
		if($(this).prop('checked')){
			tables.push($(this).attr('resTabs'));
		}
	})
	if(tables!=''){				
		open_alert(tables,'resBack','هل حقا تريد استرداد البيانات ؟','استرداد البيانات');	
	}else{
		loader_msg(2,'يجب أختيار جدول واحد على الاقل',0);	
	}
}
function prepareRestorBackupDo(tables){
	type=$('#resType').val();
	$('#backup_res_actions').hide();
	$('#backup_res_actions').after(loader_win);	
	$.post(f_path+"S/sys_backup_res_prepare.php",{id:act_back_id,type:type,tables:tables}, function(data){		
		$('.loadeText').remove();
		d=GAD(data);
		let obj = getObj(d);
		if(obj){
			if(obj.err){				
            	loader_msg(0,k_error_data,0);
				$('[prepareBackup]').show();
				$('.loadeText').remove();
			}else{				
				backupList(obj.msg);
				restorBackupDo();
			}
		}
	})
}
function restorBackupDo(){	
	$('#backup_data').html(loader_win);
	$.post(f_path+"S/sys_backup_res_list.php",{id:act_back_id}, function(data){		
		$('.loadeText').remove();
		d=GAD(data);
		$('#backup_data').html(d);
		chekAll();
		fixPage();
        fixForm();	
		fixObjects($('body'));	
		restorSave();
	})
}
function restorSave(id=1){	
	$('[n='+id+']').removeClass('cbg4');
	$('[n='+id+']').addClass('cbg5');
	$.post(f_path+"S/sys_backup_res_save.php",{b_id:act_back_id,id:id},function(data){
        d=GAD(data);
		obj =jQuery.parseJSON(d);
		$('#saveBU_info').html(obj.prog);
		id=obj.id;
		next=obj.next;
		if($('[n='+id+']').length){
			$('[n='+id+']').removeClass('cbg5');
			$('[n='+id+']').addClass('cbg6');
			location.href = '#s_'+id;
			if(next){
				restorSave(next);
			}else{
				backupList(act_back_id);
				BackupDel(act_back_id);
			}
		}
	})
}
function BackupDel(type){
	loader_msg(1,k_loading);
	$.post(f_path+"S/sys_backup_del.php",{id:act_back_id,type:type}, function(data){
		d=GAD(data);
		if(d==1){
			msg=k_done_successfully;mt=1;  
			if(type==2){
				backupList(act_back_id);
			}else{
				backupList();
			}
		}else{
			msg=k_error_data;mt=0;
		}
		loader_msg(0,msg,mt);	
	})
	
}
function setEditor(sel='',height=500){
	if(sel==''){sel='textarea.m_editor';}
	$(sel).summernote({		
		tabsize: 2,
		height: 400,
		toolbar: [
		["style", ["style"]],
		["font", ["bold", "underline", "clear"]],
		["color", ["color"]],
		["para", ["ul", "ol", "paragraph"]],
		["table", ["table"]],
		//["insert", ["link", "picture", "video"]],
		["insert", ["link", "picture"]],
		["view", ["fullscreen", "codeview", "help"]]
		]		
	});
	setTimeout(function(){
		fixPage();
    	fixForm();
	},100)
	

	
}
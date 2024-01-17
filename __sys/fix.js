var mouseX;var mouseY;var XMO=0;var YMO=0;var ctrP=false;
$(document).mousemove(function(e){XMO=mouseX=e.pageX;YMO=mouseY=e.pageY;});
window.onresize = function(){loadPageMove();}
var Dwidth=480;var Dheight=480;
function loadPageMove(){
	fixPage();
	fixForm();
	clearTimeout(p_load);
	p_load=setTimeout(function(){fixPage();fixForm();},150);
}
function fixForm(){
	realSpace=hhh-20;
	$(".ui-dialog-content").each(function(index,element){
        if($(this).dialog("isOpen")){
			topWin=$(this).closest('div[aria-describedby]')		
			attr=topWin.attr('aria-describedby');
			diaBody=$(this).height();
			$(this).height(500);
			for_win=$(this).find('.win_body,.win_body_full,.win_free');
			for_header=$(this).find('.form_header');
			for_body=$(this).find('.form_body');			
			for_body_type=for_body.attr('type');			
			for_foter=$(this).find('.form_fot');			
			for_body.height('auto');
			$(this).dialog('option','height',hhh-20);
			$(this).height('auto');
			winHSpace=42;
			if(for_body_type == "pd0" || for_body_type == "full_pd0"){
				for_body.css('padding','0px');
				//for_body.css('overflow','hidden');
				winHSpace=22;
				//for_body_type = "full";
			}
			if(for_body_type == "full" || for_body_type == "full_pd0"){
				form_h=for_header.height();
				form_f=for_foter.height();
                
                
				form_data_h=for_body.height();	
				$(this).dialog('option','height',hhh-20);			
				for_body.height(diaBody-form_f-form_h-winHSpace);
				win_width=parseInt($(this).dialog('option','width'));
				if(win_width>www-20){$(this).dialog('option','width',www-20);}
			}else{
				if(attr.substring(0,8)=='full_win'){
					$(this).dialog('option','width',www);
					$(this).dialog('option','height',hhh);
					topWin.find('.ui-dialog-title').css('text-align',k_align);				

					$(this).children('.win_body').height(hhh-winSpaceHeight);
					$(this).find('.win_free').height(hhh-winSpaceHeight-10);
					for_body.css('min-height',10);
					form_h=for_header.height();
					form_f=for_foter.height();
					form_data_h=for_body.height();				
					for_body.height(diaBody-form_f-form_h-winHSpace);			
				}else{
					if(typeof for_body[0] != typeof undefined){
						h1=for_body[0].scrollHeight;
						h2=for_body.height()+19;
						if(h1>h2){for_body.height(h2);}
					}
					win_width=parseInt($(this).dialog('option','width'));
					if(win_width>www-20){$(this).dialog('option','width',www-20);}			
					h_win=$(this).height();
					if(h_win>realSpace-40){$(this).dialog('option','height',realSpace);h_win=$(this).height();}

					diaBody=$(this).height();
					$(this).children('.win_body').height(h_win-winSpaceHeight);
					$(this).find('.win_free').height(hhh-winSpaceHeight-10);
					form_h=for_header.height();
					form_f=for_foter.height();
					form_data_h=for_body.height();				
					for_body.height(diaBody-form_f-form_h-winHSpace);					
					if(for_body_type == "static"){for_body.css('overflow','hidden');
					}else{for_body.css('overflow-x','hidden');}				
				}
			}
			if(for_body_type == "static"){for_body.css('overflow','hidden');}
			else{for_body.css('overflow-x','hidden');}
			$(this).dialog({ position: { my: "center", at: "center" }});
			/*********Res****************/
			fixObjects(for_win);
		}		
    }); 
	
	$('[actButt]').each(function(){
		actBName=$(this).attr('actButt');
		bsSet=$(this).attr('set');
		if(bsSet!=1){
			$(this).attr('set','1');
			$(this).children('div').click(function(){
				$(this).closest('[actButt='+actBName+']').children('div').removeAttr(actBName);
				$(this).attr(actBName,'1');			
			})
		}
	})
	$('[actButtE]').each(function(){
		actBName=$(this).attr('actButtE');
		bsSet=$(this).attr('set');
		if(bsSet!=1){
			$(this).attr('set','1');
			$(this).children('div').click(function(){
				attr=$(this).attr(actBName);
				if(typeof attr!==typeof undefined && attr!==false){
					$(this).removeAttr(actBName);				
				}else{
					$(this).closest('[actButtE='+actBName+']').children('div').removeAttr(actBName);
					$(this).attr(actBName,'1');
				}
			})
		}
	})
	$('[actButtM]').each(function(){
		actBName=$(this).attr('actButtM');
		bsSet=$(this).attr('set');
		if(bsSet!=1){
			$(this).attr('set','1');
			$(this).children('div').click(function(){
				attr=$(this).attr(actBName);
				all=$(this).attr('all');
				
				if(isEx(attr)){
					if(isEx(all)){
						$(this).parent().children('div').removeAttr(actBName);
					}else{
						$(this).removeAttr(actBName);
					}
				}else{
					if(isEx(all)){
						$(this).parent().children('div').attr(actBName,'');
					}else{
						$(this).attr(actBName,'');
					}
				}
				
			})
			$(this).removeAttr('actButtM');
		}
	})	
	$('[par=chAll]').each(function(){
		$(this).click(function(){
			ch=$(this).children('div').attr('ch');
			cv=1;
			if(ch=='off'){cv=0;}	
			a=$(this).closest('table').find('.form_checkBox').each(function(){
				c=$(this).attr('ch_name');
				if(c!=''){
					CBC(c,cv);
				}
			})
		})
	})
	$(function(){$(':input[type=number]').on('mousewheel',function(e){ $(this).blur(); });});
}
function fixSpaces(t,obj,full=0){
	out=0;
	if(t=='h'){
		out+=parseInt(obj.css("border-top-width"));
		out+=parseInt(obj.css("border-bottom-width"));
		out+=parseInt(obj.css("padding-top"));
		out+=parseInt(obj.css("padding-bottom"));
		out+=parseInt(obj.css("margin-top"));
		out+=parseInt(obj.css("margin-bottom"));
		if(full==1){out+=parseInt(obj.height());}
	}
	if(t=='w'){
		out+=parseInt(obj.css("border-left-width"));
		out+=parseInt(obj.css("border-right-width"));
		out+=parseInt(obj.css("padding-left"));
		out+=parseInt(obj.css("padding-right"));
		out+=parseInt(obj.css("margin-left"));
		out+=parseInt(obj.css("margin-right"));
		if(full==1){out+=parseInt(obj.width());}
	}
	return out;
}
function fixObjects(obj){
	obj.find('[fix]').each(function(){
		fix_p=$(this).attr('fix');		
		if(typeof fix_p != typeof undefined){
			fix_pd=fix_p.split('|');
			fixPars=fix_pd.length;
			for(f=0;f<fixPars;f++){
				fix_pd2=fix_pd[f].split(':');
				fix_v=parseInt(fix_pd2[1]);
				c=fix_pd2[0].substr(0,1);
				if(c=='h'){
					pearntHeight=$(this).parent().height();
					fixH=0;
					if(fix_pd2[2]){				
						fixRec=fix_pd2[2].split(',');
						for(x=0;x<fixRec.length;x++){							
							fixRecIN=fixRec[x].split('-');
							if(pearntHeight<parseInt(fixRecIN[0])){									
								fix_pd2[0]=fixRecIN[1];
								fix_v=parseInt(fixRecIN[2]);
							}
						}
					}
					xSpac=fixSpaces('h',$(this));
					if(fix_pd2[0]=='hp'){fixH=pearntHeight-fix_v;}
					if(fix_pd2[0]=='hp%'){fixH=fix_v*(pearntHeight)/100;}					
					if(fix_pd2[0]=='hw'){fixH=hhh-fix_v;}
					if(fix_pd2[0]=='hw%'){fixH=hhh/fix_v*100;}
					if(fix_pd2[0]=='h'){fixH=fix_v;}
					if(fix_pd2[0]=='hp*'){						
						objC=$(this);
						xObjs=0;
						$(this).attr('mwf','1');						
						$(this).parent().children('div').each(function(){
							if(!$(this).attr('mwf')){xObjs+=fixSpaces('h',$(this),1);}
						})
						fixH=$(this).parent().height()-(xObjs+fix_v);						
					}
					fixH=fixH-xSpac;
					fixH=parseInt(fixH);
					if(fixH>0){$(this).height(fixH);}
				}
				if(c=='w'){
					pearntWidth=$(this).parent().width();
					fixW=0;
					if(fix_pd2[2]){						
						fixRec=fix_pd2[2].split(',');
						for(x=0;x<fixRec.length;x++){							
							fixRecIN=fixRec[x].split('-');
							if(pearntWidth<parseInt(fixRecIN[0])){								
								fix_pd2[0]=fixRecIN[1];
								fix_v=parseInt(fixRecIN[2]);
							}
						}
					}
					xSpac=fixSpaces('w',$(this));
					if(fix_pd2[0]=='wp'){fixW=pearntWidth-fix_v;}
					if(fix_pd2[0]=='wp%'){fixW=fix_v*(pearntWidth)/100;}					
					if(fix_pd2[0]=='ww'){fixW=www-fix_v;}
					if(fix_pd2[0]=='ww%'){fixW=www/fix_v*100;}
					if(fix_pd2[0]=='w'){fixW=fix_v;}
					if(fix_pd2[0]=='wp*'){						
						objC=$(this);
						xObjs=0;
						$(this).attr('mwf','1')
						$(this).parent().children('div').each(function(){
							if(!$(this).attr('mwf')){xObjs+=fixSpaces('w',$(this),1);}
						})
						fixW=$(this).parent().height()-(xObjs+fix_v);						
					}
					fixW=fixW-xSpac;
					fixW=parseInt(fixW);				
					if(fixW>0){$(this).width(fixW);}
				}
				if(c=='b'){
					wSpac=0;//fixSpaces('w',$(this),0);
					hSpac=0;//fixSpaces('h',$(this),0);
					fW=$(this).parent().width();
					fH=$(this).parent().height();
					squ=fW;
					if(fW>fH){squ=fH;}
					//CL(squ+'-'+wSpac+'-'+hSpac);
					$(this).width(squ-(fix_v+wSpac));
					$(this).height(squ-(fix_v+hSpac));
				}
			}					
		}
	})
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
	fixObjects($('body'));
}
$(document).ready(function(){
    fixPage();
})

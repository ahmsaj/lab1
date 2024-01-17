/***API***/
$(document).ready(function(e){
    if(sezPage=='Chat'){setChat();}
    if(sezPage=='Patient-complaints' || sezPage=='Patient-complaints-f'){setComplaints();}
    if(sezPage=='Promotion-manager'){setPromotion();}
});
function changALink(){
    $('#cof_vnenl650c0').change(function(){
        v=$(this).val();
        $('#setAL').html(loader_win);
        f=$('#setAL').attr('f');
        $.post(f_path+"X/api_link_set.php",{v:v,f:f}, function(data){
            d=GAD(data);
            $('#setAL').html(d);
            fixForm();
            fixPage();		
            loadFormElements('#co_form0');
        })
    })
}
function postInfo(id){
	loadWindow('#m_info',1,k_details,500,200);		
	$.post(f_path+"X/api_post_info.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info').html(d);			
		fixForm();
		fixPage();
	})
}
function publishPost(id){
    open_alert(id,'api1','هل تود النشر المحتوى','نشر');
}
function publishPostDo(id){
    loader_msg(1,k_loading);		
	$.post(f_path+"X/api_post_publish.php",{id:id},function(data){
		d=GAD(data);	
		if(d==1){
			msg=k_done_successfully;mt=1;
			postNoti(id);
            loadModule('ocx1vr2l0k');
		}else{
			msg=k_error_data;mt=0;
		}
		loader_msg(0,msg,mt);
	})
}
function postNoti(id){
    loadWindow('#m_info',1,'إرسال الإشعارات',500,500);		
	$.post(f_path+"X/api_post_send.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info').html(d);			
		fixForm();
		fixPage();
	})
}
var ssn='';
function strSendNot(postId,snData=''){
    clearTimeout(ssn);
    if(snData==''){$('#sendNot').html(loader_win);}
	$.post(f_path+"X/api_post_send_do.php",{id:postId},function(data){
		d=GAD(data);
        dd=d.split('^');
        nData=dd[1];
        if(dd.length==2){
            if(dd[0]=='1'){
                ssn=setTimeout(function(){
                    strSendNot(postId,1);
                },3000);
            }
		    $('#sendNot').html(dd[1]);
        }
		fixForm();
		fixPage();
	})
}
/***********Chat**************************/
var actChat=0;
var chatLeft=0;
var chatLastId=0;
var wsTime='';
var wsTimeS='';
var prvT='';
var loadPrvSt=0;
var chatSes=0;
function setChat(){
    checkSes();
}
function checkSes(){
    clearTimeout(wsTimeS);
    $.post(f_path+"X/api_chat_check.php",{pn:pageN},function(data){		
        d=GAD(data);
        dd=d.split('^')
        if(dd[0]==1){
            wSrv();
            $('.blcCaht').hide();
            $('#chats').html(dd[1]);
            $('.chatList').click(function(){openChat($(this).attr('c'));})
        }else{
            $('.blcCaht div div').html(dd[1]);            
            wsTimeS=setTimeout(function(){checkSes();},3000);
        }
	})
}
function openChat(id,p=0){
    actChat=id;
    $('.chatList').removeAttr('act');
    if(p==0){$('#massContent').html(loader_win);}
	$.post(f_path+"X/api_chat_mess.php",{id:id,p:p},function(data){         
		d=GAD(data);
        dd=d.split('^');
        chatLeft=parseInt(dd[0]);        
        chatLastId=dd[1];
        $('.chatList[c='+id+']').attr('act','1');
        $('.chatList[c='+id+'] [n]').attr('n','0');
        $('.chatList[c='+id+'] [n]').html('0');
			
        if(p==0){
            $('#massContent').html(dd[2]);
            scrollPos = $('[p]:last').position().top;            
            $(".mesIn").animate({scrollTop:scrollPos},500,function(){
                $(".mesIn").scroll(function(){scrollEv();});
            });
            $('[closeChat]').click(function(){closeChat();})
            
            
            var input = document.getElementById("newMess");
            input.addEventListener("keyup",function(event){
                if(event.keyCode===13){event.preventDefault();addNewMessage();}
            });
            $('[newMess]').click(function(){addNewMessage();});
        }else{
            $('.mesIn .loadeText').remove();
            $('.mesIn').prepend('<div t="3" p>الرسائل السابقة</div>');
            $('.mesIn').prepend(dd[2]);
            /*************/
            scrollPos = $('.mesIn [n='+p+']').position().top;
            $(".mesIn").scrollTop(scrollPos-195);
            //CL(scrollPos-200);
            loadPrvSt=0;       
        }
		fixForm();
		fixPage();
	})
}
function readedMsg(n){    
    $('[t=2][s=0]').each(function(){
        no=parseInt($(this).attr('n'));
        if(no<=n){
            $('[n='+no+']').attr('s','1');
        }
    })
}
function addMessNo(id,s=''){
    sel=$('[c='+id+'] [n]');
    if(sel.length){
        n=parseInt(sel.html());
        n++;
        if(s!=''){n=s;}
        sel.html(n);
        sel.attr('n',n);        
    }else{
        newChatLive(id);
    }
}
function newChatLive(chId){
    $.post(f_path+"X/api_chat_mess_new_live.php",{id:chId},function(data){
		d=GAD(data);
        $('#chats').append(d);
        $('.chatList[c='+chId+']').click(function(){openChat(chId);})
        paySound('2');
	})
}
function addMess(id,mess_id,date,mess){
    fullH=$('#mesIn')[0].scrollHeight;
    chatH=$(".mesIn").scrollTop()+$(".mesIn").height()+80; 
    if(fullH-chatH<60){        
        $(".mesIn").animate({scrollTop:fullH},1500);
    }else{
        addMessNo(ch_id);
    }
    m='<div t="1" s="0" n="'+mess_id+'"><div>'+mess+'<div>'+date+'</div></div></div>';
    $('#mesIn').append(m);
    paySound('1');
    chatOpr(mess_id,1);
    //alert(fullH+'-'+chatH);
}
function chatOpr(m_id,chOpr){
    $.post(f_path+"X/api_chat_mess_opr.php",{id:actChat,m:m_id,opr:chOpr},function(data){
        d=GAD(data);
        if(chOpr==1){
            if(d){
                $('[n='+m_id+']').attr('s','1');
            }
        }
    })
}
function slidChWin(){
    fullH=$('#mesIn')[0].scrollHeight;    
    $(".mesIn").animate({scrollTop:fullH},1500);
}
function scrollEv(){    
    fullH=$('#mesIn')[0].scrollHeight;
    chatH=$(".mesIn").scrollTop()+$(".mesIn").height()+80; 
    //CL(fullH+'-'+chatH);CL(fullH+'-'+chatH);
    if(fullH-chatH<20){
        addMessNo(actChat,'0');
        $('#mesIn [t=1][s=0]').each(function(){
            n=$(this).attr('n');            
        })
    }
    //CL(chatH-$(".mesIn").height()-80);
    if(chatH-$(".mesIn").height()-80<30){
        if(chatLeft){
            clearTimeout(wsTime);
            if(loadPrvSt==0){
                loadPrvSt=1;
                $('.mesIn').prepend(loader_win);
                $(".mesIn").scrollTop(0);
                prvT=setTimeout(function(){
                    openChat(actChat,chatLastId);
                    wSrv();
                },500);
            }
        }
    }
}
function addNewMessage(){
    m=$('#newMess').val();
    if(m){
        rNo=Math.floor(Math.random()*100000);        
        mesT='<div t="4" s="2" n="s'+rNo+'"><div>'+m+'<div>-</div></div></div>';
        $('#mesIn').append(mesT);
        $('#newMess').val('');
        $('#newMess').focus();
        slidChWin();
        $.post(f_path+"X/api_chat_mess_new.php",{id:actChat,m:m,n:rNo},function(data){
            d=GAD(data);
            dd=d.split('^');
            if(dd.length==3){
                n=dd[0];
                id=dd[1];
                date=dd[2];
                mmT='<div>'+m+'<div>'+date+'</div></div>';
                $('[n=s'+n+']').html(mmT);
                $('[n=s'+n+']').attr('t','2');
                $('[n=s'+n+']').attr('s','0');
                $('[n=s'+n+']').attr('n',id);
                paySound('1');
            }
        })
    }
}
function paySound(t){
    $('#sn'+t).get(0).play();
}
function wSrv(){
    clearTimeout(wsTime);
    $.post(f_path+"X/api_chat_mess_ws.php",{id:actChat},function(data){		
        if(data){
            if(data=='X'){
                $('.blcCaht').show();
            }else{
                //CL(data.length)
                for(i=0;i<data.length;i++){
                if(data[i]){                    
                    opr=data[i][0];
                    ch_id=data[i][1];
                    mess_id=data[i][2];
                    mess_date=data[i][3];
                    mess=data[i][4];
                    if(opr=='n'){
                        if(actChat==ch_id){
                            addMess(ch_id,mess_id,mess_date,mess);
                        }else{
                            addMessNo(ch_id);
                            paySound('2');
                        }
                    }
                    if(opr=='r'){
                        readedMsg(mess_id);                        
                    }
                    if(opr=='ses'){
                        chatSes=ch_id;                        
                    }
                }
            }
            }
        }
        wsTime=setTimeout(function(){wSrv();},1000);
	})
}
function closeChat(){
    loader_msg(1,k_loading);		
	$.post(f_path+"X/api_chat_close.php",{id:actChat},function(data){
		d=GAD(data);	
		if(d==1){
			msg=k_done_successfully;mt=1;
			$('#massContent').html('');
            
            $('.chatList[c='+actChat+']').hide(500,function(){
                $('.chatList[c='+actChat+']').remove();
                actChat=0;
            })
		}else{
			msg=k_error_data;mt=0;
		}
		loader_msg(0,msg,mt);
	})
}
function setApi(id){
    co_loadForm(id,3,"0yy8m1zgqf||loadModule('mob0yj5qbn')|");
}
/*****************************************/
/*******************API Custom*****************************/
function tester_set(){
	//$('#mod').css('font-size','16px');
	//$('#mod').children('option').css('font-size','18px');
	$('#mod').change(function(){m_code=$(this).val();mLoadInfo(m_code);})
	$('.sButt').click(function(){sendAPIDat();})
	$('.bButt').click(function(){resetForm();})
}
var actMod='';
function mLoadInfo(m_code){
	actMod=m_code;
	if(m_code!=0){
		$('#mInfo').html(loader_win);
        $('#mOutInfo').html('');
        $('#mOut').html('');
		$('#mButt').hide();
        resetForm();
		//$('#mOutInfo').html();		
		$.post(f_path+"X/api_tes_mod_info.php",{mod:m_code},function(data){
			d=GAD(data);
			$('#mInfo').html(d);	
			$('.sButt').show();
			$('#mButt').show();			
			$('.bButt').hide();
			//setupForm('api_data','','x');
			fixForm();
			fixPage();
		})
	}
}
function resetForm(){
	//mLoadInfo(actMod);
	/*$('#mInfo').html('');		
	$('#mOutInfo').html('');
	$('#mOut').html('');
	$('.sButt').show();
	$('#mButt').hide();			
	$('.bButt').hide();*/
    $('#mInfoOut').html('');    
    $('#mInfo').show();
    $('.sButt').show();
    $('.bButt').hide();
    
    
}
function sendAPIDat(){
    let data=get_form_vals('#api_data');	
    $('.sButt').hide();
    $('#mInfoOut').html(loader_win);        
    $('#mOutInfo').html(loader_win);
    $('#mOut').html(loader_win);	
	$.post(f_path+"X/api_tes_mod_qu.php",data,function(data){
		d=GAD(data);		
		showData(d);
        $('.bButt').show();
		fixForm();
		fixPage();
	})
}
function showData(d){    
	dd=d.split('^');    
	//dd[1]=replaceAll("*",",",dd[1]);
	if(dd.length==3){		
		dd[2]=replaceAll("[{","[<br>{",dd[2]);	
		dd[2]=replaceAll("[[","[<br>  [",dd[2]);
		dd[2]=replaceAll("]]","<br>  ]<br>]",dd[2]);
		dd[2]=replaceAll("],[","],<br>  [",dd[2]);	
		dd[2]=replaceAll("{","    {",dd[2]);
		dd[2]=replaceAll("},","},<br>",dd[2]);
		dd[2]=replaceAll('","','",<br>      "',dd[2]);
		dd[2]=replaceAll('{"','{<br>      "',dd[2]);
		dd[2]=replaceAll('},','<br>    },',dd[2]);
		dd[2]=replaceAll('"}','"<br>    }',dd[2]);
	
		$('#mInfo').hide();
        $('#mInfoOut').html(dd[0]);        
		$('#mOutInfo').html(dd[1]);
		$('#mOut').html(dd[2]);		
	}
	$('#sendAPIData').click(function(){$('#api_data_send').submit();});
}
function replaceAll(p1,p2,str) {
    ch=str.split(p1);
	for(i=0;i<=ch.length;i++){str=str.replace(p1,"♫");}
	for(i=0;i<=ch.length;i++){str=str.replace("♫",p2);}
    return str;
};
/*********/
var actNoti='';
function noti_set(){
	//$('#noti').css('font-size','16px');
	//$('#noti').children('option').css('font-size','18px');
	$('#noti').change(function(){n_no=$(this).val();NLoadInfo(n_no);})	
}

function NLoadInfo(n_no){
	actNoti=n_no;		
	$('#mInfo').html(loader_win);
	$('#mOut').html('');	
	$.post(f_path+"X/api_noti_form.php",{noti:n_no},function(data){
		d=GAD(data);
		$('#mInfo').html(d);
		setupForm('api_data');
		$('.sButt').click(function(){$('#api_data').submit();})
		fixForm();
		fixPage();
	})
}
function showNotiData(d){
	out=d;	
	//out=replaceAll("'","`",out);
	//out=replaceAll('"',"`",out);
	$('#mOut').html(out);
}
/******************************/
function docs_set(){ 
	$('.docLinks div[t]').click(function(){
		n=$(this).attr('n');
		t=$(this).attr('t');
		$('.docLinks div[t]').removeClass('act');
		$(this).addClass('act');
		loadDoc(t,n);
	})	
}
function loadDoc(t,n){
	$('#mOut').html(loader_win);
	$.post(f_path+"X/api_tes_doc_info.php",{t:t,n:n},function(data){
		d=GAD(data);
		$('#mOut').html(d);		
		fixPage();
	})	
}
function noteSet_set(){	
	setupForm('nSet','');
	fixForm();
	fixPage();
	$('.saveNSet').click(function(){$('#nSet').submit();})
}

function savsNs(d){	
	if(d==1){
		msg=k_done_successfully;mt=1;
	}else{
		msg=k_error_data;mt=0;
	}
	loader_msg(1,'');
	loader_msg(0,msg,mt);
}
/**********set Complaints**********************/
var actCompl=0;
var actNoteType=0;
function setComplaints(){
    $('[refCompl]').click(function(){refComplaints(1);})
    $('[cmpList]').on('click','[complAc]',function(){showCompl($(this).attr('complAc'));})
    refComplaints(1); 
    refPage('api_compl',5000);
    $('[cmpdata]').on('click','[c_resp]',function(){complaintsOpr(1);})
    $('[cmpdata]').on('click','[c_foll]',function(){setFoll($(this).attr('c_foll'));})
    $('[cmpdata]').on('click','[addNote]',function(){addCNote(3);})
    $('[cmpdata]').on('click','[addNote2]',function(){addCNote(4);})
    
}
function refComplaints(l){	
	if(l==1){		
        $('[cmpList]').html(loader_win);
        $('.tapL_32').html(loader_win);		
	}	
	$.post(f_path+"X/api_compl_list.php",{},function(data){
		d=GAD(data);
		$('[cmpList]').html(d);
		fixPage();
		fixForm();
	})
}
function showCompl(id,l=1){
    actCompl=id;
    if(l){$('[cmpData]').html(loader_win);}
	$.post(f_path+"X/api_compl_show.php",{id:id},function(data){
		d=GAD(data);
		$('[cmpData]').html(d);
		fixPage();
		fixForm();
	})
}
function complaintsOpr(type,text,data=[]){ 
    loader_msg(1,k_loading);		
	$.post(f_path+"X/api_compl_opr.php",{t:type,co:actCompl,text:text,data:data},function(data){
		d=GAD(data);
        dd=d.split('^');
		if(dd[0]==0){
			msg=k_done_successfully;mt=1;
            win('close','#m_info')
		}else{
			msg=dd[1];mt=0;  
		}
		loader_msg(0,msg,mt);
        if(dd[2]==1){
            showCompl(actCompl,0);
        }        
	})    
}
function setFoll(type){
    data={};
    user=0
    if(type==2){user=$('#c_user').val();}
    if(user || type==1){
        data.user=user;
        data.type=type;
        text=$('#c_note').val();
        complaintsOpr(2,text,data);
    }else{
        nav(3,'يجب أختار المتابع');
    }    
}
function addCNote(type){
    actNoteType=type;
    loadWindow('#m_info',0,'إضافة ملاحظة',800,0);
    $.post(f_path+"X/api_compl_note.php",{id:actCompl,type:type},function(data){
        d=GAD(data);
        $('#m_info').html(d);
        fixForm();
        fixPage();			
    })
}
function addCNoteSave(type,solve=0){
    data={};    
    text=$('#c_noteIn').val();
    if(text){        
        data.solve=solve;
        complaintsOpr(type,text,data);
    }else{
        nav(3,'يجب كتابة الملاحظة');
    }
}

function setPromotion(){
    $('.centerSideIn').on('click','[prom_contnet]',function(){promo_contetn($(this).attr('prom_contnet'));})
    $('body').on('keyup','#promo_form input',function(){updatePromoPreview();})
    $('body').on('keyup','#promo_form textarea',function(){updatePromoPreview();})  
    $('body').on('click','#promo_form [deli]',function(){setTimeout(function(){updatePromoPreview();},1000);});
    
    $('.centerSideIn').on('click','[prom_audience]',function(){prom_audience($(this).attr('prom_audience'));})
    $('.centerSideIn').on('click','[prom_send]',function(){prom_send($(this).attr('prom_send'));})
    

}
var actPromo=0;
function promo_contetn(id){
    actPromo=id;
    loadWindow('#full_win1',1,'تحرير المحتوى',0,0);
	$.post(f_path+"X/api_promo_content.php",{id:id},function(data){
		d=GAD(data);
		$('#full_win1').html(d);
        setupForm('promo_form','full_win1');
        updatePromoPreview();
		fixForm();
		fixPage();
	})
}
function updatePromoPreview(){
    msg_title=$('[name=msg_title]').val();    
    $('#prv_msg_title').html(checkPromoData(msg_title));
    
    msg_desc=$('[name=msg_desc]').val();    
    $('#prv_msg_desc').html(checkPromoData(msg_desc));
    
    title=$('[name=title]').val();    
    $('#prv_title').html(checkPromoData(title));
    
    body=$('[name=body]').val();    
    $('#prv_body').html(checkPromoData(body));
    
    setTimeout(function(){
        photo=$('[name=photo]').val(); 
        if(photo){        
            image=$('[imgc="'+photo+'"] >div').attr('href');            
            $('#prv_photo').html('<img src="'+image+'" style="max-height:160px"/>');            
        }else{
            $('#prv_photo').html('');
        }
    },100);
    
    url=$('[name=url]').val();
    url_text=$('[name=url_text]').val();
    if(url && url_text){
        $('#prv_link').html('<a href="'+url+'" target="blank"><div class="bu bu_t4" style="max-width:250px">'+url_text+'</div></a>');
    }else{
        $('#prv_link').html('');
    }
    
}
function checkPromoData(txt){
    txt=txt.replaceAll('[p]',' <span class="clr5 f1"> اسم المريض </span> ');
    txt=txt.replace (/\n/g, "<br />");
    return txt;
}
function prom_audience(id){
    actPromo=id;
    loadWindow('#m_info',1,'تحديد الجمهور',800,0);
	$.post(f_path+"X/api_prom_audience.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info').html(d);
        setupForm('promo2_form','');		
        fixForm();
        fixPage();
        viwaUdience();
	})
}
function viwaUdience(){
    $('#udienceRes').html(loader_win);
    sex=$('#sex').val();
    age_from=$('#age_from').val();
    age_to=$('#age_to').val();
    b_date=$('#b_date').val();
    area=$('#area').val();    
	$.post(f_path+"X/api_prom_audience_view.php",{id:actPromo,sex:sex,age_from:age_from,age_to:age_to,area:area,b_date:b_date},function(data){
        d=GAD(data);
        $('#udienceRes').html(d);
        fixForm();
        fixPage();
	})    
}

function genrUdience(){
    loader_msg(1,k_loading);
    sex=$('#sex').val();
    age_from=$('#age_from').val();
    age_to=$('#age_to').val();
    b_date=$('#b_date').val();
    area=$('#area').val();    
	$.post(f_path+"X/api_prom_audience_save.php",{id:actPromo,sex:sex,age_from:age_from,age_to:age_to,area:area,b_date:b_date},function(data){
        d=GAD(data);			
		if(d==1){
			msg=k_done_successfully;mt=1;
            win('close','#m_info');
            loadModule('wuv9f0s7zj');
        }else{
            msg=k_error_data;mt=0;
        }
		loader_msg(0,msg,mt);
	})    
}

function prom_send(id){
    actPromo=id;
    loadWindow('#m_info',1,'إرسال الإشعارات',800,0);
	$.post(f_path+"X/api_prom_send.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info').html(d);        		
        fixForm();
        fixPage();        
	})  
}
var ssnp='';
function prom_send_do(id,snData=''){
    clearTimeout(ssnp);
    if(snData==''){$('#sendNot').html(loader_win);}
	$.post(f_path+"X/api_prom_send_do.php",{id:id},function(data){
		d=GAD(data);        
        dd=d.split('^');    
        nData=dd[1];
        if(dd.length==2){
            if(dd[0]=='1'){
                if($('#sendNot').length>0){
                    ssnp=setTimeout(function(){
                        prom_send_do(id,1);
                    },200);
                }
            }
		    $('#sendNot').html(dd[1]);
        }
		fixForm();
		fixPage();
	})
}
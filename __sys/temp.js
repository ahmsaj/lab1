// ------------- Start Page
$(document).ready(function(e){
    if(sezPage=='pageName'){fun();}
});
// ------------- Load Window
function openWin(id){
	loadWindow('#m_info',1,'title',800,200);		
	$.post(f_path+"X/path.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info').html(d);		
		loadFormElements('#formId');	
		setupForm('formName','m_info');
		fixForm();
		fixPage();
	})
}
// ------------- Load Full Window ---------------
function openFullWin(id){
	loadWindow('#full_win1',1,'title',0,0);
    $.post(f_path+"X/path.php",{id:id},function(data){
		d=GAD(data);
		$('#full_win1').html(d);		
		loadFormElements('#formId');	
		setupForm('formName','m_info');
		fixForm();
		fixPage();
	})    
}
// ------------- Live Page.
refPage(code,time)
function livePage(l){	
    if(l==1){$('.sel').html('');}        
    $.post(f_path+"X/path.php",{},function(data){
        d=GAD(data);
        dd=d.split('^');
        $('.sel').html(d);
        fixPage();
        fixForm();
    })
}
// ------------- Alert.
function alertFun(id){    
	open_alert(id,'alertCode','msg','title');
}
// -------------Procedure with loader .
function Procedure(id){
    loader_msg(1,k_loading);
	$.post(f_path+"X/path.php",{id:id},function(data){
		d=GAD(data);
		if(d==1){
			msg=k_done_successfully;mt=1;
			CbFun();			
		}else{
			msg=k_error_data;mt=0;
		}
		loader_msg(0,msg,mt);
	})	
}
// -------------Module Form.
co_loadForm(id,3,"mod_code|id|cb([id])|column:"+column+":hh");

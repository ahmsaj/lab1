/***LAB***/
$(document).ready(function(){
	$('body').on('change','[changeSample]',function(){
		changeServiceSample($(this).attr('changeSample'),$(this).val());
	})
})
var l_t_ides='';var actSampleR=2;var RformOk=1;var equs='';var equ_arr=new Array();var lsrno2='';var lsrnoRest2='';var ActSample=0;var rackSer='';var ActRack=0;var ActarSel='';var rx=0;var ry=0;var actReport=0;var stopslref=0;var lsrno='';var lsrnoRest='';var CancleSerTypeActL=0;var anaQType=0;var actAnaQ=0;var activeQno1=0;var actQItme='o';var drop_rd_no=0;var drop_rd_name='';var drop_rd_type='';var drop_rd_del='';var actvisCancel=0;var r_stopslref=0;var actLabSW=0;var sel_sex=0;var sel_age=0;var mas_ana=0;var viewAcceptBlocks=0;var myanType=0;var myarr=new Array();
$(window).click(function(){$('.rts').attr('sw','off');})

function drowLabSrv(mdc,price,name){
	dd='<tr class="aalLinst " mdc="'+mdc+'" p="'+price+'"><input name="ser_'+mdc+'" type="hidden" value="'+price+'">\
		<td id="in2_'+mdc+'">'+loader_win+'</td>\
		<td class=" fs14 lh30 ws">'+name+'</td>\
		<td id="in_'+mdc+'" class="f1 fs14">'+loader_win+'</td>\
		<td><ff>'+price+'</ff></td>\
		<td><div class="list_del2 ic40 icc2 ic40_del fl" no="'+mdc+'" title="'+k_delete+'"></div></td>\
	</tr>';
	$('#srvData').append(dd);
	resAnaSet3(mdc);
	loadAddInfo(mdc);
	$('#saveButt').show(300);
}
function resAnaSet3(id){
	$('.ana_list_mdc div[mdc='+id+']').attr('del','1');
	$('.ana_list_mdc div[del=1]').slideUp(300);
	$('.list_del2[no='+id+']').click(function(){
		delLabServ(id);					
	})
	countAmountss2();		
}
function delLabServ(id){
	$('.list_del2[no='+id+']').closest('.aalLinst').remove();
	showSaveButt(2);		
	$('.ana_list_mdc div[mdc='+id+']').slideDown(400);
	$('.ana_list_mdc div[mdc='+id+']').attr('del','0');
	countAmountss2();
}
function countAmountss2(){
	pp=0;
	cc=0;
	$('.aalLinst').each(function(index,element){
		pp+=parseInt($(this).attr('p'));
		cc++;
	});
	$('#serTotal').html(pp);
	$('#countAna').html('( '+cc+' ) ');
}
function loadAddInfo(id){
	$.post(f_path+"X/lab_visit_analysis_info.php",{id:id},function(data){
		d=GAD(data);
		dd=d.split('^');
		$('#in_'+id).html(dd[0]);
		$('#in2_'+id).html(dd[1]);
		loadFormElements('#n_visit');
	})
}
function showSaveButt(t){
	showB=0;
	if(t==1){showB=$('.list_del').length;}
	if(t==2){showB=$('.list_del2').length;}
	if(showB==0){$('#saveButt').hide(300);}
	countAmountss();
}
function load_ls_temp(){
	loadWindow('#m_info3',1,k_lst_tst_tmp,400,0);	
	$.post(f_path+"X/lab_visit_template.php",{}, function(data){
		d=GAD(data);
		$('#m_info3').html(d);
		fixForm();
		fixPage();
	})
}
function loadThisTemp(ids){
	if(ids!=''){
		$('.list_del2').each(function(index, element) {
			id=$(this).attr('no');
			delLabServ(id);
        });	
		idds=ids.split(',');
		for(i=0;i<idds.length;i++){
			mdc=idds[i];
			sel=$('.ana_list_mdc div[mdc='+mdc+']');
			name=sel.attr('name');	
			price=sel.attr('price');			
			sel.attr('del','1');			
			drowLabSrv(mdc,price,name);
		}		
	}
	win('close','#m_info3');
}
function l_save_temp(){
	l_t_ides='';
	$('.list_del2').each(function(index, element) {
        no=$(this).attr('no')
		name=$('norCat[mdc='+no+']').attr('name');
		if(l_t_ides!=''){l_t_ides+=',';}
		l_t_ides+=no;
    });
	if(l_t_ides==''){
		nav(1,k_ontst_sel);
	}else{
		loadWindow('#m_info3',1,k_sv_tsamplt,400,0);
	$('#m_info3').html('<div class="win_body"><div class="form_body so f1 fs16 clr1 lh40">'+k_ent_tmp_nm+'<input type="text" id="lt_name"/></div>\
		<div class="form_fot fr"><div class="bu bu_t2 fr" onclick="win(\'close\',\'#m_info3\');">'+k_close+'</div>\
		<div class="bu bu_t3 fl" onclick="save_ltame();">'+k_save+'</div></div>');
		fixPage();
		fixForm();
	}
}
function save_ltame(){
	temp_n=$('#lt_name').val();
	if(temp_n==''){
		nav(1,k_tmp_nm_ent);
	}else{
		loader_msg(1,k_loading);
		$.post(f_path+"X/lab_visit_template_save.php",{n:temp_n,v:l_t_ides},function(data){
			d=GAD(data);
			if(d==1){msg=k_done_successfully;mt=1;win('close','#m_info3');}else{msg=k_error_data;mt=0;}
			loader_msg(0,msg,mt);
		})
	}
}
function labVisitStatus(id){
	loadWindow('#m_info',1,k_visit_details,750,0);
	$.post(f_path+"X/lab_visit_add_save_status.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
}
function veiwSamplInfo(id){
	actSampleR=id;
	loadWindow('#m_info3',1,k_sams_sts,700,0);	
	$.post(f_path+"X/lab_sample_info.php",{id:id}, function(data){
		d=GAD(data);
		$('#m_info3').html(d);
		fixForm();
		fixPage();
	})
}
function showLReport(id,type){
	RformOk=1;
	loadWindow('#m_info2',1,k_ent_report,www,hhh);	
	$.post(f_path+"X/lab_results_report_enter.php",{id:id,t:type}, function(data){
		d=GAD(data);
		$('#m_info2').html(d);
		loadFormElements('#lr_form');		
		setupForm('lr_form','m_info2');
		fixForm();
		fixPage();
		setswabs();
		SetEQu();
		chckNorVal();
	})	
}
function setswabs(){
	$('#swabs_types').change(function(){
		sw_sel=$(this).val();
		sw_c=$(this).children('option[value='+sw_sel+']').attr('c');
		if(sw_c==1){$('#sw_colon').show();}else{$('#sw_colon').hide();}
	})
	$('input[antib]').keyup(function(){
		i_no=$(this).attr('antib');
		$('#code'+i_no).html('');
		i_val=$(this).val();
		if(i_val!=''){
			i_val=parseInt(i_val);
			icode='I';
			i_min=parseInt($(this).attr('s'));
			i_max=parseInt($(this).attr('b'));
			if(i_val<=i_min){icode="R";}
			if(i_val>=i_max){icode="S";}
			$('#code'+i_no).html(icode);
		}		
	})
	$('.form_checkBox[par=mutr]').click(function(){
		ch=$(this).children('div[ch]').attr('ch');
		if(ch=='on'){$(this).closest('tr').removeClass('tranTr');}else{$(this).closest('tr').addClass('tranTr');}
	})
	$('.grad_lab_enter').find('input,select,textarea').focusin(function(){
		$(this).closest('tr').css('background-color','#f4eb57')
	})
	$('.grad_lab_enter').find('input,select,textarea').focusout(function(){
		$(this).closest('tr').css('background-color','')
	})
	
}
function SetEQu(){
	equ_arr=[];
	q=equs.split('^');
	
	for(i=0;i<q.length;i++){equ_arr[i]=q[i].split('|');}
	for(i=0;i<equ_arr.length;i++){
		Qid=equ_arr[i][0];
		Qtype=equ_arr[i][1];
		Qitem=equ_arr[i][2];
		Qq=equ_arr[i][3];
		if(Qtype==2 || Qtype==3){
			Qq2=Qq.split(',');
			for(i3=0;i3<Qq2.length;i3++){
				$('input[name^=lrp_'+Qq2[i3]+']').attr('q'+Qtype,Qid);
			}
		}
	}
	setSLR_vset();
}
function setSLR_vset(){
	$('div[part=input][rt=1] > input ,div[part=input][rt=2] > input ,div[part=input][rt=4] > input ').keyup(function(){calEQu(1,0);})
	$('input[q2]').each(function(index, element){
		qNo2=$(this).attr('q2');
		calEQu(2,qNo2);
    	$(this).keyup(function(){calEQu(2,qNo2);});    
    });
	$('input[q3]').each(function(index, element){
		qNo3=$(this).attr('q3');
		calEQu(3,qNo3);
    	$(this).keyup(function(){calEQu(3,qNo3);});   
    });
	for(i=0;i<equ_arr.length;i++){
		Qtype=equ_arr[i][1];
		Qitem=equ_arr[i][2];
		if(Qtype==1){$('input[name^=lrp_'+Qitem+']').prop('disabled', true);}
	}
	//$('.grad_lab_enter input:enabled').first().focus();
	fo=0;
	$('.grad_lab_enter input:enabled ,.grad_lab_enter select ,.grad_lab_enter textarea ').each(function(){
		if($(this).attr('class')!='hide' && fo==0){
			$(this).focus();
			fo=1;
		}
	});
}
/*
function calEQu(t,p){
	if(t==1){
		for(i=0;i<equ_arr.length;i++){
			Qid=equ_arr[i][0];
			Qtype=equ_arr[i][1];
			Qitem=equ_arr[i][2];
			Qq=equ_arr[i][3];			
			if(Qtype==1){
				newVal=0;
				oprVal=0;
				q3=Qq.split(',');
				for(i2=0;i2<q3.length;i2++){
					q4=q3[i2].split(':');
					qc=q4[0];
					qv=q4[1];				
					if(qc=='o'){
						oprVal=q4[1];
					}else{
						if(qc=='n'){thisV=qv;}
						if(qc=='v'){thisV=$('input[name^=lrp_'+qv+']').val();}
						//alert(qv+'= '+thisV)
						thisVal=0;
						if(thisV!=''){thisVal=parseFloat(thisV);}
						
						if(oprVal==0){
							newVal=thisVal;
						}else{
							if(oprVal==1){newVal=newVal+thisVal;}
							if(oprVal==2){newVal=newVal*thisVal;}
							if(oprVal==3){newVal=newVal-thisVal;}
							if(oprVal==4){
								if(newVal!=0){newVal=newVal/thisVal;}else{$('input[name^=lrp_'+Qitem+']').val(0); 
								//return;
								}
							}							
						}
					}				
				}
				if(newVal % 1 != 0){newVal=newVal.toFixed(2)}
				$('input[name^=lrp_'+Qitem+']').val(newVal);				
			}
		}
	}
	if(t==2){
		Qtotal=0;
		Qerr=0;
		Qemp=0;
		Qdata='';
		$('input[q2='+p+']').each(function(index,element){
			Qn=$(this).parent().attr('no');
			Qv=$(this).val();			
			if(Qdata!=''){Qdata+=','};
			Qdata+=Qn+':'+Qv;
			if(Qv==''){Qemp=1;}else{Qtotal+=parseFloat(Qv);}               
        });		
		if(Qemp==0){			
			Qtotal=Qtotal.toFixed(4);	
			if(Qtotal==100){
				$('input[q2='+p+']').closest('tr[b]').css('background-color','');
				tt=t;pp=p;QQ=Qdata;
				setTimeout(function(){loadLRChart(tt,pp,QQ);},1000);
				RformOk=1;
			
			}else{
				$('input[q2='+p+']').closest('tr[b]').css('background-color','#fcc');
				////$('div[selit2='+p+']').html('<img src="../images/nti2.png">');
				RformOk=0;
			}
		}
	}
	if(t==3){
		Qdata='';
		$('input[q3='+p+']').each(function(index,element){
			Qn=$(this).parent().attr('no');
			Qv=$(this).val();			
			if(Qv==''){Qv=0;}
			if(Qdata!=''){Qdata+=',';}
			Qdata+=Qn+':'+Qv;
        });
		loadLRChart(t,p,Qdata);
	}	
}
*/
function calEQu(t,p){
	Q_sinR=new Array('','+','*','-','/',')','(','Math.sqrt');
	if(t==1){		
		for(i=0;i<equ_arr.length;i++){
			Qid=equ_arr[i][0];
			Qtype=equ_arr[i][1];
			Qitem=equ_arr[i][2];
			Qq=equ_arr[i][3];			
			if(Qtype==1){
				newVal=0;
				oprVal=0;
				q3=Qq.split(',');				
				advanceQ =Qq.search("a");				
				if(advanceQ>=0){
					out='';
					allVal=1;
					for(i2=0;i2<q3.length;i2++){						
						q4=q3[i2].split(':');
						qc=q4[0];
						qv=q4[1];
						if(qc=='o' || qc=='a'){
							out+=Q_sinR[qv];
						}
						if(qc=='n'){out+=qv;}
						if(qc=='v'){
							qvv=$('input[name^=lrp_'+qv+']').val();
							if(qvv){out+=qvv;}else{allVal=0;}
						}						
					}
					if(allVal==1){						
						newVal=eval(out);
						//CL(out+'='+newVal);
						$('input[name^=lrp_'+Qitem+']').val(newVal);
					}
				}else{
					for(i2=0;i2<q3.length;i2++){
						q4=q3[i2].split(':');
						qc=q4[0];
						qv=q4[1];
						if(qc=='o'){
							oprVal=q4[1];
						}else{
							if(qc=='n'){thisV=qv;}
							if(qc=='v'){thisV=$('input[name^=lrp_'+qv+']').val();}							
							thisVal=0;
							if(thisV!=''){thisVal=parseFloat(thisV);}

							if(oprVal==0){
								newVal=thisVal;
							}else{
								if(oprVal==1){newVal=newVal+thisVal;}
								if(oprVal==2){newVal=newVal*thisVal;}
								if(oprVal==3){newVal=newVal-thisVal;}
								if(oprVal==4){
									if(newVal!=0){newVal=newVal/thisVal;}else{$('input[name^=lrp_'+Qitem+']').val(0); 
									//return;
									}
								}							
							}
						}		
					}
				}
				if(newVal % 1 != 0){newVal=newVal.toFixed(2)}
				$('input[name^=lrp_'+Qitem+']').val(newVal);				
			}
		}
	}
	if(t==2){
		Qtotal=0;
		Qerr=0;
		Qemp=0;
		Qdata='';
		$('input[q2='+p+']').each(function(index,element){
			Qn=$(this).parent().attr('no');
			Qv=$(this).val();
			if(Qdata!=''){Qdata+=','};
			Qdata+=Qn+':'+Qv;
			if(Qv==''){Qemp=1;}else{Qtotal+=parseFloat(Qv);}               
        });		
		if(Qemp==0){			
			Qtotal=Qtotal.toFixed(4);	
			if(Qtotal==100){
				$('input[q2='+p+']').closest('tr[b]').css('background-color','');
				tt=t;pp=p;QQ=Qdata;
				setTimeout(function(){loadLRChart(tt,pp,QQ);},1000);
				RformOk=1;
			
			}else{
				$('input[q2='+p+']').closest('tr[b]').css('background-color','#fcc');
				////$('div[selit2='+p+']').html('<img src="../images/nti2.png">');
				RformOk=0;
			}
		}
	}
	if(t==3){
		Qdata='';
		$('input[q3='+p+']').each(function(index,element){
			Qn=$(this).parent().attr('no');
			Qv=$(this).val();			
			if(Qv==''){Qv=0;}
			if(Qdata!=''){Qdata+=',';}
			Qdata+=Qn+':'+Qv;
        });
		loadLRChart(t,p,Qdata);
	}	
}
function loadLRChart(Qtype,Qp,Qdata){
	//$('div[selit'+Qtype+'='+Qp+']').html(loader_win);
	$.post(f_path+"X/lab_results_info_chart.php",{type:Qtype,data:Qdata,p:Qtype+'^'+Qp},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==3){$('div[selit'+dd[0]+'='+dd[1]+']').html(dd[2]);}
	})
}
function chckNorVal(){
	chckNorValDo();
	$('tr[b]').find('input').keyup(function(){chckNorValDo();})
	$('tr[b]').find('div[par]').click(function(){chckNorValDo();})
	$('select[lrNo]').change(function(){chckNorValDo();})
}
function chckNorValDo(){
	$('tr[b]').each(function(index,element) {
		db=$(this).find('div[part=norval]')
		no=db.attr('no');
		rt=db.attr('rt');
		
		if(rt==0){
			bd_val=$('input[name=lrp_'+no+']').val();
			if(bd_val==''){
				colorResInput($('input[name=lrp_'+no+']'),'');				
			}else{
				colorResInput($('input[name=lrp_'+no+']'),'y');
			}
		}
		if(rt==1){
			bd_val=$('input[name=lrp_'+no+']').val();
			if(bd_val==''){
				colorResInput($('input[name=lrp_'+no+']'),'');				
			}else{
				bd_val=parseFloat(bd_val);
				db_min=parseFloat(db.attr('min'));
				db_max=parseFloat(db.attr('max'));
				if(bd_val>=db_min && bd_val<=db_max){
					colorResInput($('input[name=lrp_'+no+']'),'g');
				}else{
					colorResInput($('input[name=lrp_'+no+']'),'r');
				}
			}
		}
		if(rt==2 || rt==4){
			inNRang=0;
			bd_val=$('input[name=lrp_'+no+']').val();
			if(bd_val==''){				
				colorResInput($('input[name=lrp_'+no+']'),'');
			}else{
				bd_val=parseFloat(bd_val);
				db_opr=parseFloat(db.attr('opr'));
				db_opr_v=parseFloat(db.attr('opr_v'));
				if(db_opr==0){if(bd_val>db_opr_v){inNRang=1;}}
				if(db_opr==1){if(bd_val<db_opr_v){inNRang=1;}}
				if(db_opr==2){if(bd_val>=db_opr_v){inNRang=1;}}
				if(db_opr==3){if(bd_val<=db_opr_v){inNRang=1;}}				
				if(db_opr==4){if(bd_val==db_opr_v){inNRang=1;}}
				if(db_opr==5){if(bd_val!=db_opr_v){inNRang=1;}}
				if(inNRang==1){colorResInput($('input[name=lrp_'+no+']'),'g');
				}else{colorResInput($('input[name=lrp_'+no+']'),'r');}
			}
		}
		if(rt==3){
			bd_val=$('input[name=lrp_'+no+']').val();
			if(bd_val==''){				
				colorResInput($('div[part=input][no='+no+']'),'');
			}else{				
				db_def=parseFloat(db.attr('def'));				
				if((bd_val=='n' && db_def=='0') || (bd_val=='p' && db_def=='1')){colorResInput($('div[part=input][no='+no+']'),'g');
				}else{colorResInput($('div[part=input][no='+no+']'),'r');}
			}
		}
		if(rt==7){
			bd_val=$('input[name=lrp_'+no+']').val();
			if(bd_val==''){				
				colorResInput($('input[name=lrp_'+no+']'),'');
			}else{
				bd_val=parseFloat(bd_val);
				db_min=parseFloat(db.attr('min'));
				db_max=parseFloat(db.attr('max'));
				
				if(bd_val<db_min){colorResInput($('input[name=lrp_'+no+']'),'r');}
				if(bd_val>db_max){colorResInput($('input[name=lrp_'+no+']'),'g');}
				if(bd_val<=db_max && bd_val>=db_min){colorResInput($('input[name=lrp_'+no+']'),'b');}
			}
		}
	})
	$('select[lrNo]').each(function(index,element){	
		selVal=$(this).val();
		sty_t=$(this).children('option[value='+selVal+']').attr('c');
		if(sty_t==2){colorResInput($(this),'g');}
		if(sty_t==1){colorResInput($(this),'r');}
		if(selVal==0){colorResInput($(this),'');}
		
	})
}

function colorResInput(s,t){
	if(t==''){$(s).css('background-color','');}
	if(t=='g'){$(s).css('background-color','#b6f89f');}
	if(t=='r'){$(s).css('background-color','#fdc9c9');}
	if(t=='b'){$(s).css('background-color','#9faef8');}
	if(t=='y'){$(s).css('background-color','#eee365');}
}

function save_rep(id){	
	if(RformOk==1){
		$('#lr_form input[name]').prop('disabled', false);	
		$('.grad_lab_enter input:enabled').first().focus();
		sub('lr_form');
	}else{
		nav(1,k_numbers_not_balanced);
	}
}

function resvLSNo2(){
	clearTimeout(lsrno2);
	ActSample=$('#rsno').val();
	lsrno2=setTimeout(function(){resvLSNoDo3();},800);
	stopslref=1;
	$('#rlsMsg').html('....');
	clearTimeout(lsrnoRest2);
}

//function resetRepS(){ActSample='';resvLSNoDo3();}
function resvLSNoDo3(){
	if(ActSample==0){
		$('#rlsMsg').html(k_srching);
		no=$('#rsno').val();
		ActSample=no;
	}else{
		no=ActSample;	
	}	
	//if(no!=''){
		//$('.centerSideIn').html(loader_win);
		centerLoader(0);
		$.post(f_path+"X/lab_results_sample_info.php",{no:no},function(data){
			d=GAD(data);
			$('#rsno').val('');

			dd=d.split('^');
			if(dd[0]=='0'){
				$('#rlsMsg').css('color','#f00');
				$('#rlsMsg').html(dd[1]);				
			}else{
				$('.centerSideIn').html(dd[1]);
				centerLoader(1);
				$('#rlsMsg').html(k_sam_found);
				$('#rlsMsg').css('color','#0a0');
			}
			stopslref=0;
			lsrnoRest=setTimeout(function(){resetRLSTxt2();},3000);
		})
	//}else{stopslref=0;}
	
}

function resetRLSTxt2(){
	clearTimeout(lsrnoRest);
	$('#rlsMsg').css('color','');
	$('#rsno').val('');
	$('#rlsMsg').html(k_ent_num_sams);
}

function enterRack(){
	d='<div class="win_body"><div class="form_body so">\
	<div class="fs18 f1 clr1 lh40">'+k_ent_rck_num+'</div>\
	<input type="number" id="rackN" />\
	</div><div class="form_fot fr"><div class="bu bu_t2 fr" onclick="win(\'close\',\'#m_info\')">'+k_cancel+'</div>';
	loadWindow('#m_info',1,k_sel_rck,400,0);
	$('#m_info').html(d);
	$('#rackN').focus();
	$('#rackN').keyup(function(){
		clearTimeout(rackSer);		
		rackSer=setTimeout(function(){v=$('#rackN').val();if(v!=''){findRack(v);}},800);		
	})
	fixPage();
	fixForm();
}


function findRack(r_id){	
	ActRack=r_id;
	win('close','#m_info');
	$.post(f_path+"X/lab_rack_view.php",{id:r_id}, function(data){
		d=GAD(data);
		$('#sContent2').html(d);
		fixPage();
		fixForm();
		set_rack();
		AutoSelectRack();			
	})
}
function set_rack(){
	ActarSel='';
	$('.rts').click(function(){
		event.stopPropagation();
		rs_id=$(this).attr('id');
		sel_rs(rs_id);
	})
}
function sel_rs(id){
	ActarSel=id;
	s_no=$('#'+id).attr('no');
	if(s_no==0){
		sw=$('#'+id).attr('sw');
		$('.rts').attr('sw','off');
		if(sw=='off'){
			$('#'+id).attr('sw','on');
			$('#rsno').val('');
			$('#rsno').focus();
		}
	}else{
		veiwSamplInfo(s_no);
	}
}
function resvLSNoDo2(){	
	no=$('#rsno').val();
	$('#rsno').val('');
	if(no!=''){			
		r_ord=$('#'+ActarSel).attr('ord');		
		$.post(f_path+"X/lab_sample_move.php",{no:no,p:ActarSel,r:ActRack,r_ord:r_ord},function(data){
			d=GAD(data);
			dd=d.split('^');
			if(dd.length==2){
				s=dd[0];
				msg=dd[1];
				colorr='#f00';
				if(s==1){colorr='#0a0';r_samples_ref(1);}
				navC(1,msg,colorr);
			}
			findRack(ActRack);			
		})
	}
}
function AutoSelectRack(){
	if(ActarSel==''){SelNow='S0_1';}else{SelNow=ActarSel;}
	xxyy=SelNow.substr(1).split('_');
	Sx=parseInt(xxyy[0]);
	Sy=parseInt(xxyy[1]);
	if(Sx<rx){Sx++;}else{Sy++;Sx=1;}
	if(Sy<=ry){
		Sidd='S'+Sx+'_'+Sy;
		if($('#'+Sidd).length>0){
			s_no=$('#'+Sidd).attr('no');			
			if(s_no=='0'){
				sel_rs(Sidd);
			}else{				
				ActarSel='S'+Sx+'_'+Sy;
				AutoSelectRack();
			}
		}
	}	
}
function rackInfo(id){
	loadWindow('#m_info',1,k_rck_det,www,hhh);
	$('#m_info').html(loader_win);
	$.post(f_path+"X/lab_rack_info.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info').html(d);						
		fixForm();
		fixPage();		
	})
}
function rackPrint(id){printLab(2,id);}
function rackPartPrint(id){printLab(3,id);}
function rackSDel(id){open_alert(id,24,k_cmp_dstr_rck,k_dstrc_rck);}
function XsDel(id){open_alert(id,25,k_sam_dstr,k_dmg_sam);}
function RSDeL(type,id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_sample_receipt_del.php",{id:id,type:type},function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);
		if(type==1){
			findRack(ActRack);
			win('close','#m_info3');
		}
		if(type==2){findRack(ActRack);}
	})
}
function rackSOut(id){
	loadWindow('#m_info',1,k_snd_rck_ext,www,hhh);
	$('#m_info').html(loader_win);
	$.post(f_path+"X/lab_rack_out.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info').html(d);						
		fixForm();
		fixPage();		
	})
}
function reviweRep(id,t){
	actReport=id;
	loadWindow('#full_win1',1,k_test_details,www,hhh);
	$('#m_info').html(loader_win);
	$.post(f_path+"X/lab_review_list.php",{id:id,t:t},function(data){
		d=GAD(data);
		$('#full_win1').html(d);						
		fixForm();
		fixPage();
		fixReport();
		viewAcceptBlocks=0;
	})
}
function fixReport(){
	$('.reprort_s div[r]').each(function(index, element){
		ph=$(this).height();
		$(this).children('div').each(function(index, element) {
			rr=$(this).children('div[bb]').length;
			//alert(rr)
			if(rr!=0){
				hhb=(ph/rr)
				if(rr>1){hhb=(ph/rr)-(rr*7);}
				$(this).children('div[bb]').height(hhb);
			}        	
		})
		$('#rr_b1 , .acceptBut').show();
		$('#rr_b2').hide();
    });
	$('.reprort_s .x_val').click(function(){
		no=$(this).attr('no');
		r_st=$(this).attr('sw');
		
		if(r_st=='off'){
			$(this).attr('sw','on');
			$(this).closest('tr').css('background-color','#fbb');
		}else{
			$(this).attr('sw','off');
			$(this).closest('tr').css('background-color','');
		}
		dl=$('.reprort_s .x_val[sw=on]').length;
		if(dl>0){
			$('#rr_b1 , .acceptBut').hide(200);
			$('#rr_b2').html(k_rej_res+' <ff>( '+dl+' )</ff>')
			$('#rr_b2').show(200);
		}else{
			$('#rr_b1 , .acceptBut').show(200);
			$('#rr_b2').hide(200);
		}
	})
}
function revRepDo(id,t,m){
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_review_end.php",{id:id,t:t,m:m},function(data){
		d=GAD(data);
		if(d>0){msg=k_done_successfully;mt=1;}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);
		if(d==1){
			//reviweRep(id);
			if(t==1){
				$('[srb='+id+']').attr('s','8');
				$('[but='+id+']').remove();
				$('[srb='+id+'] .x_val').remove();
				sll=$(".reportRevBlok[s='6']").length;
				//alert(sll)
				if(sll==0){win('close','#full_win1');r_rev_all();}
				if(viewAcceptBlocks==0){$('[srb='+id+']').slideUp();}else{$('[srb='+id+']').show();}			
			}
			if(t==2){win('close','#full_win1');r_rev_all();}
		}
	})
}
function viewAccReport(){
	if(viewAcceptBlocks==0){
		$(".reportRevBlok[s='8']").slideDown();
		viewAcceptBlocks=1
	}else{
		$(".reportRevBlok[s='8']").slideUp();
		viewAcceptBlocks=0
	}
}
function revReRefusal(t){
	loader_msg(1,k_loading);
	xRes='';
	$('.x_val[sw=on]').each(function(index, element){
		rno=$(this).attr('no');
		if(xRes!=''){xRes+=',';}
		xRes+=rno;
	});
	$.post(f_path+"X/lab_review_refusal.php",{x:xRes},function(data){
		d=GAD(data);
		if(d>0){msg=k_done_successfully;mt=1;}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);
		if(d==1){reviweRep(actReport,t);}
		r_rev_all();
	})
}
function r_rev_all(){r_rev(1);loadFitterCostom('lab_review_live_info');}
function showXRes(){
	loadWindow('#m_info3',1,k_rjct_tsts,600,hhh);
	$('#m_info').html(loader_win);
	$.post(f_path+"X/lab_results_report_rejected.php",{},function(data){
		d=GAD(data);
		$('#m_info3').html(d);						
		fixForm();
		fixPage();		
	})
}
function sendToOutLab(){
	oLab=$('#outLab').val();
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_rack_out_send.php",{l:oLab,r:ActRack},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd[0]==1){
			loadWindow('#m_info4',1,k_lst_nprc_tst,600,hhh);
			$('#m_info4').html(dd[1]);
			loader_msg(0,k_error_data,0);
			fixForm();
			fixPage();
		}else{
			win('close','#m_info');
			findRack(ActRack);
			loader_msg(0,k_done_successfully,1);		
		}	
	})
}
function lRepDlv(type,id,vis){
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_results_delivery_done.php",{t:type,id:id},function(data){
		d=GAD(data);
		if(d==1){
			if(type==2){vis=id;}
			loader_msg(0,k_done_successfully,1);
			showAnaToDelv(vis);
		}else{
			loader_msg(0,k_error_data,0);
		}
		fixForm();
		fixPage();		
	})	
}
function reftekLab(){$('.centerSideIn').html(loader_win);check_tik_do(act_tik);}
function printLabRes(type,id){
	if(type==1){Ppage='PrintLR_A';}
	if(type==2){Ppage='PrintLR_V';}
	if(type==3){Ppage='PrintLR_PDF';}
	url=f_path+Ppage+'/'+id;
	popWin(url,800,600);
}
function changeResType(t){
	$('#res_type').val(t);
	if(t==3){
		$('#blc1').hide();
		$('#blc2').show();		
		fixPage();
	}else{sub('lr_form');}
}
function chcklabFmfVal(no,v){
	if(v==1){
		$('#m_'+no).show();
	}else{
		$('#m_'+no).hide();
	}
}
function x_result(id){
	loadWindow('#m_info3',1,k_previous_results,600,200);	
	$.post(f_path+"X/lab_results_report_rejected_info.php",{id:id}, function(data){
		d=GAD(data);
		$('#m_info3').html(d);
		fixForm();
		fixPage();
	})
}
function customPrint(id){
	loadWindow('#m_info',1,k_prnt_tst,500,200);	
	$.post(f_path+"X/lab_print_win_results.php",{id:id}, function(data){
		d=GAD(data);
		$('#m_info').html(d);
		loadFormElements('#lab_print');
		setupForm('lab_print','');
		fixForm();
		fixPage();		
	})
}
function printAnCostom(type){
	vals='';
	$('#lab_print input').each(function(){
		v=$(this).val();
		if(v!=0){
			if(vals!=''){vals+='a';}
			vals+=v;
		}
	})
	if(vals){printLabRes(type,vals)}	
}
function r_samples_ref(l){
	if(r_stopslref==0){
		c_no=$('#cn_bc').val();
		if(l==1){$('#sContent').html(loader_win);}
		$.post(f_path+"X/lab_sample_receipt_live.php",{},function(data){
			d=GAD(data);
			dd=d.split('^');
			$('#sContent').html(dd[0]);
			tt=dd[1].split(',');
			$('#a1').html(tt[0]);
			$('#a2').html(tt[1]);
			$('#a3').html(tt[2]);			
			fixPage();
			fixForm();
		})
	}
}
function samples_ref(l){
	if(stopslref==0){
		c_no=$('#cn_bc').val();
		if(l==1){$('.lvisR1 , .lvisR2').html(loader_win);}
		$.post(f_path+"X/lab_visit_live.php",{},function(data){
			d=GAD(data);
			dd=d.split('^');
			$('#soBut').html(dd[0]);
			$('.labNn1').html(dd[1]);
			$('.lvisR1').html(dd[2]);
			$('.labNn2').html(dd[3]);
			$('.lvisR2').html(dd[4]);
			fixPage();
			fixForm();
			$('#rsno').focus();		
		})
	}
}
function resvLSNo(){	
	clearTimeout(lsrno);
	lsrno=setTimeout(function(){
		if(sezPage=='vis_l_r'){
			resvLSNoDo2();
		}else{
			resvLSNoDo();
			stopslref=1;
			$('#rlsMsg').html('....');
			clearTimeout(lsrnoRest);
		}
	},800);	
}
function resvLSNoDo(){	
	no=$('#rsno').val();
	$('#rsno').val('');
	$('#rlsMsg').html(k_srching);
	if(no!=''){		
		$.post(f_path+"X/lab_sample_receipt.php",{no:no},function(data){
			d=GAD(data);
			dd=d.split(',');
			if(dd.length==2){
				s=dd[0];
				msg=dd[1];
				if(s==0){
					$('#rlsMsg').css('color','#f00');
					 ax.play();
				}else{
					$('#rlsMsg').css('color','#0a0');
					ay.play();
					$('#rsno').val('');
					stopslref=0;
					samples_ref(0);					
				}
				$('#rlsMsg').html(msg);				
			}
			stopslref=0;
			lsrnoRest=setTimeout(function(){resetRLSTxt();},3000);			
		})
	}else{
		stopslref=0;
		$('#rlsMsg').css('color','');
		$('#rlsMsg').html(k_rcv_sam);
	}
}
function editPat2(id,vis){
	co_loadForm(id,3,'27g0s2owdw||openLabSWin(1,'+vis+')|');
}
function editLDoc(vis){
	co_loadForm(vis,3,'y6m42tajub||openLabSWin(1,'+vis+')|');
}
function addPkg(srv,id,t){
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_sample_add.php",{srv:srv,id:id,t:t},function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;openLabSWin(0,actLabSW)}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);				
	})
}
function delAnaFromSPkg(id,srv){
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_sample_analysis_cancel.php",{srv:srv,id:id},function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;openLabSWin(0,actLabSW)}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);				
	})
}
function setLNoCB(t){if(t==0){loader_msg(0,k_cd_entd,0);}else{openLabSWin(0,actLabSW);}}
function caclSrvDoL(srv){
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_service_cancel.php",{vis:actLabSW,srv:srv,t:CancleSerTypeActL},function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;openLabSWin(0,actLabSW);}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);		
	})
}
function cancelSampleDo(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_sample_number_cancel.php",{id:id,vis:actvisCancel},function(data){
		d=GAD(data);
		if(d>0){msg=k_done_successfully;mt=1;openLabSWin(0,actvisCancel);}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);
	})
}
function delSpare(id,vis){actvisCancel=vis;open_alert(id,30,k_dlt_bu_sam,k_cnl_bu_sam);}
function delSpare_do(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_sample_spare_del.php",{id:id},function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;openLabSWin(0,actvisCancel);}else{msg=k_error_data;mt=0;}

		loader_msg(0,msg,mt);			
	})
}
/*************New Design*********************/
function openLabSWin(l,id){
	actLabSW=id;
	if(l==1){
		loadWindow('#full_win1',1,k_sampels,www,hhh);
	}else{
		loader_msg(1,k_loading);
	}
	$.post(f_path+"X/lab_sample.php",{id:id,l:l}, function(data){
		d=GAD(data);
		if(l==1){
			$('#full_win1').html(d);
			setSamMOpr();
		}else{
			dd=d.split('^');
			if(dd.length==2){				
				$('.labSrvList').html(dd[0]);
				$('#samHolder').html(dd[1]);
				loader_msg(0,'');
			}
		}
		setSamNo();
		fixPage();
        fxObjects($('.win_free'));
	})
}
var actDragSrv=0;
var actDropSam=0;
function setSamMOpr(){
	$('[addSam]').click(function(){addNewSam();})
	$('[vlEnd]').click(function(){endLabVis();})	
	$('[srvEmerg]').click(function(){emerg_set(actLabSW);})
	$('[addLabSer]').click(function(){addNewServLab(actLabSW);})
	$('[vlPrint]').click(function(){printLabSt(actLabSW);})	
}
function setSamNo(){
	$('[samin][set=0]').keypress(function(e){		
		var key = e.which;
		if(key==13){saveSamNo($(this).closest('[samn]').attr('samn'));}		
	});
	$('[samin][set=0]').attr('set','1');
	$('[shNo][set=0]').click(function(e){		
		id=$(this).closest('[samn]').attr('samn');
		no=$(this).attr('shNo');
		editSamNo(id,no);
	});
	$('[shNo][set=0]').attr('set','1');
	$('[delLabSrv]').click(function(){
		n=$(this).parent().attr('sn');
		dellabSrv(n);		
	})
	$('[resLabSrv]').click(function(){
		n=$(this).parent().attr('sn');
		reslabSrv(n);		
	})	
	/*******************************************/
	$('.drag').draggable({ 
		revert: true,		
		start: function(event,ui){
			actDragSrv=$(this).attr('sn');
			$(this).addClass('dragItem');
			$('.labSrvList').css('overflow-x','visible');	
			$('.labSrvListContent').css('overflow-x','visible');	
					
			actDropSam=0;						
		},
		stop: function(event,ui){
			$('.labSrvList').css('overflow-x','hidden');
			$('.labSrvListContent').css('overflow-x','hidden');	
			$(this).removeClass('dragItem');		
		},
		
	});   
 	$('.dragIn').draggable({ 
		revert: true,
		start: function(event,ui){
			actDragSrv=$(this).attr('sn');
			actDropSam=$(this).closest('div[samBlc]').attr('samBlc');
			$(this).addClass('dragItem');			
			$(".dropp[samblc="+actDropSam+"]").droppable('disable');
		},
		stop: function(event,ui){
			sn=$(this).attr('sn');
			$(this).removeClass('dragItem');
			$(".dropp[samblc="+actDropSam+"]").droppable('enable');
		}
	});
    $('.dropp').droppable({	
		drop: function( event, ui ) {			
			sam=$(this).attr('samBlc');
			if(actDropSam==0){
				linkSrvToSam(actDragSrv,sam);
				$('.drag[sn='+actDragSrv+']').hide(300);
			}else{
				$('.dragIn').draggable( "option", "revert", false );
				moveSamp(actDragSrv,sam);
				$('.dragIn[sn='+actDragSrv+']').hide(300);
			}
		},
		over: function( event, ui ) {
			$(this).addClass('dropItem');
		},
		out: function( event, ui ) {
			$(this).removeClass('dropItem');
		}
    });
	/*******************************************/
	$('[srvSam]').click(function(){
		n=$(this).attr('srvSam');
		unlinkSrv(n);		
	})
	$('.sam_menu [smo_print]').click(function(){
		sam=$(this).closest('.sam_menu').attr('smo');
		printLabSt(actLabSW,sam);
	})
	$('.sam_menu [smo_del]').click(function(){
		sam=$(this).closest('.sam_menu').attr('smo');
		delSam(sam);
	})
	$('.sam_menu [smo_bu]').click(function(){
		sam=$(this).closest('.sam_menu').attr('smo');
		addBUSam(sam);
	})
}
function addNewSam(){	
	loadWindow('#m_info',1,k_add_tube,500,hhh);	
	$.post(f_path+"X/lab_sample_tube_add.php",function(data){
		d=GAD(data);		
		$('#m_info').html(d);
		$('[tube]').click(function (){
			saveNewSam($(this).attr('tube'));
		})
		fixPage();
		fixForm();
		
	})
}
function saveNewSam(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_sample_tube_save.php",{vis:actLabSW,id:id}, function(data){
		d=GAD(data);
		if(d==1){				
			openLabSWin(0,actLabSW);
			win('close','#m_info');
			msg=k_done_successfully;mt=1;
		}else{
			msg=k_error_data;mt=0;
		}
		loader_msg(0,msg,mt);
	})
}
function unlinkSrv(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_sample_srv_oprs.php",{vis:actLabSW,o:1,id:id}, function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
			if(dd[0]!=1){nav(3,dd[1]);}
			loader_msg(0,'',0);
			openLabSWin(0,actLabSW);
		}		
	})
}
function linkSrvToSam(id,sam){
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_sample_srv_oprs.php",{vis:actLabSW,o:2,id:id,sam:sam}, function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
			if(dd[0]!=1){nav(3,dd[1]);}
			loader_msg(0,'',0);
			openLabSWin(0,actLabSW);
		}		
	})
}
function dellabSrv(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_sample_srv_oprs.php",{vis:actLabSW,o:4,id:id}, function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
			if(dd[0]!=1){nav(3,dd[1]);}
			loader_msg(0,'',0);
			openLabSWin(0,actLabSW);
		}		
	})
}
function reslabSrv(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_sample_srv_oprs.php",{vis:actLabSW,o:5,id:id}, function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
			if(dd[0]!=1){nav(3,dd[1]);}
			loader_msg(0,'',0);
			openLabSWin(0,actLabSW);
		}		
	})
}
function moveSamp(id,sam){	
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_sample_srv_oprs.php",{vis:actLabSW,o:3,id:id,sam:sam}, function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
			if(dd[0]!=1){nav(3,dd[1]);}
			loader_msg(0,'',0);
			openLabSWin(0,actLabSW);
		}		
	})

}
function saveSamNo(id){
	no=$('[samn='+id+'] input').val();	
	$('[samn='+id+']').html(loader_win);
	$.post(f_path+"X/lab_sample_oprs.php",{vis:actLabSW,o:1,id:id,no:no}, function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
			if(dd[0]==1){
				n=dd[1];
				$('[samn='+id+']').attr('no',n);
				$('[samn='+id+']').html('<div class="fr pd10 lh50" shNo="'+n+'" set="0"><ff>#'+n+'</ff></div>');
				setSamNo();
			}else{
				nav(3,dd[1]);
				editSamNo(id,no);
			}
		}
		fixPage();
	})
}
function addBUSam(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_sample_oprs.php",{vis:actLabSW,o:3,id:id}, function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
			if(dd[0]!=1){nav(3,dd[1]);}
			loader_msg(0,'',0);
			openLabSWin(0,actLabSW);
		}		
	})
}
function editSamNo(id,no){
	$('[samn='+id+']').html('<input type="number" samin class="cbg777 fs12" placeHolder="'+k_sample_no+'" set="0" value="'+no+'">');
	$('[samn='+id+'] input').focus();
	setSamNo();
}
function amNoEnter(){
	$('.prvlBlc [inpu][t='+t+'][n='+n+'] [intxt]').keypress(function(e){
		var key = e.which;
		if(key==13){mp_in_save(t,n);}
	}); 
}
function delSam(id){open_alert(id,'lab_5',k_want_del_sample,k_del_sample);}
function delSamDo(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_sample_oprs.php",{vis:actLabSW,o:2,id:id}, function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd[0]!=1){nav(3,dd[1]);}
		loader_msg(0,'',0);
		openLabSWin(0,actLabSW);
		fixPage();
	})
}
function printLabSt(vis,sam=0){
	printWindowC2(5,vis,sam);
}
/*function endLabVis(id){open_alert(id,22,k_yend_vis,k_endvis);}
function finshLS_do(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_visit_end.php",{id:id},function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;samples_ref(0)}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);				
	})
}*/
function endLabVis(){
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_visit_end.php",{id:actLabSW},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
			if(dd[0]!=1){
				nav(4,dd[1]);
			}else{
				win('close','#full_win1');
				samples_ref(1);
			}
			loader_msg(0,'',0);			
		}		
	})
}
/*********************************/
function caclSrvL(id,type){
	CancleSerTypeActL=type;
	if(type==1){textMsg=k_wnt_cnl_srv;}
	if(type==2){textMsg=k_cnl_srv_asoc_sam;}
	if(type==3){textMsg=k_rtrn_srv;}
	open_alert(id,23,textMsg,k_cncl_serv);
}
function addNewServLab(vis){	
	loadWindow('#m_info',1,k_sel_add_tst,www,hhh);
	$('#m_info').html(loader_win);
	$.post(f_path+"X/gnr_visit_add_level2.php",{vis:vis,t:2},function(data){
		d=GAD(data);		
		$('#m_info').html(d);
		$('#ssin').focus();
		loadFormElements('#n_visit');		
		setupForm('n_visit','m_info');						
		resAnaSet(2);
		resAnaSet2(0);				
		fixForm();
		fixPage();		
	})
}
function viwLabVis(id){
	loadWindow('#m_info2',1,k_patient_info,650,200);
	$.post(f_path+"X/lab_visit_list.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info2').html(d);
		fixForm();
		fixPage();	
	})	
}
function viwLabAnals(id){
	loadWindow('#m_info3',1,k_tst_vis,650,200);
	$.post(f_path+"X/lab_visit_analysis_list.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info3').html(d);
		fixForm();
		fixPage();	
	})	
}
function l_res_ref(l){
	if(l==1){$('.clicList').html(loader_win);}
	$.post(f_path+"X/lab_results_delivery_live.php",{},function(data){
		d=GAD(data);		
		dd=d.split(',');
		$('#lr1').html(dd[0]);
		$('#lr2').html(dd[1]);
		fixPage();
	})
}
function labPrices(id){
	loadWindow('#m_info',1,k_ana_prices,650,200);
	$.post(f_path+"X/lab_sett_outlab_price.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
		loadFormElements('#lab_pr');		
		setupForm('lab_pr','m_info');
	})
}
function subSamp(id,t){
	loadWindow('#m_info2',1,k_crt_sub_sam,500,200);
	$.post(f_path+"X/lab_sample_new.php",{id:id,t:t},function(data){
		d=GAD(data);
		$('#m_info2').html(d);
		fixForm();
		fixPage();
		setSSFomr();
		loadFormElements('#subs_form');
		setupForm('subs_form','m_info2');
	})	
}
function setSSFomr(){
	$('#subs_form').submit(function(){
		s1=0;
		s2=0;
    	$('table[ssr] td[no]').each(function(index, element) {
			ss_no=$(this).attr('no');
            ssv=$(this).find('input[name=s_'+ss_no+']').val();
			if (typeof ssv === "undefined"){s1++;}else{s2++;}			 
        });
		if(s1>0 && s2>0){
    		return true; 
		}else{
			if(s2==0){nav(2,k_ontst_sel,0);}
			if(s1==0){nav(2,k_nt_sel_tst,0);}
			return false;
		}
	});
}

function anaEqu(id){
	actAnaQ=id;
	loadWindow('#m_info',1,k_equations,700,0);	
	$.post(f_path+"X/lab_sett_equations.php",{id:id}, function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixPage();
		setOrder();		
	})
}
function anaEqu_set(l,id,no,title,subNo){
	loadWindow('#m_info2',1,title,800,0);	
	$.post(f_path+"X/lab_sett_equations_add.php",{l:l,id:id,no:no,t:anaQType,sn:subNo}, function(data){
		d=GAD(data);
		$('#m_info2').html(d);
		fixPage();
		fixForm();
	})
}
function setQList(){
	$('.aq_list[l] div[no]').click(function(){
		no=$(this).attr('no');
		$(this).slideUp(300,function(){$(this).attr('d','h');})
		$('.aq_list[t] div[no='+no+']').slideDown(300,function(){
			$('.aq_list[t] div[no='+no+']').attr('d','s');
		})		
	})
	$('.aq_list[t] div[no]').click(function(){
		no=$(this).attr('no');
		$(this).slideUp(300,function(){$(this).attr('d','h');})
		$('.aq_list[l] div[no='+no+']').slideDown(300,function(){
			$('.aq_list[l] div[no='+no+']').attr('d','s');
		})		
	})
}
function saveQu(id,no){
	v='';
	n=0;
	ch_type=$('#ch_type').val();
	$('.aq_list[t] div[d=s]').each(function(index, element){    
		nn=$(this).attr('no');		
		if(v!=''){v+=',';}
		v+=nn;
		n++;		
	})
	if(n>1){
		$.post(f_path+"X/lab_sett_equations_save.php",{id:id,no:no,t:anaQType,v:v,ch_type:ch_type}, function(data){
			d=GAD(data);
			if(d==1){anaEqu(id);win('close','#m_info2')}
		})
	}else{nav(1,k_tw_itms_sel);}
}
function anaEqu_del(id){open_alert(id,20,k_wnt_cnl_eq,k_cnl_equ);}
function anaEqu_del_do(id){
	$.post(f_path+"X/lab_sett_equations_del.php",{id:id}, function(data){
		d=GAD(data);if(d==1){anaEqu(actAnaQ);}
	})
}
function setQList2(id,no){
	$('.aq_list[t] div[no]').click(function(){
		sn=$(this).attr('no');
		activeQno1=sn;
		anaQType=11;
		anaEqu_set(2,id,no,k_build_the_equation,sn);			
	})
}
function setQList3(){	
	$('.q_list3 div[no]').click(function(){
		no=$(this).attr('no');
		txt=$(this).attr('txt');
		r='<div class="fl" title="'+txt+'" v val="'+no+'" type="v" t="v">['+no+']</div>';
		addValQ(r,'v');
	})
	$('.q_tool div[v]').click(function(){
		no=$(this).attr('no');
		r='<div class="fl" n val="'+no+'" type="v" t="n">'+no+'</div>';
		addValQ(r,'v');
	})
	$('.q_tool div[o]').click(function(){
		no=$(this).attr('no');
		txt=$(this).attr('txt');
		r='<div class="fl" o val="'+no+'" type="o" t="o">'+txt+'</div>';
		addValQ(r,'o');
	})	
	$('.q_tool div[a]').click(function(){
		no=$(this).attr('no');
		txt=$(this).attr('txt');
		r='<div class="fl" a val="'+no+'" type="a" t="a">'+txt+'</div>';
		addValQ(r,'a');
	})
	
	$('.q_tool > div[n] > div[nn]').click(function(){
		no=$('#qnoO').val();
		$('#qnoO').val('');
		if(no!=''){
			r='<div class="fl" n val="'+no+'" type="v" t="n">'+no+'</div>';		
			addValQ(r,'v');
		}
	})
	$('.q_tool > div[c]').click(function(){
		$('#nqn div:last-child').remove();
	})
}
function addValQ(val,type){
	l=$('#nqn div').length
	e=0;	
	lQ=0;
	itmesC=0;
	$('#nqn div').each(function(){
		t=$(this).attr('type');		
		if(t!='a'){
			itmesC++;
			lQ=t;		
		}
	})
	if(itmesC==0 && type=='o'){
		e_mas=k_equ_init_cal;
		e=1;
	}
	if(lQ==type){
		e_mas=k_error_data;
		e=1;
	}
	
	/*if(l==0){
		if(type=='o'){
			e_mas=k_equ_init_cal;
			e=1;
		}else{	
			actQItme='v';
		}
	}else{
		t=$('#nqn div:last-child').attr('type');
		if(type==t){
			e_mas=k_error_data;
			e=1;
		}else{actQItme=type;}
			
	}*/
	if(e==1){
		nav(1,e_mas);
	}else{
		$('#nqn').append(val);
		fixForm();
	}
}
function saveQu1(id,no){
	l=$('#nqn div').length;
	v='';
	lQ=0;
	arrOpen=0;
	arrClose=0;
	$('#nqn div').each(function(index,element){
        vv=$(this).attr('val');
		tt=$(this).attr('t');
		if(tt!='a'){
			lQ=tt;
		}else{
			if(vv==5){arrOpen++;}
			if(vv==6){arrClose++;}
		}
		if(v!='')v+=',';
		v+=tt+':'+vv;
    });	
	if(arrOpen!=arrClose){
		nav(3,k_brackets_not_balanced);
	}else{
	if(l>0 && arrOpen==arrClose){
		if(lQ=='o'){
			nav(1,k_equ_ntend_signl);
		}else{		
			$.post(f_path+"X/lab_sett_equations_save.php",{id:id,no:no,t:anaQType,v:v,f:activeQno1}, function(data){
				d=GAD(data);
				if(d==1){anaEqu(id);win('close','#m_info2')}
			})
		}
	}else{nav(1,k_onitm_sel);}
	}
}
function reportDesign(id){
	sezPage='rd_win';
	loadWindow('#full_win1',1,k_design_report,www,600);	
	$.post(f_path+"X/lab_sett_report_design.php",{id:id}, function(data){
		d=GAD(data);
		$('#full_win1').html(d);
		fixForm();
		fixPage();
		setRepDes();
		setFilToResive();
		set_rd_in_del();
		rdOrdering();
	})
}
function setRepDes(){
	$('.rd_r1').click(function(){setRDrow(1);});
	$('.rd_r2').click(function(){setRDrow(2);});
	$('.rd_r3').click(function(){setRDrow(3);});
	$( function() {
		$("#q_list3 > div[no]").draggable({			
			start: function(){
				drop_rd_no=$(this).attr('no');
				drop_rd_name=$(this).attr('txt');
				drop_rd_type=$(this).attr('t');
				drop_rd_del=$(this).attr('del');
				$(this).hide();
				$('.moveBox').show();
				$('.moveBox').css('left',XMO-20);
				$('.moveBox').css('top',YMO-60);			
			},
			drag: function(){				
				$('.moveBox').css('left',XMO-20);
				$('.moveBox').css('top',YMO-60); 
			},
			stop: function(){
				if(drop_rd_no!=0){delrdItm(drop_rd_no,drop_rd_del);drop_rd_no=0;}
				$('.moveBox').hide();				
			}
		});	
	});
}
function setRDrow(r){
	row='';
	ran=parseInt(Math.random()*100000);
	row+='<div r="r'+r+'" class="fl" id="r'+ran+'">';
	row+='<div class="rd_mover fl"></div>';
	for(i=0;i<r;i++){row+='<div class="fl" fil new></div>';}
	row+='<div class="rdr_del fl" onclick="delRow_rd('+ran+');"></div>';
	row+='</div>';
	$('.rd_b2').append(row);
	orderRD();
	rdOrdering();
	setFilToResive();
}
function setFilToResive(){
	$('.rd_b2 div[r] div[fil][new]').each(function(index, element){		
		$(this).droppable({
			drop:function(event,ui) {
				if(drop_rd_no!=0){
					dd_img='';
					delType='del="1"';
					if (typeof drop_rd_type == 'undefined'){
						drop_rd_type='';						
					}else{						
						if(drop_rd_type=='s2'){delType='del="2"';dd_img='<img src="../images/nti2.png"/><br>';}
						if(drop_rd_type=='s3'){delType='del="3"';dd_img='<img src="../images/nti3.png"/><br>';}
					}
					dd='<div selIt="'+drop_rd_no+'" new title="'+k_press_delete+'" '+drop_rd_type+' '+delType+'>'+dd_img+drop_rd_name+'</div>'
					$(this).append(dd);
					$(this).css('background-color','');
					set_rd_in_del();
					drop_rd_no=0;
					drop_rd_name='';
					drop_rd_type='';
				}				
			},
			over:function(event,ui){
				if(drop_rd_no!=0){$(this).css('background-color','#aaa');}
			},
			out:function(event,ui){$(this).css('background-color','');}
		});		
		$(this).removeAttr('new');	
	});
}
function set_rd_in_del(){
	$('div[selIt][new]').click(function(){
		nid=$(this).attr('selIt');
		del=$(this).attr('del');
		delrdItm(nid,del);
		$(this).removeAttr('new');
	})
}
function delrdItm(id,type){
	$('div[selIt='+id+'][del='+type+']').remove();
	$('.q_list3 > div[no='+id+'][del='+type+']').css('position','static');
	$('.q_list3 > div[no='+id+'][del='+type+']').show(300);
}
function orderRD(){
	rdWidth=$('.rd_b2').width()-90;
	rw1=(rdWidth-20);
	rw2=(rdWidth-40)/2;
	rw3=(rdWidth-60)/3;
	$('.rd_b2 div[r=r1] div[fil]').width(rw1);
	$('.rd_b2 div[r=r2] div[fil]').width(rw2);
	$('.rd_b2 div[r=r3] div[fil]').width(rw3);
}
function rdOrdering(){
	$( function() {
    	$( ".rd_b2" ).sortable({
    		handle: ".rd_mover",
			 axis: "y"
		});
	});
}
function delRow_rd(sel){
	$('#r'+sel).find('div[selit]').each(function(index, element) {
        nn=$(this).attr('selit');
		del=$(this).attr('del');
		delrdItm(nn,del);
    });
	$('#r'+sel).remove();
}
function save_rd(id){
	grv=get_rd_values();
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_sett_report_design_save.php",{id:id,grv:grv}, function(data){
		d=GAD(data);
		if(d==1){
			msg=k_done_successfully;
			win('close','#full_win1');
			loadModule();mt=1
		}else{msg=k_error_data;mt=0}
		loader_msg(0,msg,mt);
	})
}
function get_rd_values(){
	rd_data='';	
	$('.rd_b2 div[r]').each(function(index,element){
        rn=$(this).attr('r').substr(1);
		if(rd_data!='')rd_data+='|';
		rd_data+=rn+'^';
		rd_fir=0;
		$(this).children('div[fil]').each(function(index,element){
			if(rd_fir!=0){rd_data+=',';}else{rd_fir=1;}
			dl=$(this).children('div[selit]').length;
			if(dl>0){
				rd_data_in='';
				$(this).children('div[selit]').each(function(index,element){
					td_id=$(this).attr('selit');
					td_del=$(this).attr('del');
					if(rd_data_in!='')rd_data_in+='.';
					rd_data_in+=td_del+':'+td_id;
				})
				rd_data+=rd_data_in;
			}else{rd_data+='0';}
		});	
    });
	return rd_data;
}
function slNo(opr,id){
	x=0;
	if(opr==0){loadWindow('#m_info',1,k_ent_num_sams,500,300);no=0}else{
		no=$('#lsNN').val();
		if(no==''){ x=1;$('#lsNN').css('border','1px #f00 solid');}
	}
	if(x==0){
		if(opr==0){
			$.post(f_path+"X/lab_sample_number_change.php",{opr:opr,id:id},function(data){
				d=GAD(data);
				$('#m_info').html(d);
				$('#lsNN').focus();
				loadFormElements('#lsno_form');		
				setupForm('lsno_form','m_info');
				fixPage();
				fixForm();
			})
		}else{
			sub('lsno_form');
		}			
	}
}
function resetRLSTxt(){
	clearTimeout(lsrnoRest);
	$('#rlsMsg').css('color','');
	//$('#rsno').val('');
	$('#rlsMsg').html(k_rcv_sam);
	stopslref=0;
}
function printLabTic(id){printWindowC(4,id);}
function sampelsGropInfo(id){
	loadWindow('#full_win1',1,k_samples_groups,800,1);	
	$.post(f_path+"X/lab_sample_groups_info.php",{id:id}, function(data){
		d=GAD(data);
		$('#full_win1').html(d);
		fixForm();
		fixPage();
		setSG();
		loadSamplGrp(id);
	})
}
function setSG(){
	$('.samp_grp_list > div[n]').click(function(){
		g_id=$(this).attr('n');
		loadSamplGrp(g_id);
	})
	
}
function loadSamplGrp(id){
	$('#sampGrpDet').html(loader_win);
	$.post(f_path+"X/lab_sample_groups_details.php",{id:id}, function(data){
		d=GAD(data);
		$('#sampGrpDet').html(d);
		fixForm();
		fixPage();
		if(id==0){
			loadFormElements('#sampgrp');
			setupForm('sampgrp','m_info');		
		}
	})
}
function addTosGrp(){
	l=$("input[name='rec[]']").length
	if(l>0){
		loadWindow('#m_info',1,k_samples_add_to_group,500,1);	
		$.post(f_path+"X/lab_sample_groups_select.php",{}, function(data){
			d=GAD(data);
			$('#m_info').html(d);
			fixForm();
			fixPage();
			$('#grpSname').focus();
		})
	}
}
function saveSampGrop(n){
	if(n==0){		
		grp=$('#grpSname').val();
		if(grp!=''){
			$('#grp_name').val(grp);
			$('#sampgrp').submit();
		}else{
			nav(1,k_must_enter_group_name);
			$('#grpSname').focus();
		}		
	}else{
		$('#grp_id').val(n);
		$('#sampgrp').submit();
	}
}
function sendSG(id){
	open_alert(id,'lab_1',k_would_like_send_samples,k_samples_send);
}
function sendSG_do(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_sample_groups_send.php",{id:id},function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;sampelsGropInfo(id)}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);				
	})
}
function veiwReceiptDet(id){
	$('#sampGrpDet').html(loader_win);
	$.post(f_path+"X/lab_sample_group_receipt_details.php",{id:id}, function(data){
		d=GAD(data);
		$('#sampGrpDet').html(d);
		fixForm();
		fixPage();
		if(id==0){
			loadFormElements('#sampgrp');
			setupForm('sampgrp','m_info');		
		}
	})
}
function receiptSG(id){
	open_alert(id,'lab_2',k_did_receive_samples,k_receive_samples);
}
function receiptSG_do(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_sample_groups_receipt.php",{id:id},function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;veiwReceiptDet(id);r_samples_ref(1);}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);				
	})
}
function printSG(id){
	printLab(1,id);
}
function cancelSample(id,vis){
	actvisCancel=vis;open_alert(id,29,k_wnt_cnl_sam,k_cnl_sam);
}
function r_samples_work(l){
	if(r_stopslref==0){
		$.post(f_path+"X/lab_results_live.php",{},function(data){
			d=GAD(data);	
			dd=d.split(',');
			$('#lr1').html(dd[0]);
			$('#lr2').html(dd[1]);
			$('#lr3').html(dd[2]);
			$('#rsno').focus();
		})
	}
}
function lssv_del(id){open_alert(id,21,k_wnt_cnl_val,k_cnl_norl_val);}
function lssv_del_do(id){
	$.post(f_path+"X/lab_sett_normal_del.php",{id:id}, function(data){
		d=GAD(data);if(d==1){anaParts(anaPAct);}
	})
}
function anaParts(id){
	anaPAct=id;
	loadWindow('#full_win1',1,k_tst_rat,500,0);	
	$.post(f_path+"X/lab_sett_normal.php",{id:id}, function(data){
		d=GAD(data);
		$('#full_win1').html(d);
		fixPage();
		fixForm();
	})
}
function r_rev(l){
	$.post(f_path+"X/lab_review_live.php",{},function(data){
		d=GAD(data);
		d2=d.split('^');
		dd=d2[0].split(',');
		$('#lr1').html(dd[0]);
		$('#lr2').html(dd[1]);
		$('#lr3').html(dd[2]);
		fixPage();
	})
}
function slSpare(id,id_spare){
	loadWindow('#m_info',1,k_bu_sam,500,200);
	$.post(f_path+"X/lab_sample_spare_add.php",{id:id,id_spare:id_spare},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		$('#lsNN').focus();
		loadFormElements('#lsss_form');		
		setupForm('lsss_form','m_info');
		fixPage();
		fixForm();
	})
}
function save_lnsv(type){
	ageChk=1;
	sel_sex=1;
	typeChek=1;
	em='';
	if(sel_sex==1){}
	if(sel_age==1){ageChk=checkLage();}
	/****************************************************/
	if(type==1){		
		p1=parseFloat($('#p1').val());ErStl('#p1',0);
		p2=parseFloat($('#p2').val());ErStl('#p2',0);
		p3=parseFloat($('#p3').val());ErStl('#p3',0);
		p4=parseFloat($('#p4').val());ErStl('#p4',0);
		p5=parseFloat($('#p5').val());ErStl('#p5',0);
		if(isNaN(p2)){ErStl('#p2',1);typeChek=0;}
		if(isNaN(p4)){ErStl('#p4',1);typeChek=0;}
		if(typeChek==1){
			if(p2>=p4){
				ErStl('#p2',1);ErStl('#p4',1);typeChek=0;em+=k_err_nor_val;
			}
		}else{em=k_ent_req_val;}
		if(typeChek==1){
			if(p3!=''){
				if(p3<p2 || p3 >p4){
					ErStl('#p3',1);typeChek=0;em+=k_err_ent_defval;
				}
			}
		}
		if(typeChek==1){
			if(!isNaN(p1) || !isNaN(p5)){
				if(!isNaN(p1) && !isNaN(p5)){
					if(p1>p2){ErStl('#p1',1);typeChek=0;em+=k_err_ent_val;}
					if(p5<p4){ErStl('#p5',1);typeChek=0;em+=k_err_ent_val;}
					
				}else{
					ErStl('#p1',1);ErStl('#p5',1);typeChek=0;em+=k_bo_val_ent;
				}
			}
		}
	}
	/****************************************************/
	if(type==2){
		p2=parseFloat($('#p2').val());ErStl('#p2',0);
		if(isNaN(p2)){ErStl('#p2',1);typeChek=0;em=k_ent_req_val;}		
	}
	/****************************************************/
	if(type==4){
		p3=parseFloat($('#p3').val());ErStl('#p3',0);
		if(isNaN(p3)){ErStl('#p3',1);typeChek=0;em=k_ent_req_val;}
	}
	/****************************************************/
	if(type==5){
		p1=$('#p1').val();ErStl('#p1',0);
		if(p1==''){ErStl('#p1',1);typeChek=0;em=k_ent_req_val;}
	}
	/****************************************************/	
	if(type==7){		
		p1=$('#p1').val();ErStl('#p1',0);if(p1==''){ErStl('#p1',1);typeChek=0;}
		p2=$('#p2').val();ErStl('#p2',0);if(p2==''){ErStl('#p2',1);typeChek=0;}
		t1=$('#t1').val();ErStl('#t1',0);if(t1==''){ErStl('#t1',1);typeChek=0;}
		t2=$('#t2').val();ErStl('#t2',0);if(t2==''){ErStl('#t2',1);typeChek=0;}
		t3=$('#t3').val();ErStl('#t3',0);if(t3==''){ErStl('#t3',1);typeChek=0;}		
		if(typeChek==1){
			if(parseFloat(p1)>=parseFloat(p2)){
				ErStl('#p1',1);ErStl('#p2',1);typeChek=0;em=k_mn_sm_upval;
			}
		}else{em=k_ent_req_val;}		
	}
	/****************************************************/	
	if(type==8){
		p1=$('#p1').val();ErStl('#p1',0);
		if(p1==''){ErStl('#p1',1);typeChek=0;em=k_ent_req_val;}
	}
	/****************************************************/
	if(em!=''){nav(1,em);}
	if(ageChk==1 && sel_sex==1 && typeChek==1){
		$('#lvv_form').submit();
	}	
}
function checkLage(){
	age_f=$('#l_age1').val();
	age_t=$('#l_age2').val();
	if(age_f=='')age_f=0;	
	if(age_t=='')age_t=0;	
	age_f=parseFloat(age_f);
	age_t=parseFloat(age_t);
	if(age_f>age_t){
		ErStl('#l_age1',1);ErStl('#l_age2',1);
		return 0;
	}else{
		ErStl('#l_age1',0);ErStl('#l_age2',0);
		return 1;
	}	
}
function lssv_add(r_id,id,type){
	loadWindow('#m_info2',1,k_ad_nor_rng,600,0);	
	$.post(f_path+"X/lab_sett_normal_add.php",{r_id:r_id,id:id,t:type}, function(data){
		d=GAD(data);
		$('#m_info2').html(d);
		loadFormElements('#lvv_form');			
		setupForm('lvv_form','m_info2');
		fixPage();
		fixForm();
	})
}
function setAgeTemp(v){
	vv=v.split(',');
	if(vv.length==3){
		$('#l_age0').val(vv[0]);
		$('#l_age1').val(vv[1]);
		$('#l_age2').val(vv[2]);
		$('#l_age_c').val(0)
	}
}
function marageAna(id){
	mas_ana=id;
	loadWindow('#m_info',1,k_link_ana2samp,700,200);
	$.post(f_path+"X/lab_sample_link_old.php",{id:id},function(data){
		d=GAD(data);
		$('#m_info').html(d);		
		fixPage();
		fixForm();
	})
}
function marageAnaSave(sample){open_alert(sample,31,k_wld_link_analys_to_smpl,k_link_ana2samp);}
function marageAnaSaveDO(sample){
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_sample_link_old_save.php",{a:mas_ana,s:sample},function(data){
		d=GAD(data);		
		if(d==1){msg=k_done_successfully;win('close','#m_info');openLabSWin(1,actLabSW);mt=1}else{msg=k_error_data;mt=0}
		loader_msg(0,msg,mt);
	})
}
function l_alert_ref(l){
	if(l==1){$('.centerSideIn').html(loader_win);}
	$.post(f_path+"X/lab_alert_live.php",{},function(data){
		d=GAD(data);
		$('.centerSideIn').html(d);
		fixPage();
	})
}
function newSamplCB(t,no,cb){
	if(cb==1){
		if(t==2){r_samples_ref(1);win('close','#m_info3');findRack(ActRack);
		}else{r_samples_work(1);$('#rsno').val(no);resvLSNoDo3();}
	}else{		
		loader_msg(0,k_error_data,0);
	}		
}
function send_sampels_do(id,lab_no){	
	analysis_out='';
	if(id==0){
		$("div[ch_name='rec[]'] input").each(function(){
			r_id=$(this).val();
			if(analysis_out!=''){analysis_out+=',';}
			analysis_out+=r_id	
		});
	}else{
		analysis_out=id;
	}	
	if(analysis_out!=''){
		loadWindow('#m_info',1,k_send_tests_to_lab,www,hhh);
		$.post(f_path+"X/lab_out_selected_send.php",{ana_ids:analysis_out,ln:lab_no}, function(data){
			d=GAD(data);
			if(d==''){}else{}
			$('#m_info').html(d);
			fixPage();
			fixForm();
		})
	}else{
		nav(2000,k_ontst_sel);
	}
}
function sendGroupTolab(anarr,lab){	
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_out_send_do.php",{ids:anarr,l:lab},function(data){
		d=GAD(data);
		if(d==1){msg=k_done_successfully;mt=1;win('close','#m_info');loadFitterCostom('lab_out_send');}else{msg=k_error_data;mt=0;}
		loader_msg(0,msg,mt);		
	})
}
function printLab2(type,str){url=f_path+'PrintLab2/T'+type+'/'+str;popWin(url,800,600);}
function returnReport(id,samp){	
	ActSample=samp;
	no=ActSample;open_alert(id,'lab_3',k_wld_ret_analys_to_edit,k_analys_return);
}
function returnReport_do(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_results_return.php",{id:id},function(data){
		d=GAD(data);
		if(d==1){
			msg=k_done_successfully;mt=1;showLReport(id,1);
		}else{
			msg=k_error_data;mt=0;
		}
		resvLSNoDo3();
		loader_msg(0,msg,mt);			
	})
}
function emerg_set(id){
	loadWindow('#m_info',1,k_energency_tests,500,hhh-20);
	$.post(f_path+"X/lab_sample_emergency.php",{id:id}, function(data){
		d=GAD(data);				
		$('#m_info').html(d);
		loadFormElements('#emrgForm');		
		setupForm('emrgForm','m_info');
		fixForm();
		fixPage();
	
	})
}
/****************************NourCodeStart********************************************************/
var actRecPat=0;
var actReciept=0;
function reciept_ItemAdd(){
	loadWindow('#m_info',1,k_add,500,0);
	$.post(f_path+"X/lab_test_outlab_reciept_item_add.php",{},function(data){
		d=GAD(data);
		$('#m_info').html(d);
			loadFormElements('#Recform');
			fixPage();	
			setupForm('Recform','');
			fixForm();
	});
}
function addTestsRec(p,r){
	actRecPat=p;
	actReciept=r;
	loadWindow('#m_info',1,k_tests,800,0);
		$.post(f_path+"X/lab_test_outlab_reciept.php",{},function(data){
		d=GAD(data);
		$('#m_info').html(d);
			$('.listDataSelCon').each(function(index, element){
			ldsc_W=$(this).parent().css('overflow','hidden');
		    ldsc_W=$(this).parent().width()-4;
			ldsc_H=$(this).parent().height()-4;
			$(this).children('.listDataSel').width(ldsc_W);
			$('.listDataSel input').width(ldsc_W-4);
			$(this).parent().children('.proTab_in').width(ldsc_W-22);
			$(this).parent().children('.proTab_in').height(ldsc_H-76);
			$(this).parent().children('.proTab_in').find('.option_selected').width(ldsc_W-385);          
        });	
		fixPage();
		fixForm();
		op_listR();	
	})
}
var ser_in_type='';
function view_list_SerR(){
clearTimeout(ser_in_type);ser_in_type=setTimeout(function(){view_listR()},ser_wittig);
}
function op_listR(){
	$('.op_list div').click(function(){
		if($('#serListR').val()!=''){$('#serListR').val('');view_listR();}
		num=$(this).attr('num');
		val=$(this).attr('name');
		makeButtR(num,val);
		saveButtR(num);
		$(this).hide(500);
	})
}
function view_listR(){
	serl=$('#serListR').val();
	$('#list_optionR').html(loader_win);
	$.post(f_path+"X/lab_test_outlab_reciept_view_list.php",{serl:serl}, function(data){
		d=GAD(data);		
		$('#list_optionR').html(d);
		op_listR();
	})
}
function makeButtR(num,val){
	b='';
	b+='<div class="listButt fl hide" num ="'+num+'" id="R-'+num+'" style="background-color:'+clr1+'">';
	b+='<div class="delTag" onclick="delOprListR('+num+')"></div>';
	b+='<div class="strTag">'+val+'</div>';
	b+='</div>';
	$('#sel_optionR').append(b);listButtR();
	$('#R-'+num).show(500);		
}
function listButtR(){
	$('.listButt').mouseover(function(){
		detWidth=$(this).width();
		detHeight=$(this).height();
		$(this).children('.delTag').width(detWidth);
		$(this).children('.delTag').height(detHeight);
		$(this).children('.delTag').show();
	})
	$('.listButt').mouseout(function(){
		$(this).children('.delTag').hide();
	})
}
var saveButtArr=new Array();
indexR=0;
var saveButtArr2='';
function saveButtR(num){
	$.post(f_path+"X/lab_test_outlab_reciept_save.php",{num:num,pat:actRecPat,recP:actReciept}, function(data){
		d=GAD(data);
		dd=d.split('^');
		$('#'+dd[0]).css('background-color',clr1);
		$('#'+dd[0]).attr('recChild',dd[1]);
	})
}
function delOprListR(num){
	if($('#serListR').val()!=''){$('#serListR').val('');}
	$('#R-'+num).css('background-color',clr4);
	recChild=$('#R-'+num).attr('recChild');
	$('#R-'+num).children('.delTag').remove();
	$.post(f_path+"X/lab_test_outlab_reciept_delete.php",{id:recChild}, function(data){		
		$('#R-'+num).hide(500,function(){
			$('#R-'+num).remove();
		});		
		view_listR(num);
	});
}
/****************************NourCodeEnd********************************************************/
function showAnaToDelv(id){
	if(sezPage=='l_Resp'){
		ser_reset(1);
		$('.centerSideIn').html(loader_win);
		$.post(f_path+"X/lab_results_delivery.php",{vis:id},function(data){
			d=GAD(data);
			$('.centerSideIn').html(d);				
			fixForm();
			fixPage();		
		})
	}
}
function showPatToDelv(id){
	ser_reset(1);
	$('.centerSideIn').html(loader_win);
	$.post(f_path+"X/lab_results_delivery.php",{pat:id},function(data){
		d=GAD(data);
		$('.centerSideIn').html(d);				
		fixForm();
		fixPage();		
	})
}
var actDocAna=0;
function LabNewAnalysis(id,temp=0){// إضافة تحليل جديد
    actDocAna=id;
	loadWindow('#m_info2',1,k_sel_add_tst,www,hhh);	
	$.post(f_path+"X/lab_preview_analysis_add.php",{vis:visit_id,id:id},function(data){
		d=GAD(data);		
		$('#m_info2').html(d);
		$('#ssin').focus();
		loadFormElements('#l_ana');		
		setupForm('l_ana','m_info');						
		lab_resAnaSet(2);
		lab_resAnaSet2(0);
        $('[addDocATemp]').click(function(){addDocAnaTemp();})
        $('[docLoadATemp]').change(function(){loadDocAnaTemp($(this).val());})
		fixForm();
		fixPage();
        if(temp){loadDocAnaTemp(temp);}
	})
}
function addDocAnaTemp(){//حفظ موذج التحليل    
    var anaTData=[];
    $('.aalLinst').each(function(){
        mdc=$(this).attr('mdc');        
        anaTData.push(mdc);
    })
    anas=anaTData.join(',');
    if(anas){
        loadWindow('#m_info3',1,k_sv_tsamplt,400,0);
        $('#m_info3').html('<div class="win_body"><div class="form_body so f1 fs16 clr1 lh40">'+k_ent_tmp_nm+'<input type="text" id="lt_name"/></div>\
        <div class="form_fot fr"><div class="bu bu_t2 fr" onclick="win(\'close\',\'#m_info3\');">'+k_close+'</div>\
        <div class="bu bu_t3 fl" onclick="addDocAnaTempDo(\''+anas+'\');">'+k_save+'</div></div>');
        $('#lt_name').focus();
        fixPage();
        fixForm();
    }else{
        nav(3,k_ana_must_selected);
    }
}
function loadDocAnaTemp(data){ 
    $('[delana]').each(function(){
        let m=$(this).attr('delana'); 
		$(this).closest('tr').remove();				
		$('.ana_list_mdc div[mdc='+m+']').slideDown(400);
		$('.ana_list_mdc div[mdc='+m+']').attr('del','0');		
    })
    
    ids=data.split(',');
    for(i=0;i<ids.length;i++){
        drowAnaRow(ids[i]);
    }
    $('#temp').val('');
}
function addDocAnaTempDo(anas){//حفظ نموذح التحاليل عند الطبيب
    tName=$('#lt_name').val();
    if(anas && tName){
        loader_msg(1,k_loading);
        $.post(f_path+"X/lab_preview_analysis_add_temp.php",{name:tName,anas:anas},function(data){
            d=GAD(data);
            if(d){
                msg=k_done_successfully;mt=1;
                LabNewAnalysis(actDocAna,d);			
            }else{
                msg=k_error_data;mt=0;
            }
            loader_msg(0,msg,mt);
            win('close','#m_info3');
        })        
    }else{
        nav(3,k_ana_must_selected);
    }
}
function lab_resAnaSet(type){
	$('.ana_list_cat div').click(function(){
		num=$(this).attr('cat_num');
		if(actAnaCat!=num){
			$(this).addClass('actCat');
			$(this).removeClass('norCat');						
			$('.ana_list_cat div[cat_num='+actAnaCat+']').addClass('norCat');
			$('.ana_list_cat div[cat_num='+actAnaCat+']').removeClass('actCat');				
			if(num==0){
				$('.ana_list_mdc div[del=0]').show();	
			}else{	
				$('.ana_list_mdc div[del=0]').hide();
				$('.ana_list_mdc div[cat_mdc='+num+'][del=0]').show();
			}
			actAnaCat=num;
			$('#ssin').val('');$('#ssin').focus();serServIN('');
		}		
	})	
	$('.ana_list_mdc div[s="0"]').click(function(){
		mdc=$(this).attr('mdc');		
		drowAnaRow(mdc);
	})
}
function drowAnaRow(an_id){	
	this_a=$(".ana_list_mdc div[mdc='"+an_id+"']");
	del=this_a.attr('del');	
	if(del==0){
		name=this_a.attr('name');
		price=this_a.attr('price');
		this_a.attr('del','1');			
		fixPage();
		if($('.list_del[no="'+an_id+'"]').length==0){
			dd='<tr class="aalLinst " mdc="'+an_id+'" p="'+price+'"><input name="s_'+an_id+'" type="hidden" value="1"><td class=" ff B fs18 lh30 ws">'+name+'</td><td><div class="i30 i30_del fl" delAna="'+an_id+'" title="'+k_delete+'"></div></td>\
			</tr>';
			$('#srvData').append(dd);
			$('#saveButt').show(300);
			lab_resAnaSet2(an_id);
		}
		$('#ssin').val('');$('#ssin').focus();
		serServIN('');
	}
}
function lab_resAnaSet2(id){
	$('.ana_list_mdc div[del=1]').slideUp(300);
	$('[delAna='+id+']').click(function(){
		id=$(this).attr('delAna');
		$(this).closest('tr').remove();				
		$('.ana_list_mdc div[mdc='+id+']').slideDown(400);
		$('.ana_list_mdc div[mdc='+id+']').attr('del','0');
		if($('[delAna]').length==0){
			$('#saveButt').hide(300);
		}
	})
}
function delReqAna(id){open_alert(id,'lab_4',k_wld_del_req,k_req_del);}
function delReqAna_do(id){
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_preview_analysis_delete.php",{id:id},function(data){
		d=GAD(data);
		if(d==1){
			msg=k_done_successfully;mt=1;AnalysisN(0,actAnType);
		}else{
			msg=k_error_data;mt=0;
		}		
		loader_msg(0,msg,mt);		
	})
}
function LabSendAna(id){
	loadWindow('#m_info2',1,k_send_tests,700,350);	
	$.post(f_path+"X/lab_preview_analysis_send.php",{id:id},function(data){
		d=GAD(data);		
		$('#m_info2').html(d);		
		loadFormElements('#l_ana');
		setupForm('l_ana','m_info2');		
		fixForm();
		fixPage();		
	})
}
function LabSendAnaN(id){	
    loader_msg(1,k_loading);
	$.post(f_path+"X/lab_prv_analysis_send.php",{id:id},function(data){
		d=GAD(data);
		if(d==1){
			msg=k_done_successfully;mt=1;
            AnalysisN(id,actAnType);            
		}else{
			msg=k_error_data;mt=0;
		}		
		loader_msg(0,msg,mt);		
	})
}
function anaRequ(id){
	loadWindow('#m_info',1,k_analys_req,700,350);	
	$.post(f_path+"X/lab_preview_analysis_receive.php",{id:id},function(data){
		d=GAD(data);		
		$('#m_info').html(d);		
		loadFormElements('#n_visit');
		setupForm('n_visit','m_info');
		fixForm();
		fixPage();		
	})
}
function veiwAnaResult(id,t){
	loadWindow('#m_info2',1,k_preview_analysis,800,hhh);	
	$.post(f_path+"X/lab_preview_analysis_view.php",{id:id,t:t},function(data){
		d=GAD(data);		
		$('#m_info2').html(d);			
		fixForm();
		fixPage();		
	})
}
function prvSaveAna(id,t,ref_id){
	res_v=$('#anaresTxtRes').val();
	if(res_v!=''){
		loader_msg(1,k_loading);
		$.post(f_path+"X/lab_preview_analysis_enter.php",{id:id,val:res_v},function(data){
			d=GAD(data);
			if(d==1){
				msg=k_done_successfully;mt=1;
                //veiwAnaResult(ref_id,t);
                loadAna(ref_id);
                win('close','#m_info2');
			}else{
				msg=k_error_data;mt=0;
			}		
			loader_msg(0,msg,mt);			
		})
	}else{
		nav(2,k_analys_fill_befor_save);
	}
}
function prvEditAna(id,t,r_id){
	tr_val=$('#tri'+id).html();
	$('#tri'+id).html('<textarea style="font-size:18px"class="ff fs18 " id="anaresTxtRes" txt>'+tr_val+'</textarea>');
	$('#bri'+id).html('<div class="ic40 icc2 ic40_save" title="'+k_save+'" onclick="prvSaveAna('+id+','+t+','+r_id+')"></div>');
}
function sw2pat(p_id){
	ser_reset(1);
	$('#fil_p1').val(p_id);
	Tpage=$('.filterForm').attr('p');
	loadFitterCostom(page);	
}
function sw2vis(v_id){
	ser_reset(1);
	$('#fil_v1').val(v_id);
	Tpage=$('.filterForm').attr('p');
	loadFitterCostom(page);	
}
function anaAddNote(x_id){
	$('#b_'+x_id).hide();
	$('#i_'+x_id).show();
	$('#i_'+x_id).focus();
}
function setLabDev(id){	
	loadWindow('#m_info4',1,k_device_setts,700,350);	
	$.post(f_path+"X/lab_devices.php",{id:id},function(data){
		d=GAD(data);		
		$('#m_info4').html(d);		
		loadFormElements('#labDev');
		setupForm('labDev','m_info4');
		fixForm();
		fixPage();		
	})
}
function addSrvToVis(id){
	loadWindow('#m_info3',1,k_add_visit_srv,700,350);	
	$.post(f_path+"X/lab_visit_srv_add.php",{id:id},function(data){
		d=GAD(data);		
		$('#m_info3').html(d);		
		loadFormElements('#labsrv');
		setupForm('labsrv','m_info3');
		fixForm();
		fixPage();		
	})
}
/*
function lab_out(){
		$('div[ch_name=outlab_all]').click(function(){
		ch=$(this).children().attr('ch');
	//	if(ch=='on'){myanType=1;}else{myanType=0}
		form=$(this).closest('form').attr('id');
		$('#'+form).find("div[ch_name=outlab]").each(function(index, element) {
			id=$(this).attr('id');
			
            checkBoxlabClick($(this),ch);
        });
	})
}
function checkBoxlabClick(this_ch,v){		
	this_ch_val=this_ch.attr('ch_val');
	this_ch_name=this_ch.attr('ch_name');
	if(v==''){this_v=this_ch.children().attr('ch');}else{if(v=='on')this_v='off';else this_v='on';}		
	if(this_v=='on'){
		this_ch.children().attr('ch','off');
		this_ch.children().html('');
	}else{
		this_ch.children().attr('ch','on');
		this_ch.children().html('<input name="'+this_ch_name+'" type="hidden" value="'+this_ch_val+'" />');
	}
}
/*function loadAnalRes(id,t){
	actReport=id;
	if(t==0){$('#rr_b1 , #rr_b2').hide();}else{$('#rr_b1').show();}
	$('.rr_t2').html(loader_win);
	$.post(f_path+"X/lab_review_list_info.php",{id:id,t:t},function(data){
		d=GAD(data);
		$('.rr_t2').html(d);						
		fixForm();
		fixPage();
		fixReport();	
	})
}*/
/* sample send Old mood 
function snsInfo(){
	loadWindow('#m_info',1,k_sams_ntsnt_lab,800,1);	
	$.post(f_path+"X/lab_sample_receipt_info.php",{}, function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
}
*/
/****Work Tables****/
var actWtg=0;
function startworkTable(){
	wt_grp_load();
	setTimeout(function(){wt_ana_load();},1000);	
	$('[addWtGrp]').click(function(){addLabTable();})
	$('[refAna]').click(function(){wt_ana_load();})
}
function wt_grp_load(grp='',l=1){
	if(l==1){$('#wtGrps').html(loader_win);$('#tot1').html('');}	
	$.post(f_path+"X/lab_wt_grp_list.php",{g:actWtg},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
			$('#tot1').html(dd[0]);
			$('#wtGrps').html(dd[1]);
			if(grp){wt_grp_info(grp);}
		}
		$('[grpWT]').click(function(){
			wt_grp_info($(this).attr('grpWT'));
		})
		fixForm();
		fixPage();		
	})
}
function addLabTable(){
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_wt_grp_add.php",function(data){
		d=GAD(data);
		if(d==0){
			loader_msg(0,'',0);
			nav(4,k_not_possible_add);
		}else{			
			loader_msg(0,k_done_successfully,1);
			wt_grp_load(d);			
		}			
	})
}
function wt_grp_info(id){
	actWtg=id;
	$('#gTitle').html(k_loading);
	$('#gData').html(loader_win);	
	$.post(f_path+"X/lab_wt_grp_info.php",{id:id},function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
			$('#gTitle').html(dd[0]);
			$('#gData').html(dd[1]);
			$('[wtBacAna]').click(function(){wt_grp_info_oprs($(this).attr('wtBacAna'));})
			$('[wtBacSrv]').click(function(){wt_grp_info_oprs($(this).attr('wtBacSrv'),1);})
			$('[wtDelSrv]').click(function(){wt_grp_info_oprs($(this).attr('wtDelSrv'),2);})
			
			$('[wtg_done]').click(function(){wt_grp_info_oprs(0,3);})
			$('[wtg_del]').click(function(){wt_grp_del();})
			$('[wtg_print]').click(function(){printFixed(1,actWtg);})
		}
		fixForm();
		fixPage();		
	})
	
}
function wt_grp_del(){
	loader_msg(1,k_loading);	
	$.post(f_path+"X/lab_wt_grp_del.php",{id:actWtg},function(data){
		d=GAD(data);		
		if(d){				
			loader_msg(0,'',0);
			wt_ana_load();
			wt_grp_load();
			$('#gTitle').html('');
			$('#gData').html('');
			actWtg=0;
		}else{		
			loader_msg(0,k_error_data,0);		
		}
		fixForm();
		fixPage();		
	})
}
function wt_grp_info_oprs(id,o=0){
	loader_msg(1,k_loading);	
	$.post(f_path+"X/lab_wt_grp_info_oprs.php",{g:actWtg,id:id,o:o},function(data){
		d=GAD(data);		
		if(d){
			if(o==3){
				actWtg=0;
				$('#gTitle').html('');
				$('#gData').html('');
			}
			loader_msg(0,'',0);
			wt_ana_load();
			wt_grp_load(actWtg,0);
		}else{		
			loader_msg(0,k_error_data,0);		
		}
		fixForm();
		fixPage();		
	})	
}
function wt_ana_load(){
	$('#tot2').html('');
	$('#anas').html(loader_win);	
	$.post(f_path+"X/lab_wt_ana_list.php",function(data){
		d=GAD(data);
		dd=d.split('^');
		if(dd.length==2){
			$('#tot2').html(dd[0]);
			$('#anas').html(dd[1]);
			$('[wt_srvDel]').click(function(){WTsrvDel($(this).parent().attr('wt_srv'));});
			$('[wt_srvAdd]').click(function(){WTsrvAdd($(this).parent().attr('wt_srv'));});
			
		}
		fixForm();
		fixPage();		
	})
}
function WTsrvDel(id,t=0){
	if(t==0){
		loadWindow('#m_info',1,k_cancel_tests,500,350);
	}else{
		loader_msg(1,k_loading);
	}
	$.post(f_path+"X/lab_wt_ana_del.php",{t:t,id:id},function(data){
		d=GAD(data);		
		if(t==0){
			$('#m_info').html(d);
			$('[wgad1]').click(function(){WTsrvDel(id,1);})
			$('[wgad2]').click(function(){WTsrvDel(id,2);})
		}else{
			win('close','#m_info');
			if(d){				
				loader_msg(0,'',0);
				wt_ana_load();
				
			}else{		
				loader_msg(0,k_error_data,0);
			}	
		}
		fixForm();
		fixPage();		
	})	
}
function WTsrvAdd(id){
	if(actWtg){
		loader_msg(1,k_loading);
		$.post(f_path+"X/lab_wt_ana_add.php",{id:id,grp:actWtg},function(data){
			d=GAD(data);
			if(d>0){
				msg='';mt=1;
				wt_grp_info(actWtg);
				$('[grpWT="'+actWtg+'"] [t]').html(d);
				$('[wt_srv='+id+']').hide(300);
			}else{
				msg=k_error_data;mt=0;
			}		
			loader_msg(0,msg,mt);			
		})
	}else{
		nav(3,k_group_must_selected);
	}
}
function l_save_tempN(){
	temSrvs='';
	$('#anaSelected [anaSel]').each(function(){
        srv=$(this).attr('anaSel');		
		temSrvs+=srv+',';
    });
    temSrvs=temSrvs.slice(0,-1);    
	if(temSrvs==''){
		nav(1,k_ontst_sel);
	}else{
		winSave='<div class="f1 fs16 clr3 lh30 TC">'+k_ent_tmp_nm+'</div>\
        <div class="lh60 mg10v"><input type="text" id="temp_name"/></div>\
		<div class="fl w100 ">\
            <div class="ic30 ic30_x ic30Txt icc2 fr" lt_close>'+k_close+'</div>\
            <div class="ic30 ic30_save ic30Txt icc4 fl" lt_save>'+k_save+'</div>\
        </div>';
        $('.winLabTmp').height('');
        $('.winLabTmp').toggle();
	    $('.winLabTmp').html(winSave);
        $('#temp_name').focus();
		fixPage();
		fixForm();
	}
}
function save_ltameN(){
	temp_n=$('#temp_name').val();
	if(temp_n==''){
		nav(1,k_tmp_nm_ent);
	}else{
		loader_msg(1,k_loading);
		$.post(f_path+"X/lab_visit_template_save.php",{n:temp_n,v:temSrvs},function(data){
			d=GAD(data);
			if(d==1){
                msg=k_done_successfully;
                mt=1;
                win('close','#m_info3');
                $('.winLabTmp').slideUp(200,function(){$('.winLabTmp').html('');});
            }else{
                msg=k_error_data;mt=0;
            }
			loader_msg(0,msg,mt);
		})
	}
}
function load_ls_tempN(){
	$('.winLabTmp').html(loader_win);
	$('.winLabTmp').toggle();
    $.post(f_path+"X/lab_visit_templateN.php", function(data){
		d=GAD(data);
        $('.winLabTmp').height('50%');
		$('.winLabTmp').html(d);
		fixForm();
		fixPage();
	})
}
/*************/
function accDelAna(id){
    open_alert(id,'lab_sDel',k_do_del_ana+'<br>'+k_opr_cant_undo,k_delete_test);
}
function accDelAnaDo(id){    
    loader_msg(1,k_loading);
	$.post(f_path+"X/lab_del_ana.php",{id:id}, function(data){    
		d=GAD(data);
        dd=d.split('^');
        if(dd[0]=='0'){
			msg=k_done_successfully;mt=1;
			loadModule('n5dmy993nf');
		}else{
			msg=dd[1];
			mt=0;
		}
		loader_msg(0,msg,mt);
	})
}

function changeServiceSample(srv,sample){
	loader_msg(1,k_loading);
	$.post(f_path+"X/lab_sarvice_change_status.php",{srv:srv,sample:sample}, function(data){   
		d=GAD(data); 
		msg=k_error_data;mt=0;
		if(d==1){
			msg=k_done_successfully;
			mt=1;
		}
		loader_msg(0,msg,mt);
	})

}
<? include("../../__sys/mods/protected.php");?>
<script>
var accActMood=0;
var accActVis=0;
function endVisAcc(mod,vis){
	accActMood=mod;accActVis=vis;
	loadWindow('#m_info',1,k_visit_details,www,hhh);
	$.post(f_path+"X/gnr_acc_visit_end.php",{vis:vis,mod:mod},function(data){
		d=GAD(data);
		$('#m_info').html(d);
		fixForm();
		fixPage();
	})
}
function accvisOpr(opr,p1){
	loadWindow('#m_info2',1,k_the_proced,600,300);
	$.post(f_path+"X/gnr_acc_visit_end.php",{opr:opr,vis:accActVis,mod:accActMood,p1:p1},function(data){
		d=GAD(data);
		$('#m_info2').html(d);
		loadFormElements('#accVis');
		setupForm('accVis','m_info2');
		fixForm();
		fixPage();
	})
}
function accvisOprDone(mod,vis,opr){
	if(opr==4){
		win('close','#m_info');
		$('.n'+vis).remove();
	}else{
		endVisAcc(mod,vis);
	}
}

</script>

<div class="centerSideInFull fxg h100" fxg="gtc:250px 250px 250px 1fr|gtr:100%">
	<div class="cbg4 fxg r_bord" fxg="gtr:auto 1fr">       
        <div class="b_bord">
            <select sync_list>
                <option value="0">اختر القسم</option>
                <option value="6"><?=k_visits?></option>
                <option value="1"><?=k_box?></option>
                <option value="2"><?=k_clinics?></option>
                <option value="3"><?=k_drs?></option>
                <option value="4"><?=k_charities?></option>
                <option value="5"><?=k_insurance?></option>
                
                <!--<option value="7"><?=k_thlab?></option>-->
                <option value="8"><?=k_emps?></option>
                <!--<option value="9"><?=k_thdental?></option>-->
                <? if($thisGrp=='s'){?>
                    <!--<option value="10">أداء الأطباء</option>-->  
                <?}?>
            </select>            
        </div>
        <div class="h100 of">
            <div class="h100 pd10f ofx so" sync_info></div>
        </div>
	</div>
	<div class="pd10f ofx so r_bord cbg444" id="syncData1"></div>
	<div class="pd10f ofx so" id="syncData2"></div>
    <div class="pd10f ofx so l_bord" id="notes">
        <div class="f1 fs14 clr5 pd10f">يجب التأكد من أنه تم مزامنة الزيارات قبل البدء بباقي الأقسام</div>
    </div>
</div>
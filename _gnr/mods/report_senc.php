<? include("../../__sys/mods/protected.php");?>
<?=header_sec($def_title,'');?>
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
<div class="centerSideInHeader lh50">
	<div id="snc1Bloc">
	<div class="f1 fs16 clr1 lh50 pd10 fl"><?=k_department?> : </div>
	<div class="fl lh50">
	<select onChange="sncInfo(this.value)" style="width: 150px;">
		<option value="0"></option>
        <!--<option value="2"><?=k_clinics?></option>
		<option value="3"><?=k_drs?></option>
		<option value="4"><?=k_charities?></option>
		<option value="5"><?=k_insurance?></option>
		<option value="6"><?=k_visits?></option>-->
		<option value="7"><?=k_thlab?></option>
		<!--<option value="8"><?=k_emps?></option>-->
        <option value="9"><?=k_thdental?></option>
        <? if($thisGrp=='s'){?>
		    <option value="10">أداء الأطباء</option> 
        <?}?>
        
	</select>
	<!--<div class="fl bu2 bu_t3 n47668" onclick="endVisAcc(1,47668)"><ff>47668</ff></div>-->
	</div>
	</div>
	<div id="snc2Bloc" class="hide" >
		<table  cellpadding="4" width="100%"><tr><td id="snc2BlocIn" width="100%">
		</td><td><div class="bu bu_t3 buu fr" onclick="stopSncAction();" id="ssb"><?=k_stp?></div></td></tr></table>
	</div>
	<div class="uLine lh1 cb">&nbsp;</div>
</div>
<div class="centerSideIn so">
</div>
<script>sezPage='RepSnc';$(document).ready(function(e){sncInfo(1);});</script>
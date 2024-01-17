<? include("../../__sys/prcds/ajax_header.php");
if($_SESSION['m_id']){
	$pID=$_SESSION['m_id'];
	$pDate=get_val('lab_x_receipt','date',$pID);
}?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18"><?
	if($pID){echo '<ff>'.dateToTimeS3($pDate,1).'</ff>';}
	else{echo k_add;}?>
	</div>
	<div class="form_body so">
	<form name="Recform" id="Recform" action="<?=$f_path.'X/lab_test_outlab_reciept_save.php'?>" method="post" cb="addTestsRec('[1]',[2]);" bv="p,r">
	<? if($pID){echo '<input type="hidden" name="recParent" value="'.$pID.'"/>';}else{?>
	<div>
		<div class="fl  f1"><?=k_delivery_bill?></div>
		<select  name="recParent" required><?
			$sql="select * from lab_x_receipt";
		  	$res=mysql_q($sql);
		  	$rows=mysql_n($res);
		  	while($r=mysql_f($res)){
				echo '<option value='.$r['id'].'>'.dateToTimeS3($r['date'],1).'</option>';
			}?>
		</select>
	</div>
	<?}?>
	<div class="fs14 lh40 f1">
		<div class="fl f1"><?=k_patient?></div>
		<div class="">
			<input type="text" name="ptientname" style="width:100%;" required/>
		</div>	
	</div>
	<input type="hidden" name="type" value="patName"/>
	</form>
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
        <div class="bu bu_t3 fl" onclick="sub('Recform')"><?=k_save?></div>      
    </div>
    </div>
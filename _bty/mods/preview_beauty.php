<? include("../../__sys/mods/protected.php");?>
<?
$visit_id=pp($_GET['m_id']);
$doctor=get_val('bty_x_visits','doctor',$visit_id);?>
<?
$mood=5;
if($doctor==0){
	mysql_q("UPDATE bty_x_visits SET doctor='$thisUser' where id='$visit_id' ");
	mysql_q("UPDATE bty_x_visits_services SET doc='$thisUser' where visit_id='$visit_id' ");
	$doctor=$thisUser;
}
if($thisUser==$doctor){
$sql2="select * from bty_x_visits where id='$visit_id' and doctor='$doctor' limit 1";
$res2=mysql_q($sql2);
$rows2=mysql_n($res2);
if($rows2>0){
	$r2=mysql_f($res2);
	$doctor=$r2['doctor'];
	$patient_id=$r2['patient'];
	$d_start=$r2['d_start'];
	$d_check=$r2['d_check'];	
	$sub_type=$r2['sub_type'];
	$status=$r2['status'];
	$clinic=$r2['clinic'];	
	$pay_type=$r2['pay_type'];
	$pay_type_link=$r2['pay_type_link'];
	if($d_check==0){
		mysql_q("UPDATE bty_x_visits set d_check='$now' where id='$visit_id' ");
		mysql_q("UPDATE gnr_x_roles set doctor='$thisUser' where vis='$visit_id' and mood=5");
	}
	if($status==2 || $status==3){
		mysql_q("UPDATE gnr_x_roles set status=4 where vis='$visit_id' and mood=5");
		if($status==3){
			loc('_Beauty-Visits');
			exit;
		}
	}	
$clinic=$userSubType;
$sql="select * from gnr_m_patients where id='$patient_id' limit 1";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){
	$r=mysql_f($res);
	$sex=$r['sex'];
	$birth=$r['birth_date'];
	$birthCount=birthCount($birth);
	$p_title=$r['title'];
	if($p_title){
		$col=getColumesData('',0,'h4ljv9q3qf');		
		$p_titleTxt=viewRecElement($col[0],$p_title);
	}
	$B2='';
	$patName=get_p_name($patient_id,0);	?>
	<script>sezPage='BPreview';</script>
	<header>
    <div class="top_txt_sec fl">
		<div class="top_title f1 fs14 w100 Over" fix="h:35" onclick="patInfo(<?=$patient_id?>,5)">
			<ff><?=$patient_id?></ff> | <?=$p_titleTxt.' '.$patName?>
		( <ff><?=$birthCount[0]?> </ff><?=$birthCount[1]?> )
		</div><? 
		if($pay_type==2){				
			$name_ch=get_val('gnr_m_charities','name_'.$lg,$pay_type_link);
			echo '<div class="f1 inf_name f1 fs14 pd10" fix="h:25">'.$name_ch.' </div>';
		}?>
        
    </div>
    <div class="top_icons">
		<? echo topIconCus(k_end,'cbg5 ti_77 fr','bty_finshSrv(0,'.$status.')');?>	
       	<div class="fr timeStatus" id="timeStatus" >
        	<div line>            	
            	<div icon class="fr"></div>                
            	<div class="fr ff fs18 B" num id="stu_1"><?=getTotalCO("gnr_x_roles","status < 3 and clic='$clinic' and mood=5 ");?></div>
            </div>
            <div line2>
            	<div class="fr" icon2></div>
            	<div class="fr ff fs18 B" num2 id="stu_2"><?=dateToTimeS2(getDocWorkTime($visit_id,$clinic))?></div>
            </div>            
        </div><div class="fr swWin so"></div>              	
       <!-- <div class="fr cost_icon" title="<?=k_consumables?>" onclick="newCons(<?=$userStore?>,'','docCostAdd([data])','');"></div>-->
	   <?
	   if(chProUsed('dts')){
			echo topIconCus(k_appointments,'ti_date fr','selDtSrvs('.$clinic.',0,'.$patient_id.')');
		}
		if(modPer('b8kpe202f3','0')){
			echo topIconCus(k_documents,'ti_docs fr','patDocs('.$patient_id.',1)');			
		}?>        
    </div>    
	</header>
<div class="centerSideInHeader" style="height:40px;"><div class="datesline" id="prv_slider"></div></div>
<div class="centerSideIn of">
    <section class="tab16">
        <div class="tabs">
            <div icon="tab_p1" onclick="refPage('bty2',5000)"><?=k_services?></div>   
            <div icon="tab_p4" onclick="bty_loadHistory(<?=$patient_id?>,0);"><?=k_visits_his?> </div>
        </div>
        <div class="tabc">
	        <section class="mad_info2 so" id="sevises_list"></section>
            <section class="so"><div class="his_cont so" id="p_his"></div></section>
        </div>
    </section> 
</div>
<script>
	var visit_id=parseInt(<?=$visit_id?>);
	var patient_id=<?=$patient_id?>;	
	$(document).ready(function(e){bty_rev_ref(1,<?=$visit_id?>);refPage('bty2',8000);fixPage();});
</script><? 
}
}
}else{
	$status=get_val('bty_x_visits','status',$visit_id);
	if($status==2 || $status==3){
		delTempOpr($mood,$visit_id,'a');
	}
	loc('_Preview-Beauty');
}
?>
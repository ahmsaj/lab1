<? include("../../__sys/mods/protected.php");?>
<header style="width: 721px;">
	<div class="top_title fl f1"><?=k_prescriptions?> 
		<span id="m_total" class="title_Total"><ff>( 1 )</ff></span>
	</div>
	<div class="top_icons fr" type="list">
		<div class="top_icon ti_ref fr" onclick="presc_loadPrescriptions(1)" title="تحديث">
		</div>
	</div>
	<div class="fr resSamlpe">
		<div class="f1 fs14">
			<input type="text" id="patient_barcode"/>
		</div>
		<div class="f1 fs12 TC" t ><?=k_patient_barcode?></div>    
	</div> 
	<div class="top_icons fr" type="list">
		<div class="presc_top_icon sStatus fr cbg6">
			<div a2 id="part_exchanged_presc">0</div>
			<div b2 ><?=k_incomplete_pres?></div>
		</div>
		<div class="presc_top_icon sStatus fr cbg1">
			<div a id="all_presc">0</div>
			<div b2 ><?=k_total_pres?></div>
		</div>
		<div class="presc_top_icon sStatus fr cbg6">
			<div a2 id="exchanged_presc">0</div>
			<div b2 ><?=k_spent_pres?></div>
		</div>
		<div class="presc_top_icon sStatus fr cbg5">
			<div a2 id="not_exchanged_presc">0</div>
			<div b2 ><?=k_unspent_pres?></div>
		</div>
	</div>
	
	
</header>
<!--header>
	<div class="top_title fl f1"><?=k_lb_sams?></div>
    <div class="top_icons fr" type="list"> </div>
    <div class="fr resSamlpe">
    	<div class="f1 fs14"><input type="number" id="rsno" onkeyup="resvLSNo()"/></div>
        <div class="f1 fs12" t id="rlsMsg"><?=k_rcv_sam?></div>    
    </div>    
</header-->
<div class="centerSideInHeader">
	<div class="f1 fs18 clr1 pd10 lh50"  id="patient_name"></div>
</div>
<div class="centerSideIn so ofx"><div id="presc_data"></div></div>
<script>
	$(document).ready(function(e){
		refPage('pres_1',10000);
		presc_loadPrescriptions(0);
	});
</script>
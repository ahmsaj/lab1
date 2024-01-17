<? include("../../__sys/prcds/ajax_header.php");?>
<div class="win_body">
<div class="form_header so lh40 clr1 f1 fs18"><?=k_choose_pat_and_offer?></div>
<div class="form_body" type="static">
	<div class="fl r_bord" fix="w:300|hp:0">		
		<div fix="hp:0" class="ofx so pd10">
			<div class="f1 fs16 lh40 clr1111"><?=k_patient?> :</div>
			<div class="f1 clr1 bord fs14 uLine lh40 Over TC cbg44" onclick="selPatient('patOffer([id],[name])')" patno="0"><?=k_click_sel_pat?></div>			
			<div class="f1 fs16 lh40  clr1111"><?=k_offers?> :</div>			
			<select id="offer" onChange="viewOffer(this.value)" t >
				<option value="0"><?=k_offer_choose?></option><?
				$date_off_end=$now-86400;
				$sql="select * from gnr_m_offers where act=1 and date_s < $now and date_e > $date_off_end and type in(1,6)";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){
					while($r=mysql_f($res)){
						echo '<option value="'.$r['id'].'">'.$r['name'].'</option>';
					}
				}?>
			</select>
		</div>
	</div>
	<div class="fl pd10 ofx so" fix="wp:300|hp:0" fix="hp:0" id="offerView"></div>	
</div>
<div class="form_fot fr">
	<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
	<div class="bu bu_t3 fl" onclick="newOffer()"><?=k_buy?></div>
</div>
</div>
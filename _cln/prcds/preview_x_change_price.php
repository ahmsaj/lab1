<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){?>
	<div class="win_body"><?
		$id=pp($_POST['id']);	
		$r=getRec('cln_x_visits_services',$id);	
		$rows=$r['r'];
		if($rows>0){
			$s_id=$r['id'];
			$visit_id=$r['visit_id'];
			$service=$r['service'];
			$s_status=$r['status'];
			$offer=$r['offer'];
			$doc=$r['doc'];
			if(($s_status==0 || $s_status==2) && $doc=$thisUser){
				$r2=getRec('cln_m_services',$service);	
				$rows2=$r2['r'];
				$edit_price=$r2['edit_price'];
				if($edit_price){
					?><div class="form_body so" >    	
						<div class="f1 blc_win_title bwt_icon4"><?=$r2['name_'.$lg]?></div>
						<form name="srv_ch" id="srv_ch" action="<?=$f_path.'X/cln_preview_x_change_price_do.php'?>" method="post" cb="rev_ref(1,<?=$visit_id?>)" bv="">
						<input type="hidden" name="id" value="<?=$id?>" />
						<div class="f1 fs16 clr1 lh40"><?=k_specify_price_ser?></div>
						<input type="number" name="price" value="" required />
						<?
						if($offer){
							list($offer_id,$offer_item)=get_val_con('gnr_x_offers_oprations','offer,offer_item'," visit_srv='$s_id' and mood=1 ");
							echo '<div class="f1 fs16 clr5 lh30">'.k_ser_is_bel.' ( '.get_val('gnr_m_offers','name',$offer_id).' )<br> 
							'.k_ser_fee_ded.' <ff> ( '.get_val('gnr_m_offers_items','dis_percent',$offer_item).'% )</ff></div>';
						}?>
						
					 </div>
					 <div class="form_fot fr">
						<div class="bu bu_t2 fr" onclick="win('close','#m_info')"><?=k_close?></div> 
						<div class="bu bu_t3 fl" onclick="sub('srv_ch')"><?=k_save?></div>                       
					</div><?
				}
			}
		}?>
	</div><? 
}?>
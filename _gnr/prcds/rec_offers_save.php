<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['pat'],$_POST['offer'])){
	$pat=pp($_POST['pat']);
	$offer=pp($_POST['offer']);
	$ch1=getTotalCO('gnr_m_patients',"id='$pat'");
	$r=getRecCon('gnr_m_offers',"id='$offer' and act=1 ");	
	if($ch1 && $r['r']){
		$type=$r['type'];
		$clinics=$r['clinics'];
		$sett=$r['sett'];
		$s=explode(',',$sett);
		if($type==1){
			$price=get_sum('gnr_m_offers_items','(price*quantity)'," offers_id='$offer' ");		
			$qun=get_sum('gnr_m_offers_items','quantity'," offers_id='$offer' ");
		}else if($type==6){
			$qun=$s[3];
			$price=$s[3]*$s[2];
		}?>
		<div class="w100 h100 fxg" fxg="gtr:auto 50px">			
			<div class="ofx so cbg444 pd10f">
				<table width="" border="0" cellspacing="0" cellpadding="6" class="grad_s " type="static" over="0" >
				<tr><td txt width="180"><?=k_patient?>:</td><td txt><?=get_p_name($pat)?></td></tr>
				<tr><td txt><?=k_thoffer?>:</td><td txt><?=get_val('gnr_m_offers','name',$offer)?></td></tr>
				<tr><td txt><?=k_srvcs_num?> :</td><td><ff><?=$qun?></ff></td></tr>
				<tr><td txt><?=k_offer_val?> :</td><td class="cbg44 clr5"><ff ><?=number_format($price)?></ff></td></tr>
				</table>
			</div>
			<div class="cbg4 t_bord lh50">
                <div class="fr lh50 f1 fs14 clrw cbg6 pd10" > المبلغ المطلوب <ff>( <?=number_format($price)?> )</ff></div>
                <div class="fr payBut icc22" saveOfferPay  title="تنفيذ الدفعة نقدا"></div><?
                if(_set_l1acfcztzu){?>
                    <div class="fr payCard icc22" visPayCard="6" par="<?=$price?>" id="payCar5" mood="0" title="دفع الكتروني"></div><?
                }?>				
			</div>
		</div><?
	}
}?>
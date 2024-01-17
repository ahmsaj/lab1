<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['offer'],$_POST['id'],$_POST['mood'],$_POST['t'])){
	$id=pp($_POST['id']);
	$mood=pp($_POST['mood']);
	$t=pp($_POST['t']);
	$offer=pp($_POST['offer']);
	$type=get_val('gnr_m_offers','type',$offer);
	if($t==1){
		if($type==6){$action='onChange="selclicCat(2,'.$mood.',this.value)"';}
		echo '<input type="hidden" name="mood" value="'.$mood.'"/>';
		if($mood==1 || $mood==3){			
			echo '<div class="f1 fs16 lh40 clr1">'.k_tclinic.' :</div>';
			echo make_Combo_box('gnr_m_clinics','name_'.$lg,'id'," where act =1 and type='$mood'",'offSubType',0,'',"$action t");
			
		}else{
            $cond='';
			echo '<div class="f1 fs16 lh40 clr1">'.k_cat.' :</div>';
			if($mood==4){$table='den_m_services_cat';}
			if($mood==2){$table='lab_m_services_cats';}
			if($mood==5 || $mood==6){$table='bty_m_services_cat';$cond="where clinic in(select id from gnr_m_clinics where type='$mood')";}            
			if($mood==7){$table='osc_m_services_cat';}
			echo make_Combo_box($table,'name_'.$lg,'id',$cond,'offSubType',0,'',"$action t");
		}
	}
	if($t==2){
		echo '<div class="f1 fs16 lh40 clr1">'.k_service.' :</div>';
		$table=$srvTables[$mood];
		if($mood==1 || $mood==3){
			$q="where clinic='$id' ";
		}else{
			$q="where cat='$id' ";
		}
		echo make_Combo_box($table,'name_'.$lg,'id',$q,'offSubSrv',0,'','onChange="selclicCat(3,'.$mood.',this.value)" t');
		
	}
	if($t==3){		
		$table=$srvTables[$mood];
		if($mood==2){			
			list($name,$unit)=get_val($table,'name_'.$lg.',unit',$id);
			$price=$unit*_set_x6kmh3k9mh;
		}else{
			list($name,$hos_part,$doc_part)=get_val($table,'name_'.$lg.',hos_part,doc_part',$id);
			$price=$hos_part+$doc_part;
		}?>
		<div class="lh20 uLine">&nbsp;</div>
		<div class="f1 lh30 fs16 clr5 "><?=$name?> <ff> ( <?=$price?> )</ff></div>
		<div class="f1 lh30 fs16 clr1">السعر الجديد :</div>
		<div class="f1 lh30 fs16 clr5"><input type="number" name="price" srvPrice value="<?=$price?>"/></div>
		<div class="f1 lh30 fs16 clr1">عدد الخدمات :</div>
		<div class="f1 lh30 fs16 clr5 "><input type="number" name="num" value="3" srvNo /></div>
		<div class="f1 lh30 fs16 clr1">القيمة الإجمالية للخدمات :</div>
		<? if($mood==2){?><div class="f1 lh30 fs12 clr66">سعر الوحدة الجديد : <ff14 id="unitPrice"><?=_set_x6kmh3k9mh?></ff14></div><?}?>
		<div id="srvFullPrice" class="lh40 ff B TC fs18 cbg66 clrw" m="<?=$mood?>" u="<?=$unit?>"><?=($price*3)?></div>
		
		
		<?
		
	}
}?>
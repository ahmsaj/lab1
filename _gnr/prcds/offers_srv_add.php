<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$parts=[];
	$r=getRec('gnr_m_offers',$id);	
	if($r['r']){
		$type=$r['type'];
		$sett=$r['sett'];
		$clinics=$r['clinics'];
		$butTxt=k_srv_chos;?>		
		<div class="win_body"><? 
		if($type==6){
			$butTxt=k_save;?>
			<div class="form_header">
				<div class="lh40 clr1 f1 fs18"><?=k_thoffer?> ( <?=$r['name']?> )</div>
			</div>
			<div class="form_body so" type="full">
			<form name="offer6" id="offer6" action="<?=$f_path?>X/gnr_offers_srv_save.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?=$id?>"/><?
			if($sett){
				$s=explode(',',$sett);
				$clnTxt=get_val($subTablesOfeer[$clinics],'name_'.$lg,$s[0]);
				if($clinics==2){
					list($srvTxt,$unit)=get_val($srvTables[$clinics],'name_'.$lg.',unit',$s[1]);
					$price=$unit*_set_x6kmh3k9mh;
				}else{		list($srvTxt,$hos_part,$doc_part)=get_val($srvTables[$clinics],'name_'.$lg.',hos_part,doc_part',$s[1]);
					$price=$hos_part+$doc_part;
				}
				echo '
				<input type="hidden" name="mood" value="'.$clinics.'"/>
				<input type="hidden" name="offSubType" value="'.$s[0].'"/>
				<input type="hidden" name="offSubSrv" value="'.$s[1].'"/>
				<div class="f1 fs16 lh40">'.k_department.' : '.$clinicTypes[$clinics].' ( '.$clnTxt.' ) </div>
				<div class="f1 fs16 lh40">'.k_service.' : '.$srvTxt.'</div>
				';?>
				<div class="lh20 uLine">&nbsp;</div>
				<div class="f1 lh40 fs16 clr5 "><?=$srvTxt?> <ff> ( <?=$price?> )</ff></div>
				<div class="f1 lh30 fs16 clr1">السعر الجديد :</div>
				<div class="f1 lh30 fs16 clr5"><input type="number" name="price" srvPrice value="<?=$s[2]?>"/></div>
				<div class="f1 lh40 fs16 clr1">عدد الخدمات :</div>
				<div class="f1 lh30 fs16 clr5 "><input type="number" name="num" value="<?=$s[3]?>" srvNo /></div>
				<div class="f1 lh40 fs16 clr1">القيمة الإجمالية للخدمات :</div>
				<?
				if($clinics==2){?>
					<div class="f1 lh30 fs12 clr9">عدد وحدات التحليل : <ff14><?=$unit?></ff14></div>
					<div class="f1 lh30 fs12 clr66">سعر الوحدة الجديد : <ff14 id="unitPrice"><?=($s[2]/$unit)?></ff14></div><?
				}?>
				<div id="srvFullPrice" class="lh40 ff B TC fs18 cbg66 clrw" m="<?=$clinics?>" u="<?=$unit?>"><?=($s[2]*$s[3])?></div><?
				
			}else{?>								
				<div class="f1 fs16 lh40 clr1"><?=k_department?> :</div>
				<select id="clnicType" onchange="selclicCat(1,this.value)" t>
				<option value="0"><?=k_dept_choose?></option><?
				foreach($clinicTypes as $k => $part){
					if($part){
						$ch='off';
						if(in_array($k,$parts)){$ch='on';}
						echo '<option value="'.$k.'">'.$part.'</option>';
					}
				}?>
				</select>
				<div id="subcT1"></div>
				<div id="subcT2"></div>
				<div id="subcT3"></div><?
			}?>
			</form>
		</div><?
		}else{?>
			<div class="form_header">
				<div class="lh40 clr1 f1 fs18"><?=k_thoffer?> ( <?=$r['name']?> )</div>			
				<div class="lh30 clr5 f1 fs14"><?=k_sel_percent_depart_srv?></div>			
			</div>
			<div class="form_body so" type="full">
				<form name="offer6" id="offer6" action="<?=$f_path?>X/gnr_offers_srv_save.php" method="post" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?=$id?>"/>					
					<div class="f1 fs16 lh40 clr1"><?=k_discount_percent?> :</div>
					<div><input id="offerp" type="number" ></div>					
					<div class="f1 fs16 lh40 clr1"><?=k_department?> :</div><?
					echo '<select id="clnicType" onchange="selclicCat(1,this.value)" t>
					<option value="0">'.k_dept_choose.'</option>';				
					foreach($clinicTypes as $k => $part){
						if($part){
							$ch='off';
							if(in_array($k,$parts)){
								$ch='on';
							}
							echo '<option value="'.$k.'">'.$part.'</option>';
						}
					}
					echo '</select>
					<div id="subcT1"></div>';?>	
				</form>
			</div>
		<?}?>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info2');"><?=k_close?></div>
			<div class="bu bu_t3 fl" onclick="offerSelSrv(<?=$type?>);"><?=$butTxt?></div>
		</div>
		</div><?		
	}
}?>
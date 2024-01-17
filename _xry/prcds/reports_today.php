<? include("../../__sys/prcds/ajax_header.php");?>
<div class="win_body">	
	<div class="form_body so" type="pd0"><?
		$sql="select * from xry_x_pro_radiography_report where doc='$thisUser' and date>=$ss_day and date < $ee_day  order by date DESC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);	
		if($rows>0){?>			
			<table width="100%" border="0"  class="grad_s holdH" type="static" cellspacing="0" cellpadding="4" over="0" >		
			<tr>
			<th class="fs16 f1">#</th>
			<th class="fs16 f1"><?=k_date?></th> 
			<th class="fs16 f1"><?=k_photo?></th>
			<th class="fs16 f1"><?=k_patient?></th>
			<th class="fs16 f1"><?=k_service?></th>        
			<th class="fs16 f1"><?=k_technician?></th>			
			<th class="fs16 f1" width="40"></th>
			</tr> <?
			while($r=mysql_f($res)){
				$id=$r['id'];
				$date=$r['date'];
				$patient=$r['patient'];
				$service=$r['service'];
				$photos=$r['photos'];
				$ray_tec=$r['ray_tec'];
				$srvTxt=get_val_arr('xry_m_services','name_'.$lg,$service,'srv');
				$userTxt=get_val_arr('_users','name_'.$lg,$ray_tec,'u');
				$photoTxt='';
				if($photos){
					$photoTxt='<div class="fl w100">'.viewPhotosImg($photos,1,5,40,40).'</div>';
				}?>
				<tr>
				<td class="ff B fs16"><?=$id?></td>
				<td class="f1"><ff><?=date('Ah:i',$date)?></ff></td>
				<td class="f1"><?=$photoTxt?></td>
				<td class="f1"><?=get_p_name($patient)?></td>
				<td class="f1"><?=$srvTxt?></td>			
				<td class="f1"><?=$userTxt?></td>
				<td class="f1"><div class="ic40 icc1 ic40_info ic40Txt" onclick="xry_erep(<?=$id?>)"><?=k_details?></div></td>
				</tr><?
			}
			
			?></table><?
		}else{
			echo '<div class="lh40 f1 fs18 clr5">'.k_no_results.'</div>';
		}?>
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>     
    </div>
</div>
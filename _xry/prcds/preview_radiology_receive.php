<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('xry_x_visits_requested',$id);
	?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18"><?=get_p_name($r['patient'])?></div>
	<div class="form_body so">
	<? if($r['r']){
		if($r['status']==1){
			$clinic=$r['x_clinic'];
			$action="viSts(3,[1]);";?>
	
			<form name="n_visit" id="n_visit" action="<?=$f_path?>X/gnr_visit_add_save.php" method="post" cb="<?=$action?>" bv="id">				
				<input type="hidden" name="c" value="<?=$clinic?>">
				<input type="hidden" name="p" value="<?=$r['patient']?>">
				<input type="hidden" name="vis" value="0">
				<input type="hidden" name="d" value="0">
				<input type="hidden" name="t" value="3">
				<input type="hidden" name="xry_req" value="<?=$id?>">

				<table width="100%" id="srvData" border="0" cellspacing="0" cellpadding="6" class="grad_s holdH" type="static">
				<th><?=k_service?></th><th> <?=k_price?></th><?
				$xphs=get_vals('xry_x_visits_requested_items','xphoto',"r_id='$id' and action=1 ");
				if($xphs){
					$sql="select * from xry_m_services where id IN($xphs)";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){
						$all_price=0;
						while($r=mysql_f($res)){
							$x_id=$r['id'];													
							$time_req=$r['time_req'];							
							$fast=$r['fast'];
							$name=$r['name_'.$lg];
							$hos_part=$r['hos_part'];
							$doc_part=$r['doc_part'];
							$price=$hos_part+$doc_part;
							$all_price+=$price;							
							echo'
							<tr>
							<input name="ser_'.$x_id.'" type="hidden" value="'.$price.'">							
							<td class="f1 fs14 lh30 ">'.$name.'</td>							
							<td ><ff>'.number_format($price).'</ff></td>					
							</tr>';
						}
						echo'
						<tr>							
						<td class="fs16 f1">'.k_total.'</td>							
						<td ><ff class="clr5">'.number_format($all_price).'</ff></td>					
						</tr>';
					}
				}?>
				</table>
			</form>					
				
			<?
		}else{
			echo '<div class="f1 fs18 clr5 lh40">'.k_req_cant_complete.'</div>';
		}
	}else{
		echo '<div class="f1 fs18 clr5 lh40">'.k_no_req_num.'</div>';
	}?>
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
		<? if($rows>0){?><div class="bu bu_t3 fl " onclick="sub('n_visit');"><?=k_save?></div><?}?>
    </div>
    </div><?
}?>
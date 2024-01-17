<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['t'])){
	$id=pp($_POST['id']);
	$cType=pp($_POST['t']);
	if($cType==1){$table='cln_x_visits';$table2='cln_x_visits_services';}
	if($cType==3){$table='xry_x_visits';$table2='xry_x_visits_services';}
	if($cType==4){$table='den_x_visits';$table2='';}
	if($cType==5){$table='bty_x_visits';$table2='bty_x_visits_services';}
	if($cType==6){$table='bty_x_laser_visits';$table2='';}
	$r=getRecCon($table," id='$id' and status=0 and dts_id!=0 ");
	$save=0;
	if(isset($_POST['doc'])){
		$newDoc=pp($_POST['doc']);
		if($r['r']){
			$doc=$r['doctor'];
			$clinic=$r['clinic'];
			$dts_id=$r['dts_id'];
			if(getTotalCO('_users'," id='$newDoc' and subgrp in ($clinic)")){
				if(mysql_q("UPDATE $table SET doctor='$newDoc' where id='$id' limit 1")){
					if($table2){
						if(mysql_q("UPDATE $table2 SET doc='$newDoc' where visit_id='$id' limit 1")){echo 1; }
					}else{
						echo 1;
					}
				}
				if($dts_id){
					mysql_q("UPDATE dts_x_dates SET doctor='$newDoc' where id='$dts_id' limit 1");
				}
			}
		}
	}else{?>
		<div class="win_body">
		<div class="form_header so lh40 clr1 f1 fs18"></div>
		<div class="form_body so"><?
		if($r['r']){
			$doc=$r['doctor'];
			$clinic=$r['clinic'];
			echo '<div class="f1 fs18 clr1 lh40 uLine">'.k_sel_altr_doc.'</div>';
			echo make_Combo_box('_users','name_'.$lg,'id'," where subgrp in($clinic)",'chDoc',1,$doc,' t ');
			echo '<div class="f1 fs14 clr5 lh40">'.k_note.' : '.k_chng_doc_responsible.'</div>';
			$save=1;
		}else{
			echo '<div class="f1 fs16 clr5 lh40">'.k_visit_cant_modify.'</div>';
		}
		?>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info2');"><?=k_close?></div>
			<? if($save){?><div class="bu bu_t3 fl" onclick="changDoc_do();"><?=k_save?></div><? }?>
		</div>
    </div><?
	}
}?>
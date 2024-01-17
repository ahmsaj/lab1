<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['ana_ids'],$_POST['ln'])){
	$ana_id=pp($_POST['ana_ids'],'s');
	$lab_id=pp($_POST['ln']);?>
	<div class="win_body">
	<div class="form_header lh40 f1 fs18 clr1">
		<div class="fl f1 fs18 clr1111 lh40"><? 
			$sql="select * from lab_m_external_Labs where act=1 order by name_$lg asc";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				echo '<div class="f1 fs18 fl pd10">'.k_sel_ext_lab.'</div><div class="fl">
				<select id="outLab" t style="width:200px;" class="fs18" onChange="send_sampels_do(0,this.value);">';
				$i=0;
				while($r=mysql_f($res)){
					$id=$r['id'];
					if($lab_id==0 && $i==0){$lab_id=$id;}
					$name=$r['name_'.$lg];
					$sel='';
					if($lab_id==$id){$sel="selected";}
					echo '<option value="'.$id.'" '.$sel.'>'.$name.'</option>';
					$i++;
				}
				echo '</select></div>';
			}?>
		</div>
		<div class="fr printIcon" title="<?=k_print_sams?>" onclick="printLab2(5,<?='\''.$ana_id.'\''?>);"> </div>
	</div>
	<div class="form_body so" style="padding-top:0px"><?
		$ana_prices=array();
		$anas=get_vals('lab_x_visits_services','service'," id IN($ana_id) ");
		if($anas){
			$sql="select * from lab_m_external_labs_price where lab='$lab_id' and ana IN($anas)";
			$res=mysql_q($sql);
			while($r=mysql_f($res)){
				$ana_prices[$r['ana']]=$r['price'];				
			}
		}
		//$items_arr=explode(',',$items);
		$sql="select * ,x.id as x_id  from lab_x_visits_services x ,lab_m_services m where 
		x.service=m.id and x.id in ($ana_id) order by x.id ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
			<tr><th>'.k_sample_date.'</th><th>'.k_num_serv.'</th><th>'.k_visit_num.'</th><th>'.k_patient.'</th><th>'.k_sample.'</th><th width="100">'.k_test_code.'</th><th>'.k_short_name.'</th><th>'.k_notes.'</th></tr>
			';
			while($r=mysql_f($res)){
				$s_id=$r['x_id'];
				$visit_id=$r['visit_id'];
				$sample_link=$r['sample_link'];
				$service=$r['service'];
				$p=$r['patient'];
				$code=$r['code'];
				$short_name=$r['short_name'];
				$price=$r['total_pay'];				list($pkg_id,$no,$samplDate,$status)=get_val('lab_x_visits_samlpes','pkg_id,no,date,status',$sample_link);
				if($samplDate){$samplDate=date('Y-m-d',$samplDate);}
				$p_data=get_p_name($p,3);
				$service_id=$r['service'];
				$lab_price=$ana_prices[$service];
				$note='';
				if(!$lab_price){$note=k_test_price_not_determined;}
				echo'<tr>
					<td><ff>'.$samplDate.'</ff></td>
					<td><ff>'.$s_id.'</ff></td>
					<td><ff>'.$visit_id.'</ff></td>
					<td><div class="f1 lh20 ">'.$p_data[0].' <br>'.$sex_types[$p_data[4]].' ( '.$p_data[1].' )</div></td>
					<td>'.get_samlpViewC(0,$pkg_id,2,$no).'</td>
					<td>'.$code.'</td>
					<td>'.$short_name.'</td>					
					<td><div class="f1 clr5">'.$note.'</div></td>
				</tr>';
			}
			echo'</table>';
		}
		?>
	</div>
	<div class="form_fot fr">
		<div class="bu bu_t3 fl" onclick="sendGroupTolab('<?=$ana_id?>',<?=$lab_id?>)"><?=k_send?></div>
		<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
	</div>
	</div>
<? }?>

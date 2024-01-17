<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['d'])){	
	$data=pp($_POST['d'],'s');
	$pac_u1=$pac_n1=$pac_u2=$pac_n2=0;
	if($data){$d=explode('-',$data);$pac_u1=$d[0];$pac_n1=$d[1];$pac_u2=$d[2];$pac_n2=$d[3];}
	
	$unites=array();
	$sql="select * from str_m_items_units where act=1 order by name_$lg ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$i=0;
		while($r=mysql_f($res)){
			$unites[$i]['id']=$r['id'];
			$unites[$i]['name']=$r['name_'.$lg];
			$i++;
		}
	}
?><div class="win_body">	 
    <div class="form_body so" type="full">
		<table width="100%" class="grad_s" style="max-width: 600px" align="center" cellpadding="4" cellspacing="0" type="static" over="0" style="table-layout:fixed;">
			<tr>
				<td><div class="f1 fs14 clr1"><?=k_main_packaging?></div></td>
				<td><div class="f1 fs14 clr1"><?=k_sub_packaging?></div></td>				
			</tr>
			<tr>
				<td><div class="pacIcon pacIcon11"></div></td>
				<td><div class="pacIcon pacIcon22"></div></td>				
			</tr>
			<tr>
				<td><select id="pacT1" t onChange="countPac()"><option value="0"><?=k_main_classification_unit?></option><? 
				foreach($unites as $u){
					$sel='';if($u['id']==$pac_u1){$sel='selected';}
					echo '<option value="'.$u['id'].'" '.$sel.'>'.$u['name'].'</option>';
				}?></select></td>
				
				<td><select id="pacT2" t onChange="countPac()"><option value="0"><?=k_subcategory_unit?></option><?
				foreach($unites as $u){
					$sel='';if($u['id']==$pac_u2){$sel='selected';}
					echo '<option value="'.$u['id'].'" '.$sel.'>'.$u['name'].'</option>';}?></select></td>
			</tr>
			<tr>
				<td><div class="f1 fs14 clr1 lh30"><?=k_number_subunits_main_envelope?></div>
				<input type="number" value="<?=$pac_n1?>" id="pNo1" onkeyup="countPac()"/></td>
				<td><div class="f1 fs14 clr1 lh30"><?=k_number_items_units_subpacking?></div>
				<input type="number" value="<?=$pac_n2?>" id="pNo2" onkeyup="countPac()"/></td>
			</tr>			
			<tr>
				<td colspan="2" class="f1 fs16"><?=k_total_number_units_packaging?> : <ff id="pcTotal">1</ff></td>
				
			</tr>
			<tr>
				<td colspan="2">
				<div class="f1 clr5 lh30 fs14"><?=k_no_main_packaging_subpack_keep_blank?></div>
				<div class="f1 clr5 lh30 fs14"><?=k_filling_main_packagin_fill_subpack?></div>
				</td>
				</tr>
		</table>
			
    </div>
    <div class="form_fot fr">
      <div class="bu bu_t2 fr" onclick="win('close','#m_info');" ><?=k_close?></div>
      <div class="bu bu_t1 fl hide" id="endButt" onclick="endPac();" ><?=k_end?></div>      
    </div>
    </div><?
}?>

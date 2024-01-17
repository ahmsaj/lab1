<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['table'])){
	$table=pp($_POST['table'],'s');
	$sql="SHOW COLUMNS FROM $table ";
	$cols=mysql_q($sql);
	$rows=mysql_n($cols);
	$cols_index=[];
	if(isset($_POST['column'])){
		$column=pp($_POST['column'],'s');
		if($column!=''){
			$col_arr=explode('|',$column);
			foreach($col_arr as $v){
				$temp=explode('-',$v);
				$col_name=$temp[0];
				$lenV=$temp[1];
				if(!$lenV){$lenV='';}
				$cols_index[$col_name]['index']=$lenV;
				
			}
		}
	}

?>
	<div class="win_body">
	<div class="form_header so lh40 clr5 f1 fs16">
		<?=k_sel_index_cols?>:</div>
	<div class="form_body so">
		<form id="index_cols" name="index_cols">
			<table width="100%" border="0" cellspacing="0" cellpadding="4" type="static" class="grad_s mlord" id="selMalTab">
				<tr>
					<th  width="30"></th>
					<th><?=k_column?></th>
					<th><?=k_length?></th>
					<th width="30"></th>
				</tr>
				<? 
					$out1=$out2='';
					while($col=mysql_f($cols)){//print_r($col);
						$col_name=$col['Field'];
						if(isset($cols_index[$col_name])){
							$cols_index[$col_name]['table']=$col;
						}else{
							$out1.=getTable_cols($col);
						}
					}
					foreach($cols_index as $k=>$v){
						//echo $k.'<br>';
						$col=$v['table'];
						$prefix_length=$v['index'];
						$out2.=getTable_cols($col,'edit',$prefix_length);
						
					
					}
				echo $out2.$out1;
				?>
			</table>
		</form>	
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info4');"><?=k_close?></div>     
        <div class="bu bu_t3 fl" onclick="index_col_save()" style="margin-right:-1px;"><?=k_save?></div>     
    </div>
    </div><?
}

function getTable_cols($col,$status='add',$prefix_length=''){
	$col_name=$col['Field'];
	$col_full_type=$col['Type'];
	$temp=explode('(',$col_full_type);
	$col_type=$temp[0];
	$col_length=explode(')',$temp[1])[0];
	$ok=(strpos($col_type, 'text') !== false) || (strpos($col_type, 'char') !== false)||(strpos($col_type, 'binary') !== false)||(strpos($col_type, 'blob') !== false);
	$cbg=$ch=''; 
	if($status=='edit'){
		$ch='checked';
		$cbg='cbg44';
	}
	$out='
	<tr class="'.$cbg.'">
		<td><input type="checkbox" id="sel_cols"  '.$ch.'  /></td>
		<td col="'.$col_name.'" class="fs14">'.$col_name.' - '.$col_full_type.'</td>
		<td width="60">';
		if($ok){$out.='<input text="'.$ok.'" col_length="'.$col_length.'" type="number" id="prefix_length" value="'.$prefix_length.'"  />';}
	$out.=
		'</td>
		<td><div class="mover"></div></td>
	</tr>';
	return $out;
}?>
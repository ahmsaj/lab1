<? include("ajax_header.php");?>
<div class="win_body">
<div class="form_header lh40 clr1 fs18 f1"><?=k_module?></div>
<div class="form_body so " type=""><? 
$data_arr=array();
$qq='';
if($thisUser!='s'){
	$p_type=$_SESSION[$logTs.'grpt'];
	if($p_type==1){$g_code=$thisGrp;}
	if($p_type==2){$g_code=$thisUserCode;}
	$m_codes=get_vals('_perm','m_code',"g_code='$g_code' and p0=1 and type=$p_type ","','");
	$qq="and ( code in ('$m_codes') OR type=0)";
}
$sql="select * from _modules_list where hide=0 and act=1 and type!=3 $qq order by ord ASC";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){		
	$fav=get_vals('_fav_list','m_code'," user_code='$thisUserCode' ",'arr');
	$i=0;
	while($r=mysql_f($res)){
		$mod_code=$r['mod_code'];
		$m_code=$r['code'];
		$type=$r['type'];
		if($type==1){$table='_modules';}
		if($type==2){$table='_modules_';}
		$sec=get_val_con($table,'module',"code='$mod_code'");
		$data_arr[$i]['code']=$m_code;
		$data_arr[$i]['mod_code']=$mod_code;			
		$data_arr[$i]['title']=$r['title_'.$lg];
		$data_arr[$i]['p_code']=$r['p_code'];
		$data_arr[$i]['section']=$sec;
		$data_arr[$i]['type']=$type;
		$chM=0;
		if(in_array($m_code,$fav)){$chM=1;}		
		$data_arr[$i]['ch_ch']=$chM;				
		$i++;
	}
}?>
<form name="favFo" id="favFo" action="<?=$f_path?>S/sys_fav_save.php" method="post" cb="loadFav()" bv="" max="<?=_set_fltfu89tyr?>">
<table class="grad_s " width="100%" cellpadding="4" cellspacing="0" type="static" Over="0"><?
$module_section=''; $out='';
foreach($data_arr as $d){
	$mod_code=$d['mod_code']; 
	$p_code=$d['p_code'];
	if($p_code=='0'){
		if($mod_code=='0'){
			$sub_m='';
			$p_code=$d['code'];
			foreach($data_arr as $sd){
				if($sd['p_code']==$p_code){
					$m_code=$sd['code'];
					$func="setFavMenu('$m_code')";					
					$ch='';
					$ch_ch=$sd['ch_ch'];
					if($sd['ch_ch']){$ch_ch=' checked ';}						
					$sub_m.='<tr>
						<td></td>
						<td width="30">
							<input type="checkbox" name="mPer[]'.$m_code.'" value="'.$m_code.'" par="modL" '.$ch_ch.'/>
						</td>
						<td><div class="fl lh40 f1 fs16">'.$Madd.$sd['title'].'</div></td>
					</tr>';
				}
			}
			if($sub_m!=''){
				$out.= '<tr bgcolor="'.$clr44.'"><td></td>
					<td colspan="2">
						<div class="fl fs14x f1 pd10">'.$d['title'].'</div>
					</td>
			   </tr>'.$sub_m;
			}
		}else{
			$ch_ch='';
			if($d['ch_ch']){$ch_ch=' checked ';}				
			$Madd='';
			$m_code=$d['code']; 
			$func="setFavMenu('$m_code')";
			if($d['type']==2){$Madd='* ';}
			$out.= '
			 <tr >
				<td width="30">
					<input type="checkbox" name="mPer[]" value="'.$m_code.'" par="modL" '.$ch_ch.'/>
				</td>
				<td colspan="2">
					<div class="fl fs14x f1 pd10">'.$Madd.$d['title'].'</div>
				</td>
			</tr>';
		}
	}
}
echo $out;
?></table></form>
</div>
<div class="form_fot fr">
	<div class="bu bu_t3 fl" onclick="sub('favFo');"><?=k_save?></div>
	<div class="bu bu_t2 fr" onclick="win('close','#m_info5');"><?=k_close?></div>
</div>
</div>
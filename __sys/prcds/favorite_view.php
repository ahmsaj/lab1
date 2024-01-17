<? include("ajax_header.php");
if(isset($_POST['m_code'])){
	$menu_code=pp($_POST['m_code'],'s');?>
	<div class="win_body">
	<div class="form_header favMneuOrder" onclick="favMenuOrder()" style="margin-bottom:3px;"></div>
	<div class="form_body so " type="pd0"><? 
	$data_arr=array();
	$qq='';
	if($thisUser!='s'){
		$p_type=$_SESSION[$logTs.'grpt'];
		if($p_type==1){$g_code=$thisGrp;}
		if($p_type==2){$g_code=$thisUserCode;}
		$m_codes=get_vals('_perm','m_code',"g_code='$g_code' and type=$p_type ","','");
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
			$data_arr[$i]['title']=$r['name'];
			$data_arr[$i]['p_code']=$r['p_code'];
			$data_arr[$i]['section']=$sec;
			$data_arr[$i]['type']=$type;
			$data_arr[$i]['ch_ch']='off';
			if(in_array($m_code,$fav)){$data_arr[$i]['ch_ch']='on';}
			$i++;
		}
		echo '<table class="grad_s holdH" width="100%" cellpadding="4" cellspacing="0" type="static" Over="0">
		<tr>
			<th></th>
			<th><div class="fs16x f1 TC">'.k_module.'</div></th>
		</tr>';
	}
	$module_section=''; $out='';
	foreach($data_arr as $d){
		$mod_code=$d['mod_code']; $p_code=$d['p_code'];
		if($p_code=='0'){
			if($mod_code=='0'){
				$sub_m='';
				$p_code=$d['code'];
				foreach($data_arr as $sd){
					if($sd['p_code']==$p_code){
						$m_code=$sd['code'];
						$func="setFavMenu('$m_code')";
						$module_section=$sd['section']; 
						$ch_ch=$sd['ch_ch'];
						$sub_m.='<tr>
							<td></td>
							<td>
								<div ch_name="favorite_'.$sd['code'].'" class="form_checkBox fl cur " onclick="'.$func.'" >
									<div ch="'.$ch_ch.'"></div>
								</div>
								<div class="fl lh40 f1 fs12x">'.$Madd.get_key($sd['title']).' ( '.$module_section.' )</div>
							</td>
						</tr>';
					}
				}
				if($sub_m!=''){
					$out.= '<tr bgcolor="'.$clr44.'">
						<td></td>
						<td>
							<div class="fl fs14x f1 pd10">'.get_key($d['title']).'</div>
						</td>
				   </tr>'.$sub_m;
				}
			}else{
				$module_section=$d['section']; 
				$ch_ch=$d['ch_ch'];
				$Madd='';
				$m_code=$d['code']; 
				$func="setFavMenu('$m_code')";
				if($d['type']==2){$Madd='* ';}
				$out.= '
				 <tr bgcolor="'.$clr44.'">
					<td>
						<div ch_name="favorite_'.$m_code.'" class="form_checkBox fl cur" onclick="'.$func.'" >
							<div ch="'.$ch_ch.'"></div>
						</div>
					</td>
					<td>
						<div class="fl fs14x f1 pd10">'.$Madd.get_key($d['title']).' ( '.$module_section.' )</div>
					</td>
				</tr>';
			}
		}
	}
	echo $out;
	echo '</table>';?>
	</div>
	<div class="form_fot fr">
		<div class="bu bu_t2 fr" onclick="win('close','#m_info');$('#m_info').dialog( 'option', 'closeOnEscape', true);loadFavList();"><?=k_close?></div>
	</div>
	</div><?
}?>

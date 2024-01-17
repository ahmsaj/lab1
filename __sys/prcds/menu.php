<? include("ajax_header.php");
$out='';
$ser=pp($_POST['s'],'s');
$grptM=$_SESSION[$logTs.'grpt'];	
$grpM=$thisGrp;
$showPar=array();
if($grptM==2){$grpM=$thisUserCode;}
$q='and type!=3';
if($ser){
	$q=" and type in(1,2) and title_$lg like '%$ser%' ";
}
if($thisGrp=='s'){
	$sql="select * from _modules_list where act=1 $q order by ord ASC ";	
}else{
	$m_codes=get_vals('_perm','m_code',"type='$grptM' and  g_code='$grpM'");
	$m_codes=str_replace(',',"','",$m_codes);
	$sql="select * from _modules_list where act=1 $q and type!=3 and sys=0
	and (code IN('$m_codes') OR type=0)	order by ord ASC ";
	$showPar=get_vals('_perm','m_code'," p0=1 and type='$grptM' and  g_code='$grpM' ",'arr');
}
$res=mysql_q($sql);
$rows=mysql_n($res);
$data_arr=array();
$modsArr=array();
$mods1=$mods2='';
if($rows>0){		
	$i=0;
	while($r=mysql_f($res)){
		$data_arr[$i]=$r;			
		if($data_arr[$i]['mod_code']){
			if($data_arr[$i]['type']==1){if($mods1!=''){$mods1.=',';}$mods1.="'".$data_arr[$i]['mod_code']."'";}
			if($data_arr[$i]['type']==2){if($mods2!=''){$mods2.=',';}$mods2.="'".$data_arr[$i]['mod_code']."'";}
		}
		$i++;
	}
	if($mods1){		
		$sql="SELECT `code`,`module`,`icon` from _modules where code IN($mods1)";
		$res=mysql_q($sql);$rows=mysql_n($res);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$this_id=$r['code'];
				$modsArr[$this_id]['link']=$r['module'];				
				$modsArr[$this_id]['icon']=$r['icon'];
			}
		}			
	}
	if($mods2){
		$sql="SELECT code,module,icon from _modules_ where code IN($mods2)";
		$res=mysql_q($sql);
		$rows=mysql_n($res);			
		if($rows>0){
			while($r=mysql_f($res)){
				$this_id=$r['code'];
				$modsArr[$this_id]['link']=$r['module'];					
				$modsArr[$this_id]['icon']=$r['icon'];					
			}
		}			
	}
	$ms_txt='';
	if($ser!=''){
		foreach($data_arr as $data){
			$m_id=$data['id'];
			$m_code=$data['code'];
			$m_pearnt=$data['p_code'];
			$m_hide=$data['hide'];		
			$m_title=$data['title_'.$lg];
			$m_icon=$data['icon'];
			$m_mod_code=$data['mod_code'];
			if(!$m_icon){$m_icon=$modsArr[$m_mod_code]['icon'];}
			$act_class='';
			$actList=1;			
			$subClass='';			
			$m_type=$data['type'];
			$m_link=$modsArr[$m_mod_code]['link'];
			if($m_type==2){$m_link='_'.$m_link;}
			$perTxt='';
			if($m_pearnt){
				$perTxt=get_val_arr('_modules_list','title_'.$lg,$m_pearnt,'ml','code');
				$perTxt='<span class="f1 fs14 clr9">'.$perTxt.'</span> <ff class="fs20 clr9"> &raquo; </ff>';
				
			}
			if((!$m_hide && in_array($m_code,$showPar)) || $grpM=='s'){
				$out.='<a href="'.$f_path.$m_link.'">	
				<div class="menuList_row" '.$subClass.' '.$act_class.' id="'.$m_code.'">
				<div m_ic style="background-image:url('.$m_path.'im/menu/icon_m_'.$m_icon.'.png)" ></div>
				<div m_tx class="f1" fix="wp:52">'.$perTxt.hlight($ser,$m_title).'</div></div>
				</a>';
			}
			
		}
		$out.='<div class="sub_menu ofx so" >'.$ms_txt_all.'</div>';
	}else{
		foreach($data_arr as $data){
			$m_id=$data['id'];
			$m_code=$data['code'];
			$m_pearnt=$data['p_code'];
			$m_hide=$data['hide'];		
			$m_title=$data['title_'.$lg];
			$m_icon=$data['icon'];
			$m_mod_code=$data['mod_code'];
			if(!$m_icon){$m_icon=$modsArr[$m_mod_code]['icon'];}
			$act_class='';
			$actList=1;
			if(!$m_pearnt){
				$subClass='';			
				$m_type=$data['type'];
				if($m_code==$PER_ID){$act_class='m_act';}			
				if($m_type==0){
					$subClass='m_sub';
					$ms_txt='';
					foreach($data_arr as $data_s){
						$acts_class='';
						$ms_code=$data_s['code'];
						$ms_type=$data_s['type'];
						$ms_hide=$data_s['hide'];
						$ms_pearnt=$data_s['p_code'];
						if($ms_pearnt==$m_code){
							if($ms_code==$PER_ID){
								$acts_class='m_act';
								$act_class='m_act';
							}
							$ms_mod_code=$data_s['mod_code'];
							$ms_icon=$data_s['icon'];
							if(!$ms_icon){$ms_icon=$modsArr[$ms_mod_code]['icon'];}
							$ms_title=$data_s['title_'.$lg];
							$ms_link=$modsArr[$ms_mod_code]['link'];
							if($ms_type==2){$ms_link='_'.$ms_link;}
							if((!$ms_hide && in_array($ms_code,$showPar)) || $grpM=='s'){
								$ms_txt.='<a href="'.$f_path.$ms_link.'">
								<div class="menuList_row_s" '.$acts_class.'>
								<div m_ic style="background-image:url('.$m_path.'im/menu/icon_m_'.$ms_icon.'.png)" ></div>
								<div m_tx fix="wp:52">'.$ms_title.'</div>
								</div>
								</a>';
							}
						}
					}
					if($ms_txt){
						$ms_txt_all.='<div class="sub_menu_tab" id="tab_'.$m_code.'">'.$ms_txt.'</div>';
					}else{
						$actList=0;
					}
				}

				$m_link=$modsArr[$m_mod_code]['link'];
				if($m_type==2){$m_link='_'.$m_link;}				
				//if(!$m_hide && $actList){
				if((!$m_hide && in_array($m_code,$showPar))||($m_type==0 && $actList) || $grpM=='s' ){
					if($m_type!=0){$out.='<a href="'.$f_path.$m_link.'">';}		
					$out.='<div class="menuList_row" '.$subClass.' '.$act_class.' id="'.$m_code.'">
					<div m_ic style="background-image:url('.$m_path.'im/menu/icon_m_'.$m_icon.'.png)" ></div>
					<div m_tx class="f1" fix="wp:52">'.$m_title.'</div></div>';		
					if($m_type!=0){$out.='</a>';}
				}
			}
		}
		$out.='<div class="sub_menu ofx so" >'.$ms_txt_all.'</div>';
	}
}else{
	$out='<div class="f1 fs16 lh30 clrw TC">'.k_no_results.'</div>';
}
echo $out;

?>
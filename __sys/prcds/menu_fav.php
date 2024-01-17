<? include("../../__sys/prcds/ajax_header.php");
$out='';
$grptM=$_SESSION[$logTs.'grpt'];	
$grpM=$thisGrp;
$showPar=array();
if($grptM==2){$grpM=$thisUserCode;}

$fav=get_vals('_fav_list','m_code'," user_code='$thisUserCode'  ","','",1,"  order by ord ASC");
$favs=explode("','",$fav);
$showPar=get_vals('_perm','m_code'," p0=1 and type='$grptM' and  g_code='$grpM' ",'arr');
$sql="select * from _modules_list where act=1 and hide=0 and code IN('$fav') ORDER BY FIELD(code,'$fav') ";	
$res=mysql_q($sql);
$rows=mysql_n($res);
$data_arr=array();
$modsArr=array();
$mods1=$mods2='';
$hide=get_val_con('_modules_list','hide',"code='$PER_ID'");
if($hide==0){
	if(in_array($PER_ID,$favs)){
		$oprButt='<div class="fl thicF favDel"></div>
		<div class="fl f1 fs14 lh40 ">'.k_fav_remove.'</div>';
		$o=2;
	}else{
		if(count($favs)<_set_fltfu89tyr){
			$oprButt='<div class="fl thicF favAdd"></div>
			<div class="fl f1 fs14 lh40 ">'.k_fav_add.'</div>';
			$o=1;
		}
	}
}
if($oprButt){echo '<div class="favHopr" m="'.$PER_ID.'" o="'.$o.'">'.$oprButt.'</div><div class="cb"></div>';}
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
			$perTxt='<span class="f1 fs14 clr9" >'.$perTxt.'</span> <ff class="fs20 clr9"> &raquo; </ff>';

		}
		if((!$m_hide && in_array($m_code,$showPar)) || $thisGrp=='s'){		
			$out.='<a href="'.$f_path.$m_link.'">	
			<div class="menuList_row" '.$subClass.' '.$act_class.' id="'.$m_code.'">
			<div m_ic style="background-image:url('.$m_path.'im/menu/icon_m_'.$m_icon.'.png)" ></div>
			<div m_tx class="f1">'.$perTxt.hlight($ser,$m_title).'</div></div>
			</a>';
		}
	}
	$out.='<div class="sub_menu ofx so" >'.$ms_txt_all.'</div>';	
}else{
	$out='<div class="f1 fs16 lh30 clrw TC">'.k_no_results.'</div>';
}
echo $out;

?>
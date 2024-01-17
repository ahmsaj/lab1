<?
function lang_effect($opr,$table,$filed,$lang,$src='',$type=1){
	$type_Str=" VARCHAR( 255 )";
	if($type==7){$type_Str=" TEXT ";}
	
	if($opr=='add'){
		if(mysql_q("ALTER TABLE `$table` ADD `".$filed.$lang."` ".$type_Str." CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL")){
			if($src!=''){mysql_q("UPDATE `$table` set `".$filed.$lang."`=`".$filed.$src."` ");}
		}
	}	
	if($opr=='edit'){
		mysql_q("ALTER TABLE `$table` CHANGE  `".$filed.$src."` `".$filed.$lang."` ".$type_Str." CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
	}
	if($opr=='del'){
		mysql_q("ALTER TABLE `$table` DROP `".$filed.$lang."`");
	}
}
/***********************************************************/
function getColPrams($type,$id,$prams){
	global $TxtcolTypes;
	switch ($type){
		case 1:
			$ch='';
			$pars=explode('|',$prams);			
			$out='<select name="txt_'.$id.'">';
			foreach($TxtcolTypes as $key => $d){
				$sel='';if($key==$pars[0]){$sel=" selected ";}
				$out.='<option value="'.$key.'" '.$sel.'>'.$d[1].'</option>';
			}
			$out.='</select>';
			return $out;
			break;
		case 2:
			$ch='';			
			if($prams==1)$ch1=' selected ';
			if($prams==2)$ch2=' selected ';
            if($prams==3)$ch3=' selected ';
			return '
			<select name="date_'.$id.'">
			<option value="0"  selected>'.k_norm_date.'</option>
			<option value="1" '.$ch1.'>'.k_date_sec.'</option>
			<option value="2" '.$ch2.'>'.k_date_moment_auto.' </option>
            <option value="3" '.$ch3.'>'.k_date_moment_auto.' (Update)</option>
			</select>';
			break;
		case 3:
			$ch='';
			$sel='';
			$pars=explode('|',$prams);
			if($pars[0]==1){$ch=' checked ';}
			if($pars[1]==2){$sel=' selected ';}
			return '
			<select name="actType_'.$id.'">
			<option value="1"  selected>'.k_independent.'</option>
			<option value="2" '.$sel.'>'.k_linked.'</option>		
			</select><input type="checkbox" name="actShow_'.$id.'" value="1" '.$ch.'/><div class="fl f1 lh40">'.k_con_butt.'</div>';
			break;
		case 4:            
            if($prams==''){$prams='0';}
            $pramsTxt='';
            if($prams!=''){
				$pars=explode('|',$prams);
                $pramsTxt=k_one_photo.'|';
				$tags='';	
                if($pars[0]==1){$pramsTxt=k_many_photo.'|';}
                $pramsTxt.=$pars[1].'|'.$pars[2].'|'.$pars[3];
			}
            $out='<input type="hidden" name="photo_'.$id.'" id="photo_'.$id.'" value="'.$prams.'"/>
		<div class="f1 clr5 Over" onclick="photoSetting('.$id.')">'.k_edt_prp.'</div>
		<div id="photoSett_'.$id.'">'.$pramsTxt.'</div>';
			return $out;
			break;
		case 5:
			$p_table=$p_col=$p_view=$p_mod_link=$p_cond=$p_evens='';
			$data=json_decode($prams,true);
			if(is_array($data)){				
				$p_table=$data['table'];
				$p_col=$data['col'];
				$p_view=$data['view'];
				$p_c_view=$data['c_view'];
				$p_mod_link=$data['mod_link'];
				$p_cond=$data['cond'];
				$p_evens=$data['evens'];
			}
			$fullVal=($p_table.'|'.$p_col.'|'.$p_view.'|'.$p_c_view.'|'.$p_mod_link.'|'.$p_cond.'|'.$p_evens);
			$out='<input type="hidden" name="parent_'.$id.'" id="parent_'.$id.'" value="'.addslashes($fullVal).'"/>
			<div class="f1 clr5 Over" onclick="parlist('.$id.')">'.k_edt_prp.'</div>
			<div id="parent_t'.$id.'" dir="ltr">'.($fullVal).'</div>';
			
			return $out;			
			break;
		case 6:
			if($prams!=''){
				$pars=explode('|',$prams);
				$tags='';				
				foreach($pars as $p ){
					$tags.='<div>'.$p.'</div>';			
				}
			}
			$out='<input type="hidden" name="list_'.$id.'" id="list_'.$id.'" value="'.$prams.'"/>
			<div class="f1 clr5 Over" onclick="addTolist('.$id.')">'.k_edt_mnu.'</div>
			<div id="list_t'.$id.'">'.$tags.'</div>';
			
			return $out;
			break;
		case 8:
			$out='<select name="file_'.$id.'" ><option value="0">'.k_all_types.'</option>';
			$s='';if($prams==1)$s=' selected ';
			$out.='<option value="1" '.$s.' >'.k_documents.'</option>';
			$s='';if($prams==2)$s=' selected ';
			$out.='<option value="2" '.$s.'>'.k_compressed_files.'</option></select>';
			return $out;
			break;
		case 10:
			$pars=explode('|',$prams);
			$out='<table cellpadding="4"><tr>';		
			$out.='<td width="120"><div class="fl">'.k_pg_lk.'<br><input type="text" name="child_title_'.$id.'" value="'.$pars[0].'"/>
			</div></td>';
			$out.='<td width="120"><div class="fl">'.k_select_table.'<br>'.tablesList('child_table_'.$id,'coll_c_'.$id,$pars[1]).'</div></td>';
			$out.='<td width="120">'.k_val.'<br>
			<div class="fl" link="coll_c_'.$id.'" link_id="chi_val_'.$id.'">'.columeList($pars[1],$pars[2]).'</div></td>';				
		$out.='<td width="180"><div class="fl">'.k_lk_md.'<br>'.modulesList('chi_mod_'.$id,$pars[3]).'</div></td>';
		
			$out.='</tr></table>';
			$out.='<script>makeColumrName(\'coll_c_'.$id.'\')</script>';
			return $out;
			break;
		case 11:
			$pars=explode('|',$prams);
			$stc_type=$pars[0];
			$stc_type_arr=array('','User ID','GET ID','POST ID','GET','POST','Variable','Static Value');
			$out='<table cellpadding="4"><tr><td>'.k_type.'<br>
			<select name="static_'.$id.'" onchange="static_ch('.$id.',this.value)" >';
			$i=1;
			foreach($stc_type_arr as $sta){	
				if(count($stc_type_arr)>$i){			
					$s='';if($stc_type==$i)$s=' selected ';
					$out.='<option value="'.$i.'" '.$s.'>'.$stc_type_arr[$i].'</option>';
				}
				$i++;
			}			
			$out.='</select>';
            $class='';$stc_val='';
			if($stc_type<4 && $stc_type!=1){$class='hide';}else{$stc_val=$pars[1];}
            $out.='</td>
			<td id="show_sta_'.$id.'" class="'.$class.'">'.k_val.'<br><input type="text" name="static_val_'.$id.'" value="'.$stc_val.'"/></td>
			</tr></table>';
			return $out;
			break;
			case 14:			
			return k_val.' : <input style="width:100px" type="text" name="cus_val_'.$id.'" value="'.$prams.'" />';
			break;
			case 15:			
			return k_val.' : <input style="width:100px" type="text" name="cus_val_'.$id.'" value="'.$prams.'" />';
		break;
        case 12:
            $ch='';
            if($prams){$ch=' checked ';}						
			$out='<input type="checkbox" value="1" name="passType_'.$id.'" '.$ch.'/><div class="fl f1 lh40">فحص كلمة السر</div>';	
        return $out;
        break;
        case 14:			
			return k_val.' : <input style="width:100px" type="text" name="cus_val_'.$id.'" value="'.$prams.'" />';
        break;
        case 15:			
			return k_val.' : <input style="width:100px" type="text" name="cus_val_'.$id.'" value="'.$prams.'" />';
		break;
	}
}
function getColDefult($type,$id,$defult){
	if(in_array($type,array(1,7,13))){
		return '<input type="text" name="defult_'.$id.'" value="'.$defult.'" />';
	}
	if($type==3){
		if($defult)$ch=' checked ';
		return '<input type="checkbox" value="1" name="defult_'.$id.'" '.$ch.' /><div class="fl f1 lh40">'.k_active.'</div>';
	}
	if(in_array($type,array(5,6))){
		if($defult)$ch=' checked ';
		return '<input type="checkbox" value="1" name="defult_'.$id.'" '.$ch.' />
		<div class="fl f1 lh40">'.k_mt_vl.'</div>';
	}
}
function getColRequerd($type,$id,$requerd){	
	if(in_array($type,array(1,2,4,5,6,7,8,12,13))){ 
		if($requerd)$ch=' checked ';
		return '<input type="checkbox" name="req_'.$id.'"  '.$ch.' />';	
	}
}
function saveColPrams($type,$id){
	$res='';
	switch($type){
		case 1:$res= $_POST['txt_'.$id];break;
		case 2:$res= $_POST['date_'.$id];break;
		case 3:$sel=0;if(isset($_POST['actShow_'.$id])){$sel=1;}
		$actType=$_POST['actType_'.$id];
		return $sel.'|'.$actType;break;
		case 4:$res= $_POST['photo_'.$id];break;
		case 5:
			$parsArr=explode('|',$_POST['parent_'.$id]);
			$parsOut=[
				'table'=>$parsArr[0] ?? '',
				'col'=>$parsArr[1] ?? '',
				'view'=>$parsArr[2] ?? '',
				'c_view'=>$parsArr[3] ?? '',
				'mod_link'=>$parsArr[4] ?? '',
				'cond'=>$parsArr[5] ?? '',
				'evens'=>$parsArr[6] ?? '',
			];
			$res=json_encode($parsOut);
		break;
		case 6:$res= $_POST['list_'.$id];break;
		case 8:$res= $_POST['file_'.$id];break;
		case 10:$res= $_POST['child_title_'.$id].'|'.$_POST['child_table_'.$id].'|'.$_POST['chi_val_'.$id].'|'.$_POST['chi_mod_'.$id];break;
		case 11:$res= $_POST['static_'.$id].'|'.$_POST['static_val_'.$id];break;
		case 14:$res= $_POST['cus_val_'.$id];break;
		case 15:$res= $_POST['cus_val_'.$id];break;	
        case 12:
            $res=0;
            if(isset($_POST['passType_'.$id])){
                $res= 1;
            }
        break;	
            
	}
	return addslashes($res);
}
function getModItInput($id,$type,$prams){
	if($type==5){
		$out='<table cellpadding="4"><tr>';
		$out.='<td width="120"><div class="fl">'.k_select_table.'<br>'.tablesList('parent_table_'.$id,'coll_'.$id).'</div></td>';
		$out.='<td width="120">'.k_val.'<br>
		<div class="fl" link="coll_'.$id.'" link_id="par_val_'.$id.'"><input type="text" disabled required/></div></td>';
		$out.='<td width="120">'.k_menu.'<br>
		<div class="fl" link="coll_'.$id.'" link_id="par_txt_'.$id.'"><input type="text" disabled required/></div></td>';
		$out.='<td width="180"><div class="fl">'.k_lk_md.'<br>'.modulesList('par_mod_'.$id).'</div></td>';
		$out.='</tr></table>
		<div class="fl"><input type="text" name="par_con_'.$id.'" placeholder="'.k_condition.'"/></div>';
		
	}
	if($type==10){
		$out='<table cellpadding="4"><tr>';		
		$out.='<td width="120"><div class="fl">'.k_address.'<br><input type="text" name="child_title_'.$id.'" /></div></td>';
		$out.='<td width="120"><div class="fl">'.k_select_table.'<br>'.tablesList('child_table_'.$id,'coll_c_'.$id).'</div></td>';
		$out.='<td width="120">'.k_val.'<br>
		<div class="fl" link="coll_c_'.$id.'" link_id="chi_val_'.$id.'"><input type="text" disabled required/></div></td>';				
		$out.='<td width="180"><div class="fl">'.k_lk_md.'<br>'.modulesList('chi_mod_'.$id).'</div></td>';
		$out.='</tr></table>';
	}
	return $out;
}
function checkCoulmEx($table,$id){
	$ress = mysql_q("SHOW TABLES LIKE '$table'");
	if(mysql_n($ress)>0){
		$sql="show fields from `".$table."`";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		$fildes_arr=array();
		if($rows>0){				
			while($r=mysql_f($res)){	
				$filde=$r['Field'];
				array_push($fildes_arr,$filde);
			}
		}
		$o=1;
		$colums4Langs=array();
		foreach($fildes_arr as $filde){		
			$res=mysql_q("select count(*)c from _modules_items where mod_code='$id' and colum='$filde' ");
			$r=mysql_f($res);
			$c=$r['c'];
			if($c==0){
				$code=getRandString(10);		
				if($filde!='id'){
					$langStatus=ColLangChek($filde);
					if($langStatus=='x'){
						mysql_q("insert into _modules_items (`mod_code`,`colum`,`title`,`type`,`code`,ord) 
						values('$id','$filde','$filde','1','$code','$o')");
					}else{						
						if(!in_array($langStatus,$colums4Langs)){
							if(getTotalCO('_modules_items'," mod_code='$id' and `colum`='$langStatus'")==0){
								mysql_q("insert into _modules_items (`mod_code`,`colum`,`title`,`type`,`code`,ord,lang) 
								values('$id','$langStatus','$langStatus','1','$code','$o',1)");
							}
							array_push($colums4Langs,$langStatus);
						}
					}
				}
			}
			$o++;
		}
		$sql="select * from _modules_items where mod_code='$id' and type!=10 and type!=15";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){				
				$c_id=$r['id'];
				$colum=$r['colum'];
				$lang=$r['lang'];
				if(!in_array($colum,$fildes_arr)){
					$del=0;
					if($lang==0){
						$del=1;
					}else{$langStatus=ColLangChek2($fildes_arr,$colum);
						if($langStatus=='x'){$del=1;}
					}
					if($del==1){
						mysql_q("delete from _modules_items where id='$c_id'");
					}
				}
			}		
		}
		return 1;
	}else{
		return 0;
	}	
}
function getFilterInput($type,$id,$val){
	global $filterTypes,$filtTypeName;
	$out='';
	if($filterTypes[$type]!='0'){
		$out.='<select name="filter_'.$id.'" id="filter_'.$id.'"  style="width:100px;">
		<option value="0">'.k_sl_sr_tp.'</option>';
		$type=explode(',',$filterTypes[$type]);
		foreach($type as $t){
			$ch='';
			if($val==$t)$ch=" selected ";
			$out.='<option value="'.$t.'" '.$ch.' >'.$filtTypeName[$t].'</option>';
		}
		$out.='</select>';
	}
	return $out;
}
function modulesList($filed,$val=''){
	$out='';
	global $x_tables,$lg;
	$sql="select module, code,title_$lg from _modules order by module ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$out.='<select name="'.$filed.'" id="'.$filed.'" dir="ltr">';
	$out.='<option value="">-----------</option>';
	while($r=mysql_f($res)){			
		$code=$r['code'];
		$module=$r['module'];
		$title=$r['title_'.$lg];
		$s='';
		if($code==$val){$s=" selected ";}
		$out.='<option value="'.$code.'" '.$s.'>'.$module.'|'.get_key($title).'</option>';
	}
	$out.='</select>';
	return $out;
}
function tablesList($filed,$link='',$sel='',$filedName=''){
	$out='';
	global $x_tables;
	$sql="show tables";
	$res=mysql_q($sql);
	$tCount=mysql_n($res);
	$action='';
	if($filedName=='')$filedName=$filed;
	if($link!=''){$action='onChange="loadFileds(this.value,\''.$link.'\',\''.$filedName.'\')"';}
	//$out.='<select name="'.$filedName.'" id="'.$filed.'" '.$action.' required dir="ltr">';
    $out.='<input type="text" list="brow" value="'.$sel.'" name="'.$filedName.'" id="'.$filed.'" '.$action.' required dir="ltr">
    <datalist id="brow">';
	$out.='<option value="">-----------</option>';
	$clr='';
	$lastPC='';
	while($r=mysql_f($res)){	
		//list(,$table) = each($e);		
		$table=$r['Tables_in_'._database] ;
		$table_txt=$table;
		$PC=substr($table,0,3);
		if($PC!=$lastPC){$lastPC=$PC;$clr=genClr(200,240);}
		if(!in_array($table,$x_tables)){
			$s='';
			if($table==$sel){$s=" selected ";}
			//$out.='<option value="'.$table.'" style="background-color:rgb('.$clr.')" '.$s.'>'.tableName($table_txt).'</option>';
            $out.='<option value="'.$table.'" data-value="'.$table.'"  style="background-color:rgb('.$clr.')" '.$s.'></option>';
		}	
	}
	$out.='</datalist>';
    //$out.='</select>';
	return $out;
}
function tableName($str){
	$str=str_replace('_x_','--( X )--',$str);
	$str=str_replace('_m_','--(M)--',$str);	
	$str=strtoupper($str);
	return $str;
}
function genClr($s=0,$e=255){	
	$out=rand($s,$e).','.rand($s,$e).','.rand($s,$e);
	return $out;
}
function columeList($table,$sel='',$f='',$multi=''){
	if($table!=''){
		$out='';
        $multiTxt='';
        $selArr=explode(',',$sel);        
        if($multi){$multiTxt='multiple style="height:240px"';}
		$colums4Langs=array();
		$ch = mysql_q("SHOW TABLES LIKE '$table'");
		if(mysql_n($ch)){	
			$sql="show fields from `".$table."`";
			$res=mysql_q($sql);
			$tCount=mysql_n($res);
			$out.='<select name="'.$f.'" id="'.$f.'" class="so" required dir="ltr" '.$multiTxt.' >';
			while($r=mysql_f($res)){				
				$filde=$r['Field'];
				$filde_txt=$filde;
				
                $s='';
				if(in_array($filde,$selArr)){$s=" selected ";}
                
				$filde_txt=strtoupper($filde_txt);
				$langStatus=ColLangChek($filde);
                
				if($langStatus=='x'){
					$out.='<option value="'.$filde.'" '.$s.'>'.$filde_txt.'</option>';	
				}else{
					if(!in_array($langStatus,$colums4Langs)){
						if(in_array($langStatus,$selArr)){$s=" selected ";}
						$filde_txt=strtoupper(str_replace('_',' ',$langStatus));
						$out.='<option value="'.$langStatus.'" '.$s.'>'.$filde_txt.'</option>';	
						array_push($colums4Langs,$langStatus);
					}
				}				
			}
			$out.='</select>';
		}
		return $out;
	}
}
function getLinkData($code,$link){
	$out='';
	if($link==''){
		$out.='<div class="bu2 bu_t1 w-auto" onclick="mLinkWin(\''.$code.'\')">'.k_lk_pr.'</div>';
	}else{
		$l=explode('^',$link);
		$oprC=count($l);
		$ll=explode('|',$l[0]);
		$t=$ll[0];
		if($t==1){
			$d=$ll[1];
			list($tilte,$col)=get_val_c('_modules_items','title,colum',$d,'code');			
			$out.='<div class="clr5">'.k_lk_pr_fd.' <br>( '.$col.' | '.get_key($tilte).' )</div>';
			$out.='<div class="bu2 bu_t3" onclick="mLinkDel(\''.$code.'\',1)">'.k_dt_lk.'</div>';
		}
		if($t==2){
			$d=$ll[1];
			list($tilte,$col)=get_val_c('_modules_items','title,colum',$d,'code');
			$out.='<div class="clr1">'.k_lk_ch.' <br>( '.$col.' | '.get_key($tilte).' )</div>';
			if($oprC>1){
				$ll=explode('|',$l[1]);
				$d=$ll[1];
				list($tilte,$col)=get_val_c('_modules_items','title,colum',$d,'code');
				$out.='<div class="clr5">'.k_lk_pr_fd.' <br>( '.$col.' | '.get_key($tilte).' )</div>';
				$out.='<div class="bu2 bu_t3" onclick="mLinkDel(\''.$code.'\',1)">'.k_dt_lk.'</div>';
			}else{
				$out.='<div class="bu2 bu_t1" onclick="mLinkWin(\''.$code.'\')">'.k_lk_pr.'</div>';
			}
		}
	}
	return $out;
}
function ColLangChek($filde){
	global $lg_s_f;
	$out='x';
	$ch=explode('_',$filde);
	if($ch>2){		
		if(in_array(end($ch),$lg_s_f) || end($ch)=='(L)' ){
			$out=substr($filde,0,-3).'_(L)';
		}
	}
	return $out;	
}
function ColLangChek2($fildes_arr,$filde){
	$out=1;
	global $lg_s_fs;
	foreach($lg_s_fs as $l){
		$filde2=str_replace('_(L)','_'.$l,$filde);
		if(!in_array($filde2,$fildes_arr)){
			return 'x';
		}
	}
	return $out;	
}
/******************************************************/
function get_icon($opr,$filed='',$val=''){
	global $m_path;
	if($opr=='list' || $opr=='view'){
		if($val){return '<div class="ic40x icc1" style="background-image:url('.$m_path.'im/menu/icon_m_'.$val.'.png)"></div>';}
	}
	if($opr=='add' || $opr=='edit'){return selectIcon($val,$filed,1);}
}
function selectIcon($icon='',$filed='',$bd=0){
	global $m_path,$folderBack;
	$out='
	<div class="cb mod_ico so" id="'.$filed.'_in">
	<input type="hidden" name="'.$filed.'" id="'.$filed.'" value="'.$icon.'"/>';    
	$dir = $folderBack.'images/menu';
	$files = scandir($dir);
	foreach($files as $f){	
		if($f!='.' && $f!='..'){
			$f2=str_replace('icon_m_','',$f);
			$f2=str_replace('.png','',$f2);
			$sw='off';
			if($icon==$f2){$sw='on';}
			list($w,$h)=getimagesize($dir."/".$f);
			if($w==32 && $h==32 && substr($f,0,7)=='icon_m_'){
			$out.='<div class="fl sel_ico" onclick="selIcon(\''.$f2.'\',\''.$filed.'\')" sw="'.$sw.'" ico="'.$f2.'" style="background-image:url('.$m_path.'im/menu/'.$f.')"></div>';
			}
		}	
	}
	$out.='</div><div class="cb"></div>';
	return $out;
}
function selectAtt($filess,$filed,$bd=0){
	global $m_path;
	$out='';
	$valuess=explode(',',$filess);
	$ch_num=rand(10000,99999);
	$exFileRoot=array('.htaccess','index.php');
	$dir = str_repeat('../',$bd).'ajax';
	$files = scandir($dir);
	$out.='<div class="MultiBlc so fl" chM="'.$filed.'" n="'.$ch_num.'">
			<input type="hidden" name="'.$filed.'" id="mlt_'.$filed.'" value="'.$filess.'"  n="'.$ch_num.'" >';			
	foreach($files as $f){	
		if($f!='.' && $f!='..'){
			$ff=$dir.$f;
			$f2=str_replace('.php','',$f);			
			if(!in_array($f,$exFileRoot)){				
				$ch='off';

				if(in_array($f2,$valuess)){$ch='on';}
				$out.='<div class="cMul" v="'.$f2.'" ch="'.$ch.'" n="'.$ch_num.'" set>'.$f2.'</div>';
			}
		}	
	}
	$out.='</div>';	
	return $out;
}
function m_file($id,$type){
	$out='<div class="fr ic40 icc1 ic40_edit ic40Txt" onclick="mm_file('.$id.','.$type.')">'.k_edt_cod.'</div>';
	return $out;
}
function reset_ord($code){
	$sql="select id from _modules_items where mod_code='$code' order by ord ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$i=0;
	while($r=mysql_f($res)){
		$this_id=$r['id'];
		mysql_q("UPDATE _modules_items set ord='".($i+1)."' where id='$this_id'");
		$i++;
	}	
}
function mTools($id){
	$code=get_val('_modules','code',$id);
	$out='';
	list($ids,$events)=get_val('_modules','ids_set,events',$id);
	$out.='<div class="mToolIco">';	
		$total=0;$c='n';
		if($events!=''){$t1=explode('|',$events);$total=count($t1);$c='t';}
		
		$out.='<div class="mt0" onclick="modEvent(\''.$code.'\')" title="'.k_events.'" '.$c.'><div '.$c.'>'.$total.'</div></div>';
	
		$total=getTotalCO('_modules_links'," mod_code='$code' ");$c='n';if($total>0){$c='t';}
		$out.='<div class="mt1" onclick="modLinkes(\''.$code.'\')" title="'.k_links.'" '.$c.'><div '.$c.'>'.$total.'</div></div>';
		
		$total=getTotalCO('_modules_cons'," mod_code='$code' ");$c='n';if($total>0){$c='t';}
		$out.='<div class="mt2" onclick="modCons(\''.$code.'\')" title="'.k_conditions_program.'" '.$c.'><div '.$c.'>'.$total.'</div></div>';
		
		$total=getTotalCO('_modules_butts'," mod_code='$code' ");$c='n';if($total>0){$c='t';}
		$out.='<div class="mt3" onclick="addOnButts(\''.$code.'\')" title="'.k_ad_ta.'" '.$c.'><div '.$c.'>'.$total.'</div></div>';
		
		$out.=id_set($code,$ids);
		
		$total=0;
		$cols=get_val_con('_ex_col','cols'," mod_code='$code'");
		if($cols){$total=substr_count($cols,',')+1;}
		$c='n';if($total>0){$c='t';}
		$out.='<div class="mt6" onclick="exCol(\''.$code.'\')" title="'.k_ex_col.'" '.$c.'><div '.$c.'>'.$total.'</div></div>';
		
		$total=getTotalCO('_modules_items'," mod_code='$code'");$c='n';if($total>0){$c='t';}
		$out.='<div class="mt5" onclick="modItem(\''.$code.'\')" title="'.k_module_Items.'" '.$c.'><div '.$c.'>'.$total.'</div></div>';
		
		
		
	$out.='</div>';
	return $out;
	
}
function helpOpr($id,$opr,$filed,$val){
	$out='';
	if($opr=='list' || $opr=='view'){
		$total=getTotalCO('_help_videos'," h_code='$val'");$c='3';if($total>0){$c='2';}
		$out.='<div class="fr ic40 ic40_play mg10 ic40Txt icc'.$c.'" onclick="hlpListVids(\''.$val.'\')" '.$c.'>'.k_videos.'</div>';
		
		$total=getTotalCO('_help_details'," h_code='$val'");$c='3';if($total>0){$c='1';}
		$out.='<div class="fr ic40 ic40_info ic40Txt icc'.$c.'" onclick="hlpListTxt(\''.$val.'\')" >'.k_texts.'</div>';
		$out.='</div>';
	}
	if($opr=='add' || $opr=='edit'){
		if($val){$code=$val;}else{
			if($c==''){
				$code=getRandString(10);
			}else{
				$code=codeUnq($c);
			}
		}
		$out='<ff>'.$code.'</ff>
		<input type="hidden" name="'.$filed.'" value="'.$code.'"></input>';
	}
	return $out;
}
function id_set($id,$val){
	$out='';
	$fils=0;
	$c='n';
	if($val!=''){$fil=explode(',',$val);$fils=count($fil);$c='t';}
	$out.='<div class="mt4" onclick="idsWin(\''.$id.'\',\''.$val.'\')" title="'.k_fields.'" '.$c.'><div '.$c.'>'.$fils.'</div></div>';	
	return $out;
}
function mTables($id,$opr,$filed,$val){
	$out='';
	if($opr=='add' || $opr=='edit'){
		$out.=tablesList('this_table','tabale1',$val,$filed);
	}else{
		$out.=$val;		
	}
	return $out;
}
function mOrder($id,$opr,$filed,$val){
	$out='';
	if($opr=='add' || $opr=='edit'){
		$table=get_val('_modules','table',$id);
		$out.='<div link="tabale1" link_id="'.$filed.'" v>'.columeList($table,$val,$filed).'</div>';	
	}else{
		$out.=$val;		
	}
	return $out;	
}
function delMod($id,$t){
	if(is_array($id)){
		return script('nav(2,"'.k_md_ndt_bk.'")');
	}else{
		if($t==1){$table='_modules';}else{$table='_modules_';}
		return script('delMod("'.get_val($table,'code',$id).'",'.$t.')');
	}
}
function modGen($id,$type){
	$tab=array('','_modules','_modules_');
	$mod=get_val($tab[$type],'code',$id);
	moduleGen($type,$mod);
}
function moduleGen($type=1,$mod='',$o=0){
	global $folderBack,$m_path,$lg_s_f,$proTs,$encrMod;
	$backFolder=1;	
	$out='';
	$size=0;	
	$folder=$folderBack.'__mods';
	if(!file_exists($folder)){mkdir($folder,0777);}
	if($type==1){
		$q='';
		$data=array();
		if($mod){$q=" where code='$mod' ";}
		$sql="select * from _modules  $q ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){
			while($r=mysql_f($res)){
				unset($data);				
				$code=$r['code'];
				$module=$r['module'];
				$file=$folder.'/'.$code.'.php';
				$data['mod']['id']=$r['id'];
				$data['mod']['code']=$r['code'];
				$data['mod']['progs']=$r['progs'];
				$data['mod']['progs_used']=$r['progs_used'];
				$data['mod']['module']=$r['module'];
				foreach($lg_s_f as $l){$data['mod']['title_'.$l]=$r['title_'.$l];}
				$data['mod']['table']=$r['table'];
				$data['mod']['order']=$r['order'];
				$data['mod']['order_dir']=$r['order_dir'];				
				$data['mod']['rpp']=$r['rpp'];
				$data['mod']['opr_type']=$r['opr_type'];
				$data['mod']['opr_add']=$r['opr_add'];
				$data['mod']['add_page']=$r['add_page'];
				$data['mod']['opr_edit']=$r['opr_edit'];
				$data['mod']['edit_page']=$r['edit_page'];
				$data['mod']['opr_del']=$r['opr_del'];
				$data['mod']['opr_copy']=$r['opr_copy'];
				$data['mod']['opr_view']=$r['opr_view'];
				$data['mod']['opr_order']=$r['opr_order'];
				$data['mod']['opr_export']=$r['opr_export'];
				$data['mod']['opr_show_id']=$r['opr_show_id'];				
				$data['mod']['act']=$r['act'];
				$data['mod']['exFile']=$r['exFile'];				
				$data['mod']['ord']=$r['ord'];				
				$data['mod']['sys']=$r['sys'];
				$data['mod']['icon']=$r['icon'];
				$data['mod']['ids_set']=$r['ids_set'];
				$data['mod']['events']=$r['events'];
				$data['mod']['lk_tables']=$r['lk_tables'];
				/*******************************************/
				$sql_items="select * from _modules_items where mod_code='$code' order by ord ASC";
				$res_items=mysql_q($sql_items);
				$rows_items=mysql_n($res_items);
				if($rows_items){					
					while($r_items=mysql_f($res_items)){
						$item_code=$r_items['code'];
						$data['items'][$item_code]['id']=$r_items['id'];
						$data['items'][$item_code]['code']=$r_items['code'];
						$data['items'][$item_code]['mod_code']=$r_items['mod_code'];
						$data['items'][$item_code]['colum']=$r_items['colum'];
						$data['items'][$item_code]['title']=$r_items['title'];
						$data['items'][$item_code]['type']=$r_items['type'];
						$data['items'][$item_code]['validit']=$r_items['validit'];
						$data['items'][$item_code]['prams']=$r_items['prams'];
						$data['items'][$item_code]['show']=$r_items['show'];
						$data['items'][$item_code]['requerd']=$r_items['requerd'];
						$data['items'][$item_code]['ord']=$r_items['ord'];
						$data['items'][$item_code]['defult']=$r_items['defult'];
						$data['items'][$item_code]['lang']=$r_items['lang'];
						$data['items'][$item_code]['note']=$r_items['note'];
						$data['items'][$item_code]['filter']=$r_items['filter'];
						$data['items'][$item_code]['link']=$r_items['link'];
						$data['items'][$item_code]['act']=$r_items['act'];
					}
				}
				/*******************************************/
				$sql_butts="select * from _modules_butts where mod_code='$code'";
				$res_butts=mysql_q($sql_butts);
				$rows_butts=mysql_n($res_butts);
				if($rows_butts){
					$i=0;
					while($r_butts=mysql_f($res_butts)){
						$data['butts'][$i]['id']=$r_butts['id'];
						$data['butts'][$i]['mod_code']=$r_butts['mod_code'];
						$data['butts'][$i]['title']=$r_butts['title'];
						$data['butts'][$i]['function']=$r_butts['function'];
						$data['butts'][$i]['style']=$r_butts['style'];					
						$i++;
					}
				}
				/*******************************************/
				$sql_cons="select * from _modules_cons where mod_code='$code'";
				$res_cons=mysql_q($sql_cons);
				$rows_cons=mysql_n($res_cons);
				if($rows_cons){
					$i=0;
					while($r_cons=mysql_f($res_cons)){
						$data['cons'][$i]['id']=$r_cons['id'];
						$data['cons'][$i]['mod_code']=$r_cons['mod_code'];
						$data['cons'][$i]['colume']=$r_cons['colume'];
						$data['cons'][$i]['type']=$r_cons['type'];
						$data['cons'][$i]['val']=$r_cons['val'];						
						$i++;
					}
				}
				/*******************************************/
				$sql_links="select * from _modules_links where mod_code='$code'";
				$res_links=mysql_q($sql_links);
				$rows_links=mysql_n($res_links);
				if($rows_links){
					$i=0;
					while($r_links=mysql_f($res_links)){
						$data['links'][$i]['id']=$r_links['id'];
						$data['links'][$i]['mod_code']=$r_links['mod_code'];
						$data['links'][$i]['table']=$r_links['table'];
						$data['links'][$i]['colume']=$r_links['colume'];
						$data['links'][$i]['val']=$r_links['val'];
						$i++;
					}
				}
				/*******************************************/				
				$content=json_encode($data,JSON_UNESCAPED_UNICODE);
				if($encrMod){$content=Encode($content,$proTs);}
				$content='<? $mod_data[\''.$code.'\']=\''.$content.'\';?>';
				if(!file_exists($file)){fopen($file, "w");}								
				file_put_contents($file,$content);
				//fclose($file);
				if($o){
					$fileSize=filesize($file);
					$size+=$fileSize;
					$out.='<div dir="ltr" class="lh30 ff B fs14 b_bord">'.$module.' | '.$code.'.php'.' ('.getFileSize($fileSize).')<div>';
				}
			}
		}
	}
	if($type==2){
		$q='';
		$data=array();
		if($mod){$q=" where code='$mod' ";}
		$sql="select * from _modules_  $q ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){
			while($r=mysql_f($res)){
				unset($data);
				$code=$r['code'];
				$module=$r['module'];
				$file=$folder.'/'.$code.'.php';
				$data['mod']['id']=$r['id'];
				$data['mod']['code']=$r['code'];
				$data['mod']['progs']=$r['progs'];
				$data['mod']['progs_used']=$r['progs_used'];
				$data['mod']['module']=$r['module'];
				foreach($lg_s_f as $l){$data['mod']['title_'.$l]=$r['title_'.$l];}
				$data['mod']['file']=$r['file'];
				$data['mod']['exFile']=$r['exFile'];
				$data['mod']['icon']=$r['icon'];				
				$data['mod']['sys']=$r['sys'];
				$data['mod']['add']=$r['add'];
				$data['mod']['edit']=$r['edit'];
				$data['mod']['delete']=$r['delete'];
				$data['mod']['view']=$r['view'];
				$data['mod']['ord']=$r['ord'];
				$data['mod']['lk_tables']=$r['lk_tables'];
				/*******************************************/				
				$content=json_encode($data,JSON_UNESCAPED_UNICODE);
				if($encrMod){$content=Encode($content,$proTs);}					
				$content='<? $mod_data[\''.$code.'\']=\''.$content.'\';?>';
				if(!file_exists($file)){fopen($file, "w");}								
				file_put_contents($file,$content);
				if($o){
					$fileSize=filesize($file);
					$size+=$fileSize;
					$out.='<div dir="ltr" class="lh30 ff B fs14 b_bord">'.$module.' | '.$code.'.php'.' ('.getFileSize($fileSize).')<div>';
				}
			}
		}
	}
	if($type==3){		
		$data=array();		
		$sql="select * from _modules_list ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){
			$i=0;
			$file=$folder.'/_list.php';
			while($r=mysql_f($res)){
				$code=$r['code'];
				$module=$r['module'];				
				$data[$i]['id']=$r['id'];
				$data[$i]['code']=$r['code'];
				foreach($lg_s_f as $l){$data[$i]['title_'.$l]=$r['title_'.$l];}
				$data[$i]['sys']=$r['sys'];				
				$data[$i]['type']=$r['type'];
				$data[$i]['p_code']=$r['p_code'];
				$data[$i]['mod_code']=$r['mod_code'];				
				$data[$i]['icon']=$r['icon'];
				$data[$i]['ord']=$r['ord'];
				$data[$i]['act']=$r['act'];
				$data[$i]['hide']=$r['hide'];
				$i++;
			}
		}
		$content=json_encode($data,JSON_UNESCAPED_UNICODE);
		if($encrMod){$content=Encode($content,$proTs);}		
		$content='<? $mod_data[\'_list\']=\''.$content.'\';?>';
		if(!file_exists($file)){fopen($file, "w");}								
		file_put_contents($file,$content);
		if($o){
			$fileSize=filesize($file);
			$size+=$fileSize;
			$out.='<div dir="ltr" class="lh30 ff B fs14 b_bord">_list.php'.' ('.getFileSize($fileSize).')<div>';
		}
		/******************************************/
		$data=array();		
		$sql="select * from _modules_files ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){
			$i=0;
			$file=$folder.'/_file_m.php';
			while($r=mysql_f($res)){
				$code=$r['code'];							
				$data[$code]=$r['file'];
				$i++;
			}
		}
		$content=json_encode($data,JSON_UNESCAPED_UNICODE);
		if($encrMod){$content=Encode($content,$proTs);}		
		$content='<? $mod_data[\'_file_m\']=\''.$content.'\';?>';
		if(!file_exists($file)){fopen($file, "w");}								
		file_put_contents($file,$content);
		if($o){
			$fileSize=filesize($file);
			$size+=$fileSize;
			$out.='<div dir="ltr" class="lh30 ff B fs14 b_bord">_file_m.php'.' ('.getFileSize($fileSize).')<div>';
		}
		/******************************************/
		$data=array();		
		$sql="select * from _modules_files_pro ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){
			$i=0;
			$file=$folder.'/_file_a.php';
			while($r=mysql_f($res)){
				$code=$r['code'];							
				$data[$code]=$r['file'];
				$i++;
			}
		}
		$content=json_encode($data,JSON_UNESCAPED_UNICODE);
		if($encrMod){$content=Encode($content,$proTs);}		
		$content='<? $mod_data[\'_file_a\']=\''.$content.'\';?>';
		if(!file_exists($file)){fopen($file, "w");}								
		file_put_contents($file,$content);
		if($o){
			$fileSize=filesize($file);
			$size+=$fileSize;
			$out.='<div dir="ltr" class="lh30 ff B fs14 b_bord">_file_a.php'.' ('.getFileSize($fileSize).')<div>';
		}
	}
	/*********************************/
	$data=array();
	unset($data);	
	$file=$folder.'/_mod1.php';
	$sql="select * from _modules ";
	$res=mysql_q($sql);
	$rows2=mysql_n($res);
	if($rows2){
		$i=0;
		while($r=mysql_f($res)){
			$data[$i]['id']=$r['id'];
			$data[$i]['code']=$r['code'];
			$data[$i]['module']=$r['module'];
			$data[$i]['act']=$r['act'];			
			$i++;
		}
	}
	$content=json_encode($data,JSON_UNESCAPED_UNICODE);
	if($encrMod){$content=Encode($content,$proTs);}		
	$content='<? $mod_data[\'_mod1\']=\''.$content.'\';?>';
	if(!file_exists($file)){fopen($file, "w");}								
	file_put_contents($file,$content);	
	/*********************************/
	$data=array();
	unset($data);
	$file=$folder.'/_mod2.php';
	$sql="select * from _modules_ ";
	$res=mysql_q($sql);
	$rows3=mysql_n($res);
	if($rows3){
		$i=0;
		while($r=mysql_f($res)){
			$data[$i]['id']=$r['id'];
			$data[$i]['code']=$r['code'];
			$data[$i]['module']=$r['module'];
			$data[$i]['act']=$r['act'];
			$i++;
		}
	}
	$content=json_encode($data,JSON_UNESCAPED_UNICODE);
	if($encrMod){$content=Encode($content,$proTs);}		
	$content='<? $mod_data[\'_mod2\']=\''.$content.'\';?>';
	if(!file_exists($file)){fopen($file, "w");}								
	file_put_contents($file,$content);
	/*********************************/
	if($o){
		$out='<div dir="ltr" class="lh30 ff B fs14 uLine">'.$rows.' | ('.getFileSize($size).')<div>'.$out;
	}
	return $out;
}
/******library modules export-import********/
/*export*/
function exp_sq($table,$cond){
	$out=[];
	$sql="select * from $table where $cond";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			unset($r['id']);
			foreach($r as $k=>$v){
				$r[$k]=addslashes($v);
			}
			array_push($out,$r);
		}
	}
	return $out;
}
function exp_tables_copy($table,$saveData=0){
	$sql_data_c='';
	$sql_data_c.="create table if not exists `".$table."` (";
	$table_list =[];
	$fields_query = mysql_q("show fields from `".$table."`");
	$fil_rows=mysql_n($fields_query);
	$fr=0;
	while ($fields = mysql_f($fields_query)){
		if($fields['Extra']!='auto_increment'){$table_list[] = "`".$fields['Field']."`";}
		$sql_data_c.= "  `".$fields['Field']."` ".$fields['Type'];		
		if (strlen($fields['Default']) > 0) $sql_data_c.= " default '".$fields['Default']."' ";
		if ($fields['Null'] != 'YES') $sql_data_c.=" not null";
		if (isset($fields['Extra'])) $sql_data_c.=" ".$fields['Extra'];
		$fr++;
		if($fr!=$fil_rows){$sql_data_c.= ",";}			
	}
	// add the keys
	$index =[];
	$keys_query = mysql_q("show keys from `" . $table."`");
	while ($keys = mysql_f($keys_query)){	
		$kname = $keys['Key_name'];	
		if (!isset($index[$kname])){
			$index[$kname] = array('unique' => !$keys['Non_unique'],
			'fulltext' => ($keys['Index_type'] == 'FULLTEXT' ? '1' : '0'),
			'columns' => array());
		}	
		$index[$kname]['columns'][] = "`".$keys['Column_name']."`";
	}
	foreach($index as $info){
		$sql_data_c.= ",";		
		$columns = implode( ", ",$info['columns']);		
		if($kname == "PRIMARY"){
			$sql_data_c.= "  PRIMARY KEY (". $columns. ")";
		}elseif( $info['fulltext'] == '1' ) {
			$sql_data_c.= "  FULLTEXT `".$kname."` (".$columns.")";
		}elseif($info['unique']) {
			$sql_data_c.= "  UNIQUE (".$columns.")";	
		}else{
			$sql_data_c.= "  $kname KEY (".$columns.")";
		}				
	}		
	$sql_data_c.= ") ENGINE=MYISAM  ;|^-^|";
	// dump the data
    if($saveData){
        $rows_query = mysql_q("select ". implode(',',$table_list)." from `".$table."`");
        $rows_rows=mysql_n($rows_query);			
        if($rows_rows>0){	
            $qpp_counter=0;
            $qpp_all=0;				
            while($rows=mysql_f($rows_query)){                
                $r_rows=count($table_list);
                if($qpp_counter==0){			
                    $sql_data_c.= "insert into `".$table."` (".implode(',',$table_list).")values";		
                }else{
                    if($qpp_all<$rows_rows){
                        $sql_data_c.= ",";
                    }else{
                        $sql_data_c.= ";";
                    }
                }
                $sql_data_c.= "(";
                reset($table_list);
                $rr=0;
                while (list(,$i) = each($table_list)){
                    $i= str_replace('`', '',$i);		
                    if(!isset($rows[$i])){
                        $sql_data_c.= 'NULL ';
                    }elseif( trim($rows[$i]) != '' ){
                        $row = addslashes($rows[$i]);
                        $row = str_replace("\n#", "\n".'\#', $row);			
                        $sql_data_c.= "'".$row."'";
                    }else{
                        $sql_data_c.= "''";
                    }
                    $rr++;
                    if($rr!=$r_rows){$sql_data_c.= ",";}				
                }
                $sql_data_c.=")";			
                $qpp_counter++;
                // if($qpp_counter==$qpp){
                //     $qpp_counter=0;
                //     $sql_data_c.=";";
                // }
                $qpp_all++;
            }
            $sql_data_c.=";";
        }
    }
	return $sql_data_c;
}
/*import*/
function exp_fixTitleLang(&$titleLang,&$mod_info,$imp_langs,$sys_lang){
	//not shared
	foreach($sys_lang as $l){
		if(!in_array($l,$imp_langs)){
			$titleLang.=", `title_$l`";
			$mod_info["title_$l"]='';
		}
	}
	//shared
	foreach($imp_langs as $l){
		if(!in_array($l,$sys_lang)){
			unset($mod_info["title_$l"]);
		}else{
			$temp=$mod_info["title_$l"];
			unset($mod_info["title_$l"]);
			$mod_info["title_$l"]=$temp;
			$titleLang.=", `title_$l`";
		}
	}
}
/*****list archeive*********/
function getLists_mods($id,$opr,$filed,$val){
	$out=$cb='';
	if($opr=='add' || $opr=='edit'){
		$out.='
		<input name="'.$filed.'" id="list_'.$id.'" type="hidden"  value="'.$val.'"/>
		
			<div class="clr5 U f1 fs14 Over" onclick="addTolist('.$id.')">'.k_edt_mnu.' </div>
			<div id="list_t'.$id.'">';
			if($opr=='edit'){
				$vals=explode('|',$val);
				foreach($vals as $v){$out.='<div>'.$v.'</div>';}
			}
		$out.='</div>
	  	';
	}elseif($opr=='view'||$opr=='list'){
		$arr=explode('|',$val);
		$i=1;
		$out='<div>';
		foreach($arr as $v){
			$txt=explode(':',$v);
			$out.='<div class="cb" style="padding:5px;">
						<div class="fl fs12 lh20 f1 pd10 ">
						<ff14 pd10">'.SplitNo($txt[0]).'-</ff14>
						'.SplitNo($txt[1]).'</div>
					</div>';
			$i++;
		}
		$out.='</div>
		<script>$("tr td:nth-child(2)").attr("width",300);</script>';
	}
	return $out;
}
/*****indexing**************/
function index_getTables($id,$opr,$filed,$val){
	$out='';
	if($opr=='add' || $opr=='edit'){
		if($opr=='edit'){$out=tablesList($filed,'',$val);}
		else{$out=tablesList($filed);}
		$out.='<script>fix_view_index(1,"'.$filed.'",'.$id.')</script>';
	}elseif($opr=='list' || $opr=='view'){
		$pos='TC';
		if($opr=='view'){$pos='fl';}
		$out='<div class="'.$pos.'" dir="ltr">'.$val.'</div>';
	}
	return $out;
}
function index_getTable_cols($id,$opr,$filed,$val){
	if($opr=='add'){
		$view='';$hide=' hide ';
		if($opr=='edit'){
			$vals=explode('|',$val);
			$i=1;
			foreach($vals as $v){
				$temp=explode('-',$v);
				$col_name=$temp[0];
				$prefix_len=$temp[1];
				$lenV='';
				if($prefix_len&&$prefix_len!=''){$lenV=' ('+$prefix_len+')';}
				$view.='<div dir="ltr">'.$i.':'.$col_name.' ('.$lenV.')</div>';
				$i++;
			}
			$view=str_replace('()','',$view);
			$hide='';			
		}
		$out='<input type="hidden" name="'.$filed.'" required value="'.$val.'"/>
		<div id="sel_cols" class="'.$hide.' fs14 f1 clr5 U Over TC" onclick="index_tableCols()">'.k_edt_mnu.'</div>
		<div class="TC" id="index_cols">'.$view.'</div>';
		$out.='<script>fix_view_index(2,"'.$filed.'",'.$id.')</script>';
	}
	elseif($opr=='list' || $opr=='view'){
		$vals=explode('|',$val);
		$i=1;$view='';
		foreach($vals as $v){
			$temp=explode('-',$v);
			$col_name=$temp[0];
			$prefix_len=$temp[1];
			$lenV='';
			if($prefix_len&&$prefix_len!=''){$lenV=' ('+$prefix_len+')';}
			$view.='<div dir="ltr">'.$i.':'.$col_name.' ('.$lenV.')</div>';
			$i++;
		}
		$view=str_replace('()','',$view);
		if($opr=='view'){$pos='fl';}
		$out='<div class="'.$pos.'" dir="ltr">'.$view.'</div>';
	}
	$out.=Script("fix_view_index(3,'$filed',$id)");
	return $out;
}
function index_getTable_cols2($col,$status='add',$prefix_length=''){
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
}
function index_delete($id,&$err,$algo=0,$lock=0){
	$ok=1;
	global $index_type_logTxt,$index_type_phyTxt,$index_algoTxt,$index_lockTxt,$dbl;
	$r=getRec('_indexes',$id);
	if($r['r']){
		$name_prev=$r['name_prev'];
		$table=$r['table'];
		if(!$algo && !$lock){
			$algo=($v=$r['algorithm'])?'ALGORITHM='.$index_algoTxt[$v]:'';
			$lock=($v=$r['lock'])?'LOCK='.$index_lockTxt[$v]:'';
		}else{
			$algo='ALGORITHM='.$index_algoTxt[$algo];
			$lock='LOCK='.$index_lockTxt[$lock];
		}
		$sql="DROP INDEX $name_prev ON $table $algo $lock";
		if(!mysql_q($sql)){$ok=0;}
		$err=addslashes(mysqli_error($dbl));
		if($err){$err=$sql.'-!-'.$err;}
	}
	return $ok;
}
function index_create($id,$event_no){
	if($event_no==2){
		global $index_type_logTxt,$index_type_phyTxt,$index_algoTxt,$index_lockTxt,$dbl;
		$r=getRec('_indexes',$id);
		if($r['r']){
			$type_logic=($v=$r['type'])?$index_type_logTxt[$v]:'';
			$type_phy=($v=$r['type_phy'])?'USING '.$index_type_phyTxt[$v]:'';

			$name=$r['name'];
			$name_prev=$r['prev'];
			$table=$r['table'];

			$column=$r['column']; $cols='';
			if($column && $column!=''){
				$cols='`'.str_replace(['-','|'],['`(','), `'],$column).')';
				$cols=str_replace('()','',$cols);
			}

			$comment=($v=$r['comment'])?'COMMENT "'.$v.'"':'';
			//if($visible==0){$visible='VISIBLE';}elseif($visible==1){$visible='INVISIBLE';}
			$algorithm=($v=$r['algorithm'])?'ALGORITHM='.$index_algoTxt[$v]:'';
			$lock=($v=$r['lock'])?'LOCK='.$index_lockTxt[$v]:'';

			$ok=1;$err=0;
			
			$sql="CREATE $type_logic INDEX $name $type_phy ON $table ($cols) $comment $algorithm $lock";
			if(!mysql_q($sql)){$ok=0;}
			$err=addslashes(mysqli_error($dbl));
			if($err){
				$err=$sql.'-!-'.$err;
			}
			if(!mysql_q("update _indexes set name_prev=name where id='$id'")){$ok=0;}
			
			
			if($err){
				if($event_no==2){mysql_q("delete from _indexes where id='$id'");}
				$view="script:: <script>index_errors('$err');</script>";
				$ok.=' '.$view;
			}
			return $ok;

		}
	}
	elseif($event_no==1){
		return Script("$('div[name=cof_625bdfckjg]').attr('evn','index_type_review');");
	}
}
function modFilterMrg($mod){
	global $lg,$lg_s,$lg_n,$thisUser;
	$x_filter=array();		
	$sptf=$_POST['sptf'];
	if($sptf!='^'){
		$d1=explode('^',Decode($sptf,_pro_id));
		$d2=explode('|',$d1[1]);
		for($s=0;$s<count($d2);$s++){
			$d3=explode(':',$d2[$s]);
			array_push($x_filter,$d3[0]);
		}
	}	
	if($mod){
	$sendData='';
	$out='<div class="filterFormLM so" p="">';
	$out.='<div class="f1 lh40" txt>'.k_merged_data_show.'</div>
	<div>
	<div class="filBut fl" val="1" link="fil_lgm" style=" margin-'.k_Xalign.':6px;">'.k_yes.'</div>
	<div class="filBut fl" val="0" link="fil_lgm">'.k_no.'</div>
	<input type="hidden" id="fil_lgm" value=""/>
	</div>';
	$mod_data=loadModulData($mod);
	$show_id=$mod_data[14];
	$table=$mod_data[1];
	$cData=getColumesData($mod);	
	
	foreach($cData as $data){
		if(!in_array($data[1],$x_filter))	
		if($data[11]!=0){
			$sendData.=$data['c'].':'.$data[3].':'.$data[11].'|';	
			$prams=explode('|',$data[5]);	
			$fil=$data[11];
			if($fil){
				switch($fil){
				case 1:
					if($data[3]==1){
						$out.='<div class="f1 lh40" txt>'.get_key($data[2]).'</div>
						<div><input type="text" id="fil_'.$data['c'].'" /></div>';					
					}
					if($data[3]==2){
						if($data[5]==0){
						$out.='<div class="f1 lh40" txt>'.get_key($data[2]).'</div>
							<div><input type="text" class="fil_Date" id="fil_'.$data['c'].'" /></div>';
						}
					}
					if($data[3]==5){
						$p_tag=0;
						$s_tag=0;
						$p_tag_txt='';
						$s_tag_txt='';
						$p_tag_id='';
						$s_tag_id='';
						if($data[12]!=''){
							$l=explode('^',$data[12]);
							$oprC=count($l);
							if($oprC==1){
								$ll=explode('|',$l[0]);
								if($ll[0]==1){
									$p_tag=1;
									$p_tag_id=$ll[1];
								}else{
									$s_tag=1;
									$s_tag_id=$ll[3];
								}
							}else{
								$ll=explode('|',$l[0]);
								$lp=explode('|',$l[1]);								
								$p_tag=1;
								$p_tag_id=$lp[1];
								$s_tag=1;
								$s_tag_id=$ll[3];
							}
							if($s_tag){$s_tag_txt=' id="filSun_'.$s_tag_id.'" ';}
							if($p_tag){$p_tag_txt=' filPar="'.$p_tag_id.'" ';}
						}
						$Q=$prams[4];						
						$Q.=cekActColun($table,$Q);
						$Q=str_replace('[user]',$thisUser,$Q);
						$Q=readVarsInText($Q);						
						if($Q){$Q=" WHERE ".$Q;}
						$out.='<div class="f1 lh40" txt>'.get_key($data[2]).'</div>
						<div '.$s_tag_txt.' '.$p_tag_txt.'>'.make_Combo_box($prams[0],str_replace('(L)',$lg,
						$prams[2]),$prams[1],$Q,'fil_'.$data['c'],0).'</div>';
					}
					if($data[3]==6){
						$out.='<div class="f1 lh40" txt>'.get_key($data[2]).'</div>
						<div>'.selectFromArrayWithVal('fil_'.$data['c'],$prams).'</div>';					
					}
					if($data[3]==9){
						$out.='<div class="f1 lh40" txt>'.get_key($data[2]).'</div><div>';
						$out.='<select id="fil_'.$data['c'].'"><option></option>';
						for($l=0;$l<count($lg_s);$l++){$out.='<option value="'.$lg_s[$l].'">'.$lg_n[$l].'</option>';}
						$out.='</select></div>';					
					}				
				break;
				case 2:
					$out.='<div class="f1 lh40" txt>'.get_key($data[2]).'</div>
					<div><input type="text" id="fil_'.$data['c'].'" /></div>';
				break;
				case 3:
					$out.='
					<div class="f1 lh40" txt>'.get_key($data[2]).'</div>
					<div class="cb">
					<div class="fl" style="width:100px; margin-'.k_Xalign.':8px;">
						<div class="f1" txt>'.k_from.'</div>
						<div><input type="text" class="fil_Date" name="fil_'.$data['c'].'_1"/></div>				
					</div>
					<div class="fl" style="width:100px">
						<div class="f1" txt>'.k_to.'</div>
						<div><input type="text" class="fil_Date" name="fil_'.$data['c'].'_2"/></div>
					</div>
					</div><div class="cb"></div>				
					';
				break;
				case 4:
					if($data[3]==3 || $data[3]==4 || $data[3]==8){					
						$out.='<div class="f1 lh40" txt>'.get_key($data[2]).'</div>
						<div>
						<div class="filBut fl" val="1" link="fil_'.$data['c'].'" style=" margin-'.k_Xalign.':6px;">'.k_yes.'</div>
						<div class="filBut fl" val="0" link="fil_'.$data['c'].'">'.k_no.'</div>
						<input type="hidden" id="fil_'.$data['c'].'" value=""/>

						</div>';										
					}
					if($data[3]==11){
						if($data[5]==1){
							$out.='<div class="f1 lh40" txt>'.get_key($data[2]).'</div>							
							<div>'.make_Combo_box('_users','name_'.$lg,'id','','fil_'.$data['c'],0).'</div>';	
						}
					}
				break;
				}
			}
		}
	}
	$out.='</div><script>fil_pars="'.$sendData.'"</script>';
	}
	return $out;
}
/***reset library***/
function reset_ajax_file($files){
	$files="'".str_replace(',',"','",$files)."'";	
    $sql="select * from _modules_files_pro where code IN ($files)";
    $res=mysql_q($sql);
    while($r=mysql_f($res)){
        $file_name=$r['file'];
        $code=$r['code'];
        $prog=$r['prog'];
        if($prog!='sys' && $prog!='man'){
            $path='../../_'.$prog.'/prcds/'.$file_name.'.php';
            unlink($path);
            mysql_q("DELETE FROM `_modules_files_pro` WHERE code ='$code'");
        }
    }
}
function reset_mod_file($file){
    $r=getRecCon('_modules_files',"code='$file'");
    if($r['r']){
        $file_name=$r['file'];
        $prog=$r['prog'];
        $type=$r['type'];
        if($type==1){
            $path='../../_'.$prog.'/mods/'.$file_name.'.php';
            unlink($path);

            $sql="DELETE FROM `_modules_files` WHERE code='$file'";
            if(mysql_q($sql)){return 1;}
            return 0;
        }
    }
}
function reset_tables_delete($t){
    global $sysTableArr;
    $tables=explode(',',$t);
    foreach($tables as $table){
        if(!in_array($table,$sysTableArr)){
            mysql_q("Drop table $table");	    
        }
    }
    return 1;	
}
function reset_modules_delete($mod,$deleteTable=0){
    global $main_mods,$sysTableArr;
    if(!in_array($mod,$main_mods)){
        $r=getRecCon('_modules',"code='$mod'");
        if($r['r']){
            $table=$r['table'];
            mysql_q("DELETE FROM _modules where code='$mod'");
            mysql_q("DELETE FROM _modules_butts where mod_code='$mod'");
            mysql_q("DELETE FROM _modules_cons where mod_code='$mod'");
            mysql_q("DELETE FROM _modules_items where mod_code='$mod'");
            mysql_q("DELETE FROM _modules_links where mod_code='$mod'"); 
            if($deleteTable && !in_array($table,$sysTableArr)){                
                mysql_q("Drop table $table");
            }
            $sql="select * from _modules_list where type='1' and mod_code='$mod'";
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            if($rows>0){
                while($r=mysql_f($res)){
                    $mml_id=$r['code'];
                    mysql_q("DELETE FROM _modules_list where code='$mml_id' ");
                    mysql_q("DELETE FROM _perm where m_code='$mml_id' ");
                }
            }
            return 1;			
        }
        return 0;
    }
}
function reset_add_modules_delete($mod,$deleteFile=0){
    global $main_mods_add;
    if(!in_array($mod,$main_mods_add)){
        $r=getRecCon('_modules_',"code='$mod'");
        if($r['r']){
            $file=$r['file'];
            $progs=$r['progs'];
            mysql_q("DELETE FROM _modules_ where code='$mod'");
            $sql="select * from _modules_list where type='2' and  mod_code= '$mod'";
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            if($rows>0){
                while($r=mysql_f($res)){
                    $mml_id=$r['code'];
                    mysql_q("DELETE FROM _modules_list where code='$mml_id'");
                    mysql_q("DELETE FROM _perm where m_code='$mml_id'");
                }
            }
            if($deleteFile){reset_mod_file($file);}
            return 1;			
        }
    }
}
function reset_group_delete($groups){
	if(mysql_q("DELETE FROM _groups where code in ($groups) and code != 'tmbx9qnjx4' ")){
		mysql_q("DELETE FROM _users where grp_code in ($groups) and grp_code != 'tmbx9qnjx4'");
		mysql_q("DELETE FROM _perm where g_code in ($groups) and g_code != 'tmbx9qnjx4'");
		return 1;	
	}	
}
function reset_info_delete($info){
	if(mysql_q("DELETE FROM _information where code in ($info) and code != '7dvjz4qg9g'")){
		return 1;	
	}
}
function reset_settings_delete($settings){
    global $sysSittings;
    $xSettings="'".implode("','",$sysSittings)."'";
	if(mysql_q("DELETE FROM _settings where code in ($settings) and code NOT IN ($xSettings) and admin=1 ")){
		return 1;
	}
}
function reset_program_delete($pro){
	if($pro=='gnr'){
		reset_delTree('../../_'.$pro);
        genProgFiles($pro);
	}else{
		if(mysql_q("DELETE FROM _programs where code='$pro'")){
			reset_delTree('../../_'.$pro);
			return 1;	
		}
	}
	return 0;
}
function reset_delTree($dir){
    if(!file_exists($dir)){return true;}
    if(!is_dir($dir)){return unlink($dir);}
    foreach(scandir($dir) as $item){
        if($item !='.' && $item!='..'){
            if(!deleteDir($dir.DIRECTORY_SEPARATOR.$item)){return false;}
        }
    }
    return rmdir($dir);
}
function delHelp($id,$event){
	if($event==5){
		if(is_array($id)){
			$ides=implode(',',$id);
			$sql="select code from _help where id IN($ides) ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			$codes='';
			if($rows>0){				
				while($r=mysql_f($res)){
					$code=$r['code'];
					if($codes){$codes.=',';}
					$codes.=$code;
				}
			}			
			$_SESSION['delHelp']=$codes;			
		}else{
			$_SESSION['delHelp']=get_val('_help','code',$id);
		}		
	}
	if($event==6){
		$code=$_SESSION['delHelp'];
		$codes=explode(',',$code);
		foreach($codes as $code){
			mysql_q("DELETE from _help_details where h_code='$code'");
			mysql_q("DELETE from _help_videos where h_code='$code'");
		}		
	}
}
function getModFolder($prog){
    global $folderBack;
    $out='_'.$prog.'/';
    if($prog=='sys'){$out='__sys/';}
    if($prog=='spr'){$out='__super/';}
    if($prog=='man'){$out='__main/';}
    return $folderBack.$out;
}
function progList($id,$opr,$filed,$val){
    global $lg;
    if($opr=='add' || $opr=='edit'){
        $out='<select name="'.$filed.'">';
        $sql="select * from _programs order by name_$lg ASC";
		$res=mysql_q($sql);
        while($r=mysql_f($res)){
            $code=$r['code'];
            $name=$r['name_'.$lg];
            $sel='';if($code==$val){$sel=' selected';}
            $out.='<option value="'.$code.'" '.$sel.'>'.strtoupper($code).' | '.$name.'</option>';
        }
        
        $sel='';if('man'==$val){$sel=' selected';}
        $out.='<option value="man" '.$sel.'>--'.k_sys_man.'--</option>';
        $sel='';if('sys'==$val){$sel=' selected';}
        $out.='<option value="sys" '.$sel.'>--'.k_sys_pro.'--</option>';
        $sel='';if('spr'==$val){$sel=' selected';}
        $out.='<option value="spr" '.$sel.'>--'.k_super.'--</option>';
        $out.='</select>';
	}else{
        $out='<ff class="uc">'.$val.'</ff>';
    }
    return $out;
}
/****************API***********************/
function api_in($id){
	$c=getTotalCO('api_modules_items_in'," mod_id='$id' ");
	$t='n';
	if($c){$t='t';}
	return '<div class="child_link fl f1" onclick="apiInputsWin('.$id.')"><div '.$t.'>'.$c.'</div>'.k_inputs.'</div>';
}
function api_out($id){
	$c=getTotalCO('api_modules_items_out'," mod_id='$id' ");
	$t='n';
	if($c){$t='t';}
	return '<div class="child_link fl f1"  onclick="apiOutputsWin('.$id.')"><div '.$t.'>'.$c.'</div>'.k_outputs.'</div>';
}

function tabCols($id,$opr,$filed,$val){
	$m_id=$_SESSION['apim'];
	$out='';
	if($opr=='add' || $opr=='edit'){
		$table=get_val('api_module','table',$m_id);
		$out.='<div >'.columeList($table,$val,$filed).'</div>';	
	}else{
		$out.=$val;
	}
	return $out;
}
function cusColVal($id,$opr,$filed,$val,$t){
    global $lg;
	$v=$val;
	$out='';
	if($id){
		if($t==1){$type=get_val('api_modules_items_in','type',$id);}
		if($t==2){$type=get_val('api_modules_items_out','type',$id);}
	}	
	if($opr=='add' || $opr=='edit'){
		if($id){				
			if($type==1){
				$sel='';
				if($val==2){$sel="selected";}
				$v='<select name="'.$filed.'" t><option value="1">'.k_txt.'</option><option value="2" '.$sel.'>'.k_num.'</option></select>';
			}	
			if($type==2){
				if($val==2){$sel="selected";}
				$v='<select name="'.$filed.'" t >
					<option value="1">'.k_norm_date.'</option>
					<option value="2" '.$sel.'>'.k_date_sec.'</option>
				</select>';
			}
			if($type==3){
				$v='<input type="hidden" name="'.$filed.'" value="'.$val.'"/>';
			}
			if($type==4){
				$v='<input type="text" name="'.$filed.'" value="'.$val.'"/>';
			}
			if($type==5){
				$v='<input type="hidden" name="'.$filed.'" id="parent" value="'.$val.'"/>
				<div class="f1 clr5 Over TC" onclick="parlist_a()">'.k_edt_prp.'</div>
				<div class="TC" id="parent_t" dir="ltr">'.$val.'</div>';
			}
			if($type==6){
				$vTxt='';
				if($val){
					$vArr=explode('|',$val);
					foreach($vArr as $va){
						$vTxt.=$va.'<br>';
					}
				}
				$v='<input type="hidden" name="'.$filed.'" id="list" value="'.$val.'"/>
				<div class="f1 clr5 Over TC" onclick="addTolist_a()">'.k_edt_mnu.'</div>
				<div class="TC" id="list_t">'.$vTxt.'</div>';
			}
			if($type==7){
				$v='<input type="text" name="'.$filed.'" value="'.$val.'"/>';
			}
            if($type==8){				
                $v=make_Combo_box('api_module','title_'.$lg,'code',"where act=1 and part_internal=1 ",$filed,1,$val);
			}
		}
		$out.='<div id="apiSubtype">'.$v.'</div>'.script('setApiSelType(\''.$filed.'\');');
	}else{
		if($id){
			$out=$val;
			if($type==1){
				if($val==1){$out=k_txt;}
				if($val==2){$out=k_num;}
				$out='<div class="f1 fs14">'.$out.'</div>';
			}
			if($type==2){
				if($val==1){$out=k_norm_date;}
				if($val==2){$out=k_date_sec;}
				$out='<div class="f1 fs14">'.$out.'</div>';
			}	
			if($type==5 || $type==6 || $type==7){
				$out='<ff>'.$out.'</ff>';
			}
            if($type==8){
				$out=get_val_c('api_module','title_'.$lg,$val,'code');
			}
		}
	}
	return $out;
}
function get_subType_a($type,$val){
    global $lg;
	$out=$val;
	if($type==1){
		if($val==1){$out=k_txt;}
		if($val==2){$out=k_num;}
		$out='<div class="f1 fs14">'.$out.'</div>';
	}
	if($type==2){
		if($val==1){$out=k_norm_date;}
		if($val==2){$out=k_date_sec;}
		$out='<div class="f1 fs14">'.$out.'</div>';
	}	
	if($type==5 || $type==6 || $type==7){
		$out='<ff>'.$out.'</ff>';
	}
    if($type==8){
        $out=get_val_c('api_module','title_'.$lg,$val,'code');
    }
	return $out;
}
function mOrder2($id,$opr,$filed,$val,$att=''){
	$out='';
	if($opr=='add' || $opr=='edit'){
		$table=get_val('api_module','table',$id);
		$out.='<div link="tabale1" link_id="'.$filed.'" '.$att.'>'.columeList($table,$val,$filed).'</div>';	
	}else{
		$out.=$val;		
	}
	return $out;	
}
/************Backup************************/
function backUpTable($table,$cond='',$tab_contnet=1){
    global $_database;
    $data=[];
    //---------COLUMN-----------------
    $columns=[];
    $sql="show fields from `$table` ";
    $res=mysql_q($sql);
    while($r=mysql_f($res)){
        $data[$table]['columns'][$r['Field']]=[$r['Type'],$r['Default'],$r['Null'],$r['Extra']];       
    }
    $columns=$data[$table]['columns'];    
    $res=mysql_q("Select Column_name 'f', Character_set_name 's' FROM information_schema.columns where table_schema = '$_database' and table_name ='$table';");
    while($r=mysql_f($res)){
        array_push( $data[$table]['columns'][$r['f']],$r['s']);
    }
    //---------Keys--------------------
	$keys=[];
	$sql="show keys from `$table`";
	$res= mysql_q($sql);
	while($r=mysql_f($res)){         
		$kname = $r['Key_name'];	
		if (!isset($data[$table]['keys'][$kname])){
			$keys[$kname]['unique']=$r['Non_unique'];
			$keys[$kname]['Index_type']=$r['Index_type'];            
		}
		$keys[$kname]['columns'][]=$r['Column_name'];
	}
	$data[$table]['keys']=$keys;
	unset($keys);
    //---------DATA--------------------
	if($tab_contnet){
		$recs=[];
		$sql="SELECT * FROM $table $cond";
		$res=mysql_q($sql);
		$row=[];
		$rows=[];
		while($r=mysql_f($res)){
			foreach($columns as $k=>$c){
				$row[]=$r[$k];            
			}        
			$rows[]=$row;
			unset($row);
		}
		$data[$table]['rows']=$rows;
	}
    //---------------------------------	
	$res=mysql_q("SELECT `AUTO_INCREMENT`FROM  INFORMATION_SCHEMA.TABLES
	WHERE TABLE_SCHEMA = '$_database' AND TABLE_NAME = '$table';");
	$AI=mysql_f($res)['AUTO_INCREMENT'];
	$data[$table]['AI']=$AI;
	
    return $data;
} 
function loadMOdBackFiles(){
    $dir='../../__super_backup/';
    $files=glob($dir.'*');
    
    if(count($files)){
        echo '<div id="mwb" class="w100 fl ofx so" fix="h:200">';
        foreach($files as $file){            
            $file=explode('mira-',$file);            
            $type='Modules';
            if(substr($file[1],0,3)=='api'){$type='API';}
            $date=str_replace('.mwb','',$file[1]);            
            $dateTxt=$type.' | '.substr($date,4,4).'-'.substr($date,8,2).'-'.substr($date,10,2).' | '.substr($date,12,2).':'.substr($date,14,2).':'.substr($date,16,2);
            echo '<div   class=" fl mg5f" file="'.$file[1].'">
                <div class="f1 bord  TC cbg555 in w100" >
                <div class="fl ic30 ic30Txt icc1"  onclick="loadModBackup(\''.$file[1].'\',1)">تركيب</div>
                <div class="fl lh30 f1 pd20">يوجد نسخة احتياطية بتاريخ : <span class="f1 fs14 clr5" dir="ltr">'.$dateTxt.'</span></div>                
                <div class="fl ic30 ic30Txt icc2" onclick="loadModBackup(\''.$file[1].'\',2)">حذف</div>
                </div>
            </div>';
        //}
        }
        echo '</div>';
    }
}
//function backupRestor($table_data,$data,$type,$structure=1){
function backupRestor($table,$data,$opration,$type,$structure=1){	
	$AI=$data['AI'];
    $engine='MyISAM';
    $defCharset='utf8';
		//echo show_array($data);
	$start=$opration['start'];
	$end=$opration['end'];

	$rows=$data['rows'];
	$AI=$data['AI'];
	if(!$AI){$AI=0;}
	//echo show_array($rows);
	
	$columns=$data['columns'];
	//echo show_array($data);
	if($structure==1 && $type==1){
		mysql_q("drop table if exists `$table`;");	
		$columnsTxt='';
		foreach($columns as $kc=>$col){
			$type=$col[0];
			$default=$col[1];
			$null=$col[2];
			$extra=$col[3];
			$chSet=$col[4];
			$chSetTxt='';
			if($chSet && $chSet!=$defCharset){
				$chSetTxt=" CHARACTER SET $chSet ";
			}
			// echo '('.$default.')';
			$defTxt='';
			$nullTxt='';
			if($default!=''){
				$defTxt=" DEFAULT '$default' ";
			}else{
				$nullTxt='';
				if($null!='YES'){$nullTxt=" NOT NULL ";}else{$defTxt=" DEFAULT NULL ";}
			}                
			$columnsTxt.=" `$kc` $type $chSetTxt $defTxt $nullTxt ,";
		}
		$columnsTxt=substr($columnsTxt,0,-1);
		          
		$sql="CREATE TABLE IF NOT EXISTS `$table` ($columnsTxt) ENGINE=$engine  DEFAULT CHARSET=$defCharset AUTO_INCREMENT=$AI ;";
		$res=mysql_q($sql);
		if(!$res){echo '('.$sql.')';}
		$keys=$data['keys'];
		$keysQ='';
		foreach($keys as $kk=>$vk){                
			$col = '`'.implode('`,`',$vk['columns']).'`';
			if($kk=='PRIMARY'){
				$keysQ.=" ADD PRIMARY KEY ($col) ,";
			}else if($vk['Index_type']=='FULLTEXT'){
				$keysQ.=" ADD FULLTEXT KEY `$kk` ($col) ,";
			}else if($vk['unique']==0){
				$keysQ.=" ADD UNIQUE KEY `$kk` ($col) ,";
			}else{
				$keysQ.=" ADD KEY `$kk` ($col) ,";
			}
		}
		if($keysQ){
			$keysQ=substr($keysQ,0,-1);
			mysql_q("ALTER TABLE `$table` $keysQ ;");
		}
		if($table!='api__log'){
			mysql_q("ALTER TABLE `$table` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;");
		}
	}else{
		$column_id='id';
		if($table=='api__log'){
			$column_id='user';
		}	
		mysql_q("delete from $table where `$column_id` >=$start and `$column_id` <=$end ");
	}
	/**************************************/
	
	$cols = '`'.implode('`,`',array_keys($columns)).'`';	
	foreach($rows as $r){		
		$vals='';
		foreach($r as $k=>$rr){			
			//$rr=addslashes($rr);
			if($vals){$vals.=',';}
			if($rr===null){
				$vals.='NULL';		
			}else{
				$vals.="'".addcslashes($rr,"'\\")."'";
			}
		}
		//$vals = "'".implode("','",$r)."'";		
		$sql="INSERT INTO `$table` ($cols) VALUES ($vals) ";
		$res=mysql_q($sql);
		if(!$res){echo $sql;}
		unset($vals);
	}	
}
?>

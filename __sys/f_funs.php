<?
$MO_ID='';$MO_Type=0;$PER_ID='';$mod=0;
$thisUser=$_SESSION[$logTs.'user_id'];
$thisGrp=$_SESSION[$logTs.'grp_code'];
$thisUserCode=$_SESSION[$logTs.'user_code'];
$userSubType=get_val('_users','subgrp',$thisUser) ?? '0';

$userSubTypeCon=get_val('_users','subgrp',$thisUser) ?? ' 0 ) or ( 1=1 ';
// if($thisGrp=='s'){$userSubType='s';}

$logTime='12345';
$mod_data=array();
/********************************************************/
$bx_tables=array('_langs','_lang_keys','_modules','_modules_','_modules_butts','_modules_cons','_modules_files','_modules_files_pro','_modules_items','_modules_links','_modules_list','backup','_log','_log_his','_log_opr');
$x_tables=array('','','');
/*********************************************************/
$sender=senderPage();
function login(){
	global $PER_ID,$thisUser;
	$PER_ID=getModNow();	
	$log=false;
	if($thisUser=='s'){$log=true; }
	elseif(checkSess()){
		$log=true;
	}else{
	    
	}	
	if($thisUser!='s' && $log && user_active()){
		$ch=checkPer($PER_ID);
		if(!$ch[0]){$log=false;  }
	}
	if($log==false){        
        out(1);
    }
}
function loginAjax(){
	global $logTs,$PER_ID,$thisUser;	
	$a=str_replace('http://','',$_SERVER['HTTP_REFERER']);
	$a=str_replace('https://','',$a);
	$dom=explode('/',$a);		
	if($_SERVER['HTTP_HOST']!=$dom[0]){exit;}	
	$PER_ID=getModNowFrom();
	$log=false;
	if($thisUser=='s'){ $log=true; }
	elseif(checkSess()){ $log=true;}
	else{ $log=checkCookie();}	
	if($log && (user_active() || $thisUser=='s')){
		return true;
	}else{        
        out();
    }
}
function loginAddon(){
	global $thisUser;
	$l=explode('addons/',$_SERVER['PHP_SELF']);
	$l2=explode('/',$l[1]);
	$addon=$l2[0];	
	$sel=str_replace(',',"','",get_val_con('cln_x_addons_per','addons'," user='$thisUser' "));
	if($sel){
		$userAddons=get_vals('cln_m_addons','addon'," code IN('$sel')",'arr');
		if(!in_array($addon,$userAddons)){exit;}
	}else{
		exit;
	}
}
function checkSess(){
	global $logTs,$thisGrp,$thisUser;	
	if ($thisUser && $thisGrp && isset($_SESSION[$logTs.'grpt']) && $thisUser!=''){return true;} return false;
}
function checkCookie(){    
	global $proTs;
    if(isset($_COOKIE['sess'])){
        $str=$_COOKIE['sess'];
        $token=Decode($str,$proTs);
        $data=explode('|',$token);
        $ip=$data[0];
        $id=$data[1];
        if(count($data)==3){            
            if($ip==$_SERVER['REMOTE_ADDR']){
                $user=getRecCon("_users","id='$id' and act=1 ");
                if($user['r']){                                       
                    saveSessino($user);
                }
            }
        }
    }
}
function rememberMe($id){
    global $proTs;
    $token='';
    if(isset($_POST['keep_connected'])){
        $code=getRandString(128);
        $str=$_SERVER['REMOTE_ADDR'].'|'.$id.'|'.$code;    
        $token=Encode($str,$proTs);
        $time=30*60*60;
        setcookie('sess',$token,time()+$time,'/','',True,True);        
        //echo '('.$str.')<br>('.$token.')<br>';
    }
    $sql="UPDATE _users set token='$code' where id ='$token' limit 1";    
    mysql_q($sql);
}
function saveSessino($r){
    global $logTs;
    $grpt=1;
    $grp=$r['grp_code'];
    $user_id=$r['id'];
    $user_code=$r['code'];
    $lang=$r['lang'];
    $theme=$r['theme'];
    $x=getTotalCO('_perm'," type='2' and g_code='$user_code'");
    if($x>0){$grpt=2;}
    $_SESSION[$logTs.'user_id']=$user_id;
    $_SESSION[$logTs.'user_code']=$user_code;
    $_SESSION[$logTs.'grp_code']=$grp;
    $_SESSION[$logTs.'grpt']=$grpt;
    $_SESSION[$logTs.'theme']=$theme;            
    rememberMe($user_id);
    header("Location:");
}
function checkLang(){
	$lg='';
	$lang_ex=0;	
	$lg_s=array();
	$lg_n=array();	
	$lg_s_f=array();
	$lg_n_f=array();
	$lg_dir=array();    
	if(isset($_REQUEST['lg'])){$lg=$_REQUEST['lg'];}else{
		if(isset($_SESSION['lg'])){$lg=$_SESSION['lg'];}
	}
	$sql="SELECT * from `_langs` ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$lang_dir='ltr';
	while($r=mysql_f($res)){	
		$lang=$r['lang'];
		$lang_name=$r['lang_name'];
		$dir=$r['dir'];
		$def=$r['def'];
		$active=$r['active'];
		array_push($lg_s_f,$lang);
		array_push($lg_n_f,$lang_name);
		array_push($lg_n_f,$lang_name);
		$lg_dir[$lang]=$dir;
		if($active==1){
			array_push($lg_s,$lang);
			array_push($lg_n,$lang_name);			
			if($lg==$lang){
				$lang_de_name=$lang_name;
				$lang_dir=$dir;
				$lang_ex=1;
			}
			if($def==1){
				$de_lang_name=$lang_name;
				$de_lang=$lang;
				$de_dir=$dir;			
			}
		}else{
		
		}	
	}
	if($lang_ex==0){
		$lg=$de_lang;
		$lang_dir=$de_dir;
		$lang_de_name=$de_lang_name;
	}
	$_SESSION['lg']=$lg;
	$_SESSION['lg_n']=$lang_de_name;
	$_SESSION['lg_d']=$lang_dir;
    $lang_dirX='ltr';
    if($lang_dir=='ltr'){$lang_dirX='rtl';}
	return array($lg,$lang_dir,$lg_s,$lg_n,$lg_s_f,$lg_n_f,$lg_dir,$lang_dirX);
}
function user_active(){
	global $logTs,$thisUser;
	$res=mysql_q("select count(*)c from _users where id='$thisUser' and act=1 ");
	$r=mysql_f($res);
	return $r['c'];
}
function loc($URL=''){
	global $lg;	
	if($URL==''){
		$URL=_path.$lg.'/';
		$URL=$_SERVER['REQUEST_URI'];
	}
	echo "<script>document.location='".$URL."';</script>";
	exit;
}
function senderPage(){
	global $lg;
	if($lg){
		$l=explode($lg.'/',$_SERVER['HTTP_REFERER']);	
		$l2=explode('/',$l[1]);
		$SendFile=$l2[0];
	}else{		
		$l=explode('/',str_replace(_path,'',$_SERVER['HTTP_REFERER']));
		$SendFile=$l[0];
	}	
	$SendFile=$l[count($l)-1];
	return $SendFile;
}
function getModNow($mm='',$modType=1){
	global $MO_Type,$MO_ID,$MFF;
	$type=0;
	$m='p';
	$l=explode('/',$_SERVER['PHP_SELF']);	
	//$file=end($l);	
	if($mm==''){
		if(isset($_GET['m_id'])){$_SESSION['m_id']=$_GET['m_id'];}else{$_SESSION['m_id']='';}
		if(isset($_REQUEST['mod'])){
			if($MFF){
				$m2=MF_getModCode($_REQUEST['mod'],1);
			}else{
				$m2=get_val_c('_modules','code',$_REQUEST['mod'],'module');
			}
			$type=1;
		}
		if(isset($_REQUEST['mod2'])){
			if($MFF){
				$m2=MF_getModCode($_REQUEST['mod2'],2);
				
			}else{
				$m2=get_val_c('_modules_','code',$_REQUEST['mod2'],'module');
			}
			$type=2;
		}
	}else{
		$type=$modType;
		$m2=$mm;
	}
	$MO_ID=$m2;
	$MO_Type=$type;
	if($type){
		if($MFF){
			$m=MF_getListCode($m2);
		}else{
			$m=get_val_con('_modules_list','code', " type='$type' and mod_code='$m2' ");
		}
	}		
	return $m;
}
function getModNowFrom(){
	global $logTs,$lg,$thisGrp,$thisUser,$MO_Type,$MO_ID,$MFF;
	$SPU=0;	
	if($thisUser=='s' && $thisGrp=='s' && $_SESSION[$logTs.'grpt']=='s'){$SPU=1;}	
	$m=0;
	$type=0;
	if($lg){
		$l=explode('/'.$lg.'/',$_SERVER['HTTP_REFERER']);	
		$l2=explode('/',$l[1]);
		$l3=explode('.',$l2[0]);
		$SendFile=$l3[0];        
	}else{
		$l=explode('/',str_replace(_path,'',$_SERVER['HTTP_REFERER']));
		$SendFile=$l[0];
	}
	if(isset($_GET['m_id'])){$SendFile=$l[count($l)-1];}
	if($SendFile=='index.php' || $SendFile==''){$m='p';}	
	if(isset($_REQUEST['mod'])){$m2=$_REQUEST['mod'];$type=1;}
	if(isset($_POST['encData'])){$m2=getEncMod($_POST['encData']);$type=1;}
	if(isset($_REQUEST['mod2'])){$m2=$_REQUEST['mod2'];$type=2;}
	if($type){
		if($MFF){
			$m=MF_getListCode($m2);
		}else{
			$m=get_val_con('_modules_list','code', " type='$type' and mod_code='$m2' ");
		}
	}	
	if(!$m){        
		$l=explode('/',$_SERVER['PHP_SELF']);
		$file=end($l);
        $prog=getFolderProg($l[count($l)-3]);
        
		$file=str_replace('.php','',$file);	
		if($MFF){
			$fileCode=MF_getFileCode($file,'a');
		}else{
			list($fileCode,$need_per)=get_val_con('_modules_files_pro','code,need_per',"file='$file' and prog='$prog'"); 
		}
		
		$exFilesArr=array();		
		if(substr($SendFile,0,1)!='_'){
			if($MFF){
				$m2=MF_getListCode($SendFile,1);
				$exFile=MF_mod_data($m2,'exFile');
			}else{
				list($exFile,$m2)=get_val_c('_modules','exFile,code',$SendFile,'module');                
			}
			$type=1;
		}else{
			if($MFF){
				$m2=MF_getModCode(substr($SendFile,1),2);
				$exFile=MF_mod_data($m2,'exFile');
			}else{
				list($exFile,$m2)=get_val_c('_modules_','exFile,code',substr($SendFile,1),'module');                  
			}
			$type=2;			
		}        
		if($m2 || $SPU){
			if($exFile){$exFilesArr=explode(',',$exFile);}	            
			if($fileCode!='' && (in_array($fileCode,$exFilesArr) || $need_per==0 )){
				if($type){
					if($MFF){
						$m=MF_getListCode($m2);
					}else{
						$m=get_val_con('_modules_list','code'," type='$type' and mod_code='$m2' ");
					}
				}
			}else{
                if($SPU==0){out();}
            }
		}else{            
           out();
        }		
	}	
	$MO_ID=$m2;
	$MO_Type=$type;
	return $m;
}
function getEncMod($str){
	$encData=Decode($str,_pro_id);
	$data=explode('^*^',$encData);
	return $data[0];
}
function modPer($mod,$o=''){
	global $MFF;
	if($MFF){
		$list_code=MF_getListCode($mod);
	}else{
		$list_code=get_val_c('_modules_list','code',$mod,'mod_code');
	}
	return checkPer($list_code,$o);
}
function checkPer($m_code,$o=''){
	$out=array(0,0,0,0,0);
	global $logTs,$thisGrp,$thisUserCode;	
	if($m_code=='p'){$out[0]=$out[1]=$out[2]=$out[3]=$out[4]=1;}else{
		$grpt=$_SESSION[$logTs.'grpt'];
		if($grpt==1){$grp=$thisGrp;}
		if($grpt==2){$grp=$thisUserCode;}
		if($thisGrp=='s'){$out=array(1,1,1,1,1);}
		$sql="select * from _perm where type='$grpt' and g_code='$grp' and m_code='$m_code' ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$out[0]=$r['p0'];$out[1]=$r['p1'];$out[2]=$r['p2'];$out[3]=$r['p3'];$out[4]=$r['p4'];
		}		
	}
	if($o==''){
		$out['c']=$out[1]+$out[2]+$out[3]+$out[4];
		return $out;
	}else{
		return $out[$o];
	}
}
function proUsed($mod=''){
	global $MO_ID,$MO_Type,$PER_ID,$MFF;
	$MO_sel=$MO_ID;
	if($mod){$MO_sel=$mod;}
	$out=array();
	$out2=array();
	if($MO_sel && $MO_Type){
		if($MO_Type==1){$t='_modules';}
		if($MO_Type==2){$t='_modules_';}
		if($MFF){
			$pros=MF_mod_data($MO_sel,'progs_used');
		}else{            
			$pros=get_val_c($t,'progs_used',$MO_sel,'code');            
		}
		$prosArr=explode(',',$pros);
	}
	if($PER_ID==='p'){
		$pros=get_val_c('_settings','val','n1aghgszv','code');
		$prosArr=explode(',',$pros);
	}	
	
	$sql="select code from _programs where act=1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);			
	if($rows>0){
		while($r=mysql_f($res)){
			$code=$r['code'];
			if($prosArr){
				if(in_array($code,$prosArr)){
					array_push($out2,$code);
				}
			}
			array_push($out,$code);				
		}
	}
	
	return array($out,$out2);
}
function chProUsed($pro){
	global $proUsed;
	if(in_array($pro,$proUsed)){return 1;}
}
function out($c=''){
	global $logTs,$lg,$PER_ID;	
	unset($_SESSION[$logTs.'user_id']);
	unset($_SESSION[$logTs.'grp_code']); 
	unset($_SESSION[$logTs.'grpt']);
	if($c==1){
		$lnk='';
		if($PER_ID && $PER_ID!='' && $PER_ID!='p'){$lnk='-'.$PER_ID;}
		loc(_path.$lg.'/Login'.$lnk);
	}else{echo 'out';}
	exit;
}
function get_val($table,$name,$id,$order=''){
	$nName=explode(',',$name);	
	$cols='';
	if(count($nName)>1){foreach($nName as $n){if($cols!=''){$cols.=',';}$cols.='`'.$n.'`';}$out=array();
	}else{$cols='`'.$name.'`';}
	$ret="";
	$sql="select $cols from `$table` where id='$id' $order limit 1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		if(count($nName)>1){
			foreach($nName as $n){				
				array_push($out,$r[$n]);
			}
			return $out;
		}else{
			return  $ret=$r[$name];
		}
	}	
}
function get_vals($table,$col,$co='',$code=',',$unique=1,$order='',$limit=''){
	$nName=explode(',',$col);	
	$cols='';
	$itemOut=array();
	if(count($nName)>1){
		foreach($nName as $n){if($cols!=''){$cols.=',';}$cols.='`'.$n.'`';}
		$out=[];
	}else{
		$cols='`'.$col.'`'; $out='';
	}
	$ret="";
	if($co){$co=" where $co ";}
	$sql="select $cols from `$table` $co $order $limit";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$i=0;
		while($r=mysql_f($res)){				
			if(count($nName)>1){
				$s=0;
				foreach($nName as $n){
					if(!is_array($itemOut[$n])){$itemOut[$n]=array();}
					if(!in_array($r[$n],$itemOut[$n]) || $unique==0){
						array_push($itemOut[$n],$r[$n]);
					}
					$s++;
				}				
			}else{
				if(!in_array($r[$col],$itemOut) || $unique==0){
					array_push($itemOut,$r[$col]);
				}
			}
		}
		if(count($nName)>1){
			$s=0;
			foreach($nName as $n){
				if($code=='arr'){
					$out[$s]=$itemOut[$n];
				}else{
					$out[$s]=implode($code,$itemOut[$n]);
				}
				$s++;
			}				
		}else{
			if($code=='arr'){
				$out=$itemOut;
			}else{
				$out=implode($code,$itemOut);				
			}
		}
	}else{
		if($code=='arr'){
			$out=[];
		}
	}
	return $out;
}
function get_arr($table,$col_id,$col,$co='',$unique=1,$order=''){
	$out=array();
	$cols=explode(',',$col);
	$colTxt='`'.$col.'`';
	if(count($cols)>1){
		$colTxt='`'.str_replace(',','`,`',$col).'`';
	}
	if($co){$co=" where $co ";}
	$sql="select `$col_id`,$colTxt from `$table` $co $order ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){		
		while($r=mysql_f($res)){				
			$id=$r[$col_id];
			if(count($cols)>1){
				foreach($cols as $c){
					$val=$r[$c];
					$out[$id][$c]=$val;
				}
			}else{
				$val=$r[$col];
				$out[$id]=$val;
			}
		}
	}
	return $out;
}
function get_val_c($table,$name,$id,$id_filed,$order=''){
	$nName=explode(',',$name);	
	$cols='';
	if(count($nName)>1){foreach($nName as $n){if($cols!=''){$cols.=',';}$cols.='`'.$n.'`';}$out=array();
	}else{$cols='`'.$name.'`';}
	$ret="";
	$sql="select $cols from `$table` where `$id_filed`='$id' $order limit 1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		if(count($nName)>1){
			foreach($nName as $n){
				array_push($out,$r[$n]);
			}
			return $out;
		}else{
			return $ret=$r[$name];
		}
	}
}
function get_val_con($table,$name,$con,$order=''){
	$nName=explode(',',$name);	
	$cols='';
	if(count($nName)>1){foreach($nName as $n){if($cols!=''){$cols.=',';}$cols.='`'.$n.'`';}$out=array();
	}else{$cols='`'.$name.'`';}
	$ret="";
	$sql="select $cols from `$table` where $con $order limit 1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		if(count($nName)>1){
			foreach($nName as $n){
				array_push($out,$r[$n]);
			}
			return $out;
		}else{
			return $ret=$r[$name];
		}
	}
}
function get_val_arr($table,$col,$val,$arr,$id='id'){
	global ${'arr_'.$arr};
	if($val){
		if(!is_array(${'arr_'.$arr})){${'arr_'.$arr}=array();}
		if(!array_key_exists($val,${'arr_'.$arr})){${'arr_'.$arr}[$val]=get_val_c($table,$col,$val,$id);}
		return ${'arr_'.$arr}[$val];
	}
}
function get_data($table,$cond="",$select="",$order=""){
	$out=[];
	$out['total']=0;
	if($cond){$cond='where '.$cond; }
	if($order){$order='order by '.$order;}
	if(!$select){$select='*';}
	$sql="select $select from $table $cond $order";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows){
		$out['total']=$rows;
		while($r=mysql_f($res)){
			$out['rows'][]=$r;
		}
	}
	return $out;
}
function show_array($arr,$lev=0){
	$out='<div style="background-color:#eee;padding-left:10px;margin-bottom:5px;" dir="ltr">';
	if(is_array($arr)){
		foreach($arr as $k=>$v){
			$out.='<div style="padding-left:2px; border:1px #999 solid;margin-bottom:5px;">';
			if(is_array($v)){
				$out.='<div>'.$k.': ->'.show_array($v,$lev+1).'</div>';
			}else{
				$out.='<div>'.$k.': <span class="clr1">'.$v.'</span></div>';
			}
			$out.='</div>';
		}
	}
	$out.='</div>';
	return $out;
}
function getTableDate($table){
	$db=_database;
	$sql="SELECT            
	(DATA_LENGTH + INDEX_LENGTH) AS `size` ,TABLE_ROWS as `rows`
	FROM
	information_schema.TABLES
	WHERE
	TABLE_NAME='$table'
	and 
	TABLE_SCHEMA = '$db'
	ORDER BY
	(DATA_LENGTH + INDEX_LENGTH)
	DESC;
	";
	$res=mysql_q($sql);
	$r=mysql_f($res);
	return [$r['size'],$r['rows']];
}
function pp($val,$type='i',$lenght=0){
	global $dbl;
	switch($type){
		case 'i':$val=intval($val);break;//integer
		case 's':$val=mysqli_real_escape_string($dbl,$val);break;//string
		case 'f':$val=floatval($val);break;//float 
		//case 'd':$val=mysqli_real_escape_string($dbl,$val);break;//date 
		//case 'dt':$val=mysqli_real_escape_string($dbl,$val);break;//datetime 
        //$val=filter_var($val,FILTER_SANITIZE_INT);
	}
	return $val;
}
function mysql_q($q,$print=0){
	global $dbl,$now;	
	$q=fixSqlCondition($q);
	if($print){echo '
		---( '.$q.' )---
		'; }
	$s=microtime(true);
	$res=mysqli_query($dbl,$q);
	$e=microtime(true);
	$time=number_format($e-$s,3);	
	if($time>10){
		mysql_q("INSERT INTO _q_time (`qu`,`q_time`,`date`)values('$q','$time','$now')");
	}	
	return $res;
	/*if (!mysqli_query($link, "SET a=1")) {
    	printf("Errormessage: %s\n", mysqli_error($link));
	}*/
}
function fixSqlCondition($q){
	$q=str_replace("WHERE  WHERE",'WHERE',$q);
	$q=str_replace("WHERE WHERE",'WHERE',$q);
	$q=str_replace("WHERE  where",'WHERE',$q);
	$q=str_replace("WHERE where",'WHERE',$q);
	$q=str_replace("where  where",'WHERE',$q);
	$q=str_replace("WHERE  AND",'WHERE',$q);
	$q=str_replace("WHERE   AND",'WHERE',$q);
	$q=str_replace("WHERE   WHERE",'WHERE',$q);	
	
	return $q;
}
function mysql_n($res){return mysqli_num_rows($res);}
function mysql_f($res){return mysqli_fetch_assoc($res);}
function mysql_arr($res){return mysqli_fetch_array($res);}
function last_id(){
	global $dbl;
	return mysqli_insert_id($dbl);
}
function mysql_a(){
	global $dbl;
	return mysqli_affected_rows($dbl);
}
function getFolderProg($folder){
    $out=substr($folder,1);
    if($folder=='__sys'){$out='sys';}
    if($folder=='__super'){$out='spr';}
    if($folder=='__main'){$out='man';}
    return $out;
}
/***********************************/
$MF_mod=array();
function MF_getModFile($code){
	global $folderBack,$encrMod,$proTs,$mod_data,$MF_mod;    
	if(!isset($MF_mod[$code])){		
		include_once($folderBack.'__mods/'.$code.'.php');
		$obj=json_decode($mod_data[$code],true);
		if($encrMod){$obj=Decode($obj,$proTs);}
		$MF_mod[$code]=$obj;
	}else{
		$obj=$MF_mod[$code];
	}	
	return $obj;
}
function MF_getModCode($title,$type){	
	if($type==1){
		$obj=MF_getModFile('_mod1');
		$key = array_search($title, array_column($obj,'module'));
		$code=$obj[$key]['code'];
		if($code){return $code;}
	}
	if($type==2){
		$obj=MF_getModFile('_mod2');
		$key = array_search($title, array_column($obj,'module'));
		$code=$obj[$key]['code'];
		if($code){return $code;}	
	}
}
function MF_getListCode($code){	
	$obj=MF_getModFile('_list');
	$key = array_search($code,array_column($obj,'mod_code'));	
	$code=$obj[$key]['code'];
	if($code){return $code;}
}
function MF_getFileCode($file,$t){
	$obj=MF_getModFile('_file_'.$t);	
	$key = array_search($file,$obj);
	if($key){return $key;}
}
function MF_mod_data($code,$cal=''){	
	$obj=MF_getModFile($code);
	$out=$obj;
	if($cal){$out=$obj['mod'][$cal];}
	return $out;
}
?>
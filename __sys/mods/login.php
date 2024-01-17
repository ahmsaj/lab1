<? session_start();
include("../../__sys/dbc.php");
include("../../__sys/token.php");
include("../../__sys/mods/protected.php");
include("../../__sys/f_funs.php");
$lang_data=checkLang();
$lg=$lang_data[0];
$l_dir=$lang_data[1];
$lg_s=$lang_data[2];
$lg_n=$lang_data[3];
$lg_s_f=$lang_data[4];
$lg_n_f=$lang_data[5];
$lg_dir=$lang_data[6];
if($l_dir=="ltr"){define('k_align','left');	define('k_Xalign','right');}else{define('k_align','right');define('k_Xalign','left');}
include("../../__sys/cssSet.php");
include("../../__main/lang/lang_k_$lg.php");
include("../../__sys/lang/lang_k_$lg.php");
include("../../__sys/funs.php");
include("../../__sys/funs_co.php");
include("../../__sys/define.php");
include("../../__main/define.php");
$ProVer=$projectVersion;
$f_path=_path.$lg.'/';
$m_path=_path;?>
<!doctype html>
<html lang="<?=$lg?>" class="no-js">
<head><script>var f_path='<?=$f_path?>';</script>
<meta content='width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;' name='viewport' _token="<?=_token?>"/>
<meta charset="utf-8">
<title><?=_info_7dvjz4qg9g?></title>
<link href="<?=$m_path?>logCSS<?=$l_dir[0]?>M.css" rel="stylesheet" type="text/css" />
<? $fileName=$fileName='Lg'.$lg.'Mv'.$ProVer.'.js';?>
<script src="<?=$m_path.$fileName?>"></script>
<? $fileName=$fileName='Lg'.$lg.'Sv'.$ProVer.'.js';?>
<script src="<?=$m_path.$fileName?>"></script>
<script src="<?=$m_path?>library/jquery/jq3.6.js"></script>
<script src="<?=$m_path?>__sys/log.js"></script>
</head>
<body>
<div class="body">
<?  
//checkCookie();
//checkCookie();

$log=false;
$msg="";
$link=$f_path."Login";
if(isset($_REQUEST['out'])){// حالة المستخدم طلب تسجيل الخروج من اسفل الشاشة
    setcookie('sess',$token,time(),'/','',True,True);
    out(1);    
    $msg="Logged out";
}elseif(isset($_SESSION[$logTs.'user_id'])){
    $log=true; 
    $link=$f_path;
	ob_start();
	header("Location: $link");	
	echo "<script>document.location='".$link."'</script>";
	
}elseif($log=checkCookie()){
    $link=$f_path;
}
$link=trim($link);
$user="";
if($_SERVER['REQUEST_METHOD']=='POST'){ //حالة submit
	$user= pp($_POST['user'],'s');
	$pass= pp($_POST['pass'],'s');
	$pass= md5($pass);
    
	if(isset($_POST['PER_ID'])){
		$m_code=pp($_POST['PER_ID'],'s');
		if($m_code!=''){$link.='-'.$m_code;}
	}
	$sql="select * from `_users` where un='$user' and act=1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){    
		$r=mysql_f($res);        
        if(password_verify($pass,$r['pw'])){
            saveSessino($r);            
        }		
	}
    include("../../__super/log.php");
	if(!$log){
		unset($_SESSION['_token']);
        header("Location:Login-x");
		echo "<script>document.location='".$link."'</script>";
	}
}

if($_REQUEST['PER_ID']=='x'){
    $msg=k_ty_gn;
}
if($log){ //حالة هناك جلسة أو كوكي
	$link=$f_path;
	if(isset($_REQUEST['PER_ID'])){
		$m_code=pp($_REQUEST['PER_ID'],'s');
		$perms=checkPer($m_code);
		if(!empty($perms) && $perms[0]){
			$lnk='';
			$cond="code in (select mod_code from _modules_list where code='$m_code')";
			$mod=get_val_con('_modules','module',$cond);
			if(!$mod || $mod==''){
				$lnk.='_';
				$mod=get_val_con('_modules_','module',$cond);
			}
			$lnk.=$mod;
			if($mod && $mod!=''){$link.=$lnk;}
			
		}
	}
	//echo "<script>document.location='".$link."'</script>";
    header("Location:$link");
	echo "<script>document.location='".$link."'</script>";
}else{ //حالة تسجيل الدخول
	//في حال المستخدم والباسورد خطأ فيبقى الرابط نفسه ولا يعمل له refresh
	$action=$f_path.'Login';
	$dom=explode('/',$_SERVER['REQUEST_URI']);
	$parms=explode('-',$dom[3]);
	if(!empty($parms)){
		if(isset($parms[1])){
			$action.="-".$parms[1];
		}
	}
    //header("Location:Login-x");
    //echo "<script>document.location='".$link."'</script>";
?>

<div class="log ">
<div class="log_in fl cbg1111">
	<? if(_set_51yacfyygp){
		$image=getImages(_set_51yacfyygp);
		$id=$img['id'];
		$file=$image[0]['file'];
		$folder=$image[0]['folder'];
		$ex=$image[0]['ex'];
		list($w,$h)=getimagesize("../../sData/".$folder.$file);
		$fullfile=$m_path.'upi/'.$folder.$file;
		$image=resizeImage($file,"sData/".$folder,220,220,'logo25',$m_path.'imup/',0,'sData/resize/',$ex);
		if($w){
			$logoH=intval((300*$h/$w)+10);
		}
		$logoH=min(300,$logoH);
		if($image){?>
    		<div class="logo" style="background-image:url(<?=$image?>); height:<?=$logoH?>px"></div><?        
    	}
	}?>    
	<div class="title f1"><?=_info_7dvjz4qg9g?></div>	
    <form id="login" name="login" method="post" action="<?=$action?>">
        <input name="_token" value="<?=_token?>" type="hidden" />
        <div class="inp_div"><div class="i_u fl"></div>
            <div class="fl"><input name="user" type="text" class="log_text" id="user" value="" placeholder=
            "<?=k_user_name?> ..." autofocus required/></div>
        </div>
        <div class="inp_div">
            <div class="i_p fl"></div>
            <div class="fl"><input type="password" name="pass" id="pass" value="" class="log_text" placeholder=
            "<?=k_pwd?> ..." required /></div>
        </div> 
		<div class="pd10 fl" style="margin-top:10px;" >
			<input class="fl" style="margin-top:1px;" name="keep_connected" type="checkbox" d  />
			<div class="fl pd10 mg10 fs14 clr7 f1" id="keep_connected"><?=k_keep_log?></div>
		</div>
		<?
		if(isset($_REQUEST['PER_ID'])){
			$m_code=pp($_REQUEST['PER_ID'],'s');
			if($m_code!=''){?>
				<input type="hidden" name="PER_ID" value="<?=$m_code?>"/>
			<?}
		}?>
		
        <div class="logSubmit"><input type="submit" name="sub" id="sub"  class="f1" value="<?=k_enty?>" /></div>
		
    </form>
    <? if($msg){?><div class="logMas"><?=$msg?></div><? }?>&nbsp;
</div>
<div class="power">Powered by <a href="http://www.miraware.net" target="_blank">Miraware</a></div>
</div>

<? }?>
<script>

</script>
</div>
</body>
</html>
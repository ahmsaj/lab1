<? 
$def_title='';
$maxImageSize=9999999;
function alert($MSG){return "<script>alert('".$MSG."')</script>";}
function script($MSG){return "<script>".$MSG."</script>";}
function hlight($fil,$string){
	return str_ireplace($fil,'<t class="hl_s">'.$fil.'</t>',$string);
}
function getLangLink($lg2){
	global $lg;    
    if(isset($_GET['lg'])){
	   $l= str_replace('/'.$lg.'/','/'.$lg2.'/',$_SERVER['REQUEST_URI']);
    }else{
        $l=$_SERVER['REQUEST_URI'].$lg2.'/';
    }
	return $l;
}
function logHis(){
	global $now,$thisUser,$logTime;
	$outTime=$now-(intval($logTime/1000)+8);
    $outTimeW=$outTime-40;
	$chTime=(3600*3);
	//$sql="select s_in , s_out , user from _log where s_out < $outTime ";
    $sql="select s_in , s_out , user from _log group by user order by s_out ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$s_in=$r['s_in'];
			$s_out=$r['s_out'];
			$user=$r['user'];
            if($s_out<$outTimeW){
                $id=get_val_con('_log_his','id',"user ='$user' and `s_in`='$s_in'");
                if($id){
                    $sql="UPDATE _log_his SET s_out='$s_out' where id='$id'";
                }else{
                    $sql="INSERT INTO _log_his (`user`,`s_in`,`s_out`)values('$user','$s_in','$s_out')";
                }
                mysql_q($sql);
                //if($s_out-$s_in>($chTime)){requestCheck();}
            }
		}
	}
	mysql_q("UPDATE _log SET status=1 where s_out < $outTime ");
    mysql_q("delete from _log where s_out < $outTimeW ");
}
function lang_name($val){
	global $lg_s,$lg_n,$lg_s_f,$lg_n_f;
	for($i=0;$i<count($lg_s);$i++){if($val==$lg_s[$i]){$res=$lg_n[$i];}}
	return $res;
}
function make_Combo_box($table,$name,$val,$condtion,$filed,$req=0,$correntVal='',$script='',$text=''){
	if($table && $name){	
		$ret="";	
		$sql="select * from $table $condtion order by $name ASC limit 400";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		$q='';
		if($req){$q.=' required ';}
		$ret.='<select name="'.$filed.'" id="'.$filed.'" class="text_f" '.$q.' '.$script.'>';
		$ret.='<option value="">'.$text.'</option>';		
		if($rows>0){
			while($r=mysql_f($res)){
				$sel='';
				if($correntVal==$r[$val]){$sel=' selected ';}
				$ret.='<option value="'.$r[$val].'" '.$sel.'>'.get_key($r[$name]).'</option>';
			}	
		}
		$ret.='</select>';
		return $ret;
	}
}
function getRandString($length=5,$type=1){
	if($type==1){
		$ch='0123456789abcdefghijklmnopqrstuvwxyz';
	}else if($type==2){
		$ch='0123456789';
    }else if($type==3){
		$ch='abcdefghijklmnopqrstuvwxyz';
	}else{		
		$ch='0123456789abcdefghijklmnopqrstuvwxyz@#$%^&*';
	}
	$rand_name=''; 
	for($p=0;$p < $length;$p++){$rand_name.= $ch[mt_rand(0,strlen($ch)-1)];}
	return $rand_name;
}
function getFileExt($file){$e=explode('.',$file);$ex=strtolower(end($e));return $ex;}
function Croping($file,$path,$trg_w,$trg_h,$rename,$rw_path='',$backFolder=0,$ressixeDir='sData/resize/',$ex=''){
	global $maxImageSize,$m_path,$folderBack;
	$bf=$folderBack;
	$ressixeDir=$bf.$ressixeDir;
	if(!file_exists($ressixeDir)){mkdir($ressixeDir,0777);}
	$slid_x=0;
	$slid_y=0;
	if(file_exists($bf.$path.$file)){	
		if(!file_exists($ressixeDir.$rename.$trg_w.$trg_h.$file)){
			$type= explode(".",$file);
			if(count($type)==1){
				$ext='jpg';
				if($ex)$ext=$ex;
			}else{
				$ext=$type[count($type)-1];			
			}
			$fullFileName=$bf.$path.$file;
			$trans=0;
			list($org_w,$org_h)=getimagesize($fullFileName);
			if($org_w+$org_h<$maxImageSize && $org_w && $org_h){						
				if($ext == "jpeg" || $ext == "jpg" || $ext == "JPG"){
					$type=1;
					$new_img = imagecreatefromjpeg($fullFileName);
				}elseif($ext == "png" || $ext == "PNG"){
					$trans=1;
					$type=2;
					$new_img = imagecreatefrompng($fullFileName);
				}elseif($ext == "gif" || $ext == "GIF"){
					$new_img = imagecreatefromgif($fullFileName);
					$trans=1;
					$type=3;
				}else{
					return '';
				}	
				if($trg_w/$trg_h<$org_w/$org_h){
					$fin_h=$trg_h;
					$fin_w=intval(($org_w*$trg_h)/$org_h);
					$x1=($trg_w*$org_h)/($trg_h);					
					$slid_x=intval(($org_w-$x1)/2);
		
				}else{
					$fin_w=$trg_w;
					$fin_h=intval(($org_h*$trg_w)/$org_w);
					$y1=($trg_h*$org_w)/($trg_w);					
					$slid_y=intval(($org_h-$y1)/2);
				}			
				//Alert($www."|".$hhh);
				if (function_exists('imagecreatetruecolor')){
					$resized_img =  imagecreatetruecolor($trg_w,$trg_h);
				}else{
					echo "Error: Please make sure you have GD library ";
				}
				 if($trans == 1){
					 imagealphablending($resized_img, false);
					 imagesavealpha($resized_img,true);
					 $transparent = imagecolorallocatealpha($resized_img, 255, 255, 255, 127);
					 imagefilledrectangle($resized_img, 0, 0, $trg_w, $trg_h, $transparent);
				 }
				//-------------------------------
				imagecopyresampled($resized_img,$new_img,0,0,$slid_x,$slid_y,$fin_w,$fin_h,$org_w,$org_h);
				if($type==1){imagejpeg ($resized_img,$ressixeDir.$rename.$trg_w.$trg_h.$file,100);}
				if($type==2){imagepng ($resized_img,$ressixeDir.$rename.$trg_w.$trg_h.$file);}
				if($type==3){imagegif ($resized_img,$ressixeDir.$rename.$trg_w.$trg_h.$file);}				
				ImageDestroy ($resized_img);
				ImageDestroy ($new_img);
				return $rw_path.$rename.$trg_w.$trg_h.$file;
			}else{return false;
			}
		}else{return $rw_path.$rename.$trg_w.$trg_h.$file;}	
	}
}
function resizeImage($file,$path,$trg_w,$trg_h,$rename,$rw_path='',$backFolder=0,$ressixeDir='sData/resize/',$ex=''){
	global $maxImageSize,$m_path,$folderBack;
	$bf=$folderBack;
	$ressixeDir=$bf.$ressixeDir;
	if(!file_exists($ressixeDir)){mkdir($ressixeDir,0777);}
	$slid_x=0;
	$slid_y=0;
	if(file_exists($bf.$path.$file)){	
		if(!file_exists($ressixeDir.$rename.$trg_w.$trg_h.$file)){///---            
			$type= explode(".",$file);
			if(count($type)==1){
				$ext='jpg';
				if($ex)$ext=$ex;
			}else{
				$ext=$type[count($type)-1];			
			}            
			$fullFileName=$bf.$path.$file;
			$trans=0;
			list($org_w,$org_h)=getimagesize($fullFileName);
			if($org_w+$org_h<$maxImageSize && $org_w && $org_h){
				if($ext == "jpeg" || $ext == "jpg" || $ext == "JPG"){
					$type=1;
					$new_img = imagecreatefromjpeg($fullFileName);
				}elseif($ext == "png" || $ext == "PNG"){
					$trans=1;
					$type=2;
					$new_img = imagecreatefrompng($fullFileName);
				}elseif($ext == "gif" || $ext == "GIF"){
					$new_img = imagecreatefromgif($fullFileName);
					$trans=1;
					$type=3;					
				}else{
					return '';
				}				
				/****************************/				
				if($trg_w/$trg_h>$org_w/$org_h){
					$fin_h=$trg_h;
					$fin_w=round(($org_w*$trg_h)/$org_h);
				}
				if($trg_w/$trg_h<$org_w/$org_h){
					$fin_w=$trg_w;
					$fin_h=round(($org_h*$trg_w)/$org_w);
				}
				if($trg_w/$trg_h==$org_w/$org_h){
					$fin_h=$trg_h;
					$fin_w=$trg_w;
				}				
				/****************************/
				if (function_exists('imagecreatetruecolor')){
					$resized_img =  imagecreatetruecolor($fin_w,$fin_h);
				}else{
					echo "Error: Please make sure you have GD library ";
				}
				 if($trans == 1){
					 imagealphablending($resized_img, false);
					 imagesavealpha($resized_img,true);
					 $transparent = imagecolorallocatealpha($resized_img, 255, 255, 255, 127);
					 imagefilledrectangle($resized_img, 0, 0, $org_w, $trg_h, $transparent);
				 }
				//-------------------------------
				imagecopyresampled($resized_img,$new_img,0,0,0,0,$fin_w,$fin_h,$org_w,$org_h);
				//imagecopyresampled($resized_img,$new_img,0,0,$slid_x,$slid_y,$org_w,$org_h,$fin_w,$fin_h);
				if($type==1){imagejpeg ($resized_img,$ressixeDir.$rename.$trg_w.$trg_h.$file);}
				if($type==2){imagepng ($resized_img,$ressixeDir.$rename.$trg_w.$trg_h.$file);}
				if($type==3){imagegif ($resized_img,$ressixeDir.$rename.$trg_w.$trg_h.$file);}				
				ImageDestroy ($resized_img);
				ImageDestroy ($new_img);
				return $rw_path.$rename.$trg_w.$trg_h.$file;
			}else{return false;
			}
		}else{return $rw_path.$rename.$trg_w.$trg_h.$file;}		
	}
}
function inThisDay($d){
	global $ss_day,$ee_day;
	if($d>=$ss_day && $d <$ee_day){return 1;}
}
function timeAgo($d,$bb=' / ',$stetmentMax=2){	
	$str='';
	//$d=2640000;
	//if($d<60*60*24*30.5){$stetmentMax=1;}
	$cont=0;	
	if($cont<$stetmentMax){
		$thisD=60*60*24*365;
		$thisText=k_year;
		if($d>$thisD){
			$_d=intval($d/$thisD);if($_d>0){
				if($cont>0){$str.=$bb;}$str.=$_d.' '.$thisText.' ';$d=$d%$thisD;$cont++;
			}
		}
	}
	
	if($cont<$stetmentMax){
		$thisD=60*60*24*30.5;
		$thisText=k_month;
		if($d>$thisD){
			$_d=intval($d/$thisD);if($_d>0){
				if($cont>0){$str.=$bb;}$str.=$_d.' '.$thisText.' ';$d=$d%$thisD;$cont++;
			}
		}
	}

	if($cont<$stetmentMax){
		$thisD=60*60*24;
		$thisText=k_day;
		if($d>$thisD){
			$_d=intval($d/$thisD);if($_d>0){
				if($cont>0){$str.=$bb;}$str.=$_d.' '.$thisText.' ';$d=$d%$thisD;$cont++;
			}
		}
	}
	
	if($cont<$stetmentMax){
		$thisD=60*60;
		$thisText=k_hour;
		if($d>$thisD){
			$_d=intval($d/$thisD);if($_d>0){
				if($cont>0){$str.=$bb;}$str.=$_d.' '.$thisText.' ';$d=$d%$thisD;$cont++;
			}
		}
	}
	
	if($cont<$stetmentMax){
		$thisD=60;
		$thisText=k_minute;
		if($d>$thisD){
			$_d=intval($d/$thisD);if($_d>0){
				if($cont>0){$str.=$bb;}$str.=$_d.' '.$thisText.' ';$d=$d%$thisD;$cont++;
			}
		}
	}
	if($cont<$stetmentMax){
		if($d>0){if($cont>0){$str.=$bb;}$str.=$d.' '.k_sec.' ';}
	}	
	return $str;
}
function dateToTimeS($d,$items=2){    
	$c=0;
	$str='';
	$tt=$d;
	if($tt>60*60*24*365){
		$str.=" ".k_mor_year;		
	}else{
		if($tt>60*60*24){
			$str= intval($tt/60/60/24)." ".k_days;
			$tt2=$tt-(intval($tt/60/60/24)*(60*60*24));
			$c++;
		}else{
			$tt2=$tt;
		}
		if($tt2>60*60){
			if($c<$items){
				if($c>0){$str.=' - ';}
				$str.= intval($tt2/60/60)." ".k_hours;
				$tt3= $tt2-(intval($tt2/60/60)*(60*60));
				$c++;
			}
		}else{
			$tt3=$tt2;
		}
		if($tt3>60){
			if($c<$items){
				if($c>0){$str.=' - ';}
				$str.= intval($tt3/60)." ".k_min;
				$tt4= $tt3-(intval($tt3/60)*(60));
				$c++;
			}
		}else{
			$tt4=$tt3;
		}
		if($tt4>0){
			if($c<$items){
				if($c>0){$str.=' - ';}
				$str.=intval($tt4)." ".k_sec;
			}
		}
	}	
	return $str;
}
function dateToTimeS2($d,$showHour=1){
	$c=0;$str='';$tt=$d;
	if($tt>60*60*24){$str='<b>'.intval($tt/60/60/24)." | </b>";$tt2=$tt-(intval($tt/60/60/24)*(60*60*24));$c++;
	}else{$tt2=$tt;}
	if($tt2>=60*60){
        $str.= intval($tt2/60/60).":";
        $tt3= $tt2-(intval($tt2/60/60)*(60*60));
    }else{
        if($showHour){
            $str.='0:';
        }
        $tt3=$tt2;
    }
	if($tt3>=60){
        $min=intval($tt3/60);
        if($min<10){$str.='0';}
        $str.= $min.':';$tt4= $tt3-(intval($tt3/60)*(60));
	}else{
        $str.='00:';$tt4=$tt3;
    }
	if($tt4>0){
        $sec=intval($tt4);
        if($sec<10){
            $str.='0';
        }
        $str.=intval($tt4);
    }else{
        $str.='00';
    }
    return $str;
}
function clockStr($d,$mod=1){
	$h=intval($d/3600);
	$t='';
	if($mod==1){if($h==12){$t=' PM';} else if($h>12){$t=' PM';$h=$h-12;}else{$t=' AM';}}
	$m=intval(($d%3600)/60);
	if($m<10){$m='0'.$m;};
	if($d==0 && $mod==1){$h='12';$t=' AM';}
	return $h.':'.$m.$t;
}	
function viewRengTime($str){
	$x=explode('-',$str);
	$out='<div dir="ltr"><ff>'.clockStr($x[0]*3600).' - '.clockStr($x[1]*3600).'</ff></div>';
	return $out;
}

function dateToTimeS2_array($d){
	$str=array('d'=>0,'h'=>0,'d'=>0,'s'=>0,'x'=>0);
	$txt='';
	if($d<0){$d=$d*(-1);$str['x']=1;}	
	$c=0;$tt=$d;
	if($tt>60*60*24){$str['d']=intval($tt/60/60/24);$tt2=$tt-(intval($tt/60/60/24)*(60*60*24));$c++;}else{$tt2=$tt;}
	if($tt2>60*60){$str['h']= intval($tt2/60/60);$tt3= $tt2-(intval($tt2/60/60)*(60*60));}else{$tt3=$tt2;}
	if($tt3>60){$str['m']=intval($tt3/60);$tt4=$tt3-(intval($tt3/60)*(60));}else{$tt4=$tt3;}
	if($tt4>0){$str['s']=intval($tt4);}
	if($str['m']<10)$str['m']='0'.$str['m'];
	if($str['s']<10)$str['s']='0'.$str['s'];
	return $str;
}
function dateToTimeS3($d,$dateOnly=0){
	if($dateOnly==1){return  date('Y-m-d',$d);}
	else{return  date('Y-m-d A g:i:s ',$d);}
}
function getTotal($table,$fild='0',$val=''){
	if($fild=='0'){$sql="select count(*) C from `$table` ";}
	else{$sql="select count(*) C from `$table` where `$fild`='$val'";}	
	$res=mysql_q($sql);
	$r=mysql_f($res);
	return $r['C'];
}
function getTotalCO($table,$co=''){	
	if($table!=''){	
		if($co!=''){
			$co=' WHERE '.$co;			
			$co=fixSqlCondition($co);
		}
		$sql="select count(*) C from `$table` $co";
		$res=mysql_q($sql);
		$r=mysql_f($res);
		return intval($r['C']);
	}
}
function getMaxValOrder($table,$colum,$condtion=''){
	$sql="select max($colum) x from $table $condtion";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$ord=$r['x'];
		$ord++;
	}else{
		$ord=1;
	}
	return $ord;
}
function getMaxMin($type,$table,$colum='ord',$condtion=''){
	$sql="select $type($colum) x from $table $condtion";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$ord=$r['x'];		
	}else{
		$ord=1;
	}
	return $ord;
}
function convDate2Strep($d){
	$d=strtotime($d);
	$dd= date("U",$d);
	return $dd;
}
function getPageName_RW(){
	$l1=str_replace(_path,'',$_SERVER['REQUEST_URI']);
	$l=explode('/',$l1);
	return $l[1];
}
function sendMasseg($to,$subject,$message,$name){
	$from=_set_dwhl8ovtco;
	$message='<div dir="rtl">'.$message.'</div>';	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8"' . "\r\n";	
	$headers .= 'To: <'.$to.'>' . "\r\n";
	$headers .= 'From: '.$name.' <'.$from.'>' . "\r\n";
	if(mail($to, $name, $message, $headers)){
		return 1;
	}else{
		return 0;
	}
}
use PHPMailer\PHPMailer\PHPMailer;
function send_mail($email,$subject,$body){
	global $lg;
	$body=tempEmail($body);
	$name=get_val_c('_information_web','value_'.$lg,'0ory1dayyv','code');
	require_once "../../library/PHPMailer/PHPMailer.php";
	require_once "../../library/PHPMailer/SMTP.php";
	require_once "../../library/PHPMailer/Exception.php";
	$setts=get_arr('_settings_web','code','val');
	$from=$setts['0uy7q13fz0'];
	$host=$setts['qqv8prp2rx'];
	$acMail=$setts['iraar06gs8'];
	$pass=$setts['f5eokqsokb'];
	$port=$setts['u0s3lnppck'];
	$replay=$setts['8iq3kdxyeq'];
	$cert='ssl';
	if($setts['zmr43c5xyg']==2){$cert='tls';}
	$mail=new PHPMailer();
	//SMTP Settings
	$mail->isSMTP();
	$mail->Host = $host;
	$mail->SMTPAuth = true;
	$mail->Username =$acMail;
	$mail->Password =$pass;
	$mail->Port = $port;
	$mail->SMTPSecure =$cert;
	$mail->addReplyTo($replay,"Reply");	 
	$mail->CharSet='UTF-8';
	//Email Settings
	$mail->isHTML(true);
	$mail->setFrom($from, $name);
	$emails=explode(',',$email);
	foreach($emails as $email){
		$mail->addAddress($email);
	}
	$mail->Subject = $subject;
	$mail->Body = $body;
	//$headImg=viewImage($setts['n5d6ayi1l5'],1,600,200,'src');
	$mail->AddEmbeddedImage($headImg,'head');

	if($mail->send()){
		return array(1,'');
	}else{
		return array(0,$mail->ErrorInfo);
	}
}
function tempEmail($body){
	global $lg,$lg_dir;
	$head=get_val_c('_information_web','value_'.$lg,'icxetxxjf3','code');
	$foot=get_val_c('_information_web','value_'.$lg,'w3by3hzjx3','code');
	$out='
	<div dir="'.$lg_dir.'" style="width:642px;margin: 10px auto; background-color: #fff;">
		<div style="font-size:16px;line-height:40px; font-family:tahoma;color:#333;">
		'.nl2br($head).'</div>
		<table border="0" cellpadding="0" cellspacing="20" width="600" style="border:1px #ccc solid">		
		<tr><td>'.$body.'</td></tr>
		</table>
		<div style="font-size:12px;line-height:30px; font-family:tahoma;color:#888;">
		'.nl2br($foot).'</div>
	</div>';
	return $out;
}
function sendSMS($mobile,$message){
	global $thisUser;
	$mobile=fixNumber($mobile,'963');
	if($mobile){
		$smsLink=get_val_con('api_users','sms_link'," id ='$thisUser' ");
		$smsLink=str_replace('[n]',$mobile,$smsLink);
		$smsLink=str_replace('[m]',$message,$smsLink);
		$smsLink=str_replace(' ','%20',$smsLink);	
		$out=file_get_contents($smsLink);
	}
	return $out;
}
function fixNumber($n,$code=''){
    if($n){
        if(substr($n,0,2)!='00'){
            if(substr($n,0,1)=='0'){
                $n=substr($n,1);		
            }
            /*if(strlen($n)==12){
                $n=substr($n,3);
            }*/
            if(strlen($n)>8){
                $n=$code.$n;
            }else{
                $n='';
            }
        }
    }
    return $n;
}
function get_sum($table,$colum,$condition=''){
	$sum=0;
	$cName=explode(',',$colum);	
	$cols='';
	if(count($cName)>1){foreach($cName as $k =>$n){if($cols!=''){$cols.=',';}$cols.=' SUM('.$n.')s_'.$k;}$out=array();
	}else{$cols='SUM('.$colum.')s_0';}	
	if($condition!='')$condition=' where '.$condition;
	$q="select $cols from $table $condition ";	
	$res=mysql_q($q);
	$r=mysql_f($res);
	if(count($cName)>1){foreach($cName as $k=>$n){array_push($out,$r['s_'.$k]);}return $out;
	}else{return $sum=$r['s_0'];}
	return 0;
}
function get_avg($table,$colum,$condition=''){
	$sum=0;
	$cName=explode(',',$colum);	
	$cols='';
	if(count($cName)>1){foreach($cName as $k =>$n){if($cols!=''){$cols.=',';}$cols.=' AVG('.$n.')s_'.$k;}$out=array();
	}else{$cols='AVG('.$colum.')s_0';}	
	if($condition!='')$condition=' where '.$condition;
	$q="select $cols from $table $condition ";	
	$res=mysql_q($q);
	$r=mysql_f($res);
	if(count($cName)>1){foreach($cName as $k=>$n){array_push($out,$r['s_'.$k]);}return $out;
	}else{return $sum=$r['s_0'];}
	return 0;
}
function header_sec($title,$par=''){
	global $m_path;
	$out='	
	<header>
	<div class="top_txt_sec fl ">
		<div class="top_title fl f1">'.$title.'<span id="m_total"></span></div>
	</div>
	<div class="top_icons fr">';
	if($par!=''){
		$pars=explode('|',$par);
		for($i=0;$i<count($pars);$i++){
			$parss=explode(':',$pars[$i]);
			if($parss[0]=='ser'){
				$out.='<div class="top_icon ti_search fr" onclick="Open_co_filter(0)" title="'.k_search.'"></div>';
			}
			if($parss[0]=='add'){
				if(count($parss)>1){
					 $out.='<a href="'.$parss[1].'"><div class="top_icon ti_add fr" title="'.k_add.'"></div></a>';
				}else{
					 $out.='<div class="top_icon ti_add fr" onclick="win(\'open\',\'#add\')" title="'.k_add.'"></div>';
				}
			}			
			if($parss[0]=='back'){
				$out.='<a href="'.$parss[1].'"><div class="top_icon ti_back fr" title="'.k_back.'"></div></a>';
			}
			if($parss[0]=='save'){
				$out.='<div class="top_icon ti_save fr" onclick="'.$parss[1].'" title="'.k_save.'"></div>';
			}
			if($parss[0]=='link'){			
				$out.='<a href="'.$parss[3].'"><div class="top_icon '.$parss[2].' fr" title="'.$parss[1].'"></div></a>';
			}
			if($parss[0]=='action'){			
				$out.='<div class="top_icon '.$parss[2].' fr" onclick="'.$parss[3].'" title="'.$parss[1].'"></div>';
			}
			if($parss[0]=='Custom'){			
				$out.=$parss[1];
			}			
		}
	}	
	$out.='<div class="top_icon ti_del fr hide" onclick="delete_sel()" title="'.k_delete.'"></div>';	
	$out.='</div></header>';
	return $out;
}
function topIconCus($title,$class,$action,$add='',$in=''){
	if($action){$action='onclick="'.$action.'"';}
	$out='<div class="top_icon '.$class.'" '.$action.' title="'.$title.'" '.$add.' >'.$in.'</div>
	';
	return $out;
}
function convTolongNo($no,$c){
	$length=strlen($no);
	return str_repeat('0',$c-$length).$no;
}
function makeSwitch($cId,$id,$val,$t,$Mood=0){
	global $clr66,$clr55;
	$col='#ccc';
	$st=' margin-left:2px; ';
	if($val==1){
		$col='#2cbd2f';
		$st=' margin-left:16px; ';		
	}
	$out='';
	$id2=rand();
	if($Mood==1){if($val){$out.=k_yes;}else{$out.=k_no;}}else{
		$out.='<div id="s'.$id2.'" class="switch_butt" dir="ltr" t="'.$t.'" f="'.$cId.'" r="'.$id.'" v="'.$val.'" >
		<div style="background-color:'.$col.'; '.$st.'"></div>
		</div>';	
	}
	return $out;
}
function fromTime($Time){
	global $now;
	return dateToTimeS2($now-$Time);
}
function selectFromArray($filed,$array,$req=0,$start=0,$def_val='',$add=''){
	$out='';
	if(is_array($array)){
		$out.='<select name="'.$filed.'" id="'.$filed.'" '.$add.'>';
		if($req==0)$out.='<option value=""></option>';
		for($i=$start;$i<count($array);$i++){
			$sel='';
			if($def_val==$i){$sel='selected';}
			$out.='<option '.$sel.' value="'.$i.'">'.$array[$i].'</option>';
		}
		$out.='</select>';
	}
	return $out;
}
function selectFromArrayWithVal($filed,$array,$req=0,$start=0,$def_val='',$add=''){
	$out='';
	if(is_array($array)){		
		$out.='<select '.$add.' name="'.$filed.'" id="'.$filed.'">';
		if($req==0){$out.='<option value=""></option>';}
		for($i=$start;$i<count($array);$i++){
			$det=explode(":",$array[$i]);
			$val=$det[0];
			$txt=$det[1];
			$sel='';
			if($def_val==$val){$sel='selected';}
			$out.='<option '.$sel.' value="'.$val.'">'.get_key($txt).'</option>';
		}
		$out.='</select>';
	}
	return $out;
}
function selectFromArrayByKey($filed,$array,$req=0,$def_val='',$add=''){
	$out='';
	if(is_array($array)){		
		$out.='<select '.$add.' name="'.$filed.'" id="'.$filed.'">';
		if($req==0){$out.='<option value=""></option>';}
		foreach($array as $k=>$v){
			$det=explode(":",$array[$k]);
			$val=$det[0];
			$txt=$det[1];
			$sel='';
			if($def_val==$k){$sel='selected';}
			$out.='<option '.$sel.' value="'.$k.'">'.get_key($v).'</option>';
		}
		$out.='</select>';
	}
	return $out;
}
function upFile($filed='file',$vals='',$dir=1,$cb='',$req=0,$cls='fileUp',$text=''){
	global $m_path;
	$n=getRandString();
	$reqTxt='';
	if($req){$reqTxt='required';}
	if($vals=='0'){$vals='';}
	$out='
	<div class="upimageCon" no='.$filed.' cb="'.$cb.'">
	<input type="hidden" name="'.$filed.'" id="'.$filed.'" '.$reqTxt.' value="'.$vals.'" '.$reqTxt.'/>
	<form id="f_'.$filed.'" enctype="multipart/form-data" method="post">
	<div class="fl" list id="list_'.$filed.'">
   	<div class="imgUpHol fl '.$cls.'"><input type="file" name="f" id="fi_'.$filed.'" onchange="fileSelected(\''.$filed.'\');" accept="zip/*"  /> '.$text.'</div>';
	if($vals!=''){
		$files=getUpFiles($vals);
		foreach($files as $f){
			$id=$f['id'];
			$file=$f['file'];
			$folder=$f['folder'];
			$name=$f['name'];
			$ex=$f['ex'];
			$dir=getBackpathLevel();			
			$bp=str_repeat('../',$dir);
			$fullfile=$m_path.'sFile/'.$folder.$file;
			$out.='<div class="fl ff file_box" no="'.$id.'" group="'.$filed.'" title="'.$name.'" set="0">'.$ex.'</div>';
		}
	}
	$out.='
	</div>
	</form>
	<div class="cb"></div>
	<script>FileClick()</script>
	</div>';
	return $out;
}
function getThisDay($type,$val=0){
	$out=array(0,0);
	if($type=='day'){
		if($val==0){$m=date("m");$d=date("d");$y=date("Y");
		}else{$da=explode(',',$val);$d=$da[0];$m=$da[1];$y=$da[2];}
		$d1 = mktime(0,0,0,$m,$d,$y);
		$d2 = mktime(0,0,0,$m,$d+1,$y);
	}
	if($type=='month'){
		if($val==0){$m=date("m");$y=date("Y");}else{$da=explode(',',$val);$m=$da[0];$y=$da[1];}
		$d1 = mktime(0,0,0,$m,1,$y);
		$d2 = mktime(0,0,0,$m+1,1,$y);
	}
	if($type=='year'){
		if($val==0){$y=date("Y");}else{$y=$val;}
		$d1 = mktime(0,0,0,1,1,$y);
		$d2 = mktime(0,0,0,1,1,$y+1);
	}
	if($type=='all'){
		$d1 = 0;
		$d2 = date('U');
	}
	$out[0]=date('U',$d1);
	$out[1]=date('U',$d2);
	return $out;
}
function getFileSize($s,$d=1){
	if($s>0){
		$size=0;
		$sizeLatter='';
		if($s<1024){$size=number_format($s);$sizeLatter='Bit';}
		else if($s<(1024*1024)){$size=number_format(($s/1024),1);$sizeLatter='KB';}
		else if($s<(1024*1024*1024)){$size=number_format(($s/(1024*1024)),$d);$sizeLatter='MB';}
		else if($s<(1024*1024*1024*1024)){$size=number_format(($s/(1024*1024*1024)),$d);$sizeLatter='GB';}
		else{$size=number_format(($s/(1024*1024*1024*1024)),$d);$sizeLatter='TB';}
		return $size.' '.$sizeLatter;
	}else{return '-';}
}
function limitString($str,$n,$k=0){
	$new_str='';
	$stop=0;
	if(is_array($str)){
		return $str;
	}
	if($k==1){// حساب الاحراف
		if($n<strlen($str)){$new_str=substr($str,0,$n);$stop=1;}else{$new_str=$str;}	
	}else{// حساب الكلمات		
		$words=explode(' ',$str);
		foreach($words as $word){$k=strlen($new_str.' '.$word);
			if($k<=$n){$new_str.=' '.$word;}else{$stop=1;}
		}
	}
	if($stop){$new_str='<span title="'.$str.'">'.$new_str.' ...</span>';}
	return $new_str;
}
function viewPhotos_i($ids,$dir=0,$w=60,$h=30,$type='img',$noPhoto='',$title=''){
	global $m_path,$folderBack;
	$photos=getImages($ids);
	$n=count($photos);
	$x=0;
	$res='';
	if($n>0){
		$i=0;
		$id=$photos[$i]['id'];
		$file=$photos[$i]['file'];
		$folder=$photos[$i]['folder'];
		$ex=$photos[$i]['ex'];
		$bf=$folderBack;
		if($ex=='svg'){$file.='.svg';}
		$this_file=$m_path.'upi/'.$folder.$file;
		$r_file=$bf."sData/".$folder.$file;
		if(file_exists($bf.'sData/'.$folder.$file)){
			if($ex=='svg'){
                if($title){$title=' title="'.$title.'" ';}
				$res.='<div class="fl Over"
				href="'.$this_file.'" rel="lf" '.$title.'><img src="'.$this_file.'" id="im_'.$id.'" width="'.$w.'" height="'.$h.'" /></div>';
			}else{
				$fBig=resizeImage($file,"sData/".$folder,800,800,'bi',$m_path.'imup/',$dir,'sData/resize/',$ex);
				$image=Croping($file,"sData/".$folder,$w,$h,'i',$m_path.'imup/',$dir,'sData/resize/',$ex);
                if($title){$title=' title="'.$title.'" ';}
				list($org_w,$org_h)=getimagesize($r_file);
				$res.='<div class="fl Over"
				href="'.$fBig.'" rel="lf" '.$title.'><img src="'.$image.'" id="im_'.$id.'" /></div>';
			}
		}else{$x=1;}
		
	}
	if($n==0 || $x){		
		if($noPhoto!=''){
			$ex=getFileExt($noPhoto);	$image=Croping($noPhoto,"images/",$w,$h,'image',$m_path.'imup/',$dir,'sData/resize/',$ex);
			$res.='<div class="photoBloc fl" style="background-image:url('.$image.'); width:'.$w.'px;height:'.$h.'px;"></div>';
		}	
	}	
	return $res;
}
function viewImage($ids,$dir=0,$w=60,$h=30,$type='img',$noPhoto=''){
	global $m_path,$f_path,$folderBack;
	$photos=getImages($ids);
	$n=count($photos);
	$x=0;
	$res='';
	$image='';
	if($n>0){
		$i=0;
		$bf=$folderBack;
        $id=$photos[$i]['id'];
        $folder=$photos[$i]['folder'];
        $file=$photos[$i]['file'];
        $ex=$photos[$i]['ex'];
		$this_file=$m_path.'upi/'.$folder.$file;
		$r_file=$bf."sData/".$folder.$file;
        $mainSrc=$bf.'sData/'.$folder.$file;
        $resizeSrc=$bf.'sData/resize/i'.$w.$h.$file;
        if($ex=='svg'){
            $mainSrc.='.'.$ex;
            if(file_exists($mainSrc)){
                $image=$m_path.'upi/'.$folder.$file.'.'.$ex;
            }else{$x=1;}
        }else{
            if(file_exists($mainSrc)){
                if($type=='imgR'){
                    $type='img';
                    $image=resizeImage($file,"sData/".$folder,$w,$h,'i',$m_path.'imup/',$dir,'sData/resize/',$ex);
                }else{
                    $image=Croping($file,"sData/".$folder,$w,$h,'i',$m_path.'imup/',$dir,'sData/resize/',$ex);                
                }					
                list($org_w,$org_h)=getimagesize($r_file);			
            }else{$x=1;}
        }
	}
	if($n==0 || $x){		
		if($noPhoto!=''){$image=Croping($noPhoto,"images/",$w,$h,'image',$m_path.'reup/',$dir);}
	}	
	if($type=="img"){$res.='<img src="'.$image.'" width="100%" />';}
	elseif($type=="style"){$res.='background-image:url('.$image.')';}
    elseif($type=="src"){$res=$r_file;}
    elseif($type=="z"){$res=$resizeSrc;}
	else{$res=$image;}
	return $res;
}
function getBackpathLevel(){
	global $f_path;
	$out='';
	$x=explode('/',str_replace($f_path,'',$_SERVER['REQUEST_URI']));
	return $l=count($x)-1;
	if($l>0){
		$out=str_repeat('../',$l);
	}
	echo $out;
	return $out;
}
function imageUp($filed='photo',$vals='',$dir=1,$cb='',$req=0,$cls='imgUp',$text=''){
	global $m_path;
	$n=getRandString();
	$reqTxt='';
	if($req){$reqTxt='required';}
	$out='
	<div class="upimageCon" no='.$filed.' cb="'.$cb.'">
	<input type="hidden" name="'.$filed.'" id="'.$filed.'" '.$reqTxt.' value="'.$vals.'"/>
	<form id="f_'.$filed.'" enctype="multipart/form-data" method="post">
	<div class="fl" list id="list_'.$filed.'">
   	<div class="imgUpHol fl '.$cls.'"><input type="file" name="f" id="fi_'.$filed.'" onchange="imgeSelected(\''.$filed.'\');" accept="image/*" capture="camera" /> '.$text.'</div>';
	if($vals!=''){
		$images=getImages($vals);
		foreach($images as $img){
			$id=$img['id'];
			$file=$img['file'];
			$folder=$img['folder'];
			$ex=$img['ex'];
			$dir=getBackpathLevel();			
			$bp=str_repeat('../',$dir);
			list($w,$h)=getimagesize($bp."sData/".$folder.$file);			
			$fullfile=$m_path.'upi/'.$folder.$file;	
            if($ex=='svg'){
                $fullfile=$fullfile.'.svg';
                $thamp=$fullfile;
            }else{
                $thamp=Croping($file,"sData/".$folder,60,60,'i',$m_path.'imup/',$dir,'sData/resize/',$ex);
            }
			$out.='<div class="fl uibox" style="background-image:url('.$thamp.')"
			no="'.$id.'" org="'.$fullfile.'" group="'.$filed.'" sc="0" w="'.$w.'" h="'.$h.'"></div>';
		}
	}
	$out.='
	</div>
	</form>
	<div class="cb"></div>
	<script>imgClick()</script>
	</div>';
	return $out;
}
function imageUpN($id,$filed='photo',$code='',$val='',$req=0,$multi='0',$cb='',$fEx='',$text='',$cls='upBox'){
	global $defImgEx;
	$out='';
    if($val=='0'){$val='';}
    if($fEx==''){$fEx=implode(',',$defImgEx);}
	$n=getRandString();    
    $valBox='';
    $hide='';
    $addButt='add';
    $dataBar='hide';    
	if($val){
		list($val,$valBox)=viewImageUp($val);
        if($val){
            $addButt='add';
            $hide='hide';
            $dataBar='';
        }
	}
    if($multi){$hide='';}
	$out.= '<div class="'.$cls.' " upBox="'.$filed.'" c="'.$code.'" m="'.$multi.'" t="'.$fEx.'" r_id="'.$id.'" cb="'.$cb.'">
		<div addImg '.$addButt.' class="'.$hide.'" title="'.k_up_drop_click.'"></div>
        <div class="dataBar fl ofx so '.$dataBar.'" no="'.$filed.'">'.$valBox.'</div>
	</div>
    <span class="uc lh20">'.str_replace(',',' , ',$fEx).'</span>
	<input name="'.$filed.'"  value="'.$val.'" type="hidden" reqFile="'.$req.'">';
	return $out;
}
function viewImageUp($vals){
    global $m_path,$folderBack;
    $out='';
    $valArr=[];
    if($vals!=''){        
		$images=getImages($vals);
		foreach($images as $img){
			$id=$img['id'];
            $valArr[]=$id;
			$file=$img['file'];
			$folder=$img['folder'];
			$ex=$img['ex'];
            $name=$img['name'];
			$dir=getBackpathLevel();			
			$bp=str_repeat('../',$dir);
			list($w,$h)=getimagesize($bp."sData/".$folder.$file);			
			$fullfile=$m_path.'upi/'.$folder.$file;	            
            if($ex=='svg'){
                $fullfile=$fullfile.'.svg';
                $thamp=$fullfile;
            }else if($ex=='mp4'){
                $fullfile=$fullfile.'.mp4?iframe=true&width=80%&height=80%';;
                $thamp=$bp.'images/sys/video.png';
            }else{
                $thamp=Croping($file,"sData/".$folder,50,50,'i',$m_path.'imup/',0,'sData/resize/',$ex);
            }            
            $size=filesize($folderBack.'sData/'.$folder.'/'.$file);
            $out.='
            <div class="w100 fl" imgC="'.$id.'">
                <div class="fl Over" href="'.$fullfile.'" rel="lf"><img class="alb_imgs" width="50" src="'.$thamp.'"/></div>
                <div class="fl of">
                    <div delI="'.$id.'"></div>
                    <div class=" lh30 fs14">'.$name.'</div>
                    <div class=" lh20 B" szI>'.getFileSize($size).'</div>
                </div>
            </div>';
		}
	}
    return array(implode(',',$valArr),$out);
}
function writeTotal($total){
	$total=explode('.',$total);$j= strlen($total[0]);$je=$j;$je--;$de=1; 
	for($i=1;$i<$j;$i++){$de=$de*10;}$t=$total[0]; 
	for($i=0;$i<$j;$i++){$te[$je]=$t/$de;$t=$t%$de;$de=$de/10;$temp=explode('.',$te[$je]);$te[$je]=$temp[0];$je--;} 
	for($i=0;$i<$j;$i++){
	if($i==0){if($j<3){switch($te[$i]){case'0':$arb[0]=' ';break;case'1':$arb[0]=' واحد';break;case'2': if($te[1]=='1') $arb[0]=' اثنا '; else $arb[0]=' اثنان'; break;case'3':$arb[0]=' ثلاثة'; break;case'4':$arb[0]=' اربعة'; break;case'5':$arb[0]=' خمسة';break;case'6':$arb[0]=' ستة';break;case'7':$arb[0]=' سبعة';break;case'8':$arb[0]=' ثمانية';break;case'9':$arb[0]=' تسعة';break; }
	}else{switch($te[$i]){case'0':$arb[0]=' '; break;case'1': $arb[0]=' وواحد';break;case'2':if($te[1]=='1') $arb[0]=' واثنا '; else $arb[0]=' واثنان';break;case'3':$arb[0]=' وثلاثة'; break;case'4':$arb[0]=' واربعة'; break;case'5':$arb[0]=' وخمسة'; break;case'6':$arb[0]=' وستة'; break;case'7':$arb[0]=' وسبعة'; break;case'8':$arb[0]=' وثمانية'; break;case'9':$arb[0]=' وتسعة'; break;}}}
	if($i==1){if($j==2){if($te[$i]==1){if($te[0]=='1'){$arb[0]=' ';$arb[1]=' أحد عشر';}elseif($te[0]=='0'){$arb[1]=' عشرة';}else{$arb[1]=' عشر';}}
	if($te[0]=='0'){switch($te[$i]){case'0':$arb[1]=' '; break;case'1':if($te[0]=='1'){$arb[0]=' ';$arb[1]=' أحد عشر';}elseif($te[0]=='0'){$arb[1]=' عشرة';}else{$arb[1]='عشر';} break;case'2':$arb[1]=' عشرون'; break;case'3':$arb[1]=' ثلاثون'; break;case'4':$arb[1]=' اربعون'; break;case'5':$arb[1]=' خمسون'; break;case'6':$arb[1]=' ستون'; break;case'7':$arb[1]=' سبعون'; break;case'8':$arb[1]=' ثمانون'; break;case'9':$arb[1]=' تسعون'; break;} }
	}else{switch($te[$i]){case'0':$arb[1]=' '; break;case'1':if($te[0]=='1'){$arb[0]=' ';$arb[1]=' وأحد عشر';}elseif($te[0]=='0'){$arb[1]=' وعشرة';}else{$arb[1]=' عشر';}break;case'2':$arb[1]=' وعشرون'; break;case'3':$arb[1]=' وثلاثون'; break;case'4':$arb[1]=' واربعون'; break;case'5':$arb[1]=' وخمسون'; break;case'6':$arb[1]=' وستون'; break;case'7':$arb[1]=' وسبعون'; break;case'8':$arb[1]=' وثمانون'; break;case'9':$arb[1]=' وتسعون'; break;} }}
	if($i==2){if($j==3){switch($te[$i]){case'0':$arb[2]=' '; break;case'1':$arb[2]=' مائة'; break;case'2':$arb[2]=' مائتان'; break;case'3':$arb[2]=' ثلاثمائة'; break;case'4':$arb[2]=' اربعمائة'; break;case'5':$arb[2]=' خمسمائة'; break;case'6':$arb[2]=' ستمائة'; break;case'7':$arb[2]=' سبعمائة'; break;case'8':$arb[2]=' ثمانمائة'; break;case'9':$arb[2]=' تسعمائة'; break;}
	}else{switch($te[$i]){case'0':$arb[2]=' '; break;case'1':$arb[2]=' ومائة'; break;case'2':$arb[2]=' ومائتان'; break;case'3':$arb[2]=' وثلاثمائة'; break;case'4':$arb[2]=' واربعمائة'; break;case'5':$arb[2]=' وخمسمائة'; break;case'6':$arb[2]=' وستمائة'; break;case'7':$arb[2]=' وسبعمائة'; break;case'8':$arb[2]=' وثمانمائة'; break;case'9':$arb[2]=' وتسعمائة'; break;}}}
	if($i==3){if($j==4){switch($te[$i]){case'0':$arb[$i]=' '; break;case'1':$arb[$i]=' ألف'; break;case'2':$arb[$i]=' ألفان'; break;case'3':$arb[$i]=' ثلاثة آلاف'; break;case'4':$arb[$i]=' اربعة آلاف'; break;case'5':$arb[$i]=' خمسة آلاف'; break;case'6':$arb[$i]=' ستة آلاف'; break;case'7':$arb[$i]=' سبعة آلاف'; break;case'8':$arb[$i]=' ثمانية آلاف '; break;case'9':$arb[$i]=' تسعة آلاف '; break;}
	}elseif($j==5){switch($te[$i]){case'0':$arb[$i]=' '; break;case'1':$arb[$i]=' واحد '; break;case'2':if($te[6]=='1') $arb[$i]=' اثنا '; else $arb[$i]=' اثنان'; break;case'3':$arb[$i]=' ثلاثة '; break;case'4':$arb[$i]=' اربعة '; break;case'5':$arb[$i]=' خمسة '; break;case'6':$arb[$i]=' ستة '; break;case'7':$arb[$i]=' سبعة '; break;case'8':$arb[$i]=' ثمانية '; break;case'9':$arb[$i]=' تسعة '; }
	}else{switch($te[$i]){case'0':$arb[$i]=' '; break;case'1':$arb[$i]=' وواحد '; break;case'2':if($te[4]=='1') $arb[$i]=' واثنا '; else $arb[$i]=' واثنان'; break;case'3':$arb[$i]=' وثلاثة '; break;case'4':$arb[$i]=' واربعة '; break;case'5':$arb[$i]=' وخمسة '; break;case'6':$arb[$i]=' وستة '; break;case'7':$arb[$i]=' وسبعة '; break;case'8':$arb[$i]=' وثمانية '; break;case'9':$arb[$i]=' وتسعة '; }}}
	if($i==4){if($j==5){switch($te[$i]){case'0':$arb[$i]=' '; break;case'1':if($te[3]=='1') {$arb[3]=' ';$arb[4]=' أحد عشر الفا';} elseif($te[3]=='0')$arb[4]=' عشرة آلاف';else$arb[$i]=' عشر الفا'; break;case'2':$arb[$i]=' عشرون '; break;case'3':$arb[$i]=' ثلاثون '; break;case'4':$arb[$i]=' اربعون '; break;case'5':$arb[$i]=' خمسون '; break;case'6':$arb[$i]=' ستون '; break;case'7':$arb[$i]=' سبعون '; break;case'8':$arb[$i]=' ثمانون '; break;case'9':$arb[$i]=' تسعون '; break; }
	}else{switch($te[$i]){case'0':$arb[$i]=' '; break;case'1':if($te[3]=='1') {$arb[3]=' ';$arb[4]=' وأحد عشر الفا';} elseif($te[3]=='0')$arb[4]=' وعشرة آلاف';else$arb[$i]=' عشر الفا'; break;case'2':$arb[$i]=' وعشرون '; break;case'3':$arb[$i]=' وثلاثون '; break;case'4':$arb[$i]=' واربعون '; break;case'5':$arb[$i]=' وخمسون '; break;case'6':$arb[$i]=' وستون '; break;case'7':$arb[$i]=' وسبعون '; break;case'8':$arb[$i]=' وثمانون '; break;case'9':$arb[$i]=' وتسعون '; break; }}}
	if($i==5){if($j==6){switch($te[$i]){case'0':$arb[$i]=' '; break;case'1':$arb[$i]=' مائة '; break;case'2':$arb[$i]=' مائتان '; break;case'3':$arb[$i]=' ثلاثمائة '; break;case'4':$arb[$i]=' اربعمائة '; break;case'5':$arb[$i]=' خمسمائة '; break;case'6':$arb[$i]=' ستمائة '; break;case'7':$arb[$i]=' سبعمائة '; break;case'8':$arb[$i]=' ثمانمائة '; break;case'9':$arb[$i]=' تسعمائة '; break; } 
	}else{switch($te[$i]){case'0':$arb[$i]=' '; break;case'1':$arb[$i]=' ومائة '; break;case'2':$arb[$i]=' ومائتان '; break;case'3':$arb[$i]=' وثلاثمائة '; break;case'4':$arb[$i]=' واربعمائة '; break;case'5':$arb[$i]=' وخمسمائة '; break;case'6':$arb[$i]=' وستمائة '; break;case'7':$arb[$i]=' وسبعمائة '; break;case'8':$arb[$i]=' وثمانمائة '; break;case'9':$arb[$i]=' وتسعمائة '; break;
		}}}
	if($i==6){switch($te[$i]){case'0':$arb[$i]=' '; break;case'1':$arb[$i]=' مليون '; break;case'2':$arb[$i]=' مليونان '; break;case'3':$arb[$i]=' ثلاثة ملايين '; break;case'4':$arb[$i]=' اربعة ملايين '; break;case'5':$arb[$i]=' خمسة ملايين '; break;case'6':$arb[$i]=' ستة ملايين'; break;case'7':$arb[$i]=' سبعة ملايين '; break;case'8':$arb[$i]=' ثمانية ملايين '; break;case'9':$arb[$i]=' تسعة ملايين '; break;}}}
	if($j>4 && $te[4]!='1'){$arb[4]=$arb[4].' الف ';}
	$strarb=$arb[6].$arb[5].$arb[3].$arb[4].$arb[2].$arb[0].$arb[1]; 
	return $strarb; 
}
function dayfromTime($t){return $t-($t % 86400);}
function getTikImge($width,$tic,$margin=6,$margin_out=15){
	$img='';
	$fns=array();
	$lineHeightPers=1.5;
	$fns['f1']='library/fonts/GE_SS_Two_Medium.ttf';
	$fns['f2']='library/fonts/en.ttf';
	$fns['f3']='library/fonts/BarcodeFont.ttf';
	$fns['f4']='library/fonts/ConnectCode39.ttf';
	$size=16;
	$lineNo=0;
	$l=0;
	$lineNo=0;
	$lineHeight=$size*2;
	$lineWidth=0;
	$wordSpace=8;
	$actLine=0;
	$lines=array();
	$g_words=array();	
	foreach($tic as $t1){
		$lineNo++;
		$lineWidth=0;		
		$im1=imagecreate($width,$width*2);
		$bg = imagecolorallocatealpha($im1,255,255,255,0);
		$color = imagecolorallocate($im1,0,0,0);
		$val=$t1[0];
		$type=$t1[1];
		if($type=='text'){
			$algin=$t1[2];
			$font=$fns[$t1[3]];
			$size=$t1[4];
			$incode=$t1[5];					
			$words=explode(' ',$val);		
			$i=0;		
			foreach($words as $w){
				if($incode=='ar'){$text=conv($w);}else{$text=$w;}
				$g_words[$i]=imagettftext($im1,$size,0,0,$size,$color,$font,$text);
				$g_words[$i]['text']=$text;
				$i++;
			}		
			$i=0;		
			foreach($words as $w){
				$ww=$g_words[$i][2];
				$text=$g_words[$i]['text'];
				if(($ww+$lineWidth+($margin_out*2))+$wordSpace>($width)){$lineNo++;$lineWidth=0;}
				$lines[$lineNo][$l]['img']=$g_words[$i];
				$lines[$lineNo][$l]['width']=$g_words[$i][2];
				$lines[$lineNo][$l]['text']=$g_words[$i]['text'];
				$lines[$lineNo][$l]['size']=$size;
				$lines[$lineNo][$l]['algin']=$algin;
				$lines[$lineNo][$l]['font']=$font;
				$lines[$lineNo][$l]['incode']=$incode;
				$lines[$lineNo][$l]['type']=$type;
				$wordSpace=$size/2;
				$lineWidth+=$ww+$wordSpace;			
				$l++;
				$i++;
			}
		}
		if($type=='bc'){
			$algin='c';
			$font=$fns['f4'];
			$size=16;
			$incode='en';					
			$words=explode(' ',$val);		
			$i=0;		
			foreach($words as $w){
				$text=$w;
				$g_words[$i]=imagettftext($im1,$size,0,0,$size,$color,$font,$text);
				$g_words[$i]['text']=$text;
				$i++;
			}		
			$i=0;		
			foreach($words as $w){
				$ww=$g_words[$i][2];
				$text=$g_words[$i]['text'];
				if(($ww+$lineWidth+($margin*2))+$wordSpace>($width)){$lineNo++;$lineWidth=0;}
				$lines[$lineNo][$l]['img']=$g_words[$i];
				$lines[$lineNo][$l]['width']=$g_words[$i][2];
				$lines[$lineNo][$l]['text']=$g_words[$i]['text'];
				$lines[$lineNo][$l]['size']=$size;
				$lines[$lineNo][$l]['algin']=$algin;
				$lines[$lineNo][$l]['font']=$font;
				$lines[$lineNo][$l]['incode']=$incode;
				$lines[$lineNo][$l]['type']=$type;
				$wordSpace=$size/2;
				$lineWidth+=$ww+$wordSpace;			
				$l++;
				$i++;
			}
		}
	}
	
	$y=$margin_out;
	foreach($lines as $line){
		foreach($line as $ll){
			$size=$ll['size'];
			$type=$ll['type'];
		}
		if($type=='text'){$y+=$margin+($size*$lineHeightPers);}else{$y+=$margin+($size*(2.5));}
		$i++;			
	}	
	$height=(count($lines)+1)*$lineHeight;
	$im = imagecreate($width,$y+($margin*2));
	$bg = imagecolorallocatealpha($im,255,255,255,0);
	$color = imagecolorallocate($im,0,0,0);
	
	$y=$margin_out;
	$i=0;
	foreach($lines as $line){
		$linwords=count($line);
		$x=$width-$margin;
		$lineWordWidths=0;
		foreach($line as $ll){
			$ww=$ll['width'];
			$algin=$ll['algin'];
			$incode=$ll['incode'];
			$size=$ll['size'];
			$type=$ll['type'];
			$lineWordWidths+=$ww;
			$wordSpace=$size/2;	
		}
		if($algin=='l'){$linMrg=0; $x=$margin_out;}
		if($algin=='c'){			
			if($incode=='ar'){
				$x=$width;
				$linMrg=($width-$lineWordWidths-($wordSpace*($linwords-1)))/2;
			}else{
				$x=0;
				$linMrg=($width-$lineWordWidths-($wordSpace*($linwords-1)))/2;
			}
		}
		if($algin=='r'){$linMrg=0;}
		$w=0;
		$x_pointer=0;		
		if($type=='text'){$y+=$margin+($size*$lineHeightPers);}else{$y+=$margin+($size*(2.5));}		
		foreach($line as $ll){
			$text=$ll['text'];
			$ww=$ll['width'];
			$font=$ll['font'];
			$algin=$ll['algin'];
			$incode=$ll['incode'];
			if($w==0){$space=$linMrg;}else{$space=$wordSpace;}			
			if($algin=='l'){if($w>0){$x=$x_pointer;}$x_pointer=$x+$ww+$wordSpace;}			
			if($algin=='c'){
				if($incode=='ar'){$x-=$ww+$space;}else{if($w>0){$x=$x_pointer;}else{$x=$linMrg;}$x_pointer=$x+$ww+$wordSpace;}
			}
			if($algin=='r'){$x-=$ww+$margin;}
			$t=imagettftext($im,$ll['size'],0,$x,$y,$color,$font,$text);
			$w++;
		}	
		$i++;			
	}
	/**************************/
	$fileDate=getRandString(3,0).date('U').'.png';
	$ressixeDir='temp/';
	if(!file_exists($ressixeDir)){mkdir($ressixeDir,0777);}
	imagepng($im,$ressixeDir.$fileDate);
	imagedestroy($im);
	//imagedestroy($im2);
	return $fileDate;
}
function shortNo($n){
	if($n>=1000000){
		$c='M ';
		$n=$n/1000000;
		$dot=1;
		if($n>9)$dot=0;
	}else if($n>=1000){
		$c='K ';
		$n=$n/1000;
		$dot=1;
		if($n>9)$dot=0;
	}	
	return $c.number_format($n,$dot);
}
function conv($word){
$new_word = array();
$char_type = array();
$noso=array('1','2','3','4','5','6','7','8','9','0','(',')','[',']','{','}','|','.',',',';');
$so_chars = array('ا', 'د', 'ذ', 'أ','إ', 'آ', 'ر', 'ؤ', 'ء', 'ز', 'و', 'ى', 'ة');
$all_chars = array(
'ا' => array('mi'=>'&#xFE8E;','so'=>'&#xFE8D;'),		
'ؤ' => array('mi'=>'&#xFE85;','so'=>'&#xFE86;'),
'ء' => array('mi'=>'&#xFE80;','so'=>'&#xFE80;'),
'أ' => array('mi'=>'&#xFE84;','so'=>'&#xFE83;'),
'إ' => array('mi'=>'&#xFE84;','so'=>'&#x0625;'),
'آ' => array('mi'=>'&#xFE82;','so'=>'&#xFE81;'),
'ى' => array('mi'=>'&#xFEF0;','so'=>'&#xFEEF;'),
'ب' => array('be'=>'&#xFE91;','mi'=>'&#xFE92;','end'=>'&#xFE90;','so'=>'&#xFE8F;'),
'ت' => array('be'=>'&#xFE97;','mi'=>'&#xFE98;','end'=>'&#xFE96;','so'=>'&#xFE95;'),
'ث' => array('be'=>'&#xFE9B;','mi'=>'&#xFE9C;','end'=>'&#xFE9A;','so'=>'&#xFE99;'),
'ج' => array('be'=>'&#xFE9F;','mi'=>'&#xFEA0;','end'=>'&#xFE9E;','so'=>'&#xFE9D;'),
'ح' => array('be'=>'&#xFEA3;','mi'=>'&#xFEA4;','end'=>'&#xFEA2;','so'=>'&#xFEA1;'),
'خ' => array('be'=>'&#xFEA7;','mi'=>'&#xFEA8;','end'=>'&#xFEA6;','so'=>'&#xFEA5;'),
'د' => array('mi'=>'&#xFEAA;','so'=>'&#xFEA9;'),
'ذ' => array('mi'=>'&#xFEAC;','so'=>'&#xFEAB;'),
'ر' => array('mi'=>'&#xFEAE;','so'=>'&#xFEAD;'),
'ز' => array('mi'=>'&#xFEB0;','so'=>'&#xFEAF;'),
'س' => array('be'=>'&#xFEB3;','mi'=>'&#xFEB4;','end'=>'&#xFEB2;','so'=>'&#xFEB1;'),
'ش' => array('be'=>'&#xFEB7;','mi'=>'&#xFEB8;','end'=>'&#xFEB6;','so'=>'&#xFEB5;'),
'ص' => array('be'=>'&#xFEBB;','mi'=>'&#xFEBC;','end'=>'&#xFEBA;','so'=>'&#xFEB9;'),
'ض' => array('be'=>'&#xFEBF;','mi'=>'&#xFEC0;','end'=>'&#xFEBE;','so'=>'&#xFEBD;'),
'ط' => array('be'=>'&#xFEC3;','mi'=>'&#xFEC4;','end'=>'&#xFEC2;','so'=>'&#xFEC1;'),
'ظ' => array('be'=>'&#xFEC7;','mi'=>'&#xFEC8;','end'=>'&#xFEC6;','so'=>'&#xFEC5;'),
'ع' => array('be'=>'&#xFECB;','mi'=>'&#xFECC;','end'=>'&#xFECA;','so'=>'&#xFEC9;'),
'غ' => array('be'=>'&#xFECF;','mi'=>'&#xFED0;','end'=>'&#xFECE;','so'=>'&#xFECD;'),
'ف' => array('be'=>'&#xFED3;','mi'=>'&#xFED4;','end'=>'&#xFED2;','so'=>'&#xFED1;'),
'ق' => array('be'=>'&#xFED7;','mi'=>'&#xFED8;','end'=>'&#xFED6;','so'=>'&#xFED5;'),
'ك' => array('be'=>'&#xFEDB;','mi'=>'&#xFEDC;','end'=>'&#xFEDA;','so'=>'&#xFED9;'),
'ل' => array('be'=>'&#xFEDF;','mi'=>'&#xFEE0;','end'=>'&#xFEDE;','so'=>'&#xFEDD;'),
'م' => array('be'=>'&#xFEE3;','mi'=>'&#xFEE4;','end'=>'&#xFEE2;','so'=>'&#xFEE1;'),
'ن' => array('be'=>'&#xFEE7;','mi'=>'&#xFEE8;','end'=>'&#xFEE6;','so'=>'&#xFEE5;'),
'ه' => array('be'=>'&#xFEEB;','mi'=>'&#xFEEC;','end'=>'&#xFEEA;','so'=>'&#xFEE9;'),
'و' => array('mi'=>'&#xFEEE;','so'=>'&#xFEED;'),
'ي' => array('be'=>'&#xFEF3;','mi'=>'&#xFEF4;','end'=>'&#xFEF2;','so'=>'&#xFEF1;'),
'ئ' => array('be'=>'&#xFE8B;','mi'=>'&#xFE8C;','end'=>'&#xFE8A;','so'=>'&#xFE89;'),
'ة' => array('mi'=>'&#xFE94;','so'=>'&#xFE93;'),
);
if(mb_strlen($word,'utf8')==1){
    return $all_chars[$word]['so'];
}   
if(in_array(substr($word[0],0,1),$noso)){
	return $word;
}else{
if(strlen($word)==4){
	if(in_array($word[0].$word[1],$so_chars)){
		$new_word[] = $all_chars[$word[0].$word[1]]['so'];
		$char_type[] = 'not_normal';
	}else{
		$new_word[] = $all_chars[$word[0].$word[1]]['be'];
		$char_type[] = 'normal';
	}
	if(in_array($word[2].$word[3],$so_chars)){
		$new_word[] = $all_chars[$word[2].$word[3]]['so'];
		$char_type[] = 'not_normal';
	}else{
		$new_word[] = $all_chars[$word[2].$word[3]]['end'];
		$char_type[] = 'normal';
	}
	
}else{
	if(in_array($word[0].$word[1],$so_chars)){
		$new_word[] = $all_chars[$word[0].$word[1]]['so'];
		$char_type[] = 'not_normal';
	}else{
		$new_word[] = $all_chars[$word[0].$word[1]]['be'];
		$char_type[] = 'normal';
	}
	if(strlen($word) > 4){
		if($char_type[0] == 'not_normal'){
			if(in_array($word[2].$word[3], $so_chars)){
				$new_word[] = $all_chars[$word[2].$word[3]]['so'];
				$char_type[] = 'not_normal';
			}else{		
				$new_word[] = $all_chars[$word[2].$word[3]]['be'];
				$char_type[] = 'normal';
			}
		}else{
			$new_word[] = $all_chars[$word[2].$word[3]]['mi'];
			$chars_statue[] = 'mi';
			if(in_array($word[2].$word[3], $so_chars)){
				$char_type[] = 'not_normal';
			}else{
				$char_type[] = 'normal';
			}
		}
		$x = 4;
	}else{
		$x = 2;	
	}	
	for($x=4;$x< (strlen($word)-4) ;$x++){
		if($char_type[count($char_type)-1] == 'not_normal' AND $x %2 == 0){
			if(in_array($word[$x].$word[$x+1], $so_chars)){				
				$new_word[] = $all_chars[$word[$x].$word[$x+1]]['so'];
				$char_type[] = 'not_normal';
			}else{				
				$new_word[] = $all_chars[$word[$x].$word[$x+1]]['be'];
				$char_type[] = 'normal';
			}
		}elseif($char_type[count($char_type)-1] == 'normal' AND $x %2 == 0){			
			if(in_array($word[$x].$word[$x+1], $so_chars)){				
				$new_word[] = $all_chars[$word[$x].$word[$x+1]]['mi'];
				$char_type[] = 'not_normal';
			}else{				
				$new_word[] = $all_chars[$word[$x].$word[$x+1]]['mi'];
				$char_type[] = 'normal';
			}
		}
	}
	if(strlen($word)>6){
		if($char_type[count($char_type)-1] == 'not_normal'){
			if(in_array($word[$x].$word[$x+1], $so_chars)){				
				$new_word[] = $all_chars[$word[$x].$word[$x+1]]['so'];
				$char_type[] = 'not_normal';
			}else{			
				if($word[strlen($word)-2].$word[strlen($word)-1] == 'ء'){
					$new_word[] = $all_chars[$word[$x].$word[$x+1]]['so'];
					$char_type[] = 'normal';
				}else{
					$new_word[] = $all_chars[$word[$x].$word[$x+1]]['be'];
					$char_type[] = 'normal';
				}					
			}
			$x += 2;
		}elseif($char_type[count($char_type)-1] == 'normal'){			
			if(in_array($word[$x].$word[$x+1], $so_chars)){				
				$new_word[] = $all_chars[$word[$x].$word[$x+1]]['mi'];
				$char_type[] = 'not_normal';
			}else{			
				$new_word[] = $all_chars[$word[$x].$word[$x+1]]['mi'];
				$char_type[] = 'normal';
			}
			$x += 2;
		}		
	}	
	if($char_type[count($char_type)-1] == 'not_normal'){
		if(in_array($word[$x].$word[$x+1], $so_chars)){		
			$new_word[] = $all_chars[$word[$x].$word[$x+1]]['so'];
		}else{
			$new_word[] = $all_chars[$word[$x].$word[$x+1]]['so'];
		}
	}else{
		if(in_array($word[$x].$word[$x+1], $so_chars)){			
			$new_word[] = $all_chars[$word[$x].$word[$x+1]]['mi'];
		}else{			
			$new_word[] = $all_chars[$word[$x].$word[$x+1]]['end'];
		}
	}
}
}
return implode('',array_reverse($new_word));
}
function SysBackUp($backupDir){
	global $bx_tables,$now;
	$keyCode=_pro_id;
	if(!file_exists($backupDir)){mkdir($backupDir, 0777);}
	$t_query = mysql_q('show tables');
	$back_file = 'B'.$now.getRandString().'.php';
	$b_file = fopen($backupDir.$back_file,'w');	
	$t_query = mysql_q('show tables');
	$tCount=mysql_n($t_query);
	$backup_table_count=$tCount-count($bx_tables);
	$t=0;
	$allrows=0;
	$qpp=500;
	$sql_data_c='';
	$sql_data_c.=md5(_pro_id).'|^_^|'.$now;
	while ($tables = mysql_f($t_query)){	
		list(,$table) = ($tables);	
		if(!in_array($table,$bx_tables)){
			$t++;
			$sql_data_c.='|^_^|'.$table.'|^-^|';	
			$sql_data_c.= "drop table if exists `".$table."`;|^-^|";
			$sql_data_c.="create table `".$table."` (";
			$table_list = array();
			$fields_query = mysql_q("show fields from `".$table."`");
			$fil_rows=mysql_n($fields_query);
			$fr=0;
			while ($fields = mysql_f($fields_query)){
				$table_list[] = "`".$fields['Field']."`"; 					
				$sql_data_c.= "  `".$fields['Field']."` ".$fields['Type'];		
				if (strlen($fields['Default']) > 0) $sql_data_c.= " default '".$fields['Default']."' ";
				if ($fields['Null'] != 'YES') $sql_data_c.=" not null";
				if (isset($fields['Extra'])) $sql_data_c.=" ".$fields['Extra'];
				$fr++;
				if($fr!=$fil_rows){$sql_data_c.= ",";}			
			}
            /**************************************************************/
			// add the keys
			$index = array();
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
			while (list($kname, $info) = ($index)){	
				$sql_data_c.= ",";		
				$columns = implode(", ",$info['columns']);		
				if($kname == "PRIMARY"){
					$sql_data_c.= "  PRIMARY KEY (". $columns. ")";
				}elseif( $info['fulltext'] == '1' ) {
					$sql_data_c.= "  FULLTEXT `".$kname."` (".$columns.")";
				}elseif($info['unique']) {
					$sql_data_c.= "  UNIQUE `".$kname."` (".$columns.")";
				}else{
					$sql_data_c.= "  KEY `".$kname."` (".$columns.")";
				}				
			}
            /******************************/
			$sql_data_c.= ") ENGINE=MYISAM  ;|^-^|";
			// dump the data	
			$rows_query = mysql_q("select ". implode(',',$table_list)." from `".$table."`");
			$rows_rows=mysql_n($rows_query);			
			if($rows_rows>0){	
				$qpp_counter=0;
				$qpp_all=0;	
				while ($rows = mysql_f($rows_query)){
					$allrows++;	
					$r_rows=count($table_list);
					if($qpp_counter==0){			
						$sql_data_c.= "|^*^|insert into `".$table."` (".implode(',',$table_list).")values";		
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
					while (list(,$i) = ($table_list)){
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
					if($qpp_counter==$qpp){
						$qpp_counter=0;
						$sql_data_c.=";";
					}
					$qpp_all++;
				}
				$sql_data_c.=";";
			}else{
				$sql_data_c.="Empty";
			}
			$sql_data_c.="|^-^|";		
		}
	}
	fputs($b_file,'<? $backcode="'.Encode($sql_data_c,$keyCode).'"; ?>');
	fclose($b_file);
	$size=filesize($backupDir.$back_file);
	if(mysql_q("INSERT INTO _backup (date,file,size,rec)values('$now','$back_file','$size','$allrows') ")){return 1;}
}
function getYearsOfRec($table,$d_col,$con=''){
	$out=array(0,0);
	if($con){$con=' where '.$con;}
	$sql="select MAX($d_col) x , MIN($d_col) i FROM $table $con ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows){
		$r=mysql_f($res);
		$out[0]=$r['i'];
		$out[1]=$r['x'];
	}
	if($out[0]){$out[0]=date('Y',$out[0]);}
	if($out[1]){$out[1]=date('Y',$out[1]);}
	return $out;
}
function splitNo($str){
	$no_arr=str_split('0123456789');
	$out='';$num='';$str_arr=str_split($str);
	foreach($str_arr as $s){
		if(in_array($s,$no_arr)){$num.=$s;}else{if($num){$out.='<no>'.$num.'</no>';$num='';}$out.=$s;}
	}
	if($num){$out.='<no>'.$num.'</no>';$num='';}
	return $out;
}
function getRec($table,$id,$colum='id'){
	$out=array();
	$out['r']=0;
	$fileds=array();
	$sql2="SHOW COLUMNS FROM $table ";
	$res2=mysql_q($sql2);
	$rows2=mysql_n($res2);	
	while($r2=mysql_f($res2)){		
		array_push($fileds,$r2['Field']);
	}
	$sql="select * from $table where $colum='$id' limit 1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$out['r']=$rows;		
		foreach($fileds as $f){			
			$out[$f]=$r[$f];
		}
	}
	return $out;
}
function getData($table,$cond='',$code='id',$limit=1000){
	$out=array();
    if($cond){$cond="where $cond ";}
	$out['r']=0;
	$fileds=array();
	$sql2="SHOW COLUMNS FROM $table ";
	$res2=mysql_q($sql2);
	$rows2=mysql_n($res2);	
	while($r2=mysql_f($res2)){
		array_push($fileds,$r2['Field']);
	}
	$sql="select * from $table $cond limit $limit";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
        while($r=mysql_f($res)){            			
            $out[$r[$code]]=$r;
        }
	}
	return $out;
}
function getRecCon($table,$con,$ord=''){
	$out=array();
	$out['r']=0;
	$sql="select * from $table where $con $ord limit 1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$out= mysql_f($res);
		$out['r']=$rows;
	}
	return $out;
}
function limitDec($no,$l=''){
	if($l==''){$l=2;}
	if($l>9){
		$o=number_format($no,2);
		return str_replace('.',':',$o);
	}
	$d=pow(10,$l);
	$nn=explode('~',$no);
	if(count($nn)>1){
		return round($nn[0],$l).' ~ '.round($nn[1],$l);
	}else{
		return round($no,$l);
	}		
}
function clockStye($str){
	$code='AM';
	if($str>12){
		$code='PM';
		if($str==24){$code='AM';}
		$str-=12;
	}
	if($str<10){$str='0'.$str;}
	return $code.' '.$str; 
}

function clockStye_per($str){
	$code='AM';
	$h=intval($str);
	$mp=$str-$h;
	$m='00';
	if($mp>0){
		$m=$mp*60;
		if($m<10){$m='0'.intval($m);}
	}
	if($h>12){$code='PM';$h-=12;}
	if($h<10){$h='0'.intval($h);}	
	return $code.' '.$h.':'.$m; 
}
function roundNo($no,$rate,$type='up'){
	$out=0;
	if($type=='up'){		
		$out =intval($no/$rate)*$rate;
		if($no%$rate!=0){$out+=$rate;}		
	}else if($type=='down'){
		$out=intval($no/$rate)*$rate;
	}else if($type=='n'){
		$out=intval($no/$rate)*$rate;
		if($no%$rate>=($rate/2)){$out+=$rate;}
	}
	return $out;
}
function numFor($n,$limit=0){
	$multi=explode(',',$n);
	if($multi>1){
		return $n;
	}
	$nn=explode('.',$n);
	$d=0;
	if(count($nn)==2){
		$d=strlen($nn[1]);
	}
	if($limit){
		if($d>$limit){$d=$limit;}
	}
	return number_format($n,$d);
}
function printHeaderImg($photo){
	global $m_path;
	if($photo){
		$image=getImages($photo);
		$file=$image[0]['file'];
		$folder=$image[0]['folder'];
		//list($w,$h)=getimagesize("sData/".$folder.$file);
		$fullfile=$m_path.'upi/'.$folder.$file;
		return '<img width="100%" src="'.$fullfile.'"/>';
	}
}
function minutes($id,$opr,$filed,$val){	
	if($opr=='add' || $opr=='edit'){
		$out=getMintInput($filed,$val);
	}else{
		$c='';
		if($val==0){$c='clr4';}
		$out='<ff class="'.$c.'">'.minToHour($val).'</ff>';
	}
	return $out;
}
function getMintInput($name,$val=0){
	$n='r'.rand();
	$out='';
	if($val){
		$h=intval($val/60);
		$m=$val%60;
	}
	$out.='<div class="fl" mintBlc no="'.$n.'">
	<div class="fll pd10"> H <input type="number" fix="w:80" mint_h="'.$n.'" value="'.$h.'"></div>
	<div class="fll pd10"> M <input type="number" fix="w:80" mint_m="'.$n.'" value="'.$m.'"></div>
	<div class="fll lh40 pd10 fs18 ff B clr1" mint_v="'.$n.'">'.minToHour($val).'</div>';
	$out.='<input type="hidden" name="'.$name.'" mint="'.$n.'" value="'.$val.'">';
	return $out;
}
function minToHour($min){
	$h=intval($min/60);
	$m=$min%60;	
	if($m<10){$m='0'.$m;}
	return $h.':'.$m;
}
/******Reports*********/
function reportNav($fil,$type,$page,$tab,$print,$export,$pagMood){
	global $now,$todyU,$monLen,$mm,$selYear,$monthsNames;
	if($type<4){
		if($type==1){//day
			if($fil==0){
				$thisVal=$now-($now%86400);
			}else{				
				$thisVal=$fil;				
			}
			$todyU=$thisVal;
			$valText='<ff>'.date('Y-m-d',$thisVal).'</ff>';
			$next_val=($thisVal+86400);
			$priv_val=($thisVal-86400);
		}
		if($type==2){//month
			if($fil==0){			
				$monLen=date('t');
				$month=date('m');
				$year=date('Y');
				$mm=strtotime($year.'-'.$month.'-1');		
			}else{
				$vv=explode('-',$fil);
				$year=$vv[0];
				$month=$vv[1];

				$mm=strtotime($year.'-'.$month.'-1');
				$monLen=date('t',$mm);			
			}
			if($month==12){$n_m=1;$n_y=$year+1;$b_m=$month-1;$b_y=$year;
			}else if($month==1){$n_m=$month+1;$n_y=$year;$b_m=12;$b_y=$year-1;
			}else{$n_m=$month+1;$n_y=$year;$b_m=$month-1;$b_y=$year;}
			$next_val=$n_y.'-'.$n_m;
			$priv_val=$b_y.'-'.$b_m;
			$thisVal=$year.'-'.$month;
			$valText=$monthsNames[intval($month)].'<span class="dHYear ff"> | '.$year.'</span>';
		}
		if($type==3){//year
			$selYear=$fil;	
			if($fil==0){$selYear=date('Y');}
			$next_val=$selYear+1;
			$priv_val=$selYear-1;
			$valText='<ff>'.$selYear.'</ff>';
		}
		if($type>0){
			$out='
			<div class="dateHeader fl">
			<div class="fl dth dt_l" onclick="loadReport('.$page.','.$tab.',\''.$next_val.'\')" title="'.k_next.'"></div>
			<div class="fl dHeader c_cont f1" onclick="loadReport('.$page.','.$tab.',\''.$thisVal.'\')" title="'.k_refresh.'">'.$valText.'</span></div>
			<div class="fr dth dt_r" onclick="loadReport('.$page.','.$tab.',\''.$priv_val.'\')" title="'.k_priv.'"></div>           
			</div>';
		}
	}
	if($type==4){
		$df=pp($_POST['df'],'s');
		$dt=pp($_POST['dt'],'s');
		if(!$df)$df=date('Y-m-d');
		if(!$dt)$dt=date('Y-m-d');
		$out='<div class="lh40 fl">
		<div class="fl f1 fs18 pd10"> '.k_from.' </div>
		<div class="fl"><input type="text" id="df" class="Date" but value="'.$df.'"/></div>
		<div class="fl f1 fs18 pd10"> '.k_to.' </div>
		<div class="fl"><input type="text" id="dt" class="Date" but value="'.$dt.'"/></div>
		<div class="fl ic40 icc1 ic40Txt ic40_search mg5" onclick="ReloadReport()"> '.k_search.'</div>
		</div>';
	}
	if($print){$out.='<div class="ic40 icc2 ic40_print fr ic40Txt mg5f" onclick="printReport(1)">'.k_prn_tbl.'</div>';}
	if($export){$out.='<div class="ic40 icc4 ic40_reload fr ic40Txt mg5f" onclick="printReport(2)">'.k_export.'</div>';}
	$out.='<div class="uLine cb"></div>';
	if($pagMood==0){return $out;}
}
function repoNav($fil,$type,$page,$tab,$print,$export,$pagMood){
	global $now,$todyU,$monLen,$mm,$selYear,$monthsNames;
	if($type<4){
		if($type==1){//day
			if($fil==0){
				$thisVal=$now-($now%86400);
			}else{				
				$thisVal=$fil;
			}
			$todyU=$thisVal;
			$valText=date('Y-m-d',$thisVal);
			$next_val=($thisVal+86400);
			$priv_val=($thisVal-86400);
		}
		if($type==2){//month
			if($fil==0){			
				$monLen=date('t');
				$month=date('m');
				$year=date('Y');
				$mm=strtotime($year.'-'.$month.'-1');		
			}else{
				$vv=explode('-',$fil);
				$year=$vv[0];
				$month=$vv[1];

				$mm=strtotime($year.'-'.$month.'-1');
				$monLen=date('t',$mm);			
			}
			if($month==12){$n_m=1;$n_y=$year+1;$b_m=$month-1;$b_y=$year;
			}else if($month==1){$n_m=$month+1;$n_y=$year;$b_m=12;$b_y=$year-1;
			}else{$n_m=$month+1;$n_y=$year;$b_m=$month-1;$b_y=$year;}
			$next_val=$n_y.'-'.$n_m;
			$priv_val=$b_y.'-'.$b_m;
			$thisVal=$year.'-'.$month;
			$valText=$monthsNames[intval($month)].'<span class="dHYear ff"> | '.$year.'</span>';
		}
		if($type==3){//year
			$selYear=$fil;	
			if($fil==0){$selYear=date('Y');}
			$next_val=$selYear+1;
			$priv_val=$selYear-1;
			$valText='<ff>'.$selYear.'</ff>';
		}
		if($type>0){
			$out='
			<div class="dateHead fl mg10v w100 ">
			<div class="fl dth dt_l" onclick="loadRep('.$page.','.$tab.',\''.$next_val.'\')" title="'.k_next.'"></div>';
			if($type==1){
				$out.='<div class="fl lh40 " fix="wp:80|h:40">
				<input class="repNavInput Date bord" value="'.$valText.'" onChange="loadRep('.$page.','.$tab.',this.value)"/></div>';
			}else{
				$out.='<div class="fl dHeader c_cont f1" onclick="loadRep('.$page.','.$tab.',\''.$thisVal.'\')" title="'.k_refresh.'">'.$valText.'</span></div>';
			}
			$out.='<div class="fr dth dt_r" onclick="loadRep('.$page.','.$tab.',\''.$priv_val.'\')" title="'.k_priv.'"></div>
			</div>';
		}
	}
	if($type==4){
		$df=pp($_POST['df'],'s');
		$dt=pp($_POST['dt'],'s');
		if(!$df)$df=date('Y-m-d');
		if(!$dt)$dt=date('Y-m-d');
		$out='<div class="w100 uLine">
		<div class=" f1 fs12 lh20""> '.k_from.' : </div>
		<div class="w100"><input type="text" id="df" class="Date " value="'.$df.'"/></div>
		<div class="f1 fs12 lh20"> '.k_to.' : </div>
		<div class=""><input type="text" id="dt" class="Date" value="'.$dt.'"/></div>
		<div class="ic40 icc1 ic40Txt ic40_search mg10v" onclick="reloadRep()"> '.k_send.'</div>
		</div>';
	}
	if($print){$out.='<div class="ic40 icc2 ic40_print ic40Txt mg10v" onclick="printReport(1)">'.k_prn_tbl.'</div>';}
	if($export){$out.='<div class="ic40 icc4 ic40_reload ic40Txt mg10v" onclick="printReport(2)">'.k_export.'</div>';}
	$out.='<div class="uLine cb"></div>';
    if($type<4){
        $out.='<div class="ic40 icc1 ic40_send ic40Txt mg10v refRep hide" refRep="1">'.k_send.'</div>';
    }
	if($pagMood==0){return $out;}
}
function reportStart($page_mood){
	global $page,$tab,$val,$fil,$df,$dt;
	if(isset($_POST['p']) && isset($_POST['t']) && isset($_POST['v']) && isset($_POST['f']) ){
		$page=pp($_POST['p']);
		$tab=pp($_POST['t']);
		$val=pp($_POST['v'],'s');
		$fil=pp($_POST['f'],'s');
		$filCh=explode('-',$fil);
		if(count($filCh)==3){$fil=strtotime($fil);}
		$df=pp($_POST['df'],'s');
		$dt=pp($_POST['dt'],'s');
		if(!$df){$df=date('Y-m-d');}
		if(!$dt){$dt=date('Y-m-d');}
        $type=pp($_POST['type']);
        $data=pp($_POST['data']);
        if($type && $data==0){
            echo repoNav($fil,$type,$page,$tab,1,1,$page_mood).'^
            <div class="f1 fs14 clr1 lh40">إضغط زر إرسال لإظهار التقرير</div>';
            exit;
        }
	}else{
		exit;
	}
}
function reportTapTitle($t,$title=''){
	global $title2,$fil,$monthsNames,$df,$dt;
	$out='';
	if($t=='day'){
		$title2=' '.k_dly_date.' ';
		if($fil==0){$d=date(' Y / m / d');}else{$d=date(' Y / m / d',$fil);}
		$out='<ff dir="ltr"> ( '.$d.' )</ff>';
	}
	if($t=='week'){
		if($fil==0){
			$week=getThisWeek();
			$startW=$week[0];
			$endW=$week[1];
		}else{			
			$startW=$fil;
			$endW=$startW+(86400*7);			
		}
		$title2=' '.k_wkly.' ';
		if($fil==0){$d=date(' Y / m / d');}else{$d=date(' Y / m / d',$fil);}
		$titleVal= k_from.' <ff dir="ltr">'.date('Y-m-d',$startW).'</ff> '.k_to.' <ff dir="ltr">'.date('Y-m-d',$endW).'</ff>';
	}
	if($t=='month'){
		$title2=' '.k_monthly_report.' ';
		if($fil==0){
			$out=' ( <ff>'.date('Y').' </ff> | '.$monthsNames[date('n')].' )';
		}else{
			$vv=explode('-',$fil);
			$year=$vv[0];
			$month=$vv[1];
			$out=' ( <ff>'.$year.' </ff> | '.$monthsNames[$month].' )';
		}
	}
	if($t=='year'){
		$title2=' '.k_annual_report.' ';
		if($fil==0){
			$out=' ( <ff>'.date('Y').'</ff> )';
		}else{
			$out=' ( <ff>'.$fil.'</ff> )';		
		}		
	}
	if($t=='all'){$title2=' '.k_general_report.' ';}
	if($t=='date'){
		if($df==$dt){
			$title2=' '.k_b_date.' <ff>'.$df.'</ff>';
		}else{
			$title2=' '.k_frm_dte.' <ff dir="ltr">'.$df.'</ff> '.k_tdate.' <ff dir="ltr">'.$dt.'</ff>';
		}
	}
	if($title){$title2=' '.$title.' ';}
	return $out;
}
function reportFormG($code){
	global $page_mood,$page,$tab,$val,$fil,$df,$dt;
	if($page_mood==0){
		return '
		<form id="R_form" method="post" action="" part="'.$code.'" target="_blank">
		<input type="hidden" name="p" value="'.$page.'" />
		<input type="hidden" name="t" value="'.$tab.'" />
		<input type="hidden" name="f" value="'.$fil.'" />
		<input type="hidden" name="v" value="'.$val.'" />
		<input type="hidden" name="df" value="'.$df.'" />
		<input type="hidden" name="dt" value="'.$dt.'" />
		</form>';
	}
}
function reportNorHeader(){
	global $m_path,$l_dir,$header;
	$out='';
	$style_file=styleFiles('P');
	$out.='<head><link rel="stylesheet" type="text/css" href="'.$m_path.$style_file.'"></head>
	<body dir="'.$l_dir.'">';			
	if(_set_14jk4yqz3w){
		$image=getImages(_set_14jk4yqz3w);
		$file=$image[0]['file'];
		$folder=$image[0]['folder'];
		list($w,$h)=getimagesize("sData/".$folder.$file);
		$fullfile=$m_path.'upi/'.$folder.$file;		
		$header='<div class="p5Header2"><div class="h_logo2 fr"><img src="'.$fullfile.'"  width="100%"/></div></div>';
	}
	return $out;
}
function reportNorHeader2($pageSize,$head,$reportTitle){
	global $header;
	$out='<div class="'.$pageSize.'"><div class="print_pageIn">';
	if($head){$out.= $header;}
	$out.='<div class="f1 fs16 lh40">'.$reportTitle.'</div>';
	return $out;
}
function reportExHeader($fileName){
	$fileName.='_'.date('Ymd-His');
	header('Pragma: public');
	header('Content-type: text/csv; charset=UTF-8');
	header( "Content-type: application/vnd.ms-excel" );	
	header( "Content-Disposition: attachment; filename=$fileName.xls");	
}
function reportFooter(){
	return '</div></div></body></html>
	<script>window.print();setTimeout(function(){window.close();},500);</script>';
}
function reportPageSet($page_mood,$fileName){
	global $reportTitle,$report_kWord,$title1,$title2,$titleVal,$title3,$pageSize,$head,$repCode,$breakC;
	$out='';	
	if($page_mood){		
		if($page_mood==1){$out.=reportNorHeader();}
		if($page_mood==1 || $page_mood==2){$breakC='';						
			$reportTitle=$report_kWord.$title1.$title2.$titleVal.$title3;
		}
		if($page_mood==1){$out.=reportNorHeader2($pageSize,$head,$reportTitle);}
		if($page_mood==2){$out.=reportExHeader($fileName);}
	}else{$out.=reportFormG($repCode);}
	return $out;
}
function repTitleShow(){
	global $page_mood,$reportTitle,$report_kWord,$title1,$title2,$titleVal,$title3;
	$out='';	
	if($page_mood==0){
		$reportTitle=$report_kWord.$title1.$title2.$titleVal.$title3;
		$out.='<div class="f1 fs16 lh40 uLine clr1">'.$reportTitle.'</div>';
	}
	return $out;
}
function existCol($table,$col){
	$res=mysql_q("SHOW COLUMNS FROM `$table` LIKE '$col' ");
	return mysql_n($res);
}
function timeToIntger($t){
	$out=0;
	if($t){
		$c=substr($t,0,2);
		$h=intval(substr($t,3,2));
		$m=intval(substr($t,6,2));
		if($c=='PM' && $h!=12){$h+=12;}
		$out=($h*3600)+($m*60);
	}
	return $out;
}
function clocFromstr($s){
	$out='-';
	$h='00';
	$m='00';
	$c='AM';
	if($s){
		if($s>=3600){
			$h=intval($s/3600);
			$s=$s-($h*3600);
		}
		if($s){
			$m=intval($s/60);			
		}
		if($h>12){$c='PM';$h-=12;}
		if($h==12){$c='PM';}
		if($h<10 && $h!=0){$h='0'.$h;}
		
		if($m<10 && $m!=0){$m='0'.$m;}
		$out=$c.' '.$h.':'.$m;
	}
	return $out; 
}
function loadAddons(){
	global $thisUser,$m_path,$l_dir,$userSubType;
	$clinic=$userSubType;
	$sel=str_replace(',',"','",get_val_con('cln_x_addons_per','addons'," user='$thisUser'"));
	if($sel){
		$addons=get_vals('cln_m_addons','addon'," code in('$sel') and ((clinic=0 AND service=0) OR (clinic='$clinic')) and act=1",'arr');
		return $addons;		
	}else{
		echo script('addons_ex=0');
	}
}
function gnrSysAlert($id){
	global $now;
	$q='';
	$a=getRec('_sys_alerts',$id);
	if($a['r']){
		$g=$a['grp'];
		$u=$a['users'];
		if($u){
			$u_cods=str_replace(',',"','",$u);
			$q=" and code IN('$u_cods')";
		}else if($g){
			$g_cods=str_replace(',',"','",$g);
			$q=" and grp_code IN('$g_cods')";
		}
		$sql="select id from _users where act=1 $q ";
		$res=mysql_q($sql);
		while($r=mysql_f($res)){
			$u=$r['id'];
			mysql_q("INSERT INTO _sys_alerts_items (`sa_id`,`user`,`date`)values('$id','$u','$now')");
		}
	}
}
function delSysAlert($id){
	mysql_q("DELETE from _sys_alerts_items where `sa_id` NOT IN (select id from _sys_alerts)");
}
function setReportPage($code,$page,$tab,$fillter,$data,$chart='',$autoLoad=1){
	global $lg,$def_title,$m_path;
	$out='';
	if($chart!=''){
		$out.='<script src="'.$m_path.'library/highstock/js/highstock.js"></script> 
		<script src="'.$m_path.'library/highstock/js/modules/exporting.js"></script>
		<script src="<?=$m_path?>library/highstock/js/highcharts-more.js"></script>';
	}
	$out.='
	<div class="centerSideInFull of">
        <div class="fxg h100 " fxg="gtc:300px 1fr|gtr:1fr"> 
            <div class="r_bord of cbg4">
                <div class="lh40 uLine cbg2 clrw">
                    <div class="fr ic40x br0 icc2 ic40_ref" refRep title="'.k_refresh.'"></div>
                    <div class="f1 fs16 lh40 pd10 clrw">'.$def_title.'</div>
                </div>
                <div class="pd10 ofx so">
                    <div class="rep_head fl w100">
                        <select rpSel class="mg5v">';
                            foreach($data as $k=> $v){
                                $sel='';
                                $type=0;
                                if(isset($v[2])){$type=$v[2];}
                                if($k==$tab){$sel=' selected ';}
                                $out.='<option value="'.$k.'" f="'.$v[1].'" t="'.$type.'" '.$sel.' >'.$v[0].'</option>';
                            }
                        $out.='</select>
                        <div id="repFilH" class="mg5v">'.$fillter.'</div>
                        <div id="rep_header_add" class="ropTool cb lh60"></div>
                    </div>
                </div>
            </div>	
            <div id="reportCont" class="ofxy so pd10 h100"></div>
            
        </div>
	</div>
	<script>
	sezPage=\''.$code.'_Report\';repCode=\''.$code.'\';
	$(document).ready(function(){setReportEl('.$page.','.$tab.','.$autoLoad.' );})
	</script>';
	return $out;
}
function monthSelect($table,$column,$filed,$limit=24,$action=''){
    global $now,$monthsNames;
    $thisMonth=date('U',$now);
    $date=get_val_con($table,$column,"id>0","order by `$column` ASC");
    $thisMonthN=date('Ym',$now);
    $firstMonthN=date('Ym',$date);
    $exMonth=$thisMonthN-$firstMonthN;
    if($exMonth<$limit){$limit=$exMonth;}
    $out='<select name="'.$filed.'" '.$action.'>';
    for($i=0;$i<$limit;$i++){
        $m=$thisMonth-($i*(86400*30.5));
        $name=date('Y-m',$m).' - '.$monthsNames[date('n',$m)];
        $out.='<option value="'.$m.'">'.$name.'</option>';
    }
    $out.='</select>';
    return $out;
}
function yearsSelect($table,$column,$filed,$limit=10,$action=''){
    global $now,$monthsNames;
    $thisYear=date('Y',$now);
    $date=get_val_con($table,$column,"id>0","order by `$column` ASC");    
    $firstYear=date('Y',$date);
    $exYear=$thisYear-$firstYear;
    //if($exYear<$limit){$limit=$exMonth;}
    if($limit==0){$limit=1;}
    $out='<select name="'.$filed.'" '.$action.'>';
    for($i=0;$i<10;$i++){        
        $y=$thisYear-$i;
        $out.='<option value="'.$y.'">'.$y.'</option>';
    }
    $out.='</select>';
    return $out;
}
function deleteDir($dir){
    if(!file_exists($dir)){return true;}
    if(!is_dir($dir)){return unlink($dir);}
    foreach(scandir($dir) as $item){
        if($item !='.' && $item!='..'){
            if(!deleteDir($dir.DIRECTORY_SEPARATOR.$item)){return false;}
        }
    }
    return rmdir($dir);
}
/**************************************/
function showTpBlcs($data){
    $out='';
    $arr=json_decode($data,true);
    foreach($arr as $val){
        $rows=count($val);
        $rowType=$val[0]['rt'];
        $fR=0;
        if(!$rowType){
            $rowType=str_repeat('1',$rows);
            $fR=1;
        }
        $out.='<div tp_r="'.($rows-1).'" tp_type="'.$rowType.'" >
        <div class="reSoHold" title="'.k_ord_lst.'"><div></div></div>';
        foreach($val as $k=>$val2){
            if($k || $fR){
                $r=rand(10000,99999);
                $type='';
                if($val2['type']){$type=$val2['type'];}                
                $out.='<div tpBlcCode="tp_'.$r.'" tpType="'.$type.'" s="0">';
                if($type){
                    $out.='<div>';                    
                    $title=$val2['ptTitle'];
                    $text=$val2['ptText'];
                    if($type=='h2' || $type=='h3' || $type=='h4' ){
                        if($title){
                            $out.='<'.$type.'>'.$title.'</'.$type.'>';
                        }else{
                            $out.=emptyTp($type);
                        }
                    }else if($type=='p'){
                        if($text){
                            $out.='<p>'.nl2br($text).'</p>'; 
                        }else{
                            $out.=emptyTp($type);
                        }
                    }else if($type=='hp'){
                        if($title || $text){
                            $out.='<h2>'.$title.'</h2>';
                            $out.='<p>'.nl2br($text).'</p>'; 
                        }else{
                            $out.=emptyTp($type);
                        }
                    }else if($type=='img'){
                        $id=$val2['id'];
                        $image=$val2['src'];
                        $link=$val2['link'];
                        if($image){
                            $out.='<img src="'.$image.'" no="'.$id.'" width="100%" />'; 
                            if($link){
                                $out.='<a href="'.$link.'" class="f1 clrw" target="blank"><div class="f1 fs14 icc22 clrw TC">الرابط</div></a>';
                            }
                        }else{
                            $out.=emptyTp($type);
                        }
                    }
                    $out.='
                    </div>
                    <div class="t_bord pd5v">
                        <div class="fr i30 i30_edit" title="'.k_edit.'" editTp></div>
                        <div class="fr i30 i30_x" title="'.k_delete.'" delTp></div>
                    </div>';
                }
                $out.='</div>';                
            }
        }
        $out.='<div><div class="i40 i40_del" title="'.k_delete.'" tpDelRow></div></div></div>';        
    }
    return $out;
 }
function showTpBlcsTemp($data){
    $out='';
    $arr=json_decode($data,true);
    foreach($arr as $val){
        $rows=count($val);
        $rowType=$val[0]['rt'];
        $fR=0;
        if(!$rowType){
            $rowType=str_repeat('1',$rows);
            $fR=1;
        }
        $out.='<div tp_r="'.($rows-1).'" tp_type="'.$rowType.'">';
        foreach($val as $k=>$val2){
            if($k || $fR){
                $r=rand(10000,99999);
                $type='';
                if($val2['type']){$type=$val2['type'];}                
                $out.='<div tpBlcCode="tp_'.$r.'" tpType="'.$type.'" s="0">';
                if($type){$out.=emptyTp($type);}
                $out.='</div>';                
            }
        }
        $out.='</div>'; 
        
    }
    return $out;
 }
function tpEditorDemo($data){
    $out='';
    $arr=json_decode($data,true);
    foreach($arr as $val){
        $rows=count($val);
        $out.='<div tp_t="'.$val[0]['rt'].'">';
        foreach($val as $k=>$val2){
            if($k){
                $r=rand(10000,99999);
                $type='';
                if($val2['type']){$type=$val2['type'];}
                $out.='<div tpBlc tp="'.$type.'" class="f1">';            
                $title=$val2['ptTitle'];
                $text=$val2['ptText'];
                if($type){
                    if($type=='h2' || $type=='h3' || $type=='h4' ){
                        $out.='<'.$type.'>'.$title.'</'.$type.'>';
                    }else if($type=='p'){
                        $out.='<p>'.nl2br($text).'</p>';        
                    }else if($type=='hp'){
                        $out.='<h2>'.$title.'</h2>';
                        $out.='<p>'.nl2br($text).'</p>';        
                    }else if($type=='img'){
                        $id=$val2['id'];
                        $image=$val2['src'];
                        $link=$val2['link'];
                        if($link){$out.='<a href="'.$link.'" target="blank"/> ';}
                        $out.='<img src="'.$image.'" no="'.$id.'" width="100%"/> ';
                        if($link){$out.='</a> ';}
                    }
                }
                $out.='</div>';
            }            
        }
        $out.='</div>'; 
    }
    return $out;
 }
/*************************VI**************************************/
function imgViewer($ids,$w=120,$h=80){
	global $m_path,$f_path,$folderBack;
	$photos=getImages($ids);
	$n=count($photos);
	$x=0;
    $out='';
	$image='';
	if($n>0){
        foreach($photos as $ph){
            $bf=$folderBack;
            $file=$ph['file'];
            $ex=$ph['ex'];
            $folder=$ph['folder'];
            $this_file=$m_path.'upi/'.$ph['folder'].$file;
            $r_file=$bf."sData/".$ph['folder'].$file;	
            $mainSrc=$bf.'sData/'.$ph['folder'].$file;
            $resizeSrc=$bf.'sData/resize/i'.$w.$h.$file;
            if(file_exists($mainSrc)){
                $image=Croping($file,"sData/".$folder,$w,$h,'i',$m_path.'imup/',0,'sData/resize/',$ex);                
                $out.='<div iv="'.$file.'"><div></div><img src="'.$image.'" width="100%" /></div>';
            }else{$x=1;}
        }
        if($out){$out='<div class="imgViewer" imgViewer>'.$out.'</div>';}
	}
	return $out;
}
function emptyTp($type){
    return '<div emptyTp="'.$type.'"></div>'; 
}
/*************************obj List Input**************************************/
function objListInp($data,$val=''){
    global $lg_s,$lg_n,$lg;
    $name=$data[1];
    $type=$data[2];
    $set=$data[3];
    $lang=$data[4];
    $out='';
    switch($type){
        case 'text':
            if($lang){
                foreach($lg_s as $k=>$v){
                    $tVal=$val[$v];                    
                    $out.='
                    <div class="TL mg5v">
                        <input type="text" placeholder="'.$lg_n[$k].'" lg="'.$v.'" value="'.$tVal.'" t fix="w:150"/>
                    </div>';
                }                
            }else{
                $out='<input type="text" value="'.$val.'"/>';
            }
        break;
        case 'textarea':
            $out='<texarea>'.$val.'</texarea>';
        break;
        case 'act':
            $c='';
            if($val==1){$c='checked';}
            $out='<input type="checkbox" value="'.$val.'" '.$c.'/>';
        break;
        case 'list':
            $data=explode(',',$set);
            $out.='<select>';
            foreach($data as $k=>$v){
                $vv=explode(':',$v);
                $sel='';
                if($val==$v[0]){$sel='selected';}
                $out.='<option value="'.$vv[0].'" '.$sel.'>'.$vv[1].'</option>';
            }
            $out.='<select>';
        break;
    }
    if($out){$out='<div objInpType="'.$type.'" objInpName="'.$name.'">'.$out.'</div>';}
    return $out;
}
function objListInpView($code,$val){
    global $objectListSetFileds,$lg_s,$lg_n,$lg;
    $out='';
    $val=str_replace("'",'"',$val);
    $val_arr=json_decode($val,true);        
    if($val){
        foreach($val_arr as $k=>$val){
            $titleTxt='';
            foreach($lg_s as $k=>$v){                
                $titleTxt.='('.$v.':'.$val['title'][$v].')';
            }
            $out.=$val['id'].':'.$titleTxt.':';
            foreach($objectListSetFileds[$code] as $k=>$v){
                $thisVal=$val['objAdd'][$v[1]];
                $type=$v[2];
                if($type=='list'){
                    $vv=explode(',',$v[3]);
                    foreach($vv as $k=>$v2){
                        $v3=explode(':',$v2);
                        if($v3[0]==$thisVal){
                            $thisVal=$v3[1];
                        }
                    }
                }
                if($type=='text' && $v[4]==1){
                    $addTxt='';
                    foreach($lg_s as $k=>$vv){                
                        $addTxt.='('.$vv.':'.$val['objAdd'][$v[1]][$vv].')';
                    }
                    $thisVal= $addTxt;
                }
                $out.=':'.$thisVal;
            }
            $out.='<br>';
        }
    }
    return $out; 
}
function delSpace($str){return str_replace(' ','-',$str);}
/*********************Notification*************/
function sysNotiSend($code,$rec_id,$sender,$users,$description=''){
    global $lg;
    $set=getRecCon('_sys_notification_set',"code='$code'");
    if($set['r']){
        $title=$set['title_'.$lg];
        $type=$set['type'];
        $sub_type=$set['sub_type'];
        $show_sender=$set['show_sender'];
        if(!is_array($users)){
            $users=explode(',',$users);
        }
        foreach($users as $user){
            sysNotiSendDo($code,$rec_id,$sender,$user,$description);
        }
    }
}
function sysNotiSendDo($code,$rec_id,$sender,$receiver,$description){
    global $now;
    mysql_q("INSERT INTO _sys_notification (`noti_code`,`description`,`rec_id`,`sender`,`receiver`,`date`) values ('$code','$description','$rec_id','$sender','$receiver','$now')");
    showNoti($receiver);
}
function showNoti($user){        
    if(getTotalCo('_sys_notification_live',"id='$user'")){
        mysql_q("UPDATE _sys_notification_live SET no=(no+1) where id='$user'");
    }else{        
        mysql_q("INSERT INTO _sys_notification_live (`id`,`no`) values('$user',1)");
    }    
}
function first_end_id($table,$s,$limit,$column){
	$out=[0,0,0];
	$sql="select $column from $table where $column>$s order by $column ASC limit $limit ";	
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$out[2]=$rows;
	
	if($rows){
		$c = 0;
		while ($r = mysqli_fetch_array($res)) {
			if($c==0){
				$out[0]=$r[$column];
				$out[1]=$r[$column];
			}		
			$out[1]=$r[$column];		
			$c++;
		}	
	}
	return $out;
}
function deleleBuckup($id,$type){
	global $folderBack;
	$dir= $folderBack.'.backup/'.$id.'/';	
	if($type==1){//full delete 
		deleteDir($dir);
	}
	if($type==2){//delete the restor files
		@unlink($dir.'_info_res.php');
		@unlink($dir.'_tables_res.php');
	}
}

?>
<? session_start();
$folderBack='';
if($_GET['root']){
    $folderBack=intval($_GET['root']);
    $folderBack=str_repeat('../',$folderBack);
}
include($folderBack."__sys/dbc.php");
include($folderBack."__main/define.php");
include($folderBack."__sys/f_funs.php");
include($folderBack.'_gnr/funs.php');
include($folderBack.'_dts/funs.php');
$lang_data=checkLang();
$lg=$lang_data[0];//main languge
$l_dir=$lang_data[1];//defult diratoin (ltr or rtl)
$lg_s=$lang_data[2];// active lang list code ar en sp
$lg_n=$lang_data[3];// active lang list text Arabic English
$lg_s_f=$lang_data[4];// all lang list code ar en sp
$lg_n_f=$lang_data[5];// all lang list text Arabic English
$lg_dir=$lang_data[6];
if($l_dir=="ltr"){define('k_align','left');	define('k_Xalign','right');}else{define('k_align','right');define('k_Xalign','left');}
include($folderBack."__sys/cssSet.php");
include($folderBack."__main/lang/lang_k_$lg.php");
include($folderBack."__sys/lang/lang_k_$lg.php");
include($folderBack."__sys/funs.php");
include($folderBack."__sys/funs_co.php");
include($folderBack.'__main/funs.php');
include($folderBack."__sys/define.php");?>
<!doctype html>
<html lang="<?=$lg?>" class="no-js">
<head>
<meta charset="utf-8">
<title><?=_info_7dvjz4qg9g?></title>
<meta content='width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;' name='viewport' />
<link href="<?=$m_path?>library/jquery/css/jq-ui.css" rel="stylesheet" type="text/css"/>
<link href="<?=$m_path?>library/jquery/css/jquery.datetimepicker.css" rel="stylesheet" type="text/css"/>
<? $style_file=styleFiles();?>
<link href="<?=$m_path?>sys<?=$style_file?>" rel="stylesheet" type="text/css" />
<link href="<?=$m_path?>gnr<?=$style_file?>" rel="stylesheet" type="text/css" />
<link href="<?=$m_path?>cln<?=$style_file?>" rel="stylesheet" type="text/css" />
<? $fileName=$fileName='Lg'.$lg.'Mv'.$ProVer.'.js';?>
<script src="<?=$m_path.$fileName?>"></script>
<? $fileName=$fileName='Lg'.$lg.'Sv'.$ProVer.'.js';?>
<script src="<?=$m_path.$fileName?>"></script>
<script src="<?=$m_path?>library/jquery/jq3.6.js"></script>
<script src="<?=$m_path?>library/jquery/jq-ui.js"></script>
</head>	
<body style="background-color:#fff">
<div class="m_bgx"></div>
<div class="b_bgx">
<table class="xdataTable" cellspacing="5" cellpadding="2" width="100%">
<tr>
	<td class="f1 TC fontvw1" bgcolor="#cccccc" width="500">بالانتظار</td>
	<td class="f1 TC fontvw1" bgcolor="#fc5e27" width="500"><?=k_emergency?></td>
	<td class="f1 TC fontvw1" bgcolor="<?=$clr6?>" width="500">بالمعاينة</td>
	<td class="f1 TC fontvw1" bgcolor="#ffff33" width="500"><?=k_late?></td>
	<td class="f1 TC fontvw1" bgcolor="<?=$clr5?>" width="500">دخول</td>
	<td class="f1 TC fontvw1" bgcolor="#63bdde" width="500">المواعيد</td>
	<td width="10" class="ws"><ff dir="ltr" class="colr1" id="ref_time"><?=date('Y-m-d H:i',$now);?></ff></td>
</tr>
</table>
<style>
.fontvw1{font-size: 1.2vmax;}
.fontvw2{font-size: 2.5vmax;}
</style>
<? if(_set_srvxnt0aeu){?><div class="ad_po TC"><img src="ads/logo.png"/></div><? }?>
</div><?
if(isset($_GET['s'])){
	echo '<!--***-->';
	resetRles();
	$x_clinic=array();
	$sql="select clic from gnr_x_arc_stop_clinic where e_date=0";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){while($r=mysql_f($res)){array_push($x_clinic,$r['clic']);}}
	/***********************************************/
	$sql2="select clic,status,vis,date,fast,no from gnr_x_roles where status < 4 order by fast DESC ,no ASC";
	$res2=mysql_q($sql2);
	$rows2=mysql_n($res2);	
	$r_arr=array();
	while($r2=mysql_f($res2)){
		array_push($r_arr,$r2);	
	}
	$sql="select * from gnr_m_clinics where act=1 order by ord ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$i=0;
		echo '<section class="c_cont">';
		while($r=mysql_f($res)){
			$c_id=$r['id'];
			$rr=0;			
			foreach($r_arr as $r22){
				$clic=$r22['clic'];				
				if($c_id==$clic){$rr++;}
			}
			$sss='';			
			if($rr==0){$sss=' style=" background-color:#ccc; " ';}
			if(in_array($c_id,$x_clinic)){$sss='style=" background-color:#fbb; "';}
			if($rr>0){								
				echo '<div class="Xcolum2 fl" '.$sss.'><div class="cTot">'.$rr.'</div>';				
				$photo=$r['photo'];
				$code=$r['code'];				
				$name=$r['name_'.$lg];			
				$ph_src='';
				$ph_src=viewImage($photo,0,150,150,'img','clinic.png');				
				echo '<div b '.$sss.'>'.$ph_src.'</div>';	
				echo '<div a ><div class="f1 ro180">'.$name.'</div></div>';				
				echo '<div c >';
				if($rows2){
					$sevisTimeAll=0;
					foreach($r_arr as $r22){
						$clic=$r22['clic'];
						$status=$r22['status'];
						$vis=$r22['vis'];
						$date=$r22['date'];
						$fast=$r22['fast'];
						$statusCol=$status;						
						if($c_id==$clic){							
							$no=$r22['no'];
							$textCode=$code.'-'.$no;
							if($fast && $status==0){$statusCol='9'.$fast;}
							if($fast==2){$textCode=clockStr($no);}							
							echo '<div rr sr="s'.$statusCol.'">';							
							if($no==0){
								$sevisTime=$date-$now;
								echo '<div r_c class="fontvw2">'.dateToTimeS2($date-$now).'</div>';
							}else{
								echo '<div r_a2 class="fontvw2">'.$textCode.'</div>';
							}
							echo '</div>';
						}				
					}
				}
				echo '</div>';				
				echo '&nbsp;</div>';
			}
		}
		echo '</section>';
	}echo '<!--***-->'.date('Y-m-d H:i',$now);	
}else{
	echo '<div id="l"></div>';?>    
	<script>
		$(document).ready(function(e){rr();rrr();})		
        function rr(){setTimeout(function(){rr();rrr();},5000);}
        function rrr(){$.post("zz",{}, function(data){d=data.split('<!--***-->');
		$('#l').html(d[1]);$('#ref_time').html(d[2]);rsePage();})}
        function rsePage(){
			www=$(window).width(); hhh=$(window).height();
            $('.Xcolum2').height(hhh);
			ll=$('.Xcolum2').length
			xw=parseInt((www-ll-1)/ll);
			if(xw>80)xw=80;
			$('.Xcolum2').width(xw);
			$('.Xcolum2 div[aa]').height(xw);
			$('.Xcolum2 div[aa]').css('line-height',xw+'px');
			$('.m_bgx').height(xw+6);			
			$('.Xcolum2 div[b]').height(xw);
			$('.Xcolum2 div[a] div').height(xw);
			$('.Xcolum2 div[a] div').css('line-height',xw+'px');
        }
    </script><? 
}?>
</body>
</html>
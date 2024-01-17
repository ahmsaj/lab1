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
include($folderBack."__sys/define.php");
if(isset($_POST['g'])){
	$g=pp($_POST['g']);			
	$gg=$_SESSION['actClinic'];	
	/***********************************************/
	$x_clinic=array();
	$sql="select clic from gnr_x_arc_stop_clinic where e_date=0";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){while($r=mysql_f($res)){array_push($x_clinic,$r['clic']);};}
	$q='';
	$recs=array();
	if(_set_9srs6l9zw4==0){$q=' and fast in(0,2) ';}
	$sql="select * from gnr_x_roles where status < 4 and clic IN($gg) $q order by fast DESC ,no ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);			
	while($r=mysql_f($res)){
		//array_push($r_arr,$r2);	
		$clic=$r['clic'];
		$status=$r['status'];
		$vis=$r['vis'];
		$date=$r['date'];
		$fast=$r['fast'];
		$statusCol=$status;							
							
		$no=$r['no'];
		
		$textCode=$code.'-'.$no;
		if($fast==2){$no=clockStr($no);}
		if($no==0){$status=9;$no=dateToTimeS2($date-$now);}		
		array_push($recs,'{"c":'.$clic.',"n":"'.$no.'","s":'.$status.',"f":'.$fast.'}');
	}
	$out='[['.implode(',',$x_clinic).'],['.implode(',',$recs).']]';	
	echo $out;
	
}else{?>
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
	<!--<link href="<?=$m_path?>_cln/css/<?=$style_file?>" rel="stylesheet" type="text/css" />-->
	<link href="<?=$m_path?>gnr<?=$style_file?>" rel="stylesheet" type="text/css" />
	<? $fileName=$fileName='Lg'.$lg.'Mv'.$ProVer.'.js';?>
    <script src="<?=$m_path.$fileName?>"></script>
    <? $fileName=$fileName='Lg'.$lg.'Sv'.$ProVer.'.js';?>
    <script src="<?=$m_path.$fileName?>"></script>
	<script src="<?=$m_path?>library/jquery/jq3.6.js"></script>
	<script src="<?=$m_path?>library/jquery/jq-ui.js"></script>
<style>
	.roleTable{border-collapse:collapse;}
	.roleTable td{
		height:40px;
		border-bottom:1px solid #ccc;	
		text-align:center;
	}
	.s1_clinic_name_x{
		width:180px;
		height:100%;
		line-height:54px;
		padding: 0px;
		text-align:center;
		font-size:16px;
		color:#fff;
		overflow: hidden;			
	}
	.gruopBox{
		border:1px #999 solid;
		width:300px;
		text-align:center;
		margin:10px;
		border-radius:5px;
		cursor:pointer;	
	}
	.gruopBox:hover .gruopTitle{background-color:<?=$clr1111?>;}
	.gruopBox:hover .clinics_gro{background-color:#ccc;}
	.gruopTitle{
		color:#fff;
		background-color:<?=$clr1?>;
		border-radius:2px 2px 0px 0px;
	}
	.xdataTable td{
		height:40px;
		line-height:40px;
		min-width:20px;
		border-radius:5px;
		color: #000;
		/*text-shadow:#000 0px 0px 2px ;*/
	}
	.clinics_gro{padding:10px;background-color:#eee;border-radius:0px 0px 2px 2px; min-height:40px;}
	.s1_xc_icon{width:42px; padding:5px; background-color: #eee;}
	.s1_Xcolum{
		width:30px;
		max-width: 240px;
	}
	.s_Xcolum[show='0']{
		display: none
	}
	.s1_xx_header{
		margin:2px;
		height:60px;
		border:1px #999 solid;
	}
	.s1_clinic_name{
		height:60px;
		line-height:60px;
		padding: 0px;
		text-align:center;
		font-size:20px;
		color:#fff;
		overflow: hidden;
	}
	.s1_XcolumIn{
		margin:2px;
		margin-top:4px;	
		height:100%;
		border:1px #999 solid;
		background-color:#f5f5f5;
		overflow: hidden;
	}
	/*.s1_XcolumIn > div{width:100%;}*/
	.s1_xcn{ width:50%;}
	.s1_xcn div{ width:100%;}
	.s1_xcn2{ width:100%;}
	.s2_xcn2{
		height: 55px;
		width: 200%;
		overflow: hidden;			
	}


	.s1_titleInXC{
		text-align:center;	
		font-weight:bold;			
		overflow:hidden;
		font-size:20px;
	}
	.s1_InXC1{background-color:#ccc;}
	.s1_InXC2{background-color:#ee0;}		
		
	div[s1_rr]{	
		text-align:center;	
		font-weight:bold;	
		border-bottom:1px #ccc solid;
		overflow:hidden;
		width: 100%;
	}
	div[s1_rr]  div{	
		font-family: ImpactArial Black,Palatino,Verdana
	}
	div[s1_rr] div[r_a]{
		font-size:40px;	
		height:60px;
		line-height:60px;
	}
	div[s1_rr] div[r_a] span{line-height:10px;font-family:'ff';}
	div[s1_rr] div[r_b]{font-size:16px;}
	div[s1_rr] div[r_c]{font-weight:bold;color:#fff;}
	/***************************/
	div[s2_rr]{	
		text-align:center;	
		font-weight:bold;	
		border-<?=$Xalign?>:1px #ccc solid;
		overflow:hidden;
		width:120px;
		height: 60px;
		line-height: 54px;
		float: <?=$align?>;
	}
	div[s2_rr]  div{	
		font-family: ImpactArial Black,Palatino,Verdana;
		font-size: 24px;
	}
	div[s1_rr] div[r_a]{
		font-size:40px;	
		height:60px;
		line-height:60px;
	}
	div[s1_rr] div[r_a] span{line-height:10px;font-family:'ff';}
	div[s1_rr] div[r_b]{font-size:16px;}
	div[s1_rr] div[r_c]{font-weight:bold;color:#fff;}
	/***************************/
	div[s1_sr=s0]{background-color:<?=$clr4?>;}
	div[s1_sr=s1]{
		background-color:<?=$clr5?>;	
		animation-name:changeColor;
		animation-duration:0.3s;
		animation-iteration-count:infinite;
	}
	div[s1_sr=s2]{background-color:<?=$clr6?>;}
	div[s1_sr=s3]{background-color:#FF3;}
	div[s1_sr=s9]{background-color:<?=$clr5?>;}
	div[s1_sr=s91]{background-color:#fc5e27;}
	div[s1_sr=s92]{background-color:#63bdde;}
</style>
	</head>	
	<body style="background-color:#fff"><? 
	if(isset($_GET['c'])){
		resetRles();
		$g=$_GET['c'];
		$fontP=0;
		list($gg,$late,$style)=get_val('cln_m_groups','clinics,late,style',$g);		
		$_SESSION['actClinic']=$gg;
		$sql="select * from gnr_m_clinics where act=1 and id IN($gg) order by ord ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			echo '<div class="sect ofx so">';
			if($style==1){?><section class="c_cont"><?}
			if($style==2){?><table border="0" class="roleTable" width="100%" cellpadding="0" cellspacing="0"><?}
			while($r=mysql_f($res)){
				$c_id=$r['id'];
				$photo=$r['photo'];
				$code=$r['code'];				
				$name=$r['name_'.$lg];				
				$ph_src=viewImage($photo,0,60,60,'img','clinic.png');
				$rr=0;				
				if($style==1){?>
					<div class="s1_Xcolum s_Xcolum fl" no="<?=$c_id?>" show="0">
						<div class="s1_xx_header">
							<div class="s1_clinic_name f1 cbg3 clName ws" code<?=$c_id?>="<?=$code?>">
								<?=$name?>
							</div>
						</div>
						<div class="s1_XcolumIn">
							<? if($late==1){
								$fontP=7;?>
								<div class="fl s1_xcn">
									<div class="s1_titleInXC f1 fs16 TC s1_InXC1 lh60"><?=k_waiting?></div>
									<div class="fl s1_xcn" w></div>
								</div>

								<div class="fl s1_xcn">
									<div class="s1_titleInXC f1 fs16 TC s1_InXC2 lh60"><?=k_late?></div>
									<div class="fl s1_xcn" l></div>
								</div><?
							}else{
								$fontP=4;?>
								<div class="fl s1_xcn2">								
									<div w></div>
								</div><?
							}?>

						</div>
					</div>
					<?
				}
				if($style==2){?>
					<tr class="s2_Xcolum s_Xcolum" no="<?=$c_id?>" show="0">
						<td width="40"><div class="s1_xc_icon"><?=$ph_src?></div></td>						
						<td width="80"><div class="s1_clinic_name_x f1 cbg3 clName "  code<?=$c_id?>="<?=$code?>"><?=$name?></div></td>
						<td><div class="s2_xcn2"><div w></div></div></td>
					</tr><?
				}
			}
			if($style==2){?></table><?}
			if($style==1){?></section><?}
			echo '</div>';
		}?>
		<div class="b_bgx">
		<table class="xdataTable" cellspacing="5" cellpadding="0" width="100%">
			<tr>
				<td class="f1 TC fontvw1" bgcolor="#cccccc" width="500"><?=k_in_wait?></td>
				<td class="f1 TC fontvw1" bgcolor="#fc5e27" width="500"><?=k_emergency?></td>
				<td class="f1 TC fontvw1" bgcolor="<?=$clr6?>" width="500"><?=k_insid_cln?></td>
				<td class="f1 TC fontvw1" bgcolor="#ffff33" width="500"><?=k_late?></td>
				<td class="f1 TC fontvw1" bgcolor="<?=$clr5?>" width="500"><?=k_wnt_ent?></td>
				<td class="f1 TC fontvw1" bgcolor="#63bdde" width="500">المواعيد</td>
			</tr>
		</table>
		<? if(_set_srvxnt0aeu){?><div class="ad_po TC"><img src="ads/logo.png"/></div><? }?>
		</div>
		
		<script>     
			$(document).ready(function(e){rr();rrr();rsePage();})		
			function rr(){setTimeout(function(){rr();rrr();},3000);}
			function rrr(){
				g=<?=$_GET['c']?>;
				st=<?=$style?>;
				$.post("../xx",{g:g},function(data){
					$('.s_Xcolum[no] div[w]').html('');
					$('.s_Xcolum[no] div[l]').html('');
					$('.s_Xcolum[no]').attr('show','0');
					var obj = jQuery.parseJSON(data);
					$('.clName').removeClass('cbg5');					
					$.each(obj[0], function(){
						$('.clName[code'+this+']').addClass('cbg5');						
					})
					$.each( obj[1], function() {
						c=this.c;
						n=this.n;
						s=this.s;
						f=this.f;
						sc=s;							
						if(f&&s==0){sc='9'+f;}
						if(n==0){sc=9;}
						code='';
						rType='w';
						if(s==3 && st==1){rType='l';}
						if(f!=2 && s!=9){code=$('.clName[code'+c+']').attr('code'+c)+'-';}
						txt='<div s'+st+'_rr s1_sr="s'+sc+'"><div r_a>'+code+n+'</div></div>';
						$('.s_Xcolum[no='+c+'] div['+rType+']').append(txt);
						$('.s_Xcolum[no='+c+']').attr('show','1');
					})
					rsePage();
				})
			}
			function rsePage(){
				www=$(window).width(); hhh=$(window).height();
				$('.s1_Xcolum').height(hhh-50);
				$('.s1_XcolumIn').height(hhh-125)
				ll=$('.s1_Xcolum[show=1]').length;				
				xw=parseInt((www-ll-1)/ll);				
				$('.s1_Xcolum').width(xw);
				fs=Math.min((xw/<?=$fontP?>),34);
				fs2=Math.min((xw/4),20);
				fs3=Math.min((xw/9),16);
				fs4=Math.min((xw/4),20);
				$('[s1_rr] div').css('font-size',fs+'px');
				$('.s1_clinic_name').css('font-size',fs2+'px');
				$('.s1_InXC1 ,.s1_InXC2').css('font-size',fs3+'px');
				$('.xdataTable td').css('font-size',fs4+'px');
				$('.sect').height(hhh-50);
				
			}
		</script><? 
	}else{
		echo '<div class="c_cont">';
		$sql="select * from cln_m_groups ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$i=0;
			while($r=mysql_f($res)){
				$g_id=$r['id'];
				$name=$r['name'];
				$clinics=$r['clinics'];
				echo '<div class="gruopBox fl" onclick="document.location=\'x/'.$g_id.'\'">';			
				echo '<div class="gruopTitle f1 fs18 lh40">'.$name.'</div>';
				if($clinics){
					$names='';
					$sql2="select * from gnr_m_clinics where id IN($clinics)";
					$res2=mysql_q($sql2);
					$rows2=mysql_n($res2);
					if($rows2>0){
						while($r2=mysql_f($res2)){
							$name2=$r2['name_ar'];
							if($names){$names.=' :: ';}
							$names.=$name2;
						}
					}
					echo '<div class="f1 fs14 clinics_gro f1">'.$names.'</div>';
				}
				echo '</div>';
			}
		}
		echo '</div>';
	}?>
	</body>
	</html><?
}?>

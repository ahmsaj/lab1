<? include("../../__sys/prcds/ajax_header.php");
$sql="select * from dts_x_dates where status=10 order by reg_user DESC , date ASC";
$res=mysql_q($sql);
echo $rows=mysql_n($res);
echo '^';
if($rows){?>
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
	<tr>
		<th width="120">وقت الحجز</th>
		<th>مصدر الحجز</th>
		<th>المريض</th>		
		<th>المراجع</th>
		<th width="40"></th>		
	</tr><? 
	$infoS=1;
	while($r=mysql_f($res)){
		$d_id=$r['id'];
		$patient=$r['patient'];
		$p_type=$r['p_type'];
		$date=$r['date'];
		$reg_user=$r['reg_user'];
		$app=$r['app'];
		$info=1;
		$p_name=get_p_dts_name($patient,$p_type);
		$pTxt=$RevName='';
		$AppName=get_val_arr('api_users','code',$app,'n');
		$RevName=get_val_arr('_users','name_'.$lg,$reg_user,'u');
		if($p_type==2){$pTxt.=' <span class="f1 clr5"> ( مريض مؤقت )</span>';}
		$clr='';
		if($reg_user){
			if($reg_user==$thisUser){
				$clr='cbg666';
			}else{
				$clr='cbg555';
				$info=0;
			}
		}
		?>
		<tr class="<?=$clr?>">
			<td><ff><?=dateToTimeS2($now-$date)?></ff></td>
			<td txt ><?=$AppName?></td>
			<td txt ><?=$p_name.$pTxt?></td>			
			<td txt><?=$RevName?></td>
			<td><? if($info  && $infoS){?><div class="ic40 icc4 ic40_done" onclick="confAppDts(<?=$d_id?>)"></div><?}?></td>
		</tr><? 
		if($reg_user==$thisUser){$infoS=0;}
	}?>
</table> 
<?}else{echo '<div class="f1 clr5 fs16 lh40">لايوجد مواعيد</div>';}?>
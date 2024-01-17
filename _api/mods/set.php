<? include("../../__sys/mods/protected.php");?>
<? 
echo header_sec('Notification Setting');
$pers=get_val('api_users','pers',$thisUser);
$pers=str_replace(',',"','",$pers);?>
<div class="centerSideIn of"><?
$sql="select * from api_noti_set where user='$thisUser' limit 1";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows){
	$r=mysql_f($res);?>
	<form name="nSet" id="nSet" method="post" action="<?=$f_path?>X/api_noti_set_save.php" cb="savsNs([1])" bv="a">
	<table cellpadding="0" cellspacing="6" border="0">
		<tr><td class="fs14" width="120">Sound :</td>
		<td width="300"><input required name="s" type="text" value="<?=$r['sound']?>"/></td></tr>
		<tr><td class="fs14">Icon :</td>
		<td class="f1"><input required name="i" type="text" value="<?=$r['icon']?>"/></td></tr>
		<tr><td class="fs14">Color :</td>
		<td class="f1"><input required name="c" type="text" value="<?=$r['color']?>"/></td></tr>
		<tr><td class="fs14">Priority :</td>
		<td class="f1"><input required name="p" type="text" value="<?=$r['priority']?>"/></td></tr>
		<tr><td class="fs14">Channel_id :</td>
		<td class="f1"><input required name="ac" type="text" value="<?=$r['channal']?>"/></td></tr>
		<tr><td class="fs14">SMS link :</td>
		<td class="f1"><input required name="sms" type="text" value="<?=$r['sms']?>" fix="w:400"/>
		<div class="ff clr5 fs12 lh30">NOte : ( [p]=>phone ) - ( [m]=>massage )</div>
		</td></tr>
		
		<tr><td class="fs14"></td>
		<td class="f1"><div class=" bu buu bu_t1 saveNSet" ><?=k_save?></div></td></tr>		
	</table>
	</form><?
}?>
</div>
<? //if($thisGrp!='s'){?>
<script>$(document).ready(function(e){noteSet_set();});</script>
<? //}?>
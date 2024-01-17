<? include("../../__sys/mods/protected.php");?>
<?=header_sec($def_title);?>
<div class="centerSideInFull">
<div class="gOn ofx so" fix="wp:0|hp:0"><?
echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="onlBlc" id="onlBlc">';
$sql="select * from _users where act=1 order by grp_code ASC";
$res=mysql_q($sql);
$rows=mysql_n($res);
while($r=mysql_f($res)){
	$id=$r['id'];
	$name=$r['name_'.$lg];
	$photo=$r['photo'];
	$grp_code=$r['grp_code'];
	$sex=$r['sex'];
	$grp_name=get_val_arr('_groups','name_'.$lg,$grp_code,'g','code');
	echo '
	<tr u="'.$id.'">
		<td p>---'.viewPhotos_i($photo,0,50,50,'css','nophoto'.$sex.'.png',$name.' ( '.$grp_name.' ) ').'----</td>
		<td n>'.$name.'</td>
		<td g>'.$grp_name.'</td>
		<td t="'.$id.'"></td>
	</tr>';
}
echo '</table>';
?>
</div>
</div>
<script>sezPage='online';$(document).ready(function(e){gnr_online();refPage('gnr_on',8000);});</script>
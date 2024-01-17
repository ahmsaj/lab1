<? include("../../__sys/mods/protected.php");?>
<?=header_sec($def_title);?>
<div class="centerSideInFull ofx so cbg444">
<?
echo '<div class="onlBlc" id="onlBlc">';
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
    $photo=viewPhotos_i($photo,0,60,80,'css','nophoto'.$sex.'.png',$name.' ( '.$grp_name.' ) ');
	echo '
	<div class="bord" u="'.$id.'" s="0" >
        <div i>'.$photo.'</div>        
        <div>
            <div n>'.$name.'</div>
            <div g>'.$grp_name.'</div>
            <div t="'.$id.'">0:0</div>
        </div>
        <div mod="'.$id.'"></div>
	</div>';
}
echo '</div>';
?>
</div>
<script>sezPage='online';$(document).ready(function(e){sys_online();refPage_m('sys_on',8000);});</script>
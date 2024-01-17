<? include("../../__sys/mods/protected.php");?>
<?
$pers=get_val('api_users','pers',$thisUser);
$pers=str_replace(',',"','",$pers);?>
<div class="centerSideInFull of fxg" fxg="gtc:300px 1fr" >
	<div class="fl r_bord pd10 ofx so docLinks pd10f cbg444" ><?
 		$sql="select id,title_$lg from api_pages where `show` =1 order by ord ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){
			while($r=mysql_f($res)){echo '<div class="f1 pd10f" t="1" n="'.$r['id'].'">'.$r['title_'.$lg].'</div>';}
		}
		echo '<div class="f1 fs14 lh30 pd5v pd10 br5" t="0" n="1">'.k_errors_list.'</div>';
		echo '<div class="f1 fs14 lh30 pd5v pd10 br5" t="0" n="2">'.k_notifi_list.'</div>';
		echo '<div class="f1 fs18 lh40 uLine">'.k_procedures.'</div>';
		$sql="select id,title_$lg from api_module where code IN('$pers') order by ord ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){			
			while($r=mysql_f($res)){echo '<div class="f1 fs14 lh30 pd5v pd10 br5" t="2" n="'.$r['id'].'">'.$r['title_'.$lg].'</div>';}
			echo '<div class="f1 pd10f " t="2" n="999">'.k_all.'</div>';
		}?>
	</div>
	<div class="fl pd10f ofx so" id="mOut"></div>
</div>
<script>$(document).ready(function(e){docs_set();});</script>
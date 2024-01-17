<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'])){
	$vis=pp($_POST['vis']);
	$r=getRecCon('cln_x_addons_per'," user='$thisUser'");
	if($r['r']){
		$addons=$r['addons'];
		$data=str_replace(',',"','",$addons);
		$sql="select * from cln_m_addons where (code IN('$data') OR (req=1)) and act =1 order by FIELD(code,'$data')";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){
			echo '<div class="addons">';			
			while($r=mysql_f($res)){
				$code=$r['code'];
				$name=$r['name_'.$lg];
				$color=$r['color'];
				$icon=$r['icon'];
				$short_code=$r['short_code'];
				$iconT='def';
				if($icon){$iconT=$icon;}				
				echo '<div class="fs14" style="border-'.$align.'-color:'.$color.';background-image:url(../images/add/'.$iconT.'.png);" code="'.$short_code.'">'.$name.'</div>';				
			}
			echo '</div>';
		}
	}else{
		echo '<div class="f1 fs14 lh20 clr7 pd10f">'.k_act_not_specifed.'</div>';
	}
	
	
}?>
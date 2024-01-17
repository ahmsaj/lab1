<? include("../header.php");
if(isset($_POST['vis'])){
	$vis=pp($_POST['vis']);
	$rv=getRec('cln_x_visits',$vis);
	$r=getRecCon('cln_x_addons_per'," user='$thisUser'");
	if($r['r']&& $rv['r']){
		$visStatus=$rv['status'];
		$patient=$rv['patient'];
		$addons=$r['addons'];
		$data=str_replace(',',"','",$addons);
		$sql="select * from cln_m_addons where (code IN('$data') OR (req=1)) and act =1 order by FIELD(code,'$data')";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){
			echo '<div class="flex" fix1="hp:0|wp:0">';
			$dataArr=array();
			while($r=mysql_f($res)){
				$code=$r['code'];
				$name=$r['name_'.$lg];
				$color=$r['color'];
				$icon=$r['icon'];
				$short_code=$r['short_code'];
				$addon=$r['addon'];				
				$iconT='def';
				if($icon){$iconT=$icon;}
				$iconCss="background-image:url(images/add/$iconT.png);";
				switch ($code){
					case 'jm4nndrak0':
						echo view_med_proc($vis,1,$name,$color,$short_code,$iconT,$visStatus);
					break;
					case 'vh3d871mb1':
						echo view_med_proc($vis,2,$name,$color,$short_code,$iconT,$visStatus);
					break;
					case 'kjrepzcpai':
						echo view_med_proc($vis,3,$name,$color,$short_code,$iconT,$visStatus);
					break;
					case 'cykhelccih':
						echo view_med_proc($vis,4,$name,$color,$short_code,$iconT,$visStatus);
					break;
					case 'v99ov38jw6':
						echo view_med_proc($vis,5,$name,$color,$short_code,$iconT,$visStatus);
					break;
					case '5s1knov62b':
						echo view_icd($vis,1,$name,$color,$short_code,$iconT,$visStatus);
					break;
					case 'iexje9eo9s':
						echo view_icd($vis,2,$name,$color,$short_code,$iconT,$visStatus);
					break;
					case 'dd1q42qqvk':
						echo medical_history($patient,$name,$color,$short_code,$iconT,$visStatus);
					break;
					case 'ww0i5f8nzz':
						echo view_vs($patient,$name,$color,$short_code,$iconT,$visStatus);
					break;
					case 'ba1r68m7c3':
						echo view_gi($patient,$name,$color,$short_code,$iconT,$visStatus);
					break;
					
				}
			}
			echo '</div>
            <div clss="lh20">&nbsp;</div>';
		}
	}
}?>
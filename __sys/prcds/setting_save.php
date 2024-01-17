<? include("ajax_header.php");
$q="where pro IN($proActStr) ";
if($thisGrp!='s'){$q.=" and admin=1 ";}
$sql="select * from _settings $q order by ord ASC";
$res=mysql_q($sql);
$rows=mysql_n($res);
if(isset($_POST['_set_'])){
	if($rows>0){
		while($r=mysql_f($res)){
			$id=$r['id'];
            $code=$r['code'];
			$type=$r['type'];
			if($type==3){
				$val=0;
				if(isset($_POST['set_'.$code])){
					$val=1;
				}
			}else{
				$val=pp($_POST['set_'.$code],'s');
			}
			mysql_q("UPDATE _settings set val='$val' where id='$id'");
		}
	}
    echo 1;
}?>
<? include("ajax_header.php");
if(isset($_POST['d'])){
	$d=pp($_POST['d'],'s');
	if($d){
		$dd=str_replace(',',"','",$d);
		$sql="select id from _fav_list where user_code='$thisUserCode' and g_code='$thisGrp'  ORDER BY FIELD(m_code,'$dd')";
		$res=mysql_q($sql);
		$i=1;
		while($r=mysql_f($res)){		
			$id=$r['id'];			
			mysql_q("UPDATE `_fav_list` SET ord='$i' where id='$id' ");
			$i++;
		}
	}
}
?>
<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['srv'])){
	$srv=pp($_POST['srv']);
	$rec=pp($_POST['rec']);
	$data=getServItem($srv);
	if($data){		
		if($userStore){
			echo "newCons(".$userStore.",'".$data."','endSrvDo(".$rec.",[data])',' ( ".get_val('cln_m_services','name_'.$lg,$srv)." )')";
		}else{echo 0;}
	}else{echo 0;}
}?>
<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['a'],$_POST['v'],$_POST['p'],$_POST['s'],$_POST['l'])){
	$action=pp($_POST['a']);
	$vis=pp($_POST['v']);
	$pat=pp($_POST['p']);
	$srv=pp($_POST['s']);
	$lev=pp($_POST['l']);
	$out=0;
	list($vDoc,$vStatus)=get_val('den_x_visits','doctor,status',$vis);
	list($sDoc,$sDocAdd,$vStatus)=get_val('den_x_visits_services','doc,doc_add,status',$srv);
	$r=getRecCon('den_x_visits_services',"id='$srv' and patient='$pat' and visit_id='$vis' ");
	if($vDoc==$thisUser){
		switch ($action) {
			case 1:
				if($sDoc==0){
					if(mysql_q("UPDATE den_x_visits_services SET status=1 , doc='$thisUser' , d_start='$now' where id='$srv'")){
						mysql_q("UPDATE den_x_visits_services_levels SET doc='$thisUser' , date='$now' where x_srv='$srv'");
						$out=1;
					}
				}
			break;
			case 2:				
				if(mysql_q("UPDATE den_x_visits_services_levels SET status=2 , date_e='$now' where id='$lev' and status!=2 ")){$out=1;fixDenServEnd($srv);}
				
			break;
			case 3:
				if(mysql_q("UPDATE den_x_visits_services_levels SET status=1 , date_e='' where id='$lev' and status!=1 ")){$out=1;fixDenServEnd($srv);}
			break;
			case 4:
				if(mysql_q("UPDATE den_x_visits_services_levels SET status=2 , date_e='$now' where x_srv='$srv' and status!=2 ")){$out=1;fixDenServEnd($srv);}
			break;
			case 5:				
				if($sDocAdd==$thisUser){
					$res=mysql_q("DELETE FROM den_x_visits_services where id='$srv' and doc_add='$thisUser' and status in(0,1) " );
					if(mysql_a($res)){
						$out=1;
						mysql_q("DELETE FROM den_x_visits_services_levels where x_srv='$srv' ");
						mysql_q("DELETE FROM den_x_visits_services_levels_w where x_srv='$srv' ");
					}
				}else{
					mysql_q("UPDATE den_x_visits_services SET doc=0,status=0 where id='$srv' and status!=2");
					mysql_q("UPDATE den_x_visits_services_levels SET doc=0 , status=0 where x_srv='$srv' ");
					mysql_q("DELETE FROM den_x_visits_services_levels_w where x_srv='$srv' ");
					$out=1;
				}
			break;
		}
	}
	echo $out;
}?>
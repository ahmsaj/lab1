<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['rep'])){
	$id=pp($_POST['id']);	
	$rep=pp($_POST['rep'],'s');
	$id=pp($_POST['id']);
	$r=getRec('xry_x_visits_services',$id);
	if($r['r']){
		$doc=$r['doc'];
		$status=$r['status'];
		$pat=$r['patient'];
		$srv=$r['service'];
		$clinic=$r['clinic'];
		$rep=str_replace('<br>','',$rep);
		if($status==0 && ($doc==$thisUser || $doc==0)){			
			if(getTotalCO('xry_x_pro_radiography_report',"id='$id'")==0){
				$sql="INSERT INTO xry_x_pro_radiography_report (`id`,`report`,`date`,`clin`)values('$id','$rep','$now','$clinic')";
			}else{
				$sql="UPDATE xry_x_pro_radiography_report set report='$rep' , date='$now' where id='$id' ";
			}
			if(mysql_q($sql)){echo 1;}
		}
	}
}
if(isset($_POST['id'] , $_POST['cof_m6m8y467sx'])){
	$id=pp($_POST['id']);
	//$rep=pp($_POST['cof_8q8n7fk5g2'],'s');
	$doc_ask=pp($_POST['cof_1j8mrbbsvw']);
	$photos=pp($_POST['cof_m6m8y467sx'],'s');
	$part=pp($_POST['part'],'s');
	$opr=pp($_POST['opr']);
	$mas=pp($_POST['mas'],'s');
	$kv=pp($_POST['kv'],'s');
	$film=pp($_POST['film']);
	$rep='';
	if($mas!=''){if(intval($mas)<1 || intval($mas)>400 ){exit;}}
	if($kv!=''){if(intval($kv)<30 || intval($kv)>125 ){exit;}}
	if( $thisGrp=='nlh8spit9q'){
		$opr=1;
		$rep=pp($_POST['cof_8q8n7fk5g2'],'s');
	}
	if(getTotalCO('xry_x_visits_services',"id='$id'") && ($opr==1 || $opr=2)){
	/********************************************************/	list($vis,$service,$patient,$clinic,$total_pay,$s_status)=get_val('xry_x_visits_services','visit_id,service,patient,clinic,total_pay,status',$id);
        if($s_status!=3){
            $vis_link=get_val('xry_x_visits','visit_link',$vis);
            if($vis_link){			
                $sql="select id,mad_id from xry_x_pro_radiography_items where xph_id IN(select id from xry_x_pro_radiography where v_id='$vis_link') ";
                $res=mysql_q($sql);
                $rows=mysql_n($res);
                if($rows>0){
                    while($r=mysql_f($res)){
                        $m_id=$r['id'];
                        $mad_id=$r['mad_id'];
                        $s_link=get_val('xry_m_pro_radiography_details','s_link',$mad_id);
                        if($s_link==$service){
                            mysql_q("UPDATE xry_x_pro_radiography_items set photo='$photos' , status='$opr' , note='$rep' where id='$m_id'");
                            mysql_q("UPDATE xry_x_visits_services set doc='$thisUser' where id='$id' and doc=0");
                        }
                    }
                }
            }
            $status=1;
            $doc=$thisUser;
            if($opr==2){
                $status=6;
                $doc=0;
            }else{
                if(getTotalCO('xry_x_visits_requested_items',"service_id='$id'")){
                    mysql_q("UPDATE xry_x_visits_requested_items SET res_photo='$photos' , res='$rep' , status=2 where service_id='$id' ");
                    mysql_q("UPDATE xry_x_visits_services set doc='$thisUser' where id='$m_id' and doc=0");
                }
            }
            /*********************************************************/
            if(getTotalCO('xry_x_pro_radiography_report',"id='$id'")==0){
                $sql="INSERT INTO xry_x_pro_radiography_report (`id`,`ray_tec`,`doc`,`doc_ask`,`date`,`photos`,`service`,`patient`,`val`,`clin`,`mas`,`kv`,`film`,`part`)
                values('$id','$thisUser','$doc','$doc_ask','$now','$photos','$service', '$patient','$total_pay','$clinic','$mas','$kv','$film','$part')";			
                if(mysql_q($sql)){
                    
                    mysql_q("UPDATE xry_x_visits_services set status='$status' where id='$id' ");echo 1;
                    mysql_q("UPDATE xry_x_visits_services set doc='$doc' where id='$m_id' and doc=0");
                    api_notif($pat,1,3,$id);
                }
            }else{
                $sql="UPDATE xry_x_pro_radiography_report set doc_ask='$doc_ask',doc='$doc' , photos='$photos' , service='$service' , patient='$patient' ,
                mas='$mas'  , kv='$kv' , film='$film' , part='$part'
                where id='$id' ";
                if(mysql_q($sql)){                    
                    mysql_q("UPDATE xry_x_visits_services set status='$status' where id='$id' ");
                    //mysql_q("UPDATE xry_x_visits_services set doc='$thisUser' where id='$m_id' and doc=0");
                    mysql_q("UPDATE xry_x_visits_services set doc='$doc' where id='$id' and doc=0");
                    echo 1;
                    api_notif($pat,1,3,$id);
                }
            }
        }else{echo 0;}
	}
}?>
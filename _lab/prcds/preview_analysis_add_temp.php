<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['name'],$_POST['anas'])){
	$name=pp($_POST['name'],'s');
    $anas=pp($_POST['anas'],'s');
    if($name && $anas){        
        $anas=get_vals('lab_m_services','id',"id IN($anas)");
        if($anas){
            $sql="INSERT INTO lab_m_services_templates (`name`,`temp`,`doc`)values('$name','$anas','$thisUser')";
            if(mysql_q($sql)){echo $anas;}
        }
    }
}?>
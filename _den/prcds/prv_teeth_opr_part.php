<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['type'],$_POST['teeth'] ,$_POST['opr'])){
	$vis=pp($_POST['vis']);
    $type=pp($_POST['type']);
    $teeth=pp($_POST['teeth']);
    $teeth_part=pp($_POST['teeth_part']);
    $opr=pp($_POST['opr']);
    $oprSub=pp($_POST['oprSub']);
    $oprT=pp($_POST['oprT']);    
    $opr_type=2;
    //if($oprSub){$opr_type=2;}
    $r=getRec('den_x_visits',$vis);
    if($r['r']){
        $doctor=$r['doctor'];
        $status=$r['status'];
        $patient=$r['patient'];
        $clinic=$r['clinic'];
        $cav_no=0;
        if($type==2){
            $c=pp($_POST['c'])-1;
            $cav_no=getCavNo($teeth,$c);
        }
        if($status==1 && $thisUser==$doctor){
            if($oprT==1){//add Status
                mysql_q("UPDATE den_x_opr_teeth SET `last_opr`=0 where `patient`='$patient' and `teeth_no`='$teeth' and teeth_part='$type' and teeth_part_sub='$teeth_part'");
                $sql="INSERT INTO den_x_opr_teeth (
                `patient`, `visit`, `doctor`, `teeth_no`, `teeth_part`, `teeth_part_sub`, `opr_type`, `opr`, `opr_sub`, `last_opr`, `date`, `cav_no`
                )values(
                    '$patient', '$vis', '$doctor', '$teeth', '$type', '$teeth_part', '$opr_type', '$opr', '$oprSub', '1', '$now', '$cav_no'
                )";
            }else if($oprT==2){//Delete Status
                echo $sql="delete from den_x_opr_teeth  where patient='$patient' and teeth_no='$teeth' and teeth_part='$type' and opr_type='$opr_type' and opr='$opr' and opr_sub='$oprSub' and `last_opr`=1";
                
            }
            if(mysql_q($sql)){echo 1;}
        }
    }
}?>
<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['t'])){    
	$vis=pp($_POST['vis']);
    $c_type=pp($_POST['t']);
    $table=$visXTables[$c_type];
    $r=getRecCon($table,"id='$vis' and `doctor`='$thisUser' and status=2");
    if($r['r']){       
        $d_finish=$r['d_finish'];
        $status=$r['status'];
        $dts_id=$r['dts_id'];
        if($c_type==1 && $d_finish+3600>$now){
            if(mysql_q("UPDATE $table SET status=1 where id='$vis' limit 1")){echo 1;}
        }
    }
}?>
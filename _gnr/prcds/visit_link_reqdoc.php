<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['vis'],$_POST['m'])){
	$id=pp($_POST['id']);
    $vis=pp($_POST['vis']);
    $mood=pp($_POST['m']);
    if($mood==2 || $mood==3){
        $table=$visXTables[$mood];
        $r=getRec($table,$vis);
        if($r['r']){
            if($r['status']==0){
                if(get_val('gnr_m_doc_req','name',$id)){
                    if(mysql_q("UPDATE $table SET doc_ord='$id' where id='$vis'")){
                        echo 1;
                    }
                }
            }
        }
    }
}?>
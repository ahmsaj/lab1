<? include("../../__sys/prcds/ajax_header.php");
$manager=$chPer[2];
$q=" status=2 and follower='$thisUser'";
if($manager){
    $q=" (status <3 OR date>".($now-86400).") and ( user=0 or user='$thisUser') ";
}
$sql="select * from api_x_complaints where $q order by date DESC";
$res=mysql_q($sql);
$rows=mysql_n($res);
while($r=mysql_f($res)){
    $id=$r['id'];
    $patient=$r['patient'];
    $complaint=$r['complaint'];
    $solution=$r['solution'];
    $date=$r['date'];
    $status=$r['status'];
    $statsTxt='';
    if($manager){$statsTxt='( '.$complStatus[$status].' )';}
    echo '<div class="cbgw bord pd10f mg10v br5 Over2 complList" st="'.$status.'" complAc="'.$id.'">
        <div class="fr"><ff14>#'.$id.'</ff14></div>
        <div class="f1 fs14 lh40 clr1">'.get_p_name($patient).' '.$statsTxt.'</div>                
        <div class="f1 ff B fs12">'.date('Y-m-d Ah:i:s',$date).'
        <span class=" f1 fs10">'.k_since.' ( '.dateToTimeS($now-$date,1).' )</span>
        </div>
    </div>';
}       
?>
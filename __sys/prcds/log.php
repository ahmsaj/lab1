<? include("../../__sys/prcds/ajax_header.php");
logHis();
$pn=pp($_POST['pn']);
$q='';
$expMod=['fgz4ysqwd1'];
if($thisUser!='s' && $thisGrp!='s'){
    $add=1;
    $addTime=$now;
    $q='';
    if(in_array($MO_ID,$expMod)){$q=" and pn='$pn'";}
	$sql="select `id`,`s_in`,`s_out`,`mod` from _log where user='$thisUser' $q";
	$res=mysql_q($sql);
	$rows=mysql_n($res);    
	if($rows){
		while($r=mysql_f($res)){
            $id=$r['id'];
            $mod=$r['mod'];
            $s_out=$r['s_out'];
            $s_in=$r['s_in'];
            $addTime=min($addTime,$s_in);            
            if($mod==$MO_ID){
                mysql_q("UPDATE _log set `s_out`='$now' , status='0' where `id` ='$id'");
                $add=0;
            }
        }
	}    
    if($add){
        $mod_title='';
        if($MO_ID){
            $mod_title=get_val_c('_modules_list','title_'.$lg,$MO_ID,'mod_code');
        }else{
            $mod_title='الصفحة الرئيسية';
        }
        
        $sql="INSERT INTO _log (`user`,`grp`,`s_in`,`s_out`,`mod`,`mod_title`,`lang`,`pn`) values ('$thisUser','$thisGrp','$addTime','$now','$MO_ID','$mod_title','$lg','$pn')";
        mysql_q($sql);
    }
	
}
addFunctionsTime();//this for additional functions?>
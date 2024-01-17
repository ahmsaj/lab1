<? include("../../__sys/prcds/ajax_header.php");
$t=pp($_POST['t']);
$sql="SELECT * FROM `_langs` where active=1 ";
$langs=mysql_q($sql);
$langsCount=mysql_n($langs);
$fileCount=0;
$keysCount=0;
while($l=mysql_f($langs)){
	$lang=$l['lang'];
	$jsScript=' ';    
	$phpScript='<?  ';    
	$phpArray=''; 
    $keysCount=0;
    
    if($t==1){// Project 
        $path='../../__main/lang/';
        if(!file_exists($path)){mkdir($path,0777);}
        $filePath="__main/lang/lang_k_$lang.js";        
        $table='_lang_keys';
        $q=" ";
    }else if($t==2){// System
        $path='../../__sys/lang/';
        if(!file_exists($path)){mkdir($path,0777);}
        $filePath="__sys/lang/lang_k_$lang.js";
        $table='_lang_keys_sys';
        $q=" and super=0 ";
        if(!_set_2jaj4f43vd){$q.=" and cms=0 ";}
    }else if($t==3){//Super
        $path='../../__super/lang/';
        if(!file_exists($path)){mkdir($path,0777);}
        $filePath="__super/lang/lang_k_$lang.js";
        $table='_lang_keys_sys';
        $q=" and super=1 ";
        if(!_set_2jaj4f43vd){$q.=" and cms=0 ";}// CMS Keys
    }
    $jsFileName=$path."lang_k_$lang.js";
    $phpFileName=$path."lang_k_$lang.php";
    if(_set_ccluftee8m || $t==1){// التأكد من ان المستخدم مطور
        $sql="select l_key,_$lang from $table where act=1 $q";
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        if($rows){
            while($r=mysql_f($res)){
                $k=$r['l_key'];            
                $value=$r['_'.$lang];           
                if($jsScript!=' '){$jsScript.=',';}
                $jsScript.='k_'.$k.'="'.$value.'"';
                $phpScript.='define(\'k_'.$k.'\',"'.$value.'");'; 
                $phpArray.='\'k_'.$k.'\'=>"'.$value.'",';
                $keysCount++;
            }
        }
        if($jsScript!=' '){$jsScript='var '.$jsScript.';';}
        $phpScript.='$LDA'.$t.'=array('.$phpArray.');?>';
        if(file_put_contents($phpFileName,$phpScript)){
            if(file_put_contents($jsFileName,$jsScript)){
                $fileCount++;
                $rowsOut.='
                <tr>
                    <td class="uc">'.$lang.'</td>
                    <td>'.$filePath.'</td>
                    <td><ff14> '.number_format($keysCount).'</ff14></td>
                </tr>';
            }
        }
        $keysCountAll+=$keysCount;
    }
}
if($t==1){
    if(_set_2jaj4f43vd){
        $path='../../../sys/';
        $sql="SELECT * FROM `_langs` where active=1 ";
        $langs=mysql_q($sql);
        $langsCount=mysql_n($langs);	
        while($l=mysql_f($langs)){
            $lang=$l['lang'];
            $jsScript=' ';
            $phpScript='<?  ';
            $phpArray='';		
            $jsFileName=$path."lang_k_$lang.js";		
            $phpFileName=$path."lang_k_$lang.php";
            $sql="select l_key, _$lang from _lang_keys where web_site=1";		
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            $keysCount=$rows;
            $keysCountAll+=$keysCount;
            if($rows){                
                while($r=mysql_f($res)){
                    $k=$r['l_key'];
                    $value=$r['_'.$lang];
                    if($jsScript!=' '){$jsScript.=',';}
                    $jsScript.='k_'.$k.'="'.$value.'"';
                    $phpScript.='define(k_'.$k.',"'.$value.'");';				
                    $phpArray.='\'k_'.$k.'\'=>"'.$value.'",';                    
                }                
                if($jsScript!=' '){$jsScript='var '.$jsScript.';';}
                $phpScript.='$LDA=array('.$phpArray.');?>';
                if(file_put_contents($phpFileName, $phpScript)){
                    if(file_put_contents($jsFileName, $jsScript)){
                        $fileCount++;					
                        $file="site/lang_k_$lang.js";
                        $rowsOut.='<tr><td class="uc">'.$lang.'</td><td>'.$file.'</td><td><ff14> '.number_format($keysCount).'</ff14></td></tr>';
                    }
                }
            }
        }
    }
}
echo $fileCount.'^'.number_format($keysCountAll).'^'.$rowsOut;

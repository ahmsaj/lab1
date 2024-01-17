<? include("../../__sys/prcds/ajax_header.php");
//echo '<div class="f1 bord pd10f TC clr6 cbg666 in w100" onclick="loadModBackup()"> تم التحميل بنجاح</div>';
$file=pp($_POST['file'],'s');
$type=pp($_POST['type']);

$dir='../../__super_backup/';
$file=$dir.'mira-'.$file;
//$file=glob($dir.'*')[0];
if(file_exists($file)){
    if($type==1){
        $engine='MyISAM';
        $defCharset='utf8';

        $content= file_get_contents($file);    
        $d=json_decode($content,true);
        $queries=[];
        foreach($d as $k=>$v){
            foreach($v as $k2=>$v2){
                $table=$k2;
                $queries[]="drop table if exists `$table`;";
                $columns=$v2['columns'];
                $columnsTxt='';
                foreach($columns as $kc=>$col){
                    $type=$col[0];
                    $default=$col[1];
                    $null=$col[2];
                    $extra=$col[3];
                    $chSet=$col[4];
                    $chSetTxt='';
                    if($chSet && $chSet!=$defCharset){
                        $chSetTxt=" CHARACTER SET $chSet ";
                    }
                    // echo '('.$default.')';
                    $defTxt='';
                    $nullTxt='';
                    if($default!=''){
                        $defTxt=" DEFAULT '$default' ";
                    }else{
                        $nullTxt='';
                        if($null!='YES'){$nullTxt=" NOT NULL ";}else{$defTxt=" DEFAULT NULL ";}
                    }                
                    $columnsTxt.=" `$kc` $type $chSetTxt $defTxt $nullTxt ,";
                }
                $columnsTxt=substr($columnsTxt,0,-1);
                $AI=$v2['AI'];            
                $creat= "CREATE TABLE IF NOT EXISTS `$table` ($columnsTxt) ENGINE=$engine  DEFAULT CHARSET=$defCharset AUTO_INCREMENT=$AI ;";
                $queries[]=$creat;
                /**************************************/            
                $rowPerQ=1000;
                $vals=[];
                $insert='';            
                $cols = '`'.implode('`,`',array_keys($columns)).'`';
                $rows=$v2['rows'];
                $i=0;
                foreach($rows as $r){
                    $v=addslashes("***".implode("***,***",$r)."***");
                    $v=str_replace('***',"'",$v);
                    $vals[]=$v;
                    $i++;
                    if($i>=$rowPerQ){
                        $queries[]="INSERT INTO `$table` ($cols) VALUES (".implode('),(',$vals).");
                        ";
                        $i=0;
                        unset($vals);
                    }
                }
                if(count($vals)){
                    $queries[]="INSERT INTO `$table` ($cols) VALUES (".implode('),(',$vals).");
                    ";
                }
                //$queries[]=$insert;
                /**************************************/
                $keys=$v2['keys'];
                $keysQ='';
                foreach($keys as $kk=>$vk){                
                    $col = '`'.implode('`,`',$vk['columns']).'`';
                    if($kk=='PRIMARY'){
                        $keysQ.=" ADD PRIMARY KEY ($col) ,";
                    }else if($vk['Index_type']=='FULLTEXT'){
                        $keysQ.=" ADD FULLTEXT KEY `$kk` ($col) ,";
                    }else if($vk['unique']==0){
                        $keysQ.=" ADD UNIQUE KEY `$kk` ($col) ,";
                    }else{
                        $keysQ.=" ADD KEY `$kk` ($col) ,";
                    }
                }
                if($keysQ){
                    $keysQ=substr($keysQ,0,-1);
                    $queries[]="ALTER TABLE `$table` $keysQ ;";
                }
                /**************************************/
                $queries[]="ALTER TABLE `$table` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=$AI;";
                /**************************************/
                foreach($queries as $q){
                    //echo $q.'<br><br><br>';
                    mysql_q($q);
                }
            }
        }
    }
    echo 1;
    unlink($file);
}?>
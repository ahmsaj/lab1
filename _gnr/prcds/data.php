<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['table'],$_POST['p'])){
	$table=pp($_POST['table'],'s');
    $p=pp($_POST['p']);
    
    $sql="SELECT * FROM `INFORMATION_SCHEMA`.`COLUMNS` 
    WHERE `TABLE_SCHEMA`='"._database."' AND `TABLE_NAME`='$table';";
    $res=mysql_q($sql);
    $rows=mysql_n($res);            
    if($rows){
        $tables='';
        $colms=[];
        $rows=getTotal($table);
        echo '<div class="hh10"></div>
        <div class="lh40 fs18 B">'.$table.' ('.number_format($rows).')</div>
        <table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH g_ord noWarp">';
        while($r=mysql_f($res)){            
            $cloms=$r['COLUMN_NAME'];
            $type=$r['DATA_TYPE'];
            $colms[]=$cloms;
            if(!in_array($table,$xTables)){
                echo '<th>'.$cloms.' <br>( '.$type.' )</th>';
            }
            
        }
        $sql="select * from $table limit 1000";
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        while($r=mysql_f($res)){
            echo '<tr>';
            foreach($colms as $col){
                echo '<td>'.$r[$col].'</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
    }
    
}?>
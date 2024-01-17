<? include("../../__sys/mods/protected.php");?>
<style>
    .table_list div{
        text-align: left;
        line-height: 30px;
        border-bottom: 1px #ccc solid;
        padding:0 20px;
    }
    .table_list div:hover{        
        background-color: #fff;
        cursor: pointer;
    }
    .table_list div[act]{        
        background-color: #000;
        color: #fff;
    }
    table.noWarp th{
        white-space: nowrap;
    }
</style>
<script>

</script>

<div class="centerSideInFull of fxg" fxg="gtc:250px 1fr|gtr:100%">
    <div class="r_bord cbg444 fxg " fxg="gtr:40px 1fr">
        <div class="lh40 fs14 TC b_bord cbg4">Tables</div>
        <div class="ofx so table_list" actButt="act"><?            
            $sql="select * from information_schema.TABLES where TABLE_SCHEMA='"._database."'";
            $res=mysql_q($sql);
            $rows=mysql_n($res);            
            if($rows){
                $tables='';
                while($r=mysql_f($res)){
                    $table=$r['TABLE_NAME'];
                    if(!in_array($table,$xTables)){
                        echo '<div>'.$table.'</div>';
                    }
                }
            }?>
        </div>
    </div>
    <div id="tableData" class="ofxy so pd10">
        
    </div>
    
</div>
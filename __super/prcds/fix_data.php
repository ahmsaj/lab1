<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['opr'] , $_POST['code'])){
    $opr=$_POST['opr'];
    $code=$_POST['code'];
    if($opr==1){
        echo '<div actButt="act">';
        $cData=getColumesData($code); 
        foreach($cData as $data){
            echo '<div class="f1 lh40 cbgw bord pd10 mg10v Over2" fc="'.$data['c'].'">'.get_key($data[2]).' ( '.$data[1].' )</div>';
        }
        echo '</div>';
    }
    if($opr==2){
		$cData=getColumesData('',0,$code);
		$mod_code=$cData[0]['m'];
		$col_name=str_replace('(L)',$lg,$cData[0][1]);
		$col_title=get_key($cData[0][2]);
		
        $s=pp($_POST['s'],'s');
        $mod_code=get_val_c('_modules_items','mod_code',$code,'code');	
        $table=get_val_c('_modules','table',$mod_code,'code');
        /**********************************/
        $linkData=array();
        $sql="select * from _modules_links where mod_code='$mod_code' ";
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        if($rows>0){
            $i=0;
            while($r=mysql_f($res)){
                $linkData[$i]['t']=$r['table'];
                $linkData[$i]['c']=$r['colume'];
                $i++;
            }
        }
        /**********************************/
        $cData=getColumesData('',0,$code); 
        $col_name=str_replace('(L)',$lg,$cData[0][1]);
        $col_title=$cData[0][2];
        $q='';
        if($s){
            $q=" where ";
            $ss=explode('|',$s);
            $r=0;
            foreach($ss as $sss){
                if($r>0)$q.=" OR ";
                $q.=" `$col_name` like'%$sss%' ";
                $r++;
            }
        }
        $all=getTotalCo($table,$q);
        $sql="select `id` , `$col_name` from `$table` $q order by `$col_name` ASC limit 1000";
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        $resTxt=number_format($rows);
        if($all>$rows){$resTxt=number_format($all).'/'.number_format($rows);}
        if($rows>0){?>
            <div class="f1 fs18 lh40"> <?=k_num_res?> <ff><?=$resTxt?></ff></div>
            <table class="grad_s holdH" over="0" id="tData" width="100%" border="0" cellpadding="4" cellspacing="0" type="static">
            <tr><th width="30"></th><th width="30"></th><th width="50"><?=k_num?></th><th><?=k_val?></th>
            <? foreach($linkData as $ld){
                echo '<th>'.$ld['t'].' | '.$ld['c'].'</th>';
            }?>
            </tr><?
            while($r=mysql_f($res)){
                $id=$r['id'];
                $txt=$r[$col_name];
                echo '<tr ch="off" no="'.$id.'">
                <td><div class="ic40 ic40_edit icc1" onclick="co_loadForm('.$id.',3,\''.$mod_code.'||fix_selFild()|\');" title="'.k_edit.'"></div></td>
                <td class="chMain"></td>
                <td class="ff fs18 B">'.$id.'</td>
                <td class="f1 fs14">('.$txt.')</td>';

                foreach($linkData as $ld){
                    echo '<td class="ff fs18 B">';
                    if($rows<20){
                        echo number_format(getTotalCO($ld['t']," `".$ld['c']."`='$id'"));
                    }else{
                        echo '-';
                    }
                    echo '</td>';
                }			
                echo '</tr>';
            }
            ?></table><?
        }
    }
}
if(isset($_POST['id'] , $_POST['fix_id'])){
	$mod_col=$_POST['id'];
	$min_id=$_POST['min_id'];
	$fix_id=$_POST['fix_id'];	
	$mod_code=get_val_c('_modules_items','mod_code',$mod_col,'code');
	$table=get_val_c('_modules','table',$mod_code,'code');
	/**********************************/
	$eff=0;
	$linkData=array();
	$sql="select * from _modules_links where mod_code='$mod_code' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$s_table=$r['table'];
			$column=$r['colume'];			
			$sql2="UPDATE `$s_table` set `$column`='$min_id' where `$column` IN($fix_id) " ;
			$res2=mysql_q($sql2);
			$eff+=mysql_a();
		}
	}
	/**********************************/
	$sql3="DELETE from `$table` where id IN ($fix_id) ";
	$res=mysql_q($sql3);
	echo k_chn_rcd.' <ff>( '.$eff.' )</ff>';	
}?>
<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['code'],$_POST['val'])){
	$code=pp($_POST['code'],'s');
    $val=pp($_POST['val'],'s');    
    $val=stripcslashes($val);
    $addColum='';
    foreach($objectListSetFileds[$code] as $k=>$v){
        $addColum.='<td d l="'.$v[4].'">'.objListInp($v).'</td>';
    }
    $titleColum='';
    foreach($lg_s as $k=>$v){
        $titleColum.='
        <div class="TL mg5v"><input type="text" placeholder="'.$lg_n[$k].'" lg="'.$v.'" t fix="w:150"/></div>';
    }
    echo Script('
        objBRow=`<tr>
        <td><div class="mover"></div></td>
        <td><input type="text" v/></td>
        <td>'.$titleColum.'</td>
        '.$addColum.'
        <td><div class="i30 i30_del" delToObj ></div></td>
        </tr>`;
    ');
    ?>
    <div class="win_body">
	<div class="form_header">
	    <div class="lh40 clr1 fs18 fl f1"><?=k_ent_lst_val?></div>
	    <div title="<?=k_add?>" class="fr ic40x br0 ic40_add icc1" addToObj></div>
	</div>
	<div class="form_body so" type="full" >
	<table width="100%" border="0" cellspacing="0" type="static" cellpadding="4" OLTab class="grad_s mlord holdH" >
        <thead>
            <tr>
                <th width="40"></th>
                <th width="120"><?=k_val?></th>
                <th><?=k_txt?></th>
                <? foreach($objectListSetFileds[$code] as $k=>$v){
                    echo '<th>'.$v[0].'</th>';
                }?>
                <th width="30"></th>
            </tr>
        </thead>
        <tbody><?  
        $val=str_replace("'",'"',$val);
        $val_arr=json_decode($val,true);        
        if($val){
            foreach($val_arr as $k=>$val){
                echo '<tr>
                <td><div class="mover"></div></td>
                <td><input type="text" value="'.$val['id'].'" v/></td>
                <td>';
                    foreach($lg_s as $k=>$v){
                        $tVal=$val['title'][$v];
                        echo '<div  class="TL mg5v">
                        <input type="text" placeholder="'.$lg_n[$k].'" lg="'.$v.'" value="'.$tVal.'" t fix="w:150"/>
                        </div>';
                    }
                echo '</td>';
                foreach($objectListSetFileds[$code] as $k=>$v){
                    $thisVal=$val['objAdd'][$v[1]];                    
                    echo '<td d l="'.$v[4].'">'.objListInp($v,$thisVal).'</td>';
                }
                echo '<td><div class="i30 i30_del" delToObj></div></td>
                </tr>';                
            }
        }?>
        </tbody>
	</table>
	</div>
	<div class="form_fot fr">
		<div class="bu bu_t1 fl" endToObj><?=k_end?></div>
		<div class="bu bu_t2 fr" onclick="win('close','#m_info5')"><?=k_close?></div>
	</div>
</div><?
    
}?>
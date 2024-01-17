<? include("../../__sys/prcds/ajax_header.php");?>
<div class="f1 fs20 lh30 fl"><?=k_menu?></div>
<div class="buu bu2 bu_t1 w-auto fr" on onclick="newModMenu(0)"  style="margin-<?=k_Xalign?>:10px">
<?=k_nw_mnu?></div>
<div class="fr">&nbsp;</div>
<div class="buu bu2 bu_t1 w-auto fr" on onclick="newModMenu('t')"><?=k_nw_tl?></div>
<div class="fr">&nbsp;</div>
<div class="ic30x icc2 ic30_ord  fr" onclick="menuOrder('0')"></div>
<div class="cb"></div>
<div class="menu_contener d_res" no="0" type="mm"><?
$x_mods="'0'";
$x_mods2="'0'";
$sql="select * from _modules_list order by ord ASC ";
$res=mysql_q($sql);
$rows=mysql_n($res);
$data_arr=array();
if($rows>0){
	$i=0;
    while($r=mysql_f($res)){
        $data_arr[$i]['code']=$r['code'];
        $data_arr[$i]['mod_code']=$r['mod_code'];				
        $data_arr[$i]['title']=$r['title_'.$lg];
        $data_arr[$i]['icon']=$r['icon'];
        $data_arr[$i]['type']=$r['type'];
        $data_arr[$i]['p_code']=$r['p_code'];
        $data_arr[$i]['act']=$r['act'];
		$i++;
    }
    foreach($data_arr as $data){
		$module_name='';
        if($data['p_code']=='0'){
            $p_code=$data['code'];
            $cbg='cbg1111';
            $moveTab='d_move';
			$module_name='';
			$icon=$data['icon'];
			$Madd='';
            if($data['type']==0){$moveTab='';}
            if($data['type']==1){
				$x_mods.=",'".$data['mod_code']."'";
				$cbg='cbg1';
				$module_name=' ('.get_val_c('_modules','Module',$data['mod_code'],'code').' )';
				if($icon==''){$icon=get_val_c('_modules','icon',$data['mod_code'],'code');}
			}
			if($data['type']==2){
				$x_mods2.=",'".$data['mod_code']."'";
				$cbg='cbg1';
				$module_name=' ('.get_val_c('_modules_','Module',$data['mod_code'],'code').' )';
				if($icon==''){$icon=get_val_c('_modules_','icon',$data['mod_code'],'code');}
				$Madd='* ';
			}
            if($data['type']==3){$cbg='cbg2';$moveTab='';}
            if($data['act']==0)$cbg='cbg4';
                
            echo '
            <div class="'.$moveTab.' cb '.$cbg.'" no="'.$data['code'].'" p="'.$data['p_code'].'" type="menu" l>
                <div class="ic30x icc4 ic30_edit fr" onclick="newModMenu(\''.$data['code'].'\')"></div>
                <div class="ic30x icc2 ic30_del fr mg5" onclick="delModMenu(\''.$data['code'].'\')"></div>';
				if($data['type']==0){echo '<div class="ic30x icc3 ic30_ord fr" onclick="menuOrder(\''.$data['code'].'\')"></div>';}
                echo '<div class="fl mml_ico" style="background-image:url('.$m_path.'im/menu/icon_m_'.$icon.'.png)"></div>
                <div class="f1 fs14 fl mml_txt">'.$Madd.get_key($data['title']).' '.$module_name.'</div>
            </div>';
            if($data['type']==0){
				$module_name='';
                echo '<div class="submenuMod d_res2" no="'.$data['code'].'" type="mm">';
                foreach($data_arr as $data2){
					$Madd='';
                    if($data2['p_code']==$p_code){
                        $icon=$data2['icon'];
						if($data2['type']==1){
							$x_mods.=",'".$data2['mod_code']."'";
							if($icon==''){$icon=get_val_c('_modules','icon',$data2['mod_code'],'code');}
							$module_name=get_val_c('_modules','Module',$data2['mod_code'],'code');
						}
						if($data2['type']==2){
							$x_mods2.=",'".$data2['mod_code']."'";
							if($icon==''){$icon=get_val_c('_modules_','icon',$data2['mod_code'],'code');}
							$module_name=get_val_c('_modules_','Module',$data2['mod_code'],'code');
							$Madd='* ';
						}                        
                        $cbg='cbg11';
                        if($data2['act']==0)$cbg='cbg4';							
                        echo '
                        <div class="d_move cb '.$cbg.'" no="'.$data2['code'].'" p="'.$p_code.'" type="menu" l>
                            <div class="ic30 icc4 ic30_edit fr" onclick="newModMenu(\''.$data2['code'].'\')"></div>
                            <div class="ic30 icc2 ic30_del fr" onclick="delModMenu(\''.$data2['code'].'\')"></div>
                            <div class="fl mml_ico" style="background-image:url('.$m_path.'im/menu/icon_m_'.$icon.'.png)"></div>
                            <div class="f1 fs14 fl mml_txt">'.$Madd.get_key($data2['title']).' ( '.$module_name.' ) </div>
                        </div>';								
                    }
                }
                echo '</div>';
            }
        }
    }
}?>
</div>

<!--***-->
<div class="fl f1 fs20 lh30"><?=k_additional_modules?></div>
<div class="cb"></div>
<div class="modm_mod_list"><?
$sql="select * from _modules_ where code NOT IN ($x_mods2)order by code ASC ";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){
    while($r=mysql_f($res)){
        $code=$r['code'];
        $module=$r['module'];
        $title=$r['title_'.$lg];
        $icon=$r['icon'];
        $sys=$r['sys'];	
        echo '
        <div class="d_move cb" no="'.$code.'" type="mod2">
            <div class="fl mml_ico" style="background-image:url('.$m_path.'im/menu/icon_m_'.$icon.'.png)"></div>
            <div class="f1 fs14 fl mml_txt">'.$title.' ( '.$module.' ) </div>
        </div>';
    }
}?>
</div>
<hr>
<div class="f1 fs20 lh30"><?=k_modules?></div>
<div class="modm_mod_list"><?
$sql="select * from _modules where code NOT IN ($x_mods)order by ord ASC ";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){
    while($r=mysql_f($res)){
        $code=$r['code'];
        $module=$r['module'];
        $title=$r['title_'.$lg];
        $icon=$r['icon'];
        $sys=$r['sys'];				
        echo '
        <div class="d_move cb" no="'.$code.'" type="mod">
            <div class="fl mml_ico" style="background-image:url('.$m_path.'im/menu/icon_m_'.$icon.'.png)"></div>
            <div class="f1 fs14 fl mml_txt">'.$title.' ( '.$module.' ) </div>
        </div>';
    }
}?>
</div>


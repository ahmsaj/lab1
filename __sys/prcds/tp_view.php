<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['cn'])){    
    $id=pp($_POST['id']);
    $cn=pp($_POST['cn']);
    $PER_code=pp($_POST['per'],'s');
    if($PER_ID=='p'){$PER_ID='';}
    if(!$PER_code){$PER_code=$PER_ID;}
    $per=checkPer($PER_code,1);
    if($per){
        $mod=get_val_c('_modules_list','mod_code',$PER_code,'code');
        $table=get_val_c('_modules','table',$mod,'code');
        $col=str_replace('(L)',$lg,get_val('_modules_items','colum',$cn));
        $data=get_val($table,$col,$id);
        if($data){$data=str_replace('\n\n','\n',$data);}
        $dir='ltr';
        if($l_dir!='ltr'){$dir='rtl';}?>
        <div class="win_body">        
            <div class="form_header lh40"><?
                foreach($lg_s as $k=>$v){
                    if($v!=$lg){
                        echo '<div class="ic40 icc1 ic40Txt fr br0" tpview="'.$id.'" cn="'.$cn.'" lg="'.$v.'" per="'.$PER_ID.'">'.$lg_n[$k].'</div>';
                    }
                }?>
            </div>
            <div class="form_body so" type="full_pd0" dir="<?=$dir?>">
                <div class="tpEditorDemo"><?=tpEditorDemo($data)?></div>
            </div>
            <div class="form_fot fr">            	    	
                <div class="fr ic40 ic40_x icc3 ic40Txt mg10v br0" onclick="win('close','#m_info5');"><?=k_close?></div>
            </div>
        </div><?
    }
}?>
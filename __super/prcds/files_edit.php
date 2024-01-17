<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['t'])){
	$id=$_POST['id'];
	$type=$_POST['t'];    
    if($type==1){
        $table='_modules_files';
        $folder='mods';
    }else if($type==2){
        $table='_modules_files_pro';
        $folder='prcds';        
    }
    $r=getRec($table,$id);
    if($r['r']){
        $file=$r['file'];
        $prog=$r['prog'];
        $name=$file;
        $filePath=getModFolder($prog).$folder.'/'.$file.'.php';
        $data=(file_get_contents($filePath));?>
        <div class="win_body">
            <div class="form_header"><div class="lh40"><ff><?=$name?></ff></div></div>
            <div class="form_body so" type="full">
                <form name="fEditeForm" id="fEditeForm" action="<?=$f_path?>M/files_edit_save.php" method="post" style="height:100%;">
                    <input type="hidden" name="id" value="<?=$id?>"/>
                    <input type="hidden" name="type" value="<?=$type?>"/>
                    <table width="100%" border="0" class="fTable" cellspacing="0" cellpadding="0">
                    <textarea name="code" class="so w100 h100"  dir="ltr"><?=htmlentities($data);?></textarea>
                    </table>
                </form>
            </div>
            <div class="form_fot fr">
                <div class="bu bu_t2 fr" onclick="win('close','#m_info')"><?=k_close?></div>
                <div class="bu bu_t3 fl" onclick="sub('fEditeForm')"><?=k_save?></div>
            </div>
        </div><? 
    }
}?>
    
<? include("../../__sys/header.php");
if(isset($_GET['mod'])){$module=pp($_GET['mod'],'s'); $mod_data=loadModulData($module); echo script('
mod="'.$mod_data['c'].'"; sezPage="'.$module.'"; mod_data[0]=["'.$mod_data['c'].'",0]; mod_sort="'.$mod_data['sort_no'].'"; mod_sort_dir="'.$mod_data[4].'";');$sendingParsToForm=getStaticPars($mod_data['c']); echo script('sendingParsToForm="'.$sendingParsToForm.'"'); echo co_header_sec($mod_data['c']);?><div class="centerSideInHeader fl"></div><div class="centerSideIn so" ><div class="loadeText"><?=k_loading?></div></div><? }
if(isset($_GET['mod2'])){
    echo script('sezPage="'.$_GET['mod2'].'"');
    $file=getModxFile(pp($_GET['mod2'],'s')); 
    include($file);
}include("../../__sys/footer.php");?>
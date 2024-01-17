<? include("ajax_header.php");
if(isset($_POST['code'])){
	$code=pp($_POST['code'],'s');
    $r=getRecCon('_help_hints',"code='$code'");
    if($r['r']){
        $title=$r['title_'.$lg];?>
        
        <div class='cbg666 pd10f'>
            
            <div class='w100 f1 fs12 lh20'><?=$title?></div>
        </div>
        <?
    }
}?>
<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['f'])){
    $f=pp($_POST['f'],'s');
    echo make_Combo_box('api_module','title_'.$lg,'code',"where act=1 and part_internal=1 ",$f,1);
         
}
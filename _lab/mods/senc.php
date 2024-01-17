<? session_start();
include("min/dbc.php");
//include("__sys/define_add.php");
include("__sys/f_funs.php");
$lang_data=checkLang();
$lg=$lang_data[0];//main languge
$l_dir=$lang_data[1];//defult diratoin (ltr or rtl)
$lg_s=$lang_data[2];// active lang list code ar en sp
$lg_n=$lang_data[3];// active lang list text Arabic English
$lg_s_f=$lang_data[4];// all lang list code ar en sp
$lg_n_f=$lang_data[5];// all lang list text Arabic English
$lg_dir=$lang_data[6];
if($l_dir=="ltr"){define('k_align','left');	define('k_Xalign','right');}else{define('k_align','right');define('k_Xalign','left');}
include("__sys/cssSet.php");
//login();list($proAct,$proUsed)=proUsed();
//$proActStr="'".implode("','",$proAct)."'";
include("__main/lang/lang_k_$lg.php");
include("__sys/lang/lang_k_$lg.php");
include("__sys/funs.php");
include("__sys/funs_co.php");
include('__main/funs.php');
include("__sys/define.php");

$inc_file1='_lab/funs.php';
$inc_file2='_lab/define.php';
if(file_exists($inc_file1)){include($inc_file1);}
if(file_exists($inc_file2)){include($inc_file2);}?>

<!doctype html>
<html lang="<?=$lg?>" class="no-js">
<head>
<meta charset="utf-8">
<title>Lab Senc</title>
<meta content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name="viewport" />
<link href="<?=$m_path?>library/jquery/css/jq-ui.css" rel="stylesheet" type="text/css"/>
<link href="<?=$m_path?>library/jquery/css/jquery.datetimepicker.css" rel="stylesheet" type="text/css"/><? 
$style_file='CSS1lV'.$ProVer.'.css';?>
<link href="<?=$m_path?>sys<?=$style_file?>" rel="stylesheet" type="text/css" />
<link href="<?=$m_path?>library/pp/css/prettyPhoto.css" rel="stylesheet" type="text/css"/>
<style>
.progr{
    width:100%;
    height: 10px;
    float: left;
    background-color: #fff;
}   
.progr div{
    width:0%;
    height: 10px;
    float: left;
    background:url("images/preloader3.gif");
}

</style>
<? $fileName='Lg'.$lg.'Mv'.$ProVer.'.js';?>
<script src="<?=$m_path?><?=$fileName?>"></script>
<? $fileName='Lg'.$lg.'Sv'.$ProVer.'.js';?>
<script src="<?=$m_path?><?=$fileName?>"></script>

<script>var k_Xalign='<?=k_Xalign?>';var k_align='<?=k_align?>';</script>
<script src="<?=$m_path?>library/jquery/jq3.6.js"></script>
<script src="<?=$m_path?>library/jquery/jq-ui.js"></script>
<script src="<?=$m_path?>library/jquery/jquery.form.min.js"></script>
<script src="<?=$m_path?>library/jquery/jquery.datetimepicker.js"></script>
<script src="<?=$m_path?>library/jquery/jquery.ui.touch-punch.js"></script>

<script src="<?=$m_path?>labJSv<?=$ProVer?>.js"></script>
<script src="<?=$m_path?>__sys/fix.js"></script>

<script>
	var clr1='<?=$clr1?>';var clr11='<?=$clr11?>';var clr111='<?=$clr111?>';var clr1111='<?=$clr1111?>';
	var clr2='<?=$clr2?>';var clr3='<?=$clr3?>';var clr4='<?=$clr4?>';var clr44='<?=$clr44?>';
	var clr5='<?=$clr5?>';var clr55='<?=$clr55?>';var clr555='<?=$clr555?>';
	var clr6='<?=$clr6?>';var clr66='<?=$clr66?>';var clr666='<?=$clr666?>';
	var clr7='<?=$clr7?>';var clr77='<?=$clr77?>';var clr777='<?=$clr777?>';
	var clr8='<?=$clr8?>';var clr88='<?=$clr88?>';var clr888='<?=$clr888?>';
	var sezPage='';var f_path='<?=$f_path?>';var m_path='<?=$m_path?>';	
	var lg='<?=$lg?>';var l_dir='<?=$l_dir?>';
	var lg_s=new Array('<?=implode("','",$lg_s)?>');
	var lg_n=new Array('<?=implode("','",$lg_n)?>');
	var lg_s_f=new Array('<?=implode("','",$lg_s_f)?>');
	var lg_n_f=new Array('<?=implode("','",$lg_n_f)?>');	
	var logTimer=<?=$logTime?>;
	var langs_count=<?=count($lg_s)?>;
	var langs_count_f=<?=count($lg_s_f)?>;
	var PER_ID='<?=$PER_ID?>';
	var proUsed=new Array();
	var labAnLang='<?=_set_yj870gpuyy?>';
    $(document).ready(function(){
        $('[s]').click(function(){senc(1);})
        $('[e]').click(function(){stopSenc();})
    })
    var stopS=1;
    var t=20;
    var startNow=0;
    recs=0;
    lod='';
	function senc(l=0){
        if(l==1){
            $('[s]').hide();
            $('[e]').show();
            $('.progr').show();
            stopS=0;
            startNow=1;
        }
        if(stopS==0){
            loaderTime();
            sencData();
        }
    }
    function loaderTime(l=0){
        clearTimeout(lod);
        tt=t*10;
        lod=setTimeout(function(){
            if(stopS==0){
                l++;
                if(l>tt){
                    l=0;
                    sencData();
                }else{
                    loaderTime(l);
                }
                w=(100*l)/tt;
                $('.progr div').css('width',w+'%');
            }
        },100);
    }
    function stopSenc(){
        stopS=1;
        $('[s]').show();
        $('.progr').hide();
        $('[e]').hide();
        $('.progr div').css('width','0%');
        $('[data]').prepend('<div>------------------------------------------</div>');
    }
    function sencData(){
        $.post(f_path+"X/lab_senc.php",{t:startNow}, function(data){
            dd=data.split('^');
            if(dd.length==4){                
                $('[str]').html(dd[0]);
                $('[tim]').html(dd[1]);
                recs+=parseInt(dd[2]);
                $('[rec]').html(recs);
                $('[data]').prepend(dd[3]);
                fixPage();
                fixForm();
                startNow=0;
                loaderTime(0);
            }
        })
    }
</script>

</head>
<body>
<div class="fl h100 pd10f cbg4 bord_l" fix="w:300">
    <div class="f1 fs14 lh30">Start: <ff class="clr1" str>0</ff></div>
    <div class="f1 fs14 lh30">Time: <ff class="clr1" tim>0</ff></div>
    <div class="f1 fs14 lh30">Records: <ff class="clr1" rec>0</ff></div>
    <div class="fl hide progr mg10v"><div></div></div>
    <div class="fl bu2 buu bu_t4 mg10v " s>Start Senc</div>
    <div class="fl bu2 buu bu_t3 mg10v hide" e>Stop Senc</div>
    
</div>
<div class="fl h100 pd10f ofx so" data fix="wp:300">
    
</div>
</body>
</html>
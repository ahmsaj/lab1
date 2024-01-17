
<? include("../../__sys/mods/protected.php");?><? header_sec($def_title,'');
$r=rand();
$_SESSION['live']=[$thisUser,$now,$r];?>
<div class="blcCaht"><div><div class="fs14 f1 ">جاري التحميل</div></div></div>
<div class="centerSideInFUll of" fix="hp:0" >
    <div class="fl cbg4 r_bord h100" fix="w:350">        
        <div class="w100 h100 ofx so" id="chats"><? //loadChats()?></div>
    </div>
    <div class="fl ofx so" fix="wp:350|hp:0" id="massContent"></div>
    <audio id="sn1" src="<?=$m_path?>images/sounds/n1.mp3" type="audio/mp3" allow=""></audio>
    <audio id="sn2" src="<?=$m_path?>images/sounds/n2.mp3" type="audio/mp3" allow=""></audio>
</div>

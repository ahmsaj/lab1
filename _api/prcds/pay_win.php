<? session_start();
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Card Info</title>
        <style>
            html , body{
                margin: 0;
                padding: 0;
                width: 100vw;
                height:100vh;
                overflow: hidden;
            }
            .iframe{
                margin: 0px auto;
                width: 100vw;
                height:100vh;
                overflow: hidden;
                border: 0px #fff solid;
            }
            .iframe{overflow-x: hidden;border: 0px #fff solid;}
            .page-container{
                background-color: #eee;
            }
            iframe body{overflow-x: hidden;}
            .buttons{background-color: #f00}
            .secc{
                font-size: 35px;
                text-align: center;
                margin-top: 50px;
                color: #26671C;
            }
        </style>
    </head>
    <body>
        <?
if(isset($_GET['opr'])){
    $opr=$_GET['opr'];
    if(isset($_GET['code'])){
        $PBL='../../';
        include($PBL."__sys/dbc.php");
        include($PBL."__sys/f_funs.php");
        $lang_data=checkLang();
        $lg=$lang_data[0];//main languge
        $l_dir=$lang_data[1];//defult diratoin (ltr or rtl)
        $lg_s=$lang_data[2];// active lang list code ar en sp
        $lg_n=$lang_data[3];// active lang list text Arabic English
        $lg_s_f=$lang_data[4];// all lang list code ar en sp
        $lg_n_f=$lang_data[5];// all lang list text Arabic English
        $lg_dir=$lang_data[6];
        if($l_dir=="ltr"){define('k_align','left');define('k_Xalign','right');}else{define('k_align','right');define('k_Xalign','left');}
        include($PBL."__sys/cssSet.php");	
        include($PBL."__main/lang/lang_k_$lg.php");
        include($PBL."__sys/lang/lang_k_$lg.php");
        include($PBL."__sys/funs.php");
        include($PBL."__sys/funs_co.php");
        include($PBL."__main/funs.php");
        include($PBL."__sys/define.php");
        include($PBL."_api/funs.php");
        include($PBL."_dts/funs.php");
        include($PBL."_gnr/funs.php");
        include($PBL."_lab/funs.php");
        include($PBL."_gnr/define.php");
		include($PBL."_api/define.php");
        $code=$_GET['code'];
        $r=getRecCon('api_x_payments',"code='$code' and status=0");
        if($r['r']){
            if($opr=='w'){// payment window
                echo '
                <div class="iframe" >
                    <iframe src="'.$r['url'].'" width="100%" frameborder="0" height="100%" id="iframe"></iframe>
                </div>';
            }
            if($opr=='x'){// cancle payment                 
                mysql_q("Delete from  api_x_payments where  status=0 and code='$code' ");  
                switch($r['opration']){
                    case 1:// new date
                        $dts_id=$r['rec_id'];
                        $dts=getRec('dts_x_dates',$dts_id);
                        if($dts['r']){
                            $out=api_notif($r['patient'],$dts['p_type'],102,$dts_id);
                        }
                    break;
                }
            }
            if($opr=='c'){// complate payment
                list($err,$status)=getPaymentStatus($r['payment_id']);
				echo $err.'-'.$status;				
                if($err==0){
                    if($status=='A'){
                        echo '<div class="secc">تمت الدفعة بنجاح</div>';
                        mysql_q("UPDATE api_x_payments set status=1 where status=0 and code='$code' ");
                        switch($r['opration']){
                            case 1:// new date
                                $dts_id=$r['rec_id'];
                                $dts=getRec('dts_x_dates',$dts_id);
                                if($dts['r']){
                                    mysql_q("UPDATE dts_x_dates set status=1 where status=10 and id='$dts_id' ");
                                    
                                    //$datBalance=DTS_PayBalans($r['rec_id'],0,$dts['type']);
                                    //if($dPay+$datBalance<=$price){                                
                                        addPay($dts_id,$dts['type'],$dts['clinic'],$r['amount'],0,2);
                                    //}                                    
                                    $out=api_notif($r['patient'],$dts['p_type'],101,$dts_id);
                                }
                            break;
                        }
                    }
                }
            }
        }
    }
}
?>
</body>
</html>


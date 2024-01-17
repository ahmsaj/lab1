<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    $vis=pp($_POST['vis']);
    $pat=pp($_POST['pat']);    
    $r=getRec('den_m_services',$id);
    if($r['r']){
        $hos_part=$r['hos_part'];
        $doc_part=$r['doc_part'];
        $tooth_link=$r['tooth_link'];    
        $price=$hos_part+$doc_part;
        $selType='actButt';
        if($tooth_link==2){
           $selType='actButtM';
        }
        
        $d_start=get_val('den_x_visits','d_start',$vis);
        
        $newPrice=get_docServPrice($thisUser,$id,4);
        $newP=$newPrice[0]+$newPrice[1];							
        if($newP){            
            $price=$newP;
        }
        
        $editOpr='';
        $editOprMsg='';
        if(_set_nukjs8og6f==0 || (_set_nukjs8og6f==1 && $d_start<$ss_day)){$editOpr='disabled';$editOprMsg="لايمكن تحرير السعر";}
        if(chDenSrvLev($id)){?> 
            <div class="of fxg h100" fxg="gtr:1fr 60px">
                <div class="ofx so pd20 pd10v">
                    <form name="ths" id="ths" action="<?=$f_path?>X/den_prv_oprs_new_det_save.php" method="post" cb="saveDopr('[1]')" bv="a">
                        <input type="hidden" name="id" value="<?=$id?>"/>
                        <input type="hidden" name="vis" value="<?=$vis?>"/>
                        <input type="hidden" name="pat" value="<?=$pat?>"/>
                        <div class="lh30 f1 fs12">السعر: <sapn class="f1 clr5"><?=$editOprMsg?></sapn></div>
                        <div><input type="number" name="price" class="cbg444 lh30" value="<?=$price?>" <?=$editOpr?> required/></div>
                        <div class="lh30 f1 fs12">ملاحظات :</div>
                        <div><textarea class="w100 cbg444" t name="note"></textarea></div><? 
                        if($tooth_link){?>
                            <div class="lh40 f1 fs12">أختر الأسنان :</div>
                            <div class="bord so pd10f cbg444" <?=$selType?>="act" son="[s]" selTeeth inputHolder>
                                <input name="tooth" type="hidden" required/>
                                <div class="f1 fs12 lh30 TC"><?=k_permanent_teeth?></div>
                                <div class=" w100 teethTab fxg" fxg="gtc:1fr 1fr|gtc:1fr:1300" dir="ltr">
                                    <div r1 class="fxg" fxg="gtc:repeat(8,1fr)">
                                        <div s>18</div>
                                        <div s>17</div>
                                        <div s>16</div>
                                        <div s>15</div>
                                        <div s>14</div>
                                        <div s>13</div>
                                        <div s>12</div>
                                        <div s>11</div>
                                    </div>
                                    <div r2 class="fxg" fxg="gtc:repeat(8,1fr)">
                                        <div s>21</div>
                                        <div s>22</div>
                                        <div s>23</div>
                                        <div s>24</div>
                                        <div s>25</div>
                                        <div s>26</div>
                                        <div s>27</div>
                                        <div s>28</div>
                                    </div>
                                    <div r3 class="fxg" fxg="gtc:repeat(8,1fr)">
                                        <div s>48</div>
                                        <div s>47</div>
                                        <div s>46</div>
                                        <div s>45</div>
                                        <div s>44</div>
                                        <div s>43</div>
                                        <div s>42</div>
                                        <div s>41</div>
                                    </div>
                                    <div r4 class="fxg" fxg="gtc:repeat(8,1fr)">
                                        <div s>31</div>
                                        <div s>32</div>
                                        <div s>33</div>
                                        <div s>34</div>
                                        <div s>35</div>
                                        <div s>36</div>
                                        <div s>37</div>
                                        <div s>38</div>
                                    </div>
                                </div>
                                <div class="lh10 ">&nbsp;</div>
                                <div class="f1 fs12 lh30 TC"><?=k_deciduous_teeth?> </div>
                                <div class=" w100 teethTab fxg" fxg="gtc:1fr 1fr|gtc:1fr:1300" dir="ltr" >
                                    <div r1 class="fxg" fxg="gtc:repeat(5,1fr)">
                                        <div s>55</div>
                                        <div s>54</div>
                                        <div s>53</div>
                                        <div s>52</div>
                                        <div s>51</div>                            
                                    </div>
                                    <div r2 class="fxg" fxg="gtc:repeat(5,1fr)">
                                        <div s>61</div>
                                        <div s>62</div>
                                        <div s>63</div>
                                        <div s>64</div>
                                        <div s>65</div>
                                    </div>
                                    <div r3 class="fxg" fxg="gtc:repeat(5,1fr)">
                                        <div s>85</div>
                                        <div s>84</div>
                                        <div s>83</div>
                                        <div s>82</div>
                                        <div s>81</div>
                                    </div>
                                    <div r4 class="fxg" fxg="gtc:repeat(5,1fr)">
                                        <div s>71</div>
                                        <div s>72</div>
                                        <div s>73</div>
                                        <div s>74</div>
                                        <div s>75</div>
                                    </div>
                                </div>                    
                            </div><?
                        }?>
                    </form>
                </div>
                <div class="t_bord">
                    <div class="ic40x ic40_save ic40Txt icc2 fr mg10f" saveDopr><?=k_save?></div>
                </div>
            </div><?
        }else{
            echo '<div class="f1 clr5 fs14 lh30 pd10 mg20f">'.k_err_add_procedure.'</div>';
        }
    }
}?>
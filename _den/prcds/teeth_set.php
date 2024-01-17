<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['type'],$_POST['cb'])){
	$type=pp($_POST['type']);
	$cb=pp($_POST['cb'],'s');?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18"><?=k_chos_teeth?></div>
	<div class="form_body so" type="full">
	<div class="f1 fs16 lh40 uLine"><?=k_permanent_teeth?></div>
	<table width="100%" border="0" class="tInfoTable2" dir="ltr">
	<tr r1>
		<td tno2="18">18</td>
		<td tno2="17">17</td>
		<td tno2="16">16</td>
		<td tno2="15">15</td>
		<td tno2="14">14</td>
		<td tno2="13">13</td>
		<td tno2="12">12</td>
		<td tno2="11">11</td>
		<td tno2="21" bor>21</td>
		<td tno2="22">22</td>
		<td tno2="23">23</td>
		<td tno2="24">24</td>
		<td tno2="25">25</td>
		<td tno2="26">26</td>
		<td tno2="27">27</td>
		<td tno2="28">28</td>
	</tr>
	<tr r2>
		<td tno2="48">48</td>
		<td tno2="47">47</td>
		<td tno2="46">46</td>
		<td tno2="45">45</td>
		<td tno2="44">44</td>
		<td tno2="43">43</td>
		<td tno2="42">42</td>
		<td tno2="41">41</td>
		<td tno2="31" bor>31</td>
		<td tno2="32">32</td>
		<td tno2="33">33</td>
		<td tno2="34">34</td>
		<td tno2="35">35</td>
		<td tno2="36">36</td>
		<td tno2="37">37</td>
		<td tno2="38">38</td>
	</tr>
	</table>
	<div class="lh40 ">&nbsp;</div>
	<div class="f1 fs16 lh40 uLine"><?=k_deciduous_teeth?> </div>
	<table width="100%" border="0" class="tInfoTable2" dir="ltr">
	<tr>
		<td tno2="55">55</td>
		<td tno2="54">54</td>
		<td tno2="53">53</td>
		<td tno2="52">52</td>
		<td tno2="51">51</td>
		<td tno2="61" bor>61</td>
		<td tno2="62">62</td>
		<td tno2="63">63</td>
		<td tno2="64">64</td>
		<td tno2="65">65</td>
	</tr>
	<tr r2>
		<td tno2="85">85</td>
		<td tno2="84">84</td>
		<td tno2="83">83</td>
		<td tno2="82">82</td>
		<td tno2="81">81</td>
		<td tno2="71" bor>71</td>
		<td tno2="72">72</td>
		<td tno2="73">73</td>
		<td tno2="74">74</td>
		<td tno2="75">75</td>
	</tr>							
	</table>
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t1 fl" onclick="setTeethSetSave();"><?=k_save?></div>
		<div class="bu bu_t2 fr" onclick="win('close','#m_info4');"><?=k_close?></div>
    </div>
    </div>
	<script>
		function setTeethSetDo(d){
			<?=str_replace('[data]','d',$cb); ?>
			;win('close','#m_info4');
		}
	</script><?
}?>
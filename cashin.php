<?
include('header.php');
$DOMEN=strtoupper($_SERVER['HTTP_HOST']);
$domen2=$_SERVER['HTTP_HOST'];
$protocol = (!empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS'])?"https://":"http://");

if(isset($_COOKIE["usNick"]) && isset($_COOKIE["usPass"]))
{
$username=$_COOKIE["usNick"];

$sqlwmr = "SELECT * FROM tb_config WHERE item='wmr'";
$resultwmr = mysqli_query($connect, $sqlwmr);
$rowwmr = mysqli_fetch_array($resultwmr);
$admin_wmr=$rowwmr["description"];

$sqlwmp = "SELECT * FROM tb_config WHERE item='wmp'";
$resultwmp = mysqli_query($connect, $sqlwmp);
$rowwmp = mysqli_fetch_array($resultwmp);
$admin_wmp=$rowwmp["description"];

$sqlpayeer = "SELECT * FROM tb_config WHERE item='payeer'";
$resultpayeer = mysqli_query($connect, $sqlpayeer);
$rowpayeer = mysqli_fetch_array($resultpayeer);
$admin_payeer=$rowpayeer["description"];

$sqlpayeerm = "SELECT * FROM tb_config WHERE item='payeer_merchant'";
$resultpayeerm = mysqli_query($connect, $sqlpayeerm);
$rowpayeerm = mysqli_fetch_array($resultpayeerm);
$payeer_merchant_id = $rowpayeerm["howmany"];
$payeer_merchant_pass = $rowpayeerm["description"];

$sqlyoomoney = "SELECT * FROM tb_config WHERE item='yoomoney'";
$resultyoomoney = mysqli_query($connect, $sqlyoomoney);
$rowyoomoney = mysqli_fetch_array($resultyoomoney);
$admin_yoomoney=$rowyoomoney["description"];

$sqlqiwi = "SELECT * FROM tb_config WHERE item='qiwi_public_key'";
$resultqiwi = mysqli_query($connect, $sqlqiwi);
$rowqiwi = mysqli_fetch_array($resultqiwi);
$qiwi_public_key = $rowqiwi["description"];

$sqlqwst = "SELECT * FROM tb_config WHERE item='qiwi_style'";
$resultqwst = mysqli_query($connect, $sqlqwst);
$rowqwst = mysqli_fetch_array($resultqwst);
$qiwi_style = $rowqwst["description"];

$sqlinterk = "SELECT * FROM tb_config WHERE item='interkassa'";
$resultinterk = mysqli_query($connect, $sqlinterk);
$rowinterk = mysqli_fetch_array($resultinterk);
$admin_interkassa=$rowinterk["description"];

$sqlwmin = "SELECT * FROM tb_config WHERE item='webmoney_in'";
$resultwmin = mysqli_query($connect, $sqlwmin);
$rowwmin = mysqli_fetch_array($resultwmin);
$k_webmoney_in=$rowwmin["price"];
$webmoney_in=$rowwmin["description"];

$sqlp = "SELECT * FROM tb_config WHERE item='payeer_in'";
$resultp = mysqli_query($connect, $sqlp);
$rowp = mysqli_fetch_array($resultp);
$k_payeer_in=$rowp["price"];
$payeer_in=$rowp["description"];

$sqlya = "SELECT * FROM tb_config WHERE item='yoomoney_in'";
$resultya = mysqli_query($connect, $sqlya);
$rowya = mysqli_fetch_array($resultya);
$k_yoomoney_in=$rowya["price"];
$yoomoney_in=$rowya["description"];

$sqlqw = "SELECT * FROM tb_config WHERE item='qiwi_in'";
$resultqw = mysqli_query($connect, $sqlqw);
$rowqw = mysqli_fetch_array($resultqw);
$k_qiwi_in=$rowqw["price"];
$qiwi_in=$rowqw["description"];

$sqlik = "SELECT * FROM tb_config WHERE item='interkassa_in'";
$resultik = mysqli_query($connect, $sqlik);
$rowik = mysqli_fetch_array($resultik);
$k_interkassa_in=$rowik["price"];
$interkassa_in=$rowik["description"];
?>

<h3><center><b>���������� ������� ��������</b></center></h3>
<br>

<?
$sql = "SELECT * FROM tb_users WHERE username='$username'";
$result = mysqli_query($connect, $sql);        
$row = mysqli_fetch_array($result);
$user_id=$row["id"];
$wmid=$row["wmid"];
$qiwi=$row["qiwi"];

if ($wmid == "")
{
$wmid=$username;
}

if (isset($_POST["sum"]))
{
$sum=$_POST["sum"];
$sum=round($sum, 2);

if ($_POST["sum"] == "" | $_POST["sum"] == "0")
{
echo "<br><br><br><br><br><br><br><br><center><img src=\"images/stop.png\"><br><b>�� ������� ����� ����������</b><br><br><a href='javascript:history.go(-1)'>��������� �����</a></center>";
include('footer.php'); 
exit();
}

if(!is_numeric($_POST["sum"]) | $_POST["sum"] < 0)
{
echo "<br><br><br><br><br><br><br><br><center><img src=\"images/stop.png\"><br><b>����� ���������� - ����� �� 0.01 �� 999999</b><br><br><a href='javascript:history.go(-1)'>��������� �����</a></center>";
include('footer.php'); 
exit();
}

$sqle="SELECT COUNT(*) as count from tb_cashin WHERE wmid = '$wmid'";
$resulte=mysqli_query($connect, $sqle);
$rowe=mysqli_fetch_array($resulte);
$wmid_count=$rowe['count'];

if ($wmid_count < 1)
{
$query = "INSERT INTO tb_cashin (user, wmid, summa) VALUES('$username','$wmid','$sum')";
mysqli_query($connect, $query) or die(mysqli_error());
}
else
{
$queryz = "UPDATE tb_cashin SET summa='$sum' WHERE wmid = '$wmid'";
mysqli_query($connect, $queryz) or die(mysqli_error());
}
?>

<div id='form' style='width: 100%;'>
<style>
#form input.button {
   background: #15922F;
   background: linear-gradient(to top, #15922F, #789a00);
   border: 1px solid #15922F;
   padding: 5px;
   outline: none;
   border-radius: 5px;
   color: white;
   line-height: 12px;
} 
#form input.button:hover { background: #15922F; }
#form input.button:active { background: #789a00; }

#form input.texte {
   width: 15%;
   height: 19px;
   line-height: 19px;
   border: 1px solid #ff1f1f;
   background-color:#15922F;
   background: linear-gradient(to top, #a50000, #ff1f1f);
   color: white;
   border-radius: 8px;
   margin-top: 5px;
   text-align: center;
   cursor: default;
   outline: none;
}
</style>
<div style="font-size: 130%; line-height: 110%;">
������ �� ���������� ������� �������� �������!
<br>
<div style='width: 100%; background-color: #ec5e00; font-size: 110%; lite-height: 30px; padding: 5px;'><b><FONT color=white>����� � ������: <? echo $sum; ?> ���.</FONT></b></div>
</div>

<?
$all_ps = $webmoney_in + $payeer_in + $yoomoney_in + $qiwi_in + $interkassa_in;

if($all_ps < 1)
{
?>
<br>
<br>
<div style="width: 100%; height: 15px; background: #f5fff9; background: linear-gradient(to left, #ffffff, #e2eefc);"></div>
<br>
<font color='red'><b>���� �������� ��������</b></font>
<?
}

if ($webmoney_in == 1)
{
?>
<br>
<br>
<div style="width: 100%; height: 15px; background: #f5fff9; background: linear-gradient(to left, #ffffff, #e2eefc);"></div>
<br>
<div style='background: url(../images/wm_logo.png); background-size: cover; width: 20px; height: 20px; float: left; margin: -4px 5px 0px 0px;'></div>
<div style='font-size: 150%;'><b>������ ����� <FONT color=#036cb5>WebMoney</FONT></b></div>
<br>
<FONT color='#999999'>
�������� �������� �������: 0.8%
<br>
���� ��������: <? echo $k_webmoney_in; ?>%
</FONT>
<br>
<br>
<div style='background: url(../images/wm_img/wmr.png); background-size: cover; width: 40px; height: 40px; float: left; margin-right: 4px;' title='WebMoney WMR'></div>
<div style='background: url(../images/wm_img/wmnote_selected.png); background-size: cover; width: 40px; height: 40px; float: left; margin-right: 4px;' title='WM-����'></div>
<div style='background: url(../images/wm_img/terminal_selected.png); background-size: cover; width: 40px; height: 40px; float: left; margin-right: 4px;' title='��������� ������'></div>
<div style='background: url(../images/wm_img/sdp_selected.png); background-size: cover; width: 40px; height: 40px; float: left; margin-right: 4px;' title='�������� �������'></div>
<div style='background: url(../images/wm_img/wmcards_paymer_selected.png); background-size: cover; width: 40px; height: 40px; float: left; margin-right: 4px;' title='WebMoney-����� ��� ��� Peymer'></div>
<div style='background: url(../images/wm_img/russianpost_selected.png); background-size: cover; width: 40px; height: 40px;' title='����� ��'></div>
<div style='margin-top: 10px;'></div>
<table width='100%'>
<tr>
<td width='25%'>
<?
$wmform = <<<WMFORM
<form id=pay name=pay method=POST action="https://merchant.webmoney.ru/lmi/payment.asp" method="POST">
 <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="{$sum}">
 <input type="hidden" name="LMI_PAYMENT_DESC" value="���������� ������� �������� {$username} � ������� {$DOMEN}">
 <input type="hidden" name="LMI_PAYEE_PURSE" value="{$admin_wmr}">
 <input type="hidden" name="wmid" value="{$wmid}">
 <input type="submit" class='button' value="�������� WMR">
</form>
WMFORM;
echo $wmform;
?>
</td>
<td width='25%'>
<?
$wmform = <<<WMFORM
<form id=pay name=pay method=POST action="https://merchant.webmoney.ru/lmi/payment.asp" method="POST">
 <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="{$sum}">
 <input type="hidden" name="LMI_PAYMENT_DESC" value="���������� ������� �������� {$username} � ������� {$DOMEN}">
 <input type="hidden" name="LMI_PAYEE_PURSE" value="{$admin_wmp}">
 <input type="hidden" name="wmid" value="{$wmid}">
 <input type="submit" class='button' value="�������� WMP">
</form>
WMFORM;
echo $wmform;
?>
</td>
<td width='50%'></td>
</tr>
</table>
<?
}

if ($payeer_in == 1)
{
?>
<br>
<br>
<div style="width: 100%; height: 15px; background: #f5fff9; background: linear-gradient(to left, #ffffff, #e2eefc);"></div>
<br>
<div style='background: url(../images/payeer_logo.png); background-size: cover; width: 20px; height: 20px; float: left; margin: -4px 5px 0px 0px;'></div>
<div style='font-size: 150%;'><b>������ ����� <FONT color=#3e3e3e>PAY</FONT><FONT color=#41a3d9>EER</FONT></b></div>
<br>
<FONT color='#999999'>
�������� �������� �������: 1%
<br>
���� ��������: <? echo $k_payeer_in; ?>%
</FONT>
<br>
<br>
<?
$m_shop = $payeer_merchant_id;
$m_orderid= $username;
$m_amount = number_format($sum, 2, '.', '');
$m_curr = 'RUB';
$m_desc = $DOMEN.' : pay in for user '.$username;
$m_desc = base64_encode($m_desc);
$m_key = $payeer_merchant_pass;

$arHash = array(
	$m_shop,
	$m_orderid,
	$m_amount,
	$m_curr,
	$m_desc
);

$arHash[] = $m_key;
$sign = strtoupper(hash('sha256', implode(':', $arHash)));
?>
<form method="post" action="https://payeer.com/merchant/" accept-charset="UTF-8">
<input type="hidden" name="m_shop" value="<?=$m_shop?>">
<input type="hidden" name="m_orderid" value="<?=$m_orderid?>">
<input type="hidden" name="m_amount" value="<?=$m_amount?>">
<input type="hidden" name="m_curr" value="<?=$m_curr?>">
<input type="hidden" name="m_desc" value="<?=$m_desc?>">
<input type="hidden" name="m_sign" value="<?=$sign?>">
<input type="submit" class='button' name="m_process" value="��������">
</form>
<?
}

if ($yoomoney_in == 1)
{
?>
<br>
<br>
<div style="width: 100%; height: 15px; background: #f5fff9; background: linear-gradient(to left, #ffffff, #e2eefc);"></div>
<br>
<div style='background: url(../images/yandex_logo.png); background-size: cover; width: 20px; height: 20px; float: left; margin: -5px 5px 0px 0px;'></div>
<div style='font-size: 150%;'><b>������ ����� <FONT color='#6b1ee0'>�</FONT>Money</b></div>
<br>
<FONT color='#999999'>
�������� �������� �������: 0.5%
<br>
���� ��������: <? echo $k_yoomoney_in; ?>%
</FONT>
<br>
<br>
<?
$desc = $DOMEN.' : ���������� ������� �������� '.$username;
$desc_u = $DOMEN.' : ���������� ������� �������� '.$username;
$domen_ya = "$protocol$domen2/payed.php";
?>
<form method="post" action="https://money.yandex.ru/quickpay/confirm.xml" accept-charset="UTF-8">
<input type="hidden" name="receiver" value="<?=$admin_yoomoney?>">
<input type="hidden" name="quickpay-form" value="shop">
<input type="hidden" name="targets" value="<?=$desc?>">
<input type="hidden" name="paymentType" value="PC">
<input type="hidden" name="sum" value="<?=$sum?>">
<input type="hidden" name="formcomment" value="<?=$desc_u?>">
<input type="hidden" name="short-dest" value="<?=$desc_u?>">
<input type="hidden" name="label" value="<?=$username?>">
<input type="hidden" name="successURL" value="<?=$domen_ya?>">
<?
if ($sum < 2)
{
?>
<FONT color=red><b>����������� ����� ���������� ����� �Money - 2 �����</b></FONT>
<br>
<input type="text" readonly='readonly' class='texte' value="��������">
<?
}
else
{
?>
<input type="submit" class='button' value="��������">
<?
}
?>
</form>
<?
}

if ($qiwi_in == 1)
{
?>
<br>
<br>
<div style="width: 100%; height: 15px; background: #f5fff9; background: linear-gradient(to left, #ffffff, #e2eefc);"></div>
<br>
<div style='background: url(../images/qiwi_logo.png); background-size: cover; width: 22px; height: 22px; float: left; margin: -4px 5px 0px 0px;'></div>
<div style='font-size: 150%;'><b>������ ����� <FONT color=#ff8c00>QIWI</FONT></b></div>
<br>
<FONT color='#999999'>
�������� �������� �������: 1%
<br>
���� ��������: <? echo $k_qiwi_in; ?>%
</FONT>
<br>
<br>
<?
$domen_qw = "$protocol$domen2/payed.php";
?>
<form method="get" action="https://oplata.qiwi.com/create" accept-charset="UTF-8">
<input type="hidden" name="customFields[apiClient]" value="php_sdk">
<input type="hidden" name="customFields[apiClientVersion]" value="0.1.0">
<input type="hidden" name="customFields[themeCode]" value="<?=$qiwi_style;?>">
<input type="hidden" name="publicKey" value="<?=$qiwi_public_key;?>">
<input type="hidden" name="amount" value="<?=$sum;?>">
<input type="hidden" name="phone" value="<?=$qiwi;?>">
<input type="hidden" name="account" value="<?=$user_id;?>">
<input type="hidden" name="comment" value="���������� ������� �������� <?=$username?> � ������� <?=$DOMEN?>">
<input type="hidden" name="paySource" value="qw">
<input type="hidden" name="successUrl" value="<?=$domen_qw;?>">
<?
if ($sum < 1)
{
?>
<FONT color=red><b>����������� ����� ���������� ����� Qiwi - 1 �����</b></FONT>
<br>
<input type="text" readonly='readonly' class='texte' value="��������">
<?
}
else
{
?>
<input type="submit" class='button' value="��������">
<?
}
?>
</form>
<?
}

if ($interkassa_in == 1)
{
?>
<br>
<br>
<div style="width: 100%; height: 15px; background: #f5fff9; background: linear-gradient(to left, #ffffff, #e2eefc);"></div>
<br>
<div style='background: url(../images/ik_logo.png); background-size: cover; width: 20px; height: 22px; float: left; margin: -5px 5px 0px 0px;'></div>
<div style='font-size: 150%;'><b>������ ����� <FONT color=#231f20>inter</FONT><FONT color=#09994a>kassa</FONT></b></div>
<br>
<FONT color='#999999'>
�������� �������� �������: ������� �� ���������� ���������
<br>
���� ��������: <? echo $k_interkassa_in; ?>%
</FONT>
<br>
<br>
<?
include('interkassa_images.php');
?>
<div style='margin-top: 10px;'></div>
<?
$ik_pm_no=time();
$ikform = <<<IKFORM
<form name="payment" method="post" action="https://sci.interkassa.com/" accept-charset="UTF-8">
<input type="hidden" name="ik_co_id" value="{$admin_interkassa}">
<input type="hidden" name="ik_pm_no" value="{$ik_pm_no}">
<input type="hidden" name="ik_am" value="{$sum}">
<input type="hidden" name="ik_desc" value="���������� ������� �������� {$username} � ������� {$DOMEN}">
<input type="hidden" name="ik_x_user" value="{$username}">
<input type="submit" class='button' value="��������">
</form>
IKFORM;
echo $ikform;
}
?>

</div>

<?
}
else
{
?>

<div id='form' style='width: 100%; font-size: 120%; line-height: 25px;'>
<style>
#form input.sum {
  width: 70px;
  height: 20px;
  border: 1px solid #15922F;
  background-color:#ffffff;
  color: 000000;
  margin-top: 5px;
}
#form input.pay_in_out {
  width: 150px;
  height: 22px;
  line-height: 20px;
  font-size: 110%;
  border: 0px;
  background: #0f7d26;
  background: linear-gradient(to top, #0f7d26, #789a00);
  outline: none;
  border-radius: 5px;
  color: white;
} 
#form input.pay_in_out:hover {
  background: #0f7d26;
  clip-path: polygon(90% 0%, 100% 50%, 90% 100%, 0% 100%, 0% 0%);
}
#form input.pay_in_out:active { background: #789a00; }
</style>

<form method="post" action="cashin.php">
<table width='100%'>
<tr>
<td width='25%'>
�������:
<br>
������� ������:
<br>
<br>
��������� �� �����&nbsp;&nbsp;
</td>
<td width='75%'>
<?= $row["username"] ?>
<br>
<b><?= $row["money"] ?> ���.</b>
<br>
<br>
<input type="text" maxlength='7' size='10' class="sum" value="" name="sum" id="sum"> ���.

<script>
sum = document.getElementById('sum')
sum.onkeyup = function(){this.value = this.value.replace(/[^0-9\.]/g,'')}
</script>

</td>
</tr>
</table>
<br>
<input type="submit" value="���������" class="pay_in_out">
</form>
</div>
<br>
<br>
<div class="attention">
���������� ������� �� ������ �������� ���������� ������������� ����� ����� ������. ���� ����� �� ��������� - ����������, ����������, � ��������������.
</div>

<?
}
}
else
{
include('noauth.php');
}
include('footer.php');
?>
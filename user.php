<?
include('header.php');

if(isset($_COOKIE["usNick"]) && isset($_COOKIE["usPass"]))
{
$username=($_COOKIE["usNick"]);
$action=$_GET["action"];

$sqlwmout = "SELECT * FROM tb_config WHERE item='webmoney_out'";
$resultwmout = mysqli_query($connect, $sqlwmout);
$rowwmout = mysqli_fetch_array($resultwmout);
$webmoney_out=$rowwmout["description"];

$sqlpout = "SELECT * FROM tb_config WHERE item='payeer_out'";
$resultpout = mysqli_query($connect, $sqlpout);
$rowpout = mysqli_fetch_array($resultpout);
$payeer_out=$rowpout["description"];

$sqlyaout = "SELECT * FROM tb_config WHERE item='yoomoney_out'";
$resultyaout = mysqli_query($connect, $sqlyaout);
$rowyaout = mysqli_fetch_array($resultyaout);
$yoomoney_out=$rowyaout["description"];

$sqlqwout = "SELECT * FROM tb_config WHERE item='qiwi_out'";
$resultqwout = mysqli_query($connect, $sqlqwout);
$rowqwout = mysqli_fetch_array($resultqwout);
$qiwi_out=$rowqwout["description"];

$pay_systems=$webmoney_out+$payeer_out+$yoomoney_out+$qiwi_out;

$sql = "SELECT * FROM tb_users WHERE username='$username'";
$result = mysqli_query($connect, $sql);        
$row = mysqli_fetch_array($result);
$referer = $row["referer"];

if(isset($_COOKIE["usNick"]) && isset($_COOKIE["usPass"])){echo "<br>";}else{echo "<br><br>";}

$sqlxuu = "SELECT * FROM tb_ref_premiums WHERE referal='$username' order by id DESC limit 1";
$resultxuu = mysqli_query($connect, $sqlxuu);        
$rowxuu = mysqli_fetch_array($resultxuu);
$referer2=$rowxuu['referer'];
$sum=$rowxuu['sum'];
$coment=$rowxuu['coment'];
$datetime=$rowxuu['datetime'];
$realtime=time();

if ($datetime+604800 > $realtime)
{
if ($coment == NULL)
{
echo "<center><div id=\"commentform\" style=\"width: 100%; border:1px solid #198C03; background-color:#B5FFA6;\"><b>� ���� ������ �� ����������� ����� ��������� <FONT color=green>$referer2</FONT> �� ����� $sum ���.</b></div></center><br>";
}
else
{
echo "<center><div id=\"commentform\" style=\"width: 100%; border:1px solid #198C03; background-color:#B5FFA6;\"><b>� ���� ������ �� ����������� ����� ��������� <FONT color=green>$referer2</FONT> �� ����� $sum ���.</b><br>����������� ��������:<br>$coment</div></center><br>";
}
}
?>

<div id="utables" style='line-height: 160%;'>
<table width="100%">
<tr>
<td colspan="2" align="center" width="100%" style='background-color: #ffffad; color: #bf051e;'>
<div style='margin-top: 7px;'></div>
<b>���������� �������� ID: <? echo $row["id"]; ?></b>
<div style='margin-top: 7px;'></div>
</td>
</tr>
<tr>
<td align="left" width="50%">
���� ����������� ��������
</td>
<td align="right" width="50%">
<? echo $row["joindate"]; ?> ����&nbsp;&nbsp;
</td>
</tr>
<tr>
<td align="left" width="50%">
����������� �� ����������� ������������ (�������)
</td>
<td align="right" width="50%">
<? if ($referer=="") {echo "��� �������� [ <a href='referer_designate.php' title='��������� ��������'>���������</a> ]";}else{echo "<a href='whois.php?user=$referer' title='��� ���?'><FONT color=green><b>$referer</b></FONT></a> [ <a href=\"mail_torefr.php?to=$referer\" title=\"��������� �������� ���������\">��������� ���������</a> | <a href='bonuses_from_referer.php' title='������ �� ��������'>������</a> | <a href='premiums_from_referer.php' title='������ �� ��������'>������</a> ]";} ?>&nbsp;&nbsp;
</td>
</tr>
<tr>
<td align="left" width="50%">
������� ��������� ��������
</td>
<td align="right" width="50%">
<? if ($row["account"]=="active") {echo "<font color=green>������� �������</font>";}elseif ($row["account"]=="blocked") {echo "<font color=red>������� �������� ������������</font>";}elseif ($row["account"]=="fullblocked") {echo "<font color=red>������� ��������� ������������</font>";} ?>&nbsp;&nbsp;
</td>
</tr>
<tr>
<td align="left" width="50%">
����� ����������� ��������� ������
</td>
<td align="right" width="50%">
<? echo $row["visits"]; ?>&nbsp;&nbsp;
</td>
</tr>
<tr>
<td align="left" width="50%">
����� ��������� �������
</td>
<td align="right" width="50%">
<? echo $row["alltasks"]; ?>&nbsp;&nbsp;
</td>
</tr>
<tr>
<td align="left" width="50%">
���������� ����� ������������� (���������)
</td>
<td align="right" width="50%">
<? echo $row["referals"]; ?> ���. [ <a href="referals.php" title="������ ���������">������ ���������</a> | <a href="reflinks.php" title="��������� ���������">��������� ���������</a> ]&nbsp;&nbsp;
</td>
</tr>
<tr>
<td align="left" width="50%">
��������� ���������� ��������
</td>
<td align="right" width="50%">
<? echo $row["lastlogdate"]; ?> ���� � IP-������ <? echo $row["lastiplog"]; ?><img src='images/earth.png' width='17' height='17' style='float: right; margin: 0px 5px 2px 5px'>
</td>
</tr>
<tr>
<td colspan="2" align="center" width="100%" style='background-color: #ffffad; color: #bf051e;'>
<div style='margin-top: 7px;'></div>
<b>���������� ������</b>
<div style='margin-top: 7px;'></div>
</td>
</tr>
<tr>
<td align="left" width="50%">
������ �� ����������� ������
</td>
<td align="right" width="50%">
<? $dohod=$row["dohod"]; echo $dohod;  ?> ���.&nbsp;&nbsp;
</td>
</tr>
<tr>
<td align="left" width="50%">
������ �� ���������
</td>
<td align="right" width="50%">
<? $ref_dohod=$row["ref_dohod"]; echo $ref_dohod; ?> ���.&nbsp;&nbsp;
</td>
</tr>
<tr>
<td align="left" width="50%">
����� ����������
</td>
<td align="right" width="50%">
<? $all_dohod=$dohod+$ref_dohod; echo $all_dohod; ?> ���.&nbsp;&nbsp;
</td>
</tr>
<tr>
<td align="left" width="50%">
�������� �� �������
</td>
<td align="right" width="50%">
<? echo $row["paid"]; ?> ���. [ <a href="payhistory.php" title="������� ������">������� ������</a> ]&nbsp;&nbsp;
</td>
</tr>
<tr>
<td align="left" width="50%">
<b>������� �� ����� (������)</b>
</td>
<td align="right" width="50%">
<b><? echo $row["money"]; ?> ���.</b> [ <a href="cashout.php" title="����� ������� �� WebMoney ������">�������</a> | <a href="cashin.php" title="���������� ������� ��������">������</a> | <a href="advfrombacc.php" title="���������� ������� �� ���� ������� ��������">������ �������</a> ]&nbsp;&nbsp;
</td>
</tr>
<tr>
<td colspan="2" align="center" width="100%" style='background-color: #ffffad; color: #bf051e;'>
<div style='margin-top: 7px;'></div>
<b>������ �������</b> [ <a href="profiledit.php" title="�������������� ������ �������">������ ���������</a> | <a href="avatar.php" title="��������� �������">��������� ������</a> ]
<div style='margin-top: 7px;'></div>
</td>
</tr>
<tr>
<td align="left" width="50%">
��� ��������� ��������
</td>
<td align="right" width="50%">
<? if ($row["name"]=="") {echo "�� ������� - <a href='profiledit.php'>�������</a>";}else{echo $row["name"];} ?>&nbsp;&nbsp;
</td>
</tr>
<tr>
<td align="left" width="50%">
����� ����������� �����
</td>
<td align="right" width="50%">
<? echo $row["email"]; ?><div style='background: url(../images/e_mail.png); background-size: cover; width: 16px; height: 16px; float: right; margin: 2px 5px 2px 5px;'></div>
</td>
</tr>
<tr>
<td align="left" width="50%">
������ �����������
</td>
<td align="right" width="50%">
<? if ($row["country"]=="") {echo "�� �������";}else{echo $row["country"];} if ($row["geo_ver"]=='0') {echo" [ <a href='geo_check.php' title='����������� ������ ��������������� ��������� (������)'>���-�����������</a> ]";} ?>
<?
$country=$row["country"];
if ($country=='������'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/russia.png' width='18' height='14' alt=''>";}
elseif ($country=='�������'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/ukraine.png' width='18' height='14' alt=''>";}
elseif ($country=='���������'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/kazakhstan.png' width='18' height='14' alt=''>";}
elseif ($country=='������'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/georgia.png' width='18' height='14' alt=''>";}
elseif ($country=='����������'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/uzbekistan.png' width='18' height='14' alt=''>";}
elseif ($country=='��������'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/belarus.png' width='18' height='14' alt=''>";}
elseif ($country=='�������'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/moldova.png' width='18' height='14' alt=''>";}
elseif ($country=='������'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/latvia.png' width='18' height='14' alt=''>";}
elseif ($country=='�����'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/lithuania.png' width='18' height='14' alt=''>";}
elseif ($country=='�������'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/estonia.png' width='18' height='14' alt=''>";}
elseif ($country=='��������'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/germany.png' width='18' height='14' alt=''>";}
elseif ($country=='�������'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/france.png' width='18' height='14' alt=''>";}
elseif ($country=='������'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/england.png' width='18' height='14' alt=''>";}
elseif ($country=='������'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/poland.png' width='18' height='14' alt=''>";}
elseif ($country=='������'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/italy.png' width='18' height='14' alt=''>";}
elseif ($country=='���������'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/finland.png' width='18' height='14' alt=''>";}
elseif ($country=='�������'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/armenia.png' width='18' height='14' alt=''>";}
elseif ($country=='���'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/usa.png' width='20' height='14' alt=''>";}
elseif ($country=='�����'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/china.png' width='18' height='14' alt=''>";}
elseif ($country=='�����'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/india.png' width='18' height='14' alt=''>";}
?>
</td>
</tr>
<?
if ($pay_systems > 0)
{
?>
<tr>
<td colspan="2" align="center" width="100%" style='background-color: #ffffad; color: #bf051e;'>
<div style='margin-top: 7px;'></div>
<b>�������� ���������</b>
<div style='margin-top: 7px;'></div>
</td>
</tr>
<?
if ($webmoney_out > 0)
{
?>
<tr>
<td align="left" width="50%">
<b><FONT color='#057cb4'>WebMoney</FONT></b> id
</td>
<td align="right" width="50%">
<? if ($row["wmid"]=="") {echo "�� ������ - <a href='check_wm.php'>�������</a>";}else{echo "<a href='http://passport.webmoney.ru/asp/certview.asp?wmid=$row[wmid]' title='���������� � WebMoney id $row[wmid]' target='_blank'>$row[wmid]</a>";} ?><div style='background: url(../images/wm_logo.png); background-size: cover; width: 16px; height: 16px; float: right; margin: 2px 5px 2px 5px;'></div>
</td>
</tr>
<tr>
<td align="left" width="50%">
����� WMR-��������
</td>
<td align="right" width="50%">
<? if ($row["pemail"]=="") {echo "�� ������ - <a href='check_wm.php'>�������</a>";}else{echo $row["pemail"];} ?><div style='background: url(../images/wm_logo.png); background-size: cover; width: 16px; height: 16px; float: right; margin: 2px 5px 2px 5px;'></div>
</td>
</tr>
<?
}
if ($payeer_out > 0)
{
?>
<tr>
<td align="left" width="50%">
����� <b><FONT color='#3e3e3e'>PAY</FONT><FONT color='#41a3d9'>EER</FONT></b>-��������
</td>
<td align="right" width="50%">
<? if ($row["payeer"]=="") {echo "�� ������ - <a href='check_payeer.php'>�������</a>";}else{echo $row["payeer"];} ?><div style='background: url(../images/payeer_logo.png); background-size: cover; width: 16px; height: 16px; float: right; margin: 2px 5px 2px 5px;'></div>
</td>
</tr>
<?
}
if ($yoomoney_out > 0)
{
?>
<tr>
<td align="left" width="50%">
����� <b><FONT color='#6b1ee0'>�</FONT>Money</b>-��������
</td>
<td align="right" width="50%">
<? if ($row["yoomoney"]=="") {echo "�� ������ - <a href='check_yoomoney.php'>�������</a>";}else{echo $row["yoomoney"];} ?><div style='background: url(../images/yandex_logo.png); background-size: cover; width: 16px; height: 16px; float: right; margin: 0px 5px 4px 5px;'></div>
</td>
</tr>
<?
}
if ($qiwi_out > 0)
{
?>
<tr>
<td align="left" width="50%">
����� <b><FONT color=#ed8b14>QIWI</FONT></b>-��������
</td>
<td align="right" width="50%">
<? if ($row["qiwi"]=="") {echo "�� ������ - <a href='check_qiwi.php'>�������</a>";}else{echo $row["qiwi"];} ?><div style='background: url(../images/qiwi_logo.png); background-size: cover; width: 16px; height: 16px; float: right; margin: 2px 5px 2px 5px;'></div>
</td>
</tr>
<?
}
}
?>
</table>
</div>

<?
$sqlal="SELECT COUNT(*) as count from tb_catalogue WHERE owner='$username'";
$queryal=mysqli_query($connect, $sqlal);
$rowal=mysqli_fetch_array($queryal);
$myreg_count=$rowal['count'];

if ($myreg_count > 0)
{
?>

<div id="utables" style='line-height: 150%;'>
<table width="100%">
<tr>
<td colspan="2" align="center" width="100%" style='background-color: #ffffad; color: #bf051e;'>
<div style='margin-top: 7px;'></div>
<b>��� ����� � ��������</b>
<div style='margin-top: 7px;'></div>
</td>
</tr>

<?
$tabla = mysqli_query($connect, "SELECT * FROM tb_catalogue WHERE owner='$username' ORDER BY id DESC");
while ($registro = mysqli_fetch_array($tabla))
{
echo "<tr><td align='left' width='50%'><a href='$registro[link]' title='$registro[title]' target='_blank'>$registro[link]</a><br>&nbsp;&nbsp;[ <a href='edit_siteinfo.php?id=$registro[id]' title='������������� ������ � �����'><FONT color='#999999'>������������� ������</FONT></a> | <a href='del_site.php?id=$registro[id]' title='������� ����� �� ��������'><FONT color='#F96666'>������� �� ��������</FONT></a> ]</td><td align='right' width='50%'>���� $registro[verify]&nbsp;&nbsp;</td></tr>";
}
?>

</table>
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
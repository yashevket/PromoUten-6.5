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
echo "<center><div id=\"commentform\" style=\"width: 100%; border:1px solid #198C03; background-color:#B5FFA6;\"><b>В этом месяце вы премированы вашим реферером <FONT color=green>$referer2</FONT> на сумму $sum руб.</b></div></center><br>";
}
else
{
echo "<center><div id=\"commentform\" style=\"width: 100%; border:1px solid #198C03; background-color:#B5FFA6;\"><b>В этом месяце вы премированы вашим реферером <FONT color=green>$referer2</FONT> на сумму $sum руб.</b><br>Комментарий реферера:<br>$coment</div></center><br>";
}
}
?>

<div id="utables" style='line-height: 160%;'>
<table width="100%">
<tr>
<td colspan="2" align="center" width="100%" style='background-color: #ffffad; color: #bf051e;'>
<div style='margin-top: 7px;'></div>
<b>Статистика аккаунта ID: <? echo $row["id"]; ?></b>
<div style='margin-top: 7px;'></div>
</td>
</tr>
<tr>
<td align="left" width="50%">
Дата регистрации аккаунта
</td>
<td align="right" width="50%">
<? echo $row["joindate"]; ?> года&nbsp;&nbsp;
</td>
</tr>
<tr>
<td align="left" width="50%">
Регистрация по приглашению пользователя (реферер)
</td>
<td align="right" width="50%">
<? if ($referer=="") {echo "нет реферера [ <a href='referer_designate.php' title='Назначить реферера'>назначить</a> ]";}else{echo "<a href='whois.php?user=$referer' title='Кто это?'><FONT color=green><b>$referer</b></FONT></a> [ <a href=\"mail_torefr.php?to=$referer\" title=\"Отправить рефереру сообщение\">отправить сообщение</a> | <a href='bonuses_from_referer.php' title='Бонусы от реферера'>бонусы</a> | <a href='premiums_from_referer.php' title='Премии от реферера'>премии</a> ]";} ?>&nbsp;&nbsp;
</td>
</tr>
<tr>
<td align="left" width="50%">
Текущее состояние аккаунта
</td>
<td align="right" width="50%">
<? if ($row["account"]=="active") {echo "<font color=green>аккаунт активен</font>";}elseif ($row["account"]=="blocked") {echo "<font color=red>аккаунт частично заблокирован</font>";}elseif ($row["account"]=="fullblocked") {echo "<font color=red>аккаунт полностью заблокирован</font>";} ?>&nbsp;&nbsp;
</td>
</tr>
<tr>
<td align="left" width="50%">
Всего просмотрено рекламных сайтов
</td>
<td align="right" width="50%">
<? echo $row["visits"]; ?>&nbsp;&nbsp;
</td>
</tr>
<tr>
<td align="left" width="50%">
Всего выполнено заданий
</td>
<td align="right" width="50%">
<? echo $row["alltasks"]; ?>&nbsp;&nbsp;
</td>
</tr>
<tr>
<td align="left" width="50%">
Привлечено новых пользователей (рефералов)
</td>
<td align="right" width="50%">
<? echo $row["referals"]; ?> чел. [ <a href="referals.php" title="Список рефералов">список рефералов</a> | <a href="reflinks.php" title="Рекламные материалы">рекламные материалы</a> ]&nbsp;&nbsp;
</td>
</tr>
<tr>
<td align="left" width="50%">
Последняя активность аккаунта
</td>
<td align="right" width="50%">
<? echo $row["lastlogdate"]; ?> года с IP-адреса <? echo $row["lastiplog"]; ?><img src='images/earth.png' width='17' height='17' style='float: right; margin: 0px 5px 2px 5px'>
</td>
</tr>
<tr>
<td colspan="2" align="center" width="100%" style='background-color: #ffffad; color: #bf051e;'>
<div style='margin-top: 7px;'></div>
<b>Результаты работы</b>
<div style='margin-top: 7px;'></div>
</td>
</tr>
<tr>
<td align="left" width="50%">
Доходы от собственной работы
</td>
<td align="right" width="50%">
<? $dohod=$row["dohod"]; echo $dohod;  ?> руб.&nbsp;&nbsp;
</td>
</tr>
<tr>
<td align="left" width="50%">
Доходы от рефералов
</td>
<td align="right" width="50%">
<? $ref_dohod=$row["ref_dohod"]; echo $ref_dohod; ?> руб.&nbsp;&nbsp;
</td>
</tr>
<tr>
<td align="left" width="50%">
Итого заработано
</td>
<td align="right" width="50%">
<? $all_dohod=$dohod+$ref_dohod; echo $all_dohod; ?> руб.&nbsp;&nbsp;
</td>
</tr>
<tr>
<td align="left" width="50%">
Выведено из системы
</td>
<td align="right" width="50%">
<? echo $row["paid"]; ?> руб. [ <a href="payhistory.php" title="История выплат">история выплат</a> ]&nbsp;&nbsp;
</td>
</tr>
<tr>
<td align="left" width="50%">
<b>Остаток на счету (баланс)</b>
</td>
<td align="right" width="50%">
<b><? echo $row["money"]; ?> руб.</b> [ <a href="cashout.php" title="Вывод средств на WebMoney кошелёк">вывести</a> | <a href="cashin.php" title="Пополнение баланса аккаунта">ввести</a> | <a href="advfrombacc.php" title="Размещение рекламы за счёт баланса аккаунта">купить рекламу</a> ]&nbsp;&nbsp;
</td>
</tr>
<tr>
<td colspan="2" align="center" width="100%" style='background-color: #ffffad; color: #bf051e;'>
<div style='margin-top: 7px;'></div>
<b>Данные профиля</b> [ <a href="profiledit.php" title="Редактирование данных профиля">внести изменения</a> | <a href="avatar.php" title="Настройка аватара">настроить аватар</a> ]
<div style='margin-top: 7px;'></div>
</td>
</tr>
<tr>
<td align="left" width="50%">
Имя владельца аккаунта
</td>
<td align="right" width="50%">
<? if ($row["name"]=="") {echo "не указано - <a href='profiledit.php'>указать</a>";}else{echo $row["name"];} ?>&nbsp;&nbsp;
</td>
</tr>
<tr>
<td align="left" width="50%">
Адрес электронной почты
</td>
<td align="right" width="50%">
<? echo $row["email"]; ?><div style='background: url(../images/e_mail.png); background-size: cover; width: 16px; height: 16px; float: right; margin: 2px 5px 2px 5px;'></div>
</td>
</tr>
<tr>
<td align="left" width="50%">
Страна регистрации
</td>
<td align="right" width="50%">
<? if ($row["country"]=="") {echo "не указана";}else{echo $row["country"];} if ($row["geo_ver"]=='0') {echo" [ <a href='geo_check.php' title='Верификация вашего географического положения (страны)'>гео-верификация</a> ]";} ?>
<?
$country=$row["country"];
if ($country=='Россия'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/russia.png' width='18' height='14' alt=''>";}
elseif ($country=='Украина'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/ukraine.png' width='18' height='14' alt=''>";}
elseif ($country=='Казахстан'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/kazakhstan.png' width='18' height='14' alt=''>";}
elseif ($country=='Грузия'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/georgia.png' width='18' height='14' alt=''>";}
elseif ($country=='Узбекистан'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/uzbekistan.png' width='18' height='14' alt=''>";}
elseif ($country=='Беларусь'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/belarus.png' width='18' height='14' alt=''>";}
elseif ($country=='Молдова'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/moldova.png' width='18' height='14' alt=''>";}
elseif ($country=='Латвия'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/latvia.png' width='18' height='14' alt=''>";}
elseif ($country=='Литва'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/lithuania.png' width='18' height='14' alt=''>";}
elseif ($country=='Эстония'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/estonia.png' width='18' height='14' alt=''>";}
elseif ($country=='Германия'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/germany.png' width='18' height='14' alt=''>";}
elseif ($country=='Франция'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/france.png' width='18' height='14' alt=''>";}
elseif ($country=='Англия'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/england.png' width='18' height='14' alt=''>";}
elseif ($country=='Польша'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/poland.png' width='18' height='14' alt=''>";}
elseif ($country=='Италия'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/italy.png' width='18' height='14' alt=''>";}
elseif ($country=='Финляндия'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/finland.png' width='18' height='14' alt=''>";}
elseif ($country=='Армения'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/armenia.png' width='18' height='14' alt=''>";}
elseif ($country=='США'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/usa.png' width='20' height='14' alt=''>";}
elseif ($country=='Китай'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/china.png' width='18' height='14' alt=''>";}
elseif ($country=='Индия'){echo "<img style='float: right; margin: 2px 5px 2px 5px;' src='images/country/india.png' width='18' height='14' alt=''>";}
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
<b>Платёжные реквизиты</b>
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
<? if ($row["wmid"]=="") {echo "не указан - <a href='check_wm.php'>указать</a>";}else{echo "<a href='http://passport.webmoney.ru/asp/certview.asp?wmid=$row[wmid]' title='Информация о WebMoney id $row[wmid]' target='_blank'>$row[wmid]</a>";} ?><div style='background: url(../images/wm_logo.png); background-size: cover; width: 16px; height: 16px; float: right; margin: 2px 5px 2px 5px;'></div>
</td>
</tr>
<tr>
<td align="left" width="50%">
Номер WMR-кошелька
</td>
<td align="right" width="50%">
<? if ($row["pemail"]=="") {echo "не указан - <a href='check_wm.php'>указать</a>";}else{echo $row["pemail"];} ?><div style='background: url(../images/wm_logo.png); background-size: cover; width: 16px; height: 16px; float: right; margin: 2px 5px 2px 5px;'></div>
</td>
</tr>
<?
}
if ($payeer_out > 0)
{
?>
<tr>
<td align="left" width="50%">
Номер <b><FONT color='#3e3e3e'>PAY</FONT><FONT color='#41a3d9'>EER</FONT></b>-кошелька
</td>
<td align="right" width="50%">
<? if ($row["payeer"]=="") {echo "не указан - <a href='check_payeer.php'>указать</a>";}else{echo $row["payeer"];} ?><div style='background: url(../images/payeer_logo.png); background-size: cover; width: 16px; height: 16px; float: right; margin: 2px 5px 2px 5px;'></div>
</td>
</tr>
<?
}
if ($yoomoney_out > 0)
{
?>
<tr>
<td align="left" width="50%">
Номер <b><FONT color='#6b1ee0'>Ю</FONT>Money</b>-кошелька
</td>
<td align="right" width="50%">
<? if ($row["yoomoney"]=="") {echo "не указан - <a href='check_yoomoney.php'>указать</a>";}else{echo $row["yoomoney"];} ?><div style='background: url(../images/yandex_logo.png); background-size: cover; width: 16px; height: 16px; float: right; margin: 0px 5px 4px 5px;'></div>
</td>
</tr>
<?
}
if ($qiwi_out > 0)
{
?>
<tr>
<td align="left" width="50%">
Номер <b><FONT color=#ed8b14>QIWI</FONT></b>-кошелька
</td>
<td align="right" width="50%">
<? if ($row["qiwi"]=="") {echo "не указан - <a href='check_qiwi.php'>указать</a>";}else{echo $row["qiwi"];} ?><div style='background: url(../images/qiwi_logo.png); background-size: cover; width: 16px; height: 16px; float: right; margin: 2px 5px 2px 5px;'></div>
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
<b>Мои сайты в каталоге</b>
<div style='margin-top: 7px;'></div>
</td>
</tr>

<?
$tabla = mysqli_query($connect, "SELECT * FROM tb_catalogue WHERE owner='$username' ORDER BY id DESC");
while ($registro = mysqli_fetch_array($tabla))
{
echo "<tr><td align='left' width='50%'><a href='$registro[link]' title='$registro[title]' target='_blank'>$registro[link]</a><br>&nbsp;&nbsp;[ <a href='edit_siteinfo.php?id=$registro[id]' title='Редактировать данные о сайте'><FONT color='#999999'>редактировать данные</FONT></a> | <a href='del_site.php?id=$registro[id]' title='Удалить сайта из каталога'><FONT color='#F96666'>удалить из каталога</FONT></a> ]</td><td align='right' width='50%'>сайт $registro[verify]&nbsp;&nbsp;</td></tr>";
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
<? 
include('header.php');

if(isset($_COOKIE["usNick"]) && isset($_COOKIE["usPass"]))
{
$usr=$_COOKIE["usNick"];
$DOMEN=strtoupper($_SERVER['HTTP_HOST']);

$sqlpout = "SELECT * FROM tb_config WHERE item='payeer_out'";
$resultpout = mysqli_query($connect, $sqlpout);
$rowpout = mysqli_fetch_array($resultpout);
$payeer_out=$rowpout["description"];

$sqlce = "SELECT * FROM tb_users WHERE username='$usr'";
$resultce = mysqli_query($connect, $sqlce);        
$rowce = mysqli_fetch_array($resultce);
$payeere = $rowce["payeer"];

if ($payeer_out < 1)
{
echo "<br><br><br><br><br><br><br><center><img src='images/stop.png'><br><b>Платёжная система PAYEER отключена</b><br><br><a href='javascript:history.go(-1)'>вернуться назад</a></center>";
include('footer.php');
exit();
}

if ($payeere != NULL)
{
echo "<br><br><br><br><br><br><br><center><img src='images/stop.png'><br><b>Номер PAYEER-кошелька уже указан</b><br><br><a href='javascript:history.go(-1)'>вернуться назад</a></center>";
include('footer.php');
exit();
}

if (isset($_POST["payeer"])) 
{
$payeer_purse = $_POST["payeer"];
$payeer_purse = trim($payeer_purse); // Удаляем пробелы в начале и в конце строки

if ($payeer_purse==NULL)
{
echo "<br><br><br><br><br><br><br><center><img src='images/stop.png'><br><b>Укажите номер PAYEER-кошелька</b><br><br><a href='javascript:history.go(-1)'>вернуться назад</a></center>";
include('footer.php');
exit();
}

if (strlen($payeer_purse) < 7)
{
echo "<br><br><br><br><br><br><br><center><img src='images/stop.png'><br><b>Вы некорректно указали номер PAYEER-кошелька<br>Пожалуйста исправьте свою ошибку. Пример: <font color=green>P33702492</font></b><br><br><a href='javascript:history.go(-1)'>вернуться назад</a></center>";
include('footer.php');
exit();
}

$checkpayeer = mysqli_query($connect, "SELECT payeer FROM tb_users WHERE payeer='$payeer_purse'");
$payeer_exist = mysqli_num_rows($checkpayeer);

if ($payeer_exist>0)
{
echo "<br><br><br><br><br><br><br><center><img src='images/stop.png'><br><b>Номер PAYEER-кошелька <font color=red>$payeer_purse</font> уже зарегистрирован</b><br><br><a href='javascript:history.go(-1)'>вернуться назад</a></center>";
include('footer.php');
exit();
}

//------------------------------------------------------------
// Проверка существования PAYEER-кошелька в платёжной системе

$sqlpayeer = "SELECT * FROM tb_config WHERE item='payeer'";
$resultpayeer = mysqli_query($connect, $sqlpayeer);
$rowpayeer = mysqli_fetch_array($resultpayeer);
$admin_payeer = $rowpayeer["description"];

$sqlpayeera = "SELECT * FROM tb_config WHERE item='payeer_api'";
$resultpayeera = mysqli_query($connect, $sqlpayeera);
$rowpayeera = mysqli_fetch_array($resultpayeera);
$payeer_api_id = $rowpayeera["howmany"];
$payeer_api_pass = $rowpayeera["description"];

require_once('cpayeer.php');
$accountNumber = $admin_payeer;
$apiId = $payeer_api_id;
$apiKey = $payeer_api_pass;
$payeer = new CPayeer($accountNumber, $apiId, $apiKey);

if ($payeer->isAuth())
{
if ($payeer->checkUser(array('user' => $payeer_purse,)))
{
$payeer_ex='1';
}
else
{
$payeer_ex='0';
}
}
else
{
// Ошибка авторизации API-пользователя
$payeer_ex='2';
}

if ($payeer_ex == 2)
{
echo "<br><br><br><br><br><br><br><center><img src='images/stop.png'><br><b>Не удалось проверить валидность номера PAYEER-кошелька</b><br><br><a href='javascript:history.go(-1)'>вернуться назад</a></center>";
include('footer.php');
exit();
}

if ($payeer_ex == 0)
{
echo "<br><br><br><br><br><br><br><center><img src='images/stop.png'><br><b>Указан несуществующий номер PAYEER-кошелька</b><br><br><a href='javascript:history.go(-1)'>вернуться назад</a></center>";
include('footer.php');
exit();
}

//------------------------------------------------------------

$query = "UPDATE tb_users SET payeer='$payeer_purse' WHERE username='$usr'";
mysqli_query($connect, $query) or die(mysqli_error());

echo "<br><br><br><br><br><br><br><center><img src='images/added.png'><br><b>Реквизит успешно сохранен</b><br><br><a href='user.php'>перейти в аккаунт</a></center>";
}
else
{
?>

<h3><center>Указание платёжных реквизитов</center></h3>
<br>
<div class="attention">
Обращаем Ваше внимание на то, что в дальнейшем изменить в профиле указанный платёжный реквизит (номер PAYEER-кошелька) будет <u>НЕВОЗМОЖНО</u>. В связи с этим просим Вас быть внимательнее при заполнении этого поля. Будет надёжнее, если Вы скопируете номер в своём PAYEER-аккаунте.
</div>
<br>
<form action="check_payeer.php" method="POST">
<table width="50%">
<tr>
<td><b><FONT color=#3e3e3e>PAY</FONT><FONT color=#41a3d9>EER</FONT></b>-кошелёк</td>
<td><input type="text" size="12" maxlength="15" name="payeer" class="field" value="P" style="width: 200px;"></td>
</tr>
<tr>
<td></td>
<td><br><input type="submit" value="Сохранить" class="green_150"></td>
</tr>
</table>
</form>

<?
}
}
else
{
include('noauth.php');
}
include('footer.php');
?>
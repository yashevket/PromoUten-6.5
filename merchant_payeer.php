<?
if (!in_array($_SERVER['REMOTE_ADDR'], array('185.71.65.92', '185.71.65.189', '149.202.17.210')))
{
exit();
}

if (isset($_POST['m_orderid']) && isset($_POST['m_amount']))
{
require('config/config.php');

$user=$_POST['m_orderid'];
$psumma = $_POST['m_amount'];

$sqlpayeerm = "SELECT * FROM tb_config WHERE item='payeer_merchant'";
$resultpayeerm = mysqli_query($connect, $sqlpayeerm);
$rowpayeerm = mysqli_fetch_array($resultpayeerm);
$m_key = $rowpayeerm["description"];

$arHash = array(
		$_POST['m_operation_id'],
		$_POST['m_operation_ps'],
		$_POST['m_operation_date'],
		$_POST['m_operation_pay_date'],
		$_POST['m_shop'],
		$_POST['m_orderid'],
		$_POST['m_amount'],
		$_POST['m_curr'],
		$_POST['m_desc'],
		$_POST['m_status']
	);

$arHash[] = $m_key;
$sign_hash = strtoupper(hash('sha256', implode(':', $arHash)));

if ($_POST['m_sign'] == $sign_hash)
{
$sqluc="SELECT COUNT(*) as count from tb_users WHERE username='$user'";
$queryuc=mysqli_query($connect, $sqluc);
$rowuc=mysqli_fetch_array($queryuc);
$usc=$rowuc['count'];

$sqlal="SELECT COUNT(*) as count from tb_ordering_visits WHERE order_id='$user'";
$queryal=mysqli_query($connect, $sqlal);
$rowal=mysqli_fetch_array($queryal);
$alc=$rowal['count'];

$sqlba="SELECT COUNT(*) as count from tb_ordering_banner WHERE order_id='$user'";
$queryba=mysqli_query($connect, $sqlba);
$rowba=mysqli_fetch_array($queryba);
$bac=$rowba['count'];

//---------------------------------------------------------------------------------------------------------------------------------------
// Пополняем баланс аккаунта т.к. в поле m_orderid полученном от сервера PAYEER содержится имя пользователя (username) 
//---------------------------------------------------------------------------------------------------------------------------------------

if ($usc > 0 && $alc < 1 && $bac < 1)
{
$sqlp = "SELECT * FROM tb_config WHERE item='payeer_in'";
$resultp = mysqli_query($connect, $sqlp);
$rowp = mysqli_fetch_array($resultp);
$k_payeer_in=$rowp["price"];

$sqlu = "SELECT * FROM tb_cashin WHERE user='$user'";
$resultu = mysqli_query($connect, $sqlu);
$rowu = mysqli_fetch_array($resultu);
$summa = $rowu["summa"];

if ($psumma != $summa)
{
echo $_POST['m_orderid'].'|error';
}
else
{
// Проверка текущего баланса аккаунта
$sqlue = "SELECT * FROM tb_users WHERE username='$user'";
$resultue = mysqli_query($connect, $sqlue);
$rowue = mysqli_fetch_array($resultue);
$balance = $rowue["money"];

$komisiya = $summa/100*$k_payeer_in;
$summa = $summa-$komisiya;
$newbalance = $balance+$summa;

// Обновление баланса аккаунта
$querye = "UPDATE tb_users SET money='$newbalance' WHERE username = '$user'";
mysqli_query($connect, $querye) or die(mysqli_error());

// Удаление временной записи о пополнении
$queryze = "DELETE FROM tb_cashin WHERE user='$user'";
mysqli_query($connect, $queryze) or die(mysqli_error());

//--------------------------------------------------------------------------------
// Логирование движения средств

$sqllog = "SELECT * FROM tb_config WHERE item='administration_mode'";
$resultlog = mysqli_query($connect, $sqllog);        
$rowlog = mysqli_fetch_array($resultlog);
$administration_mode=$rowlog["description"];

if ($administration_mode == 'newbie')
{
$datetimes = date("d.m.Y в H:i:s");

$querylog = "INSERT INTO tb_logs_balance (username, datetime, type, sum, balance_before, balance_after, description) VALUES('$user','$datetimes','+','$summa','$balance','$newbalance','Пополнение баланса аккаунта через ПС PAYEER')";
mysqli_query($connect, $querylog) or die(mysqli_error());
}

//--------------------------------------------------------------------------------

echo $_POST['m_orderid'].'|success';
}
}

//---------------------------------------------------------------------------------------------------------------------------------------


//---------------------------------------------------------------------------------------------------------------------------------------
// Размещение активной рекламы т.к. в поле m_orderid полученном от сервера PAYEER содержится id заказа 
//---------------------------------------------------------------------------------------------------------------------------------------

elseif ($usc < 1 && $alc > 0 && $bac < 1)
{
$order_id=$_POST['m_orderid'];

$sqlu = "SELECT * FROM tb_ordering_visits WHERE order_id='$order_id'";
$resultu = mysqli_query($connect, $sqlu);
$rowu = mysqli_fetch_array($resultu);
$username = $rowu["username"];
$plan = $rowu["plan"];
$active = $rowu["active"];
$url = $rowu["url"];
$description = $rowu["description"];
$price = $rowu["price"];
$datetime = date("d.m.Y в H:i");

if ($psumma != $price)
{
echo $_POST['m_orderid'].'|error';
}
else
{
$query = "INSERT INTO tb_ads (user, datetime, plan, active, url, description) VALUES('$username','$datetime','$plan','$active','$url','$description')";
mysqli_query($connect, $query) or die(mysqli_error());
	  
// Удаление временной записи (из таблицы заказов)
$queryz = "DELETE FROM tb_ordering_visits WHERE order_id='$order_id'";
mysqli_query($connect, $queryz) or die(mysqli_error());

//--------------------------------------------------------------------------------
// Конкурс рекламодателей

$sqlkadv = "SELECT * FROM tb_config_competitions WHERE competition='adv'";
$resultkadv = mysqli_query($connect, $sqlkadv);        
$rowkadv = mysqli_fetch_array($resultkadv);
$competition_adv_active=$rowkadv["active"];

if ($competition_adv_active == 'on' && $username != '')
{
$sqluc="SELECT COUNT(*) as count from tb_competition_adv WHERE user='$username'";
$queryuc=mysqli_query($connect, $sqluc);
$rowuc=mysqli_fetch_array($queryuc);
$usc=$rowuc['count'];

if ($usc > 0)
{
$queryurc = "UPDATE tb_competition_adv SET sum=`sum` +'$price' WHERE user='$username'";
$resultex = mysqli_query($connect, $queryurc);
}
else
{
$queryirc = "INSERT INTO tb_competition_adv (user, sum) VALUES('$username','$price')";
mysqli_query($connect, $queryirc) or die(mysqli_error());
}
}

//--------------------------------------------------------------------------------

echo $_POST['m_orderid'].'|success';
}
}

//---------------------------------------------------------------------------------------------------------------------------------------


//---------------------------------------------------------------------------------------------------------------------------------------
// Размещение баннерной рекламы т.к. в поле m_orderid полученном от сервера PAYEER содержится id заказа баннера
//---------------------------------------------------------------------------------------------------------------------------------------

elseif ($usc < 1 && $alc < 1 && $bac > 0)
{
$border_id=$_POST['m_orderid'];

$sqlub = "SELECT * FROM tb_ordering_banner WHERE order_id='$border_id'";
$resultub = mysqli_query($connect, $sqlub);
$rowub = mysqli_fetch_array($resultub);

if (isset($rowub["order_id"]) && $rowub["order_id"] == $border_id)
{
$ownerb = $rowub["owner"];
$planb = $rowub["plan"];
$urlb = $rowub["url"];
$imgurlb = $rowub["imgurl"];
$price = $rowub["price"];

if ($psumma != $price)
{
echo $_POST['m_orderid'].'|error';
}
else
{
$unixtime=time();
if ($planb=='4686001' | $planb=='10010001' | $planb=='20030001') {$period=604800;}
elseif ($planb=='468601' | $planb=='1001001' | $planb=='2003001') {$period=2592000;}
elseif ($planb=='468602' | $planb=='1001002' | $planb=='2003002') {$period=5184000;}
elseif ($planb=='468603' | $planb=='1001003' | $planb=='2003003') {$period=7776000;}
elseif ($planb=='468606' | $planb=='1001006' | $planb=='2003006') {$period=15552000;}
elseif ($planb=='4686012' | $planb=='10010012' | $planb=='20030012') {$period=31104000;}
$timeout=$unixtime+$period;

if ($planb=='4686001' | $planb=='468601' | $planb=='468602' | $planb=='468603' | $planb=='468606' | $planb=='4686012')
{
// Добавление баннерной рекламы 468x60
$queryscc = "INSERT INTO tb_banner (title, imgurl, linkurl, date, enddate, status, visits, flagv, cnb, timeout, owner) VALUES('','$imgurlb','$urlb','','','','0','0','1','$timeout','$ownerb')";
mysqli_query($connect, $queryscc) or die(mysqli_error());
}
elseif ($planb=='10010001' | $planb=='1001001' | $planb=='1001002' | $planb=='1001003' | $planb=='1001006' | $planb=='10010012')
{
// Добавление баннерной рекламы 100х100
$queryscc = "INSERT INTO tb_banner100x100 (title, imgurl, linkurl, date, enddate, status, visits, flagv, cnb, timeout, owner) VALUES('','$imgurlb','$urlb','','','','0','0','1','$timeout','$ownerb')";
mysqli_query($connect, $queryscc) or die(mysqli_error());
}
else
{
// Добавление баннерной рекламы 200х300
$queryscc = "INSERT INTO tb_banner200x300 (title, imgurl, linkurl, date, enddate, status, visits, flagv, cnb, timeout, owner) VALUES('','$imgurlb','$urlb','','','','0','0','1','$timeout','$ownerb')";
mysqli_query($connect, $queryscc) or die(mysqli_error());
}

// Удаление временной записи (из таблицы заказов)
$queryzeb = "DELETE FROM tb_ordering_banner WHERE order_id='$border_id'";
mysqli_query($connect, $queryzeb) or die(mysqli_error());

//--------------------------------------------------------------------------------
// Конкурс рекламодателей

$sqlkadv = "SELECT * FROM tb_config_competitions WHERE competition='adv'";
$resultkadv = mysqli_query($connect, $sqlkadv);        
$rowkadv = mysqli_fetch_array($resultkadv);
$competition_adv_active=$rowkadv["active"];

if ($competition_adv_active == 'on' && $ownerb != '')
{
$sqluc="SELECT COUNT(*) as count from tb_competition_adv WHERE user='$ownerb'";
$queryuc=mysqli_query($connect, $sqluc);
$rowuc=mysqli_fetch_array($queryuc);
$usc=$rowuc['count'];

if ($usc > 0)
{
$queryurc = "UPDATE tb_competition_adv SET sum=`sum` +'$price' WHERE user='$ownerb'";
$resultex = mysqli_query($connect, $queryurc);
}
else
{
$queryirc = "INSERT INTO tb_competition_adv (user, sum) VALUES('$ownerb','$price')";
mysqli_query($connect, $queryirc) or die(mysqli_error());
}
}

//--------------------------------------------------------------------------------

echo $_POST['m_orderid'].'|success';
}
}
}

//---------------------------------------------------------------------------------------------------------------------------------------

}
else
{
echo $_POST['m_orderid'].'|error';
}

}

exit();
mysqli_close($connect);
?>
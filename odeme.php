<?php

// ÖDEME ISLEMI ALANLARI
$name="XXXXXXXX";
$password="xxxxxxxxx";
$clientid=$_POST["clientid"];
$mode = "P";
$type="Auth";
$expires = $_POST["Ecom_Payment_Card_ExpDate_Month"]."/".$_POST["Ecom_Payment_Card_ExpDate_Year"];
$cv2=$_POST['cv2'];
$tutar=$_POST["amount"];
$taksit="";
$oid= $_POST['oid'];
$lip=GetHostByName("192.168.1.20");
$email="";
$mdStatus=$_POST['mdStatus'];
$xid=$_POST['xid'];
$eci=$_POST['eci'];
$cavv=$_POST['cavv'];
$md=$_POST['md'];
if ($mdStatus == "1" || $mdStatus == "2" || $mdStatus == "3" || $mdStatus == "4") {
    echo "3D Islemi Basarili";
// XML request sablonu
    $request = "DATA=" . "" . "{NAME}" . "{PASSWORD}" . "{CLIENTID}" . "{IP}" . "{EMAIL}" . "P" . "{OID}" . "" . "" . "" . "{TYPE}" . "{MD}" . "" . "" . "{TUTAR}" . "949" . "{TAKSIT}" . "{XID}" . "{ECI}" . "{CAVV}" . "13" . "" . "" . "" . "" . "" . "" . "" . "" . "" . "" . "" . "" . "" . "" . "" . "" . "" . "" . "" . "" . "" . "" . "" . "";
    $request = str_replace(array(
        "{NAME}",
        "{PASSWORD}",
        "{CLIENTID}",
        "{IP}",
        "{OID}",
        "{TYPE}",
        "{XID}",
        "{ECI}",
        "{CAVV}",
        "{MD}",
        "{TUTAR}",
        "{TAKSIT}"
    ), array($name, $password, $clientid, $lip, $oid, $type, $xid, $eci, $cavv, $md, $tutar, $taksit), $request); // Sanal pos adresine baglanti kurulmasi $url = "https:///"; //TEST $ch = curl_init(); // initialize curl handle curl_setopt($ch, CURLOPT_URL,$url); // set url to post to curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,1); curl_setopt($ch, CURLOPT_SSLVERSION, 3); curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0); curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable curl_setopt($ch, CURLOPT_TIMEOUT, 90); // times out after 90s curl_setopt($ch, CURLOPT_POSTFIELDS, $request); // add POST fields // Buraya mdStatusa göre bir kontrol koymalisiniz. // 3d Secure işleminin sonucu mdStatus 1,2,3,4 ise başarılı 5,6,7,8,9,0 başarısızdır // 3d Decure işleminin sonucu başarısız ise işlemi provizyona göndermeyiniz (XML göndermeyiniz). $result = curl_exec($ch); // run the whole process //echo htmlspecialchars($result); echo "

    $Response = "";
    $OrderId = "";
    $AuthCode = "";
    $ProcReturnCode = "";
    $ErrMsg = "";
    $HOSTMSG = "";
    $HostRefNum = "";
    $TransId = "";
    $response_tag = "Response";
    $posf = strpos($result, ("<" . $response_tag . ">"));
    $posl = strpos($result, (""));
    $posf = $posf + strlen($response_tag) + 2;
    $Response = substr($result, $posf, $posl - $posf);
    $response_tag = "OrderId";
    $posf = strpos($result, ("<" . $response_tag . ">"));
    $posl = strpos($result, (""));
    $posf = $posf + strlen($response_tag) + 2;
    $OrderId = substr($result, $posf, $posl - $posf);
    $response_tag = "AuthCode";
    $posf = strpos($result, "<" . $response_tag . ">");
    $posl = strpos($result, "");
    $posf = $posf + strlen($response_tag) + 2;
    $AuthCode = substr($result, $posf, $posl - $posf);
    $response_tag = "ProcReturnCode";
    $posf = strpos($result, "<" . $response_tag . ">");
    $posl = strpos($result, "");
    $posf = $posf + strlen($response_tag) + 2;
    $ProcReturnCode = substr($result, $posf, $posl - $posf);
    $response_tag = "ErrMsg";
    $posf = strpos($result, "<" . $response_tag . ">");
    $posl = strpos($result, "");
    $posf = $posf + strlen($response_tag) + 2;
    $ErrMsg = substr($result, $posf, $posl - $posf);
    $response_tag = "HostRefNum";
    $posf = strpos($result, "<" . $response_tag . ">");
    $posl = strpos($result, "");
    $posf = $posf + strlen($response_tag) + 2;
    $HostRefNum = substr($result, $posf, $posl - $posf);
    $response_tag = "TransId";
    $posf = strpos($result, "<" . $response_tag . ">");
    $posl = strpos($result, "");
    $posf = $posf + strlen($response_tag) + 2;
    $TransId = substr($result, $posf, $posl - $posf);
}
//echo $Response; //echo $ProcReturnCode;
?>
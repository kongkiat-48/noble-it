<?php
// app/procress/get_mail.php
require_once('PHPMailer/PHPMailerAutoload.php');

function sendMail($runticket, $name_user, $department, $service, $problem, $other, $namecall, $location, $approve, $date_send) {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Host = 'mailnoble.nbrest.com';
    $mail->Port = 25;
    $mail->isHTML(true);
    $mail->CharSet = "utf-8";
    $mail->Username = 'nbrit@nbrest.com';
    $mail->Password = '21fb16Ss7';
    $mail->AddCC('kongkiat.0174@hotmail.com');
    $mail->FromName = "แจ้งการขอใช้บริการ IT";
    $mail->Subject = "Ticket Number : " . $runticket;
    $mail->Body = $name_user . "<br>แผนก : " . $department . "<br>" .
                  "แจ้งปัญหาหมวดหมู่ของ : " . @prefixConvertorService($service) . "<br>" .
                  "พบปัญาที่แจ้ง : " . @prefixConvertorServiceList($problem) . "<br>" .
                  "รายละเอียด : " . $other . "<br>ผู้แจ้ง : " . $namecall . "<br>" .
                  "สาขา : " . @prefixbranch($location) . "<br>ผู้อนุมัติ : " . $approve . "<br>" .
                  "วันที่ : " . $date_send . "<br>Link : " . @urllink() . "<br>";
    $mail->AddAddress('nbrit@nbrest.com', 'เจ้าหน้าที่ที่เกี่ยวข้อง');

    return $mail->Send() ? 'Success' : 'Error';
}


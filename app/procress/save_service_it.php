<?php
// ------------------  Save Service IT ------------------------------
$name_key = $userdata->user_key; // show key md5 name
$fullname = @prefixConvertorUsername($name_key);
$getemployee  = $getdata->my_sql_query($connect, NULL, "employee", "card_key = '" . $_SESSION['ukey'] . "'");

$getticket = $getdata->my_sql_show_rows($connect, "problem_list", "ID AND date LIKE '%" . date("Y-m") . "%'"); // นับข้อมูลใน database โดยเลือก ปี เดือน วัน ปัจจุบัน
if ($getticket < 999) {
    $runticket = 'IT' . date("Y-m-d") . '-W' . sprintf('%02s', $getticket + 1); // ถ้าวันปัจจุบันมีการนับน้อยกว่า 999 ให้ปัจจุบัน +1 
}

$getalert = $getdata->my_sql_query($connect, NULL, "system_alert", NULL);

$getcontrol = $getdata->my_sql_show_rows($connect, "problem_list", "ID AND date LIKE '%" . date("Y-m") . "%'"); // นับข้อมูลใน database
if ($getcontrol < 999) {
    if (isset($_POST['save_newcase'])) {
        if (htmlspecialchars($_POST['se_li']) != NULL) {

            if (!defined('pic')) {
                define('pic', '../resource/it/delevymo/');
            }
            if (is_uploaded_file($_FILES['pic']['tmp_name'])) {
                $remove_charname = array(' ', '`', '"', '\'', '\\', '/', '_');
                $pic = str_replace($remove_charname, '', $_FILES['pic']['name']);
                $fixname_pic = $runticket . '-' . $pic;
                $File_tmpname = $_FILES['pic']['tmp_name'];

                if (move_uploaded_file($File_tmpname, (pic . $fixname_pic)));
            }


            resizepic($pic, $fixname_pic);


            $getdata->my_sql_insert($connect, "problem_list", "
                ticket='" . $runticket . "',
                user_key ='" . $_SESSION['ukey'] . "',
                department ='" . htmlspecialchars($_POST['department']) . "',
                company = '" . htmlspecialchars($_POST['company']) . "',
                se_id ='" . htmlspecialchars($_POST['se_id']) . "',
                se_li_id ='" . htmlspecialchars($_POST['se_li']) . "',
                se_other = '" . htmlspecialchars($_POST['other']) . "',
                se_asset = '" . htmlspecialchars($_POST['se_asset']) . "',
                pic_before = '" . $fixname_pic . "',
                se_namecall = '" . htmlspecialchars($_POST['namecall']) . "',
                se_location = '" . htmlspecialchars($_POST['location']) . "',
                se_approve = '" . htmlspecialchars($_POST['approve']) . "',
                date = '" . date("Y-m-d") . "',
                time_start = '" . date("H:i:s") . "'");

            $remove_charname = array('&', '!', '"', '%');
            $rc_other = str_replace($remove_charname, '-', htmlspecialchars($_POST['other']));
            $rc_department = str_replace($remove_charname, '-', htmlspecialchars($_POST['gt_department']));

            // ส่งข้อมูลเข้าไลน์
            $name_user = $_POST['name_em'];
            $department = $rc_department;
            $service = $_POST['se_id'];
            $problem = $_POST['se_li'];
            $other = $rc_other;
            $namecall = $_POST['namecall'];
            $location = $_POST['location'];
            $asset = $_POST['se_asset'];
            $approve = $_POST['approve'];
            $date_send = date('d/m/Y');

            $line_token = $getalert->alert_line_token; // Token
            $line_text = "
------------------------
Ticket : {$runticket}
------------------------
{$name_user}
แผนก : {$department}
ผู้แจ้ง : {$namecall}
สาขา : " . @prefixbranch($location) . "
ผู้อนุมัติ : {$approve}
รหัสสินทรัพย์ : {$asset}
------------------------
หมวดหมู่ : " . @prefixConvertorService($service) . " 
พบปัญหา : {$other}
            
วันที่ : {$date_send}
Link : " . @urllink() . "
";

            lineNotify($line_text, $line_token); // เรียกใช้ Functions line
            require_once 'get_mail.php';
            //echo "<META HTTP-EQUIV='Refresh' CONTENT = '1; URL='" . $SERVER_NAME . "'>";
        } else {
            $alert = $warning;
            //echo "<META HTTP-EQUIV='Refresh' CONTENT = '2; URL='" . $SERVER_NAME . "'>";
        }
    }

    if (isset($_POST['save_offcase'])) {
        if (htmlspecialchars($_POST['off_case_status']) != NULL && htmlspecialchars($_POST['comment']) != NULL) {
            $getdata->my_sql_update(
                $connect,
                "problem_list",
                "card_status='" . htmlspecialchars($_POST['off_case_status']) . "',
                admin_update='" . $_SESSION['ukey'] . "',
                date_update='" . htmlspecialchars($_POST['date_off_case']) . "',
                time_update='" . date("H:i:s") . "'", //เพิ่ม เวลา
                "ticket='" . htmlspecialchars($_POST['card_key']) . "'"
            );

            $getdata->my_sql_insert(
                $connect,
                "problem_comment",
                "card_status='" . htmlspecialchars($_POST['off_case_status']) . "',
                admin_update='" . $_SESSION['ukey'] . "',
                comment='" . htmlspecialchars($_POST['comment']) . "',
                date ='" . date("Y-m-d H:i:s") . "',
                ticket='" . htmlspecialchars($_POST['card_key']) . "'"
            );

            // ส่งข้อมูลเข้าไลน์
            $ticket = $_POST['ticket'];
            $name_user = $_POST['name_user'];
            $other = $_POST['comment'];
            $date_send = date('d/m/Y');

            $line_token = $getalert->alert_line_token; // Token
            $line_text = "
                 /*** Please Check Again ***/
                 ------------------------
                 Ticket : {$ticket}
                 ------------------------
                 {$name_user}
                 ------------------------
                 รายละเอียด : {$other}
    
                 วันที่ : {$date_send}
                 Link : " . @urllink() . "
                 ";

            lineNotify($line_text, $line_token); // เรียกใช้ Functions line

            $alert = $success;
            //echo "<META HTTP-EQUIV='Refresh' CONTENT = '1; URL='" . $SERVER_NAME . "'>";
        } else {
            $alert = $warning;
            //echo "<META HTTP-EQUIV='Refresh' CONTENT = '2; URL='" . $SERVER_NAME . "'>";
        }
    }
} else {
    $alert = $warning;
}
if (isset($_POST['save_editcase'])) {
    if (htmlspecialchars($_POST['ticket']) != NULL && htmlspecialchars($_POST['se_asset']) != NULL) {

        if (!defined('pic')) {
            if (!defined('pic')) {
                define('pic', '../resource/it/delevymo/');
            }
            if (is_uploaded_file($_FILES['pic']['tmp_name'])) {
                $remove_charname = array(' ', '`', '"', '\'', '\\', '/', '_');
                $pic = str_replace($remove_charname, '', $_FILES['pic']['name']);
                $fixname_pic = $_POST['card_key'] . '-after-' . $pic;
                $File_tmpname = $_FILES['pic']['tmp_name'];
                if (move_uploaded_file($File_tmpname, (pic . $fixname_pic)));
                resizepic($pic, $fixname_pic);
                $getdata->my_sql_update($connect, 'problem_list', "pic_before ='" . $fixname_pic . "'", "ticket='" . htmlspecialchars($_POST['card_key']) . "'");
            }
        } else {
            $editpic = $_POST['pic_log'];
            $getdata->my_sql_update($connect, 'problem_list', "pic_before ='" . $editpic . "'", "ticket='" . htmlspecialchars($_POST['card_key']) . "'");
        }


        $getdata->my_sql_update(
            $connect,
            "problem_list",
            "se_asset = '" . htmlspecialchars($_POST['se_asset']) . "',
            se_id = '" . htmlspecialchars($_POST['se_id']) . "',
            se_li_id = '" . htmlspecialchars($_POST['se_li']) . "',
            se_other = '" . htmlspecialchars($_POST['other']) . "',
      admin_edit='" . $name_key . "'", //เพิ่ม เวลา
            "ticket='" . htmlspecialchars($_POST['card_key']) . "'"
        );


        $alert = $success;
    } else {
        $alert = $warning;
    }
}

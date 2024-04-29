<?php
session_start();
error_reporting(0);
require("../../core/config.core.php");
require("../../core/connect.core.php");
require("../../core/functions.core.php");
$getdata = new clear_db();
$connect = $getdata->my_sql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
mysqli_set_charset($connect, "utf8");

$chk_case = $getdata->my_sql_query($connect, NULL, "problem_list", "ticket='" . htmlspecialchars($_GET['key']) . "'");
$get_admin = $getdata->my_sql_query($connect, NULL, "user", "user_key = '" . $_SESSION['ukey'] . "'");

?>
<div class="modal-body">
    <div class="form-group row">
        <div class="col-md-6 col-sm-12">
            <label for="ticket">Ticket Number</label>
            <input type="text" class="form-control" name="ticket" id="ticket" value="<?php echo @$chk_case->ticket; ?>" readonly>
        </div>
        <div class="col-md-6 col-sm-12">
            <label for="approve_status">สถานะ</label>
            <select name="approve_status" id="approve_status" class="form-control select2bs4" required>
                <option value="" selected>--- เลือกข้อมูล ---</option>

                <option value="Y">อนุมัติ</option>
                <option value="57995055c28df9e82476a54f852bd214">ยกเลิกการแจ้ง / ไม่อนุมัติ</option>

            </select>
            <div class="invalid-feedback">
                เลือก สถานะ.
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-12">
            <label for="comment">รายละเอียดเพิ่มเติม</label>
            <?php
            if ($_SESSION['uclass'] != 1) {
                echo '<textarea class="form-control" name="comment" id="comment"></textarea>';
            } else {
                echo '<textarea class="form-control" name="comment" id="comment" required></textarea>';
            }
            ?>
            <div class="invalid-feedback">
                ระบุ รายละเอียด.
            </div>
        </div>
    </div>

</div>
<div class="modal-footer">

    <button class="ladda-button btn btn-primary btn-square btn-ladda bg-info" type="submit" name="save_approve" data-style="expand-left">
        <span class="fas fa-save"> บันทึก</span>
        <span class="ladda-spinner"></span>
    </button>
</div>
<input type="text" name="card_key" id="card_key" hidden value="<?php echo @htmlspecialchars($_GET['key']); ?>">
<input type="text" name="name_user" id="name_user" hidden value="<?php echo @getemployee($chk_case->user_key); ?>">
<input type="text" name="admin" hidden value="<?php echo @getemployee($get_admin->user_key); ?>">
<input type="text" name="namecall" hidden value="<?php echo $chk_case->se_namecall; ?>">
<input type="text" name="location" hidden value="<?php echo @prefixbranch($chk_case->se_location); ?>">
<input type="text" name="detail" hidden value="<?php echo $chk_case->se_other; ?>">
<input type="text" name="se_id" hidden  value="<?php echo $chk_case->se_id; ?>">
<input type="text" name="se_li_id" hidden   value="<?php echo $chk_case->se_li_id; ?>">
<?php if ($chk_case->se_after != NULL) { ?>
    <input type="text" name="pic_log" value="<?php echo $chk_case->se_after; ?>">
<?php } ?>

<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4',
        width: '100%'
    });
</script>

<script src="service/currency.js"></script>
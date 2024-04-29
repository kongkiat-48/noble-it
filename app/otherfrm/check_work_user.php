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

?>
<div class="modal-body">
    <div class="form-group row">
        <div class="col-md-6 col-sm-12">
            <label for="ticket">Ticket Number</label>
            <input type="text" class="form-control" name="ticket" id="ticket" value="<?php echo @$chk_case->ticket; ?>" readonly>
        </div>
        <div class="col-md-6 col-sm-12">
            <label for="checkwork_user">สถานะ</label>
            <select name="checkwork_user" id="checkwork_user" class="form-control select2bs4" required>
                <option value="" selected>--- เลือกข้อมูล ---</option>

                <option value="Y">ผ่าน</option>
                <option value="reject">ไม่ผ่าน</option>

            </select>
            <div class="invalid-feedback">
                เลือก สถานะ.
            </div>
        </div>
    </div>

</div>
<input type="text" name="card_key" id="card_key" value="<?php echo @htmlspecialchars($_GET['key']); ?>">
<input type="text" name="name_user" id="name_user"  value="<?php echo @getemployee($chk_case->user_key); ?>">
<input type="text" name="admin"  value="<?php echo @getemployee($chk_case->admin_update); ?>">
<input type="text" name="namecall"  value="<?php echo @getemployee($chk_case->se_namecall); ?>">
<input type="text" name="location"  value="<?php echo @prefixbranch($chk_case->se_location); ?>">
<input type="text" name="detail"  value="<?php echo $chk_case->se_other; ?>">
<script>
    $('.select2bs4').select2({
        theme: 'bootstrap4',
        width: '100%'
    });
</script>
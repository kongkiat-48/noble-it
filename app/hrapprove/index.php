<?php
require_once 'procress/save_service_it.php';
?>
<?php $getmenus = $getdata->my_sql_query($connect, null, 'menus', "menu_status ='1' AND menu_case = '" . $_GET['p'] . "' AND menu_key != 'c6c8729b45d1fec563f8453c16ff03b8'"); ?>
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><?php echo '<i class="fas ' . $getmenus->menu_icon . ' fa-2x"></i> <span>' . $getmenus->menu_name . '</span>'; ?></h3>
    </div>
</div>

<nav aria-label="breadcrumb" class="mt-3 mb-3">
    <ol class="breadcrumb breadcrumb-inverse">
        <li class="breadcrumb-item">
            <a href="index.php">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo '<span>' . $getmenus->menu_name . '</span>'; ?></li>
    </ol>
</nav>



<div class="modal fade" id="show_case" role="dialog" aria-labelledby="show_case" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="show_case">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="approve-hr" role="dialog" aria-labelledby="approve-hr" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" enctype="multipart/form-data" class="was-validated" id="waitsave2">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เปลี่ยนแปลง</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="approve-hr">

                </div>

            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="off_case" role="dialog" aria-labelledby="off_case" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate id="waitsave">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ดำเนินการ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="offcase">

                </div>
                <div class="modal-footer">

                    <button class="ladda-button btn btn-primary btn-square btn-ladda bg-info" type="submit" name="save_offcase" data-style="expand-left">
                        <span class="fas fa-save"> บันทึก</span>
                        <span class="ladda-spinner"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="edit_case" role="dialog" aria-labelledby="edit_case" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate id="waitsave">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ดำเนินการ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="editcase">

                </div>
                <div class="modal-footer">

                    <button class="ladda-button btn btn-primary btn-square btn-ladda bg-info" type="submit" name="save_editcase" data-style="expand-left">
                        <span class="fas fa-save"> บันทึก</span>
                        <span class="ladda-spinner"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php echo @$alert; ?>

<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-md font-weight-bold text-primary text-uppercase mb-1">จำนวนรายการแจ้งปัญหาเดือน <u><?php echo @month(); ?></u></div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php @$getall = $getdata->my_sql_show_rows($connect, "problem_list", "ID <> 'hidden' AND (date LIKE '%" . date("Y-m") . "%' ) AND user_key = '" . $_SESSION['ukey'] . "'");
                                                                            echo @number_format($getall); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-md font-weight-bold text-info text-uppercase mb-1">จำนวนรายการแจ้งปัญหาวันนี้</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php @$getall = $getdata->my_sql_show_rows($connect, "problem_list", "ID <> 'hidden' AND (date LIKE '%" . date("Y-m-d") . "%' ) AND user_key = '" . $_SESSION['ukey'] . "'");
                                                                            echo @number_format($getall); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<div class=" row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header card-header-border-bottom d-flex justify-content-between">
                <h2><span class="mdi mdi-format-list-checks"></span>
                    รายการแจ้งปัญหาของคุณทั้งหมด</h2>
            </div>

            <div class="card-body">
                <div class="basic-data-table">
                    <table id="data-home-it" class="table hover nowrap text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ticket</th>
                                <th>วันที่</th>
                                <th>ผู้ดำเนินการ</th>
                                <th>สถานะ</th>
                                <th>วันที่อัพเดต</th>
                                <th>ดำเนินการ</th>

                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $i = 0;
                            $get_total = $getdata->my_sql_select($connect, NULL, "problem_list", "user_key = '" . $_SESSION['ukey'] . "' OR (approve_department = 'HR' OR se_id IN ('13','16')) AND card_status NOT IN ('wait_approve') ORDER BY ticket DESC");
                            while ($show_total = mysqli_fetch_object($get_total)) {
                                $i++;
                            ?>
                                <tr>
                                    <td><?php echo @$i; ?></td>
                                    <td><?php echo @$show_total->ticket; ?></td>
                                    <td><?php echo @dateConvertor($show_total->date); ?></td>
                                    <td>
                                        <?php
                                        if (@$show_total->admin_update == NULL) {
                                            echo '<span class="badge badge-warning">รอดำเนินการแก้ไข</span>';
                                        } else {
                                            echo @getemployee($show_total->admin_update);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (@$show_total->card_status == NULL && ($show_total->approve_department == 'IT' ||  $show_total->approve_department != 'HR')) {
                                            echo '<span class="badge badge-warning">รอดำเนินการแก้ไข</span>';
                                        } else if ($show_total->card_status == 'wait_approve' && $show_total->approve_department == 'IT') {
                                            echo '<span class="badge badge-info">รอการอนุมัติจากผู้บังคับบัญชา</span>';
                                        } else if ($show_total->card_status == NULL && $show_total->approve_department == 'HR') {
                                            echo '<span class="badge badge-info">รอการอนุมัติจาก HR</span>';
                                        } else {
                                            echo @cardStatus($show_total->card_status);
                                        }

                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (@$show_total->date_update == '0000-00-00') {
                                            echo '<span class="badge badge-warning">รอดำเนินการแก้ไข</span>';
                                        } else {
                                            echo @dateConvertor($show_total->date_update);
                                        }  ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo '<a href="#" data-toggle="modal" data-target="#show_case" data-whatever="' . @$show_total->ticket . '" class="btn btn-sm btn-info" data-top="toptitle" data-placement="top" title="ตรวจสอบ"><i class="fa fa-search"></i></a>&nbsp';
                                        if($show_total->approve_department == 'HR') {
                                            echo '<a href="#" data-toggle="modal" data-target="#approve-hr" data-whatever="' . @$show_total->ticket . '" class="btn btn-sm btn-warning btn-outline" data-top="toptitle" data-placement="top" title="ดำเนินการ"><i class="fa fa-check-circle"></i></a>';
                                        }
                                        ?>
                                        <a href="?p=case_all_service&key=<?php echo @$show_total->ticket; ?>" class="btn btn-sm btn-success" data-top="toptitle" data-placement="top" title="ตรวจสอบ"><span class="mdi mdi-timeline-text-outline"></span></a>
                                    </td>

                                </tr>


                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>
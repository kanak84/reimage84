<?php
include_once 'main_header.php';
$control = new control();
$office_info = $control->office_info($_SESSION['eID']);
$transfer_user_name = $_SESSION['employee_user'];
$date_time = date('Y-m-d H:i:s');
$info = $control->ITAccessDelete($_GET['id']);


if ($info) {
    echo "<script>alert('Your information has been Deleted successfully!')</script>";
    echo "<meta http-equiv='refresh' content='0;url=?e=pabx&p=all_list&f=all&l=access_level_list'>";
}
?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Delete IT Inventory Device
            <small>(OWST)</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">ITM</a></li>
            <li><a href="#">Inventory Device</a></li>
            <li class="active">Delete</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form name="input" action="" method="post" autocomplete="off" enctype="multipart/form-data">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">User Information
                                <small></small>
                            </h3>
                            <!-- tools box -->
                            <div class="pull-right box-tools">
                                <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Minimize">
                                    <i class="fa fa-minus"></i></button>
                            </div>
                            <!-- /. tools -->
                        </div>
                        <!-- /.box-header -->

                    </div>

                </form>
                <!-- /.box -->
            </div>
            <!-- /.col-->
        </div>
        <!-- ./row -->
    </section>
    <!-- /.content -->
</div>


<?php include_once 'main_footer.php'; ?>


<style>
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .blink {
        animation-duration: 600ms; /*blinking speed decreases and increase */
        animation-name: tgle;
        animation-iteration-count: infinite;
        /*background-color: yellow;*/
        /*color: black;*/
    }

    .red_color {

        color: #cf1f25;
        font-weight: bold;

    }
    .green_color {

        color: #00a65a;
        font-weight: bold;

    }

    @keyframes tgle {
        0% {
            opacity: 0;
        }

        49.99% {
            opacity: 0;
        }
        50% {
            opacity: 1;
        }

        99.99% {
            opacity: 1;
        }
        100% {
            opacity: 0;
        }
    }
</style>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="favicon.ico" rel="icon" type="image/x-icon"/>
    <title>F@H ITM | Home</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="author" content="New Version integrated and developed by Mohammed Abdus Sattar Shohags on behalf of F@H SW Development" >
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Data Tables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.css">
    <!-- datepicker -->
    <script src="js/datetimepicker_css.js"></script>
    <!-- <script src="plugins/datepicker/bootstrap-datepicker.js"></script> -->
    <!-- Autocomplete -->
    <script type="text/javascript">
        $(function () {
            setAutoComplete("searchField", "results", "autocomplete.php?part=");
        });
    </script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse" onload="chkNew()">

<!-- User Account: style can be found in dropdown.less -->


<?php include_once 'main_header.php';?>

<?php

$control = new control();
$UserEmployeeInfo = $control->UserEmployeeInfo($_SESSION['eID']);

$user_employee_id = $_SESSION['eID'];
$counters = $control->moduller()->homeContentCounts();


if (isset($_POST['btn_sub'])) {

    $employee_id = $_POST['employee_id'];
    $user_type = $_POST['user_type'];
    $edit_date = date('Y-m-d H:i:s');
    $edited_by = $_SESSION['employee_user'];

    $access_data = array(
        'employee_id' => $employee_id,
        'user_type' => $user_type,
        'edit_date' => $edit_date,
        'edit_by' => $edited_by
      );

         $update_data = $control->updateAccessLevel($access_data);

         if (!empty($_POST['employee_id'] && $_POST['client_name']) ) {

         if ($update_data) {
          //   echo "<p align='center' style='font-weight: bold;'><font size='+1' color='red'>You Successfully Updated data.</font></p>";
             ?>
             <script type="text/javascript">
                 alert('Data Updated Successfully');
                 window.location="?e=pabx&p=all_list&f=all&l=access_level_list";
             </script>
         <?php
         }

         }
         ?>

 <?php

}

$access_it_responsible_person = $control->AccessITResponsiblePerson();
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Welcome to <strong>F@H</strong> ITM
            <small>Version 3.0</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href=" "><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">DASHBOARD1</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="ion ion-ios-calendar-outline"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">TT OPENED TODAY</span>
                        <span class="info-box-number"><a href="?e=pabx&p=all_list&f=all&l=home&f_id=1" ><?php echo $counters[0]; ?></a></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="ion ion-clipboard"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">TT CLOSED TODAY</span>
                        <span class="info-box-number"><a href="?e=pabx&p=all_list&f=all&l=home&f_id=2" ><?php echo $counters[1]; ?></a></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="ion ion-ios-bookmarks-outline"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">TOTAL RUNNING TT</span>
                        <span class="info-box-number"><a href="?e=pabx&p=all_list&f=all&l=home&f_id=3" ><?php echo $counters[2]; ?></a></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">TOTAL USER</span>
                        <span class="info-box-number"><?php echo $counters[3]; ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-md-12">
                <!-- MAP & BOX PANE -->
                <!-- TABLE: LATEST ORDERS -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Access Level</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" style="font-size: smaller">
                        <form method="post" id="frm1" action="" autocomplete="off">
                            <div class="box-body ultra-small" >
                                <div class="form-group col-sm-3">
                                    <label for="client_name">Employee Name</label>
                                    <input type="text"  class="form-control input-sm"  id="client_name" onkeyup="lookup(this.value);" onblur="fill();"  name="client_name" placeholder="Input Name">
                                    <label id="suggestions" style="display: none;">
                                        <label style="font-size: smaller; cursor: pointer; z-index: 10; position: absolute;">
                                            <div class="FontSmaller" id="autoSuggestionsList">&nbsp;</div>
                                        </label>
                                    </label>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label for="employee_id">Employee ID</label>
                                    <input type="text"  class="form-control input-sm"  name="employee_id" id="employee_id"  required>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label for="designation">Designation</label>
                                    <select name="designation" id="designation" class="form-control input-sm">
                                        <option value="">-Select-</option>
                                        <?php
                                        $designation_info = $control->employee_designation_list();
                                        foreach ($designation_info as $di):
                                            ?>
                                            <option value="<?php echo $di[0]; ?>"><?php echo $di[0]; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label for="status">Access Category</label>
                                    <select name="user_type" id="user_type" class="form-control input-sm" required>
                                        <option value="">-Select-</option>
                                        <option value="1">Admin</option>
                                        <option value="2">Sub Admin</option>
                                        <option value="3">General</option>
                                    </select>
                                </div>

                                <div class="box-footer">
                                    <input type="submit" class="btn btn-success" name="btn_sub" value="Submit" onclick="return ChkSubmit();"/>
                                    <input type="button" class="btn btn-danger" name="btn_refresh" value="Refresh" onclick="window.location.reload();"/>
                                </div>

                            </div>
                        </form>
                    </div>

                    <!-- /.box -->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"> IT Access List</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body" style="overflow-x: auto">
                            <table id="example1" class="table table-bordered table-striped small" >
                                <thead>
                                <tr>
                                    <th style="width:10px;">SL No.</th>
                                    <th>Full Name</th>
                                    <th>Access Type</th>
                                    <th>Function </th>
                                    <th>Department</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                $i =1;
                                foreach ($access_it_responsible_person as $alt):
                                  ?>
                                    <tr>
                                        <td><?php echo $i++;?></td>

                                        <td><?php echo $alt['full_name']; ?></td>
                                        <td>
                                            <?php

                                            if($alt['user_type']==1){
                                                echo "Admin";
                                            }
                                            elseif($alt['user_type']==2){
                                                echo "Sub Admin";
                                            }
                                            else{
                                                echo "General";
                                            }
                                            ?>
                                        </td>

                                        <td><?php echo $alt['work_area']; ?></td>
                                        <td><?php echo $alt['department']; ?></td>

                                        <td>
                                            <a class="btn btn-default btn-xs" href='?e=pabx&p=all_list&f=all&l=access_level_create'>Create</a>

                                            <?php if ($_SESSION['user_type'] == 1 )
                                            {
                                                ?>
                                                <a class="btn btn-info btn-xs" href='?e=pabx&p=all_list&f=all&l=access_level_update&id=<?php echo $alt['id'] ?>'>Edit</a>
<!--                                                <a class="btn btn-danger btn-xs" href='?e=pabx&p=all_list&f=all&l=access_level_delete&id=--><?php //echo $alt['id'] ?><!--'>Delete</a>-->

                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                endforeach;
                                ?>
                                </tbody>


                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->


                </div>
                <?php include_once 'main_footer.php'; ?>
                <!-- /.row -->

    </section>

    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Control Sidebar -->


<script>

    $('#example1').dataTable( {
        language: {
            searchPlaceholder: "Global Search"
        }
    } );
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>




<script type="text/javascript">

    function lookup(inputString) {
        if(inputString.length == 0) {
            // Hide the suggestion box.
            $('#suggestions').hide();
        } else {
            $.post("cc/scr_list.php", {queryStringEmployee: ""+inputString+""}, function(data){
                if(data.length >0) {
                    $('#suggestions').show();
                    $('#autoSuggestionsList').html(data);
                }
            });
        }
    } // lookup

    function fill(thisValue) {

        $('#client_name').val(thisValue);
        setTimeout("$('#suggestions').hide();", 200);
    }

    function fillData(thisValue)
    {
        //alert('thisValue');
        $('#employee_id').val(thisValue);
    }
    function clientFromAddress(thisValue)
    {
        $('#designation').val(thisValue);
    }
    function client_to_address(thisValue)
    {
        $('#depertment').val(thisValue);
    }
    function type_of_service(thisValue)
    {
        //alert('thisValue');
        $('#type_of_service').val(thisValue);
    }
    function core_capacity(thisValue)
    {
        $('#core_capacity').val(thisValue);
    }

</script>








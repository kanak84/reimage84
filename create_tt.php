<?php
include_once 'main_header.php';
$control = new control();

date_default_timezone_set('Asia/Dhaka');
$employeeInfoDetail = $control->UserEmployeeInfo($_SESSION['eID']);

$employeeInfoDetail['mobile'];

$employeeInfoDetail['email'];

$employeeOfficeInfo = $control->UserOfficeInfo($_SESSION['eID']);


$employeeOfficeInfo['employee_name'];
//echo '<pre>';
//echo $employeeOfficeInfo['work_field'];


if (isset($_POST['btn_sub'])) {

    $fault_date_time = date('Y-m-d H:i:s');

    $tt_no = $control->check_tt($fault_date_time);
    $query_type_info = $control->show_fault_name($_POST['query_type']);

    $query_type_name = $query_type_info[1];
    $query_type = $query_type_name . $_POST['query_type1'];
    $tt_date = date('Y-m-d');

    $user_name = $_SESSION['employee_user'];
    $reason_of_problem_mail = $_POST['reason_of_problem'];
    $post_user_name=$_POST['client_name'];
    $post_contact_number=$_POST['phone'];
    $post_employee_id=$_POST['employee_id'];
    $post_email_address=$_POST['email'];
    $post_department=$_POST['depertment'];
   $post_designation=$_POST['designation'];
    $email_body = <<<EOF
<html>

<body style="background-color:#DCDCDC;">

        <div  style=" border: 1px solid;margin-top: 10%;margin-left: 5%;width:70%;border-color:#174F8C;font-size:9px;">

<div style="width:70px">
<h2 style="color:maroon;margin-left:20%;">Trouble Ticket</h2>
<h2 style="color:red;margin-left:15%;border-bottom:2px solid #174F8C;"></h2>
</div>



<div>
<table width="70%" style="font-size:10px;">
                <tr >
                    <td ><h5>TicketInfo:</h5></td>
                    <td >
                        <div style="border: 1px solid; border-color: #174F8C;width:200px;height:100px;margin-top:20px;margin-left:25px;padding:10px;">
                          <p> TicketNo:$tt_no </p>

                        </div>
                    </td>
                    <td >
                        <div style="border: 1px solid; border-color: #174F8C;margin-left: 30px;width:450px;height:100px;margin-top:20px;padding:10px;">

                         <p>  QueryType:$query_type </p>

                        </div>
                    </td>
                </tr>


            </table>


</div>
<div style=" margin-left: 0%;margin-top:5%;">

            <h5 >User Info:</h5>
            </div>
          <div style="border: 1px solid; border-color: #174F8C;margin-left:100px;width:70%;margin-top: -270px;">

                <table  style="width:400px; font-size:10px;margin-top:-270px;" cellpadding="5">


                    <tr>
                        <td>Name : $post_user_name</td>
                        <td>Contact Number : $post_contact_number</td>
                    </tr>
                    <tr>
                        <td> ID No : $post_employee_id</td>
                        <td>EmailAddress:$post_email_address</td>
                    </tr>
                    <tr>
                        <td> Department : $post_department</td>
                        <td>Designation : $post_designation</td>
                    </tr>
                </table>
            </div>
            <table width="300px" style="margin-top: 3%;">
                <tr>
                    <td><h5 style=" margin-left: 0%;margin-top: 5%;font-size:14px;">ProblemDetails:</h5></td>
                    <td width="250">
                          <div style="border: 1px solid; border-color: #174F8C;margin-left:0px;height:auto;margin-top:20px;margin-bottom: 10px;padding:10px;font-size:10px;">

                            <p>$reason_of_problem_mail</p>
                        </div>
                    </td>
                </tr>
            </table>
            <table width="200px" style="margin-top:20px;">
                <tr>
                    <td><h5 style=" margin-left: 0%;margin-top: 5%;font-size:14px;">Date and Time:</h5></td>
                    <td>
                        <div style="border: 1px solid; border-color: #174F8C;margin-left:0px;width:150px;height:auto;margin-top:20px;margin-bottom: 30px;padding:10px;font-size:10px;">

                            <p>$fault_date_time</p>
                        </div>
                    </td>
                </tr>
            </table>

        </div>

    </body>
</html>
EOF;


    define("MAX_SIZE", "100000");

   // define("MAX_SIZE", "20");

    function getExtension($str) {
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }

    $errors = 0;

    $image = $_FILES['image']['name'];

    if ($image) {

        $filename = stripslashes($_FILES['image']['name']);

        $extension = getExtension($filename);
        $extension = strtolower($extension);
        if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif") && ($extension != "doc") && ($extension != "docx") && ($extension != "txt") && ($extension !="ppt")  && ($extension !="pptx") && ($extension != "xls") && ($extension != "xlsx") && ($extension != "pdf")) {

            echo '<h1>Please Upload image file!!!!...</h1>';
            $errors = 1;
        } else {

            $size = filesize($_FILES['image']['tmp_name']);

            // if ($size > 10 * 1048576)         //1 * 1024kb x 1024b = 1048576 bytes
            if ($size > MAX_SIZE * 40000)
          // if ($size > 100000)
            {
                echo '<h1>You have exceeded the size limit!</h1>';
                $errors = 1;
            }

            $image_name = time(). '_' . $image;

            $image_path = "uploads/" . $image_name;

            $copied = move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
            if (!$copied) {
                echo "<script>alert('Error! File not uploaded')</script>";
                $errors = 1;
            }
        }
    }


    if (!empty($_POST['client_name'])) {

        $emailFrom = $employeeInfoDetail[2];
        $emailTo = 'itm@fiberathome.net';
        $emailCc = $_POST['cc'];

        $subject1 = '[Ticket#' . $tt_no . ']' . '--' . $fault_type;

        $reason_of_problem1 = preg_replace('/<[^>]*>/', '', $_POST['reason_of_problem']);
        $reason_of_problem = str_replace("'", '`', $reason_of_problem1);
        $fault_date_time = date('Y-m-d H:i:s');
        if($_POST['query_type1']!=''){
            $query_type=$_POST['query_type1'];
            $fault_type_insert = $control->fault_type_insert($fault_date_time,$query_type, $_SESSION['employee_user'],$tt_no);
            $query_type =97;
        }
        else {
            $query_type=$_POST['query_type'];
           
        }
        // $query_type = $_POST['query_type'] . $_POST['query_type1'];
        if($_POST['employee_id']!=''){


            if(($employeeOfficeInfo['work_field']=='IT')) {


                $tt_data = array(
                    'tt_no' => $tt_no,
                    'fault_date_time' => $fault_date_time,
                    'client_name' => $_POST['client_name'],
                    'employee_id' => $_POST['employee_id'],
                    'designation' => $_POST['designation'],
                    'depertment' => $_POST['depertment'],
                    'phone' => $_POST['phone'],
                    'email' => $_POST['email'],
                    'fault_requested_by' => $_POST['requested_by'],
                    'client_fault_type' => $query_type,
                    'user' => $_SESSION['employee_user'],
                    'attach_file' => $image_path,
                    'reason_of_problem' => $reason_of_problem,
                    'date' => $tt_date,
                    'forward_logical_person' => $_SESSION['eID'],
                    'fault_forward_logical'=>'IT'
                );

            }else{
                $tt_data = array(
                    'tt_no' => $tt_no,
                    'fault_date_time' => $fault_date_time,
                    'client_name' => $_POST['client_name'],
                    'employee_id' => $_POST['employee_id'],
                    'designation' => $_POST['designation'],
                    'depertment' => $_POST['depertment'],
                    'phone' => $_POST['phone'],
                    'email' => $_POST['email'],
                    'fault_requested_by' => $_POST['requested_by'],
                    'client_fault_type' => $query_type,
                    'user' => $_SESSION['employee_user'],
                    'attach_file' => $image_path,
                    'reason_of_problem' => $reason_of_problem,
                    'date' => $tt_date,
                    'fault_forward_logical'=>'IT'
                );
            }

//            if($_POST['requested_by']=='Self') {
//                $tt_data = array(
//                    'tt_no' => $tt_no,
//                    'fault_date_time' => $fault_date_time,
//                    'client_name' => $_POST['client_name'],
//                    'employee_id' => $_POST['employee_id'],
//                    'designation' => $_POST['designation'],
//                    'depertment' => $_POST['depertment'],
//                    'phone' => $_POST['phone'],
//                    'email' => $_POST['email'],
//                    'fault_requested_by' => $_POST['requested_by'],
//                    'client_fault_type' => $query_type,
//                    'user' => $_SESSION['employee_user'],
//                    'attach_file' => $image_path,
//                    'reason_of_problem' => $reason_of_problem,
//                    'date' => $tt_date,
//                    'fault_forward_logical'=>'IT'
//                );
//            }

            $insert_data = $control->insertGeneral('tbl_trouble_input',$tt_data);

        }
        if ($insert_data) {
            echo "<p align='center' style='font-weight: bold;'><font size='+1' color='red'>You Successfully inserted data.</font></p>";
            include "view/sendmail_m1.php";
            ?>
            <script type="text/javascript">
                alert('Ticket Created Successfully');
                window.location="?e=pabx&p=all_list&f=all&l=home";
            </script>
            <?php
        } else {
            echo "<script>alert('Please Insert Name from Matching list and Fill up all Mandatory Field.')</script>";
        }
    } else {
        ?>
        <script type="text/javascript">
            alert('You have to Input Client Name, Client SCR/IMPL ID, Client Fault Type, Fault Requested By.');
        </script>
        <?php
    }
}
?>
<link rel="stylesheet" href="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Create TT
            <small>Create a New Ticket</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">ITM</a></li>
            <li class="active">Create TT</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">New Ticket
                            <small> Fill all the required fields (Marked with <b style="color: red">*</b> )</small>
                        </h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Minimize">
                                <i class="fa fa-minus"></i></button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">
                        <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="form-group col-sm-3">
                                    <label for="client_name">Employee Name<b style="color: red">*</b></label>
<!--                                    <input type="text" class="form-control" name="client_name" id="client_name" onkeyup="lookup(this.value);" onblur="fill();"  value="--><?php //if (isset($_POST['client_name'])) echo $_POST['client_name']; ?><!--" required placeholder="Enter employee name" />-->


                                    <input type="text" class="form-control" name="client_name" id="client_name" onkeyup="lookup(this.value);" onblur="fill();"  value="<?php echo $employeeOfficeInfo['employee_name']; ?>" required placeholder="Enter employee name" />
                                    <label id="suggestions" style="display: none;">
                                        <label style="font-size: smaller; cursor: pointer; z-index: 10; position: absolute;">
                                            <div class="FontSmaller" id="autoSuggestionsList">&nbsp;</div>
                                        </label>
                                    </label>
                                </div>

                                <div class="form-group col-sm-3">
                                    <label for="employee_id">Employee ID <b style="color: red">*</b></label>
<!--                                    <input type="text" class="form-control" name="employee_id" readonly="readonly"  id="employee_id" onblur="fillData()" value="--><?php //if (isset($_POST['employee_id'])) echo $_POST['employee_id']; ?><!--" required/>-->

                                    <input type="text" class="form-control" name="employee_id" readonly="readonly"  id="employee_id" onblur="fillData()" value="<?php echo $employeeOfficeInfo['employee_id']; ?>" required/>

                                </div>

                                <div class="form-group col-sm-3">
                                    <label for="designation">Designation</label>
<!--                                    <input type="text" class="form-control" name="designation" readonly="readonly" id="designation" onblur="clientFromAddress()" value="--><?php //if (isset($_POST['designation'])) echo $_POST['designation']; ?><!--"/>-->

                                    <input type="text" class="form-control" name="designation" readonly="readonly" id="designation" onblur="clientFromAddress()" value="<?php echo $employeeOfficeInfo['designation']; ?>"/>
                                </div>

                                <div class="form-group col-sm-3">
                                    <label for="depertment">Department</label>
<!--                                    <input type="text" class="form-control" readonly="readonly" name="depertment" id="depertment" onblur="client_to_address()" value="--><?php //if (isset($_POST['depertment'])) echo $_POST['depertment']; ?><!--" required>-->

                                    <input type="text" class="form-control" readonly="readonly" name="depertment" id="depertment" onblur="client_to_address()" value="<?php echo $employeeOfficeInfo['department_name']; ?>" required>
                                </div>

                                <div class="form-group col-sm-3">
                                    <label for="type_of_service">Phone</label>


                                    <input type="text" class="form-control" readonly="readonly" name="phone" id="type_of_service" onblur="type_of_service()" value="<?php echo $employeeInfoDetail['mobile']; ?>">

<!--                                    <input type="text" class="form-control" readonly="readonly" name="phone" id="type_of_service" onblur="type_of_service()" value="--><?php //if (isset($_POST['phone'])) echo $_POST['phone']; ?><!--">-->
                                </div>

                                <div class="form-group col-sm-3">
                                    <label for="core_capacity">Email</label>

                                    <input type="email" class="form-control" readonly="readonly" name="email" id="core_capacity" onblur="core_capacity()" value="<?php echo $employeeInfoDetail['email']; ?>" >
<!--                                <input type="email" class="form-control" readonly="readonly" name="email" id="core_capacity" onblur="core_capacity()" value="--><?php //if (isset($_POST['email'])) echo $_POST['email']; ?><!--" >-->


                                </div>

                                <div class="form-group col-sm-3">
                                    <label for="requested_by">Request By <b style="color: red">*</b></label>
                                    <select name="requested_by" id="requested_by" class="form-control" required>
                                      <option value="Self">Self</option>
                                      <option value="IT">IT</option>
                                    </select>
                                </div>

                                <div class="form-group col-sm-3">
                                    <label for="query_type">Query Type <b style="color: red">*</b></label>
                                    <select name="query_type" id="query_type" class="form-control" value="<?php if (isset($_POST['query_type'])) echo $_POST['query_type']; ?>" >
                                        <option value="">-Select-</option>
                                        <?php
                                        $query_type = $control->show_fault();
                                        foreach ($query_type as $fault):
                                            ?>
                                            <option value="<?php echo $fault[0]; ?>"><?php echo $fault[1]; ?></option>
                                            <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group col-sm-3">
                                    <label for="other">Others</label>
                                    <input type="checkbox" id="other"  onClick="others()" >
                                    <input type="text" class="form-control" name="query_type1" style="display:none"  id="alll"/>
                                </div>

                                <span id="ViewDept1"></span>
                                <span id="ViewDept"></span>

                                <input type="hidden" name="to" size="125" value="<?php if (isset($_POST['to'])) echo $_POST['to']; ?>"/>
                                <input type="hidden" name="cc" size="125" value="<?php if (isset($_POST['cc'])) echo $_POST['cc']; ?>"/>

                                <div class="form-group col-sm-12">
                                    <label for="editor1">Problem Details <b style="color: red">*</b></label>
                                    <textarea class="form-control" id="editor1" name="reason_of_problem" rows="10" cols="100" >

                                    </textarea>
                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="attach_image">Attach file</label>
                                    <input type="file" id="attach_image" name="image" value="<?php if (isset($_POST['file'])) echo $_POST['file']; ?>" class="form-control"  />
                                    <font style="color: blue">*jpg/ jpeg/ gif/png/pdf/ txt/ docx/pptx/ xlsx format (Maximum 4MB)</font>
                                </div>

                            </div>
                            <div class="box-footer">
                                <input type="submit" class="btn btn-success" name="btn_sub" value="Submit" onclick="return ChkSubmit();"/>
                                <input type="button" class="btn btn-danger" name="btn_refresh" value="Refresh" onclick="window.location.reload();"/>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col-->
        </div>
        <!-- ./row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include_once 'main_footer.php';?>

<script type="text/javascript" src="scripts/jquery-1.2.1.pack.js"></script>
<script>

    function others()
    {
        if(document.getElementById("alll").style.display =='none')
        {
            document.getElementById("alll").style.display = '';
        }
        else
        {
            document.getElementById("alll").style.display = 'none';
        }

    }
</script>
<script type="text/javascript">

    function checkFault()
    {
        var fault=document.getElementById('fault_type').value;
        var strtfault=fault.toLowerCase();
        alert(strtfault);
    }

    function ChkSubmit()
    {
//        if(confirm('Are You Sure? You Want To Submit.'))
//        {
//            return true;
//        }
//        else
//        {
//            return false;
//        }
    }



</script>
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
<!-- CK Editor -->
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
    $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor1');
        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();
    });
</script>

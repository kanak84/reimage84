<?php
include_once 'main_header.php';

$control = new control();

$UserEmployeeInfo = $control->UserEmployeeInfo($_SESSION['eID']);

$statement='';
if ($_POST['user_type'] != "") {
    $statement .=" and tbl_user_info.user_type='$_POST[user_type]'";
}

if ($_POST['it_personel'] != "") {
    $statement .=" and tbl_user_info.full_name='$_POST[it_personel]'";
}

$statement = str_replace("'", "*", $statement);

$access_it_responsible_person = $control->ITResponsiblePerson();


?>

<title>Ticketing</title>

<script src="autosearch/jquery.js" type="text/javascript"></script>
<script src="autosearch/dimensions.js" type="text/javascript"></script>
<script src="autosearch/autocomplete.js" type="text/javascript"></script>

<script type="text/javascript">
    $(function () {
        setAutoComplete("searchField", "results", "autocomplete.php?part=");
    });
</script>
<style>
    table, th {

        padding: 10px;
    }
    table,td {

        padding: 5px;
    }
</style>
<!--------------search link end-------->
<script>
    function equipment_prient(id)
    {
        window.open("view/it_inventory_device_view_page.php?id=" + id, "printwindow", "menubar=1,resizable=1,width=700,height=300");
    }
</script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Search
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">IT Accessories</a></li>
            <li class="active">IT Accessories List</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

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
                                <th>Employee Name</th>
                                <th>Employee ID</th>

                                <th>Function </th>
                                <th>Department</th>
                                <th>Access Type</th>
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

                                    <td><?php echo $alt['employee_name']; ?></td>
                                    <td><?php echo $alt['employee_id']; ?></td>

                                    <td><?php echo $alt['work_field']; ?></td>
                                    <td><?php echo $alt['department_name']; ?></td>
                                    <td>
                                        <?php

                                        $access_type = $control->accessTypeIT($alt['employee_id']);

                                        if($access_type['user_type']==1){
                                            echo "Admin";
                                        }
                                        elseif($access_type['user_type']==2){
                                            echo "Sub Admin";
                                        }

                                        elseif($access_type['user_type']==3){
                                            echo "General";
                                        }
                                      ?>

                                    </td>



                                    <td>

                                        <?php
                                        if ($_SESSION['user_type'] == 1  || $_SESSION['user_type'] == 2) {
                                            ?>

<!--                                            <a class="btn btn-default btn-xs" href='?e=pabx&p=all_list&f=all&l=access_level_create'>Create</a>-->

                                            <?php  if ($_SESSION['user_type'] == 1 )
                                            {
                                                ?>
                                                <a class="btn btn-info btn-xs" href='?e=pabx&p=all_list&f=all&l=access_level_update&id=<?php echo $alt['id'] ?>'>Edit</a>
                                                <a class="btn btn-danger btn-xs" href='?e=pabx&p=all_list&f=all&l=access_level_delete&id=<?php echo $alt['id'] ?>'>Delete</a>

                                                <?php

                                            }
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
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<?php include_once 'main_footer.php'?>


<script>

    $('#example1').dataTable( {
        language: {
            searchPlaceholder: "Global Search"
        }
    } );

    function lookup(inputString) {
        if(inputString.length == 0) {
            // Hide the suggestion box.
            $('#suggestions').hide();
        } else {
            $.post("cc/scr_list.php", {queryString: ""+inputString+""}, function(data){
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
        $('#department').val(thisValue);
    }

</script>

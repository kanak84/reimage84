<?php

 include_once '../control/control.php';
 include_once '../model/model.php';

 $control=new control();
  $employee_info_data=$control->search_brand($_GET['q']);
?>

<div class="row">
    <div class="col-md-12">
        <ul class="timeline" id="mt" >
            <?php
            $i=1;
            if(!empty($employee_info_data)){ ?>

                <li class="time-label">
                <span class="bg-red">
                    <?php echo ($_GET['q'] == "")? "All Employee": $_GET['q'] ; ?>
                </span>
                </li>
                <?php
                foreach($employee_info_data as $eid):
                    ?>
                    <li style="overflow:hidden;" >
                        <i class="fa fa-user bg-red"></i>
                        <!-- ae left -->
                        <div class="timeline-item">
                            <div class="box box-danger col-sm-8 box-solid">
                                <div class="box-body pull-left">
                                    <div ><img src="https://192.168.40.70/hris/admin/<?php echo $eid[7]; ?>"  width="61" height="71" /></div>
                                    <div style="font-weight: bold">

                                        <span style="font-size: 16px"><a href="#"><strong><?php echo $eid[2]; ?></strong></a></span><br>
                                        <span><?php echo $eid[1];  ?>  </span><br>
                                        <span><?php echo $eid[4]; ?></span><br>
                                        <span><?php echo $eid[3]; ?></span><br>
                                        <span><?php echo $eid[5]; ?> </span><br>
                                        <div><a href="mailto:<?php echo $eid[6]; ?>"><i class="fa fa-envelope"></i> <?php echo $eid[6]; ?></a></div>
                                    </div>
                                </div>

                                <div class="box-body pull-right col-sm-4">
                                    <div><strong>Category :</strong> <?php echo $eid[8]; ?></div>
                                    <div><strong>Brand :</strong> <?php echo $eid[9]; ?></div>
                                    <div><strong>Device Serial No. :</strong> <?php echo $eid[10]; ?></div>
                                    <div><strong>Model No. :</strong> <?php echo $eid[11]; ?></div>
                                    <div><strong>IP Address :</strong> <?php echo $eid[12]; ?></div>
                                    <div><strong>Lan Mac Address :</strong> <?php echo $eid[13]; ?></div>
                                    <div><strong>Wlan Mac Address :</strong> <?php echo $eid[14]; ?></div><br>
                                    <!-- <div class="ae-more"><a href="?e=pabx&p=all_list&f=all&l=details_employee_info&id=<?php echo $eid[0]; ?>" name="details"></a></div> --->

                                    <div class="timeline-footer">
                                        <a class="btn btn-primary btn-xs" target="_blank" href="?e=pabx&p=all_list&f=all&l=details_it_equipment_requisition&id=<?php echo $eid[0]; ?>" name="details">Details</a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </li>

                    <?php
                endforeach;
                ?>
                <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                </li>
                <?php
            }
            else
            {
                echo "<div style='font-size: large; margin-left: 5%; color: red'>No record found!</div>";
            }
            ?>
        </ul>
        <br>
    </div>
</div>

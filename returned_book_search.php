<?php include ('header.php'); ?>

        <div class="page-title">
            <div class="title_left">
                <h3>
					<small>Home /</small> Returned Books
                </h3>
                </h3>
            </div>
        </div>
        <div class="clearfix"></div>
 
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fa fa-users"></i> Book Lists</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
							<a href="returned_book_search_print.php" target="_blank" style="background:none;">
							<button name="print" type="submit" class="btn btn-danger"><i class="fa fa-print"></i> Print</button>
							</a>
							</li>
                            
                        </ul>
						
                        <div class="clearfix"></div>
						
						<form method="POST" class="form-inline">
						
                                <div class="control-group">
                                    <div class="controls">
                                        <div class="col-md-3">
                                            <input type="date" style="color:black;" value="<?php echo (isset($_POST['datefrom'])) ? $_POST['datefrom']: ''; ?>" name="datefrom" class="form-control has-feedback-left" placeholder="Date From" aria-describedby="inputSuccess2Status4">
                                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                            <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <div class="col-md-3">
                                            <input type="date" style="color:black;" value="<?php echo (isset($_POST['dateto'])) ? $_POST['dateto']: ''; ?>" name="dateto" class="form-control has-feedback-left" placeholder="Date To" aria-describedby="inputSuccess2Status4">
                                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                            <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                                        </div>
                                    </div>
                                </div>
                                
								
								<button type="submit" name="search" class="btn btn-primary btn-outline"><i class="fa fa-calendar-o"></i> Search By Date Log In</button>
								
						</form>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <!-- content starts here -->

						<div class="table-responsive">
							<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
								
						
							<thead>
								<tr>
    <?php
    	$_SESSION['datefrom'] = $_POST['datefrom'];
    	$_SESSION['dateto'] = $_POST['dateto'];
    ?>
php
<th>Members Name</th>
                                    <th>Book Title</th>
                                    <th>Task</th>
                                    <th>Person In Charge</th>
                                    <th>Date Transaction</th>
								</tr>
							</thead>
							<tbody>
							<?php
    	
							$dateFrom = $_POST['datefrom'];
							$dateTo = $_POST['dateto'];

							if (!is_string($dateFrom) || !is_string($dateTo)) {
								throw new Exception("Invalid date format");
							}

							try {
								$dateFrom = DateTime::createFromFormat('Y-m-d', $dateFrom);
								$dateTo = DateTime::createFromFormat('Y-m-d', $dateTo);

								if ($dateFrom === false || $dateTo === false) {
									throw new Exception("Invalid date format");
								}
							} catch (Exception $e) {
								throw new Exception("Invalid date format");
							}

							$dateFrom = $dateFrom->format('Y-m-d H:i:s');
							$dateTo = $dateTo->format('Y-m-d H:i:s');

							$result= mysqli_query($con,"select * from report 
                            LEFT JOIN book ON report.book_id = book.book_id 
                            LEFT JOIN user ON report.user_id = user.user_id 
							where date_transaction BETWEEN '$dateFrom' and '$dateTo' and detail_action='Returned Book' order by report.report_id DESC ") or die (mysqli_error($con));
							
							while ($row= mysqli_fetch_array ($result) ){
                            $id=$row['report_id'];
                            $book_id=$row['book_id'];
                            $user_name=$row['firstname']." ".$row['middlename']." ".$row['lastname'];
                            
                            ?>
                            <tr>
                                <td><?php echo $user_name; ?></td>
                                <td><?php echo $row['book_title']; ?></td>
                                <td><?php echo $row['detail_action']; ?></td>
                                <td><?php echo $row['admin_name']; ?></td> 
                                <td><?php echo date("M d, Y h:m:s a",strtotime($row['date_transaction'])); ?></td>
                            </tr>
                            <?php } ?>
							</tbody>
							</table>
						</div>
						
                        <!-- content ends here -->
                    </div>
                </div>
            </div>
        </div>

<?php include ('footer.php'); ?>
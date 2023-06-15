<?php include 'db_connect.php' ?>


<style>
	.on-print{
		display: none;
	}

	.logo-holder img{
    height: 5px;
    width: 5%;
	
	}

	.nav-wrapper {
		font-size: 100px;
	}
	.nav-bar {
		padding: 0;
	}


</style>
<noscript>
	<style>
		.text-center{
			text-align:center;
		}
		.text-right{
			text-align:right;
		}
		table{
			width: 100%;
			border-collapse: collapse
		}
	
		
		
	</style>
</noscript>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<div class="col-md-12">
					<hr>
						<div class="row">
							<div class="col-md-12 mb-2">
								<button class="btn btn-sm btn-block btn-success col-md-2 ml-1 float-right" type="button" id="print"><i class="fa fa-print"></i> Print</button>
							</div>
						</div>

					
							<div id="report">
							

								<div class="on-print">


<!----------------------------------START OF STYLING TOP PART------------------------->
								<div style="width: 100%; display: table;">
										<div style="display: table-row">
											<div style="width: 600px; display: table-cell;" class="nav" display="flex"> 
												<div style="margin-top: -40px; margin-left: -63px;">
													<img src="images/logo.jpg" height="200px;">
												
												</div>
											</div>

											<div style="display: table-cell; text-align: right;"> 
												<p><b>CHAKA ROAD MALL </b> <br>
												P.O. Box 70207-00400,<br>
												
												Chaka road,<br>
												Kilimani,<br>
												Nairobi.</p>
												<p>
												0725100690.<br>
												</p>
												<p>
												
													<em>info@chakaroadmall.com</em>
												</p>
											</div>
										</div>
									</div>
<!----------------------------------END OF STYLING TOP PART------------------------->



							
							<div style="margin-top: -220px; margin-bottom: -183px; margin-left: 0px; max-width: 50px; position: center;">
								<img src="images/img-3.png" width="850px;"  height="400px;">
							</div>
							<div style="text-align: center; padding-bottom: 50px; color: #cccccc;"> 
								<p>Chaka Road Mall</p>
							</div>






<!----------------------------------START OF STYLING TOP PART------------------------->


									<?php 
										$payment_id = $_GET['id'];
										$i = 1;
										// $tamount = 0;
										$sql = "SELECT t.*,concat(t.lastname,', ',t.firstname,' ',t.middlename) as name, t.contact,h.house_no,h.price FROM tenants t inner join houses h on h.id = t.house_id where t.status = 1 and t.id = $payment_id order by h.house_no desc ";
										//echo($sql);
										$tenants =$conn->query($sql);
										if($tenants->num_rows > 0):
										while($row=$tenants->fetch_assoc()):
											$months = strtotime($row['date_in']." 23:59:59") - abs(strtotime(date('Y-m-d')." 23:59:59"));
											$months = floor(($months) / (30*60*60*24));
											$payable = $row['price'] * $months;
											$paid = $conn->query("SELECT SUM(amount) as paid FROM payments where tenant_id =".$row['id']);
											$last_payment = $conn->query("SELECT * FROM payments where tenant_id =".$row['id']." order by unix_timestamp(date_created) desc limit 1");
											$paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid'] : 0;
											$last_payment = $last_payment->num_rows > 0 ? date("M d, Y",strtotime($last_payment->fetch_array()['date_created'])) : 'N/A';
											$outstanding = - $paid - $payable;
										?>
												




												
									<div style="width: 100%; display: table; margin-top: -50px">
									
										<div style="display: table-row">
											<div style="width: 300px; display: table-cell; " class="nav" display="flex">
											<div style="color: #cccccc">
											
												<p>
													
													BILL TO:
											</div>
											       
													<b><?php echo $row['name'] ?> </b> <br>
													<?php echo $row['contact'] ?>.<br></p>
													<?php echo $row['email'] ?>.<br></p>
													<?php echo $row['house_no'] ?>
													

											</div>

										</div>
									</div>							

									<?php endwhile; ?>
									<?php else: ?>
										<tr>
											<th colspan="9"><center>No Data.</center></th>
										</tr>
									<?php endif; ?>
<!----------------------------------END OF STYLING TOP PART------------------------->


<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<div class="col-md-12">
					
									<div style="margin-top: 20px">
										<table class="table ">
											
											<hr>
												<?php 
												$payment_id = $_GET['id'];
												$i = 1;
												// $tamount = 0;
												$sql = "SELECT t.*,concat(t.lastname,', ',t.firstname,' ',t.middlename) as name,h.house_no,h.price FROM tenants t inner join houses h on h.id = t.house_id where t.status = 1 and t.id = $payment_id order by h.house_no desc ";
												//echo($sql);
												$tenants =$conn->query($sql);
												if($tenants->num_rows > 0):
												while($row=$tenants->fetch_assoc()):
													$months = strtotime($row['date_in']." 23:59:59") - abs(strtotime(date('Y-m-d')." 23:59:59"));
													$months = floor(($months) / (30*60*60*24));
													$payable = $row['price'] * $months;
													$paid = $conn->query("SELECT SUM(amount) as paid FROM payments where tenant_id =".$row['id']);
													$last_payment = $conn->query("SELECT * FROM payments where tenant_id =".$row['id']." order by unix_timestamp(date_created) desc limit 1");
													$paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid'] : 0;
													$last_payment = $last_payment->num_rows > 0 ? date("M d, Y",strtotime($last_payment->fetch_array()['date_created'])) : 'N/A';
													$outstanding = - $paid - $payable;

												

													
												?>



									<div style="width: 100%; display: table;">
										<div style="display: table-row">
											<div style="width: 600px; display: table-cell;" class="nav" display="flex"> 
												<div style="margin-top: 0px; margin-left: 0px;">
												<p><b>Rent </b> <br>
												<hr>
												<p><?php echo number_format($row['price'],2) ?></p>
												<hr>
												
												
												
												
												
												</div>
											</div>
<hr>
											<div style="width: 600px; display: table-cell;" class="nav" display="flex"> 
												<div style="margin-top: 0px; margin-left: 0px;">
												<p><b>Vat </b> <br>
												<hr>
												<p><?php echo number_format($row['price'],2) ?></p>
												<hr>
												
												
												
												</div>
											</div>
<hr>
											<div style="width: 600px; display: table-cell;" class="nav" display="flex"> 
												<div style="margin-top: 0px; margin-left: 0px;">
												<p><b>Service Charge </b> <br>
												<hr>
												<p><?php echo number_format($row['price'],2) ?></p>
												<hr>
												<p><b>Rent </b> <br>
												<hr>
												<p><b>Vat </b> <br>
												<hr>
												<p><b>Service Charge </b> <br>
												<hr>
												<p><b>TOTAL BALANCE </b> <br>
												<hr>
												
												<hr>
												
												</div>
											</div>


											


											<div style="display: table-cell; text-align: right;"> 
											<p><b>Amount </b> <br>
											<hr>
												<p>.</p>
												<hr>
												<p><?php echo number_format($outstanding,2) ?> <br>
												<hr>
												<p><?php echo number_format($outstanding,2) ?> <br>
												<hr>
												<p><?php echo number_format($outstanding,2) ?> <br>
												<hr>
												<p><b><?php echo number_format($outstanding,2) ?> </b> <br>
												<hr>
												<hr>
											</div>
										</div>
									</div>



												
								
												<?php endwhile; ?>
												<?php else: ?>
													<tr>
														<th colspan="9"><center>No Data.</center></th>
													</tr>
												<?php endif; ?>
											</tbody>
										</table>

										<br>
										<br>
									<div style="display: table-cell; text-align: right;"> 
											<p><b>Notes / Terms </b> 

									</div>
									<div 
										<p> Welcome to Chaka Road Mall </p>
									</div>
									<div style="padding-top: 260px; text-align: center; color: #cccccc;"> 
											<p>Thank You</p> 

									</div>

									</div>
								</div>								
							</div>
						</div>
					</div>
				</div>
		    </div>
		</div>
	</div>




	                  <!---------------------------------USER VIEW TABLE---->					 
					  <div class="row">
						<div class="receipt-txt" >
							
						</div>
						<table class="table table-bordered">
							<thead>
								<tr>
									
										<th>Tenant</th>
										<th>Store #</th>
										<th>Rent Balance</th>
										<th>Vat Balance</th>
										<th>Service Fee Balance</th>
										<th>Last Payment</th>
									
								</tr>
							</thead>
							<tbody>
								<?php 
								$payment_id = $_GET['id'];
								$i = 1;
								// $tamount = 0;
								$sql = "SELECT t.*,concat(t.lastname,', ',t.firstname,' ',t.middlename) as name,h.house_no,h.price FROM tenants t inner join houses h on h.id = t.house_id where t.status = 1 and t.id = $payment_id order by h.house_no desc ";
								//echo($sql);
								$tenants =$conn->query($sql);
								if($tenants->num_rows > 0):
								while($row=$tenants->fetch_assoc()):
									$months = strtotime($row['date_in']." 23:59:59") - abs(strtotime(date('Y-m-d')." 23:59:59"));
									$months = floor(($months) / (30*60*60*24));
									$payable = $row['price'] * $months;
									$paid = $conn->query("SELECT SUM(amount) as paid FROM payments where tenant_id =".$row['id']);
									$last_payment = $conn->query("SELECT * FROM payments where tenant_id =".$row['id']." order by unix_timestamp(date_created) desc limit 1");
									$paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid'] : 0;
									$last_payment = $last_payment->num_rows > 0 ? date("M d, Y",strtotime($last_payment->fetch_array()['date_created'])) : 'N/A';
									$outstanding = - $paid - $payable;
								?>
								<tr>
										
										<td><?php echo ucwords($row['name']) ?></td>
										<td><?php echo $row['house_no'] ?></td>
										<td class="text-right"><?php echo number_format($row['price'],2) ?></td>
										<td class="text-right"><?php echo number_format($outstanding,2) ?></td>
										<td class="text-right"><?php echo number_format($outstanding,2) ?></td>
										<td class="text-right"><?php echo number_format($outstanding,2) ?></td>
										<td><?php echo date('M d,Y',strtotime($last_payment)) ?></td>
								</tr>
								
							
								

							

								<?php endwhile; ?>
								<?php else: ?>
									<tr>
										<th colspan="9"><center>No Data.</center></th>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$('#print').click(function(){
		var _style = $('noscript').clone()
		var _content = $('#report').clone()
		var nw = window.open("","_blank","width=800,height=700");
		nw.document.write(_style.html())
		nw.document.write(_content.html())
		nw.document.close()
		nw.print()
		setTimeout(function(){
		nw.close()
		},500)
	})
	$('#filter-report').submit(function(e){
		e.preventDefault()
		location.href = 'index.php?page=payment_report&'+$(this).serialize()
	})
</script>
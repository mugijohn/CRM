<?php include 'db_connect.php' ?>
<?php 

$month_of = isset($_GET['month_of']) ? $_GET['month_of'] : date('Y-m');

?>
<!DOCTYPE html>
<html lang="en">
 <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <title>Document</title>
      <style>
        .result{
         color:red;
        }
        td
        {
          text-align:center;
        }
      </style>
   </head>
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
		th {
			border-top-style: solid;
			border-bottom-style: solid;
			border-spacing: 50px;
		}
		tr,td{
			border-spacing: 50px;
			border-top-style: dotted;
		}
	</style>
</noscript>
<body>
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



							
                              <div style="margin-top: -200px; margin-bottom: -565px; margin-left: -211px; width: 100px; position: center;">
								<img src="images/img-7.png" width="1517px;"  height="750px;">
							</div>
							
							<div style="text-align: center; margin-top: 85px; color: #cccccc;"> 
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
												





									<div style="width: 100%; display: table;">
										<div style="display: table-row">
											<div style="width: 300px; display: table-cell; " class="nav" display="flex">
											<div style="color: #cccccc">`
												<p>
													RECEIPT TO:
											</div>
													<b><?php echo $row['name'] ?> </b> <br></p>
													<?php echo $row['contact'] ?>.<br></p>
													<?php echo $row['email'] ?>.<br></p>
											</div>

										</div>
									</div>							
<hr>
									<?php endwhile; ?>
									<?php else: ?>
										<tr>
											<th colspan="9"><center>No Data.</center></th>
										</tr>
									<?php endif; ?>
<!----------------------------------END OF STYLING TOP PART------------------------->


										<div style="margin-top: 20px">
										
										<table class="table">
										
											<?php 
									$payment_id = $_GET['id'];
									$i = 1;
									$tamount = 0;
									$sql = "SELECT p.*,concat(t.lastname,', ',t.firstname,' ',t.middlename) as name,h.house_no FROM payments p inner join tenants t on t.id = p.tenant_id inner join houses h on h.id = t.house_id where h.id = $payment_id order by unix_timestamp(date_created) asc";
									//echo('SELECT p.*,concat(t.lastname,', ',t.firstname,' ',t.middlename) as name,h.house_no FROM payments p inner join tenants t on t.id = p.tenant_id inner join houses h on h.id = t.house_id where h.id = 72 order by unix_timestamp(date_created) asc');
									 //echo($sql);
									//echo('SELECT p.*,concat(t.lastname,', ',t.firstname,' ',t.middlename) as name,h.house_no FROM payments p inner join tenants t on t.id = p.tenant_id inner join houses h on h.id = t.house_id where h.id = 72 order by unix_timestamp(date_created) asc');
									$payments  = $conn->query($sql);
									if($payments->num_rows > 0 ):
									while($row=$payments->fetch_assoc()):
										$tamount += $row['amount'];
									?>
									

									<div style="width: 100%; display: table;">
										<div style="display: table-row">
											<div style="width: 600px; display: table-cell;" class="nav" display="flex"> 
												<div style="margin-top: 0px; margin-left: 0px;">
												<p><b>Description</b> <br>
												<hr>
												<p><?php echo $row['invoice'] ?></p>
												<hr>
												
												
												
												
												
												</div>
											</div>
<hr>
											
<hr>
											<div style="width: 600px; display: table-cell;" class="nav" display=""> 
												<div style="margin-top: 0px; margin-left: 0px;">
												<p><b>Store No </b> <br>
												<hr>
												<p><?php echo $row['house_no'] ?></p>
												<hr>
												<p><b>TOTAL PAID </b> <br>
												<hr>
												
												<hr>
												
												</div>
											</div>


											


											<div style="display: table-cell; " display="flex"> 
											<div style="margin-right: 0px; margin-left: 0px;">
											<p><b>Service_Charge</b> <br>
											<hr>
												<p>.</p>
												
												<hr>
												<p><b><?php echo number_format($row['service_charge_paid'],2) ?></b> <br>
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
									<div style="display: table-cell; text-align: right; padding-top: 20px;"> 
											<p><b>Notes / Terms </b> 

									</div>
									<div 
										<p> Welcome to Chaka Road Mall </p>
									</div>
									
									<div style="padding-top: 650px; text-align: center; color: #cccccc;"> 
											<p>Thank You</p> 

									</div>

									</div>
								</div>								
							</div>
</div>

<!----------------------------------PRINT PAGE END------------------------->

<!---------------------------------USER VIEW TABLE------------------------->					 
                       <div class="row">
						<div class="receipt-txt" >
							
						</div>
<!----------------------------------Email------------------------->

<form class="" action="send.php" method="post">
	Email <input type="email" name="email" value=""> <br>
	Subject <input type="text" name="subject" value=""> <br>
	Message <input type="text" name="message" value=""> <br>

	<button type="submit" name="send">Send</button>
</form>







<!----------------------------------Email End------------------------->
						<table class="table table-bordered">
							<thead>
							<tr>
										<th>#</th>
										
										<th>Date</th>
										<th>Tenant</th>
										<th>Store #</th>
										<th>Payment Code</th>
										<th>Rent</th>
									</tr>
							</thead>
							<tbody>
							<tbody>
									
							<?php 
									$payment_id = $_GET['id'];
									$i = 1;
									$tamount = 0;
									$sql = "SELECT p.*,concat(t.lastname,', ',t.firstname,' ',t.middlename) as name,h.house_no FROM payments p inner join tenants t on t.id = p.tenant_id inner join houses h on h.id = t.house_id where h.id = $payment_id order by unix_timestamp(date_created) asc";
									//echo('SELECT p.*,concat(t.lastname,', ',t.firstname,' ',t.middlename) as name,h.house_no FROM payments p inner join tenants t on t.id = p.tenant_id inner join houses h on h.id = t.house_id where h.id = 72 order by unix_timestamp(date_created) asc');
									 //echo($sql);
									//echo('SELECT p.*,concat(t.lastname,', ',t.firstname,' ',t.middlename) as name,h.house_no FROM payments p inner join tenants t on t.id = p.tenant_id inner join houses h on h.id = t.house_id where h.id = 72 order by unix_timestamp(date_created) asc');
									$payments  = $conn->query($sql);
									if($payments->num_rows > 0 ):
									while($row=$payments->fetch_assoc()):
										$tamount += $row['amount'];
									?>
									<tr>
										<td><?php echo $i++ ?></td>
										
										<td><?php echo date('M d,Y',strtotime($row['date_created'])) ?></td>
										<td><?php echo ucwords($row['name']) ?></td>
										<td><?php echo $row['house_no'] ?></td>
										<td><?php echo $row['invoice'] ?></td>
										<td class="text-center"><?php echo number_format($row['service_charge_paid'],2) ?></td>
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
</body>
</html>
<?php error_reporting(0); ?>
<?php include 'db_connect.php' ?>
<?php 

$month_of = isset($_GET['month_of']) ? $_GET['month_of'] : date('Y-m');

?>
<style>
	.on-print{
		display: none;
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
		tr,td,th{
			border:1px solid black;
		}
	</style>
</noscript>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<div class="col-md-12">
					<form id="filter-report">
						<div class="row form-group">
							<label class="control-label col-md-2 offset-md-2 text-right">Month of: </label>
							<input type="month" name="month_of" class='from-control col-md-4' value="<?php echo ($month_of) ?>">
							<button class="btn btn-sm btn-block btn-primary col-md-2 ml-1">Filter</button>
						</div>
					</form>
					<hr>
						<div class="row">
					
						</div>
					<div id="report">
						<div class="on-print">
						<div style="width: 100%; display: table;">
										<div style="display: table-row">
											<div style="width: 600px; display: table-cell;" class="nav" display="flex"> 
												
											</div>

											
										</div>
									</div>
<!----------------------------------END OF STYLING TOP PART------------------------->



							<div style="margin-top: -230px; margin-bottom: -495px; margin-left: -198px; max-width: 50px; position: center;">
								<img src="images/img-7.png" width="1517px;"  height="750px;">
							</div>
							<div style="text-align: center; padding-bottom: 50px; color: #cccccc;"> 
								<p>Chaka Road Mall</p>
							</div>
							<div style="text-align: center;"> 
								<p>Tenants Payments Report</p>
							</div>
						</div>
						<div class="row">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th>ID</th>
										<th>Date</th>
										<th>Tenant</th>
										<th>Store #</th>
										<th>Comment</th>
										<th>Rent</th>
										<th>Vat</th>
										<th>Service Charge</th>
										<th>Total Paid</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$i = 1;
									$rent_total = 0;
									//$sql  = $conn->query("SELECT p.*,concat(t.lastname,', ',t.firstname,' ',t.middlename) as name,h.house_no FROM payments p inner join tenants t on t.id = p.tenant_id inner join houses h on h.id = t.house_id where date_format(p.date_created,'%Y-%m') = '$month_of' order by unix_timestamp(date_created)  asc");

									$sql = "SELECT p.*,concat(t.lastname,', ',t.firstname,' ',t.middlename) as name,h.house_no FROM payments p inner join tenants t on t.id = p.tenant_id inner join houses h on h.id = t.house_id where date_format(p.date_created,'%Y-%m') = '$month_of' order by unix_timestamp(date_created) asc";
									//$sql = "SELECT p.*,concat(t.lastname,', ',t.firstname,' ',t.middlename) as name,h.house_no FROM payments p inner join tenants t on t.id = p.tenant_id inner join houses h on h.id = t.house_id where h.id = $payment_id order by unix_timestamp(date_created) asc";
									// echo('-------------------------------------------');
									//echo($sql);
									// echo('-------------------------------------------');
									$payments  = $conn->query($sql);									
									if($payments->num_rows > 0 ):
									while($row=$payments->fetch_assoc()):
										$rent_total += $row['amount'];
										$vat_total += $row['vat_paid'];
										$servive_charge_total += $row['service_charge_paid'];
										$total_amount = $row['service_charge_paid'] +  $row['vat_paid'];


										//$total_query = mysqli_query($con, "SELECT 'amount,','vat_paid', 'service_charge_paid', SUM('amount' + 'vat_paid' + 'service_charge_paid') as Total FROM payments WHERE id = tenant_id ");
										//$total_result = mysqli_fetch_array($total_query);

									?>
									<tr>
									<td><?php echo $i++ ?></td>
										<td><?php echo $row['id'] ?></td>
										<td><?php echo date('M d,Y',strtotime($row['date_created'])) ?></td>
										<td><?php echo ucwords($row['name']) ?></td>
										<td><?php echo $row['house_no'] ?></td>
										<td><?php echo $row['invoice'] ?></td>
										<td class="text-right"><?php echo number_format($row['amount'],2) ?></td>
										<td class="text-right"><?php echo number_format($row['vat_paid'],2) ?></td>
										<td class="text-right"><?php echo number_format($row['service_charge_paid'],2) ?></td>
										<td class="text-right"><?php echo number_format($row['service_charge_paid'],2) ?></td>
										<td>
											<a href="index.php?page=rent_receipt&id=<?php echo $row['tenant_id'] ?>"  type="button" class="btn btn-outline-primary" style="position-center">
												RENT
											</a>
											<a href="index.php?page=vat_receipt&id=<?php echo $row['tenant_id'] ?>"  type="button" class="btn btn-outline-primary"style="position-center">
												VAT
											</a>
											<a href="index.php?page=service_charge_receipt&id=<?php echo $row['tenant_id'] ?>"  type="button" class="btn btn-outline-primary"style="position-center">
												SERVICE CHARGE
											</a>
											<a href="index.php?page=total_receipt&id=<?php echo $row['tenant_id'] ?>"  type="button" class="btn btn-outline-primary"style="position-center">
												TOTAL PAID
											</a>
										</td>
									</tr>

								<?php endwhile; ?>
								<?php else: ?>
									<tr>
										<th colspan="6"><center>No Data.</center></th>
									</tr>
								<?php endif; ?>
								</tbody>
								<tfoot>
									<tr>
										<th colspan="6">Total Amount</th>
										<th class='text-right'><?php echo number_format($rent_total,2) ?></th>
										<th class='text-right'><?php echo number_format($vat_total,2) ?></th>
										<th class='text-right'><?php echo number_format($servive_charge_total,2) ?></th>
										<th class='text-right'><?php echo number_format($total_amount,2) ?></th>
									</tr>
									
								</tfoot>
							</table>
						</div>
						
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
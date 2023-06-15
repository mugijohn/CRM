<?php error_reporting(0); ?>
<?php include 'db_connect.php' ?>

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
					<hr>
						<div class="row">
							
						</div>
					<div id="report">
						<div class="on-print">
							 <p><center>Tenants Payment Report</center></p>
							 <p><center>As of <b><?php echo date('F ,Y') ?></b></center></p>
						</div>
			
						
						
						<!-------------USER VIEW TABLE------->
						
						
						<div class="">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th>Tenant</th>
										<th>Store #</th>
										<th>Rent</th>
										<th>Vat</th>
										<th>Payable Months</th>
										<th>Payable Amount</th>
										<th>Rent Paid</th>
										<th>Vat Paid</th>
										<th>Service Fee Paid</th>
										<th>Rent Bal</th>
										<th>Vat Bal</th>
										<th>Service Fee Bal</th>
										<th>Description</th>							
										<th>Last Payment</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>


									<?php 
									$i = 1;
									// $tamount = 0;
									$tenants =$conn->query("SELECT t.*,concat(t.lastname,', ',t.firstname,' ',t.middlename) as name,h.house_no,h.price FROM tenants t inner join houses h on h.id = t.house_id where t.status = 1 order by h.house_no desc ");
									if($tenants->num_rows > 0):
									while($row=$tenants->fetch_assoc()):
										$months = strtotime($row['date_in']." 23:59:59") - abs(strtotime(date('Y-m-d')." 23:59:59"));										
										$months = floor(($months) / (30*60*60*24));
										$payable = $row['price'] * $months;
										$paid = $conn->query("SELECT SUM(amount) as paid FROM payments where tenant_id =".$row['id']);
										$last_payment = $conn->query("SELECT * FROM payments where tenant_id =".$row['id']." order by unix_timestamp(date_created) desc limit 1");
										$paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid'] : 0;
										$last_payment = $last_payment->num_rows > 0 ? date("M d, Y",strtotime($last_payment->fetch_array()['date_created'])) : 'N/A';
										$outstanding_rent = - $paid - $payable ;

										$payable_vat = $row['vat_paid'] * $months;
										$vat_paid = $conn->query("SELECT SUM(vat_paid) as paid FROM payments where tenant_id =".$row['id']);
										$last_payment = $conn->query("SELECT * FROM payments where tenant_id =".$row['id']." order by unix_timestamp(date_created) desc limit 1");
										$vat_paid = $vat_paid->num_rows > 0 ? $vat_paid->fetch_array()['paid'] : 0;
										$last_payment = $last_payment->num_rows > 0 ? date("M d, Y",strtotime($last_payment->fetch_array()['date_created'])) : 'N/A';
										$outstanding_vat = - $vat_paid - $payable_vat;

										$payable = $row['price'] * $months;
										$paid = $conn->query("SELECT SUM(amount) as paid FROM payments where tenant_id =".$row['id']);
										$last_payment = $conn->query("SELECT * FROM payments where tenant_id =".$row['id']." order by unix_timestamp(date_created) desc limit 1");
										$paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid'] : 0;
										$last_payment = $last_payment->num_rows > 0 ? date("M d, Y",strtotime($last_payment->fetch_array()['date_created'])) : 'N/A';
										$outstanding_rent = - $paid - $payable ;


									?>
									<tr>
										<td><?php echo $i++ ?></td>
										<td><?php echo ucwords($row['name']) ?></td>
										<td><?php echo $row['house_no'] ?></td>
										<td class="text-right"><?php echo number_format($row['price'],2) ?></td>
										<td class="text-right"><?php echo number_format($row['price'],2) ?></td>
										<td class="text-right"><?php echo abs($months).' mo/s' ?></td>
										<td class="text-right"><?php echo number_format(abs($payable),2) ?></td>
										<td class="text-right"><?php echo number_format($paid,2) ?></td>
										<td class="text-right"><?php echo number_format($vat_paid,2) ?></td>
										<td class="text-right"><?php echo number_format($paid,2) ?></td>
										<td class="text-right"><?php echo number_format($outstanding_rent,2) ?></td>
										<td class="text-right"><?php echo number_format($outstanding_rent,2) ?></td>
										<td class="text-right"><?php echo number_format($outstanding_rent,2) ?></td>
										<td><?php echo $row['invoice'] ?></td>
										<td><?php echo date('M d,Y',strtotime($last_payment)) ?></td>
										
										<td>
											<a href="index.php?page=balance_receipt&id=<?php echo $row['id'] ?>" type="button" class="btn btn-outline-primary">
												Generate Receipt
											</a>
										</td>
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
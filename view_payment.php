<?php include 'db_connect.php' ?>

<?php 
$tenants =$conn->query("SELECT t.*,concat(t.lastname,', ',t.firstname,' ',t.middlename) as name,h.house_no,h.price FROM tenants t inner join houses h on h.id = t.house_id where t.id = {$_GET['id']} ");
foreach($tenants->fetch_array() as $k => $v){
	if(!is_numeric($k)){
		$$k = $v;
	}
}
$months =(abs(strtotime(date('Y-m-d')." 23:59:59") - strtotime($date_in." 23:59:59"))) + 1;
$months = (floor(($months) / (30*60*60*24))) + 1;
$payable = $price * ($months);
$paid = $conn->query("SELECT SUM(amount) as paid FROM payments where tenant_id =".$_GET['id']);
$last_payment = $conn->query("SELECT * FROM payments where tenant_id =".$_GET['id']." order by unix_timestamp(date_created) desc limit 1");
$paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid'] : 2;
$last_payment = $last_payment->num_rows > 0 ? date("M d, Y",strtotime($last_payment->fetch_array()['date_created'])) : 'N/A';
$outstanding= $payable - $paid;


$view_total = $row['amount'] +  $row['service_charge_paid'] +  $row['vat_paid'];

?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-md-4">
				<div id="details">
					<large><b>Details</b></large>
					<hr>
					<p>Tenant: <b><?php echo ucwords($name) ?></b></p>
					<p>Rent: <b><?php echo number_format($price,2) ?></b></p>
					<p>Rent: <b><?php echo number_format($price,2) ?></b></p>
					<p>Outstanding Balance: <b><?php echo number_format($outstanding,2) ?></b></p>
					<p>Total Paid: <b><?php echo number_format($paid,2) ?></b></p>
					<p>Rent Started: <b><?php echo date("M d, Y",strtotime($date_in)) ?></b></p>
					
					<p>Payable Months: <b><?php echo $months ?></b></p>
				</div>
			</div>
			<div class="col-md-8">
				<large><b>Payment List</b></large>
					<hr>
				<table class="table table-condensed table-striped">
					<thead>
						<tr>
							<th>Date</th>
							<th>Payment Type</th>
							<th>Rent</th>
							<th>Vat</th>
							<th>Service Fee</th>
							<th>Total Paid</th>
							
						</tr>
					</thead>
					<tbody>
						<?php 
						$payments = $conn->query("SELECT * FROM payments where tenant_id = $id");
						if($payments->num_rows > 0):
						while($row=$payments->fetch_assoc()):
						?>
					<tr>
						<td><?php echo date("M d, Y",strtotime($row['date_created'])) ?></td>
						<td><?php echo $row['invoice'] ?></td>
						<td><?php echo $row['amount'] ?></td>
						<td><?php echo $row['vat_paid'] ?></td>
						<td><?php echo number_format($row['service_charge_paid'],2) ?></td>
						<td><?php echo number_format($view_total,2) ?></td>
					</tr>
					<?php endwhile; ?>
					<?php else: ?>
					<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<style>
	#details p {
		margin: unset;
		padding: unset;
		line-height: 1.3em;
	}
	td, th{
		padding: 3px !important;
	}
</style>
<?php //Initialize models needed for the table
$filevault_escrow = new modules\filevault_escrow\Filevault_escrow_model($serial_number);
$filevault_status = new modules\filevault_status\Filevault_status_model($serial_number);
$report   = new modules\reportdata\Reportdata_model($serial_number);
?>


	<h2>FileVault Escrow</h2>

		<table class="table table-striped">
			<tbody>
				<tr>
					<td>Status as of last Check-in
					(<span class="mr-check-in_date"></span>)</td>
					<td><?php echo $filevault_status->filevault_status; ?></td>
				</tr>
				<tr>
					<td>Enable Date</td>
					<td><?php echo $filevault_escrow->EnabledDate; ?></td>
				</tr>
				<tr>
					<td>Enabled User(s)</td>
					<td><?php echo $filevault_status->filevault_users; ?></td>
				</tr>
					<tr>
					<td>Personal Recovery Key</td>
					<td><?php echo $filevault_escrow->RecoveryKey; ?></td>
				</tr>
					<tr>
					<td>Logical Volume Group UUID</td>
					<td><?php echo $filevault_escrow->LVGUUID; ?></td>
				</tr>
					<tr>
					<td>Logical Volume UUID</td>
					<td><?php echo $filevault_escrow->LVUUID; ?></td>
				</tr>
					<tr>
					<td>Physical Volume UUID</td>
					<td><?php echo $filevault_escrow->PVUUID; ?></td>
				</tr>
					<tr>
					<td>Hard Drive Serial Number</td>
					<td><?php echo $filevault_escrow->HddSerial; ?></td>
				</tr>
			</tbody>
		</table>
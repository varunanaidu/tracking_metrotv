<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<h1>ENTRY PERFORMANCE USER</h1>
<h2>Periode : <?= DateTime::createFromFormat('!m', $PeriodMonth)->format('F').' '.$PeriodYear ?></h2>

<table border="1" width="100%">
	<thead>
		<tr>
			<th rowspan="2" style="text-align: center;">Invoice</th>
			<th colspan="2" style="text-align: center;">Entry By Billing</th>
			<th colspan="2" style="text-align: center;">Send to GA</th>
			<th colspan="2" style="text-align: center;">Approve by GA</th>
			<th colspan="2" style="text-align: center;">Delivery</th>
			<th colspan="2" style="text-align: center;">Received by Client</th>
			<th colspan="2" style="text-align: center;">Returned by Client</th>
		</tr>
		<tr>
			<th style="text-align: center;">Jumlah</th>
			<th style="text-align: center;">%</th>
			<th style="text-align: center;">Jumlah</th>
			<th style="text-align: center;">%</th>
			<th style="text-align: center;">Jumlah</th>
			<th style="text-align: center;">%</th>
			<th style="text-align: center;">Jumlah</th>
			<th style="text-align: center;">%</th>
			<th style="text-align: center;">Jumlah</th>
			<th style="text-align: center;">%</th>
			<th style="text-align: center;">Jumlah</th>
			<th style="text-align: center;">%</th>
		</tr>
	</thead>
	<tbody style="text-align: center;">
		<?php 
		if (isset($result)) {
			?>
			<tr>
				<td>Manual Off Air Invoices</td>
				<td><?= $result['manual_off_air']['EntryByBilling'][0]->TOTAL ?></td>
				<td><?= $result['manual_off_air']['EntryByBilling'][1] ?></td>
				<td><?= $result['manual_off_air']['SendToGA'][0]->TOTAL ?></td>
				<td><?= $result['manual_off_air']['SendToGA'][1] ?></td>
				<td><?= $result['manual_off_air']['ApproveByGA'][0]->TOTAL ?></td>
				<td><?= $result['manual_off_air']['ApproveByGA'][1] ?></td>
				<td><?= $result['manual_off_air']['Delivery'][0]->TOTAL ?></td>
				<td><?= $result['manual_off_air']['Delivery'][1] ?></td>
				<td><?= $result['manual_off_air']['Received'][0]->TOTAL ?></td>
				<td><?= $result['manual_off_air']['Received'][1] ?></td>
				<td><?= $result['manual_off_air']['Returned'][0]->TOTAL ?></td>
				<td><?= $result['manual_off_air']['Returned'][1] ?></td>
			</tr>
			<tr>
				<td>Manual on Air Invoices</td>
				<td><?= $result['manual_on_air']['EntryByBilling'][0]->TOTAL ?></td>
				<td><?= $result['manual_on_air']['EntryByBilling'][1] ?></td>
				<td><?= $result['manual_on_air']['SendToGA'][0]->TOTAL ?></td>
				<td><?= $result['manual_on_air']['SendToGA'][1] ?></td>
				<td><?= $result['manual_on_air']['ApproveByGA'][0]->TOTAL ?></td>
				<td><?= $result['manual_on_air']['ApproveByGA'][1] ?></td>
				<td><?= $result['manual_on_air']['Delivery'][0]->TOTAL ?></td>
				<td><?= $result['manual_on_air']['Delivery'][1] ?></td>
				<td><?= $result['manual_on_air']['Received'][0]->TOTAL ?></td>
				<td><?= $result['manual_on_air']['Received'][1] ?></td>
				<td><?= $result['manual_on_air']['Returned'][0]->TOTAL ?></td>
				<td><?= $result['manual_on_air']['Returned'][1] ?></td>
			</tr>
			<tr>
				<td>BMS Invoices</td>
				<td><?= $result['bms_invoice']['EntryByBilling'][0]->TOTAL ?></td>
				<td><?= $result['bms_invoice']['EntryByBilling'][1] ?></td>
				<td><?= $result['bms_invoice']['SendToGA'][0]->TOTAL ?></td>
				<td><?= $result['bms_invoice']['SendToGA'][1] ?></td>
				<td><?= $result['bms_invoice']['ApproveByGA'][0]->TOTAL ?></td>
				<td><?= $result['bms_invoice']['ApproveByGA'][1] ?></td>
				<td><?= $result['bms_invoice']['Delivery'][0]->TOTAL ?></td>
				<td><?= $result['bms_invoice']['Delivery'][1] ?></td>
				<td><?= $result['bms_invoice']['Received'][0]->TOTAL ?></td>
				<td><?= $result['bms_invoice']['Received'][1] ?></td>
				<td><?= $result['bms_invoice']['Returned'][0]->TOTAL ?></td>
				<td><?= $result['bms_invoice']['Returned'][1] ?></td>
			</tr>
			<?php 
		}
		?>
	</tbody>
</table>
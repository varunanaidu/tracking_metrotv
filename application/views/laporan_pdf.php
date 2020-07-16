<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php 
if (isset($result)) {
	foreach ($result as $row) {
		?>
		<p>Invoice No : <span><?= $row->InvNo ?></span></p>
		<p>PO No : <span><?= $row->PONo ?></span></p>
		<p>PO Type : <span><?= $row->PO_Type ?></span></p>
		<p>Billing Type : <span><?= $row->BillingType ?></span></p>
		<p>Agency: <span><?= $row->AgencyName ?></span></p>
		<p>Address : <span><?= $row->AgencyAddr ?></span></p>
		<p>Telephone : <span><?= ($row->AgencyTelp == 0 ? '-' : $row->AgencyTelp) ?></span></p>
		<p>Advertiser: <span><?= $row->AdvertiserName ?></span></p>
		<p>Address : <span><?= $row->AdvertiserAddr ?></span></p>
		<p>Telephone : <span><?= ($row->AdvertiserTelp == 0 ? '-' : $row->AdvertiserTelp) ?></span></p>
		<p>Product : <span><?= $row->ProductName ?></span></p>
		<p>AE : <span><?= $row->AE_Name ?></span></p>
		<p>Gross : <span><?= $row->Gross ?></span></p>
		<p>(%) Disc : <span><?= $row->AgencyDisc ?></span></p>
		<p>Nett: <span><?= $row->Nett ?></span></p>
		<p>No Resi: <span><?= $row->ResiNoFromCourier ?></span></p>
		<p>Receiver: <span><?= $row->ReceiptSendPkgReceiver ?></span></p>
		<?php
		if ($row->ReceiptPathFilename != '') {
			?>
			<img src="assets/images/invoices/<?= $row->ReceiptPathFilename ?>" alt="" style="width: 350px;">
			<?php 
		}
		?>
		<?php 
	}
}
?>
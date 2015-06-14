<?php

// Page URI sent via POST
$p = page(get('id'));

// Initialize the PDF
$pdf = new FPDF('P','in','Letter');
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);

// Build the content

$pdf->Cell(0,0.3,site()->title(),0,2); // Site title
$pdf->Cell(0,0.3,$p->txn_id()->value,0,2); // Invoice #
$pdf->Cell(0,0.3,date('F j, Y H:i',$p->txn_date()->value),0,2); // Date of order

$pdf->Ln(0.3); // Line break

$pdf->Cell(0,0.3,'Bill to: '.$p->payer_id()->value.'   '.$p->payer_email()->value,0,2); // Payer id and email

$pdf->Ln(0.3); // Line break

// List products
if (substr($p->txn_id(),0,3) === 'INV') {
    foreach ($p->products()->yaml() as $product) {
        $pdf->Cell(0,0.3,$product[item_name].' / Qty: '.$product[quantity],0,2);
    }
} else {
	$products = explode('<br />', $p->products()->kirbytext());
	foreach ($products as $product) {
		$pdf->Cell(0,0.3,trim(trim($product,'<p>'),'</p>'),0,2);
	}
}

$pdf->Ln(0.3); // Line break

$pdf->Cell(0,0.5,'Subtotal: $'.sprintf('%0.2f', $p->subtotal()->value).'     Shipping: $'.sprintf('%0.2f', $p->shipping()->value).'     Tax: $'.sprintf('%0.2f', $p->tax()->value),0,2);
$pdf->Cell(0,0.5,'Total due: $'.sprintf('%0.2f', $p->subtotal()->value+$p->shipping()->value+$p->tax()->value),0,2);

// Write the PDF
$pdf->Output($p->txn_id()->value.'.pdf','D');

?>
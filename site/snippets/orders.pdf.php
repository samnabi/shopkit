<?php

// Set detected language
site()->visit('home', $lang);
site()->kirby->localize();

// Page URI sent via POST
$p = page(get('uri'));

// Initialize the PDF
$pdf = new FPDF('P','in','Letter');
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);

// Build the content

$pdf->Cell(0,0.3,site()->title(),0,2); // Site title
$pdf->Cell(0,0.3,$p->txn_id()->value,0,2); // Invoice #
$pdf->Cell(0,0.3,date('F j, Y H:i',$p->txn_date()->value),0,2); // Date of order

$pdf->Ln(0.3); // Line break

$pdf->Cell(0,0.3,l::get('bill-to').': '.$p->payer_id()->value.'   '.$p->payer_email()->value,0,2); // Payer id and email

$pdf->Ln(0.3); // Line break

// List products
$products = explode('<br />', $p->products()->kirbytext());
foreach ($products as $product) {
	$pdf->Cell(0,0.3,trim(trim($product,'<p>'),'</p>'),0,2);
}

$pdf->Ln(0.3); // Line break

// Order price summary
$pdf->Cell(0,0.5,l::get('subtotal').': '.formatPrice($p->subtotal()->value).'     '.l::get('shipping').': '.formatPrice($p->shipping()->value).'     '.l::get('tax').': '.formatPrice($p->tax()->value),0,2);
$pdf->Cell(0,0.5,l::get('tax').': '.formatPrice($p->subtotal()->value+$p->shipping()->value+$p->tax()->value),0,2);

// Write the PDF
$pdf->Output($p->txn_id()->value.'.pdf','D');

?>
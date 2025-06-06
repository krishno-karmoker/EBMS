<?php
require '../../Config.php';
require '../../fpdf/fpdf.php';
$uid = $_GET['user_id'];
$month = $_GET['month'];

$result =  mysqli_query($link, "SELECT * FROM current_bill WHERE user_id = $uid AND month= '$month'");
$data_bill = mysqli_fetch_assoc($result);

$res =  mysqli_query($link, "SELECT * FROM current_details WHERE user_id = $uid");
$data = mysqli_fetch_assoc($res);
$name = ': ' . $data['name'];
$address = ': ' . $data['user_address'];
$acc = ': ' . $data['user_account'];
$area = ': ' . $data['user_area'];
$pre = ': ' . $data['user_premises'];
$month = ': ' . $data_bill['month'] ?? null;
$meter = ': ' . $data_bill['meter'] ?? null;
$units = ': ' . $data_bill['units'] ?? null;
$charge = ': BDT.' . $data_bill['charge'] ?? null . '/=';
$total = ': BDT.' . $data_bill['total'] ?? null . '/=';
$due = ': ' . $data_bill['due'] ?? null;
$updated = ': ' . $data_bill['updated_at'] ?? null;

$pdf = new FPDF('p', 'mm', 'A4');
$pdf->AddPage();
$pdf->Rect(7, 7, 197, 287, 'D'); //For A4
$pdf->Image('../../images/ebd-logo.jpeg', 10, 10, 20, 25);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Ln();
$pdf->Cell(0, 10, 'Bangladesh Electricity Board Statement of Electricity Account', 0, 1, 'C');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, '  PERSONAL DETAILS', 1, 1, 'L');
$pdf->ln(6);
$pdf->SetLeftMargin(20);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 8, 'Name', 0, 0, 'L');
$pdf->Cell(40, 8, $name, 0, 1, 'L');
$pdf->Cell(40, 8, 'Address', 0, 0, 'L');
$pdf->Cell(40, 8, $address, 0, 1, 'L');
$pdf->Cell(40, 8, 'Area Office', 0, 0, 'L');
$pdf->Cell(40, 8, $area, 0, 1, 'L');
$pdf->Cell(40, 8, 'Account Number', 0, 0, 'L');
$pdf->Cell(40, 8, $acc, 0, 1, 'L');
$pdf->Cell(40, 8, 'Premises ID', 0, 0, 'L');
$pdf->Cell(40, 8, $pre, 0, 1, 'L');
$pdf->Ln();
$pdf->Ln();
$pdf->SetLeftMargin(10);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, '  BILL DETAILS', 1, 1, 'L');
$pdf->ln(6);
$pdf->SetLeftMargin(20);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(60, 8, 'Month', 0, 0, 'L');
$pdf->Cell(40, 8, $month, 0, 1, 'L');
$pdf->Cell(60, 8, 'Meter', 0, 0, 'L');
$pdf->Cell(40, 8, $meter, 0, 1, 'L');
$pdf->Cell(60, 8, 'Units Consumed for the month', 0, 0, 'L');
$pdf->Cell(40, 8, $units, 0, 1, 'L');
$pdf->Cell(60, 8, 'Charge for the Month (BDT.)', 0, 0, 'L');
$pdf->Cell(40, 8, $charge, 0, 1, 'L');
$pdf->Cell(60, 8, 'Total Amount Due (BDT.)', 0, 0, 'L');
$pdf->Cell(40, 8, $total, 0, 1, 'L');
$pdf->Cell(60, 8, 'Pay Before', 0, 0, 'L');
$pdf->Cell(40, 8, $due, 0, 1, 'L');

$pdf->ln(8);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, '  ISSUING DETAILS', 1, 1, 'L');
$pdf->ln(6);
$pdf->SetLeftMargin(20);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 8, 'Date of Issue', 0, 0, 'L');
$pdf->Cell(40, 8, $updated, 0, 1, 'L');
$pdf->SetY(260);
$pdf->Cell(0, 10, 'Page ' . $pdf->PageNo(), 0, 0, 'C');
$pdf->Output();

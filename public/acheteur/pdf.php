<?php
session_start();

require_once __DIR__ . '/../../vendor/autoload.php';
require_once '../../config/Database.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;


if (!isset($_SESSION['id_user'], $_GET['id_ticket'])) {
    die("Accès refusé");
}

$id_user   = $_SESSION['id_user'];
$id_ticket = (int) $_GET['id_ticket'];

$db = Database::getConnection();

$stmt = $db->prepare("
    SELECT m.equipe1, m.equipe2, m.date_match, m.heure_match, m.lieu,
           c.nom_categorie, t.place
    FROM Ticket t
    JOIN matchs m ON t.id_match = m.id_match
    JOIN categories c ON t.id_categorie = c.id_categorie
    WHERE t.id_ticket = ? AND t.id_user = ?
");
$stmt->execute([$id_ticket, $id_user]);
$ticket = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$ticket) {
    die("Billet introuvable");
}

/* ===========================
   GÉNÉRATION DU QR CODE
   =========================== */

$qrData = json_encode([
    'ticket_id' => $id_ticket,
    'user_id'   => $id_user,
    'match'     => $ticket['equipe1'].' vs '.$ticket['equipe2'],
    'place'     => $ticket['place']
]);

$qrCode = new QrCode($qrData);


$writer = new PngWriter();
$result = $writer->write($qrCode);

$qrPath = __DIR__ . "/qr_ticket_$id_ticket.png";
$result->saveToFile($qrPath);


/* ===========================
   PDF
   =========================== */

$pdf = new FPDF();
$pdf->AddPage();

/* Header */
$pdf->SetFillColor(99,102,241);
$pdf->Rect(0, 0, 210, 30, 'F');

$pdf->SetFont('Arial','B',18);
$pdf->SetTextColor(255,255,255);
$pdf->SetXY(10,10);
$pdf->Cell(0,10,'SportTicket - Billet Officiel',0,1,'C');

$pdf->Ln(15);
$pdf->SetTextColor(0,0,0);

/* Cadre principal */
$pdf->SetDrawColor(99,102,241);
$pdf->Rect(10, 40, 190, 150);

/* Infos Match */
$pdf->SetFont('Arial','B',14);
$pdf->SetXY(15,45);
$pdf->Cell(0,10,'Informations du Match',0,1);

$pdf->SetFont('Arial','',12);
$pdf->SetX(15);
$pdf->Cell(0,8,'Match : '.$ticket['equipe1'].' vs '.$ticket['equipe2'],0,1);
$pdf->SetX(15);
$pdf->Cell(0,8,'Date  : '.$ticket['date_match'].' à '.$ticket['heure_match'],0,1);
$pdf->SetX(15);
$pdf->Cell(0,8,'Lieu  : '.$ticket['lieu'],0,1);

$pdf->Line(15, 85, 195, 85);
$pdf->Image($qrPath, 135, 130, 50, 50);


/* Infos Billet */
$pdf->Ln(5);
$pdf->SetFont('Arial','B',14);
$pdf->SetX(15);
$pdf->Cell(0,10,'Informations du Billet',0,1);

$pdf->SetFont('Arial','',12);
$pdf->SetX(15);
$pdf->Cell(0,8,'Categorie : '.$ticket['nom_categorie'],0,1);
$pdf->SetX(15);
$pdf->Cell(0,8,'Place     : '.$ticket['place'],0,1);

/* Badge VALIDE */
$pdf->SetFillColor(34,197,94);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(130, 110);
$pdf->Cell(55, 12, 'VALIDE', 0, 1, 'C', true);

/* QR Code */
$pdf->Image($qrPath, 135, 130, 50, 50);

/* Footer */
$pdf->SetTextColor(120,120,120);
$pdf->SetFont('Arial','I',10);
$pdf->SetXY(10, 270);
$pdf->Cell(0,10,'Scannez le QR Code a l entree - SportTicket © '.date('Y'),0,0,'C');

/* Télécharger */
$pdf->Output('D', 'billet_sportticket_'.$id_ticket.'.pdf');

/* Nettoyage */
unlink($qrPath);

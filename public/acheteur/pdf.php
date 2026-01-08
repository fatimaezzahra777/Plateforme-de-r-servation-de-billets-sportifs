<?php
session_start();
require_once '../../config/Database.php';
//require_once '../../libs/fpdf/fpdf.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'acheteur') {
    die('Accès refusé');
}

$id_user = $_SESSION['id_user'];

if (!isset($_GET['id'])) {
    die('Ticket invalide');
}

$id_ticket = (int) $_GET['id'];
$db = Database::getConnection();

$stmt = $db->prepare("
    SELECT t.id_ticket, t.place, t.date_achat,
           m.equipe1, m.equipe2, m.date_match, m.heure_match, m.lieu,
           c.nom_categorie, c.prix
    FROM Ticket t
    JOIN matchs m ON t.id_match = m.id_match
    JOIN categories c ON t.id_categorie = c.id_categorie
    WHERE t.id_ticket = ? AND t.id_user = ?
");
$stmt->execute([$id_ticket, $id_user]);
$ticket = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$ticket) {
    die('Ticket introuvable');
}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 20);


$pdf->SetFont('Arial','B',18);
$pdf->Cell(0,10,'Billet Officiel - SportTicket',0,1,'C');
$pdf->Ln(10);

$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,'Match : '.$ticket['equipe1'].' vs '.$ticket['equipe2'],0,1);
$pdf->Cell(0,8,'Date : '.$ticket['date_match'].' a '.$ticket['heure_match'],0,1);
$pdf->Cell(0,8,'Lieu : '.$ticket['lieu'],0,1);
$pdf->Ln(5);

$pdf->Cell(0,8,'Categorie : '.$ticket['nom_categorie'],0,1);
$pdf->Cell(0,8,'Place : '.$ticket['place'],0,1);
$pdf->Cell(0,8,'Prix : '.$ticket['prix'].' DH',0,1);
$pdf->Cell(0,8,'Date d\'achat : '.$ticket['date_achat'],0,1);

$pdf->Ln(15);

$pdf->SetFont('Arial','I',10);
$pdf->Cell(0,10,'Merci pour votre achat - SportTicket',0,1,'C');

$pdf->Output('D', 'ticket_'.$ticket['id_ticket'].'.pdf');
exit;

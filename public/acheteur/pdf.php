<?php
session_start();

require_once __DIR__ . '/../../vendor/autoload.php';
require_once '../../config/Database.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if (!isset($_SESSION['id_user'], $_GET['id_ticket'])) {
    exit("Accès refusé");
}

$id_user   = (int) $_SESSION['id_user'];
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
    exit("Billet introuvable");
}


$stmtUser = $db->prepare("SELECT nom AS user_name, email FROM users WHERE id_user = ?");
$stmtUser->execute([$id_user]);
$user = $stmtUser->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    exit("Utilisateur introuvable");
}


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


$pdfPath = __DIR__ . "/billet_sportticket_$id_ticket.pdf";
$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFillColor(99,102,241);
$pdf->Rect(0, 0, 210, 30, 'F');

$pdf->SetFont('Arial','B',18);
$pdf->SetTextColor(255,255,255);
$pdf->SetXY(10,10);
$pdf->Cell(0,10,'SportTicket - Billet Officiel',0,1,'C');

$pdf->Ln(15);
$pdf->SetTextColor(0,0,0);

$pdf->SetDrawColor(99,102,241);
$pdf->Rect(10, 40, 190, 150);

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

$pdf->Ln(5);
$pdf->SetFont('Arial','B',14);
$pdf->SetX(15);
$pdf->Cell(0,10,'Informations du Billet',0,1);

$pdf->SetFont('Arial','',12);
$pdf->SetX(15);
$pdf->Cell(0,8,'Categorie : '.$ticket['nom_categorie'],0,1);
$pdf->SetX(15);
$pdf->Cell(0,8,'Place     : '.$ticket['place'],0,1);

$pdf->SetFillColor(34,197,94);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(130, 110);
$pdf->Cell(55, 12, 'VALIDE', 0, 1, 'C', true);


$pdf->Image($qrPath, 135, 130, 50, 50);

$pdf->SetTextColor(120,120,120);
$pdf->SetFont('Arial','I',10);
$pdf->SetXY(10, 270);
$pdf->Cell(0,10,'Scannez le QR Code à l\'entrée - SportTicket © '.date('Y'),0,0,'C');


$pdf->Output('F', $pdfPath);

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'fatimaezzahrabel777@gmail.com'; 
    $mail->Password   = 'fcan dpdv mtne bqrv';     
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('fatimaezzahrabel777@gmail.com', 'SportTicket');
    $mail->addAddress($user['email'], $user['user_name']);

    $mail->isHTML(true);
    $mail->Subject = 'Votre billet SportTicket';
    $mail->Body    = "
        Bonjour ".$user['user_name'].",<br><br>
        Voici votre billet pour le match <strong>".$ticket['equipe1']." vs ".$ticket['equipe2']."</strong>.<br>
        Place : ".$ticket['place']."<br><br>
        Vous trouverez votre billet en pièce jointe.<br><br>
        Merci pour votre achat !
    ";

    $mail->addAttachment($pdfPath);
    $mail->send();

    $user_email = $user['email'];
    $pdf_file = "billet_sportticket_$id_ticket.pdf";

    echo '
    <div style="
        max-width: 500px;
        margin: 50px auto;
        padding: 20px;
        border: 2px solid #6366F1;
        border-radius: 10px;
        background-color: #f9f9ff;
        text-align: center;
        font-family: Arial, sans-serif;
    ">
        <h2 style="color: #22C55E; margin-bottom: 15px;">✔ Billet envoyé avec succès !</h2>
        <p style="font-size: 16px; color: #333;">
            Votre billet a été envoyé à <strong>'.$user_email.'</strong>.
        </p>
        <p style="margin-top: 20px;">
            <a href="'.$pdf_file.'" id="downloadBtn" style="
                display: inline-block;
                padding: 10px 20px;
                background-color: #6366F1;
                color: #fff;
                text-decoration: none;
                border-radius: 5px;
                font-weight: bold;
                transition: background 0.3s;
            " onmouseover="this.style.backgroundColor=\'#4f46e5\'" onmouseout="this.style.backgroundColor=\'#6366F1\'">
                Télécharger
            </a>
        </p>
    </div>

    <script>
    document.getElementById("downloadBtn").addEventListener("click", function(e){
        // Force le téléchargement
        var link = document.createElement("a");
        link.href = this.href;
        link.download = "billet_sportticket_'.$id_ticket.'.pdf";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        // Ouvre en même temps dans un nouvel onglet
        window.open(this.href, "_blank");
        e.preventDefault(); // empêche le comportement par défaut pour gérer JS
    });
    </script>
    ';

} catch (Exception $e) {
    echo "Erreur lors de l'envoi de l'email : ".$mail->ErrorInfo;
}

unlink($qrPath);

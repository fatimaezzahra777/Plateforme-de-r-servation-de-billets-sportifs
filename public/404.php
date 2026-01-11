<?php
http_response_code(404); 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page non trouvée</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        h1 { font-size: 50px; }
        p { font-size: 20px; }
        a { color: blue; text-decoration: none; }
    </style>
</head>
<body>
    <h1>404</h1>
    <p>Oups ! La page que vous cherchez n'existe pas.</p>
    <p><a href="index.php">Retour à l'accueil</a></p>
</body>
</html>

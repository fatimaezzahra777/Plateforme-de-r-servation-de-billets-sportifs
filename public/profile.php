<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
    <link href="/assets/css/output.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <nav class="bg-blue-600 text-white p-4 flex justify-between">
        <div class="text-2xl font-bold">SportTickets</div>
        <div>
            <a href="index.php" class="mr-4 hover:underline">Accueil</a>
            <a href="profile.php" class="hover:underline">Profil</a>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto p-6 mt-6 bg-white rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-4">Mon Profil</h1>
        <form class="space-y-4">
            <input type="text" placeholder="Nom" class="w-full border rounded px-3 py-2" value="FatimaEzzahra">
            <input type="email" placeholder="Email" class="w-full border rounded px-3 py-2" value="fatima@example.com">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Mettre à jour</button>
        </form>

        <h2 class="text-2xl font-bold mt-8 mb-2">Historique des billets</h2>
        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">Match</th>
                    <th class="border px-4 py-2">Date</th>
                    <th class="border px-4 py-2">Place</th>
                    <th class="border px-4 py-2">PDF</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border px-4 py-2">Team A vs Team B</td>
                    <td class="border px-4 py-2">12/01/2026</td>
                    <td class="border px-4 py-2">VIP 12</td>
                    <td class="border px-4 py-2"><a href="#" class="text-green-600 hover:underline">Télécharger</a></td>
                </tr>
            </tbody>
        </table>
    </main>
</body>
</html>

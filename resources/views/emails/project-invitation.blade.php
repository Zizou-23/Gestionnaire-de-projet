<!-- resources/views/emails/project-invitation.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Invitation au projet</title>
</head>
<body>
    <h1>Vous êtes invité à rejoindre le projet : {{ $project->title }}</h1>
    <p>{{ $project->description }}</p>
    <p>Cliquez sur le lien ci-dessous pour rejoindre le projet :</p>
    <p>
        <a href="{{ $joinUrl }}" style="background: #3490dc; color: #fff; padding: 10px 15px; text-decoration: none; border-radius: 5px;">
            Rejoindre le Projet
        </a>
    </p>
    <p>Ce lien est valable pendant 7 jours.</p>
</body>
</html>

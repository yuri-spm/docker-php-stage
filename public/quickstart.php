<?php


require __DIR__ . '/../vendor/autoload.php';

function connect_client()
{
    $client = new Google\Client();
    $client->setApplicationName('Google Driver');
    $client->setScopes(Google\Service\Drive::DRIVE);
    $client->setAuthConfig(__DIR__ . '/credentials.json');
    $client->setAccessType('offline');
    $client->setRedirectUri('http://localhost:8000/quickstart.php');
    return $client;
}

// Search folders — $folderId = 'root' for first level
function get_folders($drive, $pastaId = 'root')
{
    return $drive->files->listFiles([
        'pageSize' => 20,
        'q'        => "'$pastaId' in parents and mimeType='application/vnd.google-apps.folder' and trashed=false",
        'fields'   => 'files(id, name, mimeType)'
    ]);
}

// Search for files (without folders) — $folderId = 'root' for first level
function get_files($drive, $pastaId = 'root')
{
    return $drive->files->listFiles([
        'pageSize' => 20,
        'q'        => "'$pastaId' in parents and mimeType!='application/vnd.google-apps.folder' and trashed=false",
        'fields'   => 'files(id, name, mimeType)'
    ]);
}

$client = connect_client();
$tokenPath = __DIR__ . '/token.json';

// To reset: go to ?reset=1
if (isset($_GET['reset']) && file_exists($tokenPath)) {
    unlink($tokenPath);
    echo "Token apagado. <a href='/quickstart.php'>Clique aqui para autenticar.</a>";
    exit;
}

if (file_exists($tokenPath)) {
    $token = json_decode(file_get_contents($tokenPath), true);
    $client->setAccessToken($token);
}

if ($client->isAccessTokenExpired()) {
    if ($client->getRefreshToken()) {
        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    } else {
        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

            if (isset($token['error'])) {
                echo "Erro: " . $token['error'];
                exit;
            }

            $client->setAccessToken($token);
            file_put_contents($tokenPath, json_encode($token));
            echo "Autenticado! <a href='/quickstart.php'>Clique aqui para continuar.</a>";
            exit;
        }

        header('Location: ' . $client->createAuthUrl());
        exit;
    }
}

$drive = new Google\Service\Drive($client);

$folders = get_folders($drive);

echo "<h2>Documentos</h2>";
foreach ($folders->getFiles() as $folder) {
   echo $folder->getName() . ' — ID: ' . $folder->getId() . '<br>';
   
   $files = get_files($drive, $folder->getId());
   foreach($files->getFiles() as $file){
        echo "&nbsp;&nbsp;&nbsp; " . $file->getName() . '<br>';
   }
}
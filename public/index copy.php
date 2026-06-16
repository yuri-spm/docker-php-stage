<?php

use PHPUnit\TextUI\Help;
use Bevith\DockerPhp\Core\IA;
use Bevith\DockerPhp\Core\GitHub;
use Bevith\DockerPhp\Core\ViaCEp;
use Bevith\DockerPhp\Core\DummyJson;
use Bevith\DockerPhp\Services\Helper;
use Bevith\DockerPhp\Core\OpenWeather;
use Bevith\DockerPhp\Core\JsonPlaceHolder;

require __DIR__ . '/../vendor/autoload.php';




// $data  = (new DummyJson())->getUsers(10);


// $admin = array_slice(Helper::filterRole($data, 'moderator'), 0, 5);



// echo "<pre>";
// var_dump($admin);
// echo "</pre>";
// echo "<hr>";


// $departament = Helper::filterDepartament($data, 'Marketing');

// echo count($departament);
// echo "<hr>";

// echo "<pre>";
// var_dump($departament);
// echo "</pre>";

// $employees = Helper::countByDepartament($data, 'Marketing');
// echo "<pre>";
// var_dump($employees);
// echo "</pre>";

// echo "<hr>";

// $employees = Helper::employees($data, 'Marketing');
// echo "<pre>";
// var_dump($employees);
// echo "</pre>";

// $employees = Helper::resumeDepartament($data, 'Marketing');
// echo "<pre>";
// var_dump($employees);
// echo "</pre>";

// Simples

// $weather = new OpenWeather();
// $data = $weather->currentWeather('Rio de Janeiro');

// $ia = new IA();
// $response = $ia->chat("Oque aprender para dominar o laravel, pois tenho muita duvida no ORM e nas colections");
// echo "Resposta: " . $response . "\n";


//echo $ia->chatWithWeather("Consigo ir a praia ou a praça amanhã com meus filhos?", $data);



$mailbox = "{imap.gmail.com:993/imap/ssl}";
$user = "yspm.developer@gmail.com";
$password = "twfo pcxm hnfs mrpr";

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Verificador de Cota</title>
</head>
<body>

<div id="status">
    <p id="msg1">Conectando ao servidor IMAP...</p>
    <p id="msg2" style="display:none">Verificando cota de armazenamento...</p>
</div>

<div id="resultado" style="display:none">
    <?php
        sleep(2); 

        $imap = imap_open($mailbox, $user, $password);

        if ($imap) {
            $quota = imap_get_quotaroot($imap, "INBOX");

            if (is_array($quota)) {
                $usage      = $quota['STORAGE']['usage'];
                $limit      = $quota['STORAGE']['limit'];
                $percentual = ($usage / $limit) * 100;
                echo "Conseguimos concluir a conexão com o servidor IMAP!<br><br>";
                echo "Cota de armazenamento:<br>";
                echo "Em uso: " . round($usage / 1024, 2) . " MB / " . round($limit / 1024, 2) . " MB<br>";
                echo "Porcentagem: " . round($percentual, 2) . "%<br>";

                if ($percentual >= 90) {
                    echo "Alerta: Caixa de e-mail está cheia ou quase cheia!";
                } else {
                    echo "Caixa de e-mail com espaço disponível.";
                }
            } else {
                echo "Não foi possível obter informações de cota.";
            }

            imap_close($imap);
        } else {
            echo "Erro ao conectar: " . imap_last_error();
        }
    ?>
</div>

<script>
    setTimeout(() => {
        document.getElementById('msg1').style.display = 'none';
        document.getElementById('msg2').style.display = 'block';
    }, 1000);


    setTimeout(() => {
        document.getElementById('status').style.display = 'none';
        document.getElementById('resultado').style.display = 'block';
    }, 2000);
</script>

</body>
</html>
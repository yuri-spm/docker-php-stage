<?php
// include_once "include/conn.php"; // DESATIVADO

date_default_timezone_set('America/Sao_Paulo');

$data = date("d-m-Y");
$data_hoje = date("d/m/Y");
$hora_hoje = date("H");

$data_prazo = date('d/m/Y', strtotime("+1 days", strtotime($data)));

/*
|--------------------------------------------------------------------------
| MOCK (SIMULANDO BANCO)
|--------------------------------------------------------------------------
*/

$lotes = [
    [
        'id' => 232,
        'situacao' => '2',
        'nome' => 'Lote Teste 001',
        'lances' => 15000,
        'lances_cadastro' => 1,
        'data_ini' => '2026-03-16 10:30:00'
    ]
];

$contas_bancarias = [
    [
        'id' => 2,
        'razao_social' => 'Palácio dos Leilões',
        'agencia' => '1234',
        'conta' => '56789-0',
        'banco' => 'Banco do Brasil',
        'pix' => 'financeiro@palaciodeleilao.com',
        'cnpj' => '12.345.678/0001-99',
        'matricula' => '394'
    ]
];

$cadastro = [
    [
        'id' => 1,
        'nome' => 'Yuri do Monte',
        'rua' => 'Rua Teste',
        'numero' => '123',
        'email' => 'yuri@email.com',
        'cpf' => '123.456.789-00',
        'estados' => 'MG',
        'complemento' => 'Apto 101',
        'cidades' => 'Belo Horizonte',
        'telefone' => '3133333333',
        'celular' => '31999999999',
        'bairro' => 'Centro',
        'cep' => '30100-000'
    ]
];

/*
|--------------------------------------------------------------------------
| INPUT MOCK (SUBSTITUI $_GET)
|--------------------------------------------------------------------------
*/

$patio = $_GET['patio'] ?? '100,00';
$frete = $_GET['frete'] ?? '50,00';
$id_lote = $_GET['lote'] ?? 232;
$id_conta = $_GET['conta'] ?? 2;

/*
|--------------------------------------------------------------------------
| FORMATOS
|--------------------------------------------------------------------------
*/

$patio_format_calc = str_replace('.', '', $patio);
$patio_format_calc = str_replace(',', '.', $patio_format_calc);

$frete_format_calc = str_replace('.', '', $frete);
$frete_format_calc = str_replace(',', '.', $frete_format_calc);

/*
|--------------------------------------------------------------------------
| SITUAÇÃO (ANTES ERA SELECT)
|--------------------------------------------------------------------------
*/

foreach ($lotes as $info) {
    if ($info['id'] == $id_lote) {
        $situacao = $info['situacao'];
        break;
    }
}

if ($situacao != '2') :
    header("Location: index.php");
    exit;
endif;

/*
|--------------------------------------------------------------------------
| CONTA BANCÁRIA (ANTES ERA SELECT)
|--------------------------------------------------------------------------
*/

foreach ($contas_bancarias as $info) :
    if ($info['id'] == $id_conta) {
        $razao_social = $info['razao_social'];
        $agencia = $info['agencia'];
        $conta = $info['conta'];
        $banco = $info['banco'];
        $pix = $info['pix'];
        $cnpj = $info['cnpj'];
        $matricula = $info['matricula'];
    }
endforeach;

/*
|--------------------------------------------------------------------------
| LOTE (ANTES ERA SELECT)
|--------------------------------------------------------------------------
*/

foreach ($lotes as $info) :
    if ($info['id'] == $id_lote) {
        $nome_lote = $info['nome'];
        $lance_lote = $info['lances'];
        $id_arrematante = $info['lances_cadastro'];
        $data_ini = $info['data_ini'];

        $format = explode(' ', $data_ini);
        $data = $format[0];
        $format_data = explode('-', $data);
        $data_final = $format_data[2] . '/' . $format_data[1] . '/' . $format_data[0];
    }
endforeach;

$valor_lance = number_format($lance_lote, 2, ',', '.');

/*
|--------------------------------------------------------------------------
| ARREMATANTE (ANTES ERA SELECT)
|--------------------------------------------------------------------------
*/

foreach ($cadastro as $info) :
    if ($info['id'] == $id_arrematante) {
        $nome_arrematante = $info['nome'];
        $rua_arrematante = $info['rua'];
        $n_arrematante = $info['numero'];
        $email_arrematante = $info['email'];
        $cpf_arrematante = $info['cpf'];
        $estado_arrematante = $info['estados'];
        $compl_arrematante = $info['complemento'];
        $cidade_arrematante = $info['cidades'];
        $telefone_arrematante = $info['telefone'];
        $celular_arrematante = $info['celular'];
        $bairro_arrematante = $info['bairro'];
        $cep_arrematante = $info['cep'];
    }
endforeach;

/*
|--------------------------------------------------------------------------
| CÁLCULOS (MANTIDO IGUAL)
|--------------------------------------------------------------------------
*/

$total_produto =  $lance_lote;
$total_produto = number_format($total_produto, 2, '.', '');

$total_comissao = $total_produto * 5 / 100;
$total_comissao_func = number_format($total_comissao, 2, '.', '');
$total_comissao = number_format($total_comissao, 2, ',', '.');

$total_nota = $total_produto + $total_comissao_func;
$total_nota = $total_nota + $frete_format_calc + $patio_format_calc;

$total_nota_format = number_format($total_nota, 2, ',', '.');
?>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>TERMO ARREMATE</title>



    <!-- <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon"> -->
    <!-- bootstrap  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">



    <!-- <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css"> -->
    <!-- <link rel="stylesheet" href="css/bootstrap-select.min.css"> -->


    <script src="https://unpkg.com/pagedjs/dist/paged.polyfill.js"></script>

    <!-- </head> -->

    <style>
        /* css  */

        .div_marca_dagua {
            margin-top: 8em;
            margin-left: 3em;
            /* background-image: url(http://bolsadeleiloesbh.web15f03.uni5.net/web/img/z_leilao/logo.png); */
            background-image: url('img/flat-logo.png');
            width: 86%;
            background-repeat: no-repeat;
            position: absolute;
            opacity: 0.1;
            background-size: contain;
            height: 27em;
            position: running(div_marca_dagua);
        }

        .div_marca_dagua2 {
            margin-top: 12em;
            margin-left: 5em;
            /* background-image: url(http://bolsadeleiloesbh.web15f03.uni5.net/web/img/z_leilao/logo.png); */
            background-image: url('img/flat-logo.png');
            width: 88%;
            background-repeat: no-repeat;
            position: absolute;
            opacity: 0.1;
            background-size: contain;
            height: 27em;
            position: running(div_marca_dagua);
        }

        .color-black {
            color: black;
        }

        .bold {
            font-weight: bold;
        }

        .aligncenter {

            width: 100%;
            display: flex !important;
            flex-wrap: wrap !important;
            justify-content: center !important;
            align-items: center !important;
            display: -webkit-flex !important;
            -webkit-flex-wrap: wrap !important;
            -webkit-justify-content: center !important;
            -webkit-align-items: center !important;
        }

        .margin-0 {
            margin: 0;
        }

        .padding-0 {
            padding: 0;
        }

        #img_codigo {
            background-image: url('img/barras.png');
            height: 2em;
            background-size: contain;
            background-position: center;
            margin-right: 9px;
            margin-bottom: 10px;
        }

        .alignend {

            width: 100%;
            display: flex !important;
            flex-wrap: wrap !important;
            justify-content: end !important;
            align-items: center !important;
            display: -webkit-flex !important;
            -webkit-flex-wrap: wrap !important;
            -webkit-justify-content: end !important;
            -webkit-align-items: center !important;
            /* -webkit-align-items: end !important;	 esse alinha verticalmente  */
        }

        /* css  */


        body {
            font-family: sans-serif !important;
        }

        .bootstrap-select.form-control {
            border: 1px solid rgba(0, 0, 0, 0.5);
        }

        .efeitoCor {
            color: white;
        }

        .efeitoCor:hover {
            color: orange;
        }

        @media print {
            @page {
                margin: 0 !important;
                /* width: 100%; */
                size: A4;

                @top-center {
                    content: element(div_marca_dagua);

                }

            }


        }

        /* 
        @media print {
  html, body {
    width: 100%;
    height: auto;
  }
} */

        /* body { margin: 1.6cm; } */
    </style>
    <?php
    // var_dump($_GET);
    ?>

<body id="page-top">

    <!-- bg div -->
    <div class="container-fluid" style="width:100% !important;height:100%;">

        <!-- comeca aqui -->

        <!-- conteudo 1-->
        <div class="container-fluid w-100">

            <!-- bk -->
            <div class="div_marca_dagua_2">

            </div>
            <!-- bk -->

        </div>
        <!-- conteudo 1 -->

        <!-- conteudo 2 -->
        <div class=" w-100">


            <div class="div mt-1" style="height:auto;border:1px solid black;">


                <!-- row -->


                <!-- row -->
                <div class="row" style="border-top:1px solid black;--bs-gutter-x: 0;">


                    <!-- col -->
                    <div class="col-2 padding-0" style="border-right:1px solid black">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                Leiloeiro(a)
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter">
                            <span style="font-size:10px; color:black; ">
                                <?= $razao_social ?>
                            </span>
                        </div>
                    </div>
                    <!-- col -->



                    <!-- col -->
                    <div class="col padding-0" style="border-right:1px solid black">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                Matr.
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter">
                            <span style="font-size:10px; color:black;text-align:center; ">
                                394
                            </span>
                        </div>
                    </div>
                    <!-- col -->



                    <!-- col -->
                    <div class="col-2 padding-0" style="border-right:1px solid black">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                CPF/CNPJ
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter">
                            <span style="font-size:10px; color:black; ">
                                <span><?= $cnpj ?></span>
                            </span>
                        </div>
                    </div>
                    <!-- col -->



                    <!-- col -->
                    <div class="col padding-0" style="border-right:1px solid black">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                Endereço
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter">
                            <span style="font-size:10px; color:black; ">
                                BR-262
                            </span>
                        </div>
                    </div>
                    <!-- col -->



                    <!-- col -->
                    <div class="col padding-0" style="border-right:1px solid black">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                N°
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter aligncenter">
                            <span style="font-size:10px; color:black; ">
                                KM 375
                            </span>
                        </div>
                    </div>
                    <!-- col -->



                    <!-- col -->
                    <div class="col-2 padding-0" style="border-right:1px solid black">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                Bairro
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter">
                            <span style="font-size:10px; color:black; text-align:center">
                                Boa Vista da Serra
                            </span>
                        </div>
                    </div>
                    <!-- col -->



                    <!-- col -->
                    <div class="col padding-0" style="border-right:1px solid black">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                CEP
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter">
                            <span style="font-size:10px; color:black; ">
                                35675-000
                            </span>
                        </div>
                    </div>
                    <!-- col -->



                    <!-- col -->
                    <div class="col-2 padding-0" style="border-right:1px solid black">
                        <div class="w-80 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                Municipio
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-80" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-80 margin-0  mt-2 aligncenter">
                            <span style="font-size:10px; color:black; ">
                                Juatuba
                            </span>
                        </div>
                    </div>
                    <!-- col -->



                    <!-- col -->
                    <div class="col padding-0">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                UF
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter">
                            <span style="font-size:10px; color:black; ">
                                MG
                            </span>
                        </div>
                    </div>
                    <!-- col -->



                </div>
                <!-- row -->

                <!-- bazio -->
                <!-- row -->
                <div class="row w-100" style="border-top:1px solid black;--bs-gutter-x: 0; height:20px;">
                </div>
                <!-- bazio -->


                <div class="row w-100 aligncenter text-center" style="border-top:1px solid black;--bs-gutter-x: 0; ">
                    <h6 class="bold color-black mb-0" style="font-size:14px">ARREMATANTE</h6>
                </div>



                <!-- row -->
                <div class="row" style="border-top:1px solid black;--bs-gutter-x: 0;">


                    <!-- col -->
                    <div class="col-3 padding-0" style="border-right:1px solid black">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                Nome
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter">
                            <span style="font-size:10px; color:black; ">
                                <?= $nome_arrematante ?>
                            </span>
                        </div>
                    </div>
                    <!-- col -->



                    <!-- col -->
                    <div class="col padding-0" style="border-right:1px solid black">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                CPF/CNPJ
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter">
                            <span style="font-size:10px; color:black;text-align:center; ">
                                <?= $cpf_arrematante ?>
                            </span>
                        </div>
                    </div>
                    <!-- col -->



                    <!-- col -->
                    <div class="col padding-0" style="border-right:1px solid black">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                Telefone
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter">
                            <span style="font-size:10px; color:black; ">
                                <?= $telefone_arrematante ?>
                            </span>
                        </div>
                    </div>
                    <!-- col -->



                    <!-- col -->
                    <div class="col padding-0" style="border-right:1px solid black">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                Celular
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter">
                            <span style="font-size:10px; color:black; ">
                                <?= $celular_arrematante ?>
                            </span>
                        </div>
                    </div>
                    <!-- col -->



                    <!-- col -->
                    <div class="col padding-0">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                E-mail
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter aligncenter">
                            <span style="font-size:10px; color:black; ">
                                <?= $email_arrematante ?>
                            </span>
                        </div>
                    </div>
                    <!-- col -->



                </div>
                <!-- row -->


                <!-- row -->
                <div class="row" style="border-top:1px solid black;--bs-gutter-x: 0;">


                    <!-- col -->
                    <div class="col-3 padding-0" style="border-right:1px solid black">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                Endereço
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter">
                            <span style="font-size:10px; color:black; ">
                                <?= $rua_arrematante ?>
                            </span>
                        </div>
                    </div>
                    <!-- col -->



                    <!-- col -->
                    <div class="col padding-0" style="border-right:1px solid black">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                N
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter">
                            <span style="font-size:10px; color:black;text-align:center; ">
                                <?= $n_arrematante ?>
                            </span>
                        </div>
                    </div>
                    <!-- col -->



                    <!-- col -->
                    <div class="col-2 padding-0" style="border-right:1px solid black">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                Bairro
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter">
                            <span style="font-size:10px; color:black; ">
                                <?= $bairro_arrematante ?>
                            </span>
                        </div>
                    </div>
                    <!-- col -->



                    <!-- col -->
                    <div class="col-2 padding-0" style="border-right:1px solid black">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                CEP
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter">
                            <span style="font-size:10px; color:black; ">
                                <?= $cep_arrematante ?>
                            </span>
                        </div>
                    </div>
                    <!-- col -->



                    <!-- col -->
                    <div class="col padding-0" style="border-right:1px solid black">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                Município
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter aligncenter">
                            <span style="font-size:10px; color:black; ">
                                <?= $cidade_arrematante ?>
                            </span>
                        </div>
                    </div>
                    <!-- col -->


                    <!-- col -->
                    <div class="col padding-0">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                UF
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter aligncenter">
                            <span style="font-size:10px; color:black; ">
                                <?= $estado_arrematante ?>
                            </span>
                        </div>
                    </div>
                    <!-- col -->



                </div>
                <!-- row -->


                <!-- bazio -->
                <!-- row -->
                <div class="row w-100" style="border-top:1px solid black;--bs-gutter-x: 0; height:20px;">
                </div>
                <!-- bazio -->


                <div class="row w-100 aligncenter text-center" style="border-top:1px solid black;--bs-gutter-x: 0; ">
                    <h6 class="bold color-black mb-0" style="font-size:14px">DESCRIÇÃO DO LOTE</h6>
                </div>




                <!-- row -->
                <div class="row" style="border-top:1px solid black;--bs-gutter-x: 0;">


                    <!-- col -->
                    <div class="col padding-0" style="border-right:1px solid black">
                        <div class="w-100 margin-0 mt-1 text-start aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                LEILÃO/LOTE
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter">
                            <span class="bold" style="font-size:10px; color:black; ">
                                <?= $nome_lote ?>
                            </span>
                        </div>
                    </div>
                    <!-- col -->



                    <!-- col -->
                    <div class="col-2 padding-0 " style="border-right:1px solid black">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                DATA DO LEILÃO
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter">
                            <span style="font-size:10px; color:black;text-align:center; ">
                                <?= $data_hoje ?>
                            </span>
                        </div>
                    </div>
                    <!-- col -->



                    <!-- col -->
                    <div class="col-2 padding-0">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                SITUAÇÃO
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter">
                            <span style="font-size:10px; color:black; ">
                                ARREMATADO
                            </span>
                        </div>
                    </div>
                    <!-- col -->


                </div>
                <!-- row -->


                <!-- row -->
                <div class="row" style="border-top:1px solid black;--bs-gutter-x: 0;">


                    <!-- col -->
                    <div class="col-3 padding-0" style="border-right:1px solid black">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                SEQ. DO LOTE
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter">
                            <span class="" style="font-size:10px; color:black; ">
                                <?= $id_lote ?>
                            </span>
                        </div>
                    </div>
                    <!-- col -->



                    <!-- col -->
                    <div class="col padding-0" style="border-right:1px solid black">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                Valor arrematado
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter">
                            <span style="font-size:10px; color:black;text-align:center; ">
                                R$ <?= $valor_lance ?>
                            </span>
                        </div>
                    </div>
                    <!-- col -->
                    <!-- col -->
                    <div class="col padding-0" style="border-right:1px solid black">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                Comissão (5%)
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter">
                            <span style="font-size:10px; color:black;text-align:center; ">
                                R$ <?= $total_comissao ?>
                            </span>
                        </div>
                    </div>
                    <!-- col -->



                    <!-- col -->
                    <div class="col-2 padding-0" style="border-right:1px solid black">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                Taxa do pátio
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter">
                            <span style="font-size:10px; color:black; ">
                                R$ <?= $patio ?>
                            </span>
                        </div>
                    </div>
                    <!-- col -->




                    <!-- col -->
                    <div class="col-2 padding-0" style="border-right:1px solid black">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                Frete
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter">
                            <span style="font-size:10px; color:black; ">
                                R$ <?= $frete ?>
                            </span>
                        </div>
                    </div>
                    <!-- col -->




                    <!-- col -->
                    <div class="col-2 padding-0">
                        <div class="w-100 margin-0 mt-1 aligncenter">
                            <span style="font-size:10px; color:black; font-weight:bold;">
                                Total
                            </span>
                        </div>
                        <!-- div separa -->
                        <div class="w-100" style="border-top:1px solid black"></div>
                        <!-- div separa -->

                        <div class="w-100 margin-0  mt-2 aligncenter">
                            <span style="font-size:10px; color:black; ">
                                R$ <?= $total_nota_format ?>
                            </span>
                        </div>
                    </div>
                    <!-- col -->



                </div>
                <!-- row -->

                <!-- bazio -->
                <!-- row -->
                <div class="row w-100" style="border-top:1px solid black;--bs-gutter-x: 0; height:20px;">
                </div>
                <!-- bazio -->


                <div class="row w-100 aligncenter text-center" style="border-top:1px solid black;--bs-gutter-x: 0; ">
                    <h6 class="bold color-black mb-0" style="font-size:14px">DADOS PARA PAGAMENTO</h6>
                </div>

                <!-- cont -->
                <div class="row w-100" style=" padding:1em;border-top:1px solid black;--bs-gutter-x: 0;">

                    <div class="container-fluid">
                        <span class="bold color-black" style="font-size:10px">DECRETO N. 21.981, DE 19 DE OUTUBRO DE 1932</span><br>
                        <span class="color-black" style="font-size:9px">
                            O preposto indicado pelo leiloeiro prestará as mesmas provas de habilitação
                            exigidas no art. 2º, sendo considerado mandatário legal do preponente para efeito
                            de substituí-lo e de praticar, sob a sua responsabilidade, os atos que lhe forem
                            inerentes.<br><br>
                            Parágrafo único.
                            A destituição dos prepostos poderá ser dada mediante simples comunicação dos
                            leiloeiro às Juntas Comerciais, acompanhada da indicação do respesctivo substituto.

                            O Palácio dos Leilões, nomeia como representante financeiro(a) Sr.(a) <?= $razao_social ?>, portador do CPF: <?= $cnpj ?>, devendo este assumir as responsabilidades do referido oficio em conformidade com a Lei 9.973/200, e Decreto nº 3.855/2001 que regulamenta a matéria.</span><span class="color-black" style="font-size:13px"><br><br>
                    </div>


                    <div class="container-fluid">
                        <span class="bold color-black" style="font-size:10px">DADOS BANCÁRIOS PARA PAGAMENTO:</span>
                    </div>
                    <div class="container-fluid">
                        <span class="bold color-black" style="font-size:10px">Nome: </span><span class="color-black" style="font-size:8px">Palácio dos Leilões</span>
                    </div>
                    <div class="container-fluid">
                        <span class="bold color-black" style="font-size:10px">CPF: </span><span class="color-black" style="font-size:8px"><?= $cnpj ?></span>
                    </div>
                    <div class="container-fluid">
                        <span class="bold color-black" style="font-size:10px">Banco: </span><span class="color-black" style="font-size:8px"><?= $banco ?></span>
                    </div>
                    <div class="container-fluid">
                        <span class="bold color-black" style="font-size:10px">Agência: </span><span class="color-black" style="font-size:8px"><?= $agencia ?></span>
                    </div>
                    <div class="container-fluid">
                        <span class="bold color-black" style="font-size:10px">Conta Corrente: </span><span class="color-black" style="font-size:8px"><?= $conta ?></span>
                    </div>
                    <div class="container-fluid">
                        <span class="bold color-black" style="font-size:10px">Valor Total do Pagamento: </span><span class="color-black" style="font-size:8px"><?= $total_nota_format ?></span>
                    </div>
                    <div class="container-fluid" style="font-size:10px">
                        <br>
                        <h6 class="bold text-uppercase" style="color:#FF0000; margin-bottom:-14px;"> Quitação dos lotes via TED</h6><br>
                    </div>
                    <div class="container-fluid">
                        <span class="bold color-black" style="font-size:10px">DATA LIMITE PARA PAGAMENTO: </span><span class="color-black" style="font-size:8px"><?= $data_hoje ?> até às 16:00.</span>
                    </div>
                    <!--<div class="container-fluid" style="font-size:12px">-->
                    <!--    <h6 class="bold text-uppercase" style="color:#02538B; margin-bottom:-14px;"> ACEITAMOS PAGAMENTOS REALIZADOS PELO BANCO NUBANK E BANCO DO BRASIL</h6><BR>-->
                    <!--</div>-->

                    <span class="color-black" style="font-size:13px">Após o pagamento, o arrematante deverá nos enviar até ás 16:00h do dia <?= $data_hoje ?> o comprovante de pagamento via e-mail para financeiro@palaciodeleilao.com</span><BR>

                    <!-- row -->
                    <div class="row">
                        <!-- col -->
                        <div class="col aligncenter" style="border-right: 1px solid black;">
                            <!-- row -->
                            <div class="row p-2">
                                <!-- col -->
                                <div class="col aligncenter">
                                    <img src="img/flat-logo.png" class="img-fluid" style="width:9em; margin-left: 5px!important;" alt="">
                                </div>
                                <!-- col -->

                            </div>
                            <!-- row -->
                        </div>
                        <!-- col -->

                        <!-- col -->
                        <div class="col-8">
                            <!-- row -->
                            <div class="row p-2">
                                <!-- col -->
                                <div class="col aligncenter" id="">
                                    <!--<span data-ref="2f98448b-186a-4023-9218-d84623b0713e" style="margin-top: 32px;font-size: 12px;  font-weight: bold;">
                                    3654 6498 5284 1544 87974 6558 0555 8447 5221 8477 4211 8557 2473</span>-->
                                    <!-- <img src="img/codigo.webp" class="img-fluid" alt=""> -->
                                </div>
                                <!-- col -->
                                <!-- col -->
                                <!-- <div class="col-7">
                                <div class="aligncenter">
                                    <span style="font-size:10px; font-weight:bold; color:black; text-align:center">
                                        JUNTA COMERCIAL DO
                                        ESTADO DE SÃO PAULO:
                                    </span>
                                </div>
                                <div class="w-100 aligncenter">
                                    <span style="font-size:10px">
                                        institucional.jucesponline-br-gov.org
                                    </span>
                                </div>



                            </div> -->
                                <!-- col -->

                                <!-- div separa -->
                                <!--<div class="w-100 mt-2" style="border-top:1px dashed black; margin-left: -6px;"></div>-->
                                <!-- div separa -->

                                <div class="container-fluid aligncenter" style="margin-top:10px;">
                                    <h6 class="bold mb-0" style="color:black">TERMO DE RESPONSABILIDADE</h6>

                                </div>
                                <div class="container-fluid aligncenter mt-1">
                                    <p class=" mt-0 mb-0" style="font-size:9px; font-weight:400;">BR-262, KM 375 - BOA VISTA DA SERRA, JUATUBA - MG, 35675-000</p>

                                </div>


                                <!--<div class="container-fluid aligncenter mt-1">
                                <p class="bold color-black mt-0 mb-0" style="font-size:14px">PALÁCIO DOS LEILÕES</p>
                            </div>-->


                                <div class="container-fluid aligncenter">
                                    <p class="bold color-black mt-0 mb-0" style="font-size:11px">EMITIDO EM: <?= $data_hoje ?></p>
                                </div>
                                <div class="container-fluid aligncenter mt-1">
                                    <p class=" mt-0 mb-0" style="font-size:9px; font-weight:400;">Atendimento: (31) 2180-3306 / (31) 3058-2634 / (31) 99704-2767</p>
                                </div>
                                <div class="container-fluid aligncenter mt-1">
                                    <p class=" mt-0 mb-0" style="font-size:9px; font-weight:400;"><a href="https://palaciodeleilao.com/">www.palaciodeleilao.com</a></p>
                                </div>
                            </div>
                            <!-- row -->
                        </div>
                        <!-- col -->
                      
                        <div class="div mt-1" style="height:auto;border:1px solid black;">
                            <div class="row w-100 aligncenter text-center p-2" style="--bs-gutter-x: 0;">
                                <span class="color-black" style="font-size:12px">
                                    Confirmo a compra descrita acima e declaro estar ciente e de acordo com todas as condições estabelecidas.
                                </span>
                            </div>

                            <div style="display:flex; width:100%; border-top:1px solid black; border-bottom:1px solid black; align-items:flex-start;">
                                <div style="width:50%; border-right:1px solid black; padding:24px 18px 10px 24px; box-sizing:border-box;">
                                    <div class="text-start" style="height:5px; width:170px; border-top:1px solid black; margin-bottom:10px;"></div>
                                    <p class="mb-0" style="font-size:14px;"><strong>Nome: </strong><?= $nome_arrematante ?></p>
                                    <p class="mb-0" style="font-size:14px;"><strong>CPF: </strong><?= $cpf_arrematante ?></p>
                                </div>

                                <div style="width:50%; padding:24px 18px 10px 24px; box-sizing:border-box;">
                                    <div class="text-start" style="height:5px; width:170px; border-top:1px solid black; margin-bottom:10px;"></div>
                                    <img src="img/assinatura.png" style="width:6.5em; margin-top:-58px; margin-left:1.4em;" alt="">
                                    <p class="mb-0" style="margin-top:-72px; font-size:13px;"><strong>Leiloeiro (a): </strong><?= $razao_social ?></p>
                                    <p class="mb-0" style="font-size:13px;"><strong>Matricula: </strong>394</p>
                                    <p class="mb-0" style="font-size:13px;">JUATUBA/MG - <?= $data_hoje ?>.</p>
                                </div>
                            </div>

                            <div class="row w-100 aligncenter text-center p-2" style="--bs-gutter-x: 0;">
                                <span class="bold color-black" style="font-size:11px">
                                    APÓS O PAGAMENTO ESTE DOCUMENTO DEVERÁ SER ASSINADO E RECONHECIDO FIRMA POR AUTENTICIDADE DO ARREMATANTE. DOCUMENTO ASSINADO DIGITALMENTE NOS TERMOS DA LEI 11.419/2006, CONFORME IMPRESSÃO À MARGEM DIREITA.
                                </span>
                            </div>
                        </div>

                    </div>
                      <div class="row w-100 aligncenter text-center mt-4" style="--bs-gutter-x: 0; ">
                            <h6 class="bold color-black mb-0" style="font-size:11px">Site homologado pelo Tribunal de Justiça</h6>
                            <img src="../web/tmg.jpg" style="width:40px;" alt="">
                        </div>


                    <div class=" w-100">

                        </br></br>

                        <!-- div que ta com borda -->

                        <!-- <div class="container aligncenter text-center" style="--bs-gutter-x: 0; ">
                <h6 class="bold color-black mb-0" style="font-size:14px">
                BR-262, KM 375 - Boa Vista da Serra, Juatuba - MG, 35675-000
            </h6>
            </div>
            <div class="container aligncenter text-center" style="--bs-gutter-x: 0; ">
                <h6 class="bold color-black mb-0" style="font-size:14px">
                ATENDIMENTO: (31) 2626-1256 (SUPORTE AO CLIENTE)
            </h6>
            </div>

            <div class="row w-100 aligncenter text-center mt-3" style="--bs-gutter-x: 0; ">
            <p class=" color-black mt-0 mb-0" style="font-size:12px ; color:#1670f7">
            atendimento@palacioleilaomg.com
                                </p>
                                <p class=" color-black mt-0 mb-0" style="font-size:12px ; color:#1670f7">
                                www.palacioleilaomg.com
                                </p>
            </div>-->





                    </div>
                    <!-- row -->

                    <!-- acaba aqui -->









                </div>

            </div>
            <!-- cont -->
            <!--<div class="row w-100 aligncenter text-center" style="--bs-gutter-x: 0; ">
                    <h6 class="bold color-black mb-0" style="font-size:14px">REVISÃO DE LEILOEIRO/PREPOSTO(A) NA JUNTA COMERCIAL</h6>
                </div>-->



            <!-- cpm -->

            <!-- row -->
            <div class="row w-100" style="--bs-gutter-x: 0;">
                <!-- col -->
                <div class="col-3 " style="">
                    <!-- row -->
                    <div class="row">
                        <!-- col -->
                        <div class="col aligncenter">
                            <!--<img src="img/qrpalacio.png" style="width:8em;margin-top: 5px;" class="img-fluid" alt="">-->

                            <div class="container-fluid mt-1">
                                <!--<span class=" mb-0" style="color:black;font-size:9px">Abra o aplicativo da câmera do seu celular e aponte para o código</span>-->

                            </div>

                        </div>
                        <!-- col -->

                    </div>
                    <!-- row -->
                </div>
                <!-- col -->

                <!-- col -->
                <div class="col">
                    <!-- row -->
                    <div class="row">


                        <div class="container-fluid mt-1 " style="padding-left:1em;">
                            <!--<span class=" mb-0" style="color:black;font-size: 11px; "><br>Palácio dos Leilões, sempre prezando pelo bem estar de nossos clientes e visando sempre garantir sua segurança o leiloeiro/preposto (a) responsável é devidamente reconhecido e cadastrado junto a JUCEMG. Oferecemos um serviço de verificação de autenticidade que poderá ser consultado através do endereco eletronico abaixo ou qrcode.</span>-->

                        </div>
                        <div class="container-fluid  mt-2" style="padding-left:1em;">
                            <!--<p class="bold color-black mt-0 mb-0" style="font-size:13px">Acesse o site da junta comercial utilizando o qrcode</p>-->
                        </div>
                        <div class="container-fluid  mt-2" style="padding-left:1em;">
                            <p class="bold color-black mt-0 mb-0" style="font-size:12px ; color:#1670f7">

                            </p>
                        </div>

                    </div>
                    <!-- row -->
                </div>
                <!-- col -->



            </div>
            <!-- row -->

            <!-- cpm -->




        </div>



        <!-- comeca aqui 2-->

        <!-- conteudo 1-->
        <div class="container-fluid w-100">

            <!-- bk -->
            <div class="div_marca_dagua2">

            </div>
            <!-- bk -->

        </div>
        <!-- conteudo 1 -->

        <!-- conteudo 2 -->

        <!-- container  -->





    </div>
    <!-- bg div -->























    <!-- Bootstrap core JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous">
    </script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous">
    </script>
    <!-- <script src="https://unpkg.com/pagedjs/dist/paged.polyfill.js"></script> -->


    <script>
        $(document).ready(function() {

            setTimeout(function() {
                /cdigo a ser executado no tempo informado/
                window.print();
            }, 6000);
        });
    </script>






</body>

</html>

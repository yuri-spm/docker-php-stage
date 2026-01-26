# Docker PHP Stage

Um ambiente de desenvolvimento PHP com Docker, contendo exemplos de consumo de APIs externas.

## Funcionalidades

- Ambiente Docker com PHP 8.2 e Apache.
- Cliente HTTP para realizar requisições a APIs externas.
- Exemplos de integração com as seguintes APIs:
    - [OpenWeather](https://openweathermap.org/api): Para consulta de tempo e previsão do tempo.
    - [ViaCEP](https://viacep.com.br/): Para consulta de endereços a partir de um CEP.
    - [JSONPlaceholder](https://jsonplaceholder.typicode.com/): API de exemplo para testes.

## Tecnologias Utilizadas

- **PHP 8.2**
- **Docker**
- **Docker Compose**
- **Apache**
- **Guzzle HTTP Client**
- **MySQL 8.0**

## Pré-requisitos

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Como Começar

1.  **Clone o repositório:**

    ```bash
    git clone https://github.com/yuri-spm/docker-php-stage.git
    cd docker-php-stage
    ```

2.  **Configure as variáveis de ambiente:**

    Renomeie o arquivo `.env_example` para `.env` e adicione sua chave da API do OpenWeather na variável `OPENWEATHER_API_KEY`.

    ```bash
    cp .env_example .env
    ```

3.  **Suba os containers:**

    ```bash
    docker-compose up -d --build
    ```

4.  **Acesse a aplicação:**

    Acesse [http://localhost:8000](http://localhost:8000) no seu navegador.

## Utilização

O arquivo `public/index.php` contém exemplos de como utilizar as classes de API. Você pode descomentar as linhas para testar cada uma das integrações.

### Exemplo: JSONPlaceholder

```php
<?php

use Bevith\DockerPhp\Core\JsonPlaceHolder;

require_once __DIR__ . '/../vendor/autoload.php';

$response = (new JsonPlaceHolder())->getPosts();

echo '<pre>';
var_dump($response);
echo '</pre>';
```

### Exemplo: ViaCEP

```php
<?php

use Bevith\DockerPhp\Core\ViaCEp;

require_once __DIR__ . '/../vendor/autoload.php';

$response = (new ViaCEp())->getAddressByZipCode('01001000');

echo '<pre>';
var_dump($response);
echo '</pre>';
```

### Exemplo: OpenWeather

```php
<?php

use Bevith\DockerPhp\Core\OpenWeather;

require_once __DIR__ . '/../vendor/autoload.php';

$apiKey = $_ENV['OPENWEATHER_API_KEY'];
$response = (new OpenWeather($apiKey))->currentWeather('São Paulo');

echo '<pre>';
var_dump($response);
echo '</pre>';
```

## Estrutura do Projeto

```
.
├── docker
│   └── php
│       └── Dockerfile
├── public
│   └── index.php
├── src
│   ├── Core
│   │   ├── JsonPlaceHolder.php
│   │   ├── OpenWeather.php
│   │   └── ViaCEp.php
│   └── Services
│       └── HttpClient.php
├── .env_example
├── .gitignore
├── composer.json
└── docker-compose.yml
```

## Autor

- **Yuri do Monte** - [yuri-spm](https://github.com/yuri-spm)

## Licença

Este projeto está licenciado sob a licença MIT - veja o arquivo [LICENSE](LICENSE) para mais detalhes.

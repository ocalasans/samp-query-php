# samp-query-php

**samp-query-php** é uma **API** em **PHP** desenvolvida para consultar e obter informações de servidores **SA-MP (San Andreas Multiplayer)**. Esta **API** permite que você verifique se um servidor está online, obtenha o ping, informações básicas e detalhadas sobre o servidor, jogadores conectados e regras do servidor. A **API** também inclui um sistema de tentativas automáticas para garantir que os dados sejam obtidos de forma confiável.

### Idiomas

- Deutsch: [README](../Deutsch/README.md)
- English: [README](../English/README.md)
- Español: [README](../Espanol/README.md)
- Français: [README](../Francais/README.md)
- Italiano: [README](../Italiano/README.md)
- Polski: [README](../Polski/README.md)
- Русский: [README](../Русский/README.md)
- Svenska: [README](../Svenska/README.md)
- Türkçe: [README](../Turkce/README.md)

## Índice

- [samp-query-php](#samp-query-php)
    - [Idiomas](#idiomas)
  - [Índice](#índice)
  - [Características](#características)
  - [Instalação](#instalação)
  - [Uso](#uso)
    - [Exemplo de uso básico](#exemplo-de-uso-básico)
    - [Exemplo com múltiplos servidores](#exemplo-com-múltiplos-servidores)
  - [Métodos Disponíveis](#métodos-disponíveis)
    - [Verificar se o servidor está online](#verificar-se-o-servidor-está-online)
    - [Obter ping do servidor](#obter-ping-do-servidor)
    - [Obter informações do servidor](#obter-informações-do-servidor)
    - [Obter lista de jogadores](#obter-lista-de-jogadores)
      - [Lista Básica](#lista-básica)
      - [Lista Detalhada](#lista-detalhada)
    - [Obter regras do servidor](#obter-regras-do-servidor)
  - [Detalhes Técnicos](#detalhes-técnicos)
    - [Sistema de tentativas](#sistema-de-tentativas)
    - [Timeouts configuráveis](#timeouts-configuráveis)
    - [Construção de pacotes](#construção-de-pacotes)
    - [Conversão de dados](#conversão-de-dados)
  - [Customizações e Configurações](#customizações-e-configurações)
    - [Configurações avançadas de timeout](#configurações-avançadas-de-timeout)
    - [Mensagens de erro e tratamento de exceções](#mensagens-de-erro-e-tratamento-de-exceções)
  - [Licença](#licença)
    - [Condições:](#condições)

## Características

- Consulta rápida e eficiente de servidores **SA-MP**.
- Requisição de informações básicas e detalhadas do servidor.
- Possibilidade de obtenção de dados sobre jogadores e regras do servidor.
- Sistema de tentativas automático para garantir a obtenção dos dados.
- Configuração de timeouts para conexão e resposta.
- Fechamento automático do socket ao término da operação.
- Suporte a múltiplos idiomas para informações do servidor.
- Limitação personalizada para a exibição de jogadores.

## Instalação

Clone o repositório para sua máquina local:

```bash
git clone https://github.com/ocalasans/samp-query-php.git
```

## Uso

Inclua o arquivo `samp_query.php` no seu projeto e instancie a classe `Samp_Query` passando o endereço IP e a porta do servidor **SA-MP** que deseja consultar.

### Exemplo de uso básico

```php
require 'samp_query.php';

$server = new Samp_Query('127.0.0.1', 7777);

if ($server->Is_Online()) {
    echo "Servidor está online!";
    echo "Ping: " . $server->Get_Ping() . " ms";
    
    $info = $server->Get_Information();
    print_r($info);
    
    $players = $server->Get_Players_0();
    print_r($players);
    
    $rules = $server->Get_Rules();
    print_r($rules);
} else {
    echo "Servidor está offline.";
}
```

### Exemplo com múltiplos servidores

```php
require 'samp_query.php';

$servidores = [
    ['ip' => '127.0.0.1', 'porta' => 7777],
    ['ip' => '192.168.0.1', 'porta' => 7778],
];

foreach ($servers as $data) {
    $server = new Samp_Query($data['ip'], $data['porta']);
    
    if ($server->Is_Online()) {
        echo "Servidor " . $data['ip'] . ":" . $data['porta'] . " está online!";
        echo "Ping: " . $server->Get_Ping() . " ms\n";
    } else {
        echo "Servidor " . $data['ip'] . ":" . $data['porta'] . " está offline.\n";
    }
}
```

## Métodos Disponíveis

### Verificar se o servidor está online

```php
public function Is_Online()
```

Retorna `true` se o servidor estiver online, caso contrário, `false`. A verificação é realizada ao tentar conectar-se ao servidor e enviar um pacote inicial. Se a conexão falhar, o servidor é considerado offline.

### Obter ping do servidor

```php
public function Get_Ping()
```

Retorna o ping do servidor em milissegundos, calculado com base no tempo que leva para o pacote ser enviado e a resposta ser recebida. Se o servidor estiver offline ou não puder obter o ping, retorna `null`.

### Obter informações do servidor

```php
public function Get_Information()
```

Retorna um array com informações básicas do servidor, como:

- `passworded`: Indica se o servidor é protegido por senha.
- `players`: Número atual de jogadores.
- `maxplayers`: Número máximo de jogadores permitido.
- `hostname`: Nome do servidor.
- `gamemode`: Modo de jogo do servidor.
- `language`: Idioma utilizado no servidor.

Este método faz uso do sistema de tentativas automáticas para garantir que os dados sejam obtidos corretamente.

### Obter lista de jogadores

#### Lista Básica

```php
public function Get_Players_0()
```

Retorna um array com a lista de jogadores conectados, contendo `nickname` e `score` (pontuação) de cada jogador. Esse método é adequado para obter uma visão geral dos jogadores conectados.

#### Lista Detalhada

```php
public function Get_Players_1()
```

Retorna um array com informações detalhadas sobre cada jogador, incluindo `playerid`, `nickname`, `score` e `ping`. Esse método fornece dados mais profundos sobre os jogadores conectados.

### Obter regras do servidor

```php
public function Get_Rules()
```

Retorna um array com as regras do servidor, onde a chave é o nome da regra e o valor é o valor associado a essa regra. Esse método também utiliza o sistema de tentativas para assegurar a obtenção dos dados.

## Detalhes Técnicos

### Sistema de tentativas

A API incorpora um sistema de tentativas (`retry_limit`) que permite tentar a obtenção de informações até três vezes antes de desistir. Isso aumenta a confiabilidade, especialmente em situações onde a conexão pode ser instável.

### Timeouts configuráveis

Ao instanciar a classe `Samp_Query`, dois tipos de timeouts são configurados:

- `timeouts['connect']`: Define o tempo máximo em segundos para estabelecer uma conexão com o servidor. O padrão é 1 segundo.
- `timeouts['response']`: Define o tempo máximo em segundos para esperar uma resposta do servidor após o envio de um pacote. O padrão é 120 segundos que já é um tempo extremamente alto.

Esses timeouts garantem que a API não fique indefinidamente aguardando uma resposta, melhorando a eficiência.

### Construção de pacotes

Os pacotes de consulta ao servidor **SA-MP** são construídos manualmente, utilizando o prefixo `'SAMP'` seguido pelo endereço IP do servidor e pela porta. Dependendo do tipo de informação solicitada (`i`, `c`, `d`, `r`), o comando correspondente é adicionado ao pacote.

### Conversão de dados

A API inclui um método privado `To_Int()` que converte dados binários recebidos do servidor para inteiros. Esse método garante que os dados sejam manipulados corretamente, mesmo em casos de grandes valores.

```php
private function To_Int($data)
```

O método utiliza operações bit a bit para reconstruir o valor inteiro a partir dos dados binários, convertendo as quatro partes separadas de um número inteiro para o formato original.

## Customizações e Configurações

### Configurações avançadas de timeout

É possível personalizar os timeouts no momento da instância da classe `Samp_Query`. Por exemplo, para definir o tempo máximo de conexão para 5 segundos e o tempo de resposta para 60 segundos:

```php
$server = new Samp_Query('127.0.0.1', 7777);
$server->setTimeouts([
    'connect' => 5,
    'response' => 60
]);
```

### Mensagens de erro e tratamento de exceções

A API é projetada para capturar erros e falhas de conexão, retornando mensagens de erro claras em caso de falhas. Por exemplo, se um servidor não puder ser alcançado, a API retorna `null` para métodos como `Get_Information()` e `Get_Rules()`.

```php
if ($server->Get_Information() === null) {
    echo "Não foi possível obter informações do servidor.";
}
```

## Licença

Esta API está protegido sob a Licença MIT, que permite:
- ✔️ Uso comercial e privado
- ✔️ Modificação do código fonte
- ✔️ Distribuição do código
- ✔️ Sublicenciamento

### Condições:

- Manter o aviso de direitos autorais
- Incluir cópia da licença MIT

Para mais detalhes sobre a licença: https://opensource.org/licenses/MIT

**Copyright (c) Calasans - Todos os direitos reservados**

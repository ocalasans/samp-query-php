# samp-query-php

**samp-query-php** es una **API** en **PHP** desarrollada para consultar y obtener información de servidores **SA-MP (San Andreas Multiplayer)**. Esta **API** te permite verificar si un servidor está en línea, obtener el ping, información básica y detallada sobre el servidor, jugadores conectados y reglas del servidor. La **API** también incluye un sistema de reintentos automáticos para garantizar que los datos se obtengan de manera confiable.

### Idiomas

- Português: [README](../../)
- Deutsch: [README](../Deutsch/README.md)
- English: [README](../English/README.md)
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
  - [Instalación](#instalación)
  - [Uso](#uso)
    - [Ejemplo de uso básico](#ejemplo-de-uso-básico)
    - [Ejemplo con múltiples servidores](#ejemplo-con-múltiples-servidores)
  - [Métodos Disponibles](#métodos-disponibles)
    - [Verificar si el servidor está en línea](#verificar-si-el-servidor-está-en-línea)
    - [Obtener ping del servidor](#obtener-ping-del-servidor)
    - [Obtener información del servidor](#obtener-información-del-servidor)
    - [Obtener lista de jugadores](#obtener-lista-de-jugadores)
      - [Lista Básica](#lista-básica)
      - [Lista Detallada](#lista-detallada)
    - [Obtener reglas del servidor](#obtener-reglas-del-servidor)
  - [Detalles Técnicos](#detalles-técnicos)
    - [Sistema de reintentos](#sistema-de-reintentos)
    - [Timeouts configurables](#timeouts-configurables)
    - [Construcción de paquetes](#construcción-de-paquetes)
    - [Conversión de datos](#conversión-de-datos)
  - [Personalizaciones y Configuraciones](#personalizaciones-y-configuraciones)
    - [Configuraciones avanzadas de timeout](#configuraciones-avanzadas-de-timeout)
    - [Mensajes de error y manejo de excepciones](#mensajes-de-error-y-manejo-de-excepciones)
  - [Licencia](#licencia)
    - [Condiciones:](#condiciones)

## Características

- Consulta rápida y eficiente de servidores **SA-MP**.
- Solicitud de información básica y detallada del servidor.
- Posibilidad de obtener datos sobre jugadores y reglas del servidor.
- Sistema de reintentos automático para garantizar la obtención de datos.
- Configuración de timeouts para conexión y respuesta.
- Cierre automático del socket al finalizar la operación.
- Soporte para múltiples idiomas para información del servidor.
- Limitación personalizada para la visualización de jugadores.

## Instalación

Clona el repositorio en tu máquina local:

```bash
git clone https://github.com/ocalasans/samp-query-php.git
```

## Uso

Incluye el archivo `samp_query.php` en tu proyecto e instancia la clase `Samp_Query` pasando la dirección IP y el puerto del servidor **SA-MP** que deseas consultar.

### Ejemplo de uso básico

```php
require 'samp_query.php';

$server = new Samp_Query('127.0.0.1', 7777);

if ($server->Is_Online()) {
    echo "¡El servidor está en línea!";
    echo "Ping: " . $server->Get_Ping() . " ms";
    
    $info = $server->Get_Information();
    print_r($info);
    
    $players = $server->Get_Players_0();
    print_r($players);
    
    $rules = $server->Get_Rules();
    print_r($rules);
} else {
    echo "El servidor está fuera de línea.";
}
```

### Ejemplo con múltiples servidores

```php
require 'samp_query.php';

$servidores = [
    ['ip' => '127.0.0.1', 'puerto' => 7777],
    ['ip' => '192.168.0.1', 'puerto' => 7778],
];

foreach ($servers as $data) {
    $server = new Samp_Query($data['ip'], $data['puerto']);
    
    if ($server->Is_Online()) {
        echo "¡Servidor " . $data['ip'] . ":" . $data['puerto'] . " está en línea!";
        echo "Ping: " . $server->Get_Ping() . " ms\n";
    } else {
        echo "Servidor " . $data['ip'] . ":" . $data['puerto'] . " está fuera de línea.\n";
    }
}
```

## Métodos Disponibles

### Verificar si el servidor está en línea

```php
public function Is_Online()
```

Retorna `true` si el servidor está en línea, de lo contrario, `false`. La verificación se realiza al intentar conectarse al servidor y enviar un paquete inicial. Si la conexión falla, el servidor se considera fuera de línea.

### Obtener ping del servidor

```php
public function Get_Ping()
```

Retorna el ping del servidor en milisegundos, calculado en base al tiempo que tarda el paquete en ser enviado y la respuesta en ser recibida. Si el servidor está fuera de línea o no se puede obtener el ping, retorna `null`.

### Obtener información del servidor

```php
public function Get_Information()
```

Retorna un array con información básica del servidor, como:

- `passworded`: Indica si el servidor está protegido por contraseña.
- `players`: Número actual de jugadores.
- `maxplayers`: Número máximo de jugadores permitido.
- `hostname`: Nombre del servidor.
- `gamemode`: Modo de juego del servidor.
- `language`: Idioma utilizado en el servidor.

Este método utiliza el sistema de reintentos automáticos para garantizar que los datos se obtengan correctamente.

### Obtener lista de jugadores

#### Lista Básica

```php
public function Get_Players_0()
```

Retorna un array con la lista de jugadores conectados, conteniendo `nickname` y `score` (puntuación) de cada jugador. Este método es adecuado para obtener una visión general de los jugadores conectados.

#### Lista Detallada

```php
public function Get_Players_1()
```

Retorna un array con información detallada sobre cada jugador, incluyendo `playerid`, `nickname`, `score` y `ping`. Este método proporciona datos más profundos sobre los jugadores conectados.

### Obtener reglas del servidor

```php
public function Get_Rules()
```

Retorna un array con las reglas del servidor, donde la clave es el nombre de la regla y el valor es el valor asociado a esa regla. Este método también utiliza el sistema de reintentos para asegurar la obtención de los datos.

## Detalles Técnicos

### Sistema de reintentos

La API incorpora un sistema de reintentos (`retry_limit`) que permite intentar la obtención de información hasta tres veces antes de desistir. Esto aumenta la confiabilidad, especialmente en situaciones donde la conexión puede ser inestable.

### Timeouts configurables

Al instanciar la clase `Samp_Query`, se configuran dos tipos de timeouts:

- `timeouts['connect']`: Define el tiempo máximo en segundos para establecer una conexión con el servidor. El valor predeterminado es 1 segundo.
- `timeouts['response']`: Define el tiempo máximo en segundos para esperar una respuesta del servidor después de enviar un paquete. El valor predeterminado es 120 segundos, que ya es un tiempo extremadamente alto.

Estos timeouts garantizan que la API no espere indefinidamente una respuesta, mejorando la eficiencia.

### Construcción de paquetes

Los paquetes de consulta al servidor **SA-MP** se construyen manualmente, utilizando el prefijo `'SAMP'` seguido por la dirección IP del servidor y el puerto. Dependiendo del tipo de información solicitada (`i`, `c`, `d`, `r`), se añade el comando correspondiente al paquete.

### Conversión de datos

La API incluye un método privado `To_Int()` que convierte datos binarios recibidos del servidor a enteros. Este método garantiza que los datos sean manipulados correctamente, incluso en casos de valores grandes.

```php
private function To_Int($data)
```

El método utiliza operaciones bit a bit para reconstruir el valor entero a partir de los datos binarios, convirtiendo las cuatro partes separadas de un número entero al formato original.

## Personalizaciones y Configuraciones

### Configuraciones avanzadas de timeout

Es posible personalizar los timeouts al momento de instanciar la clase `Samp_Query`. Por ejemplo, para establecer el tiempo máximo de conexión en 5 segundos y el tiempo de respuesta en 60 segundos:

```php
$server = new Samp_Query('127.0.0.1', 7777);
$server->setTimeouts([
    'connect' => 5,
    'response' => 60
]);
```

### Mensajes de error y manejo de excepciones

La API está diseñada para capturar errores y fallos de conexión, retornando mensajes de error claros en caso de fallos. Por ejemplo, si no se puede alcanzar un servidor, la API retorna `null` para métodos como `Get_Information()` y `Get_Rules()`.

```php
if ($server->Get_Information() === null) {
    echo "No fue posible obtener información del servidor.";
}
```

## Licencia

Esta API está protegida bajo la Licencia MIT, que permite:
- ✔️ Uso comercial y privado
- ✔️ Modificación del código fuente
- ✔️ Distribución del código
- ✔️ Sublicenciamiento

### Condiciones:

- Mantener el aviso de derechos de autor
- Incluir copia de la licencia MIT

Para más detalles sobre la licencia: https://opensource.org/licenses/MIT

**Copyright (c) Calasans - Todos los derechos reservados**
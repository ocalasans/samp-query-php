# samp-query-php

**samp-query-php** es una **API** en **PHP** desarrollada para consultar y obtener información de servidores **SA-MP (San Andreas Multiplayer)**. Esta **API** permite que verifiques si un servidor está en línea, obtengas el ping, información básica y detallada sobre el servidor, jugadores conectados y reglas del servidor. La **API** también incluye un sistema de intentos automáticos para garantizar que los datos se obtengan de manera confiable.

### 🌐 Lenguajes

- **Português** > [README](https://github.com/ocalasans/samp-query-php) / [Código](https://github.com/ocalasans/samp-query-php/blob/main/samp-query.php).
- **English** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/English/README.md) / [Code](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/English/samp-query-php).
- **Polski** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Polski/README.md) / [Kod](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Polski/samp-query-php).
- **Türk** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Turk/README.md) / [Kod](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Turk/samp-query-php).
- **Deutsch** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Deutsch/README.md) / [Code](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Deutsch/samp-query-php).
- **Русский** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Русский/README.md) / [Код](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Русский/samp-query-php).
- **Français** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Francais/README.md) / [Code](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Francais/samp-query-php).
- **Italiano** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Italiano/README.md) / [Codice](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Italiano/samp-query-php).
- **Svensk** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Svensk/README.md) / [Koda](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Svensk/samp-query-php).
  
## 📋 Índice

- [samp-query-php](#samp-query-php)
    - [🌐 Lenguajes](#-lenguajes)
  - [📋 Índice](#-índice)
  - [🎯 Características](#-características)
  - [🛠️ Instalación](#️-instalación)
  - [🚀 Uso](#-uso)
    - [Ejemplo de uso básico](#ejemplo-de-uso-básico)
    - [Ejemplo con múltiples servidores](#ejemplo-con-múltiples-servidores)
  - [🧩 Métodos Disponibles](#-métodos-disponibles)
    - [Verificar si el servidor está en línea](#verificar-si-el-servidor-está-en-línea)
    - [Obtener el ping del servidor](#obtener-el-ping-del-servidor)
    - [Obtener información del servidor](#obtener-información-del-servidor)
    - [Obtener lista de jugadores](#obtener-lista-de-jugadores)
      - [Lista Básica](#lista-básica)
      - [Lista Detallada](#lista-detallada)
    - [Obtener reglas del servidor](#obtener-reglas-del-servidor)
  - [🔍 Detalles Técnicos](#-detalles-técnicos)
    - [Sistema de intentos](#sistema-de-intentos)
    - [Timeouts configurables](#timeouts-configurables)
    - [Construcción de paquetes](#construcción-de-paquetes)
    - [Conversión de datos](#conversión-de-datos)
  - [🔧 Personalizaciones y Configuraciones](#-personalizaciones-y-configuraciones)
    - [Configuraciones avanzadas de timeout](#configuraciones-avanzadas-de-timeout)
    - [Mensajes de error y manejo de excepciones](#mensajes-de-error-y-manejo-de-excepciones)
  - [ℹ️ Información de contacto](#ℹ️-información-de-contacto)

## 🎯 Características

- Consulta rápida y eficiente de servidores **SA-MP**.
- Solicitud de información básica y detallada del servidor.
- Posibilidad de obtener datos sobre jugadores y reglas del servidor.
- Sistema automático de reintentos para garantizar la obtención de los datos.
- Configuración de tiempos de espera para conexión y respuesta.
- Cierre automático del socket al finalizar la operación.
- Soporte para múltiples idiomas en la información del servidor.
- Limitación personalizada para la visualización de jugadores.

## 🛠️ Instalación

Clona el repositorio en tu máquina local:

```bash
git clone https://github.com/ocalasans/samp-query-php.git
```

## 🚀 Uso

Incluye el archivo `samp_query.php` en tu proyecto e instancia la clase `samp_query` pasando la dirección IP y el puerto del servidor **SA-MP** que deseas consultar.

### Ejemplo de uso básico

```php
require 'samp_query.php';

$server = new samp_query('127.0.0.1', 7777);

if ($server->Esta_EnLinea()) {
    echo "¡El servidor está en línea!";
    echo "Ping: " . $server->Obtener_Ping() . " ms";
    
    $info = $server->Obtener_Informacion();
    print_r($info);
    
    $jugadores = $server->Obtener_Jugadores_0();
    print_r($jugadores);
    
    $reglas = $server->Obtener_Reglas();
    print_r($reglas);
} else {
    echo "El servidor está fuera de línea.";
}
```

### Ejemplo con múltiples servidores

```php
require 'samp_query.php';

$servidores = [
    ['ip' => '127.0.0.1', 'puerta' => 7777],
    ['ip' => '192.168.0.1', 'puerta' => 7778],
];

foreach ($servidores as $datos) {
    $server = new samp_query($datos['ip'], $datos['puerta']);
    
    if ($server->Esta_EnLinea()) {
        echo "Servidor " . $datos['ip'] . ":" . $datos['puerta'] . " ¡está en línea!";
        echo "Ping: " . $server->Obtener_Ping() . " ms\n";
    } else {
        echo "Servidor " . $datos['ip'] . ":" . $datos['puerta'] . " eestá fuera de línea.\n";
    }
}
```

## 🧩 Métodos Disponibles

### Verificar si el servidor está en línea

```php
public function Esta_EnLinea()
```

Retorna `true` si el servidor está en línea, de lo contrario, `false`. La verificación se realiza al intentar conectarse al servidor y enviar un paquete inicial. Si la conexión falla, el servidor se considera fuera de línea.

### Obtener el ping del servidor

```php
public function Obtener_Ping()
```

Retorna el ping del servidor en milisegundos, calculado en base al tiempo que tarda en enviar el paquete y recibir la respuesta. Si el servidor está fuera de línea o no se puede obtener el ping, retorna `null`.

### Obtener información del servidor

```php
public function Obtener_Informacion()
```

Retorna un array con información básica del servidor, como:

- `passworded`: Indica si el servidor está protegido por una contraseña.
- `players`: Número actual de jugadores.
- `maxplayers`: Número máximo de jugadores permitido.
- `hostname`: Nombre del servidor.
- `gamemode`: Modo de juego del servidor.
- `language`: Idioma utilizado en el servidor.

Este método hace uso del sistema de intentos automáticos para garantizar que los datos se obtengan correctamente.

### Obtener lista de jugadores

#### Lista Básica

```php
public function Obtener_Jugadores_0()
```

Devuelve un array con la lista de jugadores conectados, que contiene `nickname` y `score` (puntuación) de cada jugador. Este método es adecuado para obtener una visión general de los jugadores conectados.

#### Lista Detallada

```php
public function Obtener_Jugadores_1()
```

Devuelve un array con información detallada sobre cada jugador, incluyendo `playerid`, `nickname`, `score` y `ping`. Este método proporciona datos más profundos sobre los jugadores conectados.

### Obtener reglas del servidor

```php
public function Obtener_Reglas()
```

Devuelve un array con las reglas del servidor, donde la clave es el nombre de la regla y el valor es el valor asociado a esa regla. Este método también utiliza el sistema de intentos para asegurar la obtención de los datos.

## 🔍 Detalles Técnicos

### Sistema de intentos

La API incorpora un sistema de intentos (`retryLimit`) que permite intentar obtener información hasta tres veces antes de rendirse. Esto aumenta la fiabilidad, especialmente en situaciones donde la conexión puede ser inestable.

### Timeouts configurables

Al instanciar la clase `samp_query`, se configuran dos tipos de timeouts:

- `timeouts['connect']`: Define el tiempo máximo en segundos para establecer una conexión con el servidor. El valor por defecto es 1 segundo.
- `timeouts['response']`: Define el tiempo máximo en segundos para esperar una respuesta del servidor después del envío de un paquete. El valor por defecto es 120 segundos, que ya es un tiempo extremadamente alto.

Estos timeouts garantizan que la API no quede esperando indefinidamente una respuesta, mejorando la eficiencia.

### Construcción de paquetes

Los paquetes de consulta al servidor **SA-MP** se construyen manualmente, utilizando el prefijo `'SAMP'` seguido por la dirección IP del servidor y el puerto. Dependiendo del tipo de información solicitada (`i`, `c`, `d`, `r`), el comando correspondiente se añade al paquete.

### Conversión de datos

La API incluye un método privado `toInt()` que convierte datos binarios recibidos del servidor en enteros. Este método garantiza que los datos se manejen correctamente, incluso en casos de valores grandes.

```php
private function toInt($data)
```

El método utiliza operaciones bit a bit para reconstruir el valor entero a partir de los datos binarios, convirtiendo las cuatro partes separadas de un número entero al formato original.

## 🔧 Personalizaciones y Configuraciones

### Configuraciones avanzadas de timeout

Es posible personalizar los timeouts al momento de instanciar la clase `samp_query`. Por ejemplo, para definir el tiempo máximo de conexión en 5 segundos y el tiempo de respuesta en 60 segundos:

```php
$server = new samp_query('127.0.0.1', 7777);
$server->setTimeouts([
    'connect' => 5,
    'response' => 60
]);
```

### Mensajes de error y manejo de excepciones

La API está diseñada para capturar errores y fallos de conexión, devolviendo mensajes de error claros en caso de fallos. Por ejemplo, si un servidor no puede ser alcanzado, la API devuelve `null` para métodos como `Obtener_Informacion()` y `Obtener_Reglas()`.

```php
if ($server->Obtener_Informacion() === null) {
    echo "No se pudieron obtener información del servidor.";
}
```

## ℹ️ Información de contacto

Instagram: [ocalasans](https://instagram.com/ocalasans)   
YouTube: [Calasans](https://www.youtube.com/@ocalasans)   
Discord: [Calasans](https://discord.com/users/793520050832932884)   
Comunidad: [SA-MP Programming Community©](https://abre.ai/samp-spc)
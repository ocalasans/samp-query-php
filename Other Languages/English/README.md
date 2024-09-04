# samp-query-php

**samp-query-php** is a **PHP** **API** developed to query and retrieve information from **SA-MP (San Andreas Multiplayer)** servers. This **API** allows you to check if a server is online, obtain the ping, basic and detailed server information, connected players, and server rules. The **API** also includes an automatic retry system to ensure that the data is reliably obtained.

### 🌐 Languages

- **Português** > [README](https://github.com/ocalasans/samp-query-php) / [Código](https://github.com/ocalasans/samp-query-php/blob/main/samp-query.php).
- **Español** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Espanol) / [Código](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Espanol/samp-query.php).
- **Polski** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Polski) / [Kod](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Polski/samp-query.php).
- **Türk** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Turk) / [Kod](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Turk/samp-query.php).
- **Deutsch** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Deutsch) / [Code](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Deutsch/samp-query.php).
- **Русский** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Русский) / [Код](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Русский/samp-query.php).
- **Français** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Francais) / [Code](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Francais/samp-query.php).
- **Italiano** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Italiano) / [Codice](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Italiano/samp-query.php).
- **Svensk** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Svensk) / [Koda](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Svensk/samp-query.php).

## 📋 Summary

- [samp-query-php](#samp-query-php)
    - [🌐 Languages](#-languages)
  - [📋 Summary](#-summary)
  - [🎯 Features](#-features)
  - [🛠️ Installation](#️-installation)
  - [🚀 Usage](#-usage)
    - [Basic usage example](#basic-usage-example)
    - [Example with Multiple Servers](#example-with-multiple-servers)
  - [🧩 Available Methods](#-available-methods)
    - [Check if the server is online](#check-if-the-server-is-online)
    - [Get server ping](#get-server-ping)
    - [Get server information](#get-server-information)
    - [Get Player List](#get-player-list)
      - [Basic List](#basic-list)
      - [Detailed List](#detailed-list)
    - [Get Server Rules](#get-server-rules)
  - [🔍 Technical Details](#-technical-details)
    - [Retry System](#retry-system)
    - [Configurable Timeouts](#configurable-timeouts)
    - [Packet Construction](#packet-construction)
    - [Data Conversion](#data-conversion)
  - [🔧 Customizations and Configurations](#-customizations-and-configurations)
    - [Advanced Timeout Settings](#advanced-timeout-settings)
    - [Error Messages and Exception Handling](#error-messages-and-exception-handling)
  - [ℹ️ Contact Information](#ℹ️-contact-information)

## 🎯 Features

- Quick and efficient querying of **SA-MP** servers.
- Request basic and detailed server information.
- Ability to retrieve data on players and server rules.
- Automatic retry system to ensure data retrieval.
- Configuration of timeouts for connection and response.
- Automatic socket closure upon completion of the operation.
- Multilingual support for server information.
- Customizable limitation for player display.

## 🛠️ Installation

Clone the repository to your local machine:

```bash
git clone https://github.com/ocalasans/samp-query-php.git
```

## 🚀 Usage

Include the `samp-query.php` file in your project and instantiate the `samp_query` class, passing the IP address and port of the **SA-MP** server you want to query.

### Basic usage example

```php
require 'samp-query.php';

$server = new samp_query('127.0.0.1', 7777);

if ($server->Is_Online()) {
    echo "The server is online!";
    echo "Ping: " . $server->Get_Ping() . " ms";
    
    $info = $server->Get_Information();
    print_r($info);
    
    $players = $server->Get_Players_0();
    print_r($players);
    
    $rules = $server->Get_Rules();
    print_r($rules);
} else {
    echo "The server is offline.";
}
```

### Example with Multiple Servers

```php
require 'samp-query.php';

$servers = [
    ['ip' => '127.0.0.1', 'port' => 7777],
    ['ip' => '192.168.0.1', 'port' => 7778],
];

foreach ($servers as $data) {
    $server = new samp_query($data['ip'], $data['port']);
    
    if ($server->Is_Online()) {
        echo "Server " . $data['ip'] . ":" . $data['port'] . " is online!";
        echo "Ping: " . $server->Get_Ping() . " ms\n";
    } else {
        echo "Server " . $data['ip'] . ":" . $data['port'] . " is offline.\n";
    }
}
```

## 🧩 Available Methods

### Check if the server is online

```php
public function Is_Online()
```

Returns `true` if the server is online; otherwise, `false`. The check is performed by attempting to connect to the server and sending an initial packet. If the connection fails, the server is considered offline.

### Get server ping

```php
public function Get_Ping()
```

Returns the server's ping in milliseconds, calculated based on the time it takes for the packet to be sent and the response to be received. If the server is offline or the ping cannot be obtained, it returns `null`.

### Get server information

```php
public function Get_Information()
```

Returns an array with basic server information, such as:

- `passworded`: Indicates whether the server is password-protected.
- `players`: Current number of players.
- `maxplayers`: Maximum number of players allowed.
- `hostname`: Server name.
- `gamemode`: Server game mode.
- `language`: Language used on the server.

This method uses an automatic retry system to ensure that the data is obtained correctly.

### Get Player List

#### Basic List

```php
public function Get_Players_0()
```

Returns an array with the list of connected players, including `nickname` and `score` for each player. This method is suitable for getting an overview of the connected players.

#### Detailed List

```php
public function Get_Players_1()
```

Returns an array with detailed information about each player, including `playerid`, `nickname`, `score`, and `ping`. This method provides more in-depth data about the connected players.

### Get Server Rules

```php
public function Get_Rules()
```

Returns an array with the server rules, where the key is the rule name and the value is the value associated with that rule. This method also uses a retry system to ensure data retrieval.

## 🔍 Technical Details

### Retry System

The API incorporates a retry system (`retryLimit`) that allows attempts to retrieve information up to three times before giving up. This enhances reliability, especially in situations where the connection may be unstable.

### Configurable Timeouts

When instantiating the `samp_query` class, two types of timeouts are configured:

- `timeouts['connect']`: Defines the maximum time in seconds to establish a connection with the server. The default is 1 second.
- `timeouts['response']`: Defines the maximum time in seconds to wait for a response from the server after sending a packet. The default is 120 seconds, which is already an extremely long time.

These timeouts ensure that the API does not wait indefinitely for a response, improving efficiency.

### Packet Construction

The packets for querying the **SA-MP** server are manually constructed using the prefix `'SAMP'` followed by the server's IP address and port. Depending on the type of information requested (`i`, `c`, `d`, `r`), the corresponding command is added to the packet.

### Data Conversion

The API includes a private method `toInt()` that converts binary data received from the server into integers. This method ensures that the data is handled correctly, even in cases of large values.

```php
private function toInt($data)
```

The method uses bitwise operations to reconstruct the integer value from the binary data, converting the four separated parts of an integer back to the original format.

## 🔧 Customizations and Configurations

### Advanced Timeout Settings

It is possible to customize the timeouts when instantiating the `samp_query` class. For example, to set the maximum connection time to 5 seconds and the response time to 60 seconds:

```php
$server = new samp_query('127.0.0.1', 7777);
$server->setTimeouts([
    'connect' => 5,
    'response' => 60
]);
```

### Error Messages and Exception Handling

The API is designed to capture errors and connection failures, returning clear error messages in case of failures. For instance, if a server cannot be reached, the API returns `null` for methods such as `Get_Information()`, `Get_Players_0`, `Get_Players_1` and `Get_Rules()`.

```php
if ($server->Get_Information() === null) {
    echo "Unable to retrieve server information.";
}
```

## ℹ️ Contact Information

Instagram: [ocalasans](https://instagram.com/ocalasans)   
YouTube: [Calasans](https://www.youtube.com/@ocalasans)   
Discord: [Calasans](https://discord.com/users/793520050832932884)   
Community: [SA-MP Programming Community©](https://abre.ai/samp-spc)

# samp-query-php

**samp-query-php** is a **PHP** **API** developed to query and obtain information from **SA-MP (San Andreas Multiplayer)** servers. This **API** allows you to check if a server is online, get ping, basic and detailed server information, connected players, and server rules. The **API** also includes an automatic retry system to ensure data is obtained reliably.

### Languages

- Português: [README](../../)
- Deutsch: [README](../Deutsch/README.md)
- Español: [README](../Espanol/README.md)
- Français: [README](../Francais/README.md)
- Italiano: [README](../Italiano/README.md)
- Polski: [README](../Polski/README.md)
- Русский: [README](../Русский/README.md)
- Svenska: [README](../Svenska/README.md)
- Türkçe: [README](../Turkce/README.md)

## Table of Contents

- [samp-query-php](#samp-query-php)
    - [Languages](#languages)
  - [Table of Contents](#table-of-contents)
  - [Features](#features)
  - [Installation](#installation)
  - [Usage](#usage)
    - [Basic Usage Example](#basic-usage-example)
    - [Example with Multiple Servers](#example-with-multiple-servers)
  - [Available Methods](#available-methods)
    - [Check if Server is Online](#check-if-server-is-online)
    - [Get Server Ping](#get-server-ping)
    - [Get Server Information](#get-server-information)
    - [Get Player List](#get-player-list)
      - [Basic List](#basic-list)
      - [Detailed List](#detailed-list)
    - [Get Server Rules](#get-server-rules)
  - [Technical Details](#technical-details)
    - [Retry System](#retry-system)
    - [Configurable Timeouts](#configurable-timeouts)
    - [Packet Construction](#packet-construction)
    - [Data Conversion](#data-conversion)
  - [Customizations and Configurations](#customizations-and-configurations)
    - [Advanced Timeout Settings](#advanced-timeout-settings)
    - [Error Messages and Exception Handling](#error-messages-and-exception-handling)
  - [License](#license)
    - [Conditions:](#conditions)

## Features

- Quick and efficient querying of **SA-MP** servers
- Request basic and detailed server information
- Ability to obtain data about players and server rules
- Automatic retry system to ensure data acquisition
- Configuration of connection and response timeouts
- Automatic socket closure upon operation completion
- Multi-language support for server information
- Custom limitation for player display

## Installation

Clone the repository to your local machine:

```bash
git clone https://github.com/ocalasans/samp-query-php.git
```

## Usage

Include the `samp_query.php` file in your project and instantiate the `Samp_Query` class by passing the IP address and port of the **SA-MP** server you want to query.

### Basic Usage Example

```php
require 'samp_query.php';

$server = new Samp_Query('127.0.0.1', 7777);

if ($server->Is_Online()) {
    echo "Server is online!";
    echo "Ping: " . $server->Get_Ping() . " ms";
    
    $info = $server->Get_Information();
    print_r($info);
    
    $players = $server->Get_Players_0();
    print_r($players);
    
    $rules = $server->Get_Rules();
    print_r($rules);
} else {
    echo "Server is offline.";
}
```

### Example with Multiple Servers

```php
require 'samp_query.php';

$servers = [
    ['ip' => '127.0.0.1', 'port' => 7777],
    ['ip' => '192.168.0.1', 'port' => 7778],
];

foreach ($servers as $data) {
    $server = new Samp_Query($data['ip'], $data['port']);
    
    if ($server->Is_Online()) {
        echo "Server " . $data['ip'] . ":" . $data['port'] . " is online!";
        echo "Ping: " . $server->Get_Ping() . " ms\n";
    } else {
        echo "Server " . $data['ip'] . ":" . $data['port'] . " is offline.\n";
    }
}
```

## Available Methods

### Check if Server is Online

```php
public function Is_Online()
```

Returns `true` if the server is online, otherwise `false`. The check is performed by attempting to connect to the server and send an initial packet. If the connection fails, the server is considered offline.

### Get Server Ping

```php
public function Get_Ping()
```

Returns the server ping in milliseconds, calculated based on the time it takes for the packet to be sent and the response to be received. If the server is offline or unable to get the ping, returns `null`.

### Get Server Information

```php
public function Get_Information()
```

Returns an array with basic server information, such as:

- `passworded`: Indicates if the server is password protected
- `players`: Current number of players
- `maxplayers`: Maximum number of players allowed
- `hostname`: Server name
- `gamemode`: Server game mode
- `language`: Language used on the server

This method uses the automatic retry system to ensure data is obtained correctly.

### Get Player List

#### Basic List

```php
public function Get_Players_0()
```

Returns an array with the list of connected players, containing `nickname` and `score` for each player. This method is suitable for getting an overview of connected players.

#### Detailed List

```php
public function Get_Players_1()
```

Returns an array with detailed information about each player, including `playerid`, `nickname`, `score`, and `ping`. This method provides deeper data about connected players.

### Get Server Rules

```php
public function Get_Rules()
```

Returns an array with server rules, where the key is the rule name and the value is the value associated with that rule. This method also uses the retry system to ensure data acquisition.

## Technical Details

### Retry System

The API incorporates a retry system (`retry_limit`) that allows attempting to obtain information up to three times before giving up. This increases reliability, especially in situations where the connection might be unstable.

### Configurable Timeouts

When instantiating the `Samp_Query` class, two types of timeouts are configured:

- `timeouts['connect']`: Sets the maximum time in seconds to establish a connection with the server. Default is 1 second.
- `timeouts['response']`: Sets the maximum time in seconds to wait for a server response after sending a packet. Default is 120 seconds, which is already an extremely high time.

These timeouts ensure that the API doesn't indefinitely wait for a response, improving efficiency.

### Packet Construction

The **SA-MP** server query packets are constructed manually, using the prefix `'SAMP'` followed by the server's IP address and port. Depending on the type of information requested (`i`, `c`, `d`, `r`), the corresponding command is added to the packet.

### Data Conversion

The API includes a private `To_Int()` method that converts binary data received from the server to integers. This method ensures that data is handled correctly, even in cases of large values.

```php
private function To_Int($data)
```

The method uses bitwise operations to reconstruct the integer value from binary data, converting the four separate parts of an integer number to the original format.

## Customizations and Configurations

### Advanced Timeout Settings

It's possible to customize timeouts when instantiating the `Samp_Query` class. For example, to set the maximum connection time to 5 seconds and response time to 60 seconds:

```php
$server = new Samp_Query('127.0.0.1', 7777);
$server->setTimeouts([
    'connect' => 5,
    'response' => 60
]);
```

### Error Messages and Exception Handling

The API is designed to capture errors and connection failures, returning clear error messages in case of failures. For example, if a server cannot be reached, the API returns `null` for methods like `Get_Information()` and `Get_Rules()`.

```php
if ($server->Get_Information() === null) {
    echo "Unable to get server information.";
}
```

## License

This API is protected under the MIT License, which allows:
- ✔️ Commercial and private use
- ✔️ Source code modification
- ✔️ Code distribution
- ✔️ Sublicensing

### Conditions:

- Maintain copyright notice
- Include copy of MIT license

For more details about the license: https://opensource.org/licenses/MIT

**Copyright (c) Calasans - All rights reserved**
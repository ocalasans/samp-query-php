# SA-MP Query PHP

**samp-query-php** — это **API** на **PHP**, разработанная для запроса и получения информации о серверах **SA-MP (San Andreas Multiplayer)**. Эта **API** позволяет вам проверять, работает ли сервер, получать пинг, основные и детализированные сведения о сервере, подключенных игроках и правилах сервера. **API** также включает систему автоматических попыток для обеспечения надежности получения данных.

### Языки

- **Português** > [README](https://github.com/ocalasans/samp-query-php) / [Código](https://github.com/ocalasans/samp-query-php/blob/main/samp-query.php).
- **English** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/English) / [Code](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/English/samp-query.php).
- **Español** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Espanol) / [Código](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Espanol/samp-query.php).
- **Polski** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Polski) / [Kod](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Polski/samp-query.php).
- **Türk** > [README](https://github.com/ocalasans/samp-query-php/blob/Other%20Languages/Turk) / [Kod](https://github.com/ocalasans/samp-query-php/blob/Other%20Languages/Turk/samp-query.php).
- **Deutsch** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Deutsch) / [Code](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Deutsch/samp-query.php).
- **Français** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Francais) / [Code](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Francais/samp-query.php).
- **Italiano** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Italiano) / [Codice](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Italiano/samp-query.php).
- **Svensk** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Svensk) / [Koda](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Svensk/samp-query.php).

## индекс
- [SA-MP Query PHP](#sa-mp-query-php)
    - [Языки](#языки)
  - [Содержание](#содержание)
  - [Характеристики](#характеристики)
  - [Установка](#️установка)
  - [Использование](#использование)
    - [Пример базового использования](#пример-базового-использования)
    - [Пример с несколькими серверами](#пример-с-несколькими-серверами)
  - [Доступные методы](#доступные-методы)
    - [Проверить, онлайн ли сервер](#проверить-онлайн-ли-сервер)
    - [Получить пинг сервера](#получить-пинг-сервера)
    - [Получить информацию о сервере](#получить-информацию-о-сервере)
    - [Получить список игроков](#получить-список-игроков)
      - [Основной список](#основной-список)
      - [Подробный список](#подробный-список)
    - [Получить правила сервера](#получить-правила-сервера)
  - [Технические детали](#технические-детали)
    - [Система попыток](#система-попыток)
    - [Настраиваемые тайм-ауты](#настраиваемые-тайм-ауты)
    - [Формирование пакетов](#формирование-пакетов)
    - [Преобразование данных](#преобразование-данных)
  - [Настройки и Конфигурации](#настройки-и-конфигурации)
    - [Расширенные настройки тайм-аутов](#расширенные-настройки-тайм-аутов)
    - [Сообщения об ошибках и обработка исключений](#сообщения-об-ошибках-и-обработка-исключений)
  - [Контактная информация](#контактная-информация)

## Характеристики

- Быстрый и эффективный запрос серверов **SA-MP**.
- Запрос базовой и детальной информации о сервере.
- Возможность получения данных о игроках и правилах сервера.
- Автоматическая система попыток для обеспечения получения данных.
- Настройка таймаутов для подключения и ответа.
- Автоматическое закрытие сокета по завершении операции.
- Поддержка нескольких языков для информации о сервере.
- Индивидуальное ограничение для отображения игроков.

## Установка

Клонируйте репозиторий на вашу локальную машину:

```bash
git clone https://github.com/ocalasans/samp-query-php.git
```

## Использование

Включите файл `samp-query.php` в ваш проект и создайте экземпляр класса `samp_query`, передав IP-адрес и порт сервера **SA-MP**, который вы хотите запросить.

### Пример базового использования

```php
require 'samp-query.php';

$server = new samp_query('127.0.0.1', 7777);

if ($server->Onlain()) {
    echo "Сервер онлайн!";
    echo "Ping: " . $server->Poluchit_Ping() . " ms";
    
    $info = $server->Poluchit_Informaciyu();
    print_r($info);
    
    $igrokov = $server->Poluchit_Igrokov_0();
    print_r($igrokov);
    
    $pravila = $server->Poluchit_Pravila();
    print_r($pravila);
} else {
    echo "Сервер офлайн.";
}
```

### Пример с несколькими серверами

```php
require 'samp-query.php';

$servery = [
    ['ip' => '127.0.0.1', 'дверь' => 7777],
    ['ip' => '192.168.0.1', 'дверь' => 7778],
];

foreach ($servery as $dannyye) {
    $server = new samp_query($dannyye['ip'], $dannyye['дверь']);
    
    if ($server->Onlain()) {
        echo "Сервер " . $dannyye['ip'] . ":" . $dannyye['дверь'] . " онлайн!";
        echo "Ping: " . $server->Poluchit_Ping() . " ms\n";
    } else {
        echo "Сервер " . $dannyye['ip'] . ":" . $dannyye['дверь'] . " офлайн.\n";
    }
}
```

## Доступные методы

### Проверить, онлайн ли сервер

```php
public function Onlain()
```

Возвращает `true`, если сервер онлайн, в противном случае — `false`. Проверка выполняется попыткой подключения к серверу и отправкой начального пакета. Если подключение не удается, сервер считается оффлайн.

### Получить пинг сервера

```php
public function Poluchit_Ping()
```

Возвращает пинг сервера в миллисекундах, вычисленный на основе времени, которое требуется для отправки пакета и получения ответа. Если сервер оффлайн или не удается получить пинг, возвращает `null`.

### Получить информацию о сервере

```php
public function Poluchit_Informaciyu()
```

Возвращает массив с основной информацией о сервере, такой как:

- `passworded`: Указывает, защищен ли сервер паролем.
- `players`: Текущее количество игроков.
- `maxplayers`: Максимальное количество игроков, разрешенное на сервере.
- `hostname`: Имя сервера.
- `gamemode`: Режим игры на сервере.
- `language`: Язык, используемый на сервере.

Этот метод использует систему автоматических попыток для обеспечения корректного получения данных.

### Получить список игроков

#### Основной список

```php
public function Poluchit_Igrokov_0()
```

Возвращает массив со списком подключенных игроков, содержащий `nickname` и `score` (оценка) каждого игрока. Этот метод подходит для получения общего представления о подключенных игроках.

#### Подробный список

```php
public function Poluchit_Igrokov_1()
```

Возвращает массив с детальной информацией о каждом игроке, включая `playerid`, `nickname`, `score` и `ping`. Этот метод предоставляет более глубокие данные о подключенных игроках.

### Получить правила сервера

```php
public function Poluchit_Pravila()
```

Возвращает массив с правилами сервера, где ключ — это название правила, а значение — это значение, соответствующее этому правилу. Этот метод также использует систему попыток для обеспечения получения данных.

## Технические детали

### Система попыток

API включает систему попыток (`retryLimit`), которая позволяет пытаться получить информацию до трех раз, прежде чем сдаваться. Это повышает надежность, особенно в ситуациях, когда соединение может быть нестабильным.

### Настраиваемые тайм-ауты

При создании экземпляра класса `samp_query` настраиваются два типа тайм-аутов:

- `timeouts['connect']`: Определяет максимальное время в секундах для установления соединения с сервером. По умолчанию 1 секунда.
- `timeouts['response']`: Определяет максимальное время в секундах для ожидания ответа от сервера после отправки пакета. По умолчанию 120 секунд, что уже является очень большим значением.

Эти тайм-ауты гарантируют, что API не будет бесконечно ожидать ответа, что улучшает эффективность.

### Формирование пакетов

Пакеты запросов к серверу **SA-MP** формируются вручную, используя префикс `'SAMP'`, за которым следует IP-адрес сервера и порт. В зависимости от типа запрашиваемой информации (`i`, `c`, `d`, `r`), соответствующая команда добавляется в пакет.

### Преобразование данных

API включает приватный метод `toInt()`, который преобразует бинарные данные, полученные от сервера, в целые числа. Этот метод гарантирует, что данные обрабатываются корректно, даже в случае больших значений.

```php
private function toInt($data)
```

Метод использует побитовые операции для восстановления целого значения из бинарных данных, конвертируя четыре разделенные части целого числа обратно в оригинальный формат.

## Настройки и Конфигурации

### Расширенные настройки тайм-аутов

Возможно настроить тайм-ауты при создании экземпляра класса `samp_query`. Например, чтобы установить максимальное время подключения на 5 секунд и время ожидания ответа на 60 секунд:

```php
$server = new samp_query('127.0.0.1', 7777);
$server->setTimeouts([
    'connect' => 5,
    'response' => 60
]);
```

### Сообщения об ошибках и обработка исключений

API разработана для захвата ошибок и сбоев соединения, возвращая четкие сообщения об ошибках в случае сбоев. Например, если сервер не может быть достигнут, API возвращает `null` для методов, таких как `Poluchit_Informaciyu()`, `Poluchit_Igrokov_0`, `Poluchit_Igrokov_1` и `Poluchit_Pravila()`.

```php
if ($server->Poluchit_Informaciyu() === null) {
    echo "Не удалось получить информацию от сервера.";
}
```

## Контактная информация

Instagram: [ocalasans](https://instagram.com/ocalasans)   
YouTube: [Calasans](https://www.youtube.com/@ocalasans)   
Discord: [Calasans](https://discord.com/users/793520050832932884)   
Сообщество: [SA-MP Programming Community](https://abre.ai/samp-spc)

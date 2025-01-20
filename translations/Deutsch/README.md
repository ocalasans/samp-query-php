# samp-query-php

**samp-query-php** ist eine in **PHP** entwickelte **API** zum Abfragen und Abrufen von Informationen von **SA-MP (San Andreas Multiplayer)**-Servern. Diese **API** ermöglicht es Ihnen zu überprüfen, ob ein Server online ist, den Ping zu ermitteln sowie grundlegende und detaillierte Informationen über den Server, verbundene Spieler und Server-Regeln abzurufen. Die **API** enthält auch ein automatisches Wiederholungssystem, um sicherzustellen, dass die Daten zuverlässig abgerufen werden.

### Sprachen

- Português: [README](../../)
- English: [README](../English/README.md)
- Español: [README](../Espanol/README.md)
- Français: [README](../Francais/README.md)
- Italiano: [README](../Italiano/README.md)
- Polski: [README](../Polski/README.md)
- Русский: [README](../Русский/README.md)
- Svenska: [README](../Svenska/README.md)
- Türkçe: [README](../Turkce/README.md)

## Inhaltsverzeichnis

- [samp-query-php](#samp-query-php)
    - [Sprachen](#sprachen)
  - [Inhaltsverzeichnis](#inhaltsverzeichnis)
  - [Eigenschaften](#eigenschaften)
  - [Installation](#installation)
  - [Verwendung](#verwendung)
    - [Grundlegendes Beispiel](#grundlegendes-beispiel)
    - [Beispiel mit mehreren Servern](#beispiel-mit-mehreren-servern)
  - [Verfügbare Methoden](#verfügbare-methoden)
    - [Überprüfen, ob der Server online ist](#überprüfen-ob-der-server-online-ist)
    - [Server-Ping abrufen](#server-ping-abrufen)
    - [Server-Informationen abrufen](#server-informationen-abrufen)
    - [Spielerliste abrufen](#spielerliste-abrufen)
      - [Grundlegende Liste](#grundlegende-liste)
      - [Detaillierte Liste](#detaillierte-liste)
    - [Server-Regeln abrufen](#server-regeln-abrufen)
  - [Technische Details](#technische-details)
    - [Wiederholungssystem](#wiederholungssystem)
    - [Konfigurierbare Timeouts](#konfigurierbare-timeouts)
    - [Paket-Erstellung](#paket-erstellung)
    - [Datenkonvertierung](#datenkonvertierung)
  - [Anpassungen und Konfigurationen](#anpassungen-und-konfigurationen)
    - [Erweiterte Timeout-Einstellungen](#erweiterte-timeout-einstellungen)
    - [Fehlermeldungen und Ausnahmebehandlung](#fehlermeldungen-und-ausnahmebehandlung)
  - [Lizenz](#lizenz)
    - [Bedingungen:](#bedingungen)

## Eigenschaften

- Schnelle und effiziente Abfrage von **SA-MP**-Servern
- Abruf von grundlegenden und detaillierten Server-Informationen
- Möglichkeit zum Abrufen von Spieler- und Server-Regeln
- Automatisches Wiederholungssystem zur Sicherstellung der Datenabrufung
- Konfiguration von Verbindungs- und Antwortzeitüberschreitungen
- Automatische Socket-Schließung nach Beendigung der Operation
- Mehrsprachige Unterstützung für Server-Informationen
- Anpassbare Begrenzung für die Spieleranzeige

## Installation

Klonen Sie das Repository auf Ihren lokalen Computer:

```bash
git clone https://github.com/ocalasans/samp-query-php.git
```

## Verwendung

Fügen Sie die Datei `samp_query.php` in Ihr Projekt ein und instanziieren Sie die Klasse `Samp_Query`, indem Sie die IP-Adresse und den Port des **SA-MP**-Servers übergeben, den Sie abfragen möchten.

### Grundlegendes Beispiel

```php
require 'samp_query.php';

$server = new Samp_Query('127.0.0.1', 7777);

if ($server->Is_Online()) {
    echo "Server ist online!";
    echo "Ping: " . $server->Get_Ping() . " ms";
    
    $info = $server->Get_Information();
    print_r($info);
    
    $players = $server->Get_Players_0();
    print_r($players);
    
    $rules = $server->Get_Rules();
    print_r($rules);
} else {
    echo "Server ist offline.";
}
```

### Beispiel mit mehreren Servern

```php
require 'samp_query.php';

$servers = [
    ['ip' => '127.0.0.1', 'port' => 7777],
    ['ip' => '192.168.0.1', 'port' => 7778],
];

foreach ($servers as $data) {
    $server = new Samp_Query($data['ip'], $data['port']);
    
    if ($server->Is_Online()) {
        echo "Server " . $data['ip'] . ":" . $data['port'] . " ist online!";
        echo "Ping: " . $server->Get_Ping() . " ms\n";
    } else {
        echo "Server " . $data['ip'] . ":" . $data['port'] . " ist offline.\n";
    }
}
```

## Verfügbare Methoden

### Überprüfen, ob der Server online ist

```php
public function Is_Online()
```

Gibt `true` zurück, wenn der Server online ist, andernfalls `false`. Die Überprüfung erfolgt durch den Versuch, eine Verbindung zum Server herzustellen und ein initiales Paket zu senden. Wenn die Verbindung fehlschlägt, wird der Server als offline betrachtet.

### Server-Ping abrufen

```php
public function Get_Ping()
```

Gibt den Server-Ping in Millisekunden zurück, berechnet auf Basis der Zeit, die für das Senden des Pakets und den Erhalt der Antwort benötigt wird. Wenn der Server offline ist oder der Ping nicht ermittelt werden kann, wird `null` zurückgegeben.

### Server-Informationen abrufen

```php
public function Get_Information()
```

Gibt ein Array mit grundlegenden Server-Informationen zurück, wie:

- `passworded`: Gibt an, ob der Server passwortgeschützt ist
- `players`: Aktuelle Anzahl der Spieler
- `maxplayers`: Maximal erlaubte Anzahl der Spieler
- `hostname`: Name des Servers
- `gamemode`: Spielmodus des Servers
- `language`: Auf dem Server verwendete Sprache

Diese Methode nutzt das automatische Wiederholungssystem, um sicherzustellen, dass die Daten korrekt abgerufen werden.

### Spielerliste abrufen

#### Grundlegende Liste

```php
public function Get_Players_0()
```

Gibt ein Array mit der Liste der verbundenen Spieler zurück, das `nickname` und `score` (Punktzahl) jedes Spielers enthält. Diese Methode eignet sich für einen Überblick über die verbundenen Spieler.

#### Detaillierte Liste

```php
public function Get_Players_1()
```

Gibt ein Array mit detaillierten Informationen über jeden Spieler zurück, einschließlich `playerid`, `nickname`, `score` und `ping`. Diese Methode liefert tiefergehende Daten über die verbundenen Spieler.

### Server-Regeln abrufen

```php
public function Get_Rules()
```

Gibt ein Array mit den Server-Regeln zurück, wobei der Schlüssel der Name der Regel und der Wert der mit dieser Regel verbundene Wert ist. Diese Methode verwendet ebenfalls das Wiederholungssystem, um den Datenabruf sicherzustellen.

## Technische Details

### Wiederholungssystem

Die API enthält ein Wiederholungssystem (`retry_limit`), das es ermöglicht, bis zu drei Versuche zum Abrufen von Informationen durchzuführen, bevor aufgegeben wird. Dies erhöht die Zuverlässigkeit, besonders in Situationen mit instabiler Verbindung.

### Konfigurierbare Timeouts

Bei der Instanziierung der `Samp_Query`-Klasse werden zwei Arten von Timeouts konfiguriert:

- `timeouts['connect']`: Legt die maximale Zeit in Sekunden für den Aufbau einer Verbindung zum Server fest. Standard ist 1 Sekunde.
- `timeouts['response']`: Legt die maximale Zeit in Sekunden fest, die auf eine Serverantwort nach dem Senden eines Pakets gewartet wird. Standard ist 120 Sekunden, was bereits eine extrem hohe Zeit ist.

Diese Timeouts stellen sicher, dass die API nicht unbegrenzt auf eine Antwort wartet und verbessern die Effizienz.

### Paket-Erstellung

Die Abfragepakete für den **SA-MP**-Server werden manuell erstellt, beginnend mit dem Präfix `'SAMP'`, gefolgt von der Server-IP-Adresse und dem Port. Je nach Art der angeforderten Information (`i`, `c`, `d`, `r`) wird der entsprechende Befehl dem Paket hinzugefügt.

### Datenkonvertierung

Die API enthält eine private Methode `To_Int()`, die binäre Daten vom Server in Ganzzahlen konvertiert. Diese Methode stellt sicher, dass die Daten korrekt verarbeitet werden, auch bei großen Werten.

```php
private function To_Int($data)
```

Die Methode verwendet Bit-Operationen, um den Ganzzahlwert aus den binären Daten zu rekonstruieren, indem sie die vier getrennten Teile einer Ganzzahl in das ursprüngliche Format konvertiert.

## Anpassungen und Konfigurationen

### Erweiterte Timeout-Einstellungen

Es ist möglich, die Timeouts bei der Instanziierung der `Samp_Query`-Klasse anzupassen. Zum Beispiel, um die maximale Verbindungszeit auf 5 Sekunden und die Antwortzeit auf 60 Sekunden festzulegen:

```php
$server = new Samp_Query('127.0.0.1', 7777);
$server->setTimeouts([
    'connect' => 5,
    'response' => 60
]);
```

### Fehlermeldungen und Ausnahmebehandlung

Die API ist darauf ausgelegt, Fehler und Verbindungsfehler abzufangen und im Fehlerfall klare Fehlermeldungen zurückzugeben. Wenn beispielsweise ein Server nicht erreicht werden kann, gibt die API `null` für Methoden wie `Get_Information()` und `Get_Rules()` zurück.

```php
if ($server->Get_Information() === null) {
    echo "Server-Informationen konnten nicht abgerufen werden.";
}
```

## Lizenz

Diese API steht unter der MIT-Lizenz, die Folgendes erlaubt:
- ✔️ Kommerzielle und private Nutzung
- ✔️ Modifikation des Quellcodes
- ✔️ Verteilung des Codes
- ✔️ Unterlizenzierung

### Bedingungen:

- Beibehaltung des Copyright-Hinweises
- Einbindung einer Kopie der MIT-Lizenz

Weitere Details zur Lizenz: https://opensource.org/licenses/MIT

**Copyright (c) Calasans - Alle Rechte vorbehalten**
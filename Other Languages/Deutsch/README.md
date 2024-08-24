# samp-query-php

**samp-query-php** ist eine **PHP-API**, die entwickelt wurde, um Informationen von **SA-MP (San Andreas Multiplayer)**-Servern abzufragen und zu erhalten. Diese **API** ermöglicht es Ihnen, zu überprüfen, ob ein Server online ist, den Ping sowie grundlegende und detaillierte Informationen über den Server, verbundene Spieler und Serverregeln zu erhalten. Die **API** enthält auch ein automatisches Wiederholungssystem, um sicherzustellen, dass die Daten zuverlässig abgerufen werden.

### 🌐 Sprachen

- **Português** > [README](https://github.com/ocalasans/samp-query-php) / [Código](https://github.com/ocalasans/samp-query-php/blob/main/samp-query.php).
- **English** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/English) / [Code](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/English/samp-query.php).
- **Español** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Espanol) / [Código](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Espanol/samp-query.php).
- **Polski** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Polskid) / [Kod](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Polski/samp-query.php).
- **Türk** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Turk) / [Kod](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Turk/samp-query.php).
- **Русский** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Русский) / [Код](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Русский/samp-query.php).
- **Français** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Francais) / [Code](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Francais/samp-query.php).
- **Italiano** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Italiano) / [Codice](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Italiano/samp-query.php).
- **Svensk** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Svensk) / [Koda](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Svensk/samp-query.php).

## 📋 Inhaltsverzeichnis

- [samp-query-php](#samp-query-php)
    - [🌐 Sprachen](#-sprachen)
  - [📋 Inhaltsverzeichnis](#-inhaltsverzeichnis)
  - [🎯 Eigenschaften](#-eigenschaften)
  - [🛠️ Installation](#️-installation)
  - [🚀 Verwendung](#-verwendung)
    - [Beispiel für die grundlegende Verwendung](#beispiel-für-die-grundlegende-verwendung)
    - [Beispiel mit mehreren Servern](#beispiel-mit-mehreren-servern)
  - [🧩 Verfügbare Methoden](#-verfügbare-methoden)
    - [Überprüfen, ob der Server online ist](#überprüfen-ob-der-server-online-ist)
    - [Ping des Servers abrufen](#ping-des-servers-abrufen)
    - [Serverinformationen abrufen](#serverinformationen-abrufen)
    - [Spieler-Liste abrufen](#spieler-liste-abrufen)
      - [Grundlegende Liste](#grundlegende-liste)
      - [Detaillierte Liste](#detaillierte-liste)
    - [Serverregeln abrufen](#serverregeln-abrufen)
- [🔍 Technische Details](#-technische-details)
    - [Versuchssystem](#versuchssystem)
    - [Konfigurierbare Timeouts](#konfigurierbare-timeouts)
    - [Paketkonstruktion](#paketkonstruktion)
    - [Datenkonvertierung](#datenkonvertierung)
  - [🔧 Anpassungen und Konfigurationen](#-anpassungen-und-konfigurationen)
    - [Erweiterte Timeout-Einstellungen](#erweiterte-timeout-einstellungen)
    - [Fehlermeldungen und Ausnahmebehandlung](#fehlermeldungen-und-ausnahmebehandlung)
  - [ℹ️ Kontaktinformationen](#ℹ️-kontaktinformationen)

## 🎯 Eigenschaften

- Schnelle und effiziente Abfrage von **SA-MP**-Servern.
- Abruf von grundlegenden und detaillierten Informationen des Servers.
- Möglichkeit, Daten über Spieler und Serverregeln zu erhalten.
- Automatisches Versuchssystem, um die Datenerfassung sicherzustellen.
- Konfiguration von Timeouts für Verbindung und Antwort.
- Automatisches Schließen des Sockets nach Abschluss des Vorgangs.
- Unterstützung für mehrere Sprachen bei den Serverinformationen.
- Benutzerdefinierte Begrenzung für die Anzeige von Spielern.

## 🛠️ Installation

Klonen Sie das Repository auf Ihren lokalen Rechner:

```bash
git clone https://github.com/ocalasans/samp-query-php.git
```

## 🚀 Verwendung

Fügen Sie die Datei `samp_query.php` in Ihr Projekt ein und erstellen Sie eine Instanz der Klasse `samp_query`, indem Sie die IP-Adresse und den Port des **SA-MP**-Servers übergeben, den Sie abfragen möchten.

### Beispiel für die grundlegende Verwendung

```php
require 'samp_query.php';

$server = new samp_query('127.0.0.1', 7777);

if ($server->Ist_Online()) {
    echo "Der Server ist online!";
    echo "Ping: " . $server->Abfragen_Ping() . " ms";
    
    $info = $server->Abfragen_Informationen();
    print_r($info);
    
    $spieler = $server->Abfragen_Spieler_0();
    print_r($spieler);
    
    $regeln = $server->Abfragen_Regeln();
    print_r($regeln);
} else {
    echo "Server ist offline.";
}
```

### Beispiel mit mehreren Servern

```php
require 'samp_query.php';

$server_0 = [
    ['ip' => '127.0.0.1', 'tur' => 7777],
    ['ip' => '192.168.0.1', 'tur' => 7778],
];

foreach ($server_0 as $daten) {
    $server = new samp_query($daten['ip'], $daten['tur']);
    
    if ($server->Esta_Online()) {
        echo "Server " . $daten['ip'] . ":" . $daten['tur'] . " ist online!";
        echo "Ping: " . $server->Abfragen_Ping() . " ms\n";
    } else {
        echo "Server " . $daten['ip'] . ":" . $daten['tur'] . " ist offline\n";
    }
}
```

## 🧩 Verfügbare Methoden

### Überprüfen, ob der Server online ist

```php
public function Ist_Online()
```

Gibt `true` zurück, wenn der Server online ist, andernfalls `false`. Die Überprüfung erfolgt durch den Versuch, eine Verbindung zum Server herzustellen und ein Anfangspaket zu senden. Wenn die Verbindung fehlschlägt, wird der Server als offline betrachtet.

### Ping des Servers abrufen

```php
public function Abfragen_Ping()
```

Gibt den Ping des Servers in Millisekunden zurück, berechnet basierend auf der Zeit, die benötigt wird, um das Paket zu senden und die Antwort zu erhalten. Wenn der Server offline ist oder der Ping nicht abgerufen werden kann, gibt es `null` zurück.

### Serverinformationen abrufen

```php
public function Abfragen_Informationen()
```

Gibt ein Array mit grundlegenden Informationen zum Server zurück, wie:

- `passworded`: Gibt an, ob der Server durch ein Passwort geschützt ist.
- `players`: Aktuelle Anzahl der Spieler.
- `maxplayers`: Maximale Anzahl der erlaubten Spieler.
- `hostname`: Name des Servers.
- `gamemode`: Spielmodus des Servers.
- `language`: Auf dem Server verwendete Sprache.

Diese Methode nutzt das automatische Versuchssystem, um sicherzustellen, dass die Daten korrekt abgerufen werden.

### Spieler-Liste abrufen

#### Grundlegende Liste

```php
public function Abfragen_Spieler_0()
```

Gibt ein Array mit der Liste der verbundenen Spieler zurück, das `nickname` und `score` (Punktzahl) jedes Spielers enthält. Diese Methode ist geeignet, um einen Überblick über die verbundenen Spieler zu erhalten.

#### Detaillierte Liste

```php
public function Abfragen_Spieler_1()
```

Gibt ein Array mit detaillierten Informationen zu jedem Spieler zurück, einschließlich `playerid`, `nickname`, `score` und `ping`. Diese Methode liefert tiefere Daten über die verbundenen Spieler.

### Serverregeln abrufen

```php
public function Abfragen_Regeln()
```

Gibt ein Array mit den Serverregeln zurück, wobei der Schlüssel der Name der Regel und der Wert der mit dieser Regel verbundene Wert ist. Diese Methode verwendet ebenfalls das Versuchssystem, um die Datenbeschaffung sicherzustellen.

# 🔍 Technische Details

### Versuchssystem

Die API integriert ein Versuchssystem (`retryLimit`), das es ermöglicht, bis zu drei Mal zu versuchen, Informationen abzurufen, bevor sie aufgibt. Dies erhöht die Zuverlässigkeit, insbesondere in Situationen, in denen die Verbindung instabil sein kann.

### Konfigurierbare Timeouts

Beim Erstellen der Klasse `samp_query` werden zwei Arten von Timeouts konfiguriert:

- `timeouts['connect']`: Legt die maximale Zeit in Sekunden fest, um eine Verbindung zum Server herzustellen. Der Standardwert beträgt 1 Sekunde.
- `timeouts['response']`: Legt die maximale Zeit in Sekunden fest, um auf eine Antwort des Servers nach dem Senden eines Pakets zu warten. Der Standardwert beträgt 120 Sekunden, was bereits eine extrem hohe Zeit ist.

Diese Timeouts stellen sicher, dass die API nicht unbegrenzt auf eine Antwort wartet und verbessern so die Effizienz.

### Paketkonstruktion

Die Abfragepakete an den **SA-MP**-Server werden manuell erstellt, indem das Präfix `'SAMP'` gefolgt von der IP-Adresse des Servers und dem Port verwendet wird. Abhängig von der Art der angeforderten Information (`i`, `c`, `d`, `r`) wird der entsprechende Befehl zum Paket hinzugefügt.

### Datenkonvertierung

Die API umfasst eine private Methode `toInt()`, die binäre Daten, die vom Server empfangen wurden, in Ganzzahlen umwandelt. Diese Methode stellt sicher, dass die Daten korrekt verarbeitet werden, selbst bei großen Werten.

```php
private function toInt($data)
```

Die Methode verwendet Bit-Operationen, um den Ganzwert aus den binären Daten wiederherzustellen, indem die vier getrennten Teile einer Ganzzahl in das ursprüngliche Format konvertiert werden.

## 🔧 Anpassungen und Konfigurationen

### Erweiterte Timeout-Einstellungen

Es ist möglich, die Timeouts beim Erstellen der Klasse `samp_query` anzupassen. Zum Beispiel, um die maximale Verbindungszeit auf 5 Sekunden und die Antwortzeit auf 60 Sekunden festzulegen:

```php
$server = new samp_query('127.0.0.1', 7777);
$server->setTimeouts([
    'connect' => 5,
    'response' => 60
]);
```

### Fehlermeldungen und Ausnahmebehandlung

Die API ist so gestaltet, dass sie Fehler und Verbindungsprobleme erfasst und im Falle von Fehlern klare Fehlermeldungen zurückgibt. Wenn beispielsweise ein Server nicht erreicht werden kann, gibt die API `null` für Methoden wie `Abfragen_Informationen()`, `Abfragen_Spieler_0`, `Abfragen_Spieler_1` und `Abfragen_Regeln()` zurück.

```php
if ($server->Abfragen_Informationen() === null) {
    echo "Es konnte keine Informationen vom Server abgerufen werden.";
}
```

## ℹ️ Kontaktinformationen

Instagram: [ocalasans](https://instagram.com/ocalasans)   
YouTube: [Calasans](https://www.youtube.com/@ocalasans)   
Discord: [Calasans](https://discord.com/users/793520050832932884)   
Gemeinschaft: [SA-MP Programming Community©](https://abre.ai/samp-spc)

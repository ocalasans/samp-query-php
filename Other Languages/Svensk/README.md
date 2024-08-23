# samp-query-php

**samp-query-php** är en **API** i **PHP** utvecklad för att fråga och hämta information från **SA-MP (San Andreas Multiplayer)** servrar. Denna **API** gör det möjligt att kontrollera om en server är online, få ping, grundläggande och detaljerad information om servern, anslutna spelare och serverregler. **API**:n inkluderar också ett automatiskt försöksystem för att säkerställa att data hämtas på ett tillförlitligt sätt.

### 🌐 Språk

- **Português** > [README](https://github.com/ocalasans/samp-query-php) / [Código](https://github.com/ocalasans/samp-query-php/blob/main/samp-query.php).
- **English** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/English) / [Code](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/English/samp-query.php).
- **Español** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Espanol) / [Código](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Espanol/samp-query.php).
- **Polski** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Polski) / [Kod](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Polski/samp-query.php).
- **Türk** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Turk) / [Kod](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Turk/samp-query.php).
- **Deutsch** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Deutsch) / [Code](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Deutsch/samp-query.php).
- **Русский** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Русский) / [Код](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Русский/samp-query.php).
- **Français** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Francais) / [Code](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Francais/samp-query.php).
- **Italiano** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Italiano) / [Codice](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Italiano/samp-query.php).

## 📋 Sammanfattning
- [samp-query-php](#samp-query-php)
    - [🌐 Språk](#-språk)
  - [📋 Sammanfattning](#-sammanfattning)
  - [🎯 Funktioner](#-funktioner)
  - [🛠️ Installation](#️-installation)
  - [🚀 Användning](#-användning)
    - [Enkel användningsexempel](#enkel-användningsexempel)
    - [Exempel med flera servrar](#exempel-med-flera-servrar)
  - [🧩 Tillgängliga Metoder](#-tillgängliga-metoder)
    - [Kontrollera om servern är online](#kontrollera-om-servern-är-online)
    - [Hämta serverns ping](#hämta-serverns-ping)
    - [Hämta serverinformation](#hämta-serverinformation)
    - [Hämta spelarlista](#hämta-spelarlista)
      - [Grundläggande Lista](#grundläggande-lista)
      - [Detaljerad Lista](#detaljerad-lista)
    - [Hämta serverregler](#hämta-serverregler)
  - [🔍 Tekniska Detaljer](#-tekniska-detaljer)
    - [Återförsökssystem](#återförsökssystem)
    - [Konfigurerbara timeoutar](#konfigurerbara-timeoutar)
    - [Paketbyggande](#paketbyggande)
    - [Datakonvertering](#datakonvertering)
  - [🔧 Anpassningar och Inställningar](#-anpassningar-och-inställningar)
    - [Avancerade timeoutinställningar](#avancerade-timeoutinställningar)
    - [Felmeddelanden och undantagshantering](#felmeddelanden-och-undantagshantering)
  - [ℹ️ Kontaktinformation](#ℹ️-kontaktinformation)

## 🎯 Funktioner

- Snabb och effektiv förfrågning av **SA-MP**-servrar.
- Begäran av grundläggande och detaljerad serverinformation.
- Möjlighet att hämta data om spelare och serverregler.
- Automatiskt retriesystem för att säkerställa att data hämtas.
- Timeout-konfiguration för anslutning och svar.
- Automatisk stängning av socket när operationen är klar.
- Stöd för flera språk för serverinformation.
- Anpassad begränsning för visning av spelare.

## 🛠️ Installation

Klon repositoryt till din lokala maskin:

```bash
git clone https://github.com/ocalasans/samp-query-php.git
```

## 🚀 Användning

Inkludera filen `samp_query.php` i ditt projekt och instansiera klassen `samp_query` genom att ange IP-adressen och porten för **SA-MP**-servern du vill fråga.

### Enkel användningsexempel

```php
require 'samp_query.php';

$server = new samp_query('127.0.0.1', 7777);

if ($server->Ar_Online()) {
    echo "Servern är online!";
    echo "Ping: " . $server->Hamta_Ping() . " ms";
    
    $info = $server->Hamta_Information();
    print_r($info);
    
    $spelare = $server->Hamta_Spelare_0();
    print_r($spelare);
    
    $regler = $server->Hamta_Regler();
    print_r($regler);
} else {
    echo "Servern är offline.";
}
```

### Exempel med flera servrar

```php
require 'samp_query.php';

$servrar = [
    ['ip' => '127.0.0.1', 'porten' => 7777],
    ['ip' => '192.168.0.1', 'porten' => 7778],
];

foreach ($servrar as $data) {
    $server = new samp_query($data['ip'], $data['porten']);
    
    if ($server->Ar_Online()) {
        echo "Server " . $data['ip'] . ":" . $data['porten'] . " är online!";
        echo "Ping: " . $server->Hamta_Ping() . " ms\n";
    } else {
        echo "Server " . $data['ip'] . ":" . $data['porten'] . " är offline.\n";
    }
}
```

## 🧩 Tillgängliga Metoder

### Kontrollera om servern är online

```php
public function Ar_Online()
```

Returnerar `true` om servern är online, annars `false`. Kontroll görs genom att försöka ansluta till servern och skicka ett initialt paket. Om anslutningen misslyckas anses servern vara offline.

### Hämta serverns ping

```php
public function Hamta_Ping()
```

Returnerar serverns ping i millisekunder, beräknat utifrån tiden det tar för paketet att skickas och svaret att mottas. Om servern är offline eller om ping inte kan hämtas, returneras `null`.

### Hämta serverinformation

```php
public function Hamta_Information()
```

Returnerar en array med grundläggande serverinformation, som:

- `passworded`: Anger om servern är lösenordsskyddad.
- `players`: Aktuellt antal spelare.
- `maxplayers`: Maximalt tillåtet antal spelare.
- `hostname`: Serverns namn.
- `gamemode`: Serverns spelläge.
- `language`: Språket som används på servern.

Denna metod använder ett system för automatiska försök för att säkerställa att uppgifterna hämtas korrekt.

### Hämta spelarlista

#### Grundläggande Lista

```php
public function Hamta_Spelare_0()
```

Returnerar en array med listan över anslutna spelare, som innehåller `nickname` och `score` (poäng) för varje spelare. Denna metod är lämplig för att få en översikt över anslutna spelare.

#### Detaljerad Lista

```php
public function Hamta_Spelare_1()
```

Returnerar en array med detaljerad information om varje spelare, inklusive `playerid`, `nickname`, `score` och `ping`. Denna metod ger djupare data om anslutna spelare.

### Hämta serverregler

```php
public function Hamta_Regler()
```

Returnerar en array med serverns regler, där nyckeln är regelnamn och värdet är det associerade värdet för denna regel. Denna metod använder också ett system för försök för att säkerställa att uppgifterna hämtas.

## 🔍 Tekniska Detaljer

### Återförsökssystem

API har ett återförsökssystem (`retryLimit`) som gör det möjligt att försöka hämta information upp till tre gånger innan den ger upp. Detta ökar tillförlitligheten, särskilt i situationer där anslutningen kan vara instabil.

### Konfigurerbara timeoutar

Vid instansiering av klassen `samp_query` konfigureras två typer av timeoutar:

- `timeouts['connect']`: Anger den maximala tiden i sekunder för att etablera en anslutning med servern. Standard är 1 sekund.
- `timeouts['response']`: Anger den maximala tiden i sekunder för att vänta på ett svar från servern efter att ett paket har skickats. Standard är 120 sekunder, vilket är en mycket lång tid.

Dessa timeoutar säkerställer att API:en inte väntar oändligt på ett svar, vilket förbättrar effektiviteten.

### Paketbyggande

Förfrågans paket till **SA-MP**-servern byggs manuellt, med prefixet `'SAMP'` följt av serverns IP-adress och port. Beroende på vilken typ av information som begärs (`i`, `c`, `d`, `r`), läggs motsvarande kommando till i paketet.

### Datakonvertering

API inkluderar en privat metod `toInt()` som konverterar binära data mottagna från servern till heltal. Denna metod säkerställer att data hanteras korrekt, även vid stora värden.

```php
private function toInt($data)
```

Metoden använder bitoperationer för att rekonstruera heltalsvärdet från de binära data, konvertera de fyra separata delarna av ett heltal till det ursprungliga formatet.

## 🔧 Anpassningar och Inställningar

### Avancerade timeoutinställningar

Det är möjligt att anpassa timeoutarna vid instansiering av klassen `samp_query`. Till exempel, för att sätta den maximala anslutningstiden till 5 sekunder och svarstiden till 60 sekunder:

```php
$server = new samp_query('127.0.0.1', 7777);
$server->setTimeouts([
    'connect' => 5,
    'response' => 60
]);
```

### Felmeddelanden och undantagshantering

API: n är utformad för att fånga fel och anslutningsproblem, och returnerar tydliga felmeddelanden vid misslyckanden. Till exempel, om en server inte kan nås, returnerar API: n `null` för metoder som `Hamta_Information()` och `Hamta_Regler()`.

```php
if ($server->Hamta_Information() === null) {
    echo "Kunde inte hämta serverinformation.";
}
```

## ℹ️ Kontaktinformation

Instagram: [ocalasans](https://instagram.com/ocalasans)   
YouTube: [Calasans](https://www.youtube.com/@ocalasans)   
Discord: [Calasans](https://discord.com/users/793520050832932884)   
Gemenskap: [SA-MP Programming Community©](https://abre.ai/samp-spc)

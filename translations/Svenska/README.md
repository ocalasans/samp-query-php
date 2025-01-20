# samp-query-php

**samp-query-php** är ett **API** i **PHP** utvecklat för att söka och hämta information från **SA-MP (San Andreas Multiplayer)** servrar. Detta **API** låter dig kontrollera om en server är online, få ping, grundläggande och detaljerad information om servern, anslutna spelare och serverregler. **API**:et inkluderar också ett system för automatiska försök för att säkerställa att data hämtas på ett tillförlitligt sätt.

### Språk

- Português: [README](../../)
- Deutsch: [README](../Deutsch/README.md)
- English: [README](../English/README.md)
- Español: [README](../Espanol/README.md)
- Français: [README](../Francais/README.md)
- Italiano: [README](../Italiano/README.md)
- Polski: [README](../Polski/README.md)
- Русский: [README](../Русский/README.md)
- Türkçe: [README](../Turkce/README.md)

## Innehållsförteckning

- [samp-query-php](#samp-query-php)
    - [Språk](#språk)
  - [Innehållsförteckning](#innehållsförteckning)
  - [Egenskaper](#egenskaper)
  - [Installation](#installation)
  - [Användning](#användning)
    - [Grundläggande användningsexempel](#grundläggande-användningsexempel)
    - [Exempel med flera servrar](#exempel-med-flera-servrar)
  - [Tillgängliga Metoder](#tillgängliga-metoder)
    - [Kontrollera om servern är online](#kontrollera-om-servern-är-online)
    - [Hämta serverns ping](#hämta-serverns-ping)
    - [Hämta serverinformation](#hämta-serverinformation)
    - [Hämta spelarlista](#hämta-spelarlista)
      - [Grundläggande Lista](#grundläggande-lista)
      - [Detaljerad Lista](#detaljerad-lista)
    - [Hämta serverregler](#hämta-serverregler)
  - [Tekniska Detaljer](#tekniska-detaljer)
    - [Försökssystem](#försökssystem)
    - [Konfigurerbara timeouts](#konfigurerbara-timeouts)
    - [Paketbyggnad](#paketbyggnad)
    - [Datakonvertering](#datakonvertering)
  - [Anpassningar och Inställningar](#anpassningar-och-inställningar)
    - [Avancerade timeout-inställningar](#avancerade-timeout-inställningar)
    - [Felmeddelanden och undantagshantering](#felmeddelanden-och-undantagshantering)
  - [Licens](#licens)
    - [Villkor:](#villkor)

## Egenskaper

- Snabb och effektiv sökning av **SA-MP**-servrar
- Förfrågan om grundläggande och detaljerad serverinformation
- Möjlighet att hämta data om spelare och serverregler
- Automatiskt försökssystem för att säkerställa datahämtning
- Konfiguration av timeouts för anslutning och svar
- Automatisk stängning av socket efter operation
- Stöd för flera språk för serverinformation
- Anpassningsbar begränsning för spelarvisning

## Installation

Klona repositoryt till din lokala maskin:

```bash
git clone https://github.com/ocalasans/samp-query-php.git
```

## Användning

Inkludera filen `samp_query.php` i ditt projekt och instansiera klassen `Samp_Query` genom att skicka IP-adressen och porten för **SA-MP**-servern du vill söka på.

### Grundläggande användningsexempel

```php
require 'samp_query.php';

$server = new Samp_Query('127.0.0.1', 7777);

if ($server->Is_Online()) {
    echo "Servern är online!";
    echo "Ping: " . $server->Get_Ping() . " ms";
    
    $info = $server->Get_Information();
    print_r($info);
    
    $players = $server->Get_Players_0();
    print_r($players);
    
    $rules = $server->Get_Rules();
    print_r($rules);
} else {
    echo "Servern är offline.";
}
```

### Exempel med flera servrar

```php
require 'samp_query.php';

$servers = [
    ['ip' => '127.0.0.1', 'port' => 7777],
    ['ip' => '192.168.0.1', 'port' => 7778],
];

foreach ($servers as $data) {
    $server = new Samp_Query($data['ip'], $data['port']);
    
    if ($server->Is_Online()) {
        echo "Server " . $data['ip'] . ":" . $data['port'] . " är online!";
        echo "Ping: " . $server->Get_Ping() . " ms\n";
    } else {
        echo "Server " . $data['ip'] . ":" . $data['port'] . " är offline.\n";
    }
}
```

## Tillgängliga Metoder

### Kontrollera om servern är online

```php
public function Is_Online()
```

Returnerar `true` om servern är online, annars `false`. Kontrollen utförs genom att försöka ansluta till servern och skicka ett initialt paket. Om anslutningen misslyckas anses servern vara offline.

### Hämta serverns ping

```php
public function Get_Ping()
```

Returnerar serverns ping i millisekunder, beräknat baserat på tiden det tar för paketet att skickas och svaret att tas emot. Om servern är offline eller inte kan få ping, returneras `null`.

### Hämta serverinformation

```php
public function Get_Information()
```

Returnerar en array med grundläggande serverinformation, såsom:

- `passworded`: Indikerar om servern är lösenordsskyddad
- `players`: Aktuellt antal spelare
- `maxplayers`: Maximalt antal tillåtna spelare
- `hostname`: Serverns namn
- `gamemode`: Serverns spelläge
- `language`: Språk som används på servern

Denna metod använder det automatiska försökssystemet för att säkerställa att data hämtas korrekt.

### Hämta spelarlista

#### Grundläggande Lista

```php
public function Get_Players_0()
```

Returnerar en array med listan över anslutna spelare, innehållande `nickname` och `score` (poäng) för varje spelare. Denna metod är lämplig för att få en översikt över anslutna spelare.

#### Detaljerad Lista

```php
public function Get_Players_1()
```

Returnerar en array med detaljerad information om varje spelare, inklusive `playerid`, `nickname`, `score` och `ping`. Denna metod ger djupare data om anslutna spelare.

### Hämta serverregler

```php
public function Get_Rules()
```

Returnerar en array med serverregler, där nyckeln är regelns namn och värdet är det associerade värdet för den regeln. Denna metod använder också försökssystemet för att säkerställa datahämtning.

## Tekniska Detaljer

### Försökssystem

API:et inkluderar ett försökssystem (`retry_limit`) som tillåter upp till tre försök att hämta information innan det ger upp. Detta ökar tillförlitligheten, särskilt i situationer där anslutningen kan vara instabil.

### Konfigurerbara timeouts

När klassen `Samp_Query` instansieras konfigureras två typer av timeouts:

- `timeouts['connect']`: Definierar maximal tid i sekunder för att upprätta en anslutning till servern. Standard är 1 sekund.
- `timeouts['response']`: Definierar maximal tid i sekunder för att vänta på ett svar från servern efter att ett paket skickats. Standard är 120 sekunder vilket redan är en extremt lång tid.

Dessa timeouts säkerställer att API:et inte väntar oändligt på ett svar, vilket förbättrar effektiviteten.

### Paketbyggnad

SA-MP-serverns sökpaket byggs manuellt, med prefixet `'SAMP'` följt av serverns IP-adress och port. Beroende på typ av begärd information (`i`, `c`, `d`, `r`), läggs motsvarande kommando till i paketet.

### Datakonvertering

API:et inkluderar en privat metod `To_Int()` som konverterar binär data mottagen från servern till heltal. Denna metod säkerställer att data hanteras korrekt, även i fall med stora värden.

```php
private function To_Int($data)
```

Metoden använder bitoperationer för att återskapa heltalsvärdet från binär data, konvertera de fyra separata delarna av ett heltal till originalformatet.

## Anpassningar och Inställningar

### Avancerade timeout-inställningar

Det är möjligt att anpassa timeouts vid instansiering av klassen `Samp_Query`. Till exempel, för att sätta maximal anslutningstid till 5 sekunder och svarstid till 60 sekunder:

```php
$server = new Samp_Query('127.0.0.1', 7777);
$server->setTimeouts([
    'connect' => 5,
    'response' => 60
]);
```

### Felmeddelanden och undantagshantering

API:et är designat för att fånga fel och anslutningsfel, returnera tydliga felmeddelanden vid fel. Till exempel, om en server inte kan nås, returnerar API:et `null` för metoder som `Get_Information()` och `Get_Rules()`.

```php
if ($server->Get_Information() === null) {
    echo "Det gick inte att hämta serverinformation.";
}
```

## Licens

Detta API skyddas under MIT-licensen, som tillåter:
- ✔️ Kommersiell och privat användning
- ✔️ Modifiering av källkoden
- ✔️ Distribution av koden
- ✔️ Underlicensiering

### Villkor:

- Behåll upphovsrättsmeddelandet
- Inkludera en kopia av MIT-licensen

För mer information om licensen: https://opensource.org/licenses/MIT

**Copyright (c) Calasans - Alla rättigheter förbehållna**
# samp-query-php

**samp-query-php** to **API** napisane w **PHP**, stworzone do wysyłania zapytań i pobierania informacji z serwerów **SA-MP (San Andreas Multiplayer)**. To **API** pozwala sprawdzić, czy serwer jest online, uzyskać ping, podstawowe i szczegółowe informacje o serwerze, podłączonych graczach oraz zasadach serwera. **API** zawiera również system automatycznych prób, aby zapewnić niezawodne pobieranie danych.

### Języki

- Português: [README](../../)
- Deutsch: [README](../Deutsch/README.md)
- English: [README](../English/README.md)
- Español: [README](../Espanol/README.md)
- Français: [README](../Francais/README.md)
- Italiano: [README](../Italiano/README.md)
- Русский: [README](../Русский/README.md)
- Svenska: [README](../Svenska/README.md)
- Türkçe: [README](../Turkce/README.md)

## Spis treści

- [samp-query-php](#samp-query-php)
    - [Języki](#języki)
  - [Spis treści](#spis-treści)
  - [Funkcje](#funkcje)
  - [Instalacja](#instalacja)
  - [Użycie](#użycie)
    - [Podstawowy przykład użycia](#podstawowy-przykład-użycia)
    - [Przykład z wieloma serwerami](#przykład-z-wieloma-serwerami)
  - [Dostępne metody](#dostępne-metody)
    - [Sprawdzanie czy serwer jest online](#sprawdzanie-czy-serwer-jest-online)
    - [Pobieranie pingu serwera](#pobieranie-pingu-serwera)
    - [Pobieranie informacji o serwerze](#pobieranie-informacji-o-serwerze)
    - [Pobieranie listy graczy](#pobieranie-listy-graczy)
      - [Lista podstawowa](#lista-podstawowa)
      - [Lista szczegółowa](#lista-szczegółowa)
    - [Pobieranie zasad serwera](#pobieranie-zasad-serwera)
  - [Szczegóły techniczne](#szczegóły-techniczne)
    - [System prób](#system-prób)
    - [Konfigurowalne timeouty](#konfigurowalne-timeouty)
    - [Budowanie pakietów](#budowanie-pakietów)
    - [Konwersja danych](#konwersja-danych)
  - [Dostosowania i konfiguracje](#dostosowania-i-konfiguracje)
    - [Zaawansowane ustawienia timeout](#zaawansowane-ustawienia-timeout)
    - [Komunikaty o błędach i obsługa wyjątków](#komunikaty-o-błędach-i-obsługa-wyjątków)
  - [Licencja](#licencja)
    - [Warunki:](#warunki)

## Funkcje

- Szybkie i wydajne odpytywanie serwerów **SA-MP**
- Pobieranie podstawowych i szczegółowych informacji o serwerze
- Możliwość uzyskania danych o graczach i zasadach serwera
- Automatyczny system prób zapewniający pobranie danych
- Konfiguracja timeoutów dla połączenia i odpowiedzi
- Automatyczne zamykanie socketa po zakończeniu operacji
- Wsparcie dla wielu języków dla informacji o serwerze
- Możliwość dostosowania limitu wyświetlanych graczy

## Instalacja

Sklonuj repozytorium na swój lokalny komputer:

```bash
git clone https://github.com/ocalasans/samp-query-php.git
```

## Użycie

Dołącz plik `samp_query.php` do swojego projektu i utwórz instancję klasy `Samp_Query`, przekazując adres IP i port serwera **SA-MP**, który chcesz odpytać.

### Podstawowy przykład użycia

```php
require 'samp_query.php';

$server = new Samp_Query('127.0.0.1', 7777);

if ($server->Is_Online()) {
    echo "Serwer jest online!";
    echo "Ping: " . $server->Get_Ping() . " ms";
    
    $info = $server->Get_Information();
    print_r($info);
    
    $players = $server->Get_Players_0();
    print_r($players);
    
    $rules = $server->Get_Rules();
    print_r($rules);
} else {
    echo "Serwer jest offline.";
}
```

### Przykład z wieloma serwerami

```php
require 'samp_query.php';

$servers = [
    ['ip' => '127.0.0.1', 'port' => 7777],
    ['ip' => '192.168.0.1', 'port' => 7778],
];

foreach ($servers as $data) {
    $server = new Samp_Query($data['ip'], $data['port']);
    
    if ($server->Is_Online()) {
        echo "Serwer " . $data['ip'] . ":" . $data['port'] . " jest online!";
        echo "Ping: " . $server->Get_Ping() . " ms\n";
    } else {
        echo "Serwer " . $data['ip'] . ":" . $data['port'] . " jest offline.\n";
    }
}
```

## Dostępne metody

### Sprawdzanie czy serwer jest online

```php
public function Is_Online()
```

Zwraca `true` jeśli serwer jest online, w przeciwnym razie `false`. Sprawdzenie jest wykonywane poprzez próbę połączenia z serwerem i wysłanie początkowego pakietu. Jeśli połączenie nie powiedzie się, serwer jest uznawany za offline.

### Pobieranie pingu serwera

```php
public function Get_Ping()
```

Zwraca ping serwera w milisekundach, obliczony na podstawie czasu potrzebnego na wysłanie pakietu i otrzymanie odpowiedzi. Jeśli serwer jest offline lub nie można uzyskać pingu, zwraca `null`.

### Pobieranie informacji o serwerze

```php
public function Get_Information()
```

Zwraca tablicę z podstawowymi informacjami o serwerze, takimi jak:

- `passworded`: Wskazuje, czy serwer jest chroniony hasłem
- `players`: Aktualna liczba graczy
- `maxplayers`: Maksymalna dozwolona liczba graczy
- `hostname`: Nazwa serwera
- `gamemode`: Tryb gry na serwerze
- `language`: Język używany na serwerze

Ta metoda korzysta z systemu automatycznych prób, aby zapewnić poprawne pobranie danych.

### Pobieranie listy graczy

#### Lista podstawowa

```php
public function Get_Players_0()
```

Zwraca tablicę z listą podłączonych graczy, zawierającą `nickname` i `score` (wynik) każdego gracza. Ta metoda jest odpowiednia do uzyskania ogólnego przeglądu podłączonych graczy.

#### Lista szczegółowa

```php
public function Get_Players_1()
```

Zwraca tablicę ze szczegółowymi informacjami o każdym graczu, w tym `playerid`, `nickname`, `score` i `ping`. Ta metoda dostarcza bardziej szczegółowych danych o podłączonych graczach.

### Pobieranie zasad serwera

```php
public function Get_Rules()
```

Zwraca tablicę z zasadami serwera, gdzie klucz to nazwa zasady, a wartość to wartość przypisana do tej zasady. Ta metoda również wykorzystuje system prób do zapewnienia pobrania danych.

## Szczegóły techniczne

### System prób

API zawiera system prób (`retry_limit`), który pozwala na próbę uzyskania informacji do trzech razy przed poddaniem się. Zwiększa to niezawodność, szczególnie w sytuacjach, gdy połączenie może być niestabilne.

### Konfigurowalne timeouty

Podczas tworzenia instancji klasy `Samp_Query` konfigurowane są dwa rodzaje timeoutów:

- `timeouts['connect']`: Określa maksymalny czas w sekundach na nawiązanie połączenia z serwerem. Domyślnie 1 sekunda.
- `timeouts['response']`: Określa maksymalny czas w sekundach na oczekiwanie na odpowiedź z serwera po wysłaniu pakietu. Domyślnie 120 sekund, co jest już bardzo wysoką wartością.

Te timeouty zapewniają, że API nie będzie czekać w nieskończoność na odpowiedź, poprawiając wydajność.

### Budowanie pakietów

Pakiety zapytań do serwera **SA-MP** są budowane ręcznie, używając prefiksu `'SAMP'` następnie adresu IP serwera i portu. W zależności od typu żądanej informacji (`i`, `c`, `d`, `r`), odpowiednie polecenie jest dodawane do pakietu.

### Konwersja danych

API zawiera prywatną metodę `To_Int()`, która konwertuje dane binarne otrzymane z serwera na liczby całkowite. Ta metoda zapewnia prawidłową obsługę danych, nawet w przypadku dużych wartości.

```php
private function To_Int($data)
```

Metoda wykorzystuje operacje bitowe do rekonstrukcji wartości całkowitej z danych binarnych, konwertując cztery oddzielne części liczby całkowitej do oryginalnego formatu.

## Dostosowania i konfiguracje

### Zaawansowane ustawienia timeout

Możliwe jest dostosowanie timeoutów podczas tworzenia instancji klasy `Samp_Query`. Na przykład, aby ustawić maksymalny czas połączenia na 5 sekund i czas odpowiedzi na 60 sekund:

```php
$server = new Samp_Query('127.0.0.1', 7777);
$server->setTimeouts([
    'connect' => 5,
    'response' => 60
]);
```

### Komunikaty o błędach i obsługa wyjątków

API zostało zaprojektowane do przechwytywania błędów i niepowodzeń połączenia, zwracając czytelne komunikaty o błędach w przypadku niepowodzenia. Na przykład, jeśli serwer nie jest dostępny, API zwraca `null` dla metod takich jak `Get_Information()` i `Get_Rules()`.

```php
if ($server->Get_Information() === null) {
    echo "Nie można uzyskać informacji o serwerze.";
}
```

## Licencja

To API jest chronione licencją MIT, która pozwala na:
- ✔️ Użycie komercyjne i prywatne
- ✔️ Modyfikację kodu źródłowego
- ✔️ Dystrybucję kodu
- ✔️ Sublicencjonowanie

### Warunki:

- Zachowanie informacji o prawach autorskich
- Dołączenie kopii licencji MIT

Więcej szczegółów o licencji: https://opensource.org/licenses/MIT

**Copyright (c) Calasans - Wszelkie prawa zastrzeżone**
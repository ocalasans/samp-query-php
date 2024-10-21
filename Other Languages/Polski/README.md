# samp-query-php

**samp-query-php** to **API** w **PHP** stworzona do uzyskiwania informacji o serwerach **SA-MP (San Andreas Multiplayer)**. Ta **API** pozwala na sprawdzenie, czy serwer jest online, uzyskanie pingu, podstawowych i szczegółowych informacji o serwerze, połączonych graczach oraz zasadach serwera. **API** zawiera również system automatycznych prób, aby zapewnić niezawodne uzyskiwanie danych.

### Języki

- **Português** > [README](https://github.com/ocalasans/samp-query-php) / [Código](https://github.com/ocalasans/samp-query-php/blob/main/samp-query.php).
- **English** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/English) / [Code](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/English/samp-query.php).
- **Español** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Espanol) / [Código](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Espanol/samp-query.php).
- **Türk** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Turk) / [Kod](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Turk/samp-query.php).
- **Deutsch** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Deutsch) / [Code](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Deutsch/samp-query.php).
- **Русский** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Русский) / [Код](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Русский/samp-query.php).
- **Français** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Francais) / [Code](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Francais/samp-query.php).
- **Italiano** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Italiano) / [Codice](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Italiano/samp-query.php).
- **Svensk** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Svensk) / [Koda](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Svensk/samp-query.php).

## Podsumowanie
- [samp-query-php](#samp-query-php)
    - [Języki](#języki)
  - [Podsumowanie](#podsumowanie)
  - [Cechy](#cechy)
  - [Instalacja](#️instalacja)
  - [Użycie](#użycie)
    - [Przykład podstawowego użycia](#przykład-podstawowego-użycia)
    - [Przykład z wieloma serwerami](#przykład-z-wieloma-serwerami)
  - [Dostępne Metody](#dostępne-metody)
    - [Sprawdź, czy serwer jest online](#sprawdź-czy-serwer-jest-online)
    - [Uzyskaj ping serwera](#uzyskaj-ping-serwera)
    - [Uzyskaj informacje o serwerze](#uzyskaj-informacje-o-serwerze)
    - [Uzyskaj listę graczy](#uzyskaj-listę-graczy)
      - [Lista Podstawowa](#lista-podstawowa)
      - [Lista Szczegółowa](#lista-szczegółowa)
    - [Uzyskaj zasady serwera](#uzyskaj-zasady-serwera)
  - [Szczegóły Techniczne](#szczegóły-techniczne)
    - [System prób](#system-prób)
    - [Konfigurowalne limity czasowe](#konfigurowalne-limity-czasowe)
    - [Budowanie pakietów](#budowanie-pakietów)
    - [Konwersja danych](#konwersja-danych)
  - [Dostosowywanie i Konfiguracje](#dostosowywanie-i-konfiguracje)
    - [Zaawansowane ustawienia limitów czasowych](#zaawansowane-ustawienia-limitów-czasowych)
    - [Komunikaty o błędach i obsługa wyjątków](#komunikaty-o-błędach-i-obsługa-wyjątków)
  - [Informacje kontaktowe](#informacje-kontaktowe)

## Cechy

- Szybkie i efektywne zapytania do serwerów **SA-MP**.
- Pobieranie podstawowych i szczegółowych informacji o serwerze.
- Możliwość uzyskania danych o graczach i zasadach serwera.
- Automatyczny system prób zapewniający pobieranie danych.
- Konfiguracja timeoutów dla połączenia i odpowiedzi.
- Automatyczne zamykanie gniazda po zakończeniu operacji.
- Wsparcie dla wielu języków w informacji o serwerze.
- Dostosowane limity wyświetlania graczy.

## Instalacja

Sklonuj repozytorium na swoją lokalną maszynę:

```bash
git clone https://github.com/ocalasans/samp-query-php.git
```

## Użycie

Dodaj plik `samp-query.php` do swojego projektu i zainicjuj klasę `samp_query`, przekazując adres IP i port serwera **SA-MP**, który chcesz zapytać.

### Przykład podstawowego użycia

```php
require 'samp-query.php';

$server = new samp_query('127.0.0.1', 7777);

if ($server->Jest_Online()) {
    echo "Serwer jest online!";
    echo "Ping: " . $server->Uzyskac_Ping() . " ms";
    
    $info = $server->Uzyskac_Informacja();
    print_r($info);
    
    $gracze = $server->Uzyskac_Graczy_0();
    print_r($gracze);
    
    $zasady = $server->Uzyskac_Zasady();
    print_r($zasady);
} else {
    echo "Serwer jest offline.";
}
```

### Przykład z wieloma serwerami

```php
require 'samp-query.php';

$serwery = [
    ['ip' => '127.0.0.1', 'drzwi' => 7777],
    ['ip' => '192.168.0.1', 'drzwi' => 7778],
];

foreach ($serwery as $dane) {
    $server = new samp_query($dane['ip'], $dane['drzwi']);
    
    if ($server->Jest_Online()) {
        echo "Serwer " . $dane['ip'] . ":" . $dane['drzwi'] . " jest online!";
        echo "Ping: " . $server->Uzyskac_Ping() . " ms\n";
    } else {
        echo "Serwer " . $dane['ip'] . ":" . $dane['drzwi'] . " jest offline.\n";
    }
}
```

## Dostępne Metody

### Sprawdź, czy serwer jest online

```php
public function Jest_Online()
```

Zwraca `true`, jeśli serwer jest online, w przeciwnym razie `false`. Sprawdzenie jest przeprowadzane przez próbę połączenia się z serwerem i wysłanie pakietu początkowego. Jeśli połączenie się nie powiedzie, serwer jest uznawany za offline.

### Uzyskaj ping serwera

```php
public function Uzyskac_Ping()
```

Zwraca ping serwera w milisekundach, obliczony na podstawie czasu, jaki zajmuje wysłanie pakietu i odebranie odpowiedzi. Jeśli serwer jest offline lub ping nie może zostać uzyskany, zwraca `null`.

### Uzyskaj informacje o serwerze

```php
public function Uzyskac_Informacja()
```

Zwraca tablicę z podstawowymi informacjami o serwerze, takimi jak:

- `passworded`: Wskazuje, czy serwer jest chroniony hasłem.
- `players`: Aktualna liczba graczy.
- `maxplayers`: Maksymalna liczba dozwolonych graczy.
- `hostname`: Nazwa serwera.
- `gamemode`: Tryb gry na serwerze.
- `language`: Język używany na serwerze.

Ta metoda wykorzystuje system automatycznych prób, aby zapewnić poprawne pobranie danych.

### Uzyskaj listę graczy

#### Lista Podstawowa

```php
public function Uzyskac_Graczy_0()
```

Zwraca tablicę z listą podłączonych graczy, zawierającą `nickname` i `score` (wynik) każdego gracza. Ta metoda jest odpowiednia do uzyskania ogólnego widoku podłączonych graczy.

#### Lista Szczegółowa

```php
public function Uzyskac_Graczy_1()
```

Zwraca tablicę z szczegółowymi informacjami o każdym graczu, w tym `playerid`, `nickname`, `score` i `ping`. Ta metoda dostarcza bardziej szczegółowe dane o podłączonych graczach.

### Uzyskaj zasady serwera

```php
public function Uzyskaj_Zasady()
```

Zwraca tablicę z zasadami serwera, gdzie klucz to nazwa zasady, a wartość to wartość przypisana do tej zasady. Ta metoda również wykorzystuje system prób, aby zapewnić uzyskanie danych.

## Szczegóły Techniczne

### System prób

API zawiera system prób (`retryLimit`), który umożliwia próbę uzyskania informacji do trzech razy przed podjęciem decyzji o rezygnacji. Zwiększa to niezawodność, szczególnie w sytuacjach, gdy połączenie może być niestabilne.

### Konfigurowalne limity czasowe

Podczas instancjonowania klasy `samp_query`, konfigurowane są dwa rodzaje limitów czasowych:

- `timeouts['connect']`: Określa maksymalny czas w sekundach na nawiązanie połączenia z serwerem. Domyślnie wynosi 1 sekunda.
- `timeouts['response']`: Określa maksymalny czas w sekundach na oczekiwanie na odpowiedź od serwera po wysłaniu pakietu. Domyślnie wynosi 120 sekund, co jest już bardzo długim czasem.

Te limity czasowe zapewniają, że API nie będzie czekać w nieskończoność na odpowiedź, co zwiększa efektywność.

### Budowanie pakietów

Pakiety zapytań do serwera **SA-MP** są budowane ręcznie, używając prefiksu `'SAMP'`, a następnie adresu IP serwera i portu. W zależności od rodzaju żądanej informacji (`i`, `c`, `d`, `r`), odpowiednie polecenie jest dodawane do pakietu.

### Konwersja danych

API zawiera prywatną metodę `toInt()`, która konwertuje dane binarne otrzymane z serwera na liczby całkowite. Metoda ta zapewnia prawidłowe przetwarzanie danych, nawet w przypadku dużych wartości.

```php
private function toInt($data)
```

Metoda wykorzystuje operacje bitowe do odbudowy wartości całkowitej z danych binarnych, konwertując cztery oddzielne części liczby całkowitej na pierwotny format.

## Dostosowywanie i Konfiguracje

### Zaawansowane ustawienia limitów czasowych

Można dostosować limity czasowe podczas instancjonowania klasy `samp_query`. Na przykład, aby ustawić maksymalny czas połączenia na 5 sekund i czas odpowiedzi na 60 sekund:

```php
$server = new samp_query('127.0.0.1', 7777);
$server->setTimeouts([
    'connect' => 5,
    'response' => 60
]);
```

### Komunikaty o błędach i obsługa wyjątków

API jest zaprojektowane do przechwytywania błędów i awarii połączenia, zwracając jasne komunikaty o błędach w przypadku awarii. Na przykład, jeśli serwer nie może być osiągnięty, API zwraca `null` dla metod takich jak `Uzyskac_Informacja()`, `Uzyskac_Graczy_0`, `Uzyskac_Graczy_1` i `Uzyskaj_Zasady()`.

```php
if ($server->Uzyskac_Informacja() === null) {
    echo "Nie można uzyskać informacji o serwerze.";
}
```

## Informacje kontaktowe

Instagram: [ocalasans](https://instagram.com/ocalasans)   
YouTube: [Calasans](https://www.youtube.com/@ocalasans)   
Discord: [Calasans](https://discord.com/users/793520050832932884)   
Społeczność: [SA-MP Programming Community](https://abre.ai/samp-spc)

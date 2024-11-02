# SA-MP Query PHP

**samp-query-php** è una **API** in **PHP** sviluppata per interrogare e ottenere informazioni sui server **SA-MP (San Andreas Multiplayer)**. Questa **API** ti consente di verificare se un server è online, ottenere il ping, informazioni di base e dettagliate sul server, giocatori connessi e regole del server. L'**API** include anche un sistema di tentativi automatici per garantire che i dati vengano ottenuti in modo affidabile.

### Lingue

- **Português** > [README](https://github.com/ocalasans/samp-query-php) / [Código](https://github.com/ocalasans/samp-query-php/blob/main/samp-query.php).
- **English** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/English) / [Code](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/English/samp-query.php).
- **Español** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Espanol) / [Código](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Espanol/samp-query.php).
- **Polski** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Polski) / [Kod](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Polski/samp-query.php).
- **Türk** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Turk) / [Kod](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Turk/samp-query.php).
- **Deutsch** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Deutsch) / [Code](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Deutsch/samp-query.php).
- **Русский** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Русский) / [Код](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Русский/samp-query.php).
- **Français** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Francais) / [Code](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Francais/samp-query.php).
- **Svensk** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Svensk) / [Koda](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Svensk/samp-query.php).

## Indice
- [SA-MP Query PHP](#sa-mp-query-php)
    - [Lingue](#lingue)
  - [Sommario](#sommario)
  - [Caratteristiche](#caratteristiche)
  - [Installazione](#️installazione)
  - [Uso](#uso)
    - [Esempio di utilizzo base](#esempio-di-utilizzo-base)
    - [Esempio con più server](#esempio-con-più-server)
  - [Metodi Disponibili](#metodi-disponibili)
    - [Verificare se il server è online](#verificare-se-il-server-è-online)
    - [Ottenere il ping del server](#ottenere-il-ping-del-server)
    - [Ottenere informazioni sul server](#ottenere-informazioni-sul-server)
    - [Ottenere la lista dei giocatori](#ottenere-la-lista-dei-giocatori)
      - [Lista Base](#lista-base)
      - [Lista Dettagliata](#lista-dettagliata)
    - [Ottenere le regole del server](#ottenere-le-regole-del-server)
  - [Dettagli Tecnici](#dettagli-tecnici)
    - [Sistema di tentativi](#sistema-di-tentativi)
    - [Timeout configurabili](#timeout-configurabili)
    - [Costruzione dei pacchetti](#costruzione-dei-pacchetti)
    - [Conversione dei dati](#conversione-dei-dati)
  - [Personalizzazioni e Configurazioni](#personalizzazioni-e-configurazioni)
    - [Configurazioni avanzate di timeout](#configurazioni-avanzate-di-timeout)
    - [Messaggi di errore e gestione delle eccezioni](#messaggi-di-errore-e-gestione-delle-eccezioni)
  - [Informazioni di contatto](#ℹ️informazioni-di-contatto)

## Caratteristiche

- Consultazione rapida ed efficiente dei server **SA-MP**.
- Richiesta di informazioni di base e dettagliate del server.
- Possibilità di ottenere dati sui giocatori e sulle regole del server.
- Sistema automatico di tentativi per garantire il recupero dei dati.
- Configurazione dei timeout per connessione e risposta.
- Chiusura automatica del socket al termine dell'operazione.
- Supporto per più lingue per le informazioni del server.
- Limitazione personalizzata per la visualizzazione dei giocatori.

## Installazione

Clona il repository sulla tua macchina locale:

```bash
git clone https://github.com/ocalasans/samp-query-php.git
```

## Uso

Includi il file `samp-query.php` nel tuo progetto e instancia la classe `samp_query` passando l'indirizzo IP e la porta del server **SA-MP** che desideri consultare.

### Esempio di utilizzo base

```php
require 'samp-query.php';

$server = new samp_query('127.0.0.1', 7777);

if ($server->E_Online()) {
    echo "Il server è online!";
    echo "Ping: " . $server->Ottenere_Ping() . " ms";
    
    $info = $server->Ottenere_Informazioni();
    print_r($info);
    
    $giocatori = $server->Ottenere_Giocatori_0();
    print_r($giocatori);
    
    $regole = $server->Ottenere_Regole();
    print_r($regole);
} else {
    echo "Il server è offline.";
}
```

### Esempio con più server

```php
require 'samp-query.php';

$server = [
    ['ip' => '127.0.0.1', 'porta' => 7777],
    ['ip' => '192.168.0.1', 'porta' => 7778],
];

foreach ($server as $dati) {
    $server = new samp_query($dati['ip'], $dati['porta']);
    
    if ($server->E_Online()) {
        echo "Server " . $dati['ip'] . ":" . $dati['porta'] . " è online!";
        echo "Ping: " . $server->Ottenere_Ping() . " ms\n";
    } else {
        echo "Server " . $dati['ip'] . ":" . $dati['porta'] . " è offline.\n";
    }
}
```

## Metodi Disponibili

### Verificare se il server è online

```php
public function E_Online()
```

Ritorna `true` se il server è online, altrimenti `false`. Il controllo viene eseguito tentando di connettersi al server e inviare un pacchetto iniziale. Se la connessione fallisce, il server viene considerato offline.

### Ottenere il ping del server

```php
public function Ottenere_Ping()
```

Ritorna il ping del server in millisecondi, calcolato in base al tempo che impiega per inviare il pacchetto e ricevere la risposta. Se il server è offline o non è possibile ottenere il ping, ritorna `null`.

### Ottenere informazioni sul server

```php
public function Ottenere_Informazioni()
```

Ritorna un array con informazioni di base del server, come:

- `passworded`: Indica se il server è protetto da password.
- `players`: Numero attuale di giocatori.
- `maxplayers`: Numero massimo di giocatori consentito.
- `hostname`: Nome del server.
- `gamemode`: Modalità di gioco del server.
- `language`: Lingua utilizzata nel server.

Questo metodo utilizza un sistema di tentativi automatici per garantire che i dati siano ottenuti correttamente.

### Ottenere la lista dei giocatori

#### Lista Base

```php
public function Ottenere_Giocatori_0()
```

Restituisce un array con la lista dei giocatori connessi, contenente `nickname` e `score` (punteggio) di ogni giocatore. Questo metodo è adatto per ottenere una panoramica dei giocatori connessi.

#### Lista Dettagliata

```php
public function Ottenere_Giocatori_1()
```

Restituisce un array con informazioni dettagliate su ogni giocatore, inclusi `playerid`, `nickname`, `score` e `ping`. Questo metodo fornisce dati più approfonditi sui giocatori connessi.

### Ottenere le regole del server

```php
public function Ottenere_Regole()
```

Restituisce un array con le regole del server, dove la chiave è il nome della regola e il valore è il valore associato a quella regola. Questo metodo utilizza anche il sistema di tentativi per garantire l'ottenimento dei dati.

## Dettagli Tecnici

### Sistema di tentativi

L'API incorpora un sistema di tentativi (`retryLimit`) che consente di tentare di ottenere informazioni fino a tre volte prima di arrendersi. Questo aumenta l'affidabilità, specialmente in situazioni in cui la connessione può essere instabile.

### Timeout configurabili

Quando si istanzia la classe `samp_query`, sono configurati due tipi di timeout:

- `timeouts['connect']`: Definisce il tempo massimo in secondi per stabilire una connessione con il server. Il valore predefinito è 1 secondo.
- `timeouts['response']`: Definisce il tempo massimo in secondi per attendere una risposta dal server dopo l'invio di un pacchetto. Il valore predefinito è 120 secondi, che è già un tempo estremamente elevato.

Questi timeout garantiscono che l'API non rimanga indefinitamente in attesa di una risposta, migliorando l'efficienza.

### Costruzione dei pacchetti

I pacchetti di query al server **SA-MP** sono costruiti manualmente, utilizzando il prefisso `'SAMP'` seguito dall'indirizzo IP del server e dalla porta. A seconda del tipo di informazione richiesta (`i`, `c`, `d`, `r`), il comando corrispondente viene aggiunto al pacchetto.

### Conversione dei dati

L'API include un metodo privato `toInt()` che converte i dati binari ricevuti dal server in interi. Questo metodo garantisce che i dati vengano manipolati correttamente, anche in caso di valori grandi.

```php
private function toInt($data)
```

Il metodo utilizza operazioni bit a bit per ricostruire il valore intero dai dati binari, convertendo le quattro parti separate di un numero intero nel formato originale.

## Personalizzazioni e Configurazioni

### Configurazioni avanzate di timeout

È possibile personalizzare i timeout al momento dell'istanza della classe `samp_query`. Ad esempio, per impostare il tempo massimo di connessione a 5 secondi e il tempo di risposta a 60 secondi:

```php
$server = new samp_query('127.0.0.1', 7777);
$server->setTimeouts([
    'connect' => 5,
    'response' => 60
]);
```

### Messaggi di errore e gestione delle eccezioni

L'API è progettata per catturare errori e fallimenti di connessione, restituendo messaggi di errore chiari in caso di problemi. Ad esempio, se un server non può essere raggiunto, l'API restituisce `null` per metodi come `Ottenere_Informazioni()`, `Ottenere_Giocatori_0`, `Ottenere_Giocatori_1` e `Ottenere_Regole()`.

```php
if ($server->Ottenere_Informazioni() === null) {
    echo "Impossibile ottenere informazioni dal server.";
}
```

## Informazioni di contatto

Instagram: [ocalasans](https://instagram.com/ocalasans)   
YouTube: [Calasans](https://www.youtube.com/@ocalasans)   
Discord: [Calasans](https://discord.com/users/793520050832932884)   
Comunità: [SA-MP Programming Community](https://abre.ai/samp-spc)

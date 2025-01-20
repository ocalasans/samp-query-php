# samp-query-php

**samp-query-php** è una **API** in **PHP** sviluppata per interrogare e ottenere informazioni dai server **SA-MP (San Andreas Multiplayer)**. Questa **API** ti permette di verificare se un server è online, ottenere il ping, informazioni di base e dettagliate sul server, giocatori connessi e regole del server. L'**API** include anche un sistema di tentativi automatici per garantire che i dati vengano ottenuti in modo affidabile.

### Lingue

- Português: [README](../../)
- Deutsch: [README](../Deutsch/README.md)
- English: [README](../English/README.md)
- Español: [README](../Espanol/README.md)
- Français: [README](../Francais/README.md)
- Polski: [README](../Polski/README.md)
- Русский: [README](../Русский/README.md)
- Svenska: [README](../Svenska/README.md)
- Türkçe: [README](../Turkce/README.md)

## Indice

- [samp-query-php](#samp-query-php)
    - [Lingue](#lingue)
  - [Indice](#indice)
  - [Caratteristiche](#caratteristiche)
  - [Installazione](#installazione)
  - [Utilizzo](#utilizzo)
    - [Esempio di utilizzo base](#esempio-di-utilizzo-base)
    - [Esempio con server multipli](#esempio-con-server-multipli)
  - [Metodi Disponibili](#metodi-disponibili)
    - [Verificare se il server è online](#verificare-se-il-server-è-online)
    - [Ottenere il ping del server](#ottenere-il-ping-del-server)
    - [Ottenere informazioni del server](#ottenere-informazioni-del-server)
    - [Ottenere lista dei giocatori](#ottenere-lista-dei-giocatori)
      - [Lista Base](#lista-base)
      - [Lista Dettagliata](#lista-dettagliata)
    - [Ottenere regole del server](#ottenere-regole-del-server)
  - [Dettagli Tecnici](#dettagli-tecnici)
    - [Sistema di tentativi](#sistema-di-tentativi)
    - [Timeout configurabili](#timeout-configurabili)
    - [Costruzione dei pacchetti](#costruzione-dei-pacchetti)
    - [Conversione dei dati](#conversione-dei-dati)
  - [Personalizzazioni e Configurazioni](#personalizzazioni-e-configurazioni)
    - [Configurazioni avanzate del timeout](#configurazioni-avanzate-del-timeout)
    - [Messaggi di errore e gestione delle eccezioni](#messaggi-di-errore-e-gestione-delle-eccezioni)
  - [Licenza](#licenza)
    - [Condizioni:](#condizioni)

## Caratteristiche

- Interrogazione rapida ed efficiente dei server **SA-MP**
- Richiesta di informazioni base e dettagliate del server
- Possibilità di ottenere dati sui giocatori e regole del server
- Sistema di tentativi automatico per garantire l'ottenimento dei dati
- Configurazione dei timeout per connessione e risposta
- Chiusura automatica del socket al termine dell'operazione
- Supporto multilingua per le informazioni del server
- Limitazione personalizzata per la visualizzazione dei giocatori

## Installazione

Clona il repository nella tua macchina locale:

```bash
git clone https://github.com/ocalasans/samp-query-php.git
```

## Utilizzo

Includi il file `samp_query.php` nel tuo progetto e istanzia la classe `Samp_Query` passando l'indirizzo IP e la porta del server **SA-MP** che desideri interrogare.

### Esempio di utilizzo base

```php
require 'samp_query.php';

$server = new Samp_Query('127.0.0.1', 7777);

if ($server->Is_Online()) {
    echo "Il server è online!";
    echo "Ping: " . $server->Get_Ping() . " ms";
    
    $info = $server->Get_Information();
    print_r($info);
    
    $players = $server->Get_Players_0();
    print_r($players);
    
    $rules = $server->Get_Rules();
    print_r($rules);
} else {
    echo "Il server è offline.";
}
```

### Esempio con server multipli

```php
require 'samp_query.php';

$servers = [
    ['ip' => '127.0.0.1', 'porta' => 7777],
    ['ip' => '192.168.0.1', 'porta' => 7778],
];

foreach ($servers as $data) {
    $server = new Samp_Query($data['ip'], $data['porta']);
    
    if ($server->Is_Online()) {
        echo "Server " . $data['ip'] . ":" . $data['porta'] . " è online!";
        echo "Ping: " . $server->Get_Ping() . " ms\n";
    } else {
        echo "Server " . $data['ip'] . ":" . $data['porta'] . " è offline.\n";
    }
}
```

## Metodi Disponibili

### Verificare se il server è online

```php
public function Is_Online()
```

Restituisce `true` se il server è online, altrimenti `false`. La verifica viene effettuata tentando di connettersi al server e inviare un pacchetto iniziale. Se la connessione fallisce, il server viene considerato offline.

### Ottenere il ping del server

```php
public function Get_Ping()
```

Restituisce il ping del server in millisecondi, calcolato in base al tempo necessario per l'invio del pacchetto e la ricezione della risposta. Se il server è offline o non è possibile ottenere il ping, restituisce `null`.

### Ottenere informazioni del server

```php
public function Get_Information()
```

Restituisce un array con informazioni base del server, come:

- `passworded`: Indica se il server è protetto da password
- `players`: Numero attuale di giocatori
- `maxplayers`: Numero massimo di giocatori consentito
- `hostname`: Nome del server
- `gamemode`: Modalità di gioco del server
- `language`: Lingua utilizzata nel server

Questo metodo utilizza il sistema di tentativi automatici per garantire che i dati vengano ottenuti correttamente.

### Ottenere lista dei giocatori

#### Lista Base

```php
public function Get_Players_0()
```

Restituisce un array con la lista dei giocatori connessi, contenente `nickname` e `score` (punteggio) di ogni giocatore. Questo metodo è adatto per ottenere una panoramica dei giocatori connessi.

#### Lista Dettagliata

```php
public function Get_Players_1()
```

Restituisce un array con informazioni dettagliate su ogni giocatore, inclusi `playerid`, `nickname`, `score` e `ping`. Questo metodo fornisce dati più approfonditi sui giocatori connessi.

### Ottenere regole del server

```php
public function Get_Rules()
```

Restituisce un array con le regole del server, dove la chiave è il nome della regola e il valore è il valore associato a quella regola. Questo metodo utilizza anche il sistema di tentativi per assicurare l'ottenimento dei dati.

## Dettagli Tecnici

### Sistema di tentativi

L'API incorpora un sistema di tentativi (`retry_limit`) che permette di provare a ottenere informazioni fino a tre volte prima di rinunciare. Questo aumenta l'affidabilità, specialmente in situazioni dove la connessione può essere instabile.

### Timeout configurabili

Quando si istanzia la classe `Samp_Query`, vengono configurati due tipi di timeout:

- `timeouts['connect']`: Definisce il tempo massimo in secondi per stabilire una connessione con il server. Il default è 1 secondo.
- `timeouts['response']`: Definisce il tempo massimo in secondi per attendere una risposta dal server dopo l'invio di un pacchetto. Il default è 120 secondi che è già un tempo estremamente alto.

Questi timeout garantiscono che l'API non rimanga indefinitamente in attesa di una risposta, migliorando l'efficienza.

### Costruzione dei pacchetti

I pacchetti di interrogazione al server **SA-MP** vengono costruiti manualmente, utilizzando il prefisso `'SAMP'` seguito dall'indirizzo IP del server e dalla porta. A seconda del tipo di informazione richiesta (`i`, `c`, `d`, `r`), il comando corrispondente viene aggiunto al pacchetto.

### Conversione dei dati

L'API include un metodo privato `To_Int()` che converte i dati binari ricevuti dal server in interi. Questo metodo garantisce che i dati vengano manipolati correttamente, anche in caso di valori grandi.

```php
private function To_Int($data)
```

Il metodo utilizza operazioni bit a bit per ricostruire il valore intero dai dati binari, convertendo le quattro parti separate di un numero intero nel formato originale.

## Personalizzazioni e Configurazioni

### Configurazioni avanzate del timeout

È possibile personalizzare i timeout al momento dell'istanza della classe `Samp_Query`. Per esempio, per impostare il tempo massimo di connessione a 5 secondi e il tempo di risposta a 60 secondi:

```php
$server = new Samp_Query('127.0.0.1', 7777);
$server->setTimeouts([
    'connect' => 5,
    'response' => 60
]);
```

### Messaggi di errore e gestione delle eccezioni

L'API è progettata per catturare errori e fallimenti di connessione, restituendo messaggi di errore chiari in caso di fallimento. Per esempio, se un server non può essere raggiunto, l'API restituisce `null` per metodi come `Get_Information()` e `Get_Rules()`.

```php
if ($server->Get_Information() === null) {
    echo "Non è stato possibile ottenere informazioni dal server.";
}
```

## Licenza

Questa API è protetta sotto la Licenza MIT, che permette:
- ✔️ Uso commerciale e privato
- ✔️ Modifica del codice sorgente
- ✔️ Distribuzione del codice
- ✔️ Sublicenza

### Condizioni:

- Mantenere l'avviso di copyright
- Includere una copia della licenza MIT

Per maggiori dettagli sulla licenza: https://opensource.org/licenses/MIT

**Copyright (c) Calasans - Tutti i diritti riservati**
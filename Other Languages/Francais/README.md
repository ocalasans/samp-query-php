# samp-query-php

**samp-query-php** est une **API** en **PHP** développée pour interroger et obtenir des informations sur les serveurs **SA-MP (San Andreas Multiplayer)**. Cette **API** vous permet de vérifier si un serveur est en ligne, d'obtenir le ping, des informations de base et détaillées sur le serveur, les joueurs connectés et les règles du serveur. L'**API** inclut également un système de tentatives automatiques pour garantir que les données sont obtenues de manière fiable.

### Langages

- **Português** > [README](https://github.com/ocalasans/samp-query-php) / [Código](https://github.com/ocalasans/samp-query-php/blob/main/samp-query.php).
- **English** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/English) / [Code](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/English/samp-query.php).
- **Español** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Espanol) / [Código](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Espanol/samp-query.php).
- **Polski** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Polski) / [Kod](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Polski/samp-query.php).
- **Türk** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Turk) / [Kod](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Turk/samp-query.php).
- **Deutsch** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Deutsch) / [Code](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Deutsch/samp-query.php).
- **Русский** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Русский) / [Код](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Русский/samp-query.php).
- **Italiano** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Italiano) / [Codice](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Italiano/samp-query.php).
- **Svensk** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Svensk) / [Koda](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Svensk/samp-query.php).

## Sommaire
- [samp-query-php](#samp-query-php)
    - [Langages](#langages)
  - [Sommaire](#sommaire)
  - [Caractéristiques](#caractéristiques)
  - [Installation](#️installation)
  - [Utilisation](#utilisation)
    - [Exemple d'utilisation de base](#exemple-dutilisation-de-base)
    - [Exemple avec plusieurs serveurs](#exemple-avec-plusieurs-serveurs)
  - [Méthodes Disponibles](#méthodes-disponibles)
    - [Vérifier si le serveur est en ligne](#vérifier-si-le-serveur-est-en-ligne)
    - [Obtenir le ping du serveur](#obtenir-le-ping-du-serveur)
    - [Obtenir les informations du serveur](#obtenir-les-informations-du-serveur)
    - [Obtenir la liste des joueurs](#obtenir-la-liste-des-joueurs)
      - [Liste de base](#liste-de-base)
      - [Liste détaillée](#liste-détaillée)
    - [Obtenir les règles du serveur](#obtenir-les-règles-du-serveur)
  - [Détails techniques](#détails-techniques)
    - [Système de tentatives](#système-de-tentatives)
    - [Timeouts configurables](#timeouts-configurables)
    - [Construction des paquets](#construction-des-paquets)
    - [Conversion des données](#conversion-des-données)
  - [Personnalisations et configurations](#personnalisations-et-configurations)
    - [Paramètres avancés de timeout](#paramètres-avancés-de-timeout)
    - [Messages d'erreur et gestion des exceptions](#messages-derreur-et-gestion-des-exceptions)
  - [Informations de contact](#informations-de-contact)

## Caractéristiques

- Consultation rapide et efficace des serveurs **SA-MP**.
- Demande d'informations de base et détaillées sur le serveur.
- Possibilité d'obtenir des données sur les joueurs et les règles du serveur.
- Système automatique de tentatives pour garantir l'obtention des données.
- Configuration des timeouts pour la connexion et la réponse.
- Fermeture automatique du socket à la fin de l'opération.
- Support de plusieurs langues pour les informations du serveur.
- Limitation personnalisée pour l'affichage des joueurs.

## Installation

Clonez le dépôt sur votre machine locale:

```bash
git clone https://github.com/ocalasans/samp-query-php.git
```

## Utilisation

Incluez le fichier `samp-query.php` dans votre projet et instanciez la classe `samp_query` en passant l'adresse IP et le port du serveur **SA-MP** que vous souhaitez consulter.

### Exemple d'utilisation de base

```php
require 'samp-query.php';

$server = new samp_query('127.0.0.1', 7777);

if ($server->Est_EnLigne()) {
    echo "Le serveur est en ligne !";
    echo "Ping: " . $server->Obtenir_Ping() . " ms";
    
    $info = $server->Obtenir_Informations();
    print_r($info);
    
    $joueurs = $server->Obtenir_Joueurs_0();
    print_r($joueurs);
    
    $regles = $server->Obtenir_Regles();
    print_r($regles);
} else {
    echo "Le serveur est hors ligne.";
}
```

### Exemple avec plusieurs serveurs

```php
require 'samp-query.php';

$serveurs = [
    ['ip' => '127.0.0.1', 'porte' => 7777],
    ['ip' => '192.168.0.1', 'porte' => 7778],
];

foreach ($serveurs as $données) {
    $serveur = new samp_query($données['ip'], $données['porte']);
    
    if ($serveur->Est_EnLigne()) {
        echo "Serveur " . $données['ip'] . ":" . $données['porte'] . " est en ligne !";
        echo "Ping: " . $serveur->Obtenir_Ping() . " ms\n";
    } else {
        echo "Serveur " . $données['ip'] . ":" . $données['porte'] . " est hors ligne.\n";
    }
}
```

## Méthodes Disponibles

### Vérifier si le serveur est en ligne

```php
public function Est_EnLigne()
```

Retourne `true` si le serveur est en ligne, sinon, `false`. La vérification est effectuée en essayant de se connecter au serveur et d'envoyer un paquet initial. Si la connexion échoue, le serveur est considéré comme hors ligne.

### Obtenir le ping du serveur

```php
public function Obtenir_Ping()
```

Retourne le ping du serveur en millisecondes, calculé en fonction du temps nécessaire pour envoyer le paquet et recevoir la réponse. Si le serveur est hors ligne ou si le ping ne peut pas être obtenu, retourne `null`.

### Obtenir les informations du serveur

```php
public function Obtenir_Informations()
```

Retourne un tableau avec les informations de base du serveur, telles que:

- `passworded`: Indique si le serveur est protégé par un mot de passe.
- `players`: Nombre actuel de joueurs.
- `maxplayers`: Nombre maximum de joueurs autorisé.
- `hostname`: Nom du serveur.
- `gamemode`: Mode de jeu du serveur.
- `language`: Langue utilisée sur le serveur.

Cette méthode utilise un système de tentatives automatiques pour garantir que les données sont obtenues correctement.

### Obtenir la liste des joueurs

#### Liste de base

```php
public function Obtenir_Joueurs_0()
```

Retourne un tableau avec la liste des joueurs connectés, contenant `nickname` et `score` (score) de chaque joueur. Cette méthode est appropriée pour obtenir un aperçu général des joueurs connectés.

#### Liste détaillée

```php
public function Obtenir_Joueurs_1()
```

Retourne un tableau avec des informations détaillées sur chaque joueur, y compris `playerid`, `nickname`, `score` et `ping`. Cette méthode fournit des données plus approfondies sur les joueurs connectés.

### Obtenir les règles du serveur

```php
public function Obtenir_Regles()
```

Retourne un tableau avec les règles du serveur, où la clé est le nom de la règle et la valeur est la valeur associée à cette règle. Cette méthode utilise également le système de tentatives pour assurer l'obtention des données.

## Détails techniques

### Système de tentatives

L'API incorpore un système de tentatives (`retryLimit`) qui permet de tenter l'obtention d'informations jusqu'à trois fois avant d'abandonner. Cela augmente la fiabilité, notamment dans les situations où la connexion peut être instable.

### Timeouts configurables

Lors de l'instanciation de la classe `samp_query`, deux types de timeouts sont configurés:

- `timeouts['connect']`: Définit le temps maximum en secondes pour établir une connexion avec le serveur. La valeur par défaut est de 1 seconde.
- `timeouts['response']`: Définit le temps maximum en secondes pour attendre une réponse du serveur après l'envoi d'un paquet. La valeur par défaut est de 120 secondes, ce qui est déjà un temps extrêmement élevé.

Ces timeouts garantissent que l'API ne reste pas indéfiniment en attente d'une réponse, améliorant ainsi son efficacité.

### Construction des paquets

Les paquets de requête au serveur **SA-MP** sont construits manuellement, en utilisant le préfixe `'SAMP'` suivi de l'adresse IP du serveur et du port. En fonction du type d'information demandée (`i`, `c`, `d`, `r`), la commande correspondante est ajoutée au paquet.

### Conversion des données

L'API inclut une méthode privée `toInt()` qui convertit les données binaires reçues du serveur en entiers. Cette méthode garantit que les données sont manipulées correctement, même en cas de grandes valeurs.

```php
private function toInt($data)
```

La méthode utilise des opérations bit à bit pour reconstruire la valeur entière à partir des données binaires, convertissant les quatre parties séparées d'un nombre entier au format original.

## Personnalisations et configurations

### Paramètres avancés de timeout

Il est possible de personnaliser les timeouts lors de l'instanciation de la classe `samp_query`. Par exemple, pour définir le temps maximum de connexion à 5 secondes et le temps de réponse à 60 secondes:

```php
$server = new samp_query('127.0.0.1', 7777);
$server->setTimeouts([
    'connect' => 5,
    'response' => 60
]);
```

### Messages d'erreur et gestion des exceptions

L'API est conçue pour capturer les erreurs et les échecs de connexion, en renvoyant des messages d'erreur clairs en cas d'échec. Par exemple, si un serveur ne peut pas être atteint, l'API renvoie `null` pour des méthodes telles que `Obtenir_Informations()`, `Obtenir_Joueurs_0`, `Obtenir_Joueurs_1` et `Obtenir_Regles()`.

```php
if ($server->Obtenir_Informations() === null) {
    echo "Impossible d'obtenir les informations du serveur.";
}
```

## Informations de contact

Instagram: [ocalasans](https://instagram.com/ocalasans)   
YouTube: [Calasans](https://www.youtube.com/@ocalasans)   
Discord: [Calasans](https://discord.com/users/793520050832932884)   
Communauté: [SA-MP Programming Community](https://abre.ai/samp-spc)

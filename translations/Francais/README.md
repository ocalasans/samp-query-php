# samp-query-php

**samp-query-php** est une **API** en **PHP** développée pour interroger et obtenir des informations des serveurs **SA-MP (San Andreas Multiplayer)**. Cette **API** vous permet de vérifier si un serveur est en ligne, d'obtenir le ping, les informations de base et détaillées sur le serveur, les joueurs connectés et les règles du serveur. L'**API** comprend également un système de tentatives automatiques pour garantir que les données sont obtenues de manière fiable.

### Langues

- Português: [README](../../)
- Deutsch: [README](../Deutsch/README.md)
- English: [README](../English/README.md)
- Español: [README](../Espanol/README.md)
- Italiano: [README](../Italiano/README.md)
- Polski: [README](../Polski/README.md)
- Русский: [README](../Русский/README.md)
- Svenska: [README](../Svenska/README.md)
- Türkçe: [README](../Turkce/README.md)

## Table des matières

- [samp-query-php](#samp-query-php)
    - [Langues](#langues)
  - [Table des matières](#table-des-matières)
  - [Caractéristiques](#caractéristiques)
  - [Installation](#installation)
  - [Utilisation](#utilisation)
    - [Exemple d'utilisation basique](#exemple-dutilisation-basique)
    - [Exemple avec plusieurs serveurs](#exemple-avec-plusieurs-serveurs)
  - [Méthodes disponibles](#méthodes-disponibles)
    - [Vérifier si le serveur est en ligne](#vérifier-si-le-serveur-est-en-ligne)
    - [Obtenir le ping du serveur](#obtenir-le-ping-du-serveur)
    - [Obtenir les informations du serveur](#obtenir-les-informations-du-serveur)
    - [Obtenir la liste des joueurs](#obtenir-la-liste-des-joueurs)
      - [Liste basique](#liste-basique)
      - [Liste détaillée](#liste-détaillée)
    - [Obtenir les règles du serveur](#obtenir-les-règles-du-serveur)
  - [Détails techniques](#détails-techniques)
    - [Système de tentatives](#système-de-tentatives)
    - [Timeouts configurables](#timeouts-configurables)
    - [Construction des paquets](#construction-des-paquets)
    - [Conversion des données](#conversion-des-données)
  - [Personnalisations et configurations](#personnalisations-et-configurations)
    - [Configurations avancées du timeout](#configurations-avancées-du-timeout)
    - [Messages d'erreur et gestion des exceptions](#messages-derreur-et-gestion-des-exceptions)
  - [Licence](#licence)
    - [Conditions](#conditions)

## Caractéristiques

- Interrogation rapide et efficace des serveurs **SA-MP**
- Demande d'informations basiques et détaillées du serveur
- Possibilité d'obtenir des données sur les joueurs et les règles du serveur
- Système de tentatives automatique pour garantir l'obtention des données
- Configuration des timeouts pour la connexion et la réponse
- Fermeture automatique du socket à la fin de l'opération
- Support multilingue pour les informations du serveur
- Limitation personnalisée pour l'affichage des joueurs

## Installation

Clonez le dépôt sur votre machine locale :

```bash
git clone https://github.com/ocalasans/samp-query-php.git
```

## Utilisation

Incluez le fichier `samp_query.php` dans votre projet et instanciez la classe `Samp_Query` en passant l'adresse IP et le port du serveur **SA-MP** que vous souhaitez interroger.

### Exemple d'utilisation basique

```php
require 'samp_query.php';

$server = new Samp_Query('127.0.0.1', 7777);

if ($server->Is_Online()) {
    echo "Le serveur est en ligne !";
    echo "Ping : " . $server->Get_Ping() . " ms";
    
    $info = $server->Get_Information();
    print_r($info);
    
    $players = $server->Get_Players_0();
    print_r($players);
    
    $rules = $server->Get_Rules();
    print_r($rules);
} else {
    echo "Le serveur est hors ligne.";
}
```

### Exemple avec plusieurs serveurs

```php
require 'samp_query.php';

$serveurs = [
    ['ip' => '127.0.0.1', 'port' => 7777],
    ['ip' => '192.168.0.1', 'port' => 7778],
];

foreach ($serveurs as $data) {
    $server = new Samp_Query($data['ip'], $data['port']);
    
    if ($server->Is_Online()) {
        echo "Serveur " . $data['ip'] . ":" . $data['port'] . " est en ligne !";
        echo "Ping : " . $server->Get_Ping() . " ms\n";
    } else {
        echo "Serveur " . $data['ip'] . ":" . $data['port'] . " est hors ligne.\n";
    }
}
```

## Méthodes disponibles

### Vérifier si le serveur est en ligne

```php
public function Is_Online()
```

Retourne `true` si le serveur est en ligne, sinon `false`. La vérification est effectuée en essayant de se connecter au serveur et d'envoyer un paquet initial. Si la connexion échoue, le serveur est considéré comme hors ligne.

### Obtenir le ping du serveur

```php
public function Get_Ping()
```

Retourne le ping du serveur en millisecondes, calculé en fonction du temps nécessaire pour que le paquet soit envoyé et la réponse reçue. Si le serveur est hors ligne ou si le ping ne peut pas être obtenu, retourne `null`.

### Obtenir les informations du serveur

```php
public function Get_Information()
```

Retourne un tableau avec les informations de base du serveur, comme :

- `passworded` : Indique si le serveur est protégé par mot de passe
- `players` : Nombre actuel de joueurs
- `maxplayers` : Nombre maximum de joueurs autorisé
- `hostname` : Nom du serveur
- `gamemode` : Mode de jeu du serveur
- `language` : Langue utilisée sur le serveur

Cette méthode utilise le système de tentatives automatiques pour garantir que les données sont correctement obtenues.

### Obtenir la liste des joueurs

#### Liste basique

```php
public function Get_Players_0()
```

Retourne un tableau avec la liste des joueurs connectés, contenant le `nickname` et le `score` de chaque joueur. Cette méthode est adaptée pour obtenir une vue d'ensemble des joueurs connectés.

#### Liste détaillée

```php
public function Get_Players_1()
```

Retourne un tableau avec des informations détaillées sur chaque joueur, incluant `playerid`, `nickname`, `score` et `ping`. Cette méthode fournit des données plus approfondies sur les joueurs connectés.

### Obtenir les règles du serveur

```php
public function Get_Rules()
```

Retourne un tableau avec les règles du serveur, où la clé est le nom de la règle et la valeur est la valeur associée à cette règle. Cette méthode utilise également le système de tentatives pour assurer l'obtention des données.

## Détails techniques

### Système de tentatives

L'API intègre un système de tentatives (`retry_limit`) qui permet d'essayer d'obtenir des informations jusqu'à trois fois avant d'abandonner. Cela augmente la fiabilité, particulièrement dans des situations où la connexion peut être instable.

### Timeouts configurables

Lors de l'instanciation de la classe `Samp_Query`, deux types de timeouts sont configurés :

- `timeouts['connect']` : Définit le temps maximum en secondes pour établir une connexion avec le serveur. La valeur par défaut est 1 seconde.
- `timeouts['response']` : Définit le temps maximum en secondes pour attendre une réponse du serveur après l'envoi d'un paquet. La valeur par défaut est 120 secondes, ce qui est déjà un temps extrêmement élevé.

Ces timeouts garantissent que l'API ne reste pas indéfiniment en attente d'une réponse, améliorant ainsi l'efficacité.

### Construction des paquets

Les paquets de requête au serveur **SA-MP** sont construits manuellement, en utilisant le préfixe `'SAMP'` suivi de l'adresse IP du serveur et du port. Selon le type d'information demandée (`i`, `c`, `d`, `r`), la commande correspondante est ajoutée au paquet.

### Conversion des données

L'API inclut une méthode privée `To_Int()` qui convertit les données binaires reçues du serveur en entiers. Cette méthode garantit que les données sont manipulées correctement, même dans le cas de grandes valeurs.

```php
private function To_Int($data)
```

La méthode utilise des opérations bit à bit pour reconstruire la valeur entière à partir des données binaires, convertissant les quatre parties séparées d'un nombre entier au format original.

## Personnalisations et configurations

### Configurations avancées du timeout

Il est possible de personnaliser les timeouts au moment de l'instanciation de la classe `Samp_Query`. Par exemple, pour définir le temps maximum de connexion à 5 secondes et le temps de réponse à 60 secondes :

```php
$server = new Samp_Query('127.0.0.1', 7777);
$server->setTimeouts([
    'connect' => 5,
    'response' => 60
]);
```

### Messages d'erreur et gestion des exceptions

L'API est conçue pour capturer les erreurs et les échecs de connexion, retournant des messages d'erreur clairs en cas d'échec. Par exemple, si un serveur ne peut pas être atteint, l'API retourne `null` pour les méthodes comme `Get_Information()` et `Get_Rules()`.

```php
if ($server->Get_Information() === null) {
    echo "Impossible d'obtenir les informations du serveur.";
}
```

## Licence

Cette API est protégée sous la Licence MIT, qui permet :
- ✔️ Utilisation commerciale et privée
- ✔️ Modification du code source
- ✔️ Distribution du code
- ✔️ Sous-licence

### Conditions

- Conserver l'avis de droits d'auteur
- Inclure une copie de la licence MIT

Pour plus de détails sur la licence : https://opensource.org/licenses/MIT

**Copyright (c) Calasans - Tous droits réservés**
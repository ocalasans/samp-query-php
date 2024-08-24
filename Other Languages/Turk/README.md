# samp-query-php

**samp-query-php**, **SA-MP (San Andreas Multiplayer)** sunucularından bilgi almak ve sorgulama yapmak için geliştirilmiş bir **PHP** **API**'sidir. Bu **API**, bir sunucunun çevrimiçi olup olmadığını kontrol etmenizi, ping değerini, sunucu hakkında temel ve ayrıntılı bilgileri, bağlı oyuncuları ve sunucu kurallarını almanızı sağlar. **API** ayrıca verilerin güvenilir bir şekilde elde edilmesini sağlamak için otomatik deneme sistemi içerir.

### 🌐 Diller

- **Português** > [README](https://github.com/ocalasans/samp-query-php) / [Código](https://github.com/ocalasans/samp-query-php/blob/main/samp-query.php).
- **English** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/English) / [Code](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/English/samp-query.php).
- **Español** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Espanol) / [Código](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Espanol/samp-query.php).
- **Polski** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Polski) / [Kod](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Polski/samp-query.php).
- **Deutsch** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Deutsch) / [Code](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Deutsch/samp-query.php).
- **Русский** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Русский) / [Код](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Русский/samp-query.php).
- **Français** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Francais) / [Code](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Francais/samp-query.php).
- **Italiano** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Italiano) / [Codice](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Italiano/samp-query.php).
- **Svensk** > [README](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Svensk) / [Koda](https://github.com/ocalasans/samp-query-php/blob/main/Other%20Languages/Svensk/samp-query.php).

## 📋 Özet
- [samp-query-php](#samp-query-php)
    - [🌐 Diller](#-diller)
  - [📋 Özet](#-özet)
  - [🎯 Özellikler](#-özellikler)
  - [🛠️ Kurulum](#️-kurulum)
  - [🚀 Kullanım](#-kullanım)
    - [Temel kullanım örneği](#temel-kullanım-örneği)
    - [Birden fazla sunucu örneği](#birden-fazla-sunucu-örneği)
  - [🧩 Mevcut Yöntemler](#-mevcut-yöntemler)
    - [Sunucunun çevrimdışı olup olmadığını kontrol etme](#sunucunun-çevrimdışı-olup-olmadığını-kontrol-etme)
    - [Sunucunun ping'ini alma](#sunucunun-pingini-alma)
    - [Sunucu bilgilerini alma](#sunucu-bilgilerini-alma)
    - [Oyuncu listesini alma](#oyuncu-listesini-alma)
      - [Temel Liste](#temel-liste)
      - [Ayrıntılı Liste](#ayrıntılı-liste)
    - [Sunucu kurallarını alma](#sunucu-kurallarını-alma)
  - [🔍 Teknik Detaylar](#-teknik-detaylar)
    - [Deneme Sistemi](#deneme-sistemi)
    - [Yapılandırılabilir Zaman Aşımı](#yapılandırılabilir-zaman-aşımı)
    - [Paket Oluşturma](#paket-oluşturma)
    - [Veri Dönüşümü](#veri-dönüşümü)
  - [🔧 Özelleştirmeler ve Yapılandırmalar](#-özelleştirmeler-ve-yapılandırmalar)
    - [Gelişmiş Zaman Aşımı Ayarları](#gelişmiş-zaman-aşımı-ayarları)
    - [Hata Mesajları ve İstisna Yönetimi](#hata-mesajları-ve-i̇stisna-yönetimi)
  - [ℹ️ İletişim Bilgileri](#ℹ️-i̇letişim-bilgileri)

## 🎯 Özellikler

- Hızlı ve verimli SA-MP sunucu sorgulama.
- Sunucudan temel ve detaylı bilgi alma.
- Oyuncular ve sunucu kuralları hakkında veri elde etme imkanı.
- Verilerin elde edilmesini sağlamak için otomatik deneme sistemi.
- Bağlantı ve yanıt süre aşımı ayarı.
- İşlem bitiminde soketin otomatik kapanması.
- Sunucu bilgileri için çok dilli destek.
- Oyuncu görüntüleme için kişiselleştirilmiş sınır.

## 🛠️ Kurulum

Yerel makinenize depoyu kopyalayın:

```bash
git clone https://github.com/ocalasans/samp-query-php.git
```

## 🚀 Kullanım

Projenize `samp_query.php` dosyasını dahil edin ve sorgulamak istediğiniz SA-MP sunucusunun IP adresini ve portunu belirterek `samp_query` sınıfını örnekleyin.

### Temel kullanım örneği

```php
require 'samp_query.php';

$server = new samp_query('127.0.0.1', 7777);

if ($server->Cevrimici()) {
    echo "Sunucu çevrimiçi!";
    echo "Ping: " . $server->Al_Ping() . " ms";
    
    $info = $server->Al_Bilgiler();
    print_r($info);
    
    $oyuncular = $server->Al_Oyuncular_0();
    print_r($oyuncular);
    
    $kurallar = $server->Al_Kurallar();
    print_r($kurallar);
} else {
    echo "Sunucu çevrimdışıdır.";
}
```

### Birden fazla sunucu örneği

```php
require 'samp_query.php';

$sunucular = [
    ['ip' => '127.0.0.1', 'kapı' => 7777],
    ['ip' => '192.168.0.1', 'kapı' => 7778],
];

foreach ($sunucular as $veri) {
    $server = new samp_query($veri['ip'], $veri['kapı']);
    
    if ($server->Cevrimici()) {
        echo "Sunucu " . $veri['ip'] . ":" . $veri['kapı'] . " çevrimiçi!";
        echo "Ping: " . $server->Al_Ping() . " ms\n";
    } else {
        echo "Sunucu " . $veri['ip'] . ":" . $veri['kapı'] . " çevrimdışıdır.\n";
    }
}
```

## 🧩 Mevcut Yöntemler

### Sunucunun çevrimdışı olup olmadığını kontrol etme

```php
public function Cevrimici()
```

Sunucu çevrimdışıyken `false`, çevrimiçiyken `true` döner. Kontrol, sunucuya bağlanmaya ve bir başlangıç paketi göndermeye çalışılarak yapılır. Bağlantı başarısız olursa, sunucu çevrimdışı olarak kabul edilir.

### Sunucunun ping'ini alma

```php
public function Al_Ping()
```

Paketi göndermek ve cevabı almak için geçen süreye göre sunucunun ping'ini milisaniye cinsinden döner. Sunucu çevrimdışıyken veya ping alınamıyorsa, `null` döner.

### Sunucu bilgilerini alma

```php
public function Al_Bilgiler()
```

Aşağıdaki temel bilgileri içeren bir dizi döner:

- `passworded`: Sunucunun şifreyle korunup korunmadığını belirtir.
- `players`: Mevcut oyuncu sayısı.
- `maxplayers`: İzin verilen maksimum oyuncu sayısı.
- `hostname`: Sunucu adı.
- `gamemode`: Sunucunun oyun modu.
- `language`: Sunucuda kullanılan dil.

Bu yöntem, verilerin doğru şekilde elde edilmesini sağlamak için otomatik deneme sistemini kullanır.

### Oyuncu listesini alma

#### Temel Liste

```php
public function Al_Oyuncular_0()
```

Her oyuncunun `nickname` ve `score` (puan) bilgilerini içeren bağlı oyuncuların listesini döner. Bu yöntem, bağlı oyuncuların genel bir görünümünü almak için uygundur.

#### Ayrıntılı Liste

```php
public function Al_Oyuncular_1()
```

Her oyuncunun `playerid`, `nickname`, `score` ve `ping` bilgilerini içeren ayrıntılı bir dizi döner. Bu yöntem, bağlı oyuncular hakkında daha derinlemesine veriler sağlar.

### Sunucu kurallarını alma

```php
public function Al_Kurallar()
```

Kural adı anahtar ve kuralın değeri ile birlikte sunucu kurallarını içeren bir dizi döner. Bu yöntem, verilerin elde edilmesini sağlamak için deneme sistemini de kullanır.

## 🔍 Teknik Detaylar

### Deneme Sistemi

API, bilgileri elde etmeyi denemek için üç kez deneme yapma imkanı sağlayan bir deneme sistemi (`retryLimit`) içerir. Bu, özellikle bağlantının kararsız olabileceği durumlarda güvenilirliği artırır.

### Yapılandırılabilir Zaman Aşımı

`samp_query` sınıfını örneklerken iki tür zaman aşımı yapılandırılır:

- `timeouts['connect']`: Sunucu ile bağlantı kurmak için geçen maksimum süreyi saniye cinsinden belirler. Varsayılan değer 1 saniyedir.
- `timeouts['response']`: Bir paket gönderildikten sonra sunucudan yanıt beklemek için geçen maksimum süreyi saniye cinsinden belirler. Varsayılan değer 120 saniye olup, bu zaten son derece yüksek bir süredir.

Bu zaman aşımları, API'nin sonsuz süre boyunca yanıt beklemesini engeller, böylece verimliliği artırır.

### Paket Oluşturma

**SA-MP** sunucusuna sorgu paketleri manuel olarak, `'SAMP'` öneki ile sunucunun IP adresi ve portu takip edilerek oluşturulur. İstenen bilgi türüne (`i`, `c`, `d`, `r`) bağlı olarak, ilgili komut pakete eklenir.

### Veri Dönüşümü

API, sunucudan alınan ikili verileri tam sayılara dönüştüren özel bir `toInt()` yöntemi içerir. Bu yöntem, büyük değerlerde bile verilerin doğru şekilde işlenmesini sağlar.

```php
private function toInt($data)
```

Yöntem, dört ayrı tam sayı parçasını orijinal formata dönüştürmek için bit düzeyinde işlemler kullanır.

## 🔧 Özelleştirmeler ve Yapılandırmalar

### Gelişmiş Zaman Aşımı Ayarları

`samp_query` sınıfı örneklenirken zaman aşımını kişiselleştirmek mümkündür. Örneğin, bağlantı süresini 5 saniye ve yanıt süresini 60 saniye olarak ayarlamak için:

```php
$server = new samp_query('127.0.0.1', 7777);
$server->setTimeouts([
    'connect' => 5,
    'response' => 60
]);
```

### Hata Mesajları ve İstisna Yönetimi

API, hataları ve bağlantı kesilmelerini yakalamak üzere tasarlanmıştır ve başarısızlık durumunda açık hata mesajları döndürür. Örneğin, bir sunucuya ulaşılamazsa, API `Al_Bilgiler()`, `Al_Oyuncular_0`, `Al_Oyuncular_1` ve `Al_Kurallar()` gibi yöntemler için `null` döndürür.

```php
if ($server->Al_Bilgiler() === null) {
    echo "Sunucu bilgiler alınamadı.";
}
```

## ℹ️ İletişim Bilgileri

Instagram: [ocalasans](https://instagram.com/ocalasans)   
YouTube: [Calasans](https://www.youtube.com/@ocalasans)   
Discord: [Calasans](https://discord.com/users/793520050832932884)   
Topluluk: [SA-MP Programming Community©](https://abre.ai/samp-spc)

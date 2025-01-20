# samp-query-php

**samp-query-php**, **SA-MP (San Andreas Multiplayer)** sunucularını sorgulamak ve bilgi almak için geliştirilmiş bir **PHP** **API**'sidir. Bu **API**, bir sunucunun çevrimiçi olup olmadığını kontrol etmenizi, ping süresini, sunucu hakkında temel ve detaylı bilgileri, bağlı oyuncuları ve sunucu kurallarını almanızı sağlar. **API** ayrıca verilerin güvenilir bir şekilde alınmasını sağlamak için otomatik deneme sistemi içerir.

### Diller

- Português: [README](../../)
- Deutsch: [README](../Deutsch/README.md)
- English: [README](../English/README.md)
- Español: [README](../Espanol/README.md)
- Français: [README](../Francais/README.md)
- Italiano: [README](../Italiano/README.md)
- Polski: [README](../Polski/README.md)
- Русский: [README](../Русский/README.md)
- Svenska: [README](../Svenska/README.md)

## İçindekiler

- [samp-query-php](#samp-query-php)
    - [Diller](#diller)
  - [İçindekiler](#i̇çindekiler)
  - [Özellikler](#özellikler)
  - [Kurulum](#kurulum)
  - [Kullanım](#kullanım)
    - [Temel Kullanım Örneği](#temel-kullanım-örneği)
    - [Çoklu Sunucu Örneği](#çoklu-sunucu-örneği)
  - [Kullanılabilir Metodlar](#kullanılabilir-metodlar)
    - [Sunucunun Çevrimiçi Olup Olmadığını Kontrol Etme](#sunucunun-çevrimiçi-olup-olmadığını-kontrol-etme)
    - [Sunucu Pingini Alma](#sunucu-pingini-alma)
    - [Sunucu Bilgilerini Alma](#sunucu-bilgilerini-alma)
    - [Oyuncu Listesini Alma](#oyuncu-listesini-alma)
      - [Temel Liste](#temel-liste)
      - [Detaylı Liste](#detaylı-liste)
    - [Sunucu Kurallarını Alma](#sunucu-kurallarını-alma)
  - [Teknik Detaylar](#teknik-detaylar)
    - [Deneme Sistemi](#deneme-sistemi)
    - [Yapılandırılabilir Zaman Aşımları](#yapılandırılabilir-zaman-aşımları)
    - [Paket Oluşturma](#paket-oluşturma)
    - [Veri Dönüşümü](#veri-dönüşümü)
  - [Özelleştirmeler ve Ayarlar](#özelleştirmeler-ve-ayarlar)
    - [Gelişmiş Zaman Aşımı Ayarları](#gelişmiş-zaman-aşımı-ayarları)
    - [Hata Mesajları ve İstisna İşleme](#hata-mesajları-ve-i̇stisna-i̇şleme)
  - [Lisans](#lisans)
    - [Koşullar:](#koşullar)

## Özellikler

- **SA-MP** sunucularını hızlı ve etkili sorgulama
- Sunucu hakkında temel ve detaylı bilgi alma
- Oyuncular ve sunucu kuralları hakkında veri alma imkanı
- Veri almayı garantilemek için otomatik deneme sistemi
- Bağlantı ve yanıt için zaman aşımı yapılandırması
- İşlem sonunda otomatik soket kapatma
- Sunucu bilgileri için çoklu dil desteği
- Özelleştirilebilir oyuncu görüntüleme limiti

## Kurulum

Depoyu yerel makinenize klonlayın:

```bash
git clone https://github.com/ocalasans/samp-query-php.git
```

## Kullanım

Projenize `samp_query.php` dosyasını dahil edin ve sorgulamak istediğiniz **SA-MP** sunucusunun IP adresi ve portunu kullanarak `Samp_Query` sınıfını başlatın.

### Temel Kullanım Örneği

```php
require 'samp_query.php';

$server = new Samp_Query('127.0.0.1', 7777);

if ($server->Is_Online()) {
    echo "Sunucu çevrimiçi!";
    echo "Ping: " . $server->Get_Ping() . " ms";
    
    $info = $server->Get_Information();
    print_r($info);
    
    $players = $server->Get_Players_0();
    print_r($players);
    
    $rules = $server->Get_Rules();
    print_r($rules);
} else {
    echo "Sunucu çevrimdışı.";
}
```

### Çoklu Sunucu Örneği

```php
require 'samp_query.php';

$sunucular = [
    ['ip' => '127.0.0.1', 'port' => 7777],
    ['ip' => '192.168.0.1', 'port' => 7778],
];

foreach ($servers as $data) {
    $server = new Samp_Query($data['ip'], $data['port']);
    
    if ($server->Is_Online()) {
        echo "Sunucu " . $data['ip'] . ":" . $data['port'] . " çevrimiçi!";
        echo "Ping: " . $server->Get_Ping() . " ms\n";
    } else {
        echo "Sunucu " . $data['ip'] . ":" . $data['port'] . " çevrimdışı.\n";
    }
}
```

## Kullanılabilir Metodlar

### Sunucunun Çevrimiçi Olup Olmadığını Kontrol Etme

```php
public function Is_Online()
```

Sunucu çevrimiçiyse `true`, değilse `false` döndürür. Kontrol, sunucuya bağlanmaya çalışarak ve başlangıç paketi göndererek yapılır. Bağlantı başarısız olursa, sunucu çevrimdışı kabul edilir.

### Sunucu Pingini Alma

```php
public function Get_Ping()
```

Sunucunun ping süresini milisaniye cinsinden döndürür. Ping süresi, paketin gönderilmesi ve yanıtın alınması arasında geçen süre baz alınarak hesaplanır. Sunucu çevrimdışıysa veya ping alınamazsa `null` döndürür.

### Sunucu Bilgilerini Alma

```php
public function Get_Information()
```

Sunucu hakkında temel bilgileri içeren bir dizi döndürür:

- `passworded`: Sunucunun şifre korumalı olup olmadığı
- `players`: Mevcut oyuncu sayısı
- `maxplayers`: İzin verilen maksimum oyuncu sayısı
- `hostname`: Sunucu adı
- `gamemode`: Sunucunun oyun modu
- `language`: Sunucuda kullanılan dil

Bu metod, verilerin doğru şekilde alınmasını sağlamak için otomatik deneme sistemini kullanır.

### Oyuncu Listesini Alma

#### Temel Liste

```php
public function Get_Players_0()
```

Bağlı oyuncuların listesini içeren bir dizi döndürür. Her oyuncu için `nickname` ve `score` (puan) bilgilerini içerir. Bu metod, bağlı oyuncuların genel bir görünümünü almak için uygundur.

#### Detaylı Liste

```php
public function Get_Players_1()
```

Her oyuncu hakkında detaylı bilgileri içeren bir dizi döndürür. `playerid`, `nickname`, `score` ve `ping` bilgilerini içerir. Bu metod, bağlı oyuncular hakkında daha derin bilgiler sağlar.

### Sunucu Kurallarını Alma

```php
public function Get_Rules()
```

Sunucu kurallarını içeren bir dizi döndürür. Dizide anahtarlar kural adını, değerler ise kuralın değerini temsil eder. Bu metod da verilerin alınmasını garantilemek için deneme sistemini kullanır.

## Teknik Detaylar

### Deneme Sistemi

API, bilgileri almayı denemek için üç deneme hakkı veren bir sistem (`retry_limit`) içerir. Bu özellikle bağlantının kararsız olabileceği durumlarda güvenilirliği artırır.

### Yapılandırılabilir Zaman Aşımları

`Samp_Query` sınıfı başlatılırken iki tür zaman aşımı yapılandırılır:

- `timeouts['connect']`: Sunucuya bağlanmak için maksimum süreyi saniye cinsinden belirler. Varsayılan değer 1 saniyedir.
- `timeouts['response']`: Bir paket gönderildikten sonra sunucudan yanıt beklemek için maksimum süreyi saniye cinsinden belirler. Varsayılan değer oldukça yüksek olan 120 saniyedir.

Bu zaman aşımları, API'nin sonsuza kadar yanıt beklemesini önleyerek verimliliği artırır.

### Paket Oluşturma

**SA-MP** sunucu sorgu paketleri manuel olarak oluşturulur. `'SAMP'` öneki, sunucunun IP adresi ve portu ile birlikte kullanılır. İstenen bilgi türüne göre (`i`, `c`, `d`, `r`), ilgili komut pakete eklenir.

### Veri Dönüşümü

API, sunucudan alınan ikili verileri tam sayılara dönüştüren özel bir `To_Int()` metodu içerir. Bu metod, özellikle büyük değerler söz konusu olduğunda verilerin doğru şekilde işlenmesini sağlar.

```php
private function To_Int($data)
```

Metod, ikili verilerden tam sayı değerini yeniden oluşturmak için bit işlemleri kullanır ve dört ayrı parçayı orijinal formata dönüştürür.

## Özelleştirmeler ve Ayarlar

### Gelişmiş Zaman Aşımı Ayarları

`Samp_Query` sınıfı başlatılırken zaman aşımı sürelerini özelleştirmek mümkündür. Örneğin, maksimum bağlantı süresini 5 saniye ve yanıt süresini 60 saniye olarak ayarlamak için:

```php
$server = new Samp_Query('127.0.0.1', 7777);
$server->setTimeouts([
    'connect' => 5,
    'response' => 60
]);
```

### Hata Mesajları ve İstisna İşleme

API, bağlantı hatalarını ve başarısızlıklarını yakalayacak şekilde tasarlanmıştır ve hata durumunda açık hata mesajları döndürür. Örneğin, bir sunucuya erişilemezse, API `Get_Information()` ve `Get_Rules()` gibi metodlardan `null` döndürür.

```php
if ($server->Get_Information() === null) {
    echo "Sunucu bilgileri alınamadı.";
}
```

## Lisans

Bu API MIT Lisansı altında korunmaktadır ve şunlara izin verir:
- ✔️ Ticari ve özel kullanım
- ✔️ Kaynak kodunda değişiklik
- ✔️ Kodun dağıtımı
- ✔️ Alt lisanslama

### Koşullar:

- Telif hakkı bildirimini korumak
- MIT lisansının bir kopyasını eklemek

Lisans hakkında daha fazla bilgi için: https://opensource.org/licenses/MIT

**Copyright (c) Calasans - Tüm hakları saklıdır**
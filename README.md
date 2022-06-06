[![License](https://poser.pugx.org/blar/hash/license)](https://packagist.org/packages/blar/hash)
[![Latest Stable Version](https://poser.pugx.org/blar/hash/v/stable)](https://packagist.org/packages/blar/hash)
[![Build Status](https://travis-ci.org/blar/hash.svg?branch=master)](https://travis-ci.org/blar/hash)
[![Coverage Status](https://coveralls.io/repos/blar/hash/badge.svg?branch=master)](https://coveralls.io/r/blar/hash?branch=master)
[![Dependency Status](https://gemnasium.com/blar/hash.svg)](https://gemnasium.com/blar/hash)
[![Flattr](https://button.flattr.com/flattr-badge-large.png)](https://flattr.com/submit/auto?user_id=Blar&url=https%3A%2F%2Fgithub.com%2Fblar%2Fhash)

# Hash

Erstellen und Vergleichen von Hashes.

## Beispiele

### MD5

    $generator = new HashGenerator('MD5');
    $hash = $generator->hash('foobar');

### MD5 mit mehreren Teilen

    $generator = new HashGenerator('MD5');
    $generator->push('foo');
    $generator->push('bar');
    echo $generator->getHash();

### MD5 von einer Datei

    $generator = new HashGenerator('MD5');
    $generator->pushFile('foobar.txt');
    echo $generator->getHash();

### SHA-1

    $generator = new HashGenerator('SHA1');
    $generator->push('foobar');
    echo $generator->getHash();

### SHA-1 mit HMAC

    $generator = new HmacHashGenerator('SHA1', '1337');
    $generator->push('foobar');
    echo $generator->getHash();

### SHA-1 mit HMAC und mehreren Teilen

    $generator = new HmacHashGenerator('SHA1', '1337');
    $generator->push('foo');
    $generator->push('bar');
    echo $generator->getHash();;

### Unterstützte Hash-Algorithmen abrufen

    echo implode(', ', Hash::getAlgos());

Je nach PHP-Version und Betriebsystem können andere Hash-Algorithmen verfügbar sein. Hier eine beispielhafte Ausgabe:

    adler32, crc32, crc32b, fnv132, fnv164, fnv1a32, fnv1a64, gost, gost-crypto,
    haval128,3, haval128,4, haval128,5, haval160,3, haval160,4, haval160,5,
    haval192,3, haval192,4, haval192,5, haval224,3, haval224,4, haval224,5,
    haval256,3, haval256,4, haval256,5, joaat, md2, md4, md5,
    ripemd128, ripemd160, ripemd256, ripemd320,
    sha1, sha224, sha256, sha384, sha512, snefru, snefru256,
    tiger128,3, tiger128,4, tiger160,3, tiger160,4, tiger192,3, tiger192,4, whirlpool

## Installation

### Abhängigkeiten

[Abhängigkeiten von blar/hash auf gemnasium anzeigen](https://gemnasium.com/blar/hash)

### Installation per Composer

    $ composer require blar/hash

### Installation per Git

    $ git clone https://github.com/blar/hash.git
"# blarhash" 

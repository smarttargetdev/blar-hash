<?php

/**
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */

namespace Blar\Hash;

use PHPUnit_Framework_TestCase as TestCase;

class HmacHashTest extends TestCase {

    public function testMd5() {
        $generator = new HmacHashGenerator('md5', '1337');
        $generator->push('Hello World');
        $hash = $generator->getHash();

        $this->assertEquals('53d98cf0aa1b21b7fc2c676a86106221', (string) $hash);
        $this->assertEquals(hash_hmac('md5', 'Hello World', '1337'), (string) $hash);
    }

    public function testSha1() {
        $generator = new HmacHashGenerator('sha1', '1337');
        $generator->push('Hello World');
        $hash = $generator->getHash();

        $this->assertEquals('8f37db8db373c2dc9990873c8d7b72c92bfb201e', (string) $hash);
        $this->assertEquals(hash_hmac('sha1', 'Hello World', '1337'), (string) $hash);
    }

    public function testClone() {
        $generator1 = new HmacHashGenerator('sha1', '1337');
        $generator1->push('foo');
        $hash1 = $generator1->getHash();

        $generator2 = clone $generator1;
        $generator2->push('bar');
        $hash2 = $generator2->getHash();

        $this->assertEquals('c2dc7694d120f7c286e69f896ee15243a5c28cf5', (string) $hash1);
        $this->assertEquals('ea51ab0e6bc7bd5503fc721b7f566abb637ae651', (string) $hash2);
    }

}

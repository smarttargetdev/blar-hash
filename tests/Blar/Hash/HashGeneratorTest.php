<?php

/**
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */

namespace Blar\Hash;

use PHPUnit_Framework_TestCase as TestCase;

class HashGeneratorTest extends TestCase {

    public function testListAlgorithms() {
        $this->assertTrue(is_array(Hash::listAlgorithms()));
    }

    public function testMd5FromString() {
        $generator = new HashGenerator('md5');
        $generator->push('Hello World');
        $hash = $generator->getHash();

        $this->assertEquals('b10a8db164e0754105b7a99be72e3fe5', (string) $hash);
        $this->assertEquals(hex2bin('b10a8db164e0754105b7a99be72e3fe5'), $hash->getValue());
        $this->assertEquals('b10a8db164e0754105b7a99be72e3fe5', $hash->getHexValue());
        $this->assertEquals('{md5}sQqNsWTgdUEFt6mb5y4/5Q==', $hash->getOpensslValue());
    }

    public function testMd5FromFile() {
        $generator = new HashGenerator('md5');
        $generator->pushFile(__DIR__.'/message1.bin');
        $hash1 = $generator->getHash();
        $this->assertEquals('008ee33a9d58b51cfeb425b0959121c9', (string) $hash1);

        $generator = new HashGenerator('md5');
        $generator->pushFile(__DIR__.'/message2.bin');
        $hash2 = $generator->getHash();
        $this->assertEquals('008ee33a9d58b51cfeb425b0959121c9', (string) $hash2);

        $this->assertEquals((string) $hash1, (string) $hash2);
    }

    public function testMd5FromStream() {
        $generator = new HashGenerator('md5');

        $stream = fopen(__DIR__.'/message1.bin', 'r');
        $generator->pushStream($stream);

        $hash = $generator->getHash();

        $this->assertEquals('008ee33a9d58b51cfeb425b0959121c9', (string) $hash);
    }

    public function testSha1FromString() {
        $generator = new HashGenerator('sha1');
        $generator->push('Hello World');
        $hash = $generator->getHash();

        $this->assertEquals('0a4d55a8d778e5022fab701977c5d840bbc486d0', (string) $hash);
        $this->assertEquals('{sha1}Ck1VqNd45QIvq3AZd8XYQLvEhtA=', $hash->getOpensslValue());
    }

    public function testSimpleSha1() {
        $generator = new HashGenerator('sha1');
        $hash = $generator->hash('Hello World');

        $this->assertEquals('0a4d55a8d778e5022fab701977c5d840bbc486d0', (string) $hash);
        $this->assertEquals('{sha1}Ck1VqNd45QIvq3AZd8XYQLvEhtA=', $hash->getOpensslValue());
    }

    public function testClone() {
        $generator1 = new HashGenerator('sha1');
        $generator1->push('foo');
        $hash1 = $generator1->getHash();

        $generator2 = clone $generator1;
        $generator2->push('bar');
        $hash2 = $generator2->getHash();

        $this->assertEquals('0beec7b5ea3f0fdbc95d0dd47f3c5bc275da8a33', (string) $hash1);
        $this->assertEquals('8843d7f92416211de9ebb963ff4ce28125932878', (string) $hash2);
    }


    public function testMd5SecureCompare() {
        $generator = new HashGenerator('md5');
        $generator->pushFile(__DIR__.'/message1.bin');
        $hash1 = $generator->getHash();
        $this->assertEquals('008ee33a9d58b51cfeb425b0959121c9', (string) $hash1);

        $generator = new HashGenerator('md5');
        $generator->pushFile(__DIR__.'/message2.bin');
        $hash2 = $generator->getHash();
        $this->assertEquals('008ee33a9d58b51cfeb425b0959121c9', (string) $hash2);

        $generator = new HashGenerator('md5');
        $generator->push('foobar');
        $hash3 = $generator->getHash();

        $this->assertTrue(Hash::compare($hash1, $hash1));
        $this->assertTrue(Hash::compare($hash1, $hash2));
        $this->assertFalse(Hash::compare($hash1, $hash3));

        $this->assertTrue(Hash::compare($hash2, $hash1));
        $this->assertTrue(Hash::compare($hash2, $hash2));
        $this->assertFalse(Hash::compare($hash2, $hash3));

        $this->assertFalse(Hash::compare($hash3, $hash1));
        $this->assertFalse(Hash::compare($hash3, $hash2));
        $this->assertTrue(Hash::compare($hash3, $hash3));

        $this->assertTrue($hash1->compareTo($hash1));
        $this->assertTrue($hash1->compareTo($hash2));
        $this->assertFalse($hash1->compareTo($hash3));

        $this->assertTrue($hash2->compareTo($hash1));
        $this->assertTrue($hash2->compareTo($hash2));
        $this->assertFalse($hash2->compareTo($hash3));

        $this->assertFalse($hash3->compareTo($hash1));
        $this->assertFalse($hash3->compareTo($hash2));
        $this->assertTrue($hash3->compareTo($hash3));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testUnsupportedAlgorithm() {
        $generator = new HashGenerator('foobar');
    }

}

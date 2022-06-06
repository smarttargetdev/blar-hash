<?php

/**
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */

namespace Blar\Hash;

use PHPUnit_Framework_TestCase as TestCase;

class HashTest extends TestCase {

    public function testConstructor() {
        $hash = new Hash('b10a8db164e0754105b7a99be72e3fe5', 'sha1');
        $this->assertSame('sha1', $hash->getAlgorithm());
        $this->assertSame('b10a8db164e0754105b7a99be72e3fe5', $hash->getHexValue());
    }

    public function testOpensslFormat() {
        $hash = new Hash('{sha1}b10a8db164e0754105b7a99be72e3fe5');
        $this->assertSame('sha1', $hash->getAlgorithm());
        $this->assertSame('b10a8db164e0754105b7a99be72e3fe5', $hash->getHexValue());
    }

}

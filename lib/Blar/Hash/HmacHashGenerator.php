<?php

/**
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */

namespace Blar\Hash;

/**
 * Class HmacHashGenerator
 *
 * @package Blar\Hash
 */
class HmacHashGenerator extends HashGenerator {

    /**
     * @var string
     */
    private $secret = '';

    /**
     * @param string $algorithm
     * @param string $secret
     */
    public function __construct(string $algorithm, string $secret) {
        parent::__construct($algorithm);
        $this->setSecret($secret);
    }

    /**
     * @return resource
     */
    protected function createHandle() {
        return hash_init(
            $this->getAlgorithm(),
            HASH_HMAC,
            $this->getSecret()
        );
    }

    /**
     * @param $string
     *
     * @return Hash
     */
    public function hash(string $string): Hash {
        $hash = new Hash();
        $hash->setAlgorithm($this->getAlgorithm());
        $value = hash_hmac(
            $this->getAlgorithm(),
            $string,
            $this->getSecret(),
            true
        );
        $hash->setValue($value);
        return $hash;
    }

    public function hasSecret(): bool {
        return $this->secret !== '';
    }

    /**
     * @return string
     */
    public function getSecret(): string {
        return $this->secret;
    }

    /**
     * @param string $secret
     */
    protected function setSecret(string $secret) {
        $this->secret = $secret;
    }

}

<?php

/**
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */

namespace Blar\Hash;

use RuntimeException;

/**
 * Class Hash
 *
 * @package Blar\Hash
 */
class Hash {

    /**
     * @var string
     */
    private $algorithm;

    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     *
     * @return bool
     */
    private static function isOpensslFormat(string $value): bool {
        return preg_match('#{(.*?)}(.+)#', $value) === 1;
    }

    /**
     * Hash constructor.
     *
     * @param string $value
     * @param string $algorithm
     */
    public function __construct(string $value = '', string $algorithm = '') {
        if(static::isOpensslFormat($value)) {
            preg_match('#{(.*?)}(.+)#', $value, $matches);
            $algorithm = $matches[1];
            $value = $matches[2];
        }

        $this->setAlgorithm($algorithm);

        if(ctype_xdigit($value)) {
            $this->setHexValue($value);
        }
        else {
            $this->setValue($value);
        }
    }

    /**
     * @return array
     */
    public static function listAlgorithms(): array {
        return hash_algos();
    }

    public static function isSupportedAlgorithm(string $algorithm) {
        return array_search($algorithm, static::listAlgorithms()) !== FALSE;
    }

    /**
     * @return string
     */
    public function __toString(): string {
        return $this->getHexValue();
    }

    /**
     * @param string $value
     */
    public function setHexValue(string $value) {
        $this->setValue(hex2bin($value));
    }

    /**
     * @return string
     */
    public function getHexValue(): string {
        return bin2hex($this->getValue());
    }

    /**
     * @return string
     */
    public function getValue(): string {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value) {
        $this->value = $value;
    }

    /**
     * Compare with another hash.
     * Minimize timing attacks.
     *
     * @param string $hash
     *
     * @return bool
     */
    public function compareTo($hash): bool {
        return static::compare($this, $hash);
    }

    /**
     * Compare to hashes.
     * Minimize timing attacks.
     *
     * @param string $hash1 Known hash
     * @param string $hash2 User hash
     *
     * @return bool
     */
    public static function compare($hash1, $hash2): bool {
        if(!is_string($hash1)) {
            $hash1 = (string) $hash1;
        }
        if(!is_string($hash2)) {
            $hash2 = (string) $hash2;
        }
        return hash_equals($hash1, $hash2);
    }

    /**
     * @return string
     */
    public function getOpensslValue(): string {
        return sprintf(
            '{%s}%s',
            $this->getAlgorithm(),
            base64_encode($this->getValue())
        );
    }

    /**
     * @return string
     */
    public function getAlgorithm(): string {
        return $this->algorithm;
    }

    /**
     * @param string $algorithm
     */
    public function setAlgorithm(string $algorithm) {
        $this->algorithm = $algorithm;
    }

}

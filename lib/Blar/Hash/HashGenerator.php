<?php

/**
 * @author Andreas Treichel <gmblar+github@gmail.com>
 */

namespace Blar\Hash;

use RuntimeException;

/**
 * Class HashGenerator
 *
 * @package Blar\Hash
 */
class HashGenerator {

    /**
     * @var resource
     */
    private $handle;

    /**
     * @var string
     */
    private $algorithm;

    /**
     * @param string $algorithm
     */
    public function __construct(string $algorithm) {
        $this->setAlgorithm($algorithm);
    }

    /**
     * @param $string
     *
     * @return Hash
     */
    public function hash(string $string): Hash {
        $hash = new Hash();
        $hash->setAlgorithm($this->getAlgorithm());
        $value = hash($this->getAlgorithm(), $string, true);
        $hash->setValue($value);
        return $hash;
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
    protected function setAlgorithm(string $algorithm) {
        if(!Hash::isSupportedAlgorithm($algorithm)) {
            $message = sprintf('Algorithm "%s" is not supported', $algorithm);
            throw new RuntimeException($message);
        }
        $this->algorithm = $algorithm;
    }

    /**
     * @return Hash
     */
    public function getHash(): Hash {
        $hash = new Hash();
        $hash->setAlgorithm($this->getAlgorithm());
        $hash->setValue(hash_final(hash_copy($this->getHandle()), true));
        return $hash;
    }

    /**
     * @return resource
     */
    protected function getHandle() {
        if(!$this->handle) {
            $this->handle = $this->createHandle();
        }
        return $this->handle;
    }

    /**
     * @param resource $handle
     */
    protected function setHandle($handle) {
        $this->handle = $handle;
    }

    /**
     * @return resource
     */
    protected function createHandle() {
        return hash_init($this->getAlgorithm());
    }

    public function __clone() {
        $handle = hash_copy($this->getHandle());
        $this->setHandle($handle);
    }

    /**
     * @param string $data
     *
     * @throws RuntimeException
     */
    public function push(string $data) {
        $result = hash_update($this->getHandle(), $data);
        if(!$result) {
            throw new RuntimeException();
        }
    }

    /**
     * @param string $fileName
     */
    public function pushFile(string $fileName) {
        $result = hash_update_file($this->getHandle(), $fileName);
        if(!$result) {
            throw new RuntimeException();
        }
    }

    /**
     * @param resource $stream
     *
     * @throws RuntimeException
     */
    public function pushStream($stream) {
        $result = hash_update_stream($this->getHandle(), $stream);
        if(!$result) {
            throw new RuntimeException();
        }
    }

}

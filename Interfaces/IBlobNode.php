<?php

interface IBlobNode extends INode
{
    /**
     * Get the checksum.
     *
     * @return string
     */
    public function getChecksum(): string;

    /**
     * Set the checksum.
     *
     * @param string $checksum
     */
    public function setChecksum(string $checksum): void;

    /**
     * Get the extension.
     *
     * @return string
     */
    public function getExtension(): string;

    /**
     * Set the extension.
     *
     * @param string $extension
     */
    public function setExtension(string $extension): void;

    /**
     * Determine if it is a blob.
     *
     * @return bool
     */
    public function isBlob(): bool;

    /**
     * Set whether it is a blob.
     *
     * @param bool $isBlob
     */
    public function setIsBlob(bool $isBlob): void;

    /**
     * Get the length.
     *
     * @return int
     */
    public function getLength(): int;

    /**
     * Set the length.
     *
     * @param int $length
     */
    public function setLength(int $length): void;

    /**
     * Get the name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Set the name.
     *
     * @param string $name
     */
    public function setName(string $name): void;

    /**
     * Get the URL.
     *
     * @return string
     */
    public function getUrl(): string;

    /**
     * Set the URL.
     *
     * @param string $url
     */
    public function setUrl(string $url): void;
}

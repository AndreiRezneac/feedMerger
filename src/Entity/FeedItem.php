<?php


namespace App\Entity;


use DateTimeInterface;

class FeedItem
{
    /** @var string */
    private $title;

    /** @var string */
    private $webUrl;

    /** @var string */
    private $pictureUrl;

    /** @var DateTimeInterface */
    private $publishedAt;

    public function __construct(string $title, string $webUrl, string $pictureUrl, DateTimeInterface $publishedAt)
    {
        $this->title = $title;
        $this->webUrl = $webUrl;
        $this->pictureUrl = $pictureUrl;
        $this->publishedAt = $publishedAt;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getWebUrl(): string
    {
        return $this->webUrl;
    }

    public function getPictureUrl(): string
    {
        return $this->pictureUrl;
    }

    public function getPublishedAt(): DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function toJson(): string {
        return sprintf(
            '{"title":"%s","webUrl":"%s","pictureUrl":"%s","publishedAt":"%s"}',
            $this->title,
            $this->webUrl,
            $this->pictureUrl,
            $this->publishedAt->format(DATE_ISO8601)
        );
    }
}
<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class Response extends BaseObject
{
    protected int|null $statusCode = null;
    protected string|null $description = null;

    /** @var Header[]|null */
    protected array|null $headers = null;

    /** @var MediaType[]|null */
    protected array|null $content = null;

    /** @var Link[]|null */
    protected array|null $links = null;

    public static function ok(string|null $objectId = null): static
    {
        return static::create($objectId)
            ->statusCode(200)
            ->description('OK');
    }

    public function description(string|null $description): static
    {
        $instance = clone $this;

        $instance->description = $description;

        return $instance;
    }

    public function statusCode(int|null $statusCode): static
    {
        $instance = clone $this;

        $instance->statusCode = $statusCode;

        return $instance;
    }

    public static function created(string|null $objectId = null): static
    {
        return static::create($objectId)
            ->statusCode(201)
            ->description('Created');
    }

    public static function movedPermanently(string|null $objectId = null): static
    {
        return static::create($objectId)
            ->statusCode(301)
            ->description('Moved Permanently');
    }

    public static function movedTemporarily(string|null $objectId = null): static
    {
        return static::create($objectId)
            ->statusCode(302)
            ->description('Moved Temporarily');
    }

    public static function badRequest(string|null $objectId = null): static
    {
        return static::create($objectId)
            ->statusCode(400)
            ->description('Bad Request');
    }

    public static function unauthorized(string|null $objectId = null): static
    {
        return static::create($objectId)
            ->statusCode(401)
            ->description('Unauthorized');
    }

    public static function forbidden(string|null $objectId = null): static
    {
        return static::create($objectId)
            ->statusCode(403)
            ->description('Forbidden');
    }

    public static function notFound(string|null $objectId = null): static
    {
        return static::create($objectId)
            ->statusCode(404)
            ->description('Not Found');
    }

    public static function unprocessableEntity(string|null $objectId = null): static
    {
        return static::create($objectId)
            ->statusCode(422)
            ->description('Unprocessable Entity');
    }

    public static function tooManyRequests(string|null $objectId = null): static
    {
        return static::create($objectId)
            ->statusCode(429)
            ->description('Too Many Requests');
    }

    public static function internalServerError(string|null $objectId = null): static
    {
        return static::create($objectId)
            ->statusCode(500)
            ->description('Internal Server Error');
    }

    public function headers(Header ...$header): static
    {
        $instance = clone $this;

        $instance->headers = [] !== $header ? $header : null;

        return $instance;
    }

    public function content(MediaType ...$mediaType): static
    {
        $instance = clone $this;

        $instance->content = [] !== $mediaType ? $mediaType : null;

        return $instance;
    }

    public function links(Link ...$link): static
    {
        $instance = clone $this;

        $instance->links = [] !== $link ? $link : null;

        return $instance;
    }

    protected function generate(): array
    {
        $headers = [];
        foreach ($this->headers ?? [] as $header) {
            $headers[$header->objectId] = $header;
        }

        $content = [];
        foreach ($this->content ?? [] as $contentItem) {
            $content[$contentItem->mediaType] = $contentItem;
        }

        $links = [];
        foreach ($this->links ?? [] as $link) {
            $links[$link->objectId] = $link;
        }

        return Arr::filter([
            'description' => $this->description,
            'headers' => [] !== $headers ? $headers : null,
            'content' => [] !== $content ? $content : null,
            'links' => [] !== $links ? $links : null,
        ]);
    }
}

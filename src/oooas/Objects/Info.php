<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class Info extends BaseObject
{
    protected string|null $title = null;
    protected string|null $description = null;
    protected string|null $termsOfService = null;
    protected Contact|null $contact = null;
    protected License|null $license = null;
    protected string|null $version = null;

    public function title(string|null $title): static
    {
        $instance = clone $this;

        $instance->title = $title;

        return $instance;
    }

    public function description(string|null $description): static
    {
        $instance = clone $this;

        $instance->description = $description;

        return $instance;
    }

    public function termsOfService(string|null $termsOfService): static
    {
        $instance = clone $this;

        $instance->termsOfService = $termsOfService;

        return $instance;
    }

    public function contact(Contact|null $contact): static
    {
        $instance = clone $this;

        $instance->contact = $contact;

        return $instance;
    }

    public function license(License|null $license): static
    {
        $instance = clone $this;

        $instance->license = $license;

        return $instance;
    }

    public function version(string|null $version): static
    {
        $instance = clone $this;

        $instance->version = $version;

        return $instance;
    }

    protected function generate(): array
    {
        return Arr::filter([
            'title' => $this->title,
            'description' => $this->description,
            'termsOfService' => $this->termsOfService,
            'contact' => $this->contact,
            'license' => $this->license,
            'version' => $this->version,
        ]);
    }
}

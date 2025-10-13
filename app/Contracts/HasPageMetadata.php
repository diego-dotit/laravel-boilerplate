<?php

namespace App\Contracts;

interface HasPageMetadata
{
    public function getTitle(): string;
    public function getBreadcrumb(): array;
}

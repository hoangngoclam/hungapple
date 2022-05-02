<?php

namespace App\Services;

use DateTimeInterface;
use Illuminate\Support\Facades\URL;
use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;

class MediaUrlGeneratorService extends DefaultUrlGenerator
{
    public function getTemporaryUrl(DateTimeInterface $expiration, array $options = []): string
    {
        return URL::temporarySignedRoute(
            'private-storage',
            $expiration,
            ['media' => $this->media, 'filename' => $this->media]
        );
    }
}

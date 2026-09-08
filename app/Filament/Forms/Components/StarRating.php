<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class StarRating extends Field
{
    protected string $view = 'filament.forms.components.star-rating';

    protected int $maxStars = 5;

    public function maxStars(int $stars): static
    {
        $this->maxStars = $stars;

        return $this;
    }

    public function getMaxStars(): int
    {
        return $this->maxStars;
    }
}
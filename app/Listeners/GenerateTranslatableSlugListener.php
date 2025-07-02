<?php

namespace App\Listeners;

use App\Enums\LanguageEnum;
use App\Interfaces\Events\TranslatableSlugGenerationEventInterface;
use App\Interfaces\Models\HasTranslatableSlugInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

readonly class GenerateTranslatableSlugListener
{
    public function handle(TranslatableSlugGenerationEventInterface $event): void
    {
        /** @var HasTranslatableSlugInterface|Model $record */
        $record = $event->getRecord();

        foreach (LanguageEnum::cases() as $language) {
            $record->setTranslation(
                'slug',
                $language->value,
                Str::slug(
                    sprintf(
                        '%s-%d',
                        Str::limit(
                            $record->translate(
                                $record->getFieldNameForSlug(),
                                in_array(
                                    $language->value,
                                    $this->ignoredLanguages(),
                                    true
                                ) ? LanguageEnum::EN->value : $language->value
                            ),
                            50
                        ),
                        $record->getKey()
                    )
                )
            );
        }

        $record->saveQuietly();
    }

    private function ignoredLanguages(): array
    {
        return [];
    }
}

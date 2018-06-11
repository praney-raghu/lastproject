<?php

namespace Ssntpl\Neev;

// use Spatie\TranslationLoader\LanguageLine;
use Ssntpl\Neev\LanguageLine;
use Spatie\TranslationLoader\Exceptions\InvalidConfiguration;
use Spatie\TranslationLoader\TranslationLoaders\TranslationLoader;

class Db implements TranslationLoader
{
    public function loadTranslations(string $locale, string $group) : array
    {
        $model = $this->getConfiguredModelClass();

        return $model::getTranslationsForGroup($locale, $group);
    }

    protected function getConfiguredModelClass() : string
    {
        $modelClass = config('translation-loader.model');

        // if (!is_a(new $modelClass, LanguageLine::class)) {
        //     throw InvalidConfiguration::invalidModel($modelClass);
        // }

        return $modelClass;
    }
}

<?php

namespace Modules\Setting\Support;

use Modules\Setting\Contracts\Setting;
use Modules\Setting\Repositories\SettingRepository;

class Settings implements Setting
{
    /**
     * @var SettingRepository
     */
    private SettingRepository $setting;

    /**
     * @param SettingRepository $setting
     */
    public function __construct(SettingRepository $setting)
    {
        $this->setting = $setting;
    }

    /**
     * Get the specified configuration value in the given language
     *
     * @param string $name
     * @param string|null $locale
     * @param mixed $default
     * @return string
     */
    public function get(string $name, string $locale = null, $default = null): string
    {
        $defaultFromConfig = $this->getDefaultFromConfigFor($name);

        $setting = $this->setting->findByName($name);
        if ($setting === null) {
            return is_null($default) ? $defaultFromConfig : $default;
        }

        if($setting->isMedia() && $media = $setting->files()->first()) {
            return $media->path;
        }

        if ($setting->isTranslatable) {
            if ($setting->hasTranslation($locale)) {
                return trim($setting->translate($locale)->value) === '' ? $defaultFromConfig : $setting->translate($locale)->value;
            }
        } else {
            return trim($setting->plainValue) === '' ? $defaultFromConfig : $setting->plainValue;
        }

        return $defaultFromConfig;
    }

    /**
     * Determine if the given configuration value exists.
     *
     * @param  string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        $default = microtime(true);

        return $this->get($name, null, $default) !== $default;
    }

    /**
     * Set a given configuration value.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return \Modules\Setting\Entities\Setting
     */
    public function set(string $key, mixed $value): \Modules\Setting\Entities\Setting
    {
        return $this->setting->create([
            'name' => $key,
            'plainValue' => $value,
        ]);
    }

    /**
     * Get the default value from the settings configuration file,
     * for the given setting name.
     * @param string $name
     * @return string
     */
    private function getDefaultFromConfigFor(string $name): string
    {
        list($module, $settingName) = explode('::', $name);

        return config("encore.$module.settings.$settingName.default", '');
    }
}

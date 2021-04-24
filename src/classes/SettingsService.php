<?php

namespace CryptoCore\Classes;

use CryptoCore\Models\Setting;

trait SettingsService
{
    public function getAllSettings(): array
    {
        return Setting::all();
    }

    public function get(String $key): Setting
    {
        return Setting::where("key", $key)->first() ?? null;
    }

    public function isExist(String $key): bool
    {
        return $this->get($key) != null;
    }


    public function put(String $key, String $value)
    {
        if ($this->isExist($key)) {
            $setting = $this->get($key);
            $setting->value = $value;
            $setting->save();
            return;
        }

        Setting::create([
            "key" => $key,
            "value" => $value
        ]);
    }
}

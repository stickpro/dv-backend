<?php

namespace App\Container;

use App\Models\Setting;
use App\Models\Settings\BaseSetting;
use App\Models\Traits\HasSettings;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class SettingsContainer
{
    /**
     * @var bool
     */
    protected bool $isScoped = false;

    /**
     * @var bool
     */
    protected bool $isGlobalScoped = false;

    /**
     * @var Model|null
     */
    protected ?Model $scopedModel = null;

    /**
     * @var string
     */
    protected string $scopedClass = '';

    /**
     * @var Collection|null
     */
    protected ?Collection $cachedSettings = null;

    /**
     * @var Collection|null
     */
    protected ?Collection $cachedSettingsWithDefaults = null;

    /**
     * @var bool
     */
    protected bool $cacheSettings = true;

    /**
     * @param Model|null $scopeModel
     * @param bool $isGlobalScoped
     * @throws \Exception
     */
    public function __construct(?Model $scopeModel = null, bool $isGlobalScoped = false)
    {
        if ($scopeModel !== null) {
            $this->checkMethods($scopeModel);
            $this->isScoped = true;
            $this->isGlobalScoped = $isGlobalScoped;
            $this->scopedModel = $scopeModel;
            $this->scopedClass = get_class($scopeModel);
        }
    }

    /**
     * @param Model $scopeModel
     * @return void
     * @throws \ReflectionException
     */
    protected function checkMethods(Model $scopeModel): void
    {
        if (!in_array(
            HasSettings::class,
            array_keys((new \ReflectionClass($scopeModel::class))->getTraits())
        )) {
            throw new \Exception('Model ' . get_class($scopeModel) . ' have to use ' . HasSettings::class . ' trait');
        }

        if (!is_array($scopeModel::getSettingsDefinitions())) {
            throw new \Exception('Model ' . get_class($scopeModel) . '::getSettingsDefinitions has to return array');
        }
    }

    /**
     * @return array
     */
    protected function getDefinitions(): array
    {
        if (!$this->isScoped) {
            return Setting::getGlobalSettingsDefinitions();
        }

        return $this->scopedClass::getSettingsDefinitions();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function getDefaults(): \Illuminate\Support\Collection
    {
        $settings = [];

        foreach ($this->getDefinitions() as $definition) {
            $settings[] = new Setting([
                'model_id'   => null,
                'model_type' => $this->isScoped ? $this->scopedClass : null,
                'name'       => $definition['name'],
                'value'      => $definition['default'] ?? null,
            ]);
        }

        return collect($settings);
    }

    /**
     * @param Collection $collection
     * @return Collection
     */
    protected function appendDefaults(Collection $collection): Collection
    {
        foreach ($this->getDefaults() as $default) {
            if ($collection->where('name', $default->name)->first()) {
                continue;
            }

            $collection->add($default);
        }

        return $collection;
    }

    /**
     * @return void
     */
    public function clearCache(): void
    {
        $this->cachedSettings = null;
        $this->cachedSettingsWithDefaults = null;
    }

    /**
     * @return void
     */
    protected function clearCachedDefaults(): void
    {
        $this->cachedSettingsWithDefaults = null;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function isValidSettingName(string $name): bool
    {
        foreach ($this->getDefinitions() as $definition) {
            if ($definition['name'] === $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return bool
     */
    public function isValidSettingValue(string $name, mixed $value): bool
    {
        $options = $this->getSettingOptions($name);

        if (!empty($options)) {
            return in_array($value, $options);
        }

        return true;
    }

    /**
     * @param Model|null $model
     * @return bool
     */
    public function isScopedTo(?Model $model = null): bool
    {
        return $model && $this?->scopedModel === $model;
    }


    /**
     * @param string $name
     * @return array
     */
    public function getSettingOptions(string $name): array
    {
        foreach ($this->getDefinitions() as $definition) {
            if ($definition['name'] === $name && isset($definition['options'])) {
                return $definition['options'];
            }
        }

        return [];
    }

    /**
     * @param string $name
     * @return Setting|null
     * @throws \Exception
     */
    public function setting(string $name): ?Setting
    {
        if (!$this->isValidSettingName($name)) {
            if ($this->isScoped) {
                throw new \Exception($this->scopedClass . ' setting definition does not exists for "' . $name . '"');
            } else {
                throw new \Exception('Global setting definition does not exists for "' . $name . '"');
            }
        }

        if ($this->cacheSettings) {
            $this->all();

            return $this->cachedSettings
                ->where('name', $name)
                ->first();
        }

        if ($this->isScoped) {
            return Setting::where('model_id', $this->scopedModel->id)
                ->where('model_type', $this->scopedClass)
                ->where('name', $name)
                ->first();
        }

        return Setting::whereNull('model_id')
            ->whereNull('model_type')
            ->where('name', $name)
            ->first();
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        if ($this->cacheSettings && $this->cachedSettings) {
            return $this->cachedSettings;
        }

        if ($this->isScoped) {
            $this->cachedSettings = Setting::where('model_id', $this->scopedModel->id)
                ->where('model_type', $this->scopedClass)
                ->get();

            return $this->cachedSettings;
        }

        $this->cachedSettings = Setting::whereNull('model_id')
            ->whereNull('model_type')
            ->get();

        return $this->cachedSettings;
    }

    /**
     * @return Collection
     */
    public function allWithDefaults(): Collection
    {
        if ($this->cacheSettings && $this->cachedSettingsWithDefaults) {
            return $this->cachedSettingsWithDefaults;
        }

        $this->cachedSettingsWithDefaults = $this->appendDefaults($this->all());

        return $this->cachedSettingsWithDefaults;
    }

    /**
     * @return $this
     */
    public function noCache(): SettingsContainer
    {
        $this->cacheSettings = false;

        return $this;
    }

    /**
     * @return $this
     */
    public function cache(): SettingsContainer
    {
        $this->cacheSettings = true;

        return $this;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return Setting
     * @throws \Exception
     */
    public function set(string $name, mixed $value): Setting
    {
        $setting = $this->setting($name);

        if (!$this->isValidSettingValue($name, $value)) {
            throw new \Exception('Invalid setting value for "' . $name . '"');
        }

        if ($setting) {
            $setting->value = $value;
            $setting->save();
        } else {
            $setting = Setting::create([
                'model_id'   => $this->isScoped ? $this->scopedModel->id : null,
                'model_type' => $this->isScoped ? $this->scopedClass : null,
                'name'       => $name,
                'value'      => $value,
            ]);

            if ($this->cacheSettings && $this->cachedSettings) {
                $this->cachedSettings->add($setting);
                $this->clearCachedDefaults();
            }
        }

        return $setting;
    }

    /**
     * @param string $name
     * @param mixed|null $default
     * @param bool $returnDefaultCast
     * @return mixed
     * @throws \Exception
     */
    public function get(string $name, mixed $default = null, bool $returnDefaultCast = true): mixed
    {
        $setting = $this->setting($name);
        $settingDefinition = [];

        foreach ($this->getDefinitions() as $definition) {
            if ($definition['name'] === $name) {
                $settingDefinition = $definition;

                break;
            }
        }

        if ($setting?->id === null) {
            if ($returnDefaultCast
                && !empty($settingDefinition['cast'])
                && is_subclass_of($settingDefinition['cast'], BaseSetting::class)
            ) {
                $setting = new Setting([
                    'model_id'        => null,
                    'model_type_type' => $this->isScoped ? $this->scopedClass : null,
                    'name'            => $settingDefinition['name'],
                    'value'           => $settingDefinition['default'] ?? null,
                ]);

                return $setting->value;
            }

            return $default ?: $settingDefinition['default'] ?? null;
        }

        return $setting->value;
    }

}
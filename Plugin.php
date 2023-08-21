<?php namespace Wpjscc\Json;

use Backend;
use Backend\Models\UserRole;
use System\Classes\PluginBase;

/**
 * json Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     */
    public function pluginDetails(): array
    {
        return [
            'name'        => 'wpjscc.json::lang.plugin.name',
            'description' => 'wpjscc.json::lang.plugin.description',
            'author'      => 'wpjscc',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     */
    public function register(): void
    {
        $this->app->singleton('json', fn () => new \Wpjscc\Json\Services\Json());
    }

    /**
     * Boot method, called right before the request route.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->registerCommands();
        }
    }

    public function registerCommands()
    {
        $this->commands([
            \Wpjscc\Json\Console\TestJson::class,
       
        ]);
    }

    /**
     * Registers any frontend components implemented in this plugin.
     */
    public function registerComponents(): array
    {
        return []; // Remove this line to activate

        return [
            'Wpjscc\Json\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any backend permissions used by this plugin.
     */
    public function registerPermissions(): array
    {
        return []; // Remove this line to activate

        return [
            'wpjscc.json.some_permission' => [
                'tab' => 'wpjscc.json::lang.plugin.name',
                'label' => 'wpjscc.json::lang.permissions.some_permission',
                'roles' => [UserRole::CODE_DEVELOPER, UserRole::CODE_PUBLISHER],
            ],
        ];
    }

    /**
     * Registers backend navigation items for this plugin.
     */
    public function registerNavigation(): array
    {
        return []; // Remove this line to activate

        return [
            'json' => [
                'label'       => 'wpjscc.json::lang.plugin.name',
                'url'         => Backend::url('wpjscc/json/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['wpjscc.json.*'],
                'order'       => 500,
            ],
        ];
    }
}

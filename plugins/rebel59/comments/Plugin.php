<?php namespace Rebel59\Comments;

use Backend;
use Rebel59\Comments\Models\Settings;
use System\Classes\PluginBase;
use System\Classes\PluginManager;

/**
 * comments Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'rebel59.comments::lang.plugin.title',
            'description' => 'rebel59.comments::lang.plugin.description',
            'author'      => 'rebel59',
            'icon'        => 'icon-comments'
        ];
    }

    public $relations = [];
    /**
     * @var array Plugin dependencies
     */
    public $require = ['RainLab.User'];

    /**
     * Boot method, called right before the request route.
     *
     * Retrieves the repeater fields from the settings model to establish relations for
     * the models.
     *
     * @return array
     */
    public function boot()
    {
        if($this->relations = Settings::get('relations'))
        {
            foreach($this->relations as $relation){
                if(PluginManager::instance()->hasPlugin($relation['plugin']))
                {
                    $this->relation = $relation;

                    $relation['model']::extend(function($model) {

                        $condition = addslashes($this->relation['model']);
                        $model->hasMany['comments'] = [
                            'Rebel59\Comments\Models\Comment',
                            'key' => 'attachment_id',
                            'conditions' => 'attachment_type = "' . $condition .'"'
                        ];

                    });
                }
            }
        }

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Rebel59\Comments\Components\Comments' => 'comments',
            'Rebel59\Comments\Components\Unsubscribe' => 'unsubscribe',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'rebel59.comments.manage_settings' => [
                'tab' => 'comments',
                'label' => 'Manage Settings'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'comments' => [
                'label'       => 'rebel59.comments::lang.plugin.title',
                'url'         => Backend::url('rebel59/comments/comments'),
                'icon'        => 'icon-comments',
                'permissions' => ['rebel59.comments.*'],
                'order'       => 500,
            ],
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'rebel59.comments::lang.plugin.settings_name',
                'description' => 'rebel59.comments::lang.plugin.settings_description',
                'category'    => 'Comments',
                'icon'        => 'icon-comments',
                'class'       => 'Rebel59\Comments\Models\Settings',
                'order'       => 500,
                'keywords'    => 'comments',
                'permissions' => ['rebel59.comments.manage_settings']
            ]
        ];
    }

    public function registerMailTemplates()
    {
        return [
            'rebel59.comments::notifications.reply' => 'Notification mail sent to users when a new reply is made.',
        ];
    }
}

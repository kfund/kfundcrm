<?php
namespace Rebel59\Comments\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'rebel59_comments_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';
}
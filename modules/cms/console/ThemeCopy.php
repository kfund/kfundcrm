<?php namespace Cms\Console;

use Cms\Classes\ThemeManager;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * ThemeCopy will duplicate a specified theme
 *
 * theme:copy theme-name new-theme-name
 *
 * @package october\system
 * @author Alexey Bobkov, Samuel Georges
 */
class ThemeCopy extends Command
{
    /**
     * @var string name of console command
     */
    protected $name = 'theme:copy';

    /**
     * @var string description of the console command
     */
    protected $description = 'Duplicates an existing theme';

    /**
     * handle executes the console command
     */
    public function handle()
    {
        $sourceCode = $this->argument('name');
        $targetCode = $this->argument('new-name') ?: $sourceCode.'-copy';

        $this->output->writeln("<info>Duplicating Theme [${sourceCode}] to [${targetCode}]...</info>");

        $manager = ThemeManager::instance();

        if ($this->option('child')) {
            $result = $manager->createChildTheme($sourceCode, $targetCode);
        }
        else {
            $result = $manager->duplicateTheme($sourceCode, $targetCode);
        }

        if ($result) {
            $this->output->success("Theme '${targetCode}' duplicated");
        }
        else {
            $this->output->error("Theme '${targetCode}' already exists");
        }
    }

    /**
     * getArguments get the console command arguments
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the theme (directory name) to duplicate.'],
            ['new-name', InputArgument::OPTIONAL, 'The desired name for the the new theme (directory name).'],
        ];
    }

    /**
     * getOptions get the console command options
     */
    protected function getOptions()
    {
        return [
            ['child', 'c', InputOption::VALUE_NONE, 'Create a child theme.'],
        ];
    }
}

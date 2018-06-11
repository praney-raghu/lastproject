<?php

namespace Ssntpl\Neev\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;

class NeevInit extends Command
{
    use DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'neev:init {--views : Only scaffold the neev views}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Neev scaffolding files.';

    protected $views = [
        'emails/invite.blade.php' => 'teamwork/emails/invite.blade.php',
        'members/list.blade.php' => 'teamwork/members/list.blade.php',
        'create.blade.php' => 'teamwork/create.blade.php',
        'edit.blade.php' => 'teamwork/edit.blade.php',
        'index.blade.php' => 'teamwork/index.blade.php',
    ];

    protected $directories = [
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $this->createDirectories();

        // $this->exportViews();

        // if (! $this->option('views')) {
        //     $this->info('Installed TeamController.');
        //     file_put_contents(
        //         app_path('Http/Controllers/Teamwork/TeamController.php'),
        //         $this->compileControllerStub('TeamController')
        //     );

        //     $this->info('Installed TeamMemberController.');
        //     file_put_contents(
        //         app_path('Http/Controllers/Teamwork/TeamMemberController.php'),
        //         $this->compileControllerStub('TeamMemberController')
        //     );

        //     $this->info('Installed AuthController.');
        //     file_put_contents(
        //         app_path('Http/Controllers/Teamwork/AuthController.php'),
        //         $this->compileControllerStub('AuthController')
        //     );

        //     $this->info('Installed JoinTeamListener');
        //     file_put_contents(
        //         app_path('Listeners/Teamwork/JoinTeamListener.php'),
        //         str_replace(
        //             '{{namespace}}',
        //             $this->getAppNamespace(),
        //             file_get_contents(__DIR__ . '/../../../stubs/listeners/JoinTeamListener.stub')
        //         )
        //     );

        // $this->info('Updated Routes File.');
        // file_put_contents(
        //    // app_path('Http/routes.php'),
        //    base_path('routes/web.php'),
        //     file_get_contents(__DIR__.'/../stubs/routes.stub'),
        //     FILE_APPEND
        // );
        // }

        // if ($this->updateRedirectIfAuthenticatedMiddleware()) {
        //     $this->line('Updated redirectIfAuthenticated middleware.');
        // } else {
        //     $this->error('Failed to update redirectIfAuthenticated middleware.');
        // }

        // if ($this->updateUnauthenticatedExceptionHandler()) {
        //     $this->line('Updated unauthenticated() method in app/Exceptions/Handler.php file.');
        // } else {
        //     $this->error('Failed to update unauthenticated() method in app/Exceptions/Handler.php file.');
        // }

        $this->comment('Neev installation completed successfully.');
    }

    protected function updateRedirectIfAuthenticatedMiddleware()
    {
        $file_path = app_path('Http/Middleware/RedirectIfAuthenticated.php');
        $str_to_insert = file_get_contents(__DIR__ . '/../stubs/RedirectIfAuthenticated.stub');
        $in_block = 'public function handle';

        return $this->insertTextToFile($file_path, $str_to_insert, $in_block);
    }

    protected function updateUnauthenticatedExceptionHandler()
    {
        $file_path = app_path('Exceptions/Handler.php');
        $str_to_insert = file_get_contents(__DIR__ . '/../stubs/UnauthenticatedExceptionHandler.stub');
        $in_block = 'class Handler extends ExceptionHandler';

        return $this->insertTextToFile($file_path, $str_to_insert, $in_block);
    }

    protected function insertTextToFile($file_path, $text, $in_block = null)
    {
        if (is_null($in_block) || $in_block == '') {
            file_put_contents($file_path, $text, FILE_APPEND);
            return true;
        }

        $flag = false;
        $f = fopen($file_path, 'r+');
        $oldstr = file_get_contents($file_path);

        // read lines with fgets() until you have reached the right one
        //insert the line and than write in the file.
        while (($buffer = fgets($f)) !== false) {
            if (strpos($buffer, $in_block) !== false) {
                if (strpos($buffer, '{') === false) {
                    $buffer = fgets($f);
                }
                $pos = ftell($f);
                $newstr = substr_replace($oldstr, $text, $pos, 0);
                file_put_contents($file_path, $newstr);
                $flag = true;
                break;
            }
        }
        fclose($f);
        return $flag;
    }

    /**
     * Create the directories for the files.
     *
     * @return void
     */
    protected function createDirectories()
    {
        foreach ($this->directories as $directory) {
            if (!is_dir($directory)) {
                mkdir(app_path($directory), 0755, true);
            }
        }
    }

    /**
     * Export the authentication views.
     *
     * @return void
     */
    protected function exportViews()
    {
        foreach ($this->views as $key => $value) {
            $path = base_path('resources/views/' . $value);
            $this->line('<info>Created View:</info> ' . $path);
            copy(__DIR__ . '/../stubs/views/' . $key, $path);
        }
    }

    /**
     * Compiles the HTTP controller stubs.
     *
     * @param $stubName
     * @return string
     */
    protected function compileControllerStub($stubName)
    {
        return str_replace(
            '{{namespace}}',
            $this->getAppNamespace(),
            file_get_contents(__DIR__ . '/../stubs/controllers/' . $stubName . '.stub')
        );
    }
}

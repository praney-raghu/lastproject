<?php

namespace Ssntpl\Neev;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Ssntpl\Neev\Http\Middleware\CheckNeev as CheckNeevMiddleware;
use Ssntpl\Neev\Http\Middleware\Locale as LanguageMiddleware;
use Ssntpl\Neev\Http\Middleware\GenerateMenu;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(Kernel $kernel)
    {
        // Publish config files
        $this->publishes([
            __DIR__ . '/config/neev.php' => config_path('neev.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/config/translation-loader.php' => config_path('translation-loader.php'),
        ], 'config') ;

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        // Publish migrations
        $this->publishes([
            __DIR__ . '/database/migrations' => database_path('migrations'),
        ], 'migrations');

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');

        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'neev');

        // Publish translations
        $this->publishes([
            __DIR__ . '/resources/lang' => resource_path('lang/vendor/neev'),
        ], 'lang');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'neev');

        // Publish views
        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/neev'),
        ], 'views');

        // Publish public assets
        $this->publishes([
            __DIR__ . '/public' => public_path(''), // public_path('vendor/neev'), 
        ], 'public');

        // Register CheckNeev middleware to check if neev is ready to run.
        $kernel->pushMiddleware(CheckNeevMiddleware::class);

        // Register Language middleware
        $kernel->pushMiddleware(LanguageMiddleware::class);

         // Register GenerateMenu middleware
        $kernel->pushMiddleware(GenerateMenu::class);

        // Register the admin guard
        config(['auth.guards.admin' => ['driver' => 'session', 'provider' => 'users']]);

        // Register Spatie/Permission middleware
        $this->app['router']->aliasMiddleware('permission', \Spatie\Permission\Middlewares\PermissionMiddleware::class);
        $this->app['router']->aliasMiddleware('role', \Spatie\Permission\Middlewares\RoleMiddleware::class);

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(
            __DIR__ . '/config/neev.php',
            'neev'
        );
        
        // Register the application bindings.
        $this->app->singleton('neev', function ($app) {
            return new Neev($app);
        });

        // Register the application localiser bindings.
        $this->app->singleton('i18n', function ($app) {
            return new i18n($app);
        });

        // Register init command
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\NeevInit::class,
            ]);
        }

        // Register blade extensions
        $this->app->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {
            $bladeCompiler->directive('organisationCan', function ($arguments) {
                return "<?php if(Neev::organisation()->hasAnyPermission({$arguments})): ?>";
            });
            $bladeCompiler->directive('endOrganisationCan', function () {
                return '<?php endif; ?>';
            });

        });
    }
}

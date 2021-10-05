<?php

namespace Zhelyazko777\Forms;

use Zhelyazko777\Forms\Handlers\Contracts\FormHandlerInterface;
use Zhelyazko777\Forms\Handlers\FormHandler;
use Zhelyazko777\Forms\Resolvers\Contracts\FormResolverInterface;
use Zhelyazko777\Forms\Resolvers\FormResolver;
use Illuminate\Support\ServiceProvider;
use Zhelyazko777\LaravelSimpleMapper\SimpleMapperServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    /**
     * @var array<string, string>
     */
    public array $bindings = [
        FormResolverInterface::class => FormResolver::class,
        FormHandlerInterface::class => FormHandler::class,
    ];

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../resources/js/laravel-forms' => resource_path('resources/js/laravel-forms'),
        ]);
    }

    public function register()
    {
        $this->app->register('Zhelyazko777\\LaravelSimpleMapper\\SimpleMapperServiceProvider');
        $this->app->alias('Mapper', SimpleMapperServiceProvider::class);
        $this->app->bind('laravelForms', function() {
            return new Form;
        });
    }
}

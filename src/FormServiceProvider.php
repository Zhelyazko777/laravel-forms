<?php

namespace Zhelyazko777\Forms;

use Zhelyazko777\Forms\Handlers\Contracts\FormHandlerInterface;
use Zhelyazko777\Forms\Handlers\FormHandler;
use Zhelyazko777\Forms\Resolvers\Contracts\FormResolverInterface;
use Zhelyazko777\Forms\Resolvers\FormResolver;
use Illuminate\Support\ServiceProvider;
use Zhelyazko777\LaravelSimpleMapper\SimpleMapperFacade;
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

    public function register()
    {
        $this->app->bind('laravelForms', function() {
            return new Form;
        });
    }
}

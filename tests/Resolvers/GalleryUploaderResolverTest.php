<?php

namespace Zhelyazko777\Forms\Tests\Resolvers;

use Zhelyazko777\Forms\Builders\Models\GalleryUploaderFormControlConfig;
use Zhelyazko777\Forms\Resolvers\GalleryUploaderResolver;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedGalleryUploaderFormControl;
use Zhelyazko777\Forms\Tests\TestCase;
use Zhelyazko777\Forms\Tests\TestClasses\Pet;

class GalleryUploaderResolverTest extends TestCase
{
    private GalleryUploaderResolver $resolver;

    protected function setUp(): void
    {
        parent::setUp();
        $this->resolver = new GalleryUploaderResolver;
    }

    public function test_resolve_should_populate_model_value()
    {
        $config = (new GalleryUploaderFormControlConfig)->setName('name');
        $model = new Pet;

        $resolvedControl = $this->resolver->resolve($config, $model);

        $this->assertInstanceOf(ResolvedGalleryUploaderFormControl::class, $resolvedControl);
    }
}
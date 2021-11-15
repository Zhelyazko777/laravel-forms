<?php

namespace Zhelyazko777\Forms\Tests\Builders;

use Illuminate\Validation\Rule;
use Zhelyazko777\Forms\Builders\Abstractions\BaseControlBuilder;
use Zhelyazko777\Forms\Builders\GalleryUploaderControlBuilder;
use Zhelyazko777\Forms\Builders\Models\GalleryUploaderFormControlConfig;
use Zhelyazko777\Forms\Tests\Builders\Abstractions\BaseControlBuilderTest;

class GalleryUploaderControlBuilderTest extends BaseControlBuilderTest
{
    /** @var GalleryUploaderControlBuilder */
    protected BaseControlBuilder $builder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->builder = new GalleryUploaderControlBuilder($this->fieldName);
    }

    public function test_make_required_should_add_additional_single_required_rule()
    {
        /** @var GalleryUploaderFormControlConfig $config */
        $config = $this->builder->makeRequired()->export();

        $this->assertEquals(['required'], $config->getSingleRules());
        $this->assertEquals(['required'], $config->getRules());
    }

    public function test_make_required_with_msg_should_add_custom_err_msg_to_single_item_rule_only()
    {
        $msg = 'Test msg';

        /** @var GalleryUploaderFormControlConfig $config */
        $config = $this->builder->makeRequired($msg)->export();

        $this->assertCount(1, $config->getErrorMessages());
        $this->assertEquals([ $this->fieldName . '.*.required' => $msg], $config->getErrorMessages());
    }

    public function test_add_image_dimensions_should_add_dimensions_rule_to_the_config()
    {
        $maxWidth = 500;
        $minWidth = 400;
        $maxHeight = 600;
        $minHeight = 550;

        /** @var GalleryUploaderFormControlConfig $config */
        $config = $this
            ->builder
            ->addImageDimensions($minWidth, $maxWidth, $minHeight, $maxHeight)
            ->export();

        $this->assertEquals([
            ((string)Rule::dimensions()
                ->minWidth($minWidth)
                ->maxWidth($maxWidth)
                ->minHeight($minHeight)
                ->maxHeight($maxHeight))
        ], $config->getSingleRules());
    }

    public function test_add_image_dimensions_with_msg_should_add_dimensions_rule_with_custom_err_msg_to_the_config()
    {
        $msg = 'Test msg';
        $maxWidth = 500;
        $minWidth = 400;
        $maxHeight = 600;
        $minHeight = 550;

        /** @var GalleryUploaderFormControlConfig $config */
        $config = $this
            ->builder
            ->addImageDimensions($minWidth, $maxWidth, $minHeight, $maxHeight, $msg)
            ->export();

        $this->assertEquals([$this->fieldName . '.*.dimensions' =>  $msg], $config->getErrorMessages());
    }

    public function test_add_supported_mimes_should_add_mimes_validation_to_the_config()
    {
        $mimes = ['jpg', 'svg', 'png'];

        $config = $this
            ->builder
            ->addSupportedMimes($mimes)
            ->export();

        $this->assertEquals(['mimes:' . implode(',', $mimes)], $config->getSingleRules());
    }

    public function test_add_supported_mimes_with_msg_should_add_mimes_validation_with_custom_err_msg_to_the_config()
    {
        $msg = 'Test msg';

        $config = $this
            ->builder
            ->addSupportedMimes(['jpg', 'svg', 'png'], $msg)
            ->export();

        $this->assertEquals([$this->fieldName . '.*.mimes' => $msg], $config->getErrorMessages());
    }

    public function test_image_max_file_size_should_add_single_file_size_rule_to_the_config()
    {
        $size = 2 * 1024;

        $config = $this
            ->builder
            ->addImageMaxFileSize($size)
            ->export();

        $this->assertEquals(['max:' . $size], $config->getSingleRules());
    }


    public function test_image_max_file_size_with_msg_should_add_single_file_size_rule_with_custom_err_msg_to_the_config()
    {
        $msg = 'Test msg';
        $size = 2 * 1024;

        $config = $this
            ->builder
            ->addImageMaxFileSize($size, $msg)
            ->export();

        $this->assertEquals([$this->fieldName . '.*.max' => $msg], $config->getErrorMessages());
    }

    public function test_add_image_upload_route_should_add_image_upload_route_to_the_config()
    {
        $route = '/upload';

        /** @var GalleryUploaderFormControlConfig $config */
        $config = $this
            ->builder
            ->imageUploadRoute($route)
            ->export();

        $this->assertEquals($route, $config->getUploadRoute());
    }

    public function test_add_image_remove_route_should_add_image_remove_route_to_the_config()
    {
        $route = '/remove';

        /** @var GalleryUploaderFormControlConfig $config */
        $config = $this
            ->builder
            ->imageRemoveRoute($route)
            ->export();

        $this->assertEquals($route, $config->getRemoveImageRoute());
    }

    public function test_add_image_load_route_should_add_image_load_route_to_the_config()
    {
        $route = '/load';

        /** @var GalleryUploaderFormControlConfig $config */
        $config = $this
            ->builder
            ->imagesLoadRoute($route)
            ->export();

        $this->assertEquals($route, $config->getLoadImagesRoute());
    }
}
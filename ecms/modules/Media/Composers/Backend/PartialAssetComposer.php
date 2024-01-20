<?php

namespace Modules\Media\Composers\Backend;

use Modules\Core\Foundation\Asset\Manager\AssetManager;
use Modules\Core\Foundation\Asset\Pipeline\AssetPipeline;
use Modules\Core\Foundation\Asset\Types\AssetTypeFactory;

class PartialAssetComposer
{
    /**
     * @var AssetManager
     */
    private AssetManager $assetManager;
    /**
     * @var AssetPipeline
     */
    private AssetPipeline $assetPipeline;
    /**
     * @var AssetTypeFactory
     */
    private AssetTypeFactory $assetFactory;

    public function __construct()
    {
        $this->assetManager = app(AssetManager::class);
        $this->assetPipeline = app(AssetPipeline::class);
        $this->assetFactory = app(AssetTypeFactory::class);
    }

    public function compose()
    {
        $this->addAssets();
        $this->requireAssets();
    }

    /**
     * Add the assets from the config file on the asset manager
     */
    private function addAssets()
    {
        foreach (config('encore.media.assets.media-partial-assets', []) as $assetName => $path) {
            $path = $this->assetFactory->make($path)->url();
            $this->assetManager->addAsset($assetName, $path);
        }
    }

    /**
     * Require assets from asset manager
     */
    private function requireAssets()
    {
        $css = config('encore.media.assets.media-partial-required-assets.css');
        $js  = config('encore.media.assets.media-partial-required-assets.js');

        if (!empty($css)) {
            $this->assetPipeline->requireCss($css);
        }

        if (!empty($js)) {
            $this->assetPipeline->requireJs($js);
        }
    }
}

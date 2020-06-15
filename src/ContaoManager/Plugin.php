<?php

declare(strict_types=1);

namespace Cowegis\Bundle\ContaoMultilingual\ContaoManager;

use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Config\ContainerBuilder;
use Contao\ManagerPlugin\Config\ExtensionPluginInterface;
use Cowegis\Bundle\Contao\CowegisContaoBundle;
use Cowegis\Bundle\ContaoMultilingual\CowegisContaoMultilingualBundle;
use Cowegis\Bundle\ContaoMultilingual\Model\ControlModel;
use Cowegis\Bundle\ContaoMultilingual\Model\LayerModel;
use Cowegis\Bundle\ContaoMultilingual\Model\MarkerModel;
use Terminal42\DcMultilingualBundle\Terminal42DcMultilingualBundle;
use function array_unshift;

final class Plugin implements BundlePluginInterface, ExtensionPluginInterface
{
    public function getBundles(ParserInterface $parser) : array
    {
        return [
            BundleConfig::create(CowegisContaoMultilingualBundle::class)
                ->setLoadAfter([CowegisContaoBundle::class, Terminal42DcMultilingualBundle::class])
        ];
    }

    public function getExtensionConfig($extensionName, array $extensionConfigs, ContainerBuilder $container) : array
    {
        if ($extensionName !== 'cowegis_contao_multilingual') {
            return $extensionConfigs;
        }

        array_unshift(
            $extensionConfigs,
            [
                'data_containers' => [
                    'tl_cowegis_marker'  => [
                        'model'  => MarkerModel::class,
                        'fields' => [
                            'title'        => true,
                            'tooltip'      => true,
                            'alt'          => true,
                            'popupContent' => true,
                        ],
                    ],
                    'tl_cowegis_layer'   => [
                        'model'  => LayerModel::class,
                        'fields' => [
                            'title'       => true,
                            'attribution' => true,
                        ],
                    ],
                    'tl_cowegis_control' => [
                        'model'  => ControlModel::class,
                        'fields' => [
                            'attributions'          => true,
                            'fullscreenTitle'       => true,
                            'fullscreenCancelTitle' => true,
                            'prefix'                => true,
                            'metric'                => true,
                            'imperial'              => true,
                            'title'                 => true,
                            'zoomInText'            => true,
                            'zoomInTitle'           => true,
                            'zoomOutText'           => true,
                            'zoomOutTitle'          => true,
                        ],
                    ],
                ],
            ]
        );

        return $extensionConfigs;
    }
}

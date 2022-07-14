<?php

declare(strict_types=1);

namespace Cowegis\Bundle\ContaoMultilingual\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class CowegisContaoMultilingualExtension extends Extension
{
    /** {@inheritDoc} */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        if (empty($config['default_locale']) || empty($config['locales'])) {
            return;
        }

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $container->setParameter('cowegis_contao_multilingual.locales', $config['locales']);
        $container->setParameter('cowegis_contao_multilingual.default_locale', $config['default_locale']);
        $container->setParameter('cowegis_contao_multilingual.data_containers', $config['data_containers']);

        foreach ($config['data_containers'] as $table => $config) {
            $container->setParameter('cowegis_contao.model.' . $table, $config['model']);
        }

        $loader->load('services.xml');
    }
}

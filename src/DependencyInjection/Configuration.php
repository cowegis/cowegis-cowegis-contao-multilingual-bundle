<?php

declare(strict_types=1);

namespace Cowegis\Bundle\ContaoMultilingual\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder() : TreeBuilder
    {
        $builder = new TreeBuilder('cowegis_contao_multilingual');
        $rootNode = $builder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('locales')
                    ->isRequired()
                    ->defaultValue(['en'])
                    ->scalarPrototype()->end()
                    ->info('List of defined languages')
                ->end()
                ->scalarNode('default_locale')
                    ->isRequired()
                    ->defaultValue('en')
                    ->info('The default local is used as fallback language')
                ->end()
                ->arrayNode('data_containers')
                    ->info('Configuration for each data container which should be translated')
                    ->useAttributeAsKey('table')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('model')->end()
                            ->arrayNode('fields')
                                ->info('Translated fields. Optionally pass subset of languages')
                                ->useAttributeAsKey('field')
                                ->variablePrototype()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $builder;
    }
}

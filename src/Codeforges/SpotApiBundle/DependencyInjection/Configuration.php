<?php

namespace Codeforges\SpotApiBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('spot_api');
        $rootNode
            ->children()
                ->arrayNode('amazon_s3')
                    ->children()
                        ->scalarNode('aws_key')->end()
                        ->scalarNode('aws_secret_key')->end()
                        ->scalarNode('base_url')->end()
                    ->end()
                ->end()
            ->end();
        return $treeBuilder;
    }
}
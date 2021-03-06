<?php

namespace Voryx\ThruwayBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('voryx_thruway');


        $rootNode
            ->children()
            ->arrayNode('clients')->prototype('scalar')->end()->end()
            ->arrayNode('resources')->prototype('scalar')->end()->end()
            ->scalarNode('server')->defaultValue('127.0.0.1')->end()
            ->scalarNode('port')->defaultValue('8080')->end()
            ->scalarNode('trusted_port')->defaultValue('8081')->end()
            ->scalarNode('realm')->defaultValue('realm1')->end()
            ->scalarNode('php_path')->defaultValue('/usr/bin/php')->end()
            ->booleanNode('local_server')->defaultTrue()->end()
            ->booleanNode('enable_manager')->defaultFalse()->end()
            ->booleanNode('enable_web_push')->defaultFalse()->end()
            ->booleanNode('enable_logging')->defaultFalse()->end()
            ->scalarNode('authentication')->end()
            ->end();


        $this->addSupervisorSection($rootNode);

        return $treeBuilder;
    }

    private function addSupervisorSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('supervisor')
                    ->addDefaultsIfNotSet()
                    ->info('supervisor configuration')
//                    ->canBeUnset()
                    ->children()
                        ->scalarNode('hostname')->defaultValue('unix:///tmp/supervisor.sock')->end()
                        ->scalarNode('port')->defaultValue(-1)->end()
                        ->scalarNode('timeout')->defaultNull()->end()
                        ->scalarNode('username')->defaultNull()->end()
                        ->scalarNode('password')->defaultNull()->end()
                    ->end()
                ->end()
            ->end();
    }
}

<?php

namespace CustomPhpSettings\DI\Definition\Resolver;

use CustomPhpSettings\DI\Definition\Definition;
use CustomPhpSettings\DI\Definition\InstanceDefinition;
use CustomPhpSettings\DI\DependencyException;
use CustomPhpSettings\Interop\Container\Exception\NotFoundException;

/**
 * Injects dependencies on an existing instance.
 *
 * @since 5.0
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class InstanceInjector extends ObjectCreator
{
    /**
     * Injects dependencies on an existing instance.
     *
     * @param InstanceDefinition $definition
     *
     * {@inheritdoc}
     */
    public function resolve(Definition $definition, array $parameters = [])
    {
        try {
            $this->injectMethodsAndProperties($definition->getInstance(), $definition->getObjectDefinition());
        } catch (NotFoundException $e) {
            $message = sprintf(
                'Error while injecting dependencies into %s: %s',
                get_class($definition->getInstance()),
                $e->getMessage()
            );
            throw new DependencyException($message, 0, $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isResolvable(Definition $definition, array $parameters = [])
    {
        return true;
    }
}

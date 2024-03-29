<?php

namespace CustomPhpSettings\DI\Definition;

use CustomPhpSettings\Interop\Container\ContainerInterface;

/**
 * Describes a definition that can resolve itself.
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
interface SelfResolvingDefinition
{
    /**
     * Resolve the definition and return the resulting value.
     *
     * @return mixed
     */
    public function resolve(ContainerInterface $container);

    /**
     * Check if a definition can be resolved.
     *
     * @return bool
     */
    public function isResolvable(ContainerInterface $container);
}

<?php

namespace CustomPhpSettings\DI\Invoker;

use CustomPhpSettings\Interop\Container\ContainerInterface;
use CustomPhpSettings\Invoker\ParameterResolver\ParameterResolver;
use ReflectionFunctionAbstract;

/**
 * Inject the container, the definition or any other service using type-hints.
 *
 * {@internal This class is similar to TypeHintingResolver and TypeHintingContainerResolver,
 *            we use this instead for performance reasons}
 *
 * @author Quim Calpe <quim@kalpe.com>
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class FactoryParameterResolver implements ParameterResolver
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getParameters(
        ReflectionFunctionAbstract $reflection,
        array $providedParameters,
        array $resolvedParameters
    ) {
        $parameters = $reflection->getParameters();

        // Skip parameters already resolved
        if (! empty($resolvedParameters)) {
            $parameters = array_diff_key($parameters, $resolvedParameters);
        }

        foreach ($parameters as $index => $parameter) {
            $parameterClass = @$parameter->getType();

            if (!$parameterClass) {
                continue;
            }

            if ($parameterClass->getName() === 'Interop\Container\ContainerInterface') {
                $resolvedParameters[$index] = $this->container;
            } elseif ($parameterClass->getName() === 'DI\Factory\RequestedEntry') {
                // By convention the second parameter is the definition
                $resolvedParameters[$index] = $providedParameters[1];
            } elseif ($this->container->has($parameterClass->getName())) {
                $resolvedParameters[$index] = $this->container->get($parameterClass->getName());
            }
        }

        return $resolvedParameters;
    }
}

<?php

namespace CustomPhpSettings\DI\Definition\Resolver;

use CustomPhpSettings\DI\Definition\Definition;
use CustomPhpSettings\DI\Definition\EnvironmentVariableDefinition;
use CustomPhpSettings\DI\Definition\Exception\DefinitionException;
use CustomPhpSettings\DI\Definition\Helper\DefinitionHelper;

/**
 * Resolves a environment variable definition to a value.
 *
 * @author James Harris <james.harris@icecave.com.au>
 */
class EnvironmentVariableResolver implements DefinitionResolver
{
    /**
     * @var DefinitionResolver
     */
    private $definitionResolver;

    /**
     * @var callable
     */
    private $variableReader;

    public function __construct(DefinitionResolver $definitionResolver, $variableReader = 'getenv')
    {
        $this->definitionResolver = $definitionResolver;
        $this->variableReader = $variableReader;
    }

    /**
     * Resolve an environment variable definition to a value.
     *
     * @param EnvironmentVariableDefinition $definition
     *
     * {@inheritdoc}
     */
    public function resolve(Definition $definition, array $parameters = [])
    {
        $value = call_user_func($this->variableReader, $definition->getVariableName());

        if (false !== $value) {
            return $value;
        }

        if (!$definition->isOptional()) {
            throw new DefinitionException(sprintf(
                "The environment variable '%s' has not been defined",
                $definition->getVariableName()
            ));
        }

        $value = $definition->getDefaultValue();

        // Nested definition
        if ($value instanceof DefinitionHelper) {
            return $this->definitionResolver->resolve($value->getDefinition(''));
        }

        return $value;
    }

    /**
     * @param EnvironmentVariableDefinition $definition
     *
     * {@inheritdoc}
     */
    public function isResolvable(Definition $definition, array $parameters = [])
    {
        return true;
    }
}

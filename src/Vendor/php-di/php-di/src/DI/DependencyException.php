<?php

namespace CustomPhpSettings\DI;

use CustomPhpSettings\Interop\Container\Exception\ContainerException;

/**
 * Exception for the Container.
 */
class DependencyException extends \Exception implements ContainerException
{
}

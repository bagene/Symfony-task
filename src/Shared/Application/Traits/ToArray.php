<?php

declare(strict_types=1);

namespace App\Shared\Application\Traits;

use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;

trait ToArray
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $reflectionClass = new ReflectionClass(get_class($this));
        $response = [];
        foreach ($reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $methodName = $method->getName();
            /** @var ReflectionNamedType|null $returnType */
            $returnType = $method->getReturnType();

            if (
                $method->isConstructor() ||
                $method->isAbstract() ||
                $method->isStatic() ||
                'toArray' === $methodName ||
                null === $returnType ||
                'void' === $returnType->getName()
            ) {
                continue;
            }

            if (preg_match('/^get[A-Z]/', $methodName)) {
                $key = lcfirst(substr($methodName, 3));
            } else {
                $key = lcfirst($methodName);
            }
            $response[$key] = $this->$methodName();
        }

        return $response;
    }
}

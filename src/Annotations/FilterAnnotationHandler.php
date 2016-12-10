<?php
namespace Sandbox\Annotations;

use Doctrine\Common\Annotations\Reader;
use Sandbox;

class FilterAnnotationHandler
{
    private $reader;
    private $annotationClass = 'Sandbox\Annotations\Filter';

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function read($object)
    {


        $reflectionObject = new \ReflectionObject($object);


        foreach ($reflectionObject->getMethods() as $reflectionMethod) {

            /**
             * Weird but still be need to do this.
             */
            $loader = new $this->annotationClass; $loader;

            /**
             * Autoload or instantiate the object
             */
            $annotation = $this->reader->getMethodAnnotation($reflectionMethod, $this->annotationClass);

            Sandbox\Filters::add_filter($annotation->getPropertyName(),
                [$object, $reflectionMethod->name], $annotation->priority);
        }
    }
}

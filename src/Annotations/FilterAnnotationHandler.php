<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 03-04-16
 * Time: 16:26
 */

namespace Sandbox\Annotations;

use Doctrine\Common\Annotations\Reader;

class FilterAnnotationHandler
{
    private $reader;
    private $annotationClass = 'Sandbox\Annotations\Filter';
    private $annotation = null;

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function read($object)
    {


        $reflectionObject = new \ReflectionObject($object);


        foreach ($reflectionObject->getMethods() as $reflectionMethod) {
            // fetch the @StandardObject annotation from the annotation reader
            $x = new $this->annotationClass;
            print_r($reflectionMethod);
            // exit;

            $annotation = $this->reader->getMethodAnnotation($reflectionMethod, $this->annotationClass);
            add_filter()
            print_r($annotation);
            exit;

        }

    }

}
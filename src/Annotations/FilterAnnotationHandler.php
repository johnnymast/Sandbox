<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 03-04-16
 * Time: 16:26
 */

namespace Sandbox\Annotations;
use Doctrine\Common\Annotations\Reader;
use Sandbox;


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
////            // fetch the @StandardObject annotation from the annotation reader
//            $x = new $this->annotationClass;
//
//            $annotation = $this->reader->getMethodAnnotation($reflectionMethod, $this->annotationClass);
////  //          Sandbox\Filters::add_filter($annotation->getPropertyName(), [$reflectionMethod->class, $reflectionMethod->name]);
//            Sandbox\Filters::add_filter($annotation->getPropertyName(), [$x, $reflectionMethod->getName()]);
////            print_r($annotation);
//           // exit;
            $loader = new $this->annotationClass; $loader;

            $annotation = $this->reader->getMethodAnnotation($reflectionMethod, $this->annotationClass);

            print '<pre>';
            print_r($annotation->priority);
            print '</pre>';
            /**
             * Autoload or instantiate the object
             */

            $annotation = $this->reader->getMethodAnnotation($reflectionMethod, $this->annotationClass);
            Sandbox\Filters::add_filter($annotation->getPropertyName(), [$object, $reflectionMethod->getName()], $annotation->priority);
        }

    }

}
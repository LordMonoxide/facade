<?php declare(strict_types=1); namespace BapCat\Facade;

use BapCat\Phi\Ioc;
use BapCat\Propifier\PropifierTrait;
use BapCat\Values\Regex;
use BapCat\Values\Text;

use ReflectionClass;
use ReflectionException;

/**
 * @property-read  string  $name
 * @property-read  string  $binding
 * @property-read  Ioc     $ioc
 */
class FacadeDefinition {
  use PropifierTrait;

  /** @var  string  $name */
  private $name;

  /** @var  string  $binding */
  private $binding;

  /** @var  Ioc  $ioc */
  private $ioc;

  /**
   * @param  string  $name
   * @param  string  $binding
   * @param  Ioc     $ioc
   */
  public function __construct(string $name, string $binding, Ioc $ioc) {
    $this->name    = $name;
    $this->binding = $binding;
    $this->ioc     = $ioc;
  }

  /**
   * @return  string
   */
  protected function getName(): string {
    return $this->name;
  }

  /**
   * @return  string
   */
  protected function getBinding(): string {
    return $this->binding;
  }

  /**
   * @return  Ioc
   */
  protected function getIoc(): Ioc {
    return $this->ioc;
  }

  /**
   * @return  array
   *
   * @throws  ReflectionException
   */
  public function toArray(): array {
    $reflect = new ReflectionClass($this->binding);
    $methods = [];
    $imports = [];

    $throwsRegex = new Regex('/@throws\s+([^\\ ]+)\s/');
    $useStatementParser = new UseStatementParser();

    foreach($reflect->getMethods() as $method) {
      if($method->isPublic() && !($method->isConstructor() || $method->isDestructor() || strpos($method->getName(), '__') === 0)) {
        $methods[] = $method;

        foreach($method->getParameters() as $param) {
          if($param->getType() !== null && !$param->getType()->isBuiltin()) {
            $imports[] = $param->getType()->getName();
          }
        }

        if($method->hasReturnType() && !$method->getReturnType()->isBuiltin()) {
          $imports[] = $method->getReturnType()->getName();
        }

        if($method->getDocComment() !== false) {
          foreach($throwsRegex->capture(new Text($method->getDocComment())) as $exception) {
            $exception = trim((string)reset($exception));

            $methodImports = $useStatementParser->parseUseStatements($method->getDeclaringClass());
            $found = false;

            foreach($methodImports as $methodImport) {
              if(substr_compare($methodImport, $exception, -strlen($exception)) === 0) {
                $found = true;
                $imports[] = $methodImport;
                break;
              }
            }

            if(!$found) {
              $imports[] = $method->getDeclaringClass()->getNamespaceName() . '\\' . $exception;
            }
          }
        }
      }
    }

    $imports = array_unique($imports);
    $imports = array_filter($imports, function($import) {
      // Don't add import if the import has the same class name as the facade (TODO: this is not ideal...)
      if(substr_compare($import, $this->name, -strlen($this->name)) === 0) {
        return false;
      }

      // Don't add imports for classes in the global namespace since facades are generated in the global namespace
      if(strpos($import, '\\') === false) {
        return false;
      }

      // Only add imports that actually exist
      return class_exists($import) || interface_exists($import);
    });

    return [
      'name'    => $this->name,
      'binding' => $this->binding,
      'ioc'     => get_class($this->ioc),
      'reflect' => new ReflectionClass($this->binding),
      'methods' => $methods,
      'imports' => $imports,
    ];
  }
}

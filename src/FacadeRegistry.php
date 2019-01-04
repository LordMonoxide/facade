<?php namespace BapCat\Facade;

use BapCat\Nom\TemplateNotFoundException;
use BapCat\Persist\NotADirectoryException;
use BapCat\Persist\NotAFileException;
use BapCat\Phi\Ioc;
use BapCat\Hashing\Algorithms\Sha1WeakHasher;
use BapCat\Nom\Compiler;
use BapCat\Nom\NomTransformer;
use BapCat\Nom\Pipeline;
use BapCat\Persist\Directory;
use BapCat\Persist\Drivers\Local\LocalDriver;
use BapCat\Tailor\Generator;
use BapCat\Tailor\Tailor;

class FacadeRegistry {
  /** @var  Ioc  $ioc */
  private $ioc;

  /** @var  Tailor  $tailor */
  private $tailor;

  /** @var  FacadeDefinition[]  $defs */
  private $defs = [];

  /**
   * @param  Ioc        $ioc
   * @param  Directory  $cache  Where to cache generated classes
   *
   * @throws NotADirectoryException
   */
  public function __construct(Ioc $ioc, Directory $cache) {
    $this->ioc = $ioc;

    $preprocessor = $ioc->make(NomTransformer::class);
    $compiler     = $ioc->make(Compiler::class);
    $pipeline     = $ioc->make(Pipeline::class, [$cache, $compiler, [$preprocessor]]);

    $filesystem = new LocalDriver(__DIR__ . '/../templates');
    $templates  = $filesystem->getDirectory('/');

    $hasher = $ioc->make(FacadeHashGenerator::class, [new Sha1WeakHasher()]);

    $this->tailor = $ioc->make(Tailor::class, [$templates, $cache, $pipeline, $hasher]);
  }

  /**
   * @param  string  $name
   * @param  string  $binding
   *
   * @return  FacadeDefinition
   */
  public function register(string $name, string $binding): FacadeDefinition {
    $builder = $this->defs[$name] = new FacadeDefinition($name, $binding, $this->ioc);

    $this->tailor->bindCallback($builder->name, function(Generator $gen) use($builder): void {
      $file = $gen->generate('Facade', $builder->toArray());
      $gen->includeFile($file);
    });

    return $builder;
  }

  /**
   * Forces the pre-generation of every registered Facade
   *
   * Note: for the sake of your IDE, it's a good idea to clear your cache directory before doing this
   *
   * @return  void
   *
   * @throws TemplateNotFoundException
   * @throws NotAFileException
   */
  public function generateAll(): void {
    foreach($this->defs as $def) {
      $this->tailor->getGenerator()->generate('Facade', $def->toArray());
    }
  }
}

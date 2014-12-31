<?php

namespace Estaty;

use Silex\Application as SilexApplication;

class Application extends SilexApplication
{
    use SilexApplication\UrlGeneratorTrait;
    use SilexApplication\TwigTrait;
    use SilexApplication\MonologTrait;
    use SilexApplication\TranslationTrait;
}

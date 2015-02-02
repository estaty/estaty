<?php

namespace Estaty;

use Silex\Application as SilexApplication;

class Application extends SilexApplication
{
    use SilexApplication\UrlGeneratorTrait;
    use SilexApplication\TwigTrait;
    use SilexApplication\MonologTrait;
    use SilexApplication\SecurityTrait;
    use SilexApplication\FormTrait;
    use SilexApplication\TranslationTrait;
}

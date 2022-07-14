<?php

declare(strict_types=1);

namespace Cowegis\Bundle\ContaoMultilingual\Model;

use Cowegis\Bundle\Contao\Model\ControlModel as UntranslatedControlModel;
use Terminal42\DcMultilingualBundle\Model\MultilingualTrait;

final class ControlModel extends UntranslatedControlModel
{
    use MultilingualTrait;

    /** @SuppressWarnings(PHPMD.ShortMethodName) */
    public function id(): int
    {
        return (int) $this->getLanguageId();
    }
}

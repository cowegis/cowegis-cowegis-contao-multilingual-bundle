<?php

declare(strict_types=1);

namespace Cowegis\Bundle\ContaoMultilingual\Model;

use Cowegis\Bundle\Contao\Model\MarkerModel as UntranslatedMarkerModel;
use Terminal42\DcMultilingualBundle\Model\MultilingualTrait;

class MarkerModel extends UntranslatedMarkerModel
{
    use MultilingualTrait;

    /** @SuppressWarnings(PHPMD.ShortMethodName) */
    public function id(): int
    {
        return (int) $this->getLanguageId();
    }
}

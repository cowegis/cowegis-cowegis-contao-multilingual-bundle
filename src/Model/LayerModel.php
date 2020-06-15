<?php

declare(strict_types=1);

namespace Cowegis\Bundle\ContaoMultilingual\Model;

use Cowegis\Bundle\Contao\Model\LayerModel as UntranslatedLayerModel;
use Terminal42\DcMultilingualBundle\Model\MultilingualTrait;

class LayerModel extends UntranslatedLayerModel
{
    use MultilingualTrait;

    public function id() : int
    {
        return (int) $this->getLanguageId();
    }
}

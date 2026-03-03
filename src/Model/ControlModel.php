<?php

declare(strict_types=1);

namespace Cowegis\Bundle\ContaoMultilingual\Model;

use Cowegis\Bundle\Contao\Model\ControlModel as UntranslatedControlModel;
use Override;
use Terminal42\DcMultilingualBundle\Model\MultilingualTrait;

final class ControlModel extends UntranslatedControlModel
{
    use MultilingualTrait;

    /**
     * @SuppressWarnings(PHPMD.ShortMethodName)
     * @psalm-suppress RedundantCastGivenDocblockType
     */
    #[Override]
    public function id(): int
    {
        return (int) $this->getLanguageId();
    }
}

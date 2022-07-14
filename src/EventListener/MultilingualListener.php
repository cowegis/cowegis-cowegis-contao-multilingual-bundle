<?php

declare(strict_types=1);

namespace Cowegis\Bundle\ContaoMultilingual\EventListener;

use Cowegis\Bundle\ContaoMultilingual\DependencyInjection\Configuration;
use Netzmacht\Contao\Toolkit\Dca\Manager as DcaManager;

use function is_array;

/**
 * @psalm-import-type TDataContainerConfig from Configuration
 */
final class MultilingualListener
{
    private DcaManager $dcaManager;

    /** @var array<string,TDataContainerConfig> */
    private array $dataContainers;

    /** @var string[] */
    private array $locales;

    private string $fallbackLocale;

    /**
     * @param array<string,TDataContainerConfig> $dataContainers
     * @param string[]                           $locales
     */
    public function __construct(DcaManager $dcaManager, array $dataContainers, array $locales, string $fallbackLocale)
    {
        $this->dcaManager     = $dcaManager;
        $this->dataContainers = $dataContainers;
        $this->locales        = $locales;
        $this->fallbackLocale = $fallbackLocale;
    }

    /** @SuppressWarnings(PHPMD.Superglobals) */
    public function onInitializeSystem(): void
    {
        foreach ($this->dataContainers as $table => $config) {
            $GLOBALS['TL_MODELS'][$table] = $config['model'];
        }
    }

    public function onLoadDataContainer(string $name): void
    {
        if (! isset($this->dataContainers[$name])) {
            return;
        }

        $definition = $this->dcaManager->getDefinition($name);
        $definition->modify(
            ['config'],
            /**
             * @param array<string,mixed> $config
             *
             * @return array<string,mixed>
             */
            function (array $config): array {
                $config['dataContainer']           = 'Multilingual';
                $config['languages']               = $this->locales;
                $config['fallbackLang']            = $this->fallbackLocale;
                $config['sql']['keys']['langPid']  = 'index';
                $config['sql']['keys']['language'] = 'index';

                return $config;
            }
        );

        $definition->set(['fields', 'langPid', 'sql'], "int(10) unsigned NOT NULL default '0'");
        $definition->set(['fields', 'language', 'sql'], "varchar(2) NOT NULL default ''");

        foreach ($this->dataContainers[$name]['fields'] as $field => $locales) {
            if ($locales === true) {
                $definition->set(['fields', $field, 'eval', 'translatableFor'], '*');
            } elseif (is_array($locales)) {
                $definition->set(['fields', $field, 'eval', 'translatableFor'], $locales);
            }
        }
    }
}

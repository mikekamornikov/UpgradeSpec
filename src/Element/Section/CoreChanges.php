<?php

namespace Sugarcrm\UpgradeSpec\Element\Section;

use Sugarcrm\UpgradeSpec\Element\ElementInterface;
use Sugarcrm\UpgradeSpec\Spec\Context;
use Sugarcrm\UpgradeSpec\Template\RendererAwareInterface;
use Sugarcrm\UpgradeSpec\Template\RendererAwareTrait;

class CoreChanges implements ElementInterface, RendererAwareInterface
{
    use RendererAwareTrait;

    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Backup or rewrite core changes';
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * @param Context $context
     *
     * @return bool
     */
    public static function isRelevantTo(Context $context)
    {
        return true;
    }

    /**
     * @param Context $context
     *
     * @return string
     */
    public function getBody(Context $context)
    {
        $guideUrl = $this->getExtensionsGuideUrl($context->getUpgradeVersion());

        return $this->renderer->render('core_changes', ['dev_guide_url' => $guideUrl]);
    }

    /**
     * Get extensions dev guide url for given version.
     *
     * @param $version
     *
     * @return string
     */
    private function getExtensionsGuideUrl($version)
    {
        $guideUrl = 'http://support.sugarcrm.com/Documentation/Sugar_Developer/';
        list ($v1, $v2) = explode('.', $version);
        $baseVersion = $v1 . '.' . $v2;

        if (version_compare($baseVersion, '6.5', '<') || version_compare($baseVersion, '7.8', '>')) {
            return '';
        }

        if (version_compare($baseVersion, '7.0', '<')) {
            $guideUrl .= 'Sugar_Developer_Guide_6.5/Extension_Framework/index.html';
        } elseif (version_compare($baseVersion, '7.7', '<')) {
            $guideUrl .= 'Sugar_Developer_Guide_7.6/Extension_Framework/index.html';
        } else {
            $guideUrl .= sprintf('Sugar_Developer/Sugar_Developer_Guide_%s/Architecture/Extensions/index.html', $baseVersion);
        }

        return $guideUrl;
    }
}

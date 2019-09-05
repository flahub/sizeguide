<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Orangecat\Sizeguide\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * Eav setup factory
     * @var EavSetupFactory
     * @var BlockFactory
     */
    private $eavSetupFactory;
    protected $blockFactory;

    /**
     * Init
     * @param EavSetupFactory $eavSetupFactory, $blockFactory
     */
    public function __construct(\Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
                                \Magento\Cms\Model\BlockFactory $blockFactory )
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->blockFactory = $blockFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        //create attribute size_guide

        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'size_guide',
            [
                'group' => 'General',
                'type' => 'int',
                'label' => 'Show size guide',
                'input' => 'select',
                'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
                'frontend' => '',
                'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                'required' => false,
                'sort_order' => 50,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'visible' => true,
                'is_html_allowed_on_front' => true,
                'visible_on_front' => true
            ]
        );

        // create cms block

        $cmsBlock = $this->blockFactory->create()->setStoreId(0)->load('sizeguide-block', 'identifier');

        $cmsBlockData = [
            'title' => 'Size guide block',
            'identifier' => 'sizeguide-block',
            'is_active' => 1,
            'stores' => [0],
            'content' => "<div class='block sizeguide-block'>
                                <h2>Size Guide</h2>
                                <p>Include here your size guide information...</p>
                            </div>",
        ];

        if (!$cmsBlock->getId()) {
            $this->blockFactory->create()->setData($cmsBlockData)->save();
        } else {
            $cmsBlock->setContent($cmsBlockData['content'])->save();
        }
        $setup->endSetup();
    }
}
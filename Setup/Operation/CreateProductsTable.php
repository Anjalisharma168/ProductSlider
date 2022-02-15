<?php

namespace Dotsquares\ProductSlider\Setup\Operation;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table as DdlTable;

class CreateProductsTable
{
    /**
     * @param SchemaSetupInterface $setup
     */
    public function execute(SchemaSetupInterface $setup)
    {
        $installer = $setup;

        
        $table = $installer->getConnection()->newTable(
            $installer->getTable('dotsquares_productslider_products')
        )     ->addColumn(
            'slider_id',
            DdlTable::TYPE_INTEGER,
            null,
            ['nullable' => false, 'unsigned' => true, 'primary' => true],
            'Slider ID'
        )->addColumn(
            'product_id',
            DdlTable::TYPE_INTEGER,
            null,
            ['nullable' => false, 'unsigned' => true, 'primary' => true],
            'Product ID'
        )->addColumn(
            'position',
            DdlTable::TYPE_INTEGER,
            null,
            ['nullable' => false, 'default' => '0'],
            'Position'
        )->addIndex(
            $installer->getIdxName(
                'dotsquares_productslider_products',
                ['product_id']
            ),
            ['product_id']
        )->addForeignKey(
            $installer->getFkName(
                'dotsquares_productslider_products',
                'slider_id',
                'dotsquares_productslider',
                'slider_id'
            ),
            'slider_id',
            $installer->getTable('dotsquares_productslider'),
            'slider_id',
            DdlTable::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName(
                'dotsquares_productslider_products',
                'product_id',
                'catalog_product_entity',
                'entity_id'
            ),
            'product_id',
            $installer->getTable('catalog_product_entity'),
            'entity_id',
            DdlTable::ACTION_CASCADE
        )->setComment('Dotsquares Catalog Product To Slider Linkage Table');

        $installer->getConnection()->createTable($table);
    }
}

<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariationStockViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement($this->dropView());   
    }

    private function createView() {
        return '
        CREATE VIEW product_variation_stock_views AS 
        SELECT  product_variations.product_id AS product_id, 

        product_variations.id AS product_variation_id, 

        COALESCE(stocks.quantity, 0) - COALESCE(product_variation_order.quantity, 0) AS stock,

        CASE WHEN COALESCE(stocks.quantity, 0) - COALESCE(product_variation_order.quantity, 0) > 0 
        THEN true
        ELSE false
        END in_stock

        FROM product_variations 

        LEFT JOIN (
            SELECT stocks.product_variation_id AS id,
            SUM(stocks.quantity) AS quantity
            FROM stocks 
            GROUP BY product_variation_id
        ) AS stocks USING (id)
        
        LEFT JOIN (
            SELECT product_variation_order.product_variation_id AS id,
            SUM(product_variation_order.quantity) AS quantity 
            FROM product_variation_order
            GROUP BY product_variation_order.product_variation_id
        ) AS product_variation_order USING (id);
        ';
    }

    private function dropView() {
        return '
            DROP VIEW IF EXISTS `product_variation_stock_views`;
        ';
    }
}

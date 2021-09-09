<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductVariationStockView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       DB::statement("
            CREATE OR REPLACE VIEW product_variation_stock_view AS
            SELECT
                product_variations.product_id AS product_id,
                product_variations.id AS product_variation_id,
                COALESCE(SUM(stocks.quantity) - coalesce(SUM(order_product_variation.quantity), 0), 0) AS stock,
                case when COALESCE(SUM(stocks.quantity) - coalesce(SUM(order_product_variation.quantity), 0), 0) > 0
                    then true
                    ELSE false
                END in_stock
            FROM product_variations
            LEFT JOIN (
                SELECT
                        stocks.product_variation_id AS id,
                        SUM(stocks.quantity) AS quantity
                FROM stocks
                GROUP BY stocks.product_variation_id
            ) AS stocks USING (id)
            LEFT JOIN (
                SELECT
                    order_product_variation.product_variation_id AS id,
                    SUM(order_product_variation.quantity) AS quantity
                FROM order_product_variation
                GROUP BY order_product_variation.product_variation_id
            ) AS order_product_variation USING (id)
            GROUP BY product_variations.id
       ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //DB::statement("DROP VIEW product_variation_stock_view");
    }
}

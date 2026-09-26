<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
         * ================================================================
         * 1. GLOBAL BRAND SLUG
         * ================================================================
         *
         * Rule:
         * - merchant_id IS NULL = global brand
         * - Global brand slugs must be unique.
         * - Merchant-specific brands may reuse the same slug.
         *
         * MariaDB does not support PostgreSQL-style partial unique indexes.
         * We therefore enforce this rule with triggers.
         */

        DB::unprepared('
            CREATE TRIGGER brands_global_slug_insert
            BEFORE INSERT ON brands
            FOR EACH ROW
            BEGIN
                IF NEW.merchant_id IS NULL THEN

                    IF EXISTS (
                        SELECT 1
                        FROM brands
                        WHERE merchant_id IS NULL
                          AND slug = NEW.slug
                    ) THEN
                        SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "Global brand slug already exists";
                    END IF;

                END IF;
            END
        ');

        DB::unprepared('
            CREATE TRIGGER brands_global_slug_update
            BEFORE UPDATE ON brands
            FOR EACH ROW
            BEGIN
                IF NEW.merchant_id IS NULL THEN

                    IF EXISTS (
                        SELECT 1
                        FROM brands
                        WHERE merchant_id IS NULL
                          AND slug = NEW.slug
                          AND id <> OLD.id
                    ) THEN
                        SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "Global brand slug already exists";
                    END IF;

                END IF;
            END
        ');


        /*
         * ================================================================
         * 2. GLOBAL CATEGORY SLUG
         * ================================================================
         */

        DB::unprepared('
            CREATE TRIGGER categories_global_slug_insert
            BEFORE INSERT ON categories
            FOR EACH ROW
            BEGIN
                IF NEW.merchant_id IS NULL THEN

                    IF EXISTS (
                        SELECT 1
                        FROM categories
                        WHERE merchant_id IS NULL
                          AND slug = NEW.slug
                    ) THEN
                        SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "Global category slug already exists";
                    END IF;

                END IF;
            END
        ');

        DB::unprepared('
            CREATE TRIGGER categories_global_slug_update
            BEFORE UPDATE ON categories
            FOR EACH ROW
            BEGIN
                IF NEW.merchant_id IS NULL THEN

                    IF EXISTS (
                        SELECT 1
                        FROM categories
                        WHERE merchant_id IS NULL
                          AND slug = NEW.slug
                          AND id <> OLD.id
                    ) THEN
                        SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "Global category slug already exists";
                    END IF;

                END IF;
            END
        ');


        /*
         * ================================================================
         * 3. ONE DEFAULT VARIANT PER PRODUCT
         * ================================================================
         *
         * Rule:
         * A product may have only one active default variant.
         *
         * Soft-deleted variants are ignored.
         */

        DB::unprepared('
            CREATE TRIGGER product_variants_default_insert
            BEFORE INSERT ON product_variants
            FOR EACH ROW
            BEGIN
                IF NEW.is_default = 1
                   AND NEW.deleted_at IS NULL THEN

                    IF EXISTS (
                        SELECT 1
                        FROM product_variants
                        WHERE product_id = NEW.product_id
                          AND is_default = 1
                          AND deleted_at IS NULL
                    ) THEN
                        SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "Product already has a default variant";
                    END IF;

                END IF;
            END
        ');

        DB::unprepared('
            CREATE TRIGGER product_variants_default_update
            BEFORE UPDATE ON product_variants
            FOR EACH ROW
            BEGIN
                IF NEW.is_default = 1
                   AND NEW.deleted_at IS NULL THEN

                    IF EXISTS (
                        SELECT 1
                        FROM product_variants
                        WHERE product_id = NEW.product_id
                          AND is_default = 1
                          AND deleted_at IS NULL
                          AND id <> OLD.id
                    ) THEN
                        SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "Product already has a default variant";
                    END IF;

                END IF;
            END
        ');


        /*
         * ================================================================
         * 4. ONE PRIMARY CATEGORY PER PRODUCT
         * ================================================================
         */

        DB::unprepared('
            CREATE TRIGGER product_categories_primary_insert
            BEFORE INSERT ON product_categories
            FOR EACH ROW
            BEGIN
                IF NEW.is_primary = 1 THEN

                    IF EXISTS (
                        SELECT 1
                        FROM product_categories
                        WHERE product_id = NEW.product_id
                          AND is_primary = 1
                    ) THEN
                        SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "Product already has a primary category";
                    END IF;

                END IF;
            END
        ');

        DB::unprepared('
            CREATE TRIGGER product_categories_primary_update
            BEFORE UPDATE ON product_categories
            FOR EACH ROW
            BEGIN
                IF NEW.is_primary = 1 THEN

                    IF EXISTS (
                        SELECT 1
                        FROM product_categories
                        WHERE product_id = NEW.product_id
                          AND is_primary = 1
                          AND id <> OLD.id
                    ) THEN
                        SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "Product already has a primary category";
                    END IF;

                END IF;
            END
        ');


        /*
         * ================================================================
         * 5. ONE ADDRESS OF EACH TYPE PER ORDER
         * ================================================================
         *
         * This rule is a normal unique constraint.
         */

        Schema::table('order_addresses', function (Blueprint $table) {
            $table->unique(
                ['order_id', 'type'],
                'oa_order_type_unique'
            );
        });


        /*
         * ================================================================
         * 6. MARKETPLACE LISTING
         * ================================================================
         *
         * External listing IDs need to be unique per marketplace
         * connection, but only for active listings.
         *
         * We enforce these rules with triggers.
         */

        DB::unprepared('
            CREATE TRIGGER marketplace_listings_ext_listing_insert
            BEFORE INSERT ON marketplace_listings
            FOR EACH ROW
            BEGIN
                IF NEW.external_listing_id IS NOT NULL
                   AND NEW.deleted_at IS NULL THEN

                    IF EXISTS (
                        SELECT 1
                        FROM marketplace_listings
                        WHERE marketplace_connection_id =
                              NEW.marketplace_connection_id
                          AND external_listing_id =
                              NEW.external_listing_id
                          AND deleted_at IS NULL
                    ) THEN
                        SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "External listing ID already exists for this marketplace connection";
                    END IF;

                END IF;
            END
        ');

        DB::unprepared('
            CREATE TRIGGER marketplace_listings_ext_listing_update
            BEFORE UPDATE ON marketplace_listings
            FOR EACH ROW
            BEGIN
                IF NEW.external_listing_id IS NOT NULL
                   AND NEW.deleted_at IS NULL THEN

                    IF EXISTS (
                        SELECT 1
                        FROM marketplace_listings
                        WHERE marketplace_connection_id =
                              NEW.marketplace_connection_id
                          AND external_listing_id =
                              NEW.external_listing_id
                          AND deleted_at IS NULL
                          AND id <> OLD.id
                    ) THEN
                        SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "External listing ID already exists for this marketplace connection";
                    END IF;

                END IF;
            END
        ');


        /*
         * ================================================================
         * 7. EXTERNAL PRODUCT ID
         * ================================================================
         */

        DB::unprepared('
            CREATE TRIGGER marketplace_listings_ext_product_insert
            BEFORE INSERT ON marketplace_listings
            FOR EACH ROW
            BEGIN
                IF NEW.external_product_id IS NOT NULL
                   AND NEW.deleted_at IS NULL THEN

                    IF EXISTS (
                        SELECT 1
                        FROM marketplace_listings
                        WHERE marketplace_connection_id =
                              NEW.marketplace_connection_id
                          AND external_product_id =
                              NEW.external_product_id
                          AND deleted_at IS NULL
                    ) THEN
                        SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "External product ID already exists for this marketplace connection";
                    END IF;

                END IF;
            END
        ');

        DB::unprepared('
            CREATE TRIGGER marketplace_listings_ext_product_update
            BEFORE UPDATE ON marketplace_listings
            FOR EACH ROW
            BEGIN
                IF NEW.external_product_id IS NOT NULL
                   AND NEW.deleted_at IS NULL THEN

                    IF EXISTS (
                        SELECT 1
                        FROM marketplace_listings
                        WHERE marketplace_connection_id =
                              NEW.marketplace_connection_id
                          AND external_product_id =
                              NEW.external_product_id
                          AND deleted_at IS NULL
                          AND id <> OLD.id
                    ) THEN
                        SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "External product ID already exists for this marketplace connection";
                    END IF;

                END IF;
            END
        ');


        /*
         * ================================================================
         * 8. EXTERNAL SKU
         * ================================================================
         */

        DB::unprepared('
            CREATE TRIGGER marketplace_listings_ext_sku_insert
            BEFORE INSERT ON marketplace_listings
            FOR EACH ROW
            BEGIN
                IF NEW.external_sku IS NOT NULL
                   AND NEW.deleted_at IS NULL THEN

                    IF EXISTS (
                        SELECT 1
                        FROM marketplace_listings
                        WHERE marketplace_connection_id =
                              NEW.marketplace_connection_id
                          AND external_sku =
                              NEW.external_sku
                          AND deleted_at IS NULL
                    ) THEN
                        SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "External SKU already exists for this marketplace connection";
                    END IF;

                END IF;
            END
        ');

        DB::unprepared('
            CREATE TRIGGER marketplace_listings_ext_sku_update
            BEFORE UPDATE ON marketplace_listings
            FOR EACH ROW
            BEGIN
                IF NEW.external_sku IS NOT NULL
                   AND NEW.deleted_at IS NULL THEN

                    IF EXISTS (
                        SELECT 1
                        FROM marketplace_listings
                        WHERE marketplace_connection_id =
                              NEW.marketplace_connection_id
                          AND external_sku =
                              NEW.external_sku
                          AND deleted_at IS NULL
                          AND id <> OLD.id
                    ) THEN
                        SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "External SKU already exists for this marketplace connection";
                    END IF;

                END IF;
            END
        ');


        /*
         * ================================================================
         * 9. REFUND EXTERNAL ID
         * ================================================================
         */

        DB::unprepared('
            CREATE TRIGGER refunds_external_insert
            BEFORE INSERT ON refunds
            FOR EACH ROW
            BEGIN
                IF NEW.external_refund_id IS NOT NULL THEN

                    IF EXISTS (
                        SELECT 1
                        FROM refunds
                        WHERE order_id = NEW.order_id
                          AND external_refund_id =
                              NEW.external_refund_id
                    ) THEN
                        SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "External refund ID already exists for this order";
                    END IF;

                END IF;
            END
        ');

        DB::unprepared('
            CREATE TRIGGER refunds_external_update
            BEFORE UPDATE ON refunds
            FOR EACH ROW
            BEGIN
                IF NEW.external_refund_id IS NOT NULL THEN

                    IF EXISTS (
                        SELECT 1
                        FROM refunds
                        WHERE order_id = NEW.order_id
                          AND external_refund_id =
                              NEW.external_refund_id
                          AND id <> OLD.id
                    ) THEN
                        SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "External refund ID already exists for this order";
                    END IF;

                END IF;
            END
        ');


        /*
         * ================================================================
         * 10. PAYMENT EXTERNAL ID
         * ================================================================
         */

        DB::unprepared('
            CREATE TRIGGER order_payments_external_insert
            BEFORE INSERT ON order_payments
            FOR EACH ROW
            BEGIN
                IF NEW.external_payment_id IS NOT NULL THEN

                    IF EXISTS (
                        SELECT 1
                        FROM order_payments
                        WHERE order_id = NEW.order_id
                          AND external_payment_id =
                              NEW.external_payment_id
                    ) THEN
                        SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "External payment ID already exists for this order";
                    END IF;

                END IF;
            END
        ');

        DB::unprepared('
            CREATE TRIGGER order_payments_external_update
            BEFORE UPDATE ON order_payments
            FOR EACH ROW
            BEGIN
                IF NEW.external_payment_id IS NOT NULL THEN

                    IF EXISTS (
                        SELECT 1
                        FROM order_payments
                        WHERE order_id = NEW.order_id
                          AND external_payment_id =
                              NEW.external_payment_id
                          AND id <> OLD.id
                    ) THEN
                        SIGNAL SQLSTATE "45000"
                        SET MESSAGE_TEXT = "External payment ID already exists for this order";
                    END IF;

                END IF;
            END
        ');
    }

    public function down(): void
    {
        /*
         * Drop triggers first.
         */

        DB::unprepared(
            'DROP TRIGGER IF EXISTS brands_global_slug_insert'
        );

        DB::unprepared(
            'DROP TRIGGER IF EXISTS brands_global_slug_update'
        );

        DB::unprepared(
            'DROP TRIGGER IF EXISTS categories_global_slug_insert'
        );

        DB::unprepared(
            'DROP TRIGGER IF EXISTS categories_global_slug_update'
        );

        DB::unprepared(
            'DROP TRIGGER IF EXISTS product_variants_default_insert'
        );

        DB::unprepared(
            'DROP TRIGGER IF EXISTS product_variants_default_update'
        );

        DB::unprepared(
            'DROP TRIGGER IF EXISTS product_categories_primary_insert'
        );

        DB::unprepared(
            'DROP TRIGGER IF EXISTS product_categories_primary_update'
        );

        DB::unprepared(
            'DROP TRIGGER IF EXISTS marketplace_listings_ext_listing_insert'
        );

        DB::unprepared(
            'DROP TRIGGER IF EXISTS marketplace_listings_ext_listing_update'
        );

        DB::unprepared(
            'DROP TRIGGER IF EXISTS marketplace_listings_ext_product_insert'
        );

        DB::unprepared(
            'DROP TRIGGER IF EXISTS marketplace_listings_ext_product_update'
        );

        DB::unprepared(
            'DROP TRIGGER IF EXISTS marketplace_listings_ext_sku_insert'
        );

        DB::unprepared(
            'DROP TRIGGER IF EXISTS marketplace_listings_ext_sku_update'
        );

        DB::unprepared(
            'DROP TRIGGER IF EXISTS refunds_external_insert'
        );

        DB::unprepared(
            'DROP TRIGGER IF EXISTS refunds_external_update'
        );

        DB::unprepared(
            'DROP TRIGGER IF EXISTS order_payments_external_insert'
        );

        DB::unprepared(
            'DROP TRIGGER IF EXISTS order_payments_external_update'
        );


        /*
         * Drop normal unique index.
         */

        Schema::table('order_addresses', function (Blueprint $table) {
            $table->dropUnique('oa_order_type_unique');
        });
    }
};
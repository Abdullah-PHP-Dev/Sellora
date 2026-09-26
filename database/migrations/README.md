# Sellora — Production Laravel Migrations

This package contains the Sellora commerce/multimarketplace database migrations.

## Assumptions
- Laravel 11/12 style migrations.
- PostgreSQL is the target database.
- The existing Laravel `users`, `password_reset_tokens`, and `sessions` tables are already implemented and are intentionally NOT included.
- Run these migrations after the existing authentication migration.
- Sensitive marketplace credentials must be encrypted by the application before persistence; API logs must redact credentials/tokens.

## Migration order
The files are numbered to respect foreign-key dependencies.

## Core architecture
Users → Merchants → Stores → Catalog → Marketplace Connections → Listings → Inventory / Orders / Fulfillment → Integration/Audit.

## Important implementation notes
1. `merchant_id` is the tenant boundary.
2. Orders and other historical records should not be deleted merely because a marketplace connection is disconnected.
3. External IDs are scoped to the marketplace connection/provider.
4. `inventory_movements` is the inventory audit ledger.
5. `marketplace_connection_credentials` contains encrypted secret material only.
6. PostgreSQL partial indexes are used in the final integrity migration.
7. Application services should validate that child records and referenced records belong to the same merchant.

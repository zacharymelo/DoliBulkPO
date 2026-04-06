# Bulk PO — Dolibarr Module

Bulk product selection wizard for creating Supplier Purchase Orders in [Dolibarr ERP/CRM](https://www.dolibarr.org/).

Select a vendor, browse and filter products, pick quantities, and create a draft Purchase Order with all lines in a single action — no more adding products one at a time on the order card.

## Features

- **Bulk product selection** — paginated, searchable product list with Select All and per-item quantity inputs
- **Vendor product filtering** — toggle between all purchasable products and only those with a known price from the selected vendor (AJAX-driven, no page reload)
- **Staging area** — review selected products, adjust quantities, and remove items before creating the order
- **Auto-fill vendor defaults** — payment terms and payment mode are automatically populated from the vendor's settings when selected
- **Order-level fields** — set payment terms, payment mode, planned delivery date, supplier reference, and project link directly in the wizard
- **Configurable price priority** — when "Include buy prices" is checked, line prices are sourced in a configurable priority order: vendor price, best supplier price, cost price, or PMP (weighted average)
- **Session persistence** — product selections survive pagination via sessionStorage (tab-scoped, auto-clears on tab close)

## Requirements

| Requirement | Version |
|-------------|---------|
| Dolibarr | 16.0+ |
| PHP | 7.0+ |
| Dolibarr modules | Suppliers (`fournisseur`), Products (`product`) |

## Installation

1. Download `bulkpo-<version>.zip` from [Releases](../../releases)
2. In Dolibarr, go to **Home > Setup > Modules/Applications**
3. Click **Deploy/install an external module** and upload the zip
4. Enable **Bulk PO** in the module list (under SRM category)

Or manually extract the zip into `htdocs/custom/` so that the module descriptor lands at `htdocs/custom/bulkpo/core/modules/modBulkpo.class.php`.

## Usage

1. Navigate to **Commercial > Supplier Orders > Bulk Purchase Order**
2. Select a vendor — payment terms and mode auto-fill from the vendor's defaults
3. Optionally set a delivery date, supplier reference, or project
4. Browse products (search by ref or label, toggle vendor-only filter)
5. Check products and set quantities — selections appear in the staging area
6. Optionally enable **Include buy prices** to pre-fill line prices
7. Click **Create Purchase Order**
8. You are redirected to the new draft order card to review, validate, and send

## Configuration

Go to **Home > Setup > Modules > Bulk PO Setup** to configure:

- **Price source priority** — drag-and-drop to reorder which price source is tried first when "Include buy prices" is enabled
- **Debug mode** — enables a diagnostic endpoint at `/custom/bulkpo/ajax/debug.php` (admin only)

## Permissions

The module reuses Dolibarr's built-in supplier order permissions:

- **Read** the wizard page: `fournisseur > commande > lire`
- **Create** purchase orders: `fournisseur > commande > creer`

No custom permission entries are added.

## License

GPLv3 — see [LICENSE](https://www.gnu.org/licenses/gpl-3.0.html)

<?php
/* Copyright (C) 2026 Zachary Melo
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 */

include_once DOL_DOCUMENT_ROOT.'/core/modules/DolibarrModules.class.php';

/**
 * Class modBulkpo
 *
 * Module descriptor for the Bulk PO (Bulk Purchase Order) module
 */
class modBulkpo extends DolibarrModules
{
	/**
	 * Constructor
	 *
	 * @param DoliDB $db Database handler
	 */
	public function __construct($db)
	{
		global $langs, $conf;

		$this->db = $db;

		$this->numero = 510401;
		$this->family = 'srm';
		$this->module_position = '90';
		$this->name = preg_replace('/^mod/i', '', get_class($this));
		$this->description = 'Bulk product selection wizard for creating Supplier Purchase Orders';
		$this->version = '1.0.1';
		$this->const_name = 'MAIN_MODULE_'.strtoupper($this->name);
		$this->picto = 'supplier_order';

		$this->module_parts = array();

		$this->dirs = array();
		$this->config_page_url = array('setup.php@bulkpo');

		$this->depends = array('modFournisseur', 'modProduct');
		$this->requiredby = array();
		$this->conflictwith = array();

		$this->langfiles = array('bulkpo@bulkpo');

		$this->phpmin = array(7, 0);
		$this->need_dolibarr_version = array(16, 0);

		// No custom constants
		$this->const = array();

		// No custom permissions — reuses fournisseur commande creer
		$this->rights = array();
		$this->rights_class = 'bulkpo';

		// Menus — inject under Supplier Orders in Commercial sidebar
		$this->menu = array();
		$r = 0;

		$this->menu[$r++] = array(
			'fk_menu'  => 'fk_mainmenu=commercial,fk_leftmenu=orders_suppliers',
			'type'     => 'left',
			'titre'    => 'BulkPurchaseOrder',
			'mainmenu' => 'commercial',
			'leftmenu' => 'bulkpo',
			'url'      => '/bulkpo/bulkpo_wizard.php',
			'langs'    => 'bulkpo@bulkpo',
			'position' => 301,
			'enabled'  => 'isModEnabled("fournisseur")',
			'perms'    => '$user->hasRight("fournisseur", "commande", "creer")',
			'target'   => '',
			'user'     => 0,
		);
	}

	/**
	 * Function called when module is enabled
	 *
	 * @param  string $options Options when enabling module
	 * @return int             1 if OK, 0 if KO
	 */
	public function init($options = '')
	{
		// Clean old menus before _init() calls insert_menus() to avoid duplicates on re-enable
		$this->delete_menus();

		return $this->_init(array(), $options);
	}

	/**
	 * Function called when module is disabled
	 *
	 * @param  string $options Options when disabling module
	 * @return int             1 if OK, 0 if KO
	 */
	public function remove($options = '')
	{
		return $this->_remove(array(), $options);
	}
}

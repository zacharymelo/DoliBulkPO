<?php
/* Copyright (C) 2026 Zachary Melo
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 */

/**
 * \file    ajax/vendor_defaults.php
 * \ingroup bulkpo
 * \brief   Returns the default payment terms and payment mode for a vendor.
 *
 * GET params:
 *   socid (int) — vendor/supplier ID
 *
 * Returns JSON: {cond_reglement_id: int, mode_reglement_id: int}
 */

$res = 0;
if (!$res && file_exists("../../main.inc.php")) {
	$res = @include "../../main.inc.php";
}
if (!$res && file_exists("../../../main.inc.php")) {
	$res = @include "../../../main.inc.php";
}
if (!$res && file_exists("../../../../main.inc.php")) {
	$res = @include "../../../../main.inc.php";
}
if (!$res) {
	http_response_code(500);
	exit;
}

if (!$user->id || !$user->hasRight('fournisseur', 'commande', 'lire')) {
	http_response_code(403);
	exit;
}

$socid = GETPOSTINT('socid');

$result = array(
	'cond_reglement_id' => 0,
	'mode_reglement_id' => 0,
);

if ($socid > 0) {
	require_once DOL_DOCUMENT_ROOT.'/societe/class/societe.class.php';

	$soc = new Societe($db);
	if ($soc->fetch($socid) > 0) {
		$result['cond_reglement_id'] = (int) $soc->cond_reglement_supplier_id;
		$result['mode_reglement_id'] = (int) $soc->mode_reglement_supplier_id;

		// Fallback to general defaults if supplier-specific not set
		if ($result['cond_reglement_id'] <= 0) {
			$result['cond_reglement_id'] = (int) $soc->cond_reglement_id;
		}
		if ($result['mode_reglement_id'] <= 0) {
			$result['mode_reglement_id'] = (int) $soc->mode_reglement_id;
		}
	}
}

header('Content-Type: application/json');
print json_encode($result);

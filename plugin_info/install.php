<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';

function lgthinq2_install() {
	$cron = cron::byClassAndFunction('lgthinq2', 'update');
	if (!is_object($cron)) {
		$cron = new cron();
		$cron->setClass('lgthinq2');
		$cron->setFunction('update');
		$cron->setEnable(1);
		$cron->setDeamon(0);
		$cron->setSchedule('* * * * *');
		$cron->setTimeout(30);
		$cron->save();
	}
}

function lgthinq2_update() {
	$cron = cron::byClassAndFunction('lgthinq2', 'update');
	if (!is_object($cron)) {
		$cron = new cron();
	}
	$cron->setClass('lgthinq2');
	$cron->setFunction('update');
	$cron->setEnable(1);
	$cron->setDeamon(0);
	$cron->setSchedule('* * * * *');
	$cron->setTimeout(30);
	$cron->save();
	$cron->stop();
    foreach (eqLogic::byType('lgthinq2') as $eqLogic) {
      if ($eqLogic->getConfiguration('macID') == $eqLogic->getLogicalId()) {
          $eqLogic->setLogicalId($eqLogic->getConfiguration('uuid'), $eqLogic->getConfiguration('macID'))->save();
      }
    }

}

function lgthinq2_remove() {
	$cron = cron::byClassAndFunction('lgthinq2', 'update');
	if (is_object($cron)) {
		$cron->remove();
	}
}

?>

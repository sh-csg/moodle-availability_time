<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin strings are defined here.
 *
 * @package     availability_time
 * @category    string
 * @copyright   2022 Stefan Hanauska <stefan.hanauska@altmuehlnet.de>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Restriction by time';
$string['title'] = 'Time';
$string['description'] = 'Restrict access to a certain period of time (every day)';
$string['from'] = 'from';
$string['requires_certain_time'] = 'Requires certain time';
$string['requires_time'] = 'Requires time from {$a->from} to {$a->to}';
$string['requires_not_time'] = 'Requires time outside of {$a->from} to {$a->to}';
$string['to'] = 'to';
$string['privacy:metadata'] = 'This plugin doesn\'t store any personal data itself.';

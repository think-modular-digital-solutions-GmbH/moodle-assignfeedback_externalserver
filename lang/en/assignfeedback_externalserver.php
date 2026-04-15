<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Language strings for the external server feedback plugin.
 *
 * @package    assignfeedback_externalserver
 * @author     Stefan Weber (stefan.weber@think-modular.com)
 * @copyright  2025 think-modular
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['batchlabel'] = 'Get grades from external server';
$string['enabled'] = 'Enabled';
$string['enabled_help'] = 'Enables the retrieval of grades and feedback for multiple participants from an external server. This feature is available under the “Submissions” tab.
<p><strong>Please note the following regarding this feature:</strong></p>
<ul><li>In the ‘Submissions’ tab, in the “Get grades for submission to external server” column, a submission can be graded via the external server by clicking the “Get grade” button</li>
<li>This column remains empty until students have submitted their work</li>
<li>If students need to be graded by the external server despite not having submitted anything, use the multiple grading feature</li>
<li>To do this, check the boxes in the left column of the table and select the “Get grades from external Server” option in the footer menu</li></ul>';
$string['getgradesfromexternalserver'] = 'Get grades from external server';
$string['getgradesfromexternalserver_confirm'] = 'Are you sure you want to get grades from the external server for the selected users? This will overwrite any existing grades and feedbacks. This action cannot be undone.';
$string['gradeverb'] = 'Get grade';
$string['pluginname'] = 'Get grades for submission to external server';
$string['privacy:metadata'] = 'Get grades for submission to external server plugin does not store any personal data.';

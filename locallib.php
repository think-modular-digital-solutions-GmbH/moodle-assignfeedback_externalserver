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
 * Library file for external server feedback plugin
 *
 * @package    assignfeedback_external_server
 * @author     Stefan Weber (stefan.weber@think-modular.com)
 * @copyright  2025 think-modular
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Library class for external server feedback plugin
 *
 * @package    assignfeedback_external_server
 * @author     Stefan Weber (stefan.weber@think-modular.com)
 * @copyright  2025 think-modular
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class assign_feedback_external_server extends assign_feedback_plugin {

    /**
     * Get the name of the submission plugin
     * @return string
     */
    public function get_name(): string {
        return get_string('pluginname', 'assignfeedback_external_server');
    }

    /**
     * Return a list of the batch grading operations supported by this plugin.
     *
     * @return array - An array of action and description strings.
     *                 The action will be passed to grading_batch_operation.
     * @deprecated since 4.5, use get_grading_batch_operation_details() instead.
     * @todo Final deprecation in Moodle 6.0. See MDL-82856.
     */
    public function get_grading_batch_operations() {
        return array_column(static::get_grading_batch_operation_details(), 'confirmationtitle', 'key');
    }

    /**
     * Adds our batch operation to the list of grading batch operations if enabled.
     *
     * @return array
     */
    public function get_grading_batch_operation_details() {
        $action = new stdClass();
        $action->key = 'getgradesfromexternalserver';
        $action->label = get_string('gradeverb', 'assignsubmission_external_server');
        $action->icon = 'i/reload';
        $action->confirmationtitle = get_string('getgradesfromexternalserver', 'assignfeedback_external_server');
        $action->confirmationquestion = get_string('getgradesfromexternalserver_confirm', 'assignfeedback_external_server');
        return [$action];
    }

    /**
     * Show a batch operations form
     *
     * @param string $action The action chosen from the batch operations menu
     * @param array $users The list of selected userids
     * @return string The page containing the form
     */
    public function grading_batch_operation($action, $users) {

        if ($action !== 'getgradesfromexternalserver') {
            return '';
        }

        // Do your work (loop $users, call external, update grades, etc.)
        try {
            foreach ($users as $userid) {
                // ... your logic ...
            }
            \core\notification::success(get_string('gradesupdated', 'assignfeedback_external_server'));
        } catch (\Throwable $e) {
            \core\notification::error($e->getMessage());
        }

        // Important: redirect. Returning a string won't navigate.
        redirect(new \moodle_url('/asdf', [
            'id' => $this->assignment->get_course_module()->id,
            'action' => 'grading',
        ]));

        return ''; // Not reached.
    }

    /**
     * Show a grading action form
     *
     * @param string $gradingaction The action chosen from the grading actions menu
     * @return string The page containing the form
     */
    public function grading_action($gradingaction) {

        echo "<pre>";
        var_dump($gradingaction);
        die();

    }

}

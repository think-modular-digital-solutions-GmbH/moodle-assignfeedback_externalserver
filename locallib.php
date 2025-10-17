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
 * @package    assignfeedback_externalserver
 * @author     Stefan Weber (stefan.weber@think-modular.com)
 * @copyright  2025 think-modular
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Library class for external server feedback plugin
 *
 * @package    assignfeedback_externalserver
 * @author     Stefan Weber (stefan.weber@think-modular.com)
 * @copyright  2025 think-modular
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class assign_feedback_externalserver extends assign_feedback_plugin {

    /**
     * Get the name of the submission plugin
     * @return string
     */
    public function get_name(): string {
        return get_string('pluginname', 'assignfeedback_externalserver');
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
        global $OUTPUT;

        return [
            (object) [
                'key' => 'getgradesfromexternalserver',
                'label' => get_string('batchlabel', 'assignfeedback_externalserver'),
                'icon' => $OUTPUT->pix_icon('t/download', ''),
                'confirmationtitle' => get_string('getgradesfromexternalserver', 'assignfeedback_externalserver'),
                'confirmationquestion' => get_string('getgradesfromexternalserver_confirm', 'assignfeedback_externalserver'),
            ],
        ];
        $action = new stdClass();
        $action->key = 'getgradesfromexternalserver';
        $action->label = get_string('gradeverb', 'assignsubmission_externalserver');
        $action->icon = 'i/reload';
        $action->confirmationtitle = get_string('getgradesfromexternalserver', 'assignfeedback_externalserver');
        $action->confirmationquestion = get_string('getgradesfromexternalserver_confirm', 'assignfeedback_externalserver');
        return [$action];
    }

    /**
     * Show a batch operations form
     *
     * @param string $action The action chosen from the batch operations menu
     * @param array $userids The list of selected userids
     * @return string The page containing the form
     */
    public function grading_batch_operation($action, $userids) {

        // Grade.
        if ($action == 'getgradesfromexternalserver') {
            $ext = $this->assignment->get_plugin_by_type('assignsubmission', 'externalserver')->get_externalserver();
            $result = $ext->grade_submissions($this->assignment, $userids);
        }

        // Create notification.
        if (!empty($result->errors)) {
            $this->assignment->add_message(
                get_string('someerrorsoccurred', 'assignfeedback_externalserver', ['errors' => implode(', ', $result->errors)]),
                \core\output\notification::NOTIFY_ERROR
            );
        }

        // Create notification.
        $status = $result['status'];
        $message = $result['message'];
        \core\notification::add($message, $status);

        // Reroute back to grading page.
        $cmid = $this->assignment->get_course_module()->id;
        $url = new moodle_url('/mod/assign/view.php', [
            'id' => $cmid,
            'action' => 'grading'
        ]);
        redirect($url);
    }

    /**
     * Has the plugin form element been modified in the current submission?
     *
     * @param stdClass $grade The grade.
     * @param stdClass $data Form data from the feedback form.
     * @return boolean - True if the form element has been modified.
     */
    public function is_feedback_modified(stdClass $grade, stdClass $data) {
        return false;
    }

}

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
 * Version information for plugin gradingform_mathsa
 *
 * @package    gradingform_mathsa
 * @copyright  2019 Filip Moons <filip.moons@uantwerpen.be> - www.mathsa.org
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/grade/grading/form/lib.php');

/**
 * Version information for plugin gradingform_mathsa
 *
 * @package    gradingform_mathsa
 * @copyright  2019 Filip Moons <filip.moons@uantwerpen.be> - www.mathsa.org
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class gradingform_mathsa_controller extends gradingform_controller {
    // Modes of displaying the enriched rubric (used in gradingform_erubric_renderer)


    // Constants used for enriched rubric default field values.

    /**
     * Extends the module settings navigation with the enriched rubric grading settings.
     *
     * This function is called when the context for the page is an activity module with the
     * FEATURE_ADVANCED_GRADING, the user has the permission moodle/grade:managegradingforms
     * and there is an area with the active grading method set to 'erubric'.
     *
     * @param settings_navigation $settingsnav {@link settings_navigation}
     * @param navigation_node $node {@link navigation_node}
     */
    public function extend_settings_navigation(settings_navigation $settingsnav, navigation_node $node=null) {

        $node->add(get_string('defineassessment', 'gradingform_mathsa'),
            $this->get_editor_url(), settings_navigation::TYPE_CUSTOM,
            null, null, new pix_icon('icon', '', 'gradingform_mathsa'));
    }

    /**
     * Extends the module navigation
     *
     * This function is called when the context for the page is an activity module with the
     * FEATURE_ADVANCED_GRADING and there is an area with the active grading method set to the given plugin.
     *
     * @param global_navigation $navigation {@link global_navigation}
     * @param navigation_node $node {@link navigation_node}
     */
    public function extend_navigation(global_navigation $navigation, navigation_node $node=null) {
        if (has_capability('moodle/grade:managegradingforms', $this->get_context())) {
            // No need for preview if user can manage forms, he will have link to manage.php in settings instead.
            return;
        }
        if ($this->is_form_defined() && ($options = $this->get_options()) && !empty($options['alwaysshowdefinition'])) {
            $node->add(get_string('gradingof', 'gradingform_mathsa', get_grading_manager($this->get_areaid())->get_area_title()),
                    new moodle_url('/grade/grading/form/'.$this->get_method_name().'/preview.php', array('areaid' => $this->get_areaid())),
                    settings_navigation::TYPE_CUSTOM);
        }
    }


}
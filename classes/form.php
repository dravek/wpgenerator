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
 * @package    tool_wpgenerator
 * @copyright  2020 David Matamoros <davidmc@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

global $CFG;

require_once(__DIR__ . '/../../../../config.php');
require_once($CFG->libdir . '/formslib.php');

class tool_wpgenerator_form extends moodleform {

    public function definition() {
        $mform = $this->_form;

        $html = html_writer::tag('div', get_string('formmsg', 'tool_wpgenerator'));
        $mform->addElement('static', 'formmsg', '', $html);

        // Generate program section.
        $mform->addElement('header', 'program', 'Program');
        $mform->setExpanded('program', true);

        // Program fullname.
        $mform->addElement('text', 'fullname', get_string('programfullname', 'tool_wpgenerator'));
        $mform->setType('fullname', PARAM_TEXT);
        $missingfullnamestr = get_string('missingfullname', 'tool_wpgenerator');
        $mform->addRule('fullname', $missingfullnamestr, 'required', null, 'client');

        $this->add_action_buttons(false, get_string('generateprogram', 'tool_wpgenerator'));
    }
}
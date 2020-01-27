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
 * Class generator
 *
 * @package    tool_wpgenerator
 * @copyright  2020 David Matamoros <davidmc@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_wpgenerator;

use stdClass;
use testing_data_generator;
use tool_program\persistent\program;
use tool_program_generator;

defined('MOODLE_INTERNAL') || die();

/**
 * Class generator
 *
 * @package    tool_wpgenerator
 * @copyright  2020 David Matamoros <davidmc@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class generator {

    /** @var tool_program_generator Program generator*/
    protected $programgenerator;

    /** @var testing_data_generator Data generator */
    protected $coursegenerator;


    public function __construct() {
        global $CFG;
        require_once($CFG->dirroot . '/lib/phpunit/classes/util.php');

        $this->programgenerator = \phpunit_util::get_data_generator()->get_plugin_generator('tool_program');
        $this->coursegenerator = \phpunit_util::get_data_generator();
    }

   public function generate_program(stdClass $data): program {
        $programdata = (object)[];
       if (isset($data->fullname)) {
           $programdata->fullname = format_string($data->fullname);
       }


       $program = $this->programgenerator->generate_program($programdata);
       $baseset = $program->get_base_set();

       $shortname = 'course_1' . time();
       $course1 = $this->coursegenerator->create_course(['enablecompletion' => true, 'shortname' => $shortname]);
       $assign1 = $this->coursegenerator->create_module('assign', ['course' => $course1->id], ['completion' => 1]);
       $programcourse1 = $this->programgenerator->add_course_to_set($course1->id, $baseset->get('id'), 1);
       $this->programgenerator->enable_program_enrol_instance($programcourse1);

       $shortname = 'course_2' . time();
       $course2 = $this->coursegenerator->create_course(['enablecompletion' => true, 'shortname' => $shortname]);
       $assign2 = $this->coursegenerator->create_module('assign', ['course' => $course2->id], ['completion' => 1]);
       $programcourse2 = $this->programgenerator->add_course_to_set($course2->id, $baseset->get('id'), 2);
       $this->programgenerator->enable_program_enrol_instance($programcourse2);

       $shortname = 'course_3' . time();
       $course3 = $this->coursegenerator->create_course(['enablecompletion' => true, 'shortname' => $shortname]);
       $assign3 = $this->coursegenerator->create_module('assign', ['course' => $course3->id], ['completion' => 1]);
       $programcourse3 = $this->programgenerator->add_course_to_set($course3->id, $baseset->get('id'), 3);
       $this->programgenerator->enable_program_enrol_instance($programcourse3);

       return $program;
   }
}
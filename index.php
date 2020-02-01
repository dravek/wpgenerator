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

require_once(__DIR__ . '/../../../config.php');

require_login();

// Check debugging is set to DEVELOPER.
if (!debugging('', DEBUG_DEVELOPER)) {
    echo $OUTPUT->nxxotification(get_string('error_notdebugging', 'tool_generator'));
    echo $OUTPUT->footer();
    exit;
}

$url = new moodle_url('/admin/tool/wpgenerator/index.php');

$wpgeneratorstr = get_string('pluginname', 'tool_wpgenerator');
$PAGE->set_context(context_system::instance());
$PAGE->set_url($url);
$PAGE->set_pagelayout('report');
$PAGE->set_title($wpgeneratorstr);
$PAGE->set_heading($wpgeneratorstr);
$PAGE->navbar->add(get_string('home'), new moodle_url($url));

$mform = new tool_wpgenerator_form(null,  []);

// Process Form data.
if ($mform->is_cancelled()) {
    redirect($url);
} else if ($data = $mform->get_data()) {

    $generator = new \tool_wpgenerator\generator();
    $generator->generate_program($data);

    $programcreatedstr = get_string('programcreated', 'tool_wpgenerator');
    redirect($url, $programcreatedstr, null, \core\output\notification::NOTIFY_SUCCESS);

}

// Display form.
echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
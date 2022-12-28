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
 * Condition to restrict access by time
 *
 * @package     availability_time
 * @copyright   2022 Stefan Hanauska <stefan.hanauska@altmuehlnet.de>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace availability_time;

/**
 * Condition to restrict access by user
 */
class condition extends \core_availability\condition {
    /**
     * @var int Starting time.
     */
    protected $from;

    /**
     * @var int End time.
     */
    protected $to;

    /**
     * @var bool Whether the time period contains midnight.
     */
    protected $overnight;

    /**
     * Constructor
     *
     * @param  \stdClass $structure Data structure from JSON decode
     * @return void
     */
    public function __construct($structure) {
        $this->from = $structure->from;
        $this->to = $structure->to;
        $this->overnight = $this->from > $this->to;
        $tz = \date_default_timezone_get();
        \date_default_timezone_set('UTC');
        $this->fromstring = date('H:i', $structure->from);
        $this->tostring = date('H:i', $structure->to);
        \date_default_timezone_set($tz);
    }

    /**
     * Saves tree data back to a structure object.
     *
     * @return \stdClass Structure object (ready to be made into JSON format)
     */
    public function save() {
        return (object)[
            'type' => 'time',
            'from' => $this->from,
            'to' => $this->to,
        ];
    }

    /**
     * Determines whether this item is availabile.
     *
     * @param  bool $not Set true if we are inverting the condition
     * @param  \core_availability\info $info Item we're checking
     * @param  bool $grabthelot if true, caches information required for all course-modules
     * @param  int $userid User ID to check availability for
     * @return bool true if available
     */
    public function is_available($not, \core_availability\info $info, $grabthelot, $userid) {
        $user = \core_user::get_user($userid);
        $timezone = \core_date::get_user_timezone_object($user);
        $offset = (new \DateTime("now", $timezone))->getOffset();
        $time = (time() + $offset) % 86400;
        if ($this->overnight) {
            return $not ^ ($time <= $this->to || $time >= $this->from);
        } else {
            return $not ^ ($time <= $this->to && $time >= $this->from);
        }
    }

    /**
     * Obtains a string describing this restriction (whether or not it actually applies).
     *
     * @param  bool $full Set true if this is the 'full information' view
     * @param  bool $not Set true if we are inverting the condition
     * @param  \core_availability\info $info Item we're checking
     * @return string Information string (for admin) about all restrictions on this item
     */
    public function get_description($full, $not, \core_availability\info $info) {
        if ($full) {
                return get_string(
                    'requires_' . ($not ? 'not_' : '') . 'time',
                    'availability_time',
                    ['from' => $this->fromstring, 'to' => $this->tostring]
                );
        } else {
            return get_string('requires_certain_time', 'availability_time');
        }
    }

    /**
     * Obtains a representation of the options of this condition as a string, for debugging.
     *
     * @return string Id of requested user
     */
    protected function get_debug_string() {
        return $this->from . ' - '. $this->to;
    }
}

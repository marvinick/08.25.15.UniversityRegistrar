<?php
    class Course
    {
        private $course_name;
        private $course_code;
        private $id;

        function __construct($course_name, $course_code, $id=null)
        {
            $this->course_name = $course_name;
            $this->course_code = $course_code;
            $this->id = $id;
        }

        function getCourseName()
        {
            return $this->course_name;
        }

        function getCourseCode()
        {
            return $this->course_code;
        }

        function getId()
        {
            return $this->id;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses;");
        }

    }
?>

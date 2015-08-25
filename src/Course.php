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

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO courses (course_name, course_code) VALUES ('{$this->getCourseName()}', '{$this->getCourseCode()}');");

            $this->id=$GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses ORDER BY course_name;");
            $courses = array();
            foreach($returned_courses as $course)
            {
                $course_name = $course['course_name'];
                $course_code = $course['course_code'];
                $id = $course['id'];
                $new_course = new Course($course_name, $course_code, $id);
                array_push($courses, $new_course);
            }

            return $courses;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses;");
        }
    }
?>

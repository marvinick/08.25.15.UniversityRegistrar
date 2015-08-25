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

        function setCourseName($new_course_name)
        {
            $this->course_name = $new_course_name;

        }

        function setCourseCode($new_course_code)
        {
            $this->course_code = $new_course_code;
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

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses WHERE id = {$this->getId()};");

        }

        function update($new_course_name, $new_course_code)
        {
            $GLOBALS['DB']->exec("UPDATE courses SET course_name = '{$new_course_name}', course_code = '{$new_course_code}' WHERE id = {$this->getId()};");
            $this->setCourseName($new_course_name);
            $this->setCourseCode($new_course_code);

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

        static function find($search_id)
        {
            $found_course = null;
            $courses = Course::getAll();
            foreach($courses as $course)
            {
                $course_id = $course->getId();
                if($course_id == $search_id) {
                    $found_course = $course;
                }

            }

            return $found_course;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses;");
        }
    }
?>

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


        //NOT WORKING
        function addStudent($student)
        {
            $GLOBALS['DB']->exec("INSERT INTO student_enrollments (student_id, course_id) VALUES ({$student->getId()}, {$this->getId()};");
        }

        //NOT WORKING
        function getStudents()
        {
            $returned_students = $GLOBALS['DB']->query("SELECT students.* FROM courses
                            JOIN student_enrollments ON (courses.id = student_enrollments.course_id)
                            JOIN students ON (student_enrollments.student_id = students.id)
                            WHERE courses.id = {$this->getId()}
                            ORDER BY student_name;");

            $students = array();
            foreach($returned_students as $student)
            {
                $student_name = $student['student_name'];
                $enrollment_date = $student['enrollment_date'];
                $id = $student['id'];
                $new_student = new Student($student_name, $enrollment_date, $id);
                array_push($students, $new_student);
            }
            return $students;
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

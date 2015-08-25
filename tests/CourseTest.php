<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Course.php";
    require_once "src/Student.php";

    $server = 'mysql:host=localhost; dbname=registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Course::deleteAll();
        }

        function testGetCourseName()
        {
            $course_name = "History";
            $course_code = "HIST100";
            $test_course = new Course($course_name, $course_code);

            $result = $test_course->getCourseName();

            $this->assertEquals($course_name, $result);
        }

        function testGetCourseCode()
        {
            $course_name = "History";
            $course_code = "HIST100";
            $test_course = new Course($course_name, $course_code);

            $result = $test_course->getCourseCode();

            $this->assertEquals($course_code, $result);
        }

        function testGetId()
        {
            $course_name = "History";
            $course_code = "HIST100";
            $test_course = new Course($course_name, $course_code);

            $result = $test_course->getId();

            $this->assertEquals(null, $result);
        }
    }


?>

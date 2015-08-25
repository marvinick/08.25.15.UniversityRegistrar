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
            Student::deleteAll();
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

        function testSave()
        {
            $course_name = "History";
            $course_code = "HIST100";
            $test_course = new Course($course_name, $course_code);
            $test_course->save();

            $result = Course::getAll();

            $this->assertEquals($test_course, $result[0]);
        }

        function testGetAll()
        {
            $course_name = "History";
            $course_code = "HIST100";
            $test_course = new Course($course_name, $course_code);
            $test_course->save();

            $course_name2 = "Gym";
            $course_code2 = "GYM100";
            $test_course2 = new Course($course_name2, $course_code2);
            $test_course2->save();

            $result = Course::getAll();

            $this->assertEquals([$test_course2, $test_course], $result);

        }

        function testFind()
        {
            $course_name = "History";
            $course_code = "HIST100";
            $test_course = new Course($course_name, $course_code);
            $test_course->save();

            $course_name2 = "Gym";
            $course_code2 = "GYM100";
            $test_course2 = new Course($course_name2, $course_code2);
            $test_course2->save();

            $result = Course::find($test_course->getId());

            $this->assertEquals($test_course, $result);

        }

        function testDelete()
        {
            $course_name = "History";
            $course_code = "HIST100";
            $test_course = new Course($course_name, $course_code);
            $test_course->save();

            $course_name2 = "Gym";
            $course_code2 = "GYM100";
            $test_course2 = new Course($course_name2, $course_code2);
            $test_course2->save();

            $test_course->delete();

            $this->assertEquals([$test_course2], Course::getAll());

        }

        function testUpdate()
        {
            $course_name = "History";
            $course_code = "HIST100";
            $test_course = new Course($course_name, $course_code);
            $test_course->save();

            //Creatin a course with values of History, HIST100, and id from database

            $new_course_name = "Math";
            $new_course_code = "MATH100";
            $new_course = new Course($new_course_name, $new_course_code, $test_course->getId());
            //creating a new course with values of Math, MATH100, and id that matches test_course

            $test_course->update($new_course_name, $new_course_code);

            $this->assertEquals($test_course, $new_course);
        }


        //NOT PASSING - failing to assert two equal arrays
        function testAddStudent()
        {
            $student_name = "John Doe";
            $enrollment_date = "2015-09-01";
            $test_student = new Student($student_name, $enrollment_date);
            $test_student->save();

            $course_name = "History";
            $course_code = "HIST100";
            $test_course = new Course($course_name, $course_code);
            $test_course->save();

            $test_course->addStudent($test_student);

            $this->assertEquals($test_course->getStudents(), [$test_student]);
        }
    }


?>

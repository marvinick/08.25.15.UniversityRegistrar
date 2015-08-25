<?php

        /**
        * @backupGlobals disabled
        * @backupStaticAttributes disabled
        */

        require_once "src/Student.php";
        require_once "src/Course.php";

        $server = 'mysql:host=localhost;dbname=registrar_test';
        $username = 'root';
        $password = 'root';
        $DB = new PDO($server, $username, $password);

        class StudentTest extends PHPUnit_Framework_TestCase
        {

            protected function tearDown()
            {
                Student::deleteAll();
                Course::deleteAll();
            }

            function test_save()
            {
                //arrange
                $student_name = "John Doe";
                $enrollment_date = "2015-09-01";
                $test_student = new Student($student_name, $enrollment_date);
                $test_student->save();

                //act
                $result = Student::getAll();

                //assert
                $this->assertEquals($test_student, $result[0]);
            }

            function test_getAll()
            {
                //arrange
                $student_name = "John Doe";
                $enrollment_date = "2015-09-01";
                $id = 1;
                $test_student = new Student($student_name, $enrollment_date, $id);
                $test_student->save();

                $student_name2 = "Jane Doe";
                $enrollment_date2 = "2015-10-01";
                $id2 = 2;
                $test_student2 = new Student($student_name2, $enrollment_date2, $id2);
                $test_student2->save();

                //act
                $result = Student::getAll();
                // var_dump($result);

                //assert
                $this->assertEquals([$test_student2, $test_student], $result);
            }

            function testGetStudentName()
            {
                $student_name = "John Doe";
                $enrollment_date = "2015-09-01";
                $id = 1;
                $test_student = new Student($student_name, $enrollment_date, $id);

                $result = $test_student->getStudentName();

                $this->assertEquals($student_name, $result);
            }

            function testGetEnrollmentDate()
            {
                $student_name = "John Doe";
                $enrollment_date = "2015-09-01";
                $id = 1;
                $test_student = new Student($student_name, $enrollment_date, $id);

                $result = $test_student->getEnrollmentDate();

                $this->assertEquals($enrollment_date, $result);
            }

            function testGetId()
            {
                $student_name = "John Doe";
                $enrollment_date = "2015-09-01";
                $id = 1;
                $test_student = new Student($student_name, $enrollment_date, $id);

                $result = $test_student->getId();

                $this->assertEquals($id, $result);
            }

            function testFind()
            {
                $student_name = "John Doe";
                $enrollment_date = "2015-09-01";
                $test_student = new Student($student_name, $enrollment_date);
                $test_student->save();

                $student_name2 = "Jane Smith";
                $enrollment_date2 = "2013-09-01";
                $test_student2 = new Student($student_name, $enrollment_date);
                $test_student2->save();

                $result = Student::find($test_student->getId());

                $this->assertEquals($test_student, $result);
            }

            function testUpdate()
            {
                $student_name = "John Doe";
                $enrollment_date = "2015-09-01";
                $test_student = new Student($student_name, $enrollment_date);
                $test_student->save();

                $new_student_name = "Jane Smith";
                $new_enrollment_date = "2013-09-01";
                $new_student = new Student($new_student_name, $new_enrollment_date, $test_student->getId());

                $test_student->update($new_student_name, $new_enrollment_date);

                $this->assertEquals($test_student, $new_student);
            }

            function testDelete()
            {
                $student_name = "John Doe";
                $enrollment_date = "2015-09-01";
                $test_student = new Student($student_name, $enrollment_date);
                $test_student->save();

                $student_name2 = "Jane Smith";
                $enrollment_date2 = "2013-09-01";
                $test_student2 = new Student($student_name, $enrollment_date);
                $test_student2->save();

                $test_student->delete();

                $this->assertEquals([$test_student2], Student::getAll());
            }

            function testAddCourse()
            {
                $student_name = "John Doe";
                $enrollment_date = "2015-09-01";
                $test_student = new Student($student_name, $enrollment_date);
                $test_student->save();

                $course_name = "History";
                $course_code = "HIST100";
                $test_course = new Course($course_name, $course_code);
                $test_course->save();

                $test_student->addCourse($test_course);

                $this->assertEquals($test_student->getCourses(), [$test_course]);
            }

            function testGetCourses()
            {
                $student_name = "John Doe";
                $enrollment_date = "2015-09-01";
                $test_student = new Student($student_name, $enrollment_date);
                $test_student->save();

                $course_name = "History";
                $course_code = "HIST100";
                $test_course = new Course($course_name, $course_code);
                $test_course->save();

                $course_name2 = "Gym";
                $course_code2 = "GYM100";
                $test_course2 = new Course($course_name2, $course_code2);
                $test_course2->save();

                $test_student->addCourse($test_course);
                $test_student->addCourse($test_course2);

                $this->assertEquals($test_student->getCourses(), [$test_course2, $test_course]);
            }

        }
?>



SELECT i.instructorId, s.sectionId, s.courseId, c.major, c.semester, c.year
FROM Instructors i, Sections s, CourseOutcomeMapping c
WHERE i.instructorId = s.instructorId AND
	  i.email="coyote@utk.edu" AND
	  i.password=PASSWORD('password') AND
	  s.courseId = c.courseId
ORDER BY c.year DESC,
		 c.semester ASC;

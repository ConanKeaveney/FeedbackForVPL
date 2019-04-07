#include <algorithm>
#include <iomanip>
#include <ios>
#include <iostream>
#include <stdexcept>
#include <string>
#include <vector>
#include <list>
#include "grade.h"
#include "Student_info.h"
#include "extract_fails.h"
 
using std::cin;
using std::cout;
using std::endl;
using std::domain_error;
using std::max;
using std::setprecision;
using std::sort;
using std::streamsize;
using std::string;
using std::vector;
using std::list;
 
// There are two main programs here.
//   - The top one is used to test out extract_fails version 1, 2, and 3.
//   - The bottom one is for testing out extract_fails version 4.
// Simply replace the no1_main() or no2_main() with main() to activate the main program to run
 
// for testing extract_fails_v1 / v2 / v3 - that uses vector
int main()
{
  vector<Student_info> students;
  Student_info record;
 
  // read and store all the student's data.
  while (read(cin, record))
    students.push_back(record);
 
  // Extract the failed students (use extract_fails_v1 / v2 / v3)
  vector<Student_info> students_failed = extract_fails_v1(students);//use _v1, _v2, _v3
 
  // sort vectors
  sort(students.begin(),students.end(),compare);
  sort(students_failed.begin(),students_failed.end(),compare);
 
  // Report passing students
  cout << "These students have passed." << endl;
  for (vector<Student_info>::const_iterator i = students.begin();
       i != students.end(); ++i)
    cout << i->name << endl;
 
  // Report failing students
  cout << "These students have failed." << endl;
  for (vector<Student_info>::const_iterator i = students_failed.begin();
       i != students_failed.end(); ++i)
    cout << i->name << endl;
 
  return 0;
}
 
 
// for testing extract_fails_v4 - that uses list
int no2_main()
{
  list<Student_info> students;
  Student_info record;
 
  // read and store all the student's data.
  while (read(cin, record))
    students.push_back(record);
 
  // Extract the failed students
  list<Student_info> students_failed = extract_fails_v4(students);
 
  // sort lists
  students.sort(compare);
  students_failed.sort(compare);
 
  // Report passing students
  cout << "These students have passed." << endl;
  for (list<Student_info>::const_iterator i = students.begin();
       i != students.end(); ++i)
    cout << i->name << endl;
 
  // Report failing students
  cout << "These students have failed." << endl;
  for (list<Student_info>::const_iterator i = students_failed.begin();
       i != students_failed.end(); ++i)
    cout << i->name << endl;
 
  return 0;
}

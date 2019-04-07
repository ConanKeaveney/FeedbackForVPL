#ifndef GUARD_EXTRACT_FAILS_H
#define GUARD_EXTRACT_FAILS_H
 
// extract_fails.h
#include <vector>
#include <list>
#include "Student_info.h"
 
bool fgrade(const Student_info&);
std::vector<Student_info> extract_fails_v1(std::vector<Student_info>&);
std::vector<Student_info> extract_fails_v2(std::vector<Student_info>&);
std::vector<Student_info> extract_fails_v3(std::vector<Student_info>&);
std::list<Student_info> extract_fails_v4(std::list<Student_info>&);
 
#endif // GUARD_EXTRACT_FAILS_H

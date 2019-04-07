/*
 * grade.cpp
 *  Created on: 24 May 2017
 */
#include <stdexcept>
#include <vector>
#include <numeric>
#include "grade.h"
#include "median.h"
#include "Student_info.h"

using std::domain_error; using std::vector;

double grade(double midterm, double final, double homework){
    return 0.2 * midterm + 0.4 * final + 0.4 * homework;
}

double grade(double midterm, double final, const vector<double>& hw){
    if (hw.size() == 0)
        //throw domain_error("student has done no homework");
        return grade(midterm, final, 0);
    return grade(midterm, final, computeAverage(hw));
}

double  computeAverage(const  vector<double>& hw){
    double average = accumulate( hw.begin(), hw.end(), 0.0)/hw.size();              
    return average; 
}

// const keeps s constant
double grade(Student_info& s){
    s.fgrade = grade(s.midterm, s.final, s.homework);
    return grade(s.midterm, s.final, s.homework);
}

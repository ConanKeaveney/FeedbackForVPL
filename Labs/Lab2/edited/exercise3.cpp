// C++ program to convert whole string to 
// uppercase or lowercase using STL. 
#include<bits/stdc++.h> 
using namespace std; 
  
int main() 
{ 
    // su is the string which is converted to uppercase 
    string su = "UPPER"; 
    string su2 = su;
    // using transform() function and ::toupper in STL 
    transform(su.begin(), su.end(), su.begin(), ::toupper);
    if(su==su2)//print only upper strings 
    cout << su << endl; 
  
    // sl is the string which is converted to lowercase 
    string sl = "lower"; 
    string sl2 = sl; 
  
    // using transform() function and ::tolower in STL 
    transform(sl.begin(), sl.end(), sl.begin(), ::tolower);
    if(sl==sl2) //print only lower strings
    cout << sl << endl; 
  
    return 0; 
} 

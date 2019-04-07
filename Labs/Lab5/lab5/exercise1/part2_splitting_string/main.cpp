#include <iostream>  // cin, cout, endl, getline
#include <vector>    // vector
#include <string>    // string
#include "split.h"   // split
 
using std::vector;
using std::string;
using std::cin;
using std::cout;
using std::endl;
using std::getline;
 
int main()
{
  string s;
 
  // read and split each line of input
  while (getline(cin, s))
    {
      vector<string> v = split(s);
 
      // write each word in v
      for (vector<string>::const_iterator iter = v.begin(); iter != v.end(); ++iter)
	cout << (*iter) << endl;
    }
  return 0;
}

#include <iostream>
#include <string>    // string
#include <vector>    // vector
 
using std::cout;
using std::endl;
using std::string;
using std::vector;
 
int vcout(const vector<string>& v)
{
  for (vector<string>::const_iterator iter = v.begin();
       iter != v.end(); ++iter)
    {
      cout << (*iter) << endl;
    }
  return 0;
}

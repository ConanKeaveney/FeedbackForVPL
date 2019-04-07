#include <string>      // string
#include <vector>      // vector
#include "frame.h"     // width
 
using std::string;
using std::vector;
 
vector<string> hcat(const vector<string>& left, const vector<string>& right)
{
  vector<string> ret;
 
  // add 1 to leave a space between pictures
  string::size_type width1 = width(left) + 1;
 
  // indices to look at elements from left and right respectively
  vector<string>::size_type i = 0, j = 0;
 
  // continue until we've seen all rows from both pictures
  while (i != left.size() || j != right.size())
    {
      // construct new string to hold characters from both pictures
      string s;
 
      // copy a row from the left-hand side, if there is one
      if (i != left.size())
	s = left[i++];
 
      // pad to full width
      s += string(width1 - s.size(), ' ');
 
      // copy a row from teh right-hand side, if there is one
      if (j != right.size())
	s += right[j++];
 
      // add s to the picture we are creating
      ret.push_back(s);
    }
 
  return ret;
}

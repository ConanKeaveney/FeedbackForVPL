#include <string>      // string
#include <vector>      // vector
 
using std::string;
using std::vector;
 
vector<string> vcat(const vector<string>& top, const vector<string>& bottom)
{
  // copy the top picture
  vector<string> ret = top;
 
  // copy entire bottom picture (option 1 and option 2 have the same effect - pick whichever!)
 
  // option 1
  for (vector<string>::const_iterator it = bottom.begin();
       it != bottom.end(); ++it)
    ret.push_back(*it);
 
  // option 2
  /*
    ret.insert(ret.end(), bottom.begin(), bottom.end());
  */
 
  return ret;
}

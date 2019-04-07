#include <iostream>
#include <ios>
#include <iomanip>
#include <algorithm>
#include "getStreamWidth.h"
  using std::cout;  // <iostream>
  using std::cin;   // <iostream>
  using std::endl;  // <iostream>
  using std::streamsize;  // <ios>
  using std::setw;  // <iomanip>
  using std::max;  // <algorithm>
 
  int main()
  {
    cout << "what..."<< endl;
    int m = -100;
    int n = 100;
 
    // initialise value
    const int startNumber = m;    // first output integer
    const int endNumber = n - 1;  // last output integer
    const int numLoops = n - m;  // number of rows to output
 
    // find the maxwidth for column 1 and 2
    const streamsize col1Width = max(getStreamWidth(startNumber), getStreamWidth(endNumber));
     streamsize col2Width = max(getStreamWidth(startNumber * startNumber), getStreamWidth(endNumber * endNumber));
     col2Width++;//we add one to account for the space between col1 and col2
    // display a summary
    cout << "Asymmetric range: [" << m << "," << n << ")" << endl;
    cout << "Number of rows = " << numLoops << endl;
    cout << "Column 1 width = " << col1Width << " | Column 2 width = " << col2Width << endl;
 
    // get ready to print report
    int y = startNumber;
    for (int i = 0; i != numLoops; ++i)
      {
        cout << setw(col1Width) <<  y  << setw(col2Width) << (y * y) << setw(0) << endl;
        ++y;
      }
    return 0;
  }

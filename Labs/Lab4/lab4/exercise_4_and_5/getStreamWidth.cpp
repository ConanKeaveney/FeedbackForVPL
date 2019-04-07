#include <ios>
using std::streamsize;
 
// return the required streamsize to fit a particular integer number
streamsize getStreamWidth(int number)
{ 
  streamsize numDigits; 
  // If negative, require at least 1 space to fit the negative sign
  if (number < 0)
    {
      numDigits = 1;
      number *= -1;
    }
  else
    { 
    numDigits = 0;
    }
  while (number != 0)
    {
      ++numDigits;
      number /= 10;
    }
 
  return numDigits;
}

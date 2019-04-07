// square.cpp

//define sq function
#include <iostream>
int sq(int& c, int& r, int numCols, int numRows) {
	using std::cout;

	// Are we at the exact position to output asterisk (border)?
	if ((c == 0)              // the left edge
	|| (c == numCols - 1)       // the right edge
			|| (r == 0)              // the top edge
			|| (r == numRows - 1)       // or the bottom edge
			) {
		std::cout << "*";
		++c;
	} else {
		std::cout << ' ';
		++c;
	}
	return 0;
}

//define tri function
#include <iostream>
int tri(int& c, int& r, int numCols, int numRows) {
	using std::cout;

	// Are we at the exact position to output asterisk (border)?
	if ((c == ((numCols - 1) / 2) - r) // the triangle left edge
	|| (c == ((numCols - 1) / 2) + r) // or the triangle right edge
			|| (r == numRows - 1) // or the triangle bottom edge
			) {
		cout << "*";
		++c;
	} else {
		cout << ' ';
		++c;
	}
}

//define pyr function
#include <iostream>
int pyr(int& c, int& r, int numCols, int numRows) {
	using std::cout;

	// Are we at the exact position to output asterisk (border)?
	//if ((c == ((numCols - 1) / 2) - r) // the triangle left edge
	if ((c == 0 + r) || (c == 0) || ((r == (numRows - 1)) && c <= numRows -1) // or the triangle bottom edge
			) {
		cout << "*";
		++c;
	} else {
		cout << ' ';
		++c;
	}
}

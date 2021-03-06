// main.cpp
#include <string>
#include <iostream>
#include "square.h"
#include "rectangle.h"
#include "triangle.h"

using std::cin;
using std::endl;
using std::cout;
using std::string;

int main() {
	// at the end of the program we ask user if he would like to re-run program
	// depending on the user input then this program may either re-run or terminate
	string tryAgain = "y";
	while (tryAgain == "y") {
		cout << endl;
		// ask for the Shape Type
		int shapeType;
		for (int keepAsking = 1; keepAsking == 1;) { //notice there is no increment!
			//just initialisation and condition
			cout << "Select the Shape Type." << endl;
			cout << "  [1] - Square " << endl;
			cout << "  [2] - Rectangle " << endl;
			cout << "  [3] - Triangle " << endl;
			cout << "Shape Type (enter 1 or 2 or 3): ";
			cin >> shapeType; //read option (integer)
			// Make sure the user input is within range. If not, ask again!
			if (shapeType == 1 || shapeType == 2 || shapeType == 3) {
				keepAsking = 0;
			}
		}

		// ask for the shape height
		cout << "Enter Shape Height: ";
		int shapeHeight;
		cin >> shapeHeight;

		// set the total number of rows to write (as a constant)
		int const numRows = shapeHeight;

		int shapeWidth;
		if (shapeType == 2) { // it is a rectangle so we need to ask for width,
			// it is computer otherwise
			cout << "Enter Shape Width: ";
			cin >> shapeWidth;
		}

		// compute the number of columns to write (as a constant) based on shape type
		int finalShapeWidth;
		if (shapeType == 1) {
			finalShapeWidth = shapeHeight;
		}    // assign square width
		else if (shapeType == 2) {
			finalShapeWidth = shapeWidth;
		}     // assign rectangle width
		else {
			finalShapeWidth = (2 * numRows) - 1;
		}   // compute triangle width
		const string::size_type numCols = finalShapeWidth;
		const int numColsint = numCols;

		// invariant: we have written r rows so far
		for (int r = 0; r != numRows; ++r) {
			string::size_type c = 0;

			// invariant: we have written c characters so far in the current row
			int cint = c;
			while (c != numCols) {
				// If Square or Rectangle Option
				if (shapeType == 1) {

					sq(cint, r, numColsint, numRows);
					c = cint;

				}

				if (shapeType == 2) {
					rec(cint, r, numColsint, numRows);
					c = cint;

				}

				// If Triangle Option
				if (shapeType == 3) {
					tri(cint, r, numColsint, numRows);
					c = cint;

				}
			}
			cout << endl;
		}

		// ask user if he would like to start the program again
		cout << "Again? (y/n): ";
		cin >> tryAgain;
	}
	return 0;
}

#include <iostream>
#include <string>
using namespace std;

int main() {

	string str1;
	cout << "Please enter a word: ";
	cin >> str1;
	int length = str1.length();

	cout << endl;
	cout << length;

	cout << endl;

	for (int i = length; i >= 0; i--) {
		for (int j = 0; j < i; j++) {
			cout << str1[j];
		}
		cout << endl;
	}

	cout << endl;
	string str2 = string(str1.rbegin(), str1.rend());

	for (int i = 0; i < length; i++) {
		for (int j = i; j < length; j++) { //Starting from position i to the end
			cout << str2[j];
		}
		cout << endl;
	}
	return 0;

}



#include <iostream>
#include <string>
//print string in diagonal format
using namespace std;

int
main(void)
{
    string text;
    string spaces;

    getline(cin, text);

    for (int k = 0 ; k < text.length() ; ++k)
        cout << (spaces += ' ') << text.at(k) << endl;

    return 0;
}


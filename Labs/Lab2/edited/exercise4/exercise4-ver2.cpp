#include <algorithm>
#include <string>
#include <vector>
#include <iostream>
#include <algorithm>
#include <cctype>
//print first letter in word
using std::cin; using std::cout; using std::endl; 
using std::vector; using std::sort; using std::streamsize; using std::string;
int main()
{
  typedef vector<string>::size_type vec_sz;
  vector<string> sentence;
  string word;
  while (cin >> word){
    sentence.push_back(word);
  }
  sort(sentence.begin(), sentence.end());
  for (int i = sentence.size()-1; i>= 0; --i)
  {
    string str = sentence[i];
    str[0] = toupper(str[0]);
    cout << str << endl;


  }
  return 0;
}

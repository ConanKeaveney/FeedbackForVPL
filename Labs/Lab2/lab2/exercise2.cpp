#include <algorithm>
#include <string>
#include <vector>
#include <iostream>
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
  vec_sz size = sentence.size();
  sort(sentence.begin(), sentence.end());
  int count;
  word = "";
  for (int i = 0; i < size; ++i){
    if (word != sentence[i]){
      word = sentence[i];
    count = 1;
    for (int j = i+1; j  < size; ++j){
      if (word == sentence[j]){
	++count;
      }
    }
    cout << word << " appears " << count << " times" << endl;
    }
  }
  return 0;
}

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
  vector<string::size_type> sizes;
  string word, smallestWord, largestWord;
  typedef string::size_type size_word;
  size_word smallest = word.max_size();//
  size_word  largest = 0;
  while (cin >> word){
    sentence.push_back(word);
  }
  for (int i = 0; i < sentence.size(); ++i){
    if (sentence[i].size() < smallest)
      {
	smallest =sentence[i].size();
	smallestWord = sentence[i];
      }
    if (sentence[i].size() > largest){
      largest = sentence[i].size();
      largestWord = sentence[i];
    }
  }
  int count = 0;
  for (int i = 0; i < sentence.size(); ++i){
    if (sentence[i].size() > smallest && sentence[i].size() < largest) count++;

  }
  cout << "smallest word: " << smallestWord << " of size " << smallest << endl;
  cout << "largest word: " << largestWord << " of size " << largest << endl;
  cout << "number of words in between " << count << endl;
	
  return 0;
}

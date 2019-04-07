#sort a vector
#include <iostream>
#include <algorithm>
#include <vector>
using std::cout;
using std::endl;
using std::cin;
int main(){
  std::vector<int> v;
  int sum = 0, x;
  while (cin >> x){
    v.push_back(x);
  }
  sort(v.begin(), v.end());
  for (int i = v.size()-1; i>= 0; i-=2){
    sum += v[i];
  }
  cout << "the sum of the numbers is " << sum << endl;
  return 0;
}

#include <sstream>
#include <string>
#include <cctype>
#include<iostream>
using namespace std;
//ouputs words that are capitilized
int main(){
string line = "Test one two three.";
string arr[4];
int i = 0;
stringstream ssin(line);
while (ssin.good() && i < 4){
	ssin >> arr[i];
	++i;
}
for(i = 0; i < 4; i++) cout << arr[i] << endl;

for(i = 0; i < 4; i++){
	string str = arr[i];
	if (str[i] >= 'A' && str[i] <= 'Z')
	cout << arr[i] << endl; 

}




}

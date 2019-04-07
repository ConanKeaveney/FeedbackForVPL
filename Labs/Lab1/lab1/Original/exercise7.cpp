#include <iostream>
int main()
{
  int product  = 1;
  for (int i  = 1; i < 9; ++i)
    {
      if ((i%2)==0)
	{
	  product *= i;
	}
    }
  std::cout << product << std::endl;
  return 0;
}

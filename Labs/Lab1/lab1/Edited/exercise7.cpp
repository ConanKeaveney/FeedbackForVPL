#include<stdio.h>

int main()

{

int sum=0;
int flag;

for(int i=15; i<=250; i++)

{

flag = 1;

for(j=2; j<=i/2; j++) {

if(i%j==0) {

flag=0;

break;

}

}

if(flag==1)

sum = sum + i;

}

printf(“Sum = %d”, sum);

return 0;

}

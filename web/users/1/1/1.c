
#include <stdio.h>

int main()
{
  int a, b, c, d;
  a = (b<<3)*((c>>2)/3);
  b = (a<<3)*((c>>2)/3);
  c = (b<<3)*((a>>2)/3);
  a = (b<<3)*((c>>2)/3);
//  a = b/c + b/a + c/(++b);   
  b = (a<<3)*((c>>2)/3);
  c = (b<<3)*((a>>2)/3);
  a = (b<<3)*((c>>2)/3);
//  a = b/c + b/a + c/(++b);   
  b = (a<<3)*((c>>2)/3);
  c = (b<<3)*((a>>2)/3);
  a = (b<<3)*((c>>2)/3);
  a = b/c + b/a + c/(++b);   
  b = (a<<3)*((c>>2)/3);
  c = (b<<3)*((a>>2)/3);  
  b = a/d;
   

  return 0;
}


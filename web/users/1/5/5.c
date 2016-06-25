#include<stdio.h>
#include<stdlib.h>

void ispisi_int(int x)
{
 unsigned maska;
 maska=1;
 unsigned velicina=sizeof(int)*8;
 maska<<=(velicina-1);
 
 for(;maska;maska>>=1)
  {
   if(maska&x)
    printf("1");
   else 
    printf("0");
  }
  
  printf("\n");
    
}

unsigned int zamena(unsigned int x)
{
 unsigned int cetvrti;
 unsigned int prvi;
 unsigned int y;
 int velicina=sizeof(unsigned)*8;

 prvi=(~((~0)<<8))&x;
 cetvrti=((~0)<<(velicina-8))&x;
 
 unsigned maska=(~0)<<8;
 // ovde kada napisemo broj 0, ona je tipa int, a mi hocemo da pomeramo u desno
 // i da ne kopiramo bit znaka, zbog toga moramo pretvoriti 0 u tip unsigned
 unsigned maska1=(~(unsigned)0)>>8;

 x=x&maska;
 x=x&maska1;
 y=x|(prvi<<velicina-8);
 y=y|(cetvrti>>velicina-8);
 
 return y;
}

int main()
{
 int x;
 unsigned int y;

 scanf("%d",&x);
 
 if(x<0)
 {
  printf("-1\n");
  exit(EXIT_FAILURE);
 }
 
 y=zamena(x);
 printf("%u\n",y);

 printf("x= ");
 ispisi_int(x);

 printf("y= ");
 ispisi_int(y);
 
 return 0;

}

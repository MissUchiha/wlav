#include <stdio.h>
#include <stdlib.h>
#include <math.h>


void izmeni( float **a, int n)
{
  int i,j;

  for(i=0;i<n;i++)
  // Ovde treba da povecavate j umesto i
  // for(j=0;j<n;i++)
  for(j=0;j<n;j++)
  {
       if(i<j)
       a[i][j]/=2;
     else if(i>j)
       a[i][j]*=2;}

}

float zbir_ispod_sporedne_dijagonale( float **a, int n)
{
  int i,j;
  float zbir=0;

  for(i=0;i<n;i++)
   for(j=0;j<n;j++)
       if(i+j<n-1)
      zbir+=fabs(a[i][j]);

      return zbir;
}

void ucitaj_matricu(FILE * ulaz, float **a, int n)
{
  int i,j;

  for(i=0;i<n;i++)
   for(j=0;j<n;j++)
    fscanf(ulaz,"%f",&a[i][j]);


}

void ispisi_matricu(float **a, int n)
{
  int i,j;

  for(i=0;i<n;i++)
   {for(j=0;j<n;j++)
    printf("%.2f",a[i][j]);
     printf("\n" );
  }
}

float **alociraj_memoriju(int n)
{
  int i,j;
  float **A;
  A=(float**)malloc(sizeof(float*)*n);
  if(A==NULL)
  {
    fprintf(stderr, "Greska pri alociranju memorije\n" );
    exit(EXIT_FAILURE);
  }

  for(i=0;i<n;i++)
   {
     A[i]=(float*)malloc(n* sizeof(float));

     if(A[i]==NULL)
     {
       fprintf(stderr, "Greska pri alociranju memorije\n" );
       for(j=0; j<i; j++)
        free(A[i]);

        free(A);
       exit(EXIT_FAILURE);
     }

   }
  return A;

}

void oslobodi_memoriju(float **A, int n)
{

  int i;

  for(i=0;i<n;i++)
    free(A[i]);

    free(A);

}


int main(int argc, char *argv[])
{
float **A;
int n;
int i,j;

FILE *ulaz;

if(argc<2)
{
  fprintf(stderr,"Neispravan  br argumenata" );
  exit(EXIT_FAILURE);
}

ulaz=fopen(argv[1],"r");
if(ulaz==NULL)
{
  fprintf(stderr,"Neispravan unos dadoteke" );
  exit(EXIT_FAILURE);
}

fscanf(ulaz,"%d",&n);

A=alociraj_memoriju(n);

ucitaj_matricu(ulaz,A,n);


float zbir=zbir_ispod_sporedne_dijagonale(A,n);

izmeni(A,n);
printf("Uje\n" );

printf("Zbir apsolutnih vrednosti ispod sporednje dijagonale: %.2f: ",zbir );

printf("Transformirana matrica je: \n" );
ispisi_matricu(A,n);


oslobodi_memoriju(A,n);

fclose(ulaz);

return 0;
}

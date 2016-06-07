#include <stdio.h>
#include <stdlib.h>

#define MAX 100

// Proveravamo da li je matrica B podmatrica matrice A pocev od indeksa (i,j) u matrici A
// ukoliko jeste vracamo 1 inace 0
int podmatrica_od_indeksa_i_j(int A[][100],int i,int j,int B[][100],int m)
{
        int k,l;
        for(k=0;k<m;k++)
            for(l=0;l<m;l++)
            {
                    if(A[i+k][j+l]!=B[k][l])
                          return 0;
            }

        return 1;

}

int podmatrica(int A[][100],int n,int B[][100],int m,int *pozicija_i,int *pozicija_j)
{
    int i,j;
    // Idemo do indeksa (n-m+1, n-m+1) jer za vece indekse nema potrebe proveravati
    // zato sto u matrici A pocev od tih indeksa nece biti onoliko elemenata koliko ima u matrici B
    for(i=0;i<n-m+1;i++)
        for(j=0;j<n-m+1;j++)
            if(podmatrica_od_indeksa_i_j(A,i,j,B,m))
            {
              *pozicija_i = i;
              *pozicija_j = j;
              return 1;
            }

      // Ako B nije podmatrica A, postavljamo indekse na -1 i vracamo 0
      *pozicija_i = -1;
      *pozicija_j = -1;
    return 0;
}


void ispisi(int A[][MAX], int n)
{
  int i,j;
  for(i=0;i<n;i++)
  {
      for(j=0;j<n;j++)
        printf("%d ",A[i][j] );

        printf("\n" );
  }
  }

int main(){
int n,m,A[MAX][MAX],B[MAX][MAX];
int i,j,a=0,b=0;


scanf("%d",&n);

if(n<0 || n>MAX){
 fprintf(stderr,"Greska 1\n");
 exit(EXIT_FAILURE);
}

for(i=0;i<n;i++){
 for(j=0;j<n;j++)
  scanf("%d",&A[i][j]);}

scanf("%d",&m);

if(m<0 || m>MAX){
 fprintf(stderr,"Greska 1\n");
 exit(EXIT_FAILURE);
}

for(i=0;i<m;i++){
 for(j=0;j<m;j++)
  scanf("%d",&B[i][j]);}

podmatrica(A,n,B,m,&a,&b);
if(a==-1 && b==-1)
  printf("B nije podmatrica A.\n" );
else
  printf("%d %d\n",a,b);

return 0;}

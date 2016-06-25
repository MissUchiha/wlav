#include<stdio.h>
#include<stdlib.h>
#include <string.h>

#define MAX 51

int main(int argc, char *argv[])
{

        int n;
        char **niske=NULL;
        FILE *f=NULL;
        int i, j;

        f=fopen(argv[1], "r");
        if(f==NULL)
                return -1;

        fscanf(f, "%d", &n);

        niske=(char**)malloc(sizeof(char*)* n);

        if(niske==NULL)
        {
                printf("Neuspesno alocirana memorija!\n");
                return -1;

        }

        for(i=0; i<n; i++)
        {        niske[i]=(char*)malloc(sizeof(char)*MAX);

                if(niske[i] == NULL)
                // Morate svo ovo oslobadjanje staviti u posebne zagrade
                {
                   for(j=0; j<i;j++)
                        free(niske[i]);

                        free(niske);
                        return -1;
                }
              printf("Alocirano: niske[%d]\n",i);
        }


        i=0;
        // Rezervisali smo memoriju za n niski
        // a ovde ucitavamo niske do EOF, znaci ucitacemo n niski iz datoteke + 1 - EOF, ta 1 niska nema gde da se smesti
        // jer smo niz popunili i zbog toga pukne seg fault
        // while(fscanf(f, "%s", niske[i])!=EOF){
        //         printf("Ucitano %s\n",niske[i] );
        //         i++;
        // }
        // Ovo je moguce resenje

        char pom[MAX];

        while(fscanf(f, "%s", pom)!=EOF){
                printf("Ucitano %s\n", pom );
                strcpy(niske[i], pom);
                i++;
        }
        if(i!=n)
        {
                printf("Nije i kao n");
                return -1;
        }



        fclose(f);

        // Ovde umesto i++ treba i--
        for(i=n-1; i>=0; i--)
        if(niske[i][0]>'A' && niske[i][0]< 'Z')
                printf("%s ", niske[i]);


        for(i=0; i<n; i++)
                free(niske[i]);

        free(niske);


return 0;
}

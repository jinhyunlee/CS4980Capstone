#include <stdio.h>

int main() {
       printf("Three  in number is %d", three());
       if (three() != 3) {
           printf("Failed");
       }
       else {
           printf("Success");
       }
       return 0;
}
<?php
	$code = "
              #include<stdio.h>
              #include<conio.h>
              #include<math.h>
              #define EPS 0.00005
              #define F(x) (x*x*x + 1)/2
              #define f(x)  x*x*x - 2*x + 1

              int n;

              void iter();

              void main()
              {
              clrscr();
              printf(\"\n Solution by ITERATION METHOD \");
              printf(\"\n\n Equation is -> x*x*x - 2*x + 1 = 0\n\");
              printf(\"\n Enter the no. of iterations \");
              scanf(\"%d\",&n);
              iter();
              getch();
              }

              void iter()
               {
               int i=0;
               float x1,x2,x0;
               float f1,f2,f0,error;
               for(x1=1; ;x1++)
                  {
                  f1=f(x1);
                  if(f1>0)
                    break;
                  }
               for(x0=x1-1; ;x0--)
                  {
                  f0=f(x0);
                  if(f0<0)
                    break;
                  }
               x2=(x0+x1)/2;
               printf(\"\n\n\t\t The 1 approximatrion to the root is : %f\",x2);
               for(;i<n-1;i++)
                  {
                  f2=F(x2);
                  printf(\"\n\n\t\t The %d approximatrion to the root is : %f\",i+2,f2);
                  x2=F(x2);
                  error=fabs(f2-f1);
                  if(error<EPS)
                     break;
                  f1=f2;
                  }
               if(error>EPS)
                 printf(\"\n\n\t NOTE :- The no. of iterations are not sufficient.\");
               printf(\"\n\t\t ROOT  = %.4f (Correct to 4 Decimal places)\",f2);
              }";

	$refinedCode = preg_replace("/\n/",'\'+\'',$code);

	echo $refinedCode;

?>
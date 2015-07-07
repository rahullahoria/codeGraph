<?php
	$code = "'#include <stdio.h>'+'            #include <math.h>'+'            int i,n,t,k;'+'            int a[100000],b[100000];'+'            int merge(l,r,u)'+'              int l,r,u;'+'            { int i,j,k;'+'              i=l; j=r; k=l;'+'              while (i<r && j<u) { '+'                if (a[i]<=a[j]) {b[k]=a[i]; i++;} '+'                else {b[k]=a[j]; j++;}'+'                k++;'+'              }'+'              while (i<r) { '+'                b[k]=a[i]; i++; k++;'+'              }'+'              while (j<u) { '+'                b[k]=a[j]; j++; k++;'+'              }'+'              for (k=l; k<u; k++) { '+'                a[k]=b[k]; '+'              }'+'            }'+'            sort()'+'            { int k,u;'+'              k=1;'+'              while (k<n) {'+'                i=1;'+'                while (i+k<=n) {'+'                  u=i+k*2;'+'                  if (u>n) u=n+1;'+'                  merge(i,i+k,u);'+'                  i=i+k*2;'+'                }'+'                k=k*2;'+'              }'+'            }'+'            main()'+'            { printf(\"input size '+'\");'+'              scanf(\"%d\",&n); '+'            /*  for (i=1;i<=n;i++) scanf(\"%d\",&a[i]); */'+'              for (i=1;i<=n;i++) a[i]=random()%1000;'+'              t=clock();'+'              sort();'+'              for (i=1;i<=10;i++) printf(\"%d \",a[i]);'+'              printf(\"'+'\");'+'              printf(\"time= %d millisec'+'\",(clock()-t)/1000);'+'            }'";
	

	$refinedCode = preg_replace("/'+/","\\n'",$code);

	$codeForJs = preg_replace("/+\\n/"," ",$refinedCode);

	echo $refinedCode ."\n";


	//$refinedCode = preg_replace("\s+/","\\n'+'",$code);

	//$refinedCode = preg_replace("/\n\s+/","\\n'+'",$code);
	//echo "----------------------------------code for -js---------------";
	//$codeForJs = preg_replace("/'+/","\\n'\n+",$refinedCode);
	//$refinedCode = preg_replace("/\s+/'+","/' '/'+ ",$code);
	//$refinedCode = preg_replace("/\s+/",' ',$code);

	//$codeForJs = preg_replace("/'+/","+",$refinedCode);

	//$codeForJsnew = preg_replace("/+ + +/","/\\n'+'/",$refinedCode);


	//echo $refinedCode ."\n";
	echo "----------------------------------code for -js---------------\n";
	echo $codeForJs ."\n";
	//echo "----------------------------------code for -js---------------\n";
	//echo $codeForJsnew ."\n";*/
?>
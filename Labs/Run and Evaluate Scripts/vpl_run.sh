#! /bin/bash

cat > vpl_execution <<EEOOFF
#! /bin/bash
 
prog1=x
prog2=y
prog3=z

g++ \${prog1}.cpp \${prog2}.cpp \${prog3}.cpp &> grepLines.out


if ((\$? > 0)); then
     echo "Error compiling your program"
     cat grepLines.out
     exit
fi
./a.out


EEOOFF

chmod +x vpl_execution



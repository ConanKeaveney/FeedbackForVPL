#! /bin/bash

cat > vpl_execution <<EEOOFF
#! /bin/bash


# ---------- PROGRAMS TESTED (WITHOUT EXTENSION) ---------
prog1=x
prog2=y
prog3=z

compiled=true

# --------------------- GLOBAL VARIABLES -------------------

declare -a RegexList=("a" "b" "c" "next") # regex go here
#declare -a Comment=("imported the java util library" "created a new Scanner object" "used the \"\.replace\" method" "created an if statement" "used a next method to take input")


# --------------------- SETTING VALUES FOR GRADES -------------------
compileGrade=6
numberOfRegex=\${#RegexList[*]}+1
regexGrade=54
numberOfTestCases=5
testCasesGrade=40
regex=regexGrade/numberOfRegex
testCase=testCasesGrade/numberOfTestCases

# ----------------- COMPILE STUDENT PROG  ----------------
g++ \${prog1}.cpp \${prog2}.cpp \${prog3}.cpp &> grepLines.out

if ((\$? > 0)); then
     echo "------------------------"
     echo "Your program has compiler Errors. Please fix these Errors."
     cat grepLines.out
     echo "------------------------"
     compiled=false
fi


if grep '.*' \${prog1}.cpp   
then                             
    if [ \${compiled} = true ] ; then
        grade=\$((grade+compileGrade))
    fi
fi

# ----------- Remove single line comments from code -------------
#sed -i 's|//.*||g' \${prog1}.cpp

# ----------- TEST THE CODE FOR PARTICULAR PATTERNS -------------
# ----------- TEST Code -------------
c=0
for reg in \${RegexList[*]}; do
    if grep \$reg \${prog1}.cpp
    then
        tempRegExGrade=\$((tempRegExGrade+regex))
        grade=\$((grade+regex)) #--- adds what % you wanted to give for each regex ---
    else
        echo "Comment :=>>-----------------------"
        echo "Comment :=>>You have not \${Comment[\$c]} in" \${prog1}.cpp
    fi
    ((c++))
done

declare -a RegexList2=('a' 'b') #--regex go here

c=0
for reg in \${RegexList2[*]}; do
    if grep \$reg \${prog1}.cpp
    then
        if (( tempRegExGrade < regexGrade )); then
          tempRegExGrade=\$((tempRegExGrade+regex))
          grade=\$((grade+regex)) #--- adds what % you wanted to give for each regex ---  
        fi
        ((c++))
    fi
done

if (( c == 0 )); then
    echo "------------------------"
    echo "You have not used a valid loop syntax in" \${prog1}.cpp
fi


# --- create test input files ---
cat > data1.txt <<EOF
test
EOF

cat > data2.txt <<EOF
test
EOF
    
cat > data3.txt <<EOF
test
EOF
    
cat > data4.txt <<EOF
test
EOF

cat > data5.txt <<EOF
test
EOF

#--- create expected outputs, one for each input file above ---
cat > data1.out <<EOF
output
EOF

cat > data2.out <<EOF
output
EOF

cat > data3.out <<EOF
output
EOF

cat > data4.out <<EOF
output
EOF

cat > data5.out <<EOF
output
EOF

#--- compile the program ---
g++ \${prog1}.cpp \${prog2}.cpp \${prog3}.cpp &> grepLines.out


declare -a AnswersList=('@.*@.*@.*@' '#' '#.*#' '@.*@.*@.*@.*@.*@.*@.*@' '#.*#')# if student gets these answers, give them grade, you can use this instaed of data\${i}.out
#check java example for how to use AnswersList
count=0
c=0
if [ \${compiled} = true ] ; then
    #---loops through the amount of test cases you specified at the top ---
    for((i=1;i<=\$numberOfTestCases;i++)) 
    do  
        echo "------------------------"
        ./a.out < data\${i}.txt &> user.out
        if cmp -s "data\${i}.out" "user.out"
        then
            # Answered Correctly 
            echo ""
            echo "Test Case \${i} Passed"
            
            echo ""
            echo "Your answer:"
            cat user.out
            
            #---adds value to grade based on what % you wanted to give for testcases---
            grade=\$((grade+testCase))
            ((count++))
        else
            # Wrong Answer
            echo "Test Case \${i} Failed"
            #--- display test file ---
            echo ""
            echo "Your program tested with:"
            cat data\${i}.txt
          
            echo ""
            echo "Your answer:"
            cat user.out
          
            echo ""
            echo "Expected answer:"
            cat data\${i}.out
        fi
        ((c++))
    done
fi

if (( count == numberOfTestCases )); then
  if (( grade < 100 )); then
    grade=100
    echo "------------------------"
    echo "As you have passed all Test Cases, you have been given full marks"
  fi
fi

if (( grade > 100 )); then
    grade=100
fi

if (( grade < 1 )); then
    grade=0
fi

echo "------------------------"
echo ""
echo "Grade :=>> \$grade"
EEOOFF

chmod +x vpl_execution

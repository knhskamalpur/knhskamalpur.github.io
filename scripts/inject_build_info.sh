#!/bin/bash

# Get build information (IST)
BUILD_DATE=$(TZ='Asia/Kolkata' date +'%Y-%m-%d %H:%M:%S IST')
COMMIT_HASH=$(git rev-parse --short HEAD)
BRANCH_NAME="$1" # Passed as first argument

# Create ASCII art with build information
cat << 'EOF' > build_info.txt
   _  __ _   _ _   _  ____ 
  | |/ /| \ | | |_| |/ ___|
  | ' / |  \| |  _  |\___ \
  | . \ | |\  | | | | ___) |
  |_|\_\|_| \_|_| |_||____/ 
EOF

echo -e "\n Kamalpur Netaji High School (H.S.) Estd 1956" >> build_info.txt
echo -e " Build: $COMMIT_HASH | Date: $BUILD_DATE | Branch: $BRANCH_NAME" >> build_info.txt

# Use perl for safe multiline replacement as sed -i is inconsistent with newlines
echo "Injecting ASCII build info into text files..."
FIND_FILES=$(find src public -type f \( -name "*.css" -o -name "*.js" -o -name "*.astro" -o -name "*.json" -o -name "*.html" \))
REPLACEMENT=$(cat build_info.txt)

# Use perl to replace the placeholder with the content of build_info.txt
# This handles backslashes and newlines much better than sed
export REPLACEMENT_CONTENT="$REPLACEMENT"
for f in $FIND_FILES; do
    perl -i -0777 -pe 's/Copyright belongs to Kamalpur Netaji High School \(H\.S\.\) Estd 1956/$ENV{REPLACEMENT_CONTENT}/g' "$f"
done

rm build_info.txt

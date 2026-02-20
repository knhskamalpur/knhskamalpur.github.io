#!/bin/bash

# Get build information
BUILD_DATE=$(date -u +'%Y-%m-%d %H:%M:%S UTC')
COMMIT_HASH=$(git rev-parse --short HEAD)
BRANCH_NAME="$1" # Passed as first argument

# Create ASCII art with build information
cat <<EOF > build_info.txt
   _  __ _   _ _   _  ____ 
  | |/ /| \ | | |_| |/ ___|
  | ' / |  \| |  _  |\___ \\
  | . \ | |\  | | | | ___) |
  |_|\_\|_| \_|_| |_||____/ 

 Kamalpur Netaji High School (H.S.) Estd 1956
 Build: $COMMIT_HASH | Date: $BUILD_DATE | Branch: $BRANCH_NAME
EOF

# Escape for sed: backslash, delimiter (@), and newline
# We use perl for more reliable multiline replacement if needed, 
# but sticking to sed for simplicity since we are on linux runner.
ESCAPED_INFO=$(sed 's/\\/\\\\/g; s/@/\\@/g; :a;N;$!ba;s/\n/\\n/g' build_info.txt)

echo "Injecting ASCII build info into text files..."
find src public -type f \( -name "*.css" -o -name "*.js" -o -name "*.astro" -o -name "*.json" -o -name "*.html" \) -print0 | \
xargs -0 sed -i "s@Copyright belongs to Kamalpur Netaji High School (H.S.) Estd 1956@$ESCAPED_INFO@g"

rm build_info.txt

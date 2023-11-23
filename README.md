
## AWS CLIのインストール
### Windows(WSL2)
- sudo apt install unzip
- curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip"
- unzip awscliv2.zip
- sudo ./aws/install
- aws --version

### Mac
- /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
- brew reinstall awscli
-  (echo; echo 'eval "$(/opt/homebrew/bin/brew shellenv)"') >> /Users/uchidayuma/.zprofile
- eval "$(/opt/homebrew/bin/brew shellenv)"
- aws --version


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

## 共通）Swarmクラスターの準備
- aws configure list-profiles
- aws configure --profile swarmuser

### Mac)EC2にSSH接続
- mv udemy-swarm-node.pem .ssh
- ssh -i ~/.ssh/udemy-swarm-node.pem ec2-user@IPアドレス

### Dockerのインストール

1. sudo yum -y install docker
2. sudo systemctl start docker
3. sudo systemctl enable docker
4. sudo usermod -aG docker $USER
5. exit
6. 再度SSH

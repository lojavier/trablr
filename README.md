# trablr
SJSU CMPE 220 Project

Required repositories:

mongoose (https://www.cesanta.com)
git clone git@github.com:cesanta/mongoose.git

curl (https://curl.haxx.se)
git clone git@github.com:curl/curl.git
sudo apt-get install -y autoconf libtool
Install via instructions in GIT-INFO file

rapidjson (http://rapidjson.org)
git clone git@github.com:miloyip/rapidjson.git

mysql-connector-cpp (https://github.com/mysql/mysql-connector-cpp)
git clone https://github.com/mysql/mysql-connector-cpp.git
Install via instructions: https://dev.mysql.com/doc/connector-cpp/en/connector-cpp-installation-source-prerequisites.html

boost (http://www.boost.org)
wget https://dl.bintray.com/boostorg/release/1.64.0/source/boost_1_64_0.tar.bz2

Trouble shooting:
There might be some missing packages.
sudo apt-get install -y curl libcurl3 libcurl4-gnutls-dev php5-cgi
sudo apt-get install -y cmake libmysqlcppconn-dev libmysqlclient-dev

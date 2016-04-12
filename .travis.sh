#!/bin/bash
wget https://github.com/google/cayley/releases/download/v0.4.1/cayley_0.4.1_linux_amd64.tar.gz
tar -xvzf cayley_0.4.1_linux_amd64.tar.gz
cd cayley_0.4.1_linux_amd64
./cayley http --dbpath=data/30kmoviedata.nq.gz &

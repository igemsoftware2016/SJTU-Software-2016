#!/usr/bin/python

import string
import os
import argparse

parser = argparse.ArgumentParser(description="")
parser.add_argument("-x", "--in1", help="file 1", required = True)
parser.add_argument("-y", "--in2", help="file 2", required = True)
args = vars(parser.parse_args())

with open(args["in1"], "r") as tmp_file:
    xx = tmp_file.readlines()
for i in range(len(xx)):
    xx[i] = xx[i].strip()

with open(args["in2"], "r") as tmp_file:
    yy = tmp_file.readlines()
for i in range(len(yy)):
    yy[i] = yy[i].strip()

for s in xx:
    if s not in yy:
        print s," only in ",args["in1"]

for s in yy:
    if s not in xx:
        print s," only in ",args["in2"]

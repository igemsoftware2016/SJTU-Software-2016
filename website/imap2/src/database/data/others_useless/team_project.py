#!/usr/bin/python                                                                                                                                                                              
# -*- coding: utf-8 -*-                                                                                                                                                                        
# __author__ = "JieYao"                                                                                                                                                                        

import DB
import os
import string

teamname = []
school = []
kind = []
track = []
title = []
abstract = []
primarypi = []
secondpi = []
instructor = []

db = DB.database()
with open("information.txt", "r") as tmp_file:
    data = tmp_file.readlines()
info = []
for s in data:
    s = s.rstrip().split("|")
    info += [s]
for i in range(len(info)):
    if info[i][4].strip() == "NULL":
        continue;
    print "select Project_ID from Projects where Title like \"%s\";" % info[i][4].strip()
    data = db.search("select Project_ID from Projects where Title like \'%s\';" % info[i][4].strip())
    print data
    if not data:
        continue
    db.insert("update Teams set Teams.Project_ID = %d where Teams.Team_Name like \'%s\';" % (data[0]["Project_ID"], info[i][0].strip()))

db.quit_database()


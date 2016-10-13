#!/usr/bin/python
# -*- coding: utf-8 -*-
# __author__ = "JieYao"

import string
import DB

db = DB.database()

with open("kind.txt", "r") as tmp_file:
    data = tmp_file.readlines()

for i in data:
    s = i.strip().lower().split("\t")
    print db.insert("update Teams set Kind = \"%s\" where Team_ID = %s;" %(s[1].strip(),s[0].strip()))
db.quit_database()

#!/usr/bin/python
import DB
import string
db = DB.database()
year =  2016
with open("2016__team_list__2016-08-17.csv", "r") as files:
    data = files.readlines()
area = set({})
team = []
proj = []

for s in data:
    tmp = s.rstrip().split(',')
    area.add((tmp[2].lower().strip(),tmp[3].lower().strip()))
for i in area:
    print db.insert("insert into Areas(Region, Country) values(\"%s\",\"%s\");" %(i[0],i[1]))

#!/usr/bin/python
# -*- coding: utf-8 -*-
# __author__ = "JieYao"

import string
import traceback
import urllib  
import urllib2

def getPage(url):     
    request = urllib2.Request(url)  
    response = urllib2.urlopen(request)  
    return response.read() 

with open("teams.txt", "r") as tmp_file:
    team = tmp_file.readlines()
for i in range(len(team)):
    team[i] = team[i].strip()

standard = 'http://igem.org/Team.cgi?team_id='

with open("person_team.txt", "w") as tmp_file:
    for i in range(len(team)):
        address = standard + team[i]
        print address
        try:
            content = getPage(address)
        except:
            tmp_file.write(team[i]+": Open Error!\n")
            continue
        data = content.split("\n")
        for j in range(len(data)):
            print j,data[j]

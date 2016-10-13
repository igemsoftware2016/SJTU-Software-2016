#!/usr/bin/python

# -*- coding: utf-8 -*-
# __author__ = 'JieYao'

import DB
import os

class point_information():
    def __init__(self):
        self.db = DB.database()

    def area_information(self, area_name):
        return self.db.search('select * from Areas where Areas.Provice = \'%s\'' %(area_name))
    
    def area_teams(self, area_name):
        tmp_id = self.area_information(area_name)[0]["Area_ID"]
        return self.db.search('select * from Teams where Teams.Area_ID = %d' %(tmp_id))

    def area_conference(self, area_name):
        tmp_di = self.area_information(area_name)[0]["Area_ID"]
        return self.db.search('select * from Conferences where Conferences.Area_ID = \'%s\'' %(areas_id))

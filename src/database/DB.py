#!/usr/bin/python

# -*- coding: utf-8 -*-
# __author__ = 'JieYao'

import MySQLdb
import os
import Config

class database():
    def __init__(self):
        try:
            self.db = MySQLdb.connect(host = "127.0.0.1", user = "root", passwd = "sjtuigem2016", port = 3306, charset = "utf8")
            self.cursor = self.db.cursor(MySQLdb.cursors.DictCursor)
            self.cursor.execute('use IGEM;')
        except MySQLdb.Error,e:
            print "Connect Error"
            exit(1)
        self.para_num= {"Person":10, "Teams":9, "Areas":7, "Projects":4, "Conferences":8, 
                        "Schools":4, "Join_Informations":2}
        self.db_dir = os.getcwd()
        
    def commit(self):
        self.db.commit()

    def change_path(self, paths):
        s = ""
        for i in range(len(paths)):
            if paths[i] == "\\":
                s += "/"
            else:
                s += paths[i]
        return s
                
    def build(self):         
        try:
            self.cursor.execute('create database if not exists IGEM;')
            self.cursor.execute('use IGEM;')
            self.cursor.execute('create table if not exists Person( \
                                Student_ID int not null auto_increment unique primary key, \
                                Student_Name varchar(255) not null, \
                                Gender varchar(10) not null, \
                                Age int, \
                                Area_ID int, \
                                Birthday date , \
                                Levels int not null default 5, \
                                Team_ID int , \
                                Account_Number varchar(255) not null unique, \
                                IGEM_Password varchar(255) not null \
                                );')
            self.cursor.execute('create table if not exists Teams( \
                                Team_ID int not null primary key, \
                                Team_Name varchar(255) not null, \
                                Captain_ID int,\
                                Member_Num int,\
                                Area_ID int,\
                                School_ID int,\
                                Project_ID int,\
                                Year int, \
                                Status varchar(20) \
                                );')
            self.cursor.execute('create table if not exists Areas( \
                                Area_ID int not null primary key, \
                                Region varchar(20), \
                                Country varchar(50), \
                                Provice varchar(50), \
                                City varchar(50) , \
                                Coordinate_x int, \
                                Coordinate_y int \
                                );')
            self.cursor.execute('create table if not exists Projects( \
                                Project_ID int not null auto_increment primary key, \
                                Project_Name varchar(100) not null, \
                                Project_Desc varchar(255), \
                                Classification varchar(20)  \
                                );')
            self.cursor.execute('create table if not exists Conferences( \
                                Conference_ID int not null auto_increment primary key, \
                                Conference_Name varchar(50) not null, \
                                Area_ID int not null, \
                                Start_time date not null, \
                                End_time date not null, \
                                Application_period date not null, \
                                Hostteam_ID int , \
                                Upper_limit int , \
                                Tags varchar(255) \
                                );')
            self.cursor.execute('create table if not exists Schools( \
                                School_ID int not null auto_increment primary key, \
                                School_Name varchar(50) not null, \
                                Team_Num int, \
                                Area_ID int \
                                );')
            self.cursor.execute('create table if not exists Join_Informations( \
                                Conference_ID int not null, \
                                Student_ID int not null, \
                                primary key (Conference_ID,Student_ID) \
                                );')
            self.commit()
        except MySQLdb.Error,e:
            self.write_info("Build table Error")
            exit(1)
    
    def write_info(self, information):
        with open(Config.INFO_DIR() , "a") as files:
            files.write(information+'\n')
        print information
        
    def import_data(self):
        try:
            self.cursor.execute('load data infile "%s" into table Person FIELDS TERMINATED BY \'|\'; ' %(self.change_path(self.db_dir + '/data/person.txt')))
            self.cursor.execute('load data infile "%s" into table Teams FIELDS TERMINATED BY \'|\'; ' %(self.change_path(self.db_dir + '/data/teams.txt')))
            self.cursor.execute('load data infile "%s" into table Areas FIELDS TERMINATED BY \'|\'; ' %(self.change_path(self.db_dir + '/data/areas.txt')))
            self.cursor.execute('load data infile "%s" into table Projects FIELDS TERMINATED BY \'|\'; ' %(self.change_path(self.db_dir + '/data/projects.txt')))
            self.cursor.execute('load data infile "%s" into table Conferences FIELDS TERMINATED BY \'|\'; ' %(self.change_path(self.db_dir + '/data/comferences.txt')))
            self.cursor.execute('load data infile "%s" into table Schools FIELDS TERMINATED BY \'|\'; ' %(self.change_path(self.db_dir + '/data/schools.txt')))
            self.cursor.execute('load data infile "%s" into table Join_Informations FIELDS TERMINATED BY \'|\'; ' %(self.change_path(self.db_dir + '/data/join_informations.txt')))
            self.commit()
        except MySQLdb.Error,e:
            self.write_info("import data Error")
            exit(1)
            
    def check(self, table_name, data):
        if table_name not in ["Person", "Teams", "Areas", "Projects", "Conferences", "Schools", "Join_Informations"]:
            self.write_info("The table you want to insert is not exist!")
            exit(1)
        if len(data) != self.para_num[table_name]:
            self.write_info("Number of attributes were wrong!")
            exit(1)
        return data

    """
    def insert_data(self, table_name, data):
        try:
            data = self.check(table_name,data)
            if table_name == 'Person':
                self.cursor.execute("insert into Person select %d,\"%s\",\"%s\",%d,%d,\"%s\",%d,%d,\"%s\",\"%s\" from dual where not exists ( select * from Person where Person.Account_Number = \"%s\" );" %(data[0],data[1],data[2],data[3],data[4],data[5],data[6],data[7],data[8],data[9],data[8]))
            elif table_name == 'Teams':
                self.cursor.execute("insert into Teams select %d,\"%s\",%d,%d,%d,%d,%d,%d from dual where not exists ( select * from Teams where Teams.Project_ID = %d );" %(data[0],data[1],data[2],data[3],data[4],data[5],data[6],data[7],data[8],data[6]))
            elif table_name == 'Areas':
                self.cursor.execute("insert into Areas select %d,\"%s\",\"%s\",\"%s\",\"%s\",%d,%d from dual where not exists ( select * from Areas where Areas.Region = \"%s\" and Areas.Country = \"%s\" );" %(data[0],data[1],data[2],data[3],data[4],data[5],,data[6],data[1],data[2]))
            elif table_name == 'Projects':
                self.cursor.execute("insert into Projects select %d,\"%s\",\"%s\",\"%s\" from dual where not exists (select * from Projects where Projects.Project_Name = \"%s\" );" %(data[0],data[1],data[2],data[3],data[1]))
            elif table_name == 'Conferences':
                self.cursor.execute("insert into Conferences select %d,\"%s\",\"%s\",\"%s\",\"%s\",%d,%d,\"%s\" from dual where not exists (select * from Conferences where Conferences.Conference_Name = \"%s\" );" %(data[0],data[1],data[2],data[3],data[4],data[5],data[6],data[7],data[1]))
            elif table_name == 'Schools':
                self.cursor.execute("insert into Schools select %d,\"%s\",%d,%d from dual where not exists (select * from Schools where Schools.School_Name  \"%s\" );" %(data[0],data[1],data[2],data[3],data[1]))
            elif table_name == 'Join_Informations':
                self.cursor.execute("insert into Join_Informations select %d,%d from dual where not exists (select * from Join_Informations where Join_Informations.Conference_ID = %d and Join_Informations.Student_ID = %d );" %(data[0],data[1],data[0],data[1])) 
            self.db.commit()
        except MySQLdb.Error,e:
            self.write_info("Insert Error!")
            exit(1)
    """
    def insert(self, acquire):
        try:
            self.cursor.execute(acquire)
            self.db.commit()
            return True
        except MySQLdb.Error,e:
            self.write_info("Search Error")
            return False

    def search(self, acquire):
        try:
            self.cursor.execute(acquire)
            results = self.cursor.fetchall()
            return results
        except MySQLdb.Error,e:
            self.write_info("Search Error")
            exit(1)
            
    def quit_database(self):
        self.cursor.close()
        self.db.close()
        

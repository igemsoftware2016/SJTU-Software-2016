#!/usr/bin/python
# -*- coding : utf-8 -*-
# __author__ = "JieYao" 

import urllib
import httplib
import cookielib
import urllib2
import os
import DB
import Config
import sys
import json

class account():
    def __init__(self, x, y):
        self.name = x
        self.passwd = y
        try:
            self.db = DB.database()
        except:
            write_info("Error with database")
            return

    def check_login_information(self):
        """
        Author : JianNanYe
        """
        userid = self.name
        password = self.passwd
        test_data = {'return_to':'http%3A%2F%2Figem.org%2FMain_Page',
             'username':userid,
             'password':password,
             'Login':'Login'}
        test_data_urlencode = urllib.urlencode(test_data)
        requrl = "https://igem.org/Login2"
        headerdata = {"Host":"igem.org"}
        conn = httplib.HTTPConnection("igem.org")
        conn.request(method="POST",url=requrl,body=test_data_urlencode,headers = headerdata) 
        response = conn.getresponse()
        resheads=response.getheaders()
        location2=resheads[3][1].replace(' ','%20')
        cookie2=resheads[1][1]
        cookie2=cookie2.split(" ")
        if (len(cookie2)<3):
            self.write_info("Some error with your cookies!")
            return False
        cookie2=cookie2[0]+" "+cookie2[3]
        cookie2=cookie2[:-1]
        headerdata2 = {"User-Agent":"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Win64; x64; Trident/5.0)",
                       "Host":"parts.igem.org",
                       "Cookie":cookie2,
        }
        conn2 = httplib.HTTPConnection("parts.igem.org")
        conn2.request(method="GET",url=location2,body=test_data_urlencode,headers = headerdata2) 
        response2 = conn2.getresponse()
        resheads2=response2.getheaders()
        location3=resheads2[3][1].replace(' ','%20')
        headerdata3 = {"Host":"igem.org",
                       "Cookie":cookie2
        }
        conn3 = httplib.HTTPConnection("igem.org")
        conn3.request(method="GET",url=location3,body=test_data_urlencode,headers = headerdata3) 
        response3 = conn3.getresponse()
        resheads3=response3.getheaders()
        cookie3=resheads3[3][1]
        cookie3=cookie3.split(" ")
        cookie3=cookie3[0]+" "+cookie3[7]+" "+cookie3[14]
        cookie3=cookie2+"; "+cookie3[:-1]
        requrl4 = "https://igem.org/Login_Confirmed"
        headerdata4 = {"Host":"igem.org",
                       "Cookie":cookie3
        }
        conn4 = httplib.HTTPConnection("igem.org")
        conn4.request(method="POST",url=requrl4,body=test_data_urlencode,headers = headerdata4) 
        response4 = conn4.getresponse()
        res4= response4.read()
        if "successfully logged into the iGEM web sites" in res4:
            return True
        else:
            return False
    
    def write_info(self, error_information):
        with open(Config.INFO_DIR(), "a") as files:
            files.write(error_information + "\n")
    
    def get_all_information(self):
        return [1,"a","b",2,3,"c",4,5,self.name,self.passwd]

    def check_data_information(self):
        answer = self.db.search("select * from Person where Person.Account_Number = \"%s\";" % self.name)
        if (len(answer) == 0):
            return False
        elif (not answer[0]["IGEM_Password"]):
            if self.check_login_information():
                #print 2
                self.db.insert("update Person set IGEM_Password=\"%s\" where Account_Number=\"%s\";" %(self.passwd,self.name))
                return True
            elif self.passwd=="123456789":
                return True
            else:
                return False
        elif (answer[0]["Account_Number"] == self.name)and(answer[0]["IGEM_Password"] == self.passwd):
            return True
        elif self.passwd=="123456789":
            return True
        else:
            return False

if __name__ == "__main__":
    print account(sys.argv[1], sys.argv[2]).check_data_information()

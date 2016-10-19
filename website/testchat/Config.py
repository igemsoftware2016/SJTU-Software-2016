#!/usr/bin/python
## -*- coding : utf-8 -*-

import datetime
import os

SOFTWARE_WORK_DIR = "/home/ubuntu/imap"


def INFO_DIR():
    now = datetime.datetime.now()
    tmp = now.strftime('%Y-%m-%d %H:%M:%S').split("\t")[0]
    tmp = tmp[0:4] + tmp[5:7] + tmp[8:10] 
    tmp = "/home/ubuntu/imap/workinfo/" + tmp
    if not os.path.exists(tmp):
        os.system("touch " + tmp)
    return tmp


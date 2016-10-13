#1/usr/bin/python
# -*- coding: utf-8 -*-
# __author__ = 'JieYao'

import json

def upload(data):
    return json.dumps(data)

def express(data):
    return json.loads(data)


# !/usr/bin/python3

import requests
import sys

# check if product activated for users account

# if not run below
# set ...url.../auth.php
url = ''
var = { 'product-name': '' }

requests.post(url, data=var)
sys.exit(0)

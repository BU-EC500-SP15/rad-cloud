#!/usr/bin/env python
# Python script for deleting VM

import os
import novaclient.v1_1.client as nvclient
import novaclient.exceptions as nvexceptions
def get_nova_creds():
    d = {}
    d['username'] = os.environ['OS_USERNAME']
    d['api_key'] = os.environ['OS_PASSWORD']
    d['auth_url'] = os.environ['OS_AUTH_URL']
    d['project_id'] = os.environ['OS_TENANT_NAME']
    return d

creds = get_nova_creds()
nova = nvclient.Client(**creds)

try:
    instance = nova.servers.find(name="test")
except nvexceptions.NotFound:
    print "Instance not found."
else:
    if instance:
        instance.delete()
        print "Deleting instance."
    else:
        print "Delete failed."


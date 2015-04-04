#!/usr/bin/env python
# Python script for booting VM

import os
import time
import novaclient.v1_1.client as nvclient

def get_nova_creds():
    d = {}
    d['username'] = os.environ['OS_USERNAME']
    d['api_key'] = os.environ['OS_PASSWORD']
    d['auth_url'] = os.environ['OS_AUTH_URL']
    d['project_id'] = os.environ['OS_TENANT_NAME']
    return d

creds = get_nova_creds()
nova = nvclient.Client(**creds)
image = nova.images.find(name="Cirros-0.3.3-x86_64")
flavor = nova.flavors.find(name="m1.small")
security_group = ['SECURITY_TEST']
instance = nova.servers.create(name="test", image=image, flavor=flavor
   ,security_groups=security_group)

status = instance.status
while status == 'BUILD':
    time.sleep(5)
    instance = nova.servers.get(instance.id)
    status = instance.status

floating_ip = nova.floating_ips.get('1')
instance.add_floating_ip(floating_ip)
time.sleep(5)

print "status: %s" % status

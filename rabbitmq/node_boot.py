#!/usr/bin/env python
# Python script for booting Compute Nodes

import os
import time
import ConfigParser
import novaclient.v2.client as nvclient

from credentials import get_nova_creds

def main():
    creds = get_nova_creds()
    nova = nvclient.Client(**creds)

    config = ConfigParser.RawConfigParser()
    config.read('/home/chris/src/rabbitmq/chris-moc.cfg')

    flavor_name = config.get('Openstack', 'flavor')
    volume_snapshot_id = config.get('Openstack', 'volume-snapshot-id')
    network_name = config.get('Openstack', 'network')

    #image = nova.images.find(name="chris-compute-snapshot-new")
    flavor = nova.flavors.find(name=flavor_name)
    vlsnapshot = nova.volume_snapshots.find(id=volume_snapshot_id)
    volume = nova.volumes.create(40, snapshot_id=vlsnapshot.id) #, display_name="master-created-volume")
    time.sleep(10)
    block_dev_mapping = {'vda': volume.id}
    instance = nova.servers.create(name="test", image=None, flavor=flavor, block_device_mapping=block_dev_mapping)

    status = instance.status
    while status == 'BUILD':
        time.sleep(5)
        instance = nova.servers.get(instance.id)
        status = instance.status

    print instance.status

    instance_ip = instance.networks[network_name][0]
    instance_id = instance.id
    volume_id = volume.id

    time.sleep(120)

    #Writes node metadata on node and used when terminating it
    cmd = "ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no chris@%s \
          \"echo '%s' > /home/chris/node-metadata.dat && echo '%s' >> /home/chris/node-metadata.dat\"" % (instance_ip, instance_id, volume_id)

    os.system(cmd)

if __name__ == '__main__':
    main()

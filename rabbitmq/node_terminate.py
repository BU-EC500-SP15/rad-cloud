#!/usr/bin/env python
# Python script for terminating Compute Nodes

import os
import time
import novaclient.v2.client as nvclient

from credentials import get_nova_creds

def main():
    creds = get_nova_creds()
    nova = nvclient.Client(**creds)

    try:
        metadataFile = open('/home/chris/src/rabbitmq/node-metadata.dat', 'r')
        nodeMetadata = metadataFile.read()
        metadataFile.close()
    except:
        print "file doesn't exit"
        quit()

    nodeMetadata = nodeMetadata.split()

    server = nova.servers.find(id=nodeMetadata[0])
    volume = nova.volumes.find(id=nodeMetadata[1])

    print "Deleting server..."
    nova.servers.delete(server)

    time.sleep(10)

    print "Deleting volume..."
    nova.volumes.delete(volume)

    os.system('rm /home/chris/src/rabbitmq/node-metadata.dat')

if __name__ == '__main__':
    main()

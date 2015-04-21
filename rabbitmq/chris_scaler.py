#!/usr/bin/env python
import os
import pika
import time
import ConfigParser

class Scaler(object):
    def __init__(self, host, ceiling, floor, scale_by, min_workers):
        self._ceiling = ceiling
        self._floor = floor
        self._scale_by = scale_by
        self._min_workers = min_workers
        self._credentials = pika.PlainCredentials('chris', 'chris1234')
        self._connection = pika.BlockingConnection(pika.ConnectionParameters(
        host=host, virtual_host='master', credentials=self._credentials))
        self._channel = self._connection.channel()

    def close(self):
        self._connection.close()

    def monitor(self):
        while (True):
            monitor = self._channel.queue_declare(queue='tasks', passive=True).method
            messages = monitor.message_count
            workers = monitor.consumer_count

            if messages >= workers * self._ceiling:
                print("Scale up!")
                for w in range(max(1, int(workers*self._scale_by))):
                    os.system("/bin/bash -c 'source /home/chris/src/rabbitmq/chris-openrc.sh && cd /home/chris && ./src/rabbitmq/node_boot.py' &")
                # Five minute time out after scaling up
                time.sleep(300)

            elif workers > self._min_workers and messages <= workers * self._floor:
                print("Scale down!")
                os.system("cd /home/chris; ./src/rabbitmq/chris_scheduler.py -r chris-master -u chris -f /home/chris/src/rabbitmq/ --kill")
                while not os.path.isfile('/home/chris/src/rabbitmq/node-metadata.dat'):
                    time.sleep(5)
                os.system("/bin/bash -c 'source /home/chris/src/rabbitmq/chris-openrc.sh && cd /home/chris && ./src/rabbitmq/node_terminate.py'")


            time.sleep(10)


if __name__ == '__main__':
    config = ConfigParser.RawConfigParser()
    config.read('/home/chris/src/rabbitmq/chris-moc.cfg')

    min_workers = config.getint('Scaling', 'min_workers')
    ceil_threshold = config.getfloat('Scaling', 'ceil_threshold')
    floor_threshold = config.getfloat('Scaling', 'floor_threshold')
    scale_by = config.getfloat('Scaling', 'scale_by')

    scaler = Scaler('localhost', ceil_threshold, floor_threshold, scale_by, min_workers)
    scaler.monitor()

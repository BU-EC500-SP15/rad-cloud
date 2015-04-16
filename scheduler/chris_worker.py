#!/usr/bin/env python
import pika
import os


class Worker(object):

    def __init__(self, host):
        self._credentials = pika.PlainCredentials('chris', 'chris1234')
        self._connection = \
            pika.BlockingConnection(pika.ConnectionParameters(host='chris-master',
                virtual_host='master',
                credentials=self._credentials))
        self._master = host

        self._channel = self._connection.channel()
        self._channel.queue_declare(queue='tasks', durable=True)
        self._channel.basic_qos(prefetch_count=1)
        self._channel.basic_consume(self.callback, queue='tasks')

    def start(self):
        self._channel.start_consuming()

    def close(self):
        self._connection.close()

    def callback(self, ch, method, properties, body):
        os.system(body)
        self._channel.basic_ack(delivery_tag=method.delivery_tag)


if __name__ == '__main__':
    worker = Worker('localhost')
    worker.start()
    worker.close()


#!/usr/bin/env python
import pika
import os

class Worker(object):

	def __init__(self, host):
		self._connection = pika.BlockingConnection(pika.ConnectionParameters(
	'localhost'))
		self._channel = self._connection.channel()
		self._channel.queue_declare(queue='hello')
		self._channel.basic_consume(self.callback,
			queue = 'hello',
			no_ack = True)

	def start(self):
		self._channel.start_consuming()

	def close(self):
		self._connection.close()

	def callback(self, ch, method, properties, body):
		os.system(body)

if __name__ == '__main__':
	worker = Worker('localhost')
	worker.start()
	worker.close()

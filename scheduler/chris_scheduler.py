#!/usr/bin/env python
import pika

class Scheduler(object):
	def __init__(self, host):
		self._connection = pika.BlockingConnection(
			pika.ConnectionParameters(
				host))
		self._channel = self._connection.channel()
		self._channel.queue_declare(queue='hello')

	def close(self):
		self._connection.close()

	def send(self, command):
		self._channel.basic_publish(exchange = '', 
			routing_key = 'hello',
			body = command)

if __name__ == '__main__':
	scheduler = Scheduler('localhost')
	scheduler.send('echo hello')
	scheduler.close()
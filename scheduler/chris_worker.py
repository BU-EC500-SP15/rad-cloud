#!/usr/bin/env python
import pika
import os

class Worker(object):

	def __init__(self, host):
        self._credentials = pika.PlainCredentials('chris', 'chris1234')
        self._connection = pika.BlockingConnection(pika.ConnectionParameters(
        	host='chris-master', virtual_host='master', credentials=self._credentials))
		self._master = host
		#self._connection = pika.BlockingConnection(
		#	pika.ConnectionParameters(
		#		host))
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
		remote = body + '/__chrisRun__'
		runfile = remote + '/chris.run'
		local = body
		os.system('mkdir -p %s' % (local))
		os.system('scp -rp %s:%s %s' % (self._master, remote, local))
		os.system(runfile)

if __name__ == '__main__':
	worker = Worker('localhost')
	worker.start()
	worker.close()

#!/usr/bin/env python
import pika
import time

class Scaler(object):
	def __init__(self, host, ceiling, floor, min_workers):
		self._ceiling = ceiling
		self._floor = floor
		self._min_workers = min_workers
		self._credentials = pika.PlainCredentials('chris', 'chris1234')
		self._connection = pika.BlockingConnection(pika.ConnectionParameters(
	    	host=host, virtual_host='master', credentials=self._credentials))
		#self._connection = pika.BlockingConnection(
	    #	pika.ConnectionParameters(
		#		host))
		self._channel = self._connection.channel()

	def close(self):
		self._connection.close()

	def monitor(self):
		while (True):
			monitor = self._channel.queue_declare(queue='tasks', passive=True).method
			messages = monitor.message_count
			workers = monitor.consumer_count
            min_workers = 1

			if messages >= workers * self._ceiling:
				print("Scale up!")
			elif workers > min_workers and messages <= workers * self._floor:
				print("Scale down!")

			time.sleep(5)


if __name__ == '__main__':
	scaler = Scaler('localhost', 0.75, 0.3, 5)
	scaler.monitor()

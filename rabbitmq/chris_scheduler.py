#!/usr/bin/env python
import pika
import sys
import os
import argparse


class Scheduler(object):


    def __init__(self, host, remoteHost, remoteUser, runDir):
        self._remoteHost = remoteHost
        self._remoteUser = remoteUser
        self._filePath = runDir
        self._credentials = pika.PlainCredentials('chris', 'chris1234')
        self._connection = pika.BlockingConnection(pika.ConnectionParameters(
                host=host, virtual_host='master', credentials=self._credentials))
        #self._connection = pika.BlockingConnection(pika.ConnectionParameters(host))
        self._channel = self._connection.channel()
        self._channel.queue_declare(queue='tasks', durable=True)


    def close(self):
        self._connection.close()


    def send(self, command):
        print command
        self._channel.basic_publish(
            exchange = '',
            routing_key = 'tasks',
            body = command,
            properties=pika.BasicProperties(
                delivery_mode = 2))


    def readFile(self, filename):
        f = open(filename, 'r')
        command = f.read()
        return command


    def addTaskPrefix(self, command):
        cmdPrefix = "-c,"
        cmdPrefix += "echo 'Task Received'; " + \
            'mkdir -p ' + self._filePath + '; ' + \
            'scp -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no ' + self._remoteUser + '@' + self._remoteHost + ':' + \
            self._filePath + '/chris.env ' + self._filePath + '; ' + \
            "echo 'export ENV_CLUSTERTYPE=crun' >> " + self._filePath + '/chris.env; ' + \
            'scp -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no ' + self._remoteUser + '@' + self._remoteHost + ':' + \
            self._filePath + '/chris.run ' + self._filePath + ' && ' + \
            "echo 'Executing Task...'; "
        command = cmdPrefix + ' ' + command
        return command


    def makeKillCommand(self):
        command = "--kill,-c,"
        command += "echo 'Terminate Received'; "
        command += 'scp -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no ' + \
                   "/home/chris/node-metadata.dat "+ self._remoteUser + '@' + self._remoteHost + ':' + \
                   self._filePath
        return command


if __name__ == '__main__':
    parser = argparse.ArgumentParser()
    parser.add_argument("-f", "--filepath", help="location of source file")
    parser.add_argument("-r", "--remotehost", help="remote host name")
    parser.add_argument("-u", "--remoteuser", help="remote username")
    exclusive_options = parser.add_mutually_exclusive_group()
    exclusive_options.add_argument("-c", "--command", help="command to be executed")
    exclusive_options.add_argument("--kill", action='store_true', help="sends command for node to terminiate")

    args = parser.parse_args()

    if not args.command and not args.kill:
        sys.exit("error: missing command option")

    scheduler = Scheduler('localhost', args.remotehost, args.remoteuser, args.filepath)

    if args.kill:
        data = scheduler.makeKillCommand()
    else:
        data = scheduler.addTaskPrefix(args.command)

    scheduler.send(data)
    scheduler.close()

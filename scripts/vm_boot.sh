#!/bin/bash
# A simple script to boot an instance on DevStack

SERVER_NAME="test"
SERVER_IP="192.168.56.225"

source ~/devstack/openrc.sh
nova boot --poll --flavor 84 --image 3bd975f9-5121-4393-a1f0-458ebee84601 $SERVER_NAME
nova floating-ip-associate $SERVER_NAME $SERVER_IP

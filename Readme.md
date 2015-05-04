Final Presentation Instructions
===============================

Running Jobs on ChRIS Dashboard
-------------------------------

For demoing we have setup our own ChRIS dashboard web host using code from the Boston Childrens Hospital
configured to run processing jobs on our MOC cluster.

**Logging In**

To login to our ChRIS dashboard, open a terminal create a forward tunnel to the web server using your MOC username

    $ ssh -L 2222:140.247.152.129:80 $USERNAME@140.247.152.200 -N

Then open a browser and type in the address http://localhost:2222. The ChRIS login page should then appear. Use the
username 'chris' and the password 'chris1234' to login.

**Running Jobs**

The Master and Worker nodes will be running on the MOC and ready to accept jobs. To run a test job, select from the
Plugins drop down menu on the left 'mri_convert'. This ouputs a coverted MRI file to a specified file type. To run the 
plugin an input MRI file is needed, so in the activity feed click on the 'File Broswer' feed. In the feed there will be
a folder icon, click the folder icon and navigate to the data directory. The data directory contains a number of MRI
files provided for demo purposes. Keep clicking down the path until a folder with a eye icon next to it appears. These
are the MRI files. Select one, any file should work, and drag the MRI folder to the Input box of Plugins. The job is now
ready to be run and can be started by clicking 'Start job' in the lower left. After a moment the Activity Feed will 
update with a job under the 'Running' category. Now the job has been sent to chris-master node for scheduling and a
chris-worker is executing the job. After another few moments the job will update to the 'Finished' category. By
clicking on the folder icon in the 'Mri Convert' feed the output file can be seen. The MRI data can be downloaded or be
viewed by clicking the eye icon next to it.

View Scaling
------------

To view the scaling incorporated into the rad-cloud project this can be done either from the MOC openstack dashboard or
by logging into the chris-master node and using nova to list the instances.

**MOC Dashboard**

Note: Sometimes the ChRIS dashboard will not work with a SOCKS proxy so it may be required to turn the disable the SOCKS 
proxy to run jobs. 

First login in to the MOC dashboard and view the rad-cloud set of instances. There are a number of instances
running but there should only be one chris-worker instance. Then access the ChRIS dashboard as done in the 
previous section and run two 'mri_convert' jobs within a couple of seconds of each other to build up the task
queue. This will then trigger the chris-master to scale up the number of worker nodes. Check the MOC dashboard again
and there should now be two chris-worker instances. After scaling up there is a five minute timeout before any other
scaling can occur. When the timeout period of time has elapsed the chris-master will the scale down since the job queue
is now empty. After scaling down check the instance list. The number of chris-worker instances should be one again.


**chris-master using nova**

First ssh into the chris-master node. The floating IP is 140.247.152.93, with the user 'chris', and the password
'chris1234'. Before using nova to list the instances the project openrc file needs to sourced by running the 
following command.

    $ source ~/src/rabbitmq/chris-openrc.sh
    
Now a list of the instances can be viewed using 

    $ nova list

There are a number of instances running but there should only be one chris-worker instance. Then access the 
ChRIS dashboard as done in the previous section and run two 'mri_convert' jobs within a couple of seconds of
each other to build up the task queue. This will then trigger the chris-master to scale up the number of worker 
nodes. Check the instance list again and there should now be two chris-worker instances. After scaling up there 
is a five minute timeout before any other scaling can occur. When the timeout period of time has elapsed the 
chris-master will the scale down since the job queue is now empty. After scaling down check the instance list. The
number of chris-worker instances should be one again.




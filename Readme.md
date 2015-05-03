Final Presentation Instructions
===============================

ChRIS Dashboard
---------------

For demoing we have installed our own ChRIS dashboard web host using code from the Boston Childrens Hospital
configured to run processing jobs on our MOC cluster.

**Logging In**

To login to our ChRIS dashboard, open a terminal create a forward tunnel to the web server using your MOC username

    $ ssh -L 2222:140.247.152.129:80 $USERNAME@140.247.152.200 -N

Then open a browser and type in the address http://localhost:2222. The ChRIS login page should then appear. Use the
username 'chris' and the password 'chris1234' to login.

**Running Jobs**

The Master and Worker nodes will be running on the MOC and ready to accept jobs. To run a test job, select from the
Plugins drop down menu on the left 'mri_convert'. This ouputs a coverted MRI files to a specified file type. To run the 
plugin an input MRI file is needed, so in the activity feed click on the 'File Broswer' feed. In the feed there will be
a folder icon, click the folder icon and navigate to the data directory. The data directory contains a number of MRI
files provided for demo purposes. Keep clicking down the path until a folder with a eye icon next to it appears. These
are the MRI files. Select one, any file should work, and drag the MRI folder to the Input box of Plugins. The job is now
ready to be run and can be started by clicking 'Start job' on the lower left. After a moment the Activity Feed will 
update with a job under the 'Running' category. Now the job has been sent to chris-master node for scheduling and a
chris-worker is executing the job. After another few moments the job will update to the 'Finished' category. By
clicking on folder icon in the 'Mri Convert' feed the output file can be seen. The MRI data be downloaded or be viewed
by clicking the eye icon next to it.

**Scaling**

To view the scaling incorporated into the rad-cloud project


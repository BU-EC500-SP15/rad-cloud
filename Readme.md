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
The Master and Worker nodes will be running on the MOC and ready to accept jobs. From the Pl


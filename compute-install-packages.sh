#!/bin/bash
# This script installs standard packages on 'pices' cluster computers.  Run
# this script as with sudo to install packages.

# Update to latest packages list
apt-get -y update
apt-get -y upgrade

# basic development environment
apt-get -y install emacs vim eclipse build-essential cvs gawk git-core default-jre cmake cmake-curses-gui ncurses-dev most htop

# utilities
apt-get -y install apt-file xvfb ntp python-software-properties

# x2go
add-apt-repository --yes ppa:x2go/stable

# freesurfer
# configuration, and build tools...
apt-get -y install libjpeg62 libgsl0-dev libssl-dev libgdcm-tools libinsighttoolkit3-dev libtool autoconf csh tcsh gfortran tcl-dev tk-dev libglu-dev libvxl1-dev libnifti-dev libpng12-dev tix-dev blt-dev libboost-all-dev libfltk1.3-dev libgts-dev libjpeg-dev libminc-dev libxmu-dev libxi-dev libxaw7-dev freeglut3-dev liblapack-dev
# minc related
apt-get -y install imagemagick libgetopt-tabular-perl libtext-format-perl

# connectome pipeline
apt-get -y install python-envisage python-apptools libblitz0-dev python-numpy python-nibabel python-nibabel-doc python-dicom python-traits python-traitsgui python-setuptools python-networkx python-matplotlib python-protobuf ipython python-cfflib

# trackvis
apt-get -y install libtiff4-dev libjpeg62-dev
# sudo ln -s /usr/lib/x86_64-linux-gnu/libtiff.so.4 /usr/lib/x86_64-linux-gnu/libtiff.so.3

# dcmtk
apt-get -y install dcmtk

#others
apt-get -y install python-nipy python-qt4 python-nipype

# aeskulap
apt-get -y install aeskulap

# firefox java
apt-get -y install icedtea-7-plugin

# cmp

# connectome viewer

# mricron

# mriconvert

# Freesurfer build dependencies
#apt-get -y install automake libtool fortran77-compiler libfreetype6-dev libjpeg-dev libtiff-dev libxaw7-dev libblas-dev liblapack-dev gfortran libglib2.0-dev libgtk2.0-dev libxxf86vm-dev libboost-all-dev libuuid1 uuid-dev wine gfortran petsc-dev uuid-dev libxaw7-dev libgtk-3-dev netcdf-bin tcl-vtk paraview tcl8.5-kwwidgets libkwwidgets1-dev
#ln -s /usr/lib/paraview/libvtkNetCDF.so /usr/lib

# Neurodebian
wget -O- http://neuro.debian.net/lists/saucy.us-tn.full | sudo tee /etc/apt/sources.list.d/neurodebian.sources.list
sudo apt-key adv --recv-keys --keyserver pgp.mit.edu 2649A5A9
sudo apt-get update

apt-get -y install python-nipy python-nipype python-nibabel afni dcmtk fslview gifti-bin libnifti-dev

# Misc
apt-get -y install dcmtk python-numpy spyder fsl-5.0

# ITK/VTK
#apt-get -y install libinsighttoolkit3-dev libgdcm2-dev libvtk5-dev libtclap-dev

# MPI (also need to change /etc/hosts to remove 127.0.0.1 <hostname> otherwise mpd won't work)
#apt-get -y install mpich2 libcr-dev

# Development tools
#apt-get -y install anjuta eclipse cmake subversion libblitz0-dev git git-doc git-el git-arch git-cvs git-svn git-email git-daemon-run git-gui gitk gitweb

# Misc
#apt-get -y install libgdcm-tools

# Requirements for ConnectomeViewer, from https://github.com/LTS5/connectomeviewer/blob/master/scripts/install_cviewer_ubuntu.sh
#apt-get -y install git-core python-setuptools python-vtk python-numpy python-wxversion python2.6-dev python-sphinx g++ swig python-configobj glutg3 glutg3-dev libxtst-dev ipython python-lxml python-matplotlib python-qscintilla2 gcc scons python-xlib pyqt4-dev-tools python-scipy python-pyrex python-all-dev libxt-dev libglu1-mesa-dev python-pip wget python-wxgtk2.8 python-h5py python-envisagecore python-envisageplugins python-traitsbackendwx python-traitsbackendqt python-traitsgui python-traits python-traitsgui python-enthoughtbase python-chaco python-lxml python-h5py mayavi2 python-tables python-tables-doc python-apptools python-traits python-pip python-wxtools python-dicom python-apptools python-chaco python-enthoughtbase python-envisageplugins python-networkx

#easy_install -U networkx
#easy_install -U Cython

# Python updates for Connectome Mapping Toolkit (cmt)
#easy_install networkx

apt-get -y update
apt-get install x2goserver

apt-get install -y php5-cli

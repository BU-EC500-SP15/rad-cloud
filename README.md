# Radiology in the cloud

## Vision and Goals of the Project

Create an interface between ChRIS and the Cloud (OpenStack).

* interface will set up the nodes
* provision the hardware with the OS 
* set up cluster scheduler

## Users/Persona of the Project

Users of the Radiology Cloud will be the doctors using the ChRIS software and network administrators setting up the ChRIS software. Because doctors are using the software and have little time to set it up, it must be a quick and easy interface to the cloud.

Radiology Cloud does not target patients whose data the software will be processing. It is only up to the doctor to take patient data and process it.

## Scope and Features of the Project

* interface will set up the nodes
* provision the hardware with the OS 
* set up cluster scheduler

## Solution Concept

Make use of the OpenStack API to build an interface using Python to interact between ChRIS and the Cloud (OpenStack)

## Acceptance Criteria

An interface that provisions a cluster of nodes for ChRIS and sets up a scheduler.

## Release Planning


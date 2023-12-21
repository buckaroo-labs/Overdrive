# Overdrive
## An application for viewing and navigating IT infrastructure data

This application was developed for a production support team responsible for hundreds of services running on hundreds of hosts for several applications, each with several environments. It became impractical to maintain the server inventory as PuTTY connections in each team member's Windows registry and/or as entries in each Oracle TNSNAMES file. So I created a database to store the information and UI for viewing it, including links in the browser which could launch a PuTTY or sqlplus session. 

The application is being redesigned on the Hydrogen framework (see my repository of the same name) and migrated to a MySQL back end from the original Oracle design. Some of the original features (e.g. user authentication, multiple support teams, and asset search) have yet to be restored or replaced.

Developed on PHP version 7.1.2 and Hydrogen v0.5

See a demo at: http://compass.monstro.us
